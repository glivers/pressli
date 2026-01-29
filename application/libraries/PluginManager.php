<?php namespace Lib;

use Models\PluginModel;
use Lib\Plugin;

/**
 * Plugin Manager - Pressli CMS
 *
 * Central orchestrator for plugin discovery, lifecycle management, and runtime loading.
 * Bridges filesystem plugins directory with database registry and runtime plugin system.
 *
 * TWO DISTINCT USE CASES:
 *
 * 1. ADMIN CONTEXT (Manual Operations):
 *    Called from AdminPluginsController for user-initiated plugin management:
 *    - scan(): Discover new plugins, sync versions, mark missing ones inactive
 *    - activate($slug): Load plugin, run activate() hook, mark active in DB
 *    - deactivate($slug): Run deactivate() hook, mark inactive in DB
 *    - delete($slug, $deleteData): Optionally run uninstall() hook, remove from DB and filesystem
 *
 * 2. FRONTEND CONTEXT (Automatic Loading):
 *    Called from PageController constructor on every request:
 *    - load(): Auto-loads all active plugins, calls boot() to register content types/routes
 *
 * PLUGIN LIFECYCLE:
 *   Upload → scan() → Database entry created (inactive)
 *   → activate() → Plugin.activate() hook runs (migrations, setup)
 *   → load() runs on every request → Plugin.boot() registers content/routes
 *   → deactivate() → Plugin.deactivate() hook runs (cleanup, no data loss)
 *   → delete() → Plugin.uninstall() hook runs if deleteData=true (destructive)
 *   → Filesystem deletion → Database entry removed
 *
 * PLUGIN LOADING PROCESS:
 *   1. Query active plugins from database
 *   2. For each plugin slug: convert to PascalCase namespace
 *   3. Load plugin class file from plugins/{slug}/{Namespace}Plugin.php
 *   4. Instantiate plugin class
 *   5. Call boot() method to register content types and routes
 *   6. Cache instance in $loadedPlugins to prevent duplicate loading
 *
 * SLUG TO NAMESPACE CONVERSION:
 *   - 'jobs' → 'Jobs'
 *   - 'directory-listing' → 'DirectoryListing'
 *   Uses ucwords() with '-' delimiter to handle kebab-case plugin directory names
 *
 * DATABASE SYNC:
 *   scan() keeps plugins table synchronized with filesystem:
 *   - New directories with plugin.json → inserted as inactive
 *   - Version changes → updated in database
 *   - Missing directories → marked inactive (preserves settings)
 *
 * ERROR HANDLING:
 *   Methods return boolean success status. Missing files, invalid JSON,
 *   or non-existent classes fail gracefully by returning null/false.
 *
 * EXAMPLE USAGE:
 *
 *   // Admin: Discover and activate plugin
 *   PluginManager::scan();
 *   PluginManager::activate('jobs');
 *
 *   // Frontend: Auto-load active plugins (PageController constructor)
 *   PluginManager::load();
 *
 *   // Admin: Delete plugin with data cleanup
 *   PluginManager::delete('jobs', true);
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class PluginManager
{
    private static $loadedPlugins = [];
    private static $pluginsPath = 'plugins/';

    /**
     * Scan plugins directory and sync with database
     *
     * Discovers new plugins, updates existing ones, marks missing ones inactive
     *
     * @return array Scan results with counts
     */
    public static function scan()
    {
        $results = [
            'discovered' => 0,
            'updated' => 0,
            'removed' => 0
        ];

        $pluginsPath = self::$pluginsPath;
        $directories = glob($pluginsPath . '*', GLOB_ONLYDIR);

        if (!$directories) {
            return $results;
        }

        $foundSlugs = [];

        foreach ($directories as $dir) {
            $configPath = $dir . '/plugin.json';
            if (!file_exists($configPath)) {
                continue;
            }

            $config = json_decode(file_get_contents($configPath), true);
            if (!$config || !isset($config['slug'])) {
                continue;
            }

            $slug = $config['slug'];
            $foundSlugs[] = $slug;

            $existing = PluginModel::where('slug', $slug)->first();

            if (!$existing) {
                PluginModel::save([
                    'slug' => $slug,
                    'name' => $config['name'] ?? $slug,
                    'version' => $config['version'] ?? '1.0.0',
                    'description' => $config['description'] ?? null,
                    'author' => $config['author'] ?? null,
                    'author_uri' => $config['author_uri'] ?? null,
                    'status' => 'inactive',
                    'config' => json_encode($config)
                ]);
                $results['discovered']++;
            } else {
                $currentVersion = $existing['version'];
                $newVersion = $config['version'] ?? '1.0.0';

                if ($currentVersion !== $newVersion) {
                    PluginModel::where('slug', $slug)->save([
                        'version' => $newVersion,
                        'name' => $config['name'] ?? $slug,
                        'description' => $config['description'] ?? null,
                        'author' => $config['author'] ?? null,
                        'author_uri' => $config['author_uri'] ?? null,
                        'config' => json_encode($config)
                    ]);
                    $results['updated']++;
                }
            }
        }

        // Bulk update missing plugins to inactive
        $missingPlugins = PluginModel::whereNotIn('slug', $foundSlugs)->all();

        if (!empty($missingPlugins)) {
            $updates = [];
            foreach ($missingPlugins as $plugin) {
                $updates[] = [
                    'id' => $plugin['id'],
                    'status' => 'inactive'
                ];
            }
            PluginModel::save($updates, 'id');
            $results['removed'] = count($updates);
        }

        return $results;
    }

    /**
     * Load and boot all active plugins
     *
     * Called from PageController constructor on every request.
     * Queries database for active plugins, loads their classes, and calls boot()
     * to register content types and routes with ContentRegistry.
     *
     * @return void
     */
    public static function load()
    {
        $activePlugins = PluginModel::where('status', 'active')->all();

        foreach ($activePlugins as $pluginData) {
            self::loadPlugin($pluginData['slug']);
        }
    }

    /**
     * Load a specific plugin by slug
     *
     * PSR-4 REQUIREMENT: Directory names MUST be PascalCase to match namespaces.
     * Slug (database identifier) can be kebab-case for user-friendly URLs.
     *
     * Conversion examples:
     * - Slug: 'jobs' → Directory: 'Jobs/' → Namespace: 'Plugins\Jobs\JobsPlugin'
     * - Slug: 'directory-listing' → Directory: 'DirectoryListing/' → Namespace: 'Plugins\DirectoryListing\DirectoryListingPlugin'
     *
     * @param string $slug Plugin slug from database (lowercase/kebab-case)
     * @return Plugin|null Plugin instance or null if not found
     */
    public static function loadPlugin($slug)
    {
        if (isset(self::$loadedPlugins[$slug])) {
            return self::$loadedPlugins[$slug];
        }

        // Convert slug to PascalCase for PSR-4 directory and namespace
        // 'jobs' → 'Jobs', 'directory-listing' → 'DirectoryListing'
        $dirName = str_replace('-', '', ucwords($slug, '-'));

        $pluginPath = self::$pluginsPath . $dirName;
        $pluginFile = $pluginPath . '/' . $dirName . 'Plugin.php';

        if (!file_exists($pluginFile)) {
            return null;
        }

        require_once $pluginFile;

        $namespace = 'Plugins\\' . $dirName . '\\';
        $className = $namespace . $dirName . 'Plugin';

        if (!class_exists($className)) {
            return null;
        }

        $plugin = new $className($pluginPath);
        $plugin->boot();

        self::$loadedPlugins[$slug] = $plugin;

        return $plugin;
    }

    /**
     * Activate a plugin by slug
     *
     * Loads plugin, runs activate hook, marks as active in database
     *
     * @param string $slug Plugin slug
     * @return bool Success status
     */
    public static function activate($slug)
    {
        $plugin = PluginModel::where('slug', $slug)->first();
        if (!$plugin) {
            return false;
        }

        $pluginInstance = self::loadPlugin($slug);
        if (!$pluginInstance) {
            return false;
        }

        $pluginInstance->activate();

        PluginModel::where('slug', $slug)->save(['status' => 'active']);

        return true;
    }

    /**
     * Deactivate a plugin by slug
     *
     * Runs deactivate hook, marks as inactive in database
     *
     * @param string $slug Plugin slug
     * @return bool Success status
     */
    public static function deactivate($slug)
    {
        $plugin = PluginModel::where('slug', $slug)->first();
        if (!$plugin) {
            return false;
        }

        $pluginInstance = self::loadPlugin($slug);
        if ($pluginInstance) {
            $pluginInstance->deactivate();
        }

        PluginModel::where('slug', $slug)->save(['status' => 'inactive']);

        unset(self::$loadedPlugins[$slug]);

        return true;
    }

    /**
     * Delete a plugin
     *
     * Deactivates if active, optionally runs uninstall hook for data cleanup,
     * removes from database, deletes directory
     *
     * @param string $slug Plugin slug
     * @param bool $deleteData Whether to call uninstall() to delete plugin data
     * @return bool Success status
     */
    public static function delete($slug, $deleteData = false)
    {
        $plugin = PluginModel::where('slug', $slug)->first();
        if (!$plugin) {
            return false;
        }

        if ($plugin['status'] === 'active') {
            self::deactivate($slug);
        }

        if ($deleteData) {
            $pluginInstance = self::loadPlugin($slug);
            if ($pluginInstance) {
                $pluginInstance->uninstall();
            }
        }

        PluginModel::where('slug', $slug)->delete();

        // Convert slug to PascalCase directory name for deletion
        $dirName = str_replace('-', '', ucwords($slug, '-'));
        $pluginPath = self::$pluginsPath . $dirName;

        if (is_dir($pluginPath)) {
            self::deleteDirectory($pluginPath);
        }

        return true;
    }

    /**
     * Get all loaded plugin instances
     *
     * @return array Array of Plugin instances
     */
    public static function getLoaded()
    {
        return self::$loadedPlugins;
    }

    /**
     * Recursively delete a directory
     *
     * Uses array_diff to remove '.' and '..' from scandir results
     * before processing actual files and subdirectories.
     *
     * @param string $dir Directory path
     * @return bool Success status
     */
    private static function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return false;
        }

        // Get all entries except '.' and '..'
        $files = array_diff(scandir($dir), ['.', '..']);

        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            is_dir($path) ? self::deleteDirectory($path) : unlink($path);
        }

        return rmdir($dir);
    }
}

<?php namespace Lib;

use Models\PluginModel;
use Lib\Plugin;

/**
 * Plugin Manager - Pressli CMS
 *
 * Manages plugin lifecycle: scanning, loading, booting active plugins.
 * Auto-loads all active plugins on every request via bootstrap integration.
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
            $slug = basename($dir);
            $foundSlugs[] = $slug;

            $configPath = $dir . '/plugin.json';
            if (!file_exists($configPath)) {
                continue;
            }

            $config = json_decode(file_get_contents($configPath), true);
            if (!$config) {
                continue;
            }

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
     * Called during bootstrap to initialize plugins on every request
     *
     * @return void
     */
    public static function bootAll()
    {
        $activePlugins = PluginModel::where('status', 'active')->all();

        foreach ($activePlugins as $pluginData) {
            self::loadPlugin($pluginData['slug']);
        }
    }

    /**
     * Load a specific plugin by slug
     *
     * Converts slug to PascalCase for namespace resolution:
     * - 'jobs' → 'Jobs'
     * - 'directory-listing' → 'DirectoryListing'
     *
     * @param string $slug Plugin slug (directory name, kebab-case)
     * @return Plugin|null Plugin instance or null if not found
     */
    public static function loadPlugin($slug)
    {
        if (isset(self::$loadedPlugins[$slug])) {
            return self::$loadedPlugins[$slug];
        }

        // Convert slug to PascalCase for namespace
        // 'directory-listing' → 'DirectoryListing'
        $namespacePart = str_replace('-', '', ucwords($slug, '-'));

        $pluginPath = self::$pluginsPath . $slug;
        $pluginFile = $pluginPath . '/' . $namespacePart . 'Plugin.php';

        if (!file_exists($pluginFile)) {
            return null;
        }

        require_once $pluginFile;

        $namespace = 'Plugins\\' . $namespacePart . '\\';
        $className = $namespace . $namespacePart . 'Plugin';

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
     * Deactivates if active, removes from database, deletes directory
     *
     * @param string $slug Plugin slug
     * @return bool Success status
     */
    public static function delete($slug)
    {
        $plugin = PluginModel::where('slug', $slug)->first();
        if (!$plugin) {
            return false;
        }

        if ($plugin['status'] === 'active') {
            self::deactivate($slug);
        }

        PluginModel::where('slug', $slug)->delete();

        $pluginPath = self::$pluginsPath . $slug;
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

<?php namespace Lib;

/**
 * Base Plugin Class
 *
 * Abstract base class that all plugins must extend. Provides structure for plugin
 * initialization, lifecycle hooks, and system integration.
 *
 * Plugins extend CMS functionality by registering new content types, routes, providers,
 * and database tables. They should be self-contained and follow single responsibility.
 *
 * Responsibilities:
 * - Load plugin.json configuration
 * - Register content types with ContentRegistry
 * - Register data providers with ProviderRegistry
 * - Define routes for plugin functionality
 * - Handle activation/deactivation lifecycle
 *
 * Usage:
 *   class JobListingPlugin extends Plugin {
 *       public function boot() {
 *           ContentRegistry::register('job', [
 *               'model' => Models\JobModel::class,
 *               'controller' => Controllers\JobController::class,
 *               'routes' => ['index' => 'jobs', 'show' => 'jobs/{slug}']
 *           ]);
 *       }
 *   }
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 1.0.0
 */
abstract class Plugin
{
    /**
     * Plugin display name
     *
     * Human-readable name loaded from plugin.json 'name' field. Used in admin
     * interface for plugin management. Defaults to directory name if missing.
     *
     * @var string
     */
    protected $name;

    /**
     * Plugin version number
     *
     * Semantic version string loaded from plugin.json. Used for dependency checking
     * and compatibility verification. Defaults to '1.0.0' if missing.
     *
     * @var string
     */
    protected $version;

    /**
     * Complete plugin configuration from plugin.json
     *
     * Full parsed contents of plugin.json including metadata, content type definitions,
     * provider declarations, and dependency requirements.
     *
     * Structure:
     * [
     *     'name' => 'Job Listing Plugin',
     *     'version' => '2.0.0',
     *     'author' => 'Author Name',
     *     'description' => 'Plugin description',
     *     'requires' => ['php' => '^8.0'],
     *     'provides' => [
     *         'content_types' => ['job'],
     *         'data_providers' => ['similar_jobs', 'company_info']
     *     ]
     * ]
     *
     * @var array
     */
    protected $config;

    /**
     * Plugin directory path
     *
     * Absolute filesystem path to plugin's root directory. Used for loading
     * controllers, models, views, and migrations.
     *
     * @var string
     */
    protected $path;

    /**
     * Initialize plugin instance
     *
     * Automatically loads plugin.json configuration and populates name, version,
     * and path properties. Called when plugin is instantiated by PluginManager.
     */
    public function __construct()
    {
        $this->loadConfig();
    }

    /**
     * Boot the plugin
     *
     * Called when plugin is active and system is initializing. Use this to register
     * content types, routes, providers, and perform plugin setup. Do not run migrations here.
     *
     * Example:
     *   public function boot() {
     *       ContentRegistry::register('job', [
     *           'model' => Plugins\JobListing\Models\JobModel::class,
     *           'controller' => Plugins\JobListing\Controllers\JobController::class,
     *           'routes' => ['index' => 'jobs', 'show' => 'jobs/{slug}']
     *       ]);
     *
     *       ProviderRegistry::register('similar_jobs', function($context) {
     *           return JobModel::where('category', $context['job']['category'])->limit(5)->all();
     *       });
     *   }
     *
     * @return void
     */
    abstract public function boot();

    /**
     * Run on plugin activation
     *
     * Called once when plugin is activated in admin. Use this to run migrations,
     * create database tables, and set up initial data. Keep this idempotent.
     *
     * Example:
     *   public function activate() {
     *       $this->runMigrations();
     *       $this->createDefaultCategories();
     *   }
     *
     * @return void
     */
    public function activate()
    {
        // Override in child class if needed
    }

    /**
     * Run on plugin deactivation
     *
     * Called when plugin is deactivated in admin. Use this for cleanup tasks
     * but DO NOT drop tables or delete data (user might reactivate). Unregister hooks if needed.
     *
     * Example:
     *   public function deactivate() {
     *       Cache::delete('plugin_cache_key');
     *   }
     *
     * @return void
     */
    public function deactivate()
    {
        // Override in child class if needed
    }

    /**
     * Run on plugin uninstall/deletion
     *
     * Called when plugin is permanently deleted and user chose to delete plugin data.
     * Use this to clean up PostMetaModel data, custom tables, or any other plugin-specific data.
     * This is destructive and cannot be undone.
     *
     * Example:
     *   public function uninstall() {
     *       PostMetaModel::whereLike('meta_key', 'plugin_jobs:%')->delete();
     *       $this->dropTables();
     *   }
     *
     * @return void
     */
    public function uninstall()
    {
        // Override in child class if needed
    }

    /**
     * Load plugin.json configuration
     *
     * Reads plugin.json from plugin directory and stores in $this->config.
     * Sets $this->name, $this->version, and $this->path.
     *
     * @return void
     */
    protected function loadConfig()
    {
        $reflection = new \ReflectionClass($this);
        $this->path = dirname($reflection->getFileName());
        $configPath = $this->path . '/plugin.json';

        if (file_exists($configPath)) {
            $this->config = json_decode(file_get_contents($configPath), true);
            $this->name = $this->config['name'] ?? '';
            $this->version = $this->config['version'] ?? '1.0.0';
        } else {
            $this->config = [];
            $this->name = basename($this->path);
            $this->version = '1.0.0';
        }
    }

    /**
     * Register a data provider
     *
     * Registers a callable that provides data to templates. Provider will be
     * available to all templates via ProviderRegistry.
     *
     * Example:
     *   $this->registerProvider('similar_jobs', function($context) {
     *       $job = $context['job'];
     *       return JobModel::where('category', $job['category'])->limit(5)->all();
     *   });
     *
     * @param string $name Provider name
     * @param callable $callback Provider callable (receives $context, $options)
     * @return void
     */
    protected function registerProvider($name, $callback)
    {
        ProviderRegistry::register($name, $callback);
    }

    /**
     * Register a content type
     *
     * Registers a new content type with the system. Content type becomes available
     * for creation in admin and accessible via defined routes.
     *
     * Example:
     *   $this->registerContentType('job', [
     *       'label' => 'Job Listings',
     *       'model' => Plugins\JobListing\Models\JobModel::class,
     *       'controller' => Plugins\JobListing\Controllers\JobController::class,
     *       'routes' => ['index' => 'jobs', 'show' => 'jobs/{slug}']
     *   ]);
     *
     * @param string $name Content type identifier
     * @param array $config Content type configuration
     * @return void
     */
    protected function registerContentType($name, $config)
    {
        ContentRegistry::register($name, $config);
    }

    /**
     * Run plugin migrations
     *
     * Executes all PHP migration files in plugin's migrations directory.
     * Called during plugin activation to set up database tables.
     *
     * @return void
     */
    protected function runMigrations()
    {
        $migrationsDir = $this->path . '/migrations';

        if (is_dir($migrationsDir)) {
            $files = glob($migrationsDir . '/*.php');
            foreach ($files as $file) {
                require_once $file;
                // Migration files should execute on require
            }
        }
    }

    /**
     * Get plugin display name
     *
     * Returns the human-readable plugin name from plugin.json. Used in admin
     * interface for plugin management and display.
     *
     * @return string Plugin name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get plugin version number
     *
     * Returns semantic version string from plugin.json. Used for dependency
     * checking and displaying plugin information in admin.
     *
     * @return string Plugin version
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get complete plugin configuration
     *
     * Returns the full parsed plugin.json array including all metadata,
     * content type definitions, and dependency declarations.
     *
     * @return array Plugin configuration array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Get plugin directory path
     *
     * Returns the absolute filesystem path to the plugin's root directory.
     * Useful for loading additional resources or assets.
     *
     * @return string Absolute path to plugin directory
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get plugin slug
     *
     * Returns the plugin's directory name, which serves as its unique identifier.
     * This slug is used in plugin activation and management.
     *
     * @return string Plugin directory name (e.g., 'job-listing')
     */
    public function getSlug()
    {
        return basename($this->path);
    }

    /**
     * Get plugin metadata
     *
     * Returns array with plugin information for display in admin interface.
     * Includes name, version, author, description, and paths.
     *
     * @return array Plugin metadata
     */
    public function getMetadata()
    {
        return [
            'name' => $this->name,
            'version' => $this->version,
            'author' => $this->config['author'] ?? '',
            'description' => $this->config['description'] ?? '',
            'slug' => $this->getSlug(),
            'path' => $this->path,
            'provides' => $this->config['provides'] ?? []
        ];
    }
}

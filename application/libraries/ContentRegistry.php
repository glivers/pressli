<?php namespace Lib;

/**
 * Content Registry
 *
 * Central registry for all content types in the CMS. Content types can be core
 * types (posts, pages) or plugin-provided types (jobs, directories, events, etc.).
 *
 * Each registered content type defines:
 * - Model class and database table
 * - Controller and routes
 * - Data providers for template rendering
 * - Supported features (comments, thumbnails, categories, etc.)
 * - Custom fields and metadata
 * - Searchability configuration
 *
 * Usage:
 *   // Register a content type
 *   ContentRegistry::register('post', [
 *       'label' => 'Blog Posts',
 *       'model' => Models\PostModel::class,
 *       'controller' => Controllers\PostsController::class,
 *       'routes' => [
 *           'index' => 'blog',
 *           'show' => 'blog/{slug}'
 *       ],
 *       'searchable' => true,
 *       'supports' => ['title', 'editor', 'categories', 'tags']
 *   ]);
 *
 *   // Check if type exists
 *   if (ContentRegistry::has('job')) {
 *       $model = ContentRegistry::getModel('job');
 *   }
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 1.0.0
 */
class ContentRegistry
{
    /**
     * Registered content types storage
     *
     * Array structure:
     * [
     *     'post' => [
     *         'label' => 'Blog Posts',
     *         'table' => 'posts',
     *         'type_value' => 'post',
     *         'model' => 'Models\PostModel',
     *         'controller' => 'Controllers\PostsController',
     *         'routes' => ['index' => 'blog', 'show' => 'blog/{slug}'],
     *         'searchable' => true,
     *         'providers' => ['related_posts' => callable],
     *         'fields' => ['custom_field' => ['type' => 'text']],
     *         'supports' => ['title' => true, 'editor' => true, ...]
     *     ]
     * ]
     *
     * @var array
     */
    protected static $types = [];

    /**
     * Register a new content type
     *
     * Registers a content type with the system. Content types define how content
     * is stored, displayed, and managed. They can use shared tables (like posts)
     * or dedicated tables (like jobs).
     *
     * Required config keys:
     * - model: Model class name (e.g., Models\PostModel::class)
     *
     * Optional config keys:
     * - label: Human-readable name (default: ucfirst($typeName))
     * - table: Database table (default: 'posts')
     * - type_value: Value for 'type' column in shared tables (default: $typeName)
     * - controller: Controller class name
     * - routes: Array of route definitions ['action' => 'uri']
     * - searchable: Whether content appears in search (default: true)
     * - providers: Data providers for templates ['name' => callable]
     * - fields: Custom field definitions ['name' => config]
     * - supports: Feature flags ['feature' => bool]
     *
     * Example:
     *   ContentRegistry::register('job', [
     *       'label' => 'Job Listings',
     *       'table' => 'jobs',
     *       'model' => Plugins\JobListing\Models\JobModel::class,
     *       'controller' => Plugins\JobListing\Controllers\JobController::class,
     *       'routes' => [
     *           'index' => 'jobs',
     *           'category' => 'jobs/{category}',
     *           'show' => 'jobs/{category}/{slug}'
     *       ],
     *       'searchable' => true,
     *       'providers' => [
     *           'similar_jobs' => function($context) {
     *               return JobModel::where('category', $context['job']['category'])->limit(5)->all();
     *           }
     *       ],
     *       'supports' => [
     *           'title' => true,
     *           'editor' => true,
     *           'categories' => true
     *       ]
     *   ]);
     *
     * @param string $typeName Content type identifier (lowercase, alphanumeric with dashes)
     * @param array $config Configuration array
     * @return ContentRegistry Instance for method chaining
     * @throws \Exception If model not specified in config
     */
    public static function register($typeName, $config)
    {
        // Validate required fields
        if (!isset($config['model'])) {
            throw new \Exception("Content type '{$typeName}' must define a model");
        }

        // Set defaults
        $config = array_merge([
            'label' => ucfirst($typeName),
            'table' => 'posts',
            'type_value' => $typeName,
            'model' => null,
            'controller' => null,
            'routes' => [],
            'searchable' => true,
            'providers' => [],
            'fields' => [],
            'supports' => [
                'title' => true,
                'editor' => true,
                'author' => true,
                'thumbnail' => false,
                'excerpt' => false,
                'comments' => false,
                'revisions' => false,
                'categories' => false,
                'tags' => false,
            ]
        ], $config);

        // Store config
        self::$types[$typeName] = $config;

        // Auto-register providers with ProviderRegistry
        if (!empty($config['providers'])) {
            foreach ($config['providers'] as $name => $provider) {
                ProviderRegistry::register($name, $provider);
            }
        }

        return new static;
    }

    /**
     * Get content type configuration
     *
     * Retrieves the complete configuration array for a registered content type.
     *
     * Example:
     *   $config = ContentRegistry::get('post');
     *   echo $config['label'];  // "Blog Posts"
     *   echo $config['model'];  // "Models\PostModel"
     *
     * @param string $typeName Content type identifier
     * @return array|null Configuration array or null if not found
     */
    public static function get($typeName)
    {
        return self::$types[$typeName] ?? null;
    }

    /**
     * Get all registered content types
     *
     * Returns array of all content type configurations indexed by type name.
     *
     * Example:
     *   $types = ContentRegistry::all();
     *   foreach ($types as $name => $config) {
     *       echo $config['label'];
     *   }
     *
     * @return array All content type configurations ['type_name' => config]
     */
    public static function all()
    {
        return self::$types;
    }

    /**
     * Check if content type exists
     *
     * Example:
     *   if (ContentRegistry::has('job')) {
     *       // Job content type is registered
     *   }
     *
     * @param string $typeName Content type identifier
     * @return bool True if registered, false otherwise
     */
    public static function has($typeName)
    {
        return isset(self::$types[$typeName]);
    }

    /**
     * Get plugin routes for URL routing
     *
     * Returns flattened array of top-level routes to controller mappings.
     * Used by PageController to check if a URL segment should be handled by a plugin.
     *
     * Example:
     *   $routes = ContentRegistry::getRoutes();
     *   // Returns: ['jobs' => 'Plugins\Jobs\JobsController', 'vendors' => 'Plugins\Directory\VendorsController']
     *
     * Usage:
     *   $topLevel = explode('/', $slug)[0];
     *   if (isset($routes[$topLevel])) {
     *       $controller = $routes[$topLevel];
     *       // Delegate to plugin
     *   }
     *
     * @return array Route mappings ['route' => 'ControllerClass']
     */
    public static function getRoutes()
    {
        $routes = [];

        foreach (self::$types as $type => $config) {
            $route = $config['route'] ?? null;
            $controller = $config['controller'] ?? null;

            if ($route && $controller) {
                $routes[$route] = $controller;
            }
        }

        return $routes;
    }

    /**
     * Get providers for content type
     *
     * Returns data provider callables registered for this content type.
     * Providers supply data to theme templates.
     *
     * Example:
     *   $providers = ContentRegistry::getProviders('post');
     *   // Returns: ['related_posts' => callable, 'author_bio' => callable]
     *
     * @param string $typeName Content type identifier
     * @return array Provider definitions ['provider_name' => callable]
     */
    public static function getProviders($typeName)
    {
        return self::$types[$typeName]['providers'] ?? [];
    }

    /**
     * Get model class for content type
     *
     * Returns the fully-qualified model class name for database operations.
     *
     * Example:
     *   $modelClass = ContentRegistry::getModel('post');
     *   $posts = $modelClass::where('status', 'published')->all();
     *
     * @param string $typeName Content type identifier
     * @return string|null Model class name (e.g., 'Models\PostModel')
     */
    public static function getModel($typeName)
    {
        return self::$types[$typeName]['model'] ?? null;
    }

    /**
     * Check if content type is searchable
     *
     * Determines whether this content type should appear in search results.
     *
     * Example:
     *   if (ContentRegistry::isSearchable('post')) {
     *       // Include posts in search
     *   }
     *
     * @param string $typeName Content type identifier
     * @return bool True if searchable, false otherwise
     */
    public static function isSearchable($typeName)
    {
        return self::$types[$typeName]['searchable'] ?? false;
    }

    /**
     * Get controller class for content type
     *
     * Returns the fully-qualified controller class name.
     *
     * Example:
     *   $controller = ContentRegistry::getController('post');
     *   // Returns: 'Controllers\PostsController'
     *
     * @param string $typeName Content type identifier
     * @return string|null Controller class name
     */
    public static function getController($typeName)
    {
        return self::$types[$typeName]['controller'] ?? null;
    }

    /**
     * Get table name for content type
     *
     * Returns the database table where this content type's data is stored.
     * Multiple content types can share the same table (e.g., posts, pages both use 'posts').
     *
     * Example:
     *   $table = ContentRegistry::getTable('post');  // "posts"
     *   $table = ContentRegistry::getTable('page');  // "posts"
     *   $table = ContentRegistry::getTable('job');   // "jobs"
     *
     * @param string $typeName Content type identifier
     * @return string Table name (default: 'posts')
     */
    public static function getTable($typeName)
    {
        return self::$types[$typeName]['table'] ?? 'posts';
    }

    /**
     * Get type for database queries
     *
     * For content types that share a table (like posts/pages in 'posts' table),
     * this returns the value stored in the 'type' column to distinguish them.
     *
     * Example:
     *   $type = ContentRegistry::getType('post');  // "post"
     *   $posts = PostModel::where('type', $type)->all();
     *
     * @param string $typeName Content type identifier
     * @return string Type value for database (default: same as $typeName)
     */
    public static function getType($typeName)
    {
        return self::$types[$typeName]['type_value'] ?? $typeName;
    }

    /**
     * Get custom fields for content type
     *
     * Returns custom field definitions for the content type. Fields define
     * additional metadata beyond the standard columns.
     *
     * Example:
     *   $fields = ContentRegistry::getFields('job');
     *   // Returns: ['salary_range' => ['type' => 'text'], 'remote' => ['type' => 'checkbox']]
     *
     * @param string $typeName Content type identifier
     * @return array Custom field definitions ['field_name' => config]
     */
    public static function getFields($typeName)
    {
        return self::$types[$typeName]['fields'] ?? [];
    }

    /**
     * Get features for content type
     *
     * Returns array of feature flags indicating which features this content type supports.
     * Features include: title, editor, author, thumbnail, excerpt, comments, categories, tags, etc.
     *
     * Example:
     *   $features = ContentRegistry::getFeatures('post');
     *   // Returns: ['title' => true, 'editor' => true, 'categories' => true, ...]
     *
     * @param string $typeName Content type identifier
     * @return array Supported features ['feature' => bool]
     */
    public static function getFeatures($typeName)
    {
        return self::$types[$typeName]['supports'] ?? [];
    }

    /**
     * Check if content type supports a specific feature
     *
     * Checks whether this content type has a specific feature enabled.
     *
     * Example:
     *   if (ContentRegistry::supports('post', 'comments')) {
     *       // Show comment form
     *   }
     *
     *   if (ContentRegistry::supports('job', 'categories')) {
     *       // Show category dropdown in admin
     *   }
     *
     * @param string $typeName Content type identifier
     * @param string $feature Feature name (e.g., 'comments', 'thumbnail', 'categories')
     * @return bool True if feature is supported, false otherwise
     */
    public static function supports($typeName, $feature)
    {
        $features = self::getFeatures($typeName);
        return $features[$feature] ?? false;
    }

    /**
     * Unregister a content type
     *
     * Removes a content type from the registry. Used when plugins are deactivated.
     *
     * Example:
     *   ContentRegistry::unregister('job');
     *
     * @param string $typeName Content type identifier
     * @return void
     */
    public static function unregister($typeName)
    {
        unset(self::$types[$typeName]);
    }

    /**
     * Clear all registered content types
     *
     * Removes all content types from the registry. Useful for testing.
     *
     * Example:
     *   ContentRegistry::clear();
     *
     * @return void
     */
    public static function clear()
    {
        self::$types = [];
    }

    /**
     * Get all searchable content types
     *
     * Returns array of content type names that are marked as searchable.
     * Used when building search queries.
     *
     * Example:
     *   $searchable = ContentRegistry::getSearchable();
     *   // Returns: ['post', 'page', 'job']
     *
     * @return array Content type names that are searchable
     */
    public static function getSearchable()
    {
        return array_keys(array_filter(self::$types, function($config) {
            return $config['searchable'] ?? false;
        }));
    }

    /**
     * Get content types by table
     *
     * Returns array of content type names that use the specified database table.
     * Useful for finding all types that share the same table.
     *
     * Example:
     *   $types = ContentRegistry::getByTable('posts');
     *   // Returns: ['post', 'page']
     *
     * @param string $table Table name
     * @return array Content type names using this table
     */
    public static function getByTable($table)
    {
        return array_keys(array_filter(self::$types, function($config) use ($table) {
            return ($config['table'] ?? 'posts') === $table;
        }));
    }
}

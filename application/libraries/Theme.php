<?php namespace Lib;

use Rackage\Path;

/**
 * Base Theme Class
 *
 * Abstract base class that all themes must extend. Provides structure for theme
 * initialization, configuration loading, provider registration, and template resolution.
 *
 * Themes control presentation only - they declare what data they need via theme.json,
 * and the system provides it through ProviderRegistry. Themes should not contain
 * business logic or direct database queries.
 *
 * Responsibilities:
 * - Load theme.json configuration
 * - Register theme-specific data providers
 * - Resolve template file paths
 * - Declare data provider requirements per template
 *
 * Usage:
 *   class AuroraTheme extends Theme {
 *       public function boot() {
 *           // Register custom providers
 *           $this->registerProvider('featured_posts', function($context) {
 *               return PostModel::where('featured', 1)->limit(3)->all();
 *           });
 *       }
 *   }
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 1.0.0
 */
abstract class Theme
{
    /**
     * Theme display name
     *
     * Human-readable name loaded from theme.json 'name' field. Used in admin
     * interface for theme selection and display. Defaults to directory name if missing.
     *
     * @var string
     */
    protected $name;

    /**
     * Theme version number
     *
     * Semantic version string loaded from theme.json. Used for dependency checking
     * and update management. Defaults to '1.0.0' if missing.
     *
     * @var string
     */
    protected $version;

    /**
     * Complete theme configuration from theme.json
     *
     * Full parsed contents of theme.json including metadata, template definitions,
     * provider declarations, and dependency requirements.
     *
     * Structure:
     * [
     *     'name' => 'Aurora Theme',
     *     'version' => '1.0.0',
     *     'author' => 'Author Name',
     *     'description' => 'Theme description',
     *     'requires' => ['plugins' => ['plugin-name']],
     *     'templates' => [
     *         'post' => [
     *             'template' => 'templates/post.php',
     *             'data_providers' => ['related_posts', 'author_bio']
     *         ]
     *     ]
     * ]
     *
     * @var array
     */
    protected $config;

    /**
     * Theme directory path
     *
     * Absolute filesystem path to theme's root directory. Used for resolving
     * template files and loading additional resources.
     *
     * @var string
     */
    protected $path;

    /**
     * Initialize theme instance
     *
     * Automatically loads theme.json configuration and populates name, version,
     * and path properties. Called when theme is instantiated by ThemeManager.
     */
    public function __construct()
    {
        $this->loadConfig();
    }

    /**
     * Boot the theme
     *
     * Called when theme is activated or on every request if theme is active.
     * Use this method to:
     * - Register theme-specific data providers
     * - Perform any theme initialization
     *
     * Example:
     *   public function boot() {
     *       $this->registerProvider('popular_posts', function($context) {
     *           return PostModel::orderBy('views', 'desc')->limit(5)->all();
     *       });
     *   }
     *
     * @return void
     */
    abstract public function boot();

    /**
     * Load theme.json configuration
     *
     * Reads theme.json from theme directory and stores in $this->config.
     * Sets $this->name, $this->version, and $this->path.
     *
     * @return void
     */
    protected function loadConfig()
    {
        $reflection = new \ReflectionClass($this);
        $this->path = dirname($reflection->getFileName());
        $configPath = $this->path . '/theme.json';

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
     *   $this->registerProvider('recent_posts', function($context) {
     *       return PostModel::orderBy('created_at', 'desc')->limit(5)->all();
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
     * Get template file path
     *
     * Resolves template name to absolute file path. Checks theme.json for
     * custom template path, then falls back to templates/{name}.php.
     *
     * Example:
     *   $path = $theme->getTemplate('post');
     *   // Returns: /path/to/themes/aurora/templates/post.php
     *
     *   $path = $theme->getTemplate('custom', '/fallback/path.php');
     *   // Returns custom path or fallback if not found
     *
     * @param string $name Template name (e.g., 'post', 'page', 'home')
     * @param string|null $default Fallback path if template not found
     * @return string|null Template file path or null if not found
     */
    public function getTemplate($name, $default = null)
    {
        // Check theme.json for custom template path
        if (isset($this->config['templates'][$name]['template'])) {
            $template = $this->config['templates'][$name]['template'];
            $path = $this->path . '/' . $template;

            if (file_exists($path)) {
                return $path;
            }
        }

        // Default template location: templates/{name}.php
        $path = $this->path . '/templates/' . $name . '.php';
        return file_exists($path) ? $path : $default;
    }

    /**
     * Get data providers for a template
     *
     * Returns array of provider names that should be loaded for a template.
     * These are declared in theme.json under templates.{name}.data_providers.
     *
     * Example:
     *   $providers = $theme->getProviders('post');
     *   // Returns: ['related_posts', 'author_bio', 'popular_posts']
     *
     *   // Then in controller:
     *   $data = ProviderRegistry::getBatch($providers, ['post' => $post]);
     *
     * @param string $templateName Template name
     * @return array Provider names
     */
    public function getProviders($templateName)
    {
        return $this->config['templates'][$templateName]['data_providers'] ?? [];
    }

    /**
     * Get theme display name
     *
     * Returns the human-readable theme name from theme.json. Used in admin
     * interface for theme selection and management.
     *
     * @return string Theme name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get theme version number
     *
     * Returns semantic version string from theme.json. Used for dependency
     * checking and displaying theme information in admin.
     *
     * @return string Theme version
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get complete theme configuration
     *
     * Returns the full parsed theme.json array including all metadata,
     * template definitions, and dependency declarations.
     *
     * @return array Theme configuration array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Get theme directory path
     *
     * Returns the absolute filesystem path to the theme's root directory.
     * Useful for loading additional resources or assets.
     *
     * @return string Absolute path to theme directory
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get theme slug
     *
     * Returns the theme's directory name, which serves as its unique identifier.
     * This slug is used in URLs and for theme activation.
     *
     * @return string Theme directory name (e.g., 'aurora', 'magazine')
     */
    public function getSlug()
    {
        return basename($this->path);
    }

    /**
     * Check if template exists
     *
     * Verifies whether a template file can be resolved. Useful for checking
     * template availability before attempting to render.
     *
     * @param string $name Template name
     * @return bool True if template file exists
     */
    public function hasTemplate($name)
    {
        return $this->getTemplate($name) !== null;
    }

    /**
     * Get all available templates
     *
     * Returns array of template names defined in theme.json. Used for
     * inspecting theme capabilities and available layouts.
     *
     * @return array Template names
     */
    public function getTemplates()
    {
        return array_keys($this->config['templates'] ?? []);
    }

    /**
     * Get theme metadata
     *
     * Returns array with theme information for display in admin interface.
     * Includes name, version, author, description, screenshot, and paths.
     *
     * @return array Theme metadata
     */
    public function getMetadata()
    {
        return [
            'name' => $this->name,
            'version' => $this->version,
            'author' => $this->config['author'] ?? '',
            'description' => $this->config['description'] ?? '',
            'screenshot' => $this->config['screenshot'] ?? '',
            'slug' => $this->getSlug(),
            'path' => $this->path
        ];
    }
}

<?php namespace Lib;

/**
 * Theme Configuration Reader - Pressli CMS
 *
 * Reads and parses theme.json configuration files for active themes.
 * Provides access to theme metadata, template configurations, and data provider requirements.
 *
 * RESPONSIBILITIES:
 * - Load and parse theme.json from active theme directory
 * - Provide template-specific provider requirements
 * - Cache parsed configuration for performance
 * - Validate theme configuration structure
 *
 * USAGE:
 * $config = ThemeConfig::load('aurora');
 * $providers = $config->getProviders('post');  // Returns array of provider names
 * $template = $config->getTemplate('post');    // Returns template path
 *
 * CONFIGURATION STRUCTURE:
 * theme.json contains:
 * - name: Theme display name
 * - version: Semantic version
 * - templates: Template configurations with data_providers arrays
 * - settings: Theme-specific settings
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class ThemeConfig
{
    /**
     * Parsed theme configuration data
     *
     * Stores complete theme.json contents as associative array.
     * Includes all metadata, template configs, and settings.
     * Loaded once per request and cached in memory.
     *
     * @var array
     */
    protected $config;

    /**
     * Theme directory name
     *
     * Name of theme folder in themes/ directory.
     * Used to locate theme.json and template files.
     * Example: 'aurora', 'magazine', 'minimal'
     *
     * @var string
     */
    protected $themeName;

    /**
     * Absolute path to theme directory
     *
     * Full filesystem path to theme folder.
     * Used to construct paths to theme.json and assets.
     * Example: '/var/www/pressli/themes/aurora'
     *
     * @var string
     */
    protected $themePath;

    /**
     * Constructor - loads and parses theme.json
     *
     * Reads theme.json file from specified theme directory and parses JSON.
     * Validates configuration structure and sets defaults for missing keys.
     * Throws exception if theme.json doesn't exist or contains invalid JSON.
     *
     * @param string $themeName Name of theme directory (e.g., 'aurora')
     * @throws \Exception If theme.json not found or invalid JSON
     */
    public function __construct($themeName)
    {
        $this->themeName = $themeName;
        $this->themePath = realpath(__DIR__ . '/../../themes/' . $themeName);

        if (!$this->themePath) {
            throw new \Exception("Theme directory not found: {$themeName}");
        }

        $configPath = $this->themePath . '/theme.json';

        if (!file_exists($configPath)) {
            throw new \Exception("theme.json not found for theme: {$themeName}");
        }

        $json = file_get_contents($configPath);
        $this->config = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Invalid JSON in theme.json for theme: {$themeName}");
        }

        // Set defaults for missing keys
        $this->config['templates'] = $this->config['templates'] ?? [];
        $this->config['settings'] = $this->config['settings'] ?? [];
    }

    /**
     * Get data providers for specific template type
     *
     * Returns array of provider names that template requires.
     * Providers listed in theme.json under templates.{type}.data_providers.
     * Returns empty array if template type not configured.
     *
     * EXAMPLES:
     * - getProviders('post') → ['post_categories', 'recent_posts', 'popular_posts']
     * - getProviders('page') → ['recent_posts', 'categories']
     * - getProviders('unknown') → []
     *
     * @param string $templateType Template type (post, page, archive, etc.)
     * @return array Array of provider names (strings)
     */
    public function getProviders($templateType)
    {
        if (!isset($this->config['templates'][$templateType])) {
            return [];
        }

        return $this->config['templates'][$templateType]['data_providers'] ?? [];
    }

    /**
     * Get template file path for specific type
     *
     * Returns template filename from theme.json configuration.
     * Path is relative to theme directory (e.g., 'single.html', 'templates/post.php').
     * Returns null if template type not configured.
     *
     * @param string $templateType Template type (post, page, archive, etc.)
     * @return string|null Template path or null if not found
     */
    public function getTemplate($templateType)
    {
        if (!isset($this->config['templates'][$templateType])) {
            return null;
        }

        return $this->config['templates'][$templateType]['template'] ?? null;
    }

    /**
     * Get theme metadata
     *
     * Returns associative array with theme information:
     * - name: Theme display name
     * - version: Semantic version
     * - author: Author name
     * - description: Theme description
     *
     * @return array Theme metadata
     */
    public function getMeta()
    {
        return [
            'name' => $this->config['name'] ?? 'Unknown Theme',
            'version' => $this->config['version'] ?? '1.0.0',
            'author' => $this->config['author'] ?? 'Unknown',
            'description' => $this->config['description'] ?? '',
        ];
    }

    /**
     * Get theme setting value
     *
     * Returns specific setting from theme.json settings section.
     * Returns default value if setting doesn't exist.
     * Settings are theme-specific configuration options.
     *
     * @param string $key Setting key
     * @param mixed $default Default value if setting not found
     * @return mixed Setting value or default
     */
    public function getSetting($key, $default = null)
    {
        return $this->config['settings'][$key] ?? $default;
    }

    /**
     * Get all theme settings
     *
     * Returns complete settings array from theme.json.
     * Used to pass all theme settings to templates at once.
     * Returns empty array if no settings configured.
     *
     * @return array All theme settings
     */
    public function getSettings()
    {
        return $this->config['settings'] ?? [];
    }

    /**
     * Get menu locations defined by theme
     *
     * Returns associative array of location slugs to display names.
     * Example: ['primary' => 'Primary Navigation', 'footer' => 'Footer Menu']
     *
     * @return array Menu locations
     */
    public function getMenuLocations()
    {
        return $this->config['menu_locations'] ?? [];
    }

    /**
     * Get theme name
     *
     * Returns theme directory name used to instantiate this config.
     * Example: 'aurora', 'magazine', 'minimal'
     *
     * @return string Theme directory name
     */
    public function getName()
    {
        return $this->themeName;
    }

    /**
     * Get theme path
     *
     * Returns absolute filesystem path to theme directory.
     * Used to construct paths to templates and assets.
     *
     * @return string Absolute path to theme directory
     */
    public function getPath()
    {
        return $this->themePath;
    }

    /**
     * Static factory method to load theme config
     *
     * Creates and returns new ThemeConfig instance for specified theme.
     * Convenience method for one-line theme config loading.
     * Throws exception if theme not found or invalid.
     *
     * @param string $themeName Name of theme directory
     * @return ThemeConfig Configured instance
     * @throws \Exception If theme invalid
     */
    public static function load($themeName)
    {
        return new self($themeName);
    }
}

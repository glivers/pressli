<?php namespace Lib;

use Rackage\Registry;

/**
 * Theme Manager
 *
 * Manages theme loading, activation, and lifecycle. Loads active theme from
 * settings, instantiates theme class, validates dependencies, and boots theme
 * to register providers and initialize functionality.
 *
 * Responsibilities:
 * - Load active theme configuration
 * - Instantiate theme class
 * - Validate theme dependencies (required plugins, PHP version)
 * - Boot theme to register data providers
 * - Provide theme instance for template rendering
 *
 * Usage:
 *   $themeManager = new ThemeManager();
 *   $theme = $themeManager->getActiveTheme();
 *   $template = $theme->getTemplate('post');
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 1.0.0
 */
class ThemeManager
{
    /**
     * Active theme instance
     *
     * Singleton instance of the currently active theme. Loaded once during
     * initialization and reused throughout request lifecycle.
     *
     * @var Theme|null
     */
    protected $activeTheme;

    /**
     * Active theme name
     *
     * Directory name of the active theme from settings. Used to locate theme
     * files and instantiate theme class.
     *
     * @var string
     */
    protected $activeThemeName;

    /**
     * Themes base directory
     *
     * Absolute path to themes directory. All themes are subdirectories of this
     * path. Defaults to application root + 'themes/'.
     *
     * @var string
     */
    protected $themesPath;

    /**
     * Initialize theme manager
     *
     * Loads active theme name from settings and sets themes base directory.
     * Does not instantiate theme until getActiveTheme() is called to support
     * lazy loading.
     */
    public function __construct()
    {
        $settings = Registry::settings();
        $this->activeThemeName = $settings['active_theme'] ?? 'aurora';
        $this->themesPath = $settings['root'] . 'themes/';
    }

    /**
     * Get active theme instance
     *
     * Returns the currently active theme. Loads and boots theme on first call,
     * then returns cached instance on subsequent calls. Validates dependencies
     * before booting to ensure theme requirements are met.
     *
     * Example:
     *   $theme = $themeManager->getActiveTheme();
     *   $template = $theme->getTemplate('post');
     *   $providers = $theme->getProviders('post');
     *
     * @return Theme Active theme instance
     * @throws \Exception If theme class not found or dependencies not met
     */
    public function getActiveTheme()
    {
        if ($this->activeTheme !== null) {
            return $this->activeTheme;
        }

        $themePath = $this->themesPath . $this->activeThemeName;
        $themeClass = $this->getThemeClass($this->activeThemeName);

        if (!class_exists($themeClass)) {
            $classFile = $themePath . '/' . $this->getThemeClassName($this->activeThemeName) . '.php';
            if (file_exists($classFile)) {
                require_once $classFile;
            }
        }

        if (!class_exists($themeClass)) {
            throw new \Exception("Theme class '{$themeClass}' not found");
        }

        $this->activeTheme = new $themeClass();

        // Validate dependencies before booting
        $this->validateDependencies($this->activeTheme);

        // Boot theme to register providers and initialize
        $this->activeTheme->boot();

        return $this->activeTheme;
    }

    /**
     * Get theme class name from directory name
     *
     * Converts theme directory name to PSR-4 class name. Assumes theme class
     * matches directory name in PascalCase.
     *
     * Example:
     *   'aurora' → 'AuroraTheme'
     *   'magazine-pro' → 'MagazineProTheme'
     *
     * @param string $themeName Theme directory name
     * @return string Theme class name without namespace
     */
    protected function getThemeClassName($themeName)
    {
        // Convert kebab-case to PascalCase and append 'Theme'
        $parts = explode('-', $themeName);
        $className = implode('', array_map('ucfirst', $parts));
        return $className . 'Theme';
    }

    /**
     * Get fully qualified theme class name
     *
     * Returns namespaced class name for theme. Themes use Themes\{ThemeName}
     * namespace pattern for PSR-4 autoloading.
     *
     * Example:
     *   'aurora' → 'Themes\Aurora\AuroraTheme'
     *   'magazine-pro' → 'Themes\MagazinePro\MagazineProTheme'
     *
     * @param string $themeName Theme directory name
     * @return string Fully qualified class name
     */
    protected function getThemeClass($themeName)
    {
        $parts = explode('-', $themeName);
        $namespace = implode('', array_map('ucfirst', $parts));
        $className = $this->getThemeClassName($themeName);
        return "Themes\\{$namespace}\\{$className}";
    }

    /**
     * Validate theme dependencies
     *
     * Checks if theme requirements are met before booting. Validates PHP version,
     * required plugins, and Pressli version if specified in theme.json.
     *
     * Dependency format in theme.json:
     * {
     *   "requires": {
     *     "php": ">=7.4",
     *     "pressli": ">=1.0.0",
     *     "plugins": ["job-listing", "contact-form"]
     *   }
     * }
     *
     * @param Theme $theme Theme instance to validate
     * @return void
     * @throws \Exception If dependencies not met
     */
    protected function validateDependencies(Theme $theme)
    {
        $config = $theme->getConfig();

        if (empty($config['requires'])) {
            return;
        }

        $requires = $config['requires'];

        // Validate PHP version
        if (isset($requires['php'])) {
            $requiredPhp = $requires['php'];
            if (version_compare(PHP_VERSION, $requiredPhp, '<')) {
                throw new \Exception(
                    "Theme '{$theme->getName()}' requires PHP {$requiredPhp}, current version is " . PHP_VERSION
                );
            }
        }

        // Validate Pressli version
        if (isset($requires['pressli'])) {
            $settings = Registry::settings();
            $pressliVersion = $settings['version'] ?? '1.0.0';
            $requiredVersion = $requires['pressli'];

            if (version_compare($pressliVersion, $requiredVersion, '<')) {
                throw new \Exception(
                    "Theme '{$theme->getName()}' requires Pressli {$requiredVersion}, current version is {$pressliVersion}"
                );
            }
        }

        // Validate required plugins
        if (isset($requires['plugins']) && is_array($requires['plugins'])) {
            // TODO: Implement plugin validation when PluginManager is complete
            // For now, we'll skip this check
        }
    }

    /**
     * Get all available themes
     *
     * Scans themes directory and returns array of theme information. Each theme
     * must have a theme.json file to be recognized. Used in admin interface for
     * theme selection.
     *
     * Returns array format:
     * [
     *   'aurora' => [
     *     'name' => 'Aurora Theme',
     *     'version' => '1.0.0',
     *     'author' => 'Pressli Team',
     *     'description' => 'Modern responsive theme',
     *     'screenshot' => 'screenshot.png',
     *     'path' => '/full/path/to/themes/aurora'
     *   ]
     * ]
     *
     * @return array Available themes indexed by directory name
     */
    public function getAvailableThemes()
    {
        $themes = [];
        $directories = glob($this->themesPath . '*', GLOB_ONLYDIR);

        foreach ($directories as $dir) {
            $themeName = basename($dir);
            $configPath = $dir . '/theme.json';

            if (!file_exists($configPath)) {
                continue;
            }

            $config = json_decode(file_get_contents($configPath), true);

            $themes[$themeName] = [
                'name' => $config['name'] ?? ucfirst($themeName),
                'version' => $config['version'] ?? '1.0.0',
                'author' => $config['author'] ?? '',
                'description' => $config['description'] ?? '',
                'screenshot' => $config['screenshot'] ?? '',
                'path' => $dir
            ];
        }

        return $themes;
    }

    /**
     * Get active theme name
     *
     * Returns the directory name of the currently active theme. Used for
     * configuration and display purposes.
     *
     * @return string Active theme directory name
     */
    public function getActiveThemeName()
    {
        return $this->activeThemeName;
    }

    /**
     * Switch active theme
     *
     * Changes the active theme and reinitializes. Updates settings and boots
     * new theme. Used by admin interface for theme switching.
     *
     * Note: This does NOT persist to config file. Call this in conjunction
     * with updating settings file to make change permanent.
     *
     * @param string $themeName New theme directory name
     * @return void
     * @throws \Exception If theme not found or dependencies not met
     */
    public function switchTheme($themeName)
    {
        $themePath = $this->themesPath . $themeName;

        if (!is_dir($themePath)) {
            throw new \Exception("Theme '{$themeName}' not found");
        }

        $configPath = $themePath . '/theme.json';
        if (!file_exists($configPath)) {
            throw new \Exception("Theme '{$themeName}' is missing theme.json");
        }

        $this->activeThemeName = $themeName;
        $this->activeTheme = null; // Clear cached theme

        // Load and boot new theme
        $this->getActiveTheme();
    }
}

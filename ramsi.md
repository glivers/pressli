Yes! Let's create a complete implementation guide. This will be your roadmap.

---

# **Ramsi CMS - Complete Implementation Guide**

A modern, extensible CMS built on MVC principles with a robust plugin and theme system.

---

## **Table of Contents**

1. [Architecture Overview](#1-architecture-overview)
2. [Database Schema](#2-database-schema)
3. [Core System Components](#3-core-system-components)
4. [Plugin System](#4-plugin-system)
5. [Theme System](#5-theme-system)
6. [Routing & Content Resolution](#6-routing--content-resolution)
7. [Data Provider System](#7-data-provider-system)
8. [Asset Management](#8-asset-management)
9. [Example Implementations](#9-example-implementations)
10. [Implementation Checklist](#10-implementation-checklist)

---

## **1. Architecture Overview**

### **Core Principles**

1. **MVC Separation**: Controllers handle logic, Models handle data, Views handle presentation
2. **Content Type Registration**: All content types (posts, pages, jobs, etc.) register with the system
3. **Provider Pattern**: Themes declare data needs, system provides it
4. **Plugin Architecture**: Plugins extend functionality without touching core
5. **Theme System**: Themes control presentation, not logic

### **Directory Structure**

```
ramsi-cms/
├── application/
│   ├── controllers/
│   │   ├── PostController.php
│   │   ├── PageController.php
│   │   └── AdminController.php
│   ├── models/
│   │   ├── Post.php
│   │   ├── User.php
│   │   └── Category.php
│   ├── core/
│   │   ├── Theme.php              (Base theme class)
│   │   ├── Plugin.php             (Base plugin class)
│   │   ├── ContentTypeRegistry.php
│   │   ├── ProviderRegistry.php
│   │   ├── ThemeManager.php
│   │   ├── PluginManager.php
│   │   └── AssetManager.php
│   └── views/
│       └── admin/
├── plugins/
│   ├── job-listing/
│   │   ├── JobListingPlugin.php
│   │   ├── plugin.json
│   │   ├── controllers/
│   │   ├── models/
│   │   ├── migrations/
│   │   └── views/
│   └── saas-directory/
├── themes/
│   ├── default/
│   │   ├── DefaultTheme.php
│   │   ├── theme.json
│   │   └── templates/
│   └── magazine/
│       ├── MagazineTheme.php
│       ├── theme.json
│       ├── templates/
│       └── assets/
├── public/
│   ├── index.php
│   └── assets/
├── config/
│   ├── app.php
│   ├── database.php
│   └── routes.php
└── bootstrap.php
```

---

## **2. Database Schema**

### **Core Tables**

#### **posts** - Unified content table
```sql
CREATE TABLE posts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR(50) DEFAULT 'post',     -- 'post', 'page', or custom types
    slug VARCHAR(255) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    excerpt TEXT,
    
    -- Hierarchical (for pages)
    parent_id INT NULL,
    page_order INT DEFAULT 0,
    
    -- Publishing
    published_at DATETIME NULL,
    
    -- Common
    author_id INT NOT NULL,
    status VARCHAR(20) DEFAULT 'draft',  -- 'draft', 'published', 'archived'
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (author_id) REFERENCES users(id),
    FOREIGN KEY (parent_id) REFERENCES posts(id) ON DELETE SET NULL,
    
    INDEX idx_type_status (type, status),
    INDEX idx_slug (slug),
    INDEX idx_author (author_id),
    INDEX idx_published (published_at)
);
```

#### **postmeta** - Custom fields for posts table content
```sql
CREATE TABLE postmeta (
    id INT PRIMARY KEY AUTO_INCREMENT,
    post_id INT NOT NULL,
    meta_key VARCHAR(255) NOT NULL,
    meta_value TEXT,
    
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    INDEX idx_post_key (post_id, meta_key)
);
```

#### **users**
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    display_name VARCHAR(255),
    bio TEXT,
    avatar VARCHAR(255),
    role VARCHAR(50) DEFAULT 'subscriber',  -- 'admin', 'editor', 'author', 'subscriber'
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### **categories**
```sql
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    parent_id INT NULL,
    
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE CASCADE
);
```

#### **post_category** (many-to-many)
```sql
CREATE TABLE post_category (
    post_id INT NOT NULL,
    category_id INT NOT NULL,
    
    PRIMARY KEY (post_id, category_id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);
```

#### **tags**
```sql
CREATE TABLE tags (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL
);
```

#### **post_tag** (many-to-many)
```sql
CREATE TABLE post_tag (
    post_id INT NOT NULL,
    tag_id INT NOT NULL,
    
    PRIMARY KEY (post_id, tag_id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);
```

### **Plugin Tables**

Plugins create their own tables for complex content types.

#### **Example: jobs table** (created by job-listing plugin)
```sql
CREATE TABLE jobs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    slug VARCHAR(255) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    
    -- Job-specific fields
    company_id INT,
    salary_min INT NULL,
    salary_max INT NULL,
    currency VARCHAR(10) DEFAULT 'KES',
    location VARCHAR(255),
    remote_allowed BOOLEAN DEFAULT FALSE,
    employment_type VARCHAR(50),  -- 'full-time', 'part-time', 'contract'
    category VARCHAR(100),
    
    -- Common
    author_id INT NOT NULL,
    status VARCHAR(20) DEFAULT 'draft',
    published_at DATETIME NULL,
    expires_at DATETIME NULL,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (author_id) REFERENCES users(id),
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE SET NULL,
    
    INDEX idx_status (status),
    INDEX idx_category (category),
    INDEX idx_location (location),
    INDEX idx_published (published_at)
);
```

#### **companies** (for job listings)
```sql
CREATE TABLE companies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    logo VARCHAR(255),
    website VARCHAR(255),
    description TEXT,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## **3. Core System Components**

### **3.1 ContentTypeRegistry**

Manages all registered content types.

```php
// application/core/ContentTypeRegistry.php
<?php

class ContentTypeRegistry {
    protected $types = [];
    
    /**
     * Register a new content type
     */
    public function register($typeName, $config) {
        // Validate required fields
        if (!isset($config['routes'])) {
            throw new Exception("Content type '{$typeName}' must define routes");
        }
        
        // Set defaults
        $config = array_merge([
            'label' => ucfirst($typeName),
            'table' => 'posts',
            'type_value' => $typeName,
            'model' => Post::class,
            'searchable' => true,
            'providers' => [],
            'fields' => []
        ], $config);
        
        // Store config
        $this->types[$typeName] = $config;
        
        // Auto-register routes
        if (isset($config['controller'])) {
            foreach ($config['routes'] as $action => $uri) {
                $method = $config['methods'][$action] ?? 'get';
                Route::$method($uri, [$config['controller'], $action]);
            }
        }
        
        // Auto-register providers
        if (!empty($config['providers'])) {
            foreach ($config['providers'] as $name => $provider) {
                app('providers')->register($name, $provider);
            }
        }
        
        return $this;
    }
    
    public function get($typeName) {
        return $this->types[$typeName] ?? null;
    }
    
    public function all() {
        return $this->types;
    }
    
    public function has($typeName) {
        return isset($this->types[$typeName]);
    }
    
    public function getRoutes($typeName) {
        return $this->types[$typeName]['routes'] ?? [];
    }
    
    public function getProviders($typeName) {
        return $this->types[$typeName]['providers'] ?? [];
    }
    
    public function getModel($typeName) {
        return $this->types[$typeName]['model'] ?? Post::class;
    }
    
    public function isSearchable($typeName) {
        return $this->types[$typeName]['searchable'] ?? false;
    }
}
```

### **3.2 ProviderRegistry**

Manages data providers that themes can request.

```php
// application/core/ProviderRegistry.php
<?php

class ProviderRegistry {
    protected $providers = [];
    
    /**
     * Register a data provider
     */
    public function register($name, $callback) {
        if (!is_callable($callback)) {
            throw new Exception("Provider '{$name}' must be callable");
        }
        
        $this->providers[$name] = $callback;
        return $this;
    }
    
    /**
     * Get data from a provider
     */
    public function get($name, $context = [], $options = []) {
        if (!$this->has($name)) {
            throw new Exception("Provider '{$name}' not found");
        }
        
        return call_user_func($this->providers[$name], $context, $options);
    }
    
    public function has($name) {
        return isset($this->providers[$name]);
    }
    
    public function all() {
        return array_keys($this->providers);
    }
    
    /**
     * Get multiple providers at once
     */
    public function getBatch(array $names, $context = []) {
        $results = [];
        
        foreach ($names as $key => $value) {
            // Handle both 'provider_name' and 'provider_name' => ['options']
            if (is_numeric($key)) {
                $providerName = $value;
                $options = [];
            } else {
                $providerName = $key;
                $options = is_array($value) ? $value : [];
            }
            
            if ($this->has($providerName)) {
                $results[$providerName] = $this->get($providerName, $context, $options);
            }
        }
        
        return $results;
    }
}
```

### **3.3 Base Plugin Class**

```php
// application/core/Plugin.php
<?php

abstract class Plugin {
    protected $name;
    protected $version;
    protected $config;
    
    public function __construct() {
        $this->loadConfig();
    }
    
    /**
     * Boot the plugin - register routes, providers, etc.
     */
    abstract public function boot();
    
    /**
     * Run on plugin activation
     */
    public function activate() {
        // Override in child class if needed
    }
    
    /**
     * Run on plugin deactivation
     */
    public function deactivate() {
        // Override in child class if needed
    }
    
    /**
     * Load plugin.json config
     */
    protected function loadConfig() {
        $reflection = new ReflectionClass($this);
        $dir = dirname($reflection->getFileName());
        $configPath = $dir . '/plugin.json';
        
        if (file_exists($configPath)) {
            $this->config = json_decode(file_get_contents($configPath), true);
            $this->name = $this->config['name'] ?? '';
            $this->version = $this->config['version'] ?? '1.0.0';
        }
    }
    
    /**
     * Register a route
     */
    protected function registerRoute($method, $uri, $action) {
        Route::$method($uri, $action);
    }
    
    /**
     * Register a data provider
     */
    protected function registerProvider($name, $callback) {
        app('providers')->register($name, $callback);
    }
    
    /**
     * Register a content type
     */
    protected function registerContentType($name, $config) {
        app('content_types')->register($name, $config);
    }
    
    /**
     * Run migrations
     */
    protected function runMigrations() {
        $reflection = new ReflectionClass($this);
        $dir = dirname($reflection->getFileName());
        $migrationsDir = $dir . '/migrations';
        
        if (is_dir($migrationsDir)) {
            $files = glob($migrationsDir . '/*.php');
            foreach ($files as $file) {
                require_once $file;
                // Run migration (implement your migration logic)
            }
        }
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getVersion() {
        return $this->version;
    }
    
    public function getConfig() {
        return $this->config;
    }
}
```

### **3.4 Base Theme Class**

```php
// application/core/Theme.php
<?php

abstract class Theme {
    protected $name;
    protected $version;
    protected $config;
    
    public function __construct() {
        $this->loadConfig();
    }
    
    /**
     * Boot the theme - register providers, assets, etc.
     */
    abstract public function boot();
    
    /**
     * Load theme.json config
     */
    protected function loadConfig() {
        $reflection = new ReflectionClass($this);
        $dir = dirname($reflection->getFileName());
        $configPath = $dir . '/theme.json';
        
        if (file_exists($configPath)) {
            $this->config = json_decode(file_get_contents($configPath), true);
            $this->name = $this->config['name'] ?? '';
            $this->version = $this->config['version'] ?? '1.0.0';
        }
    }
    
    /**
     * Register a data provider
     */
    protected function registerProvider($name, $callback) {
        app('providers')->register($name, $callback);
    }
    
    /**
     * Register a stylesheet
     */
    protected function registerStyle($handle, $path, $options = []) {
        app('assets')->registerStyle($handle, $this->getAssetPath($path), $options);
    }
    
    /**
     * Register a script
     */
    protected function registerScript($handle, $path, $options = []) {
        app('assets')->registerScript($handle, $this->getAssetPath($path), $options);
    }
    
    /**
     * Get template path
     */
    public function getTemplate($name, $default = null) {
        $reflection = new ReflectionClass($this);
        $dir = dirname($reflection->getFileName());
        
        // Check theme.json for custom template path
        if (isset($this->config['templates'][$name]['template'])) {
            $template = $this->config['templates'][$name]['template'];
            $path = $dir . '/' . $template;
            
            if (file_exists($path)) {
                return $path;
            }
        }
        
        // Default template location
        $path = $dir . '/templates/' . $name . '.php';
        return file_exists($path) ? $path : $default;
    }
    
    /**
     * Get data providers for a template
     */
    public function getProviders($templateName) {
        return $this->config['templates'][$templateName]['data_providers'] ?? [];
    }
    
    /**
     * Get asset path
     */
    protected function getAssetPath($path) {
        // If already a full URL, return as-is
        if (preg_match('/^https?:\/\//', $path)) {
            return $path;
        }
        
        return '/themes/' . $this->getSlug() . '/' . $path;
    }
    
    /**
     * Get theme slug (directory name)
     */
    protected function getSlug() {
        $reflection = new ReflectionClass($this);
        $dir = dirname($reflection->getFileName());
        return basename($dir);
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getVersion() {
        return $this->version;
    }
    
    public function getConfig() {
        return $this->config;
    }
}
```

### **3.5 PluginManager**

```php
// application/core/PluginManager.php
<?php

class PluginManager {
    protected $plugins = [];
    protected $active = [];
    
    /**
     * Discover all plugins
     */
    public function discover() {
        $pluginDirs = glob(BASE_PATH . '/plugins/*', GLOB_ONLYDIR);
        
        foreach ($pluginDirs as $dir) {
            $slug = basename($dir);
            $pluginClass = $this->findPluginClass($dir, $slug);
            
            if ($pluginClass) {
                $this->plugins[$slug] = [
                    'class' => $pluginClass,
                    'path' => $dir,
                    'slug' => $slug
                ];
            }
        }
    }
    
    /**
     * Find plugin class in directory
     */
    protected function findPluginClass($dir, $slug) {
        // Convert slug to class name: job-listing -> JobListing
        $className = str_replace('-', '', ucwords($slug, '-')) . 'Plugin';
        
        // Check if class file exists
        $classFile = $dir . '/' . $className . '.php';
        
        if (file_exists($classFile)) {
            require_once $classFile;
            
            // Build full class name with namespace
            $fullClassName = "Plugins\\" . str_replace('-', '', ucwords($slug, '-')) . "\\" . $className;
            
            if (class_exists($fullClassName)) {
                return $fullClassName;
            }
        }
        
        return null;
    }
    
    /**
     * Boot all active plugins
     */
    public function bootAll() {
        $this->discover();
        
        // Get active plugins from config/database
        $activePlugins = $this->getActivePlugins();
        
        foreach ($activePlugins as $slug) {
            if (isset($this->plugins[$slug])) {
                $this->boot($slug);
            }
        }
    }
    
    /**
     * Boot a specific plugin
     */
    public function boot($slug) {
        if (!isset($this->plugins[$slug])) {
            throw new Exception("Plugin '{$slug}' not found");
        }
        
        $pluginClass = $this->plugins[$slug]['class'];
        $plugin = new $pluginClass();
        
        // Run boot method
        $plugin->boot();
        
        $this->active[$slug] = $plugin;
    }
    
    /**
     * Activate a plugin
     */
    public function activate($slug) {
        if (!isset($this->plugins[$slug])) {
            throw new Exception("Plugin '{$slug}' not found");
        }
        
        $pluginClass = $this->plugins[$slug]['class'];
        $plugin = new $pluginClass();
        
        // Run activation hook
        $plugin->activate();
        
        // Save to active plugins list
        $this->saveActivePlugin($slug);
        
        // Boot the plugin
        $this->boot($slug);
    }
    
    /**
     * Deactivate a plugin
     */
    public function deactivate($slug) {
        if (isset($this->active[$slug])) {
            $this->active[$slug]->deactivate();
            unset($this->active[$slug]);
        }
        
        // Remove from active plugins list
        $this->removeActivePlugin($slug);
    }
    
    /**
     * Get list of active plugins (from database/config)
     */
    protected function getActivePlugins() {
        // TODO: Load from database or config file
        // For now, return all discovered plugins
        return array_keys($this->plugins);
    }
    
    /**
     * Save plugin to active list
     */
    protected function saveActivePlugin($slug) {
        // TODO: Save to database or config file
    }
    
    /**
     * Remove plugin from active list
     */
    protected function removeActivePlugin($slug) {
        // TODO: Remove from database or config file
    }
    
    public function getAll() {
        return $this->plugins;
    }
    
    public function getActive() {
        return $this->active;
    }
    
    public function isActive($slug) {
        return isset($this->active[$slug]);
    }
}
```

### **3.6 ThemeManager**

```php
// application/core/ThemeManager.php
<?php

class ThemeManager {
    protected $themes = [];
    protected $activeTheme = null;
    protected $currentTemplate = null;
    
    /**
     * Discover all themes
     */
    public function discover() {
        $themeDirs = glob(BASE_PATH . '/themes/*', GLOB_ONLYDIR);
        
        foreach ($themeDirs as $dir) {
            $slug = basename($dir);
            $themeClass = $this->findThemeClass($dir, $slug);
            
            if ($themeClass) {
                $this->themes[$slug] = [
                    'class' => $themeClass,
                    'path' => $dir,
                    'slug' => $slug
                ];
            }
        }
    }
    
    /**
     * Find theme class in directory
     */
    protected function findThemeClass($dir, $slug) {
        // Convert slug to class name: job-board -> JobBoard
        $className = str_replace('-', '', ucwords($slug, '-')) . 'Theme';
        
        // Check if class file exists
        $classFile = $dir . '/' . $className . '.php';
        
        if (file_exists($classFile)) {
            require_once $classFile;
            
            // Build full class name with namespace
            $fullClassName = "Themes\\" . str_replace('-', '', ucwords($slug, '-')) . "\\" . $className;
            
            if (class_exists($fullClassName)) {
                return $fullClassName;
            }
        }
        
        return null;
    }
    
    /**
     * Boot the active theme
     */
    public function bootActive() {
        $this->discover();
        
        $activeSlug = $this->getActiveThemeSlug();
        
        if ($activeSlug && isset($this->themes[$activeSlug])) {
            $this->boot($activeSlug);
        }
    }
    
    /**
     * Boot a specific theme
     */
    public function boot($slug) {
        if (!isset($this->themes[$slug])) {
            throw new Exception("Theme '{$slug}' not found");
        }
        
        $themeClass = $this->themes[$slug]['class'];
        $theme = new $themeClass();
        
        // Validate dependencies
        $this->validateDependencies($theme);
        
        // Run boot method
        $theme->boot();
        
        $this->activeTheme = $theme;
    }
    
    /**
     * Validate theme dependencies
     */
    protected function validateDependencies($theme) {
        $config = $theme->getConfig();
        
        // Check required plugins
        if (isset($config['requires']['plugins'])) {
            foreach ($config['requires']['plugins'] as $requirement) {
                // Parse requirement: "job-listing-plugin@^2.0"
                [$pluginSlug, $version] = $this->parseRequirement($requirement);
                
                if (!app('plugins')->isActive($pluginSlug)) {
                    throw new Exception("Theme requires plugin: {$pluginSlug}");
                }
                
                // TODO: Check version compatibility
            }
        }
        
        // Check required providers
        if (isset($config['templates'])) {
            foreach ($config['templates'] as $templateName => $templateConfig) {
                if (isset($templateConfig['data_providers'])) {
                    foreach ($templateConfig['data_providers'] as $provider) {
                        if (!app('providers')->has($provider)) {
                            throw new Exception("Theme requires provider: {$provider}");
                        }
                    }
                }
            }
        }
    }
    
    /**
     * Parse version requirement
     */
    protected function parseRequirement($requirement) {
        if (strpos($requirement, '@') !== false) {
            return explode('@', $requirement, 2);
        }
        return [$requirement, '*'];
    }
    
    /**
     * Activate a theme
     */
    public function activate($slug) {
        if (!isset($this->themes[$slug])) {
            throw new Exception("Theme '{$slug}' not found");
        }
        
        // Boot to validate
        $this->boot($slug);
        
        // Save as active
        $this->saveActiveTheme($slug);
    }
    
    /**
     * Get active theme slug
     */
    protected function getActiveThemeSlug() {
        // TODO: Load from database or config
        return 'default';
    }
    
    /**
     * Save active theme
     */
    protected function saveActiveTheme($slug) {
        // TODO: Save to database or config
    }
    
    public function getActive() {
        return $this->activeTheme;
    }
    
    public function getAll() {
        return $this->themes;
    }
    
    public function setCurrentTemplate($name) {
        $this->currentTemplate = $name;
    }
    
    public function getCurrentTemplate() {
        return $this->currentTemplate;
    }
}
```

### **3.7 AssetManager**

```php
// application/core/AssetManager.php
<?php

class AssetManager {
    protected $styles = [];
    protected $scripts = [];
    
    /**
     * Register a stylesheet
     */
    public function registerStyle($handle, $path, $options = []) {
        $this->styles[$handle] = array_merge([
            'path' => $path,
            'version' => '1.0',
            'position' => 'head',
            'dependencies' => [],
            'only' => []
        ], $options);
    }
    
    /**
     * Register a script
     */
    public function registerScript($handle, $path, $options = []) {
        $this->scripts[$handle] = array_merge([
            'path' => $path,
            'version' => '1.0',
            'position' => 'footer',
            'dependencies' => [],
            'only' => []
        ], $options);
    }
    
    /**
     * Render styles
     */
    public function renderStyles() {
        $output = '';
        
        foreach ($this->styles as $handle => $asset) {
            if ($this->shouldLoad($asset)) {
                $url = $asset['path'];
                $version = $asset['version'];
                $output .= "<link rel=\"stylesheet\" href=\"{$url}?v={$version}\">\n";
            }
        }
        
        return $output;
    }
    
    /**
     * Render scripts
     */
    public function renderScripts($position = 'footer') {
        $output = '';
        
        // Sort by dependencies
        $sorted = $this->sortByDependencies($this->scripts);
        
        foreach ($sorted as $handle => $asset) {
            if ($asset['position'] === $position && $this->shouldLoad($asset)) {
                $url = $asset['path'];
                $version = $asset['version'];
                $output .= "<script src=\"{$url}?v={$version}\"></script>\n";
            }
        }
        
        return $output;
    }
    
    /**
     * Check if asset should load
     */
    protected function shouldLoad($asset) {
        // Check template restriction
        if (!empty($asset['only'])) {
            $currentTemplate = app('theme')->getCurrentTemplate();
            return in_array($currentTemplate, $asset['only']);
        }
        
        return true;
    }
    
    /**
     * Sort assets by dependencies
     */
    protected function sortByDependencies($assets) {
        // Simple implementation - TODO: proper topological sort
        return $assets;
    }
}
```

---

## **4. Plugin System**

### **4.1 Plugin Structure**

```
plugins/job-listing/
├── JobListingPlugin.php       # Main plugin class
├── plugin.json                # Plugin metadata
├── controllers/
│   ├── JobController.php
│   └── ApplicationController.php
├── models/
│   ├── Job.php
│   ├── Company.php
│   └── JobApplication.php
├── migrations/
│   ├── 001_create_jobs_table.php
│   ├── 002_create_companies_table.php
│   └── 003_create_applications_table.php
├── views/
│   ├── job-detail.php
│   └── job-list.php
└── README.md
```

### **4.2 plugin.json**

```json
{
    "name": "Job Listing Plugin",
    "version": "2.0.0",
    "author": "Your Name",
    "description": "Complete job board functionality for your CMS",
    "requires": {
        "php": "^8.0",
        "ramsi-cms": "^1.0"
    },
    "provides": {
        "content_types": ["job"],
        "data_providers": [
            "similar_jobs",
            "company_info",
            "application_count"
        ],
        "routes": [
            "jobs",
            "jobs/{category}/{slug}",
            "jobs/{slug}/apply"
        ]
    }
}
```

### **4.3 Example Plugin Implementation**

```php
// plugins/job-listing/JobListingPlugin.php
<?php

namespace Plugins\JobListing;

use Plugin;

class JobListingPlugin extends Plugin {
    
    public function boot() {
        // Register the 'job' content type
        $this->registerContentType('job', [
            'label' => 'Jobs',
            'table' => 'jobs',
            'model' => Models\Job::class,
            'controller' => Controllers\JobController::class,
            'routes' => [
                'index' => 'jobs',
                'category' => 'jobs/{category}',
                'show' => 'jobs/{category}/{slug}',
                'apply' => 'jobs/{slug}/apply'
            ],
            'methods' => [
                'apply' => 'post'
            ],
            'searchable' => true,
            'providers' => [
                'similar_jobs' => [$this, 'provideSimilarJobs'],
                'company_info' => [$this, 'provideCompanyInfo'],
                'application_count' => [$this, 'provideApplicationCount']
            ]
        ]);
    }
    
    public function activate() {
        // Run migrations
        $this->runMigrations();
        
        // Create default categories
        $this->createDefaultCategories();
    }
    
    public function deactivate() {
        // Optionally clean up
    }
    
    /**
     * Provider: Similar jobs
     */
    public function provideSimilarJobs($context, $options = []) {
        $job = $context['job'];
        $limit = $options['limit'] ?? 5;
        
        return Models\Job::where('category', $job->category)
                         ->where('id', '!=', $job->id)
                         ->where('status', 'published')
                         ->limit($limit)
                         ->get();
    }
    
    /**
     * Provider: Company info
     */
    public function provideCompanyInfo($context, $options = []) {
        $job = $context['job'];
        return Models\Company::find($job->company_id);
    }
    
    /**
     * Provider: Application count
     */
    public function provideApplicationCount($context, $options = []) {
        $job = $context['job'];
        return Models\JobApplication::where('job_id', $job->id)->count();
    }
    
    /**
     * Create default job categories
     */
    protected function createDefaultCategories() {
        $categories = [
            'engineering',
            'design',
            'marketing',
            'sales',
            'customer-support'
        ];
        
        // Implementation depends on your category system
    }
}
```

### **4.4 Plugin Controller Example**

```php
// plugins/job-listing/controllers/JobController.php
<?php

namespace Plugins\JobListing\Controllers;

use Plugins\JobListing\Models\Job;

class JobController {
    
    /**
     * List all jobs
     */
    public function index() {
        $jobs = Job::where('status', 'published')
                   ->orderBy('published_at', 'desc')
                   ->paginate(20);
        
        $theme = app('theme')->getActive();
        $context = ['jobs' => $jobs];
        
        // Get providers for 'jobs' template
        $providers = $theme->getProviders('jobs');
        $context = array_merge(
            $context,
            app('providers')->getBatch($providers, $context)
        );
        
        return view($theme->getTemplate('jobs'), $context);
    }
    
    /**
     * Show single job
     */
    public function show($category, $slug) {
        $job = Job::where('category', $category)
                  ->where('slug', $slug)
                  ->where('status', 'published')
                  ->firstOrFail();
        
        $theme = app('theme')->getActive();
        app('theme')->setCurrentTemplate('job');
        
        $context = ['job' => $job];
        
        // Get providers for 'job' template
        $providers = $theme->getProviders('job');
        $context = array_merge(
            $context,
            app('providers')->getBatch($providers, $context)
        );
        
        return view($theme->getTemplate('job'), $context);
    }
    
    /**
     * Handle job application
     */
    public function apply($slug) {
        $job = Job::where('slug', $slug)->firstOrFail();
        
        // Handle application submission
        // Validate, save, send email, etc.
        
        return redirect("/jobs/{$job->category}/{$job->slug}")
               ->with('success', 'Application submitted!');
    }
}
```

### **4.5 Plugin Model Example**

```php
// plugins/job-listing/models/Job.php
<?php

namespace Plugins\JobListing\Models;

use Model;

class Job extends Model {
    protected $table = 'jobs';
    
    protected $fillable = [
        'slug', 'title', 'description',
        'company_id', 'salary_min', 'salary_max',
        'location', 'remote_allowed', 'category',
        'employment_type', 'status'
    ];
    
    /**
     * Relationships
     */
    public function company() {
        return $this->belongsTo(Company::class);
    }
    
    public function applications() {
        return $this->hasMany(JobApplication::class);
    }
    
    public function author() {
        return $this->belongsTo(\App\Models\User::class, 'author_id');
    }
    
    /**
     * Scopes
     */
    public function scopePublished($query) {
        return $query->where('status', 'published')
                     ->where('published_at', '<=', now())
                     ->where(function($q) {
                         $q->whereNull('expires_at')
                           ->orWhere('expires_at', '>', now());
                     });
    }
    
    public function scopeCategory($query, $category) {
        return $query->where('category', $category);
    }
    
    /**
     * Helpers
     */
    public function url() {
        return "/jobs/{$this->category}/{$this->slug}";
    }
    
    public function isActive() {
        return $this->status === 'published' 
               && (!$this->expires_at || $this->expires_at > now());
    }
    
    public function salaryRange() {
        if (!$this->salary_min && !$this->salary_max) {
            return 'Negotiable';
        }
        
        $min = number_format($this->salary_min);
        $max = number_format($this->salary_max);
        
        return "{$this->currency} {$min} - {$max}";
    }
}
```

---

## **5. Theme System**

### **5.1 Theme Structure**

```
themes/magazine/
├── MagazineTheme.php          # Theme class
├── theme.json                 # Theme metadata
├── templates/
│   ├── layout.php             # Base layout
│   ├── post.php               # Post template
│   ├── page.php               # Page template
│   ├── job.php                # Job template (if supports jobs)
│   └── archive.php            # Archive template
├── assets/
│   ├── css/
│   │   ├── style.css
│   │   └── post.css
│   └── js/
│       └── main.js
├── screenshot.png             # Theme preview
└── README.md
```

### **5.2 theme.json**

```json
{
    "name": "Magazine Theme",
    "version": "1.0.0",
    "author": "Your Name",
    "description": "A beautiful magazine-style theme",
    "screenshot": "screenshot.png",
    "requires": {
        "php": "^8.0",
        "ramsi-cms": "^1.0",
        "plugins": []
    },
    "templates": {
        "post": {
            "template": "templates/post.php",
            "data_providers": [
                "related_posts",
                "author_bio",
                "popular_posts"
            ]
        },
        "page": {
            "template": "templates/page.php",
            "data_providers": []
        },
        "archive": {
            "template": "templates/archive.php",
            "data_providers": [
                "featured_posts",
                "categories"
            ]
        }
    },
    "settings": {
        "primary_color": "#3498db",
        "show_author": true,
        "posts_per_page": 10
    }
}
```

### **5.3 Theme Class Implementation**

```php
// themes/magazine/MagazineTheme.php
<?php

namespace Themes\Magazine;

use Theme;

class MagazineTheme extends Theme {
    
    public function boot() {
        // Register assets
        $this->registerStyle('normalize', 'assets/css/normalize.css', [
            'version' => '8.0.1'
        ]);
        
        $this->registerStyle('main', 'assets/css/style.css', [
            'version' => $this->version,
            'dependencies' => ['normalize']
        ]);
        
        $this->registerStyle('post', 'assets/css/post.css', [
            'version' => $this->version,
            'only' => ['post']
        ]);
        
        $this->registerScript('main', 'assets/js/main.js', [
            'version' => $this->version,
            'dependencies' => ['jquery'],
            'position' => 'footer'
        ]);
        
        // Register custom providers
        $this->registerProvider('popular_posts', function($context) {
            return \App\Models\Post::posts()
                                   ->published()
                                   ->orderBy('views', 'desc')
                                   ->limit(5)
                                   ->get();
        });
        
        $this->registerProvider('featured_posts', function($context) {
            return \App\Models\Post::posts()
                                   ->published()
                                   ->where('featured', true)
                                   ->limit(3)
                                   ->get();
        });
    }
}
```

### **5.4 Template Example**

```php
<!-- themes/magazine/templates/layout.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'My Site' ?></title>
    
    <?= app('assets')->renderStyles() ?>
</head>
<body>
    <header>
        <nav>
            <a href="/">Home</a>
            <a href="/blog">Blog</a>
            <a href="/about">About</a>
        </nav>
    </header>
    
    <main>
        <?= $content ?>
    </main>
    
    <footer>
        <p>&copy; <?= date('Y') ?> My Site</p>
    </footer>
    
    <?= app('assets')->renderScripts('footer') ?>
</body>
</html>
```

```php
<!-- themes/magazine/templates/post.php -->
<?php
$layout = file_get_contents(__DIR__ . '/layout.php');
ob_start();
?>

<article class="post">
    <header>
        <h1><?= htmlspecialchars($post->title) ?></h1>
        <div class="meta">
            <span class="author">By <?= htmlspecialchars($post->author->display_name) ?></span>
            <span class="date"><?= $post->published_at->format('M d, Y') ?></span>
        </div>
    </header>
    
    <?php if (isset($author_bio)): ?>
    <aside class="author-bio">
        <img src="<?= $author_bio->avatar ?>" alt="<?= $author_bio->name ?>">
        <div>
            <h3><?= $author_bio->name ?></h3>
            <p><?= $author_bio->bio ?></p>
        </div>
    </aside>
    <?php endif; ?>
    
    <div class="content">
        <?= $post->content ?>
    </div>
    
    <?php if (isset($related_posts) && count($related_posts) > 0): ?>
    <aside class="related-posts">
        <h3>Related Posts</h3>
        <ul>
            <?php foreach ($related_posts as $related): ?>
            <li>
                <a href="<?= $related->url() ?>">
                    <?= htmlspecialchars($related->title) ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </aside>
    <?php endif; ?>
</article>

<?php
$content = ob_get_clean();
$title = $post->title;
eval('?>' . $layout);
?>
```

---

## **6. Routing & Content Resolution**

### **6.1 Bootstrap Flow**

```php
// bootstrap.php
<?php

define('BASE_PATH', __DIR__);

// Autoloader
require BASE_PATH . '/vendor/autoload.php';

// Create application container
$app = new Application();

// Register core services
$app->singleton('content_types', function() {
    return new ContentTypeRegistry();
});

$app->singleton('providers', function() {
    return new ProviderRegistry();
});

$app->singleton('plugins', function() {
    return new PluginManager();
});

$app->singleton('theme', function() {
    return new ThemeManager();
});

$app->singleton('assets', function() {
    return new AssetManager();
});

// Register core content types
app('content_types')->register('post', [
    'label' => 'Posts',
    'table' => 'posts',
    'type_value' => 'post',
    'model' => App\Models\Post::class,
    'controller' => App\Controllers\PostController::class,
    'routes' => [
        'index' => 'blog',
        'show' => 'blog/{slug}'
    ]
]);

app('content_types')->register('page', [
    'label' => 'Pages',
    'table' => 'posts',
    'type_value' => 'page',
    'model' => App\Models\Post::class,
    'controller' => App\Controllers\PageController::class,
    'routes' => [
        'show' => '{slug}'
    ]
]);

// Register core providers
app('providers')->register('related_posts', function($context) {
    $post = $context['post'];
    return App\Models\Post::posts()
                          ->published()
                          ->where('id', '!=', $post->id)
                          ->where(function($q) use ($post) {
                              // Same category or tags
                              $q->whereHas('categories', function($q2) use ($post) {
                                  $q2->whereIn('id', $post->categories->pluck('id'));
                              });
                          })
                          ->limit(5)
                          ->get();
});

app('providers')->register('author_bio', function($context) {
    $post = $context['post'];
    return $post->author;
});

// Boot plugins (they register routes, providers, content types)
app('plugins')->bootAll();

// Boot active theme (it registers custom providers, assets)
app('theme')->bootActive();

// Define fallback route LAST
Route::get('{slug}', [App\Controllers\PageController::class, 'show']);

return $app;
```

### **6.2 Route Resolution Order**

```
Request: /jobs/engineering/senior-dev

1. Check exact routes first:
   - /about → PageController::show('about')
   - /contact → PageController::show('contact')
   
2. Check plugin-registered routes:
   - /jobs/{category}/{slug} → JobController::show('engineering', 'senior-dev') ✓ MATCH
   
3. Fallback to page controller:
   - /{slug} → PageController::show($slug)
```

### **6.3 Core Controllers**

```php
// application/controllers/PostController.php
<?php

namespace App\Controllers;

use App\Models\Post;

class PostController {
    
    public function index() {
        $posts = Post::posts()
                    ->published()
                    ->orderBy('published_at', 'desc')
                    ->paginate(10);
        
        $theme = app('theme')->getActive();
        app('theme')->setCurrentTemplate('archive');
        
        $context = ['posts' => $posts];
        
        // Get providers
        $providers = $theme->getProviders('archive');
        $context = array_merge(
            $context,
            app('providers')->getBatch($providers, $context)
        );
        
        return view($theme->getTemplate('archive'), $context);
    }
    
    public function show($slug) {
        $post = Post::posts()
                   ->where('slug', $slug)
                   ->published()
                   ->firstOrFail();
        
        $theme = app('theme')->getActive();
        app('theme')->setCurrentTemplate('post');
        
        $context = ['post' => $post];
        
        // Get providers for 'post' template
        $providers = $theme->getProviders('post');
        $context = array_merge(
            $context,
            app('providers')->getBatch($providers, $context)
        );
        
        return view($theme->getTemplate('post'), $context);
    }
}
```

```php
// application/controllers/PageController.php
<?php

namespace App\Controllers;

use App\Models\Post;

class PageController {
    
    public function show($slug) {
        // Try to find page
        $page = Post::pages()
                   ->where('slug', $slug)
                   ->published()
                   ->first();
        
        if (!$page) {
            abort(404);
        }
        
        $theme = app('theme')->getActive();
        app('theme')->setCurrentTemplate('page');
        
        $context = ['page' => $page];
        
        // Get providers for 'page' template
        $providers = $theme->getProviders('page');
        $context = array_merge(
            $context,
            app('providers')->getBatch($providers, $context)
        );
        
        return view($theme->getTemplate('page'), $context);
    }
}
```

---

## **7. Data Provider System**

### **7.1 Core Providers**

Register these in bootstrap.php:

```php
// Related posts provider
app('providers')->register('related_posts', function($context, $options = []) {
    $post = $context['post'];
    $limit = $options['limit'] ?? 5;
    $by = $options['by'] ?? 'category';
    
    $query = Post::posts()
                ->published()
                ->where('id', '!=', $post->id);
    
    if ($by === 'category') {
        $query->whereHas('categories', function($q) use ($post) {
            $q->whereIn('id', $post->categories->pluck('id'));
        });
    } elseif ($by === 'tags') {
        $query->whereHas('tags', function($q) use ($post) {
            $q->whereIn('id', $post->tags->pluck('id'));
        });
    }
    
    return $query->limit($limit)->get();
});

// Author bio provider
app('providers')->register('author_bio', function($context) {
    $content = $context['post'] ?? $context['page'];
    return $content->author;
});

// Categories provider
app('providers')->register('categories', function($context) {
    return Category::with('posts')->get();
});

// Recent posts provider
app('providers')->register('recent_posts', function($context, $options = []) {
    $limit = $options['limit'] ?? 5;
    return Post::posts()
               ->published()
               ->orderBy('published_at', 'desc')
               ->limit($limit)
               ->get();
});
```

### **7.2 Using Providers in Controllers**

```php
public function show($slug) {
    $post = Post::where('slug', $slug)->firstOrFail();
    
    $theme = app('theme')->getActive();
    $context = ['post' => $post];
    
    // Get all providers theme needs
    $providers = $theme->getProviders('post');
    // ['related_posts', 'author_bio', 'popular_posts']
    
    // Fetch all provider data
    $providerData = app('providers')->getBatch($providers, $context);
    // [
    //     'related_posts' => [...],
    //     'author_bio' => {...},
    //     'popular_posts' => [...]
    // ]
    
    // Merge into context
    $context = array_merge($context, $providerData);
    
    return view($theme->getTemplate('post'), $context);
}
```

---

## **8. Asset Management**

### **8.1 Registering Assets**

```php
// In theme boot()
public function boot() {
    // Core stylesheet
    $this->registerStyle('main', 'assets/css/style.css', [
        'version' => $this->version
    ]);
    
    // Template-specific stylesheet
    $this->registerStyle('post', 'assets/css/post.css', [
        'version' => $this->version,
        'only' => ['post']  // Only load on post template
    ]);
    
    // External library
    $this->registerScript('jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', [
        'position' => 'footer'
    ]);
    
    // Theme script with dependency
    $this->registerScript('main', 'assets/js/main.js', [
        'version' => $this->version,
        'dependencies' => ['jquery'],
        'position' => 'footer'
    ]);
}
```

### **8.2 Rendering Assets in Templates**

```php
<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    
    <!-- Render all stylesheets -->
    <?= app('assets')->renderStyles() ?>
</head>
<body>
    <?= $content ?>
    
    <!-- Render footer scripts -->
    <?= app('assets')->renderScripts('footer') ?>
</body>
</html>
```

---

## **9. Example Implementations**

### **9.1 Complete Job Board Plugin**

See Section 4.3-4.5 for full implementation.

**Key files:**
- `JobListingPlugin.php` - Main plugin class
- `plugin.json` - Metadata
- `controllers/JobController.php` - Handle requests
- `models/Job.php` - Job model
- `migrations/001_create_jobs_table.php` - Database schema

### **9.2 Complete Magazine Theme**

See Section 5.3-5.4 for full implementation.

**Key files:**
- `MagazineTheme.php` - Theme class
- `theme.json` - Metadata and config
- `templates/layout.php` - Base layout
- `templates/post.php` - Post template
- `assets/css/style.css` - Styles

### **9.3 Core Post Model**

```php
// application/models/Post.php
<?php

namespace App\Models;

class Post extends Model {
    protected $table = 'posts';
    
    protected $fillable = [
        'type', 'slug', 'title', 'content', 'excerpt',
        'parent_id', 'page_order', 'published_at',
        'author_id', 'status'
    ];
    
    protected $dates = ['published_at', 'created_at', 'updated_at'];
    
    /**
     * Relationships
     */
    public function author() {
        return $this->belongsTo(User::class, 'author_id');
    }
    
    public function categories() {
        return $this->belongsToMany(Category::class, 'post_category');
    }
    
    public function tags() {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }
    
    public function parent() {
        return $this->belongsTo(Post::class, 'parent_id');
    }
    
    public function children() {
        return $this->hasMany(Post::class, 'parent_id')
                    ->orderBy('page_order');
    }
    
    /**
     * Meta data
     */
    public function meta($key = null, $default = null) {
        if ($key === null) {
            // Return all meta
            return PostMeta::where('post_id', $this->id)
                          ->pluck('meta_value', 'meta_key');
        }
        
        $meta = PostMeta::where('post_id', $this->id)
                       ->where('meta_key', $key)
                       ->value('meta_value');
        
        return $meta ?? $default;
    }
    
    public function setMeta($key, $value) {
        PostMeta::updateOrCreate(
            ['post_id' => $this->id, 'meta_key' => $key],
            ['meta_value' => $value]
        );
    }
    
    /**
     * Scopes
     */
    public function scopePosts($query) {
        return $query->where('type', 'post');
    }
    
    public function scopePages($query) {
        return $query->where('type', 'page');
    }
    
    public function scopePublished($query) {
        return $query->where('status', 'published')
                     ->where('published_at', '<=', now());
    }
    
    public function scopeType($query, $type) {
        return $query->where('type', $type);
    }
    
    /**
     * Helpers
     */
    public function url() {
        if ($this->type === 'page') {
            // Build hierarchical URL
            $segments = [$this->slug];
            $parent = $this->parent;
            
            while ($parent) {
                array_unshift($segments, $parent->slug);
                $parent = $parent->parent;
            }
            
            return '/' . implode('/', $segments);
        }
        
        return '/blog/' . $this->slug;
    }
    
    public function isPost() {
        return $this->type === 'post';
    }
    
    public function isPage() {
        return $this->type === 'page';
    }
    
    public function isPublished() {
        return $this->status === 'published' 
               && $this->published_at <= now();
    }
}
```

---

## **10. Implementation Checklist**

### **Phase 1: Core Foundation**

- [ ] Set up directory structure
- [ ] Create database schema (posts, users, categories, tags, postmeta)
- [ ] Implement base Model class
- [ ] Implement Post model with scopes
- [ ] Create basic controllers (PostController, PageController)
- [ ] Set up routing system
- [ ] Create basic views/templates

### **Phase 2: Registry System**

- [ ] Build ContentTypeRegistry class
- [ ] Build ProviderRegistry class
- [ ] Register core content types (post, page)
- [ ] Register core providers (related_posts, author_bio, etc.)
- [ ] Test provider system with mock data

### **Phase 3: Plugin System**

- [ ] Create base Plugin class
- [ ] Build PluginManager (discover, boot, activate)
- [ ] Create plugin directory structure
- [ ] Build example plugin (job-listing)
  - [ ] Plugin class with boot()
  - [ ] plugin.json metadata
  - [ ] Controllers
  - [ ] Models
  - [ ] Migrations
- [ ] Test plugin activation/deactivation

### **Phase 4: Theme System**

- [ ] Create base Theme class
- [ ] Build ThemeManager (discover, boot, activate)
- [ ] Build AssetManager
- [ ] Create theme directory structure
- [ ] Build default theme
  - [ ] Theme class with boot()
  - [ ] theme.json metadata
  - [ ] Base templates (layout, post, page)
  - [ ] CSS/JS assets
- [ ] Test theme switching

### **Phase 5: Integration**

- [ ] Implement bootstrap.php (wire everything together)
- [ ] Test plugin route registration
- [ ] Test theme provider requests
- [ ] Test dependency validation
- [ ] Test content type routing

### **Phase 6: Polish**

- [ ] Add error handling
- [ ] Add logging
- [ ] Create admin interface for:
  - [ ] Plugin management
  - [ ] Theme management
  - [ ] Content management
- [ ] Write documentation
- [ ] Create example plugins/themes

### **Testing Scenarios**

1. **Core CMS**
   - Create post, view at /blog/{slug}
   - Create page, view at /{slug}
   - Create hierarchical pages (about/team)

2. **Plugin System**
   - Install job-listing plugin
   - Create job, view at /jobs/{category}/{slug}
   - Verify providers registered
   - Deactivate plugin, verify routes removed

3. **Theme System**
   - Activate magazine theme
   - Verify assets load
   - Verify templates used
   - Verify providers requested and fulfilled

4. **Integration**
   - Install job theme without job plugin → should error
   - Install job plugin → activate job theme → should work
   - Theme requests non-existent provider → should error

---

## **Quick Start Commands**

```bash
# 1. Set up database
mysql -u root -p < database/schema.sql

# 2. Install dependencies
composer install

# 3. Configure
cp config/app.example.php config/app.php
# Edit config/app.php with your settings

# 4. Start development server
php -S localhost:8000 -t public/

# 5. Visit site
# http://localhost:8000
```

---

## **Next Steps**

1. **Start with Phase 1** - Get core CMS working (posts, pages, basic routing)
2. **Move to Phase 2** - Add registry system
3. **Build one example plugin** (job-listing) - Proves plugin system works
4. **Build one theme** (magazine) - Proves theme system works
5. **Iterate and improve**

---

**This is your complete blueprint. Start building! 🚀**
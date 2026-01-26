<?php namespace Lib;

/**
 * Provider Registry - Pressli CMS
 *
 * Manages data providers that themes and templates can request on-demand.
 * Implements lazy-loading pattern where only requested data is fetched,
 * eliminating unnecessary database queries.
 *
 * USAGE:
 * - Plugins/core register providers with callbacks
 * - Themes declare which providers they need per template
 * - Controllers fetch only what theme declares
 * - Providers receive context (current post/page) and options
 *
 * BENEFITS:
 * - No pre-loading of unused data
 * - Clean separation of concerns
 * - Easy to extend with plugins
 * - Testable provider logic
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class ProviderRegistry
{
    /**
     * Registered data providers
     *
     * Stores callable functions that provide data on-demand to templates.
     * Each provider is identified by a unique string key and must be callable.
     * Format: ['provider_name' => callable, 'another_provider' => callable]
     *
     * @var array
     */
    protected static $providers = [];

    /**
     * Register a data provider
     *
     * Providers must be callable and accept two parameters:
     * - $context: Current page context (post, page, etc.)
     * - $options: Optional configuration (limit, filters, etc.)
     *
     * @param string $name Provider identifier
     * @param callable $callback Provider function
     * @return void
     * @throws \Exception If provider is not callable
     */
    public static function register($name, $callback)
    {
        if (!is_callable($callback)) {
            throw new \Exception("Provider '{$name}' must be callable");
        }

        self::$providers[$name] = $callback;
    }

    /**
     * Get data from a single provider
     *
     * Executes provider callback with context and options.
     * Returns provider result or throws exception if not found.
     *
     * @param string $name Provider identifier
     * @param array $context Current page context
     * @param array $options Provider options
     * @return mixed Provider result
     * @throws \Exception If provider not found
     */
    public static function get($name, $context = [], $options = [])
    {
        if (!self::has($name)) {
            throw new \Exception("Provider '{$name}' not found");
        }

        return call_user_func(self::$providers[$name], $context, $options);
    }

    /**
     * Check if provider exists
     *
     * Verifies whether a provider with the given name has been registered.
     * Used to prevent errors when requesting optional providers or validating
     * theme configurations before attempting to fetch provider data.
     *
     * @param string $name Provider identifier
     * @return bool True if provider exists, false otherwise
     */
    public static function has($name)
    {
        return isset(self::$providers[$name]);
    }

    /**
     * Get all registered provider names
     *
     * Returns array of all provider identifiers currently registered in the system.
     * Useful for debugging, admin interfaces, or validating theme requirements.
     * Does not execute providers, only returns their names.
     *
     * @return array List of provider names (strings)
     */
    public static function all()
    {
        return array_keys(self::$providers);
    }

    /**
     * Get multiple providers at once
     *
     * Executes multiple provider callbacks and returns results as associative array.
     * Supports two formats:
     * - ['provider_name'] - No options
     * - ['provider_name' => ['limit' => 5]] - With options
     *
     * Skips providers that don't exist (fails silently for flexibility).
     *
     * @param array $names Provider names or name => options pairs
     * @param array $context Current page context
     * @return array Provider results keyed by provider name
     */
    public static function getBatch(array $names, $context = [])
    {
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

            // Skip if provider doesn't exist (allows flexible theme configs)
            if (self::has($providerName)) {
                $results[$providerName] = self::get($providerName, $context, $options);
            }
        }

        return $results;
    }

    /**
     * Remove a provider
     *
     * Unregisters a previously registered provider from the system.
     * Primarily used during plugin deactivation to clean up providers,
     * or in testing to reset state between tests. Safe to call on non-existent providers.
     *
     * @param string $name Provider identifier
     * @return void
     */
    public static function unregister($name)
    {
        unset(self::$providers[$name]);
    }

    /**
     * Clear all providers
     *
     * Removes all registered providers from the system completely.
     * Primarily used in testing to reset state between test cases,
     * or during application reset/reload scenarios. Use with caution as this
     * removes ALL providers including core ones.
     *
     * @return void
     */
    public static function clear()
    {
        self::$providers = [];
    }
}

<?php namespace Controllers\Api;

use Rackage\View;
use Rackage\Registry;
use Controllers\Api\ApiController;

/**
 * API Plugin Controller - Pressli CMS
 *
 * Thin dispatcher for plugin API endpoints. Verifies Bearer token via the
 * ApiController constructor, then hands the request off to the plugin's
 * api() method. The plugin handles its own routing and JSON response.
 *
 * Routes (config/routes.php):
 *   'api/plugin' => 'Api\ApiPlugin@handle/slug'
 *
 * URL examples:
 *   POST /api/plugin/directory/vendors    → DirectoryPlugin::api('post', 'vendors')
 *   GET  /api/plugin/directory/vendors/5  → DirectoryPlugin::api('get', 'vendors', '5')
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 1.0.0
 */
class ApiPluginController extends ApiController
{
    /**
     * Dispatch a plugin API request
     *
     * @param string      $slug Plugin slug (e.g. "directory")
     * @param string|null $param1   First URL segment after slug
     * @param string|null $param2   Second URL segment
     * @return void Responds via View::json()
     */
    public function handle($slug, $param1 = null, $param2 = null)
    {
        $namespace = str_replace('-', '', ucwords($slug, '-'));
        $class = 'Plugins\\' . $namespace . '\\' . $namespace . 'Plugin';

        if (!class_exists($class)) {
            View::json(['success' => false, 'message' => 'Plugin not found'], 404);
            return;
        }

        $method = strtolower($_SERVER['REQUEST_METHOD'] ?? 'get');

        $plugin = new $class();
        $plugin->api($method, $param1, $param2);
    }
}

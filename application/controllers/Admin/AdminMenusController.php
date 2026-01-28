<?php namespace Controllers\Admin;

/**
 * Menus Controller - Pressli CMS
 *
 * Manages menu containers and menu items for site navigation.
 * Handles CRUD operations for menus and their hierarchical items.
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */

use Lib\ThemeConfig;
use Rackage\Csrf;
use Rackage\View;
use Rackage\Input;
use Rackage\Session;
use Rackage\Request;
use Rackage\Redirect;
use Models\PostModel;
use Models\SettingModel;
use Models\TaxonomyModel;
use Lib\Services\Menu;
use Controllers\Admin\AdminController;
use Lib\Exceptions\ServiceException;

class AdminMenusController extends AdminController
{
    /**
     * Enable method filters for this controller
     *
     * Set to true to enable before/after filters defined in the class or
     * method level docblock. Defaults to false. Set to true to use filters.
     *
     * @var bool
     */
    public $enable_filters = false;

    /**
     * Display menu management interface
     *
     * Shows all menus with their item counts and menu editor interface.
     * Displays selected menu's items for editing and reordering.
     *
     * @return void
     */
    public function getIndex()
    {
        // Fetch all menus with item counts
        $menus = Menu::getAll();

        // Get selected menu (first menu or from query param)
        $selectedMenuId = Input::get('menu_id') ?: ($menus[0]['id'] ?? null);

        // Get selected menu data and items
        $menuItems = [];
        $selectedMenu = null;
        if ($selectedMenuId) {
            // Get selected menu data
            $selectedMenu = array_filter($menus, function($m) use ($selectedMenuId) {
                return $m['id'] == $selectedMenuId;
            });
            $selectedMenu = reset($selectedMenu);

            // Fetch menu items for selected menu
            $menuItems = Menu::getMenuItems($selectedMenuId);
        }

        // Get menu locations from active theme
        $menuLocations = [];
        try {
            $settings = SettingModel::getAutoload();
            $activeTheme = $settings['active_theme'] ?? 'aurora';

            $themeConfig = ThemeConfig::load($activeTheme);
            $menuLocations = $themeConfig->getMenuLocations();
        } 
        catch (\Exception $e) {
            // If theme doesn't define locations, use empty array
        }

        // Array of data to send to view
        $data = [
            'title' => 'Menus',
            'menus' => $menus,
            'selectedMenuId' => $selectedMenuId,
            'selectedMenu' => $selectedMenu,
            'menuItems' => $menuItems,
            'menuLocations' => $menuLocations,
            'settings' => $this->settings
        ];

        View::render('admin/menus', $data);
    }

    /**
     * Create new menu container
     *
     * Creates menu with auto-generated slug from name.
     * Redirects to menu management with new menu selected.
     *
     * @return void
     */
    public function postCreate()
    {
        // Verify CSRF token
        if (!Csrf::verify()) {
            if (Request::wantsJson()) {
                View::json(['success' => false, 'message' => 'Invalid CSRF token'], 403);
                return;
            }
            Session::flash('error', 'Invalid security token. Please try again.');
            Redirect::back();
        }

        try {
            // Prepare menu data from form input
            $data = [
                'name' => Input::post('name'),
                'slug' => Input::post('slug'),
                'location' => Input::post('location')
            ];

            // Create menu via service
            $menuId = Menu::create($data);

            // Return JSON for AJAX requests
            if (Request::wantsJson()) {
                View::json(['success' => true, 'menu_id' => $menuId]);
                return;
            }

            // Traditional redirect
            Session::flash('success', 'Menu created successfully!');
            Redirect::to('admin/menus?menu_id=' . $menuId);
        }
        catch (ServiceException $e) {
            // Validation error
            if (Request::wantsJson()) {
                View::json(['success' => false, 'message' => $e->getMessage()], 422);
                return;
            }
            Session::flash('error', $e->getMessage());
            Redirect::back();
        }
    }

    /**
     * Delete menu and all its items
     *
     * CASCADE delete automatically removes menu items via foreign key.
     * Redirects to menu management interface.
     *
     * @param int $id Menu ID to delete
     * @return void
     */
    public function postDelete($id)
    {
        try {
            // Delete menu via service
            Menu::delete($id);

            // Success - redirect to menus list
            Session::flash('success', 'Menu deleted successfully!');
            Redirect::to('admin/menus');
        }
        catch (ServiceException $e) {
            // Menu not found
            Session::flash('error', $e->getMessage());
            Redirect::to('admin/menus');
        }
    }

    /**
     * Add new item to menu
     *
     * Creates menu item with next available sort order.
     * Returns JSON response for AJAX handling.
     *
     * @return void
     */
    public function postAdd()
    {
        try {
            // Prepare menu item data from form input
            $data = [
                'menu_id' => Input::post('menu_id'),
                'parent_id' => Input::post('parent_id'),
                'title' => Input::post('title'),
                'url' => Input::post('url'),
                'target' => Input::post('target'),
                'css_classes' => Input::post('css_classes')
            ];

            // Add menu item via service
            $itemId = Menu::addItem($data);

            // Return JSON for AJAX
            View::json(['success' => true, 'item_id' => $itemId]);
        }
        catch (ServiceException $e) {
            // Validation error
            View::json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    /**
     * Update menu item properties
     *
     * Updates title, URL, target, or CSS classes.
     * Returns JSON response for AJAX handling.
     *
     * @param int $id Menu item ID
     * @return void
     */
    public function postUpdate($id)
    {
        try {
            // Prepare item data from form input
            $data = [
                'title' => Input::post('title'),
                'url' => Input::post('url'),
                'target' => Input::post('target'),
                'css_classes' => Input::post('css_classes')
            ];

            // Update menu item via service
            Menu::updateItem($id, $data);

            // Return JSON for AJAX
            View::json(['success' => true]);
        }
        catch (ServiceException $e) {
            // Item not found
            View::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    /**
     * Delete menu item
     *
     * Removes item from menu and reorders remaining items.
     * Returns JSON response for AJAX handling.
     *
     * @param int $id Menu item ID to delete
     * @return void
     */
    public function postRemove($id)
    {
        try {
            // Delete menu item via service
            Menu::deleteItem($id);

            // Return JSON for AJAX
            View::json(['success' => true]);
        }
        catch (ServiceException $e) {
            // Item not found
            View::json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    /**
     * Reorder menu items
     *
     * Updates sort_order for multiple items based on new positions.
     * Accepts array of item IDs in desired order.
     *
     * @return void
     */
    public function postReorder()
    {
        // Verify CSRF token
        if (!Csrf::verify()) {
            View::json(['success' => false, 'message' => 'Invalid CSRF token'], 403);
            return;
        }

        try {
            // Parse item IDs from JSON
            $itemIds = json_decode(Input::post('item_ids'), true);

            // Reorder menu items via service
            Menu::reorderItems($itemIds);

            // Return JSON for AJAX
            View::json(['success' => true]);
        }
        catch (ServiceException $e) {
            // Invalid data
            View::json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    /**
     * Get all published pages for menu builder
     *
     * Returns JSON list of pages with id, title, and slug.
     * Used by AJAX menu builder to populate pages list.
     *
     * @return void
     */
    public function getPages()
    {
        $pages = PostModel::select(['id', 'title', 'slug'])
            ->where('type', 'page')
            ->where('status', 'published')
            ->order('title', 'asc')
            ->all();

        View::json(['pages' => $pages]);
    }

    /**
     * Get all categories for menu builder
     *
     * Returns JSON list of categories with id, name, and slug.
     * Used by AJAX menu builder to populate categories list.
     *
     * @return void
     */
    public function getCategories()
    {
        $categories = TaxonomyModel::select(['id', 'name', 'slug'])
            ->where('type', 'category')
            ->order('name', 'asc')
            ->all();

        View::json(['categories' => $categories]);
    }

    /**
     * Update menu location
     *
     * Updates which theme location a menu is assigned to.
     * Returns JSON response for AJAX handling.
     *
     * @return void
     */
    public function postUpdatelocation()
    {
        // Verify CSRF token
        if (!Csrf::verify()) {
            View::json(['success' => false, 'message' => 'Invalid CSRF token'], 403);
            return;
        }

        try {
            // Get menu ID and location from input
            $menuId = Input::post('menu_id');
            $location = Input::post('location');

            // Update menu location via service
            Menu::updateLocation($menuId, $location);

            // Return JSON for AJAX
            View::json(['success' => true]);
        }
        catch (ServiceException $e) {
            // Validation error or menu not found
            View::json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    /**
     * Save entire menu structure
     *
     * Replaces all menu items for a menu with new structure.
     * Deletes existing items and inserts new ones in one transaction.
     *
     * @return void
     */
    public function postSavestructure()
    {
        // Verify CSRF token
        if (!Csrf::verify()) {
            View::json(['success' => false, 'message' => 'Invalid CSRF token'], 403);
            return;
        }

        try {
            // Get menu ID and items from input
            $menuId = Input::post('menu_id');
            $items = json_decode(Input::post('items'), true);

            // Save menu structure via service
            Menu::saveStructure($menuId, $items);

            // Return JSON for AJAX
            View::json(['success' => true]);
        }
        catch (ServiceException $e) {
            // Validation error or menu not found
            View::json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}

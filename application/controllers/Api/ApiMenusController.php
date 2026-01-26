<?php namespace Controllers\Api;

/**
 * API Menus Controller - Pressli CMS
 *
 * REST API endpoint for managing navigation menus via Bearer token authentication.
 * Reuses Menu service for business logic, returns JSON responses instead
 * of HTML. All state-changing operations require valid Bearer token (verified
 * in ApiController constructor).
 *
 * Routes (automatic URL-based routing):
 * - GET  /api/menus             List all menus with item counts
 * - GET  /api/menus/show/{id}   Show single menu with items
 * - POST /api/menus/create      Create new menu
 * - POST /api/menus/update/{id} Update menu metadata
 * - POST /api/menus/delete/{id} Delete menu and all items
 * - POST /api/menus/items/add   Add new menu item
 * - POST /api/menus/items/update/{id} Update menu item
 * - POST /api/menus/items/delete/{id} Delete menu item
 * - POST /api/menus/reorder     Reorder menu items
 * - POST /api/menus/structure   Save entire menu structure
 *
 * Authentication: Bearer token in Authorization header (handled by ApiController)
 * Input: JSON body for all operations
 * CSRF: Bypassed for API requests (session flag set in ApiController)
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */

use Rackage\View;
use Rackage\Input;
use Lib\Services\Menu;
use Controllers\Api\ApiController;
use Lib\Exceptions\ServiceException;

class ApiMenusController extends ApiController
{
    /**
     * List all menus with item counts
     *
     * Returns all active menus with their item counts. Used for
     * displaying menu list in management interfaces.
     *
     * @return void JSON response with menus array
     */
    public function getIndex()
    {
        // Get all menus with item counts
        $menus = Menu::getAll();

        // Return JSON response
        View::json([
            'success' => true,
            'data' => $menus
        ], 200);
    }

    /**
     * Show single menu with items
     *
     * Returns menu details including all menu items in hierarchical order.
     * Returns 404 if menu not found.
     *
     * @param int $id Menu ID from URL
     * @return void JSON response with menu and items
     */
    public function getShow($id)
    {
        // Get menu by ID
        $menu = Menu::getById($id);

        if (!$menu) {
            View::json([
                'success' => false,
                'error' => 'Menu not found',
                'message' => 'The menu you requested does not exist'
            ], 404);
            return;
        }

        // Get menu items
        $menuItems = Menu::getMenuItems($id);

        // Return menu data with items
        View::json([
            'success' => true,
            'data' => [
                'menu' => $menu,
                'items' => $menuItems
            ]
        ], 200);
    }

    /**
     * Create new menu
     *
     * Validates input, auto-generates slug from name if not provided,
     * and creates menu with optional theme location assignment.
     *
     * Expected JSON body:
     * {
     *   "name": "Primary Menu",
     *   "slug": "primary-menu",         // Optional, auto-generated if not provided
     *   "location": "header"            // Optional, theme location identifier
     * }
     *
     * @return void JSON response with created menu data or validation errors
     */
    public function postCreate()
    {
        try {
            // Prepare menu data from JSON body
            $data = [
                'name' => Input::post('name'),
                'slug' => Input::post('slug'),
                'location' => Input::post('location')
            ];

            // Create menu via service
            $menuId = Menu::create($data);

            // Get created menu for response
            $menu = Menu::getById($menuId);

            // Return success with created menu data
            View::json([
                'success' => true,
                'message' => 'Menu created successfully',
                'data' => $menu
            ], 201);
        }
        catch (ServiceException $e) {
            // Validation error
            View::json([
                'success' => false,
                'error' => 'Creation failed',
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Update menu
     *
     * Updates menu name, slug, or location assignment. All fields
     * are optional - only provided fields are updated.
     *
     * Expected JSON body (all fields optional):
     * {
     *   "name": "Updated Menu Name",
     *   "slug": "updated-slug",
     *   "location": "footer"
     * }
     *
     * @param int $id Menu ID from URL
     * @return void JSON response with updated menu or error
     */
    public function postUpdate($id)
    {
        try {
            // Prepare menu data from JSON body
            $data = [
                'name' => Input::post('name'),
                'slug' => Input::post('slug'),
                'location' => Input::post('location')
            ];

            // Update menu via service
            Menu::update($id, $data);

            // Get updated menu for response
            $menu = Menu::getById($id);

            // Return success with updated resource
            View::json([
                'success' => true,
                'message' => 'Menu updated successfully',
                'data' => $menu
            ], 200);
        }
        catch (ServiceException $e) {
            // Menu not found or validation error
            View::json([
                'success' => false,
                'error' => 'Update failed',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Delete menu and all items
     *
     * Removes menu container. CASCADE foreign key automatically removes
     * all menu items associated with this menu.
     *
     * @param int $id Menu ID from URL
     * @return void JSON response with success message or error
     */
    public function postDelete($id)
    {
        try {
            // Delete menu via service
            Menu::delete($id);

            // Return success message
            View::json([
                'success' => true,
                'message' => 'Menu deleted successfully'
            ], 200);
        }
        catch (ServiceException $e) {
            // Menu not found
            View::json([
                'success' => false,
                'error' => 'Delete failed',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Add new menu item
     *
     * Creates menu item with next available sort order. Validates menu
     * exists and required fields are provided.
     *
     * Expected JSON body:
     * {
     *   "menu_id": 1,
     *   "title": "Home",
     *   "url": "/",
     *   "parent_id": null,              // Optional, for hierarchical items
     *   "target": "_self",              // Optional, defaults to _self
     *   "css_classes": "nav-link"       // Optional
     * }
     *
     * @return void JSON response with created item data or validation errors
     */
    public function postItemsAdd()
    {
        try {
            // Prepare menu item data from JSON body
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

            // Return success with item ID
            View::json([
                'success' => true,
                'message' => 'Menu item added successfully',
                'data' => ['item_id' => $itemId]
            ], 201);
        }
        catch (ServiceException $e) {
            // Validation error or menu not found
            View::json([
                'success' => false,
                'error' => 'Addition failed',
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Update menu item
     *
     * Updates item properties (title, url, target, css_classes).
     * All fields are optional - only provided fields are updated.
     *
     * Expected JSON body (all fields optional):
     * {
     *   "title": "Updated Title",
     *   "url": "/updated-path",
     *   "target": "_blank",
     *   "css_classes": "btn btn-primary"
     * }
     *
     * @param int $id Menu item ID from URL
     * @return void JSON response with success message or error
     */
    public function postItemsUpdate($id)
    {
        try {
            // Prepare item data from JSON body
            $data = [
                'title' => Input::post('title'),
                'url' => Input::post('url'),
                'target' => Input::post('target'),
                'css_classes' => Input::post('css_classes')
            ];

            // Update menu item via service
            Menu::updateItem($id, $data);

            // Return success message
            View::json([
                'success' => true,
                'message' => 'Menu item updated successfully'
            ], 200);
        }
        catch (ServiceException $e) {
            // Item not found
            View::json([
                'success' => false,
                'error' => 'Update failed',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Delete menu item
     *
     * Removes item from menu. Child items are NOT automatically removed
     * (no CASCADE on parent_id foreign key).
     *
     * @param int $id Menu item ID from URL
     * @return void JSON response with success message or error
     */
    public function postItemsDelete($id)
    {
        try {
            // Delete menu item via service
            Menu::deleteItem($id);

            // Return success message
            View::json([
                'success' => true,
                'message' => 'Menu item deleted successfully'
            ], 200);
        }
        catch (ServiceException $e) {
            // Item not found
            View::json([
                'success' => false,
                'error' => 'Delete failed',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Reorder menu items
     *
     * Updates sort_order for multiple items based on new positions.
     * Accepts array of item IDs in desired order.
     *
     * Expected JSON body:
     * {
     *   "item_ids": [5, 3, 1, 4, 2]    // Array of item IDs in desired order
     * }
     *
     * @return void JSON response with success message or error
     */
    public function postReorder()
    {
        try {
            // Get item IDs from JSON body (already parsed as array)
            $itemIds = Input::post('item_ids');

            // Reorder menu items via service
            Menu::reorderItems($itemIds);

            // Return success message
            View::json([
                'success' => true,
                'message' => 'Menu items reordered successfully'
            ], 200);
        }
        catch (ServiceException $e) {
            // Invalid data
            View::json([
                'success' => false,
                'error' => 'Reorder failed',
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Save entire menu structure
     *
     * Replaces all menu items for a menu with new structure. Deletes
     * existing items and inserts new ones. Use for drag-and-drop menu
     * builders that send complete menu structure.
     *
     * Expected JSON body:
     * {
     *   "menu_id": 1,
     *   "items": [
     *     {
     *       "title": "Home",
     *       "url": "/",
     *       "parent_id": null,
     *       "target": "_self",
     *       "css_classes": "",
     *       "sort_order": 0
     *     },
     *     {
     *       "title": "About",
     *       "url": "/about",
     *       "parent_id": null,
     *       "target": "_self",
     *       "css_classes": "",
     *       "sort_order": 1
     *     }
     *   ]
     * }
     *
     * @return void JSON response with success message or error
     */
    public function postStructure()
    {
        try {
            // Get menu ID and items from JSON body
            $menuId = Input::post('menu_id');
            $items = Input::post('items');

            // Save menu structure via service
            Menu::saveStructure($menuId, $items);

            // Return success message
            View::json([
                'success' => true,
                'message' => 'Menu structure saved successfully'
            ], 200);
        }
        catch (ServiceException $e) {
            // Validation error or menu not found
            View::json([
                'success' => false,
                'error' => 'Save failed',
                'message' => $e->getMessage()
            ], 422);
        }
    }
}

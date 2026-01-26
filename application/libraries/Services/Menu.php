<?php namespace Lib\Services;

/**
 * Menu Service - Pressli CMS
 *
 * Business logic layer for managing navigation menus with hierarchical
 * menu items. Provides reusable functions for creating menus, managing
 * items with drag-and-drop reordering, and theme location assignments.
 *
 * USAGE CONTEXTS:
 * - Admin controllers (web UI for menu management)
 * - API controllers (REST endpoints for headless CMS)
 * - CLI commands (bulk menu operations)
 * - Plugins (programmatic menu creation)
 * - Theme rendering (menu display on frontend)
 *
 * MENU STRUCTURE:
 * - Menus: Containers with name, slug, location (theme position)
 * - Menu Items: Hierarchical items with title, url, parent_id, sort_order
 * - Locations: Theme-defined positions (header, footer, sidebar, etc.)
 * - Targets: _self (default), _blank, _parent, _top
 *
 * HIERARCHICAL STRUCTURE:
 * - Items can have parent-child relationships via parent_id
 * - Top-level items have parent_id = null
 * - sort_order determines display order within same level
 * - CASCADE delete removes all items when menu deleted
 *
 * VALIDATION RULES:
 * - Menu name is required
 * - Slug auto-generated from name if not provided
 * - Menu must exist for item operations
 * - Item title and URL are required
 * - sort_order auto-calculated if not provided
 *
 * ERROR HANDLING:
 * All methods throw ServiceException on validation or business logic errors.
 * Controllers catch exceptions and format response appropriately (flash messages or JSON).
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */

use Models\MenuModel;
use Models\MenuItemModel;
use Lib\Exceptions\ServiceException;

class Menu
{
    /**
     * Create new menu container
     *
     * Validates menu name, auto-generates slug from name if not provided,
     * and creates menu record with optional theme location assignment.
     *
     * @param array $data Input data (name, slug, location)
     * @return int Created menu ID
     * @throws ServiceException If name empty
     */
    public static function create($data)
    {
        // Validate name is provided
        if (empty($data['name'])) {
            throw new ServiceException('Menu name is required.');
        }

        // Generate slug from name if not provided
        $slug = !empty($data['slug'])
            ? self::sanitizeSlug($data['slug'])
            : self::generateSlug($data['name']);

        // Create menu
        $menuId = MenuModel::save([
            'name' => $data['name'],
            'slug' => $slug,
            'location' => $data['location'] ?? null,
            'status' => 'active'
        ]);

        return $menuId;
    }

    /**
     * Update menu container
     *
     * Updates menu name, slug, or location. Validates menu exists.
     *
     * @param int $id Menu ID to update
     * @param array $data Updated data (name, slug, location)
     * @return bool True on successful update
     * @throws ServiceException If menu not found or name empty
     */
    public static function update($id, $data)
    {
        // Fetch menu to update
        $menu = MenuModel::where('id', $id)->first();

        if (!$menu) {
            throw new ServiceException('Menu not found.');
        }

        // Validate name if provided
        if (isset($data['name']) && empty($data['name'])) {
            throw new ServiceException('Menu name is required.');
        }

        // Sanitize slug if provided
        if (isset($data['slug']) && !empty($data['slug'])) {
            $data['slug'] = self::sanitizeSlug($data['slug']);
        }

        // Update menu fields
        MenuModel::where('id', $id)->save([
            'name' => $data['name'] ?? $menu['name'],
            'slug' => $data['slug'] ?? $menu['slug'],
            'location' => $data['location'] ?? $menu['location']
        ]);

        return true;
    }

    /**
     * Delete menu and all its items
     *
     * Removes menu container. CASCADE foreign key automatically removes
     * all menu items associated with this menu.
     *
     * @param int $id Menu ID to delete
     * @return bool True on successful deletion
     * @throws ServiceException If menu not found
     */
    public static function delete($id)
    {
        // Fetch menu to delete
        $menu = MenuModel::where('id', $id)->first();

        if (!$menu) {
            throw new ServiceException('Menu not found.');
        }

        // Delete menu (CASCADE removes items)
        MenuModel::deleteById($id);

        return true;
    }

    /**
     * Update menu theme location
     *
     * Assigns menu to specific theme location (header, footer, sidebar, etc.).
     * Validates menu exists.
     *
     * @param int $menuId Menu ID to update
     * @param string|null $location Theme location identifier
     * @return bool True on successful update
     * @throws ServiceException If menu not found or menu ID not provided
     */
    public static function updateLocation($menuId, $location)
    {
        // Validate menu ID provided
        if (empty($menuId)) {
            throw new ServiceException('Menu ID is required.');
        }

        // Fetch menu to update
        $menu = MenuModel::where('id', $menuId)->first();

        if (!$menu) {
            throw new ServiceException('Menu not found.');
        }

        // Update location
        MenuModel::where('id', $menuId)->save(['location' => $location]);

        return true;
    }

    /**
     * Add new item to menu
     *
     * Creates menu item with next available sort order. Validates menu
     * exists and required fields (title, url) are provided.
     *
     * @param array $data Input data (menu_id, title, url, parent_id, target, css_classes)
     * @return int Created menu item ID
     * @throws ServiceException If menu not found or required fields missing
     */
    public static function addItem($data)
    {
        // Validate required fields
        if (empty($data['menu_id'])) {
            throw new ServiceException('Menu ID is required.');
        }

        if (empty($data['title'])) {
            throw new ServiceException('Menu item title is required.');
        }

        if (empty($data['url'])) {
            throw new ServiceException('Menu item URL is required.');
        }

        // Verify menu exists
        $menu = MenuModel::where('id', $data['menu_id'])->first();
        if (!$menu) {
            throw new ServiceException('Menu not found.');
        }

        // Get max sort order for this menu
        $maxSort = MenuItemModel::where('menu_id', $data['menu_id'])->max('sort_order');
        $nextSort = $maxSort ? $maxSort + 1 : 0;

        // Create menu item
        $itemId = MenuItemModel::save([
            'menu_id' => $data['menu_id'],
            'parent_id' => !empty($data['parent_id']) ? $data['parent_id'] : null,
            'title' => $data['title'],
            'url' => $data['url'],
            'target' => $data['target'] ?? '_self',
            'css_classes' => $data['css_classes'] ?? null,
            'sort_order' => $nextSort,
            'status' => 'active'
        ]);

        return $itemId;
    }

    /**
     * Update menu item
     *
     * Updates item properties (title, url, target, css_classes). Validates
     * item exists.
     *
     * @param int $id Menu item ID to update
     * @param array $data Updated data (title, url, target, css_classes)
     * @return bool True on successful update
     * @throws ServiceException If item not found
     */
    public static function updateItem($id, $data)
    {
        // Fetch item to update
        $item = MenuItemModel::where('id', $id)->first();

        if (!$item) {
            throw new ServiceException('Menu item not found.');
        }

        // Update item fields
        MenuItemModel::where('id', $id)->save([
            'title' => $data['title'] ?? $item['title'],
            'url' => $data['url'] ?? $item['url'],
            'target' => $data['target'] ?? $item['target'],
            'css_classes' => $data['css_classes'] ?? $item['css_classes']
        ]);

        return true;
    }

    /**
     * Delete menu item
     *
     * Removes item from menu. Child items are NOT automatically removed
     * (no CASCADE on parent_id foreign key).
     *
     * @param int $id Menu item ID to delete
     * @return bool True on successful deletion
     * @throws ServiceException If item not found
     */
    public static function deleteItem($id)
    {
        // Fetch item to delete
        $item = MenuItemModel::where('id', $id)->first();

        if (!$item) {
            throw new ServiceException('Menu item not found.');
        }

        // Delete item
        MenuItemModel::deleteById($id);

        return true;
    }

    /**
     * Reorder menu items
     *
     * Updates sort_order for multiple items based on new positions.
     * Accepts array of item IDs in desired order.
     *
     * @param array $itemIds Array of item IDs in desired order
     * @return bool True on successful reorder
     * @throws ServiceException If itemIds invalid
     */
    public static function reorderItems($itemIds)
    {
        // Validate input is array
        if (!is_array($itemIds)) {
            throw new ServiceException('Invalid item IDs. Expected array.');
        }

        // Update sort order for each item
        foreach ($itemIds as $index => $itemId) {
            MenuItemModel::where('id', $itemId)->save(['sort_order' => $index]);
        }

        return true;
    }

    /**
     * Save entire menu structure
     *
     * Replaces all menu items for a menu with new structure. Deletes
     * existing items and inserts new ones. Use for drag-and-drop
     * menu builders that send complete menu structure.
     *
     * @param int $menuId Menu ID
     * @param array $items Array of menu items with structure data
     * @return bool True on successful save
     * @throws ServiceException If menu not found or items invalid
     */
    public static function saveStructure($menuId, $items)
    {
        // Validate menu ID provided
        if (empty($menuId)) {
            throw new ServiceException('Menu ID is required.');
        }

        // Verify menu exists
        $menu = MenuModel::where('id', $menuId)->first();
        if (!$menu) {
            throw new ServiceException('Menu not found.');
        }

        // Validate items is array
        if (!is_array($items)) {
            throw new ServiceException('Invalid items data. Expected array.');
        }

        // Delete all existing items for this menu
        MenuItemModel::where('menu_id', $menuId)->delete();

        // Insert new items with correct order
        foreach ($items as $item) {
            MenuItemModel::save([
                'menu_id' => $menuId,
                'parent_id' => $item['parent_id'] ?? null,
                'title' => $item['title'],
                'url' => $item['url'],
                'target' => $item['target'] ?? '_self',
                'css_classes' => $item['css_classes'] ?? null,
                'sort_order' => $item['sort_order'],
                'status' => 'active'
            ]);
        }

        return true;
    }

    /**
     * Get all active menus with item counts
     *
     * Fetches all menus with status='active', ordered by creation date.
     * Adds item_count field to each menu showing number of active items.
     *
     * @return array Array of menu records with item counts
     */
    public static function getAll()
    {
        // Fetch all active menus
        $menus = MenuModel::select(['id', 'name', 'slug', 'location', 'status'])
            ->where('status', 'active')
            ->order('created_at', 'asc')
            ->all();

        // Add item count to each menu
        foreach ($menus as $key => $menu) {
            $menus[$key]['item_count'] = MenuItemModel::where('menu_id', $menu['id'])
                ->where('status', 'active')
                ->count();
        }

        return $menus;
    }

    /**
     * Get single menu by ID
     *
     * Fetches menu matching ID. Used for loading menu details in edit forms.
     *
     * @param int $id Menu ID
     * @return array|null Menu record or null if not found
     */
    public static function getById($id)
    {
        return MenuModel::where('id', $id)->first();
    }

    /**
     * Get menu items for specific menu
     *
     * Fetches all active items for a menu, ordered by sort_order.
     * Used for displaying menu structure in editor and frontend rendering.
     *
     * @param int $menuId Menu ID
     * @return array Array of menu item records
     */
    public static function getMenuItems($menuId)
    {
        return MenuItemModel::select([
                'id', 'menu_id', 'parent_id', 'title', 'url',
                'target', 'css_classes', 'sort_order', 'status'
            ])
            ->where('menu_id', $menuId)
            ->where('status', 'active')
            ->order('sort_order', 'asc')
            ->all();
    }

    /**
     * Generate URL-friendly slug from name
     *
     * Converts menu name to lowercase, replaces spaces with hyphens,
     * and removes special characters (keeps only a-z, 0-9, hyphens).
     *
     * @param string $name Menu name to convert to slug
     * @return string URL-friendly slug
     */
    private static function generateSlug($name)
    {
        // Convert to lowercase
        $slug = strtolower($name);

        // Replace spaces with hyphens
        $slug = str_replace(' ', '-', $slug);

        // Remove special characters (keep alphanumeric and hyphens)
        $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);

        // Remove multiple consecutive hyphens
        $slug = preg_replace('/-+/', '-', $slug);

        // Trim hyphens from start and end
        $slug = trim($slug, '-');

        return $slug;
    }

    /**
     * Sanitize user-provided slug
     *
     * Ensures slug contains only valid URL-friendly characters by converting to
     * lowercase, removing invalid characters (keeps only a-z, 0-9, hyphens),
     * collapsing consecutive hyphens, and trimming hyphens from start and end.
     *
     * @param string $slug User-provided slug to sanitize
     * @return string Sanitized slug containing only valid characters
     */
    private static function sanitizeSlug($slug)
    {
        // Convert to lowercase
        $slug = strtolower($slug);

        // Remove invalid characters (keep alphanumeric and hyphens)
        $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);

        // Remove multiple consecutive hyphens
        $slug = preg_replace('/-+/', '-', $slug);

        // Trim hyphens from start and end
        $slug = trim($slug, '-');

        return $slug;
    }
}

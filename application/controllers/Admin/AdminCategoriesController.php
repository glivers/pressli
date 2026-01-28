<?php namespace Controllers\Admin;

/**
 * Categories Controller - Pressli CMS
 *
 * Manages post categories (hierarchical taxonomies). Handles creating, editing,
 * and deleting categories with parent-child relationships. All state-changing
 * operations are CSRF-protected. Business logic delegated to Taxonomy service.
 *
 * Routes (automatic URL-based routing):
 * - GET  /admin/categories           List all categories
 * - GET  /admin/categories/new       Display category creation form
 * - POST /admin/categories/new       Process new category creation
 * - GET  /admin/categories/edit/{id} Display category edit form
 * - POST /admin/categories/edit/{id} Process category update
 * - GET  /admin/categories/delete/{id} Soft delete category
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */

use Rackage\Csrf;
use Rackage\View;
use Rackage\Input;
use Rackage\Session;
use Rackage\Redirect;
use Lib\LibException;
use Lib\Services\Taxonomy;
use Controllers\Admin\AdminController;

class AdminCategoriesController extends AdminController
{
    /**
     * Display list of all categories
     *
     * Fetches all non-deleted categories ordered by name. Shows hierarchical
     * structure with parent-child relationships in the view.
     *
     * @return void
     */
    public function getIndex()
    {
        // Get all categories from service
        $categories = Taxonomy::getAll('category');

        // Get total count for statistics display
        $totalCount = Taxonomy::count('category');

        // Array of data to send to view
        $data = [
            'title' => 'Categories',
            'categories' => $categories,
            'totalCount' => $totalCount,
            'settings' => $this->settings
        ];

        View::render('admin/categories', $data);
    }

    /**
     * Display form to create new category
     *
     * Loads all existing categories for parent selection dropdown.
     * Parent dropdown allows creating hierarchical category structure.
     *
     * @return void
     */
    public function getNew()
    {
        // Get all categories for parent dropdown
        $categories = Taxonomy::getAll('category');

        // Array of data to send to view
        $data = [
            'title' => 'New Category',
            'categories' => $categories,
            'settings' => $this->settings
        ];

        View::render('admin/categories-new', $data);
    }

    /**
     * Process new category creation
     *
     * Validates CSRF token, delegates creation to Taxonomy service which handles
     * validation, slug generation, uniqueness checking, and database insertion.
     *
     * @return void Redirects to /admin/categories on success, back on error
     */
    public function postNew()
    {
        // Verify CSRF token
        if (!Csrf::verify()) {
            Session::flash('error', 'Invalid security token. Please try again.');
            Redirect::back();
        }

        try {
            // Create category via service
            $categoryId = Taxonomy::create(Input::post(), 'category');

            // Success - redirect to list
            Session::flash('success', 'Category created successfully!');
            Redirect::to('admin/categories');
        }
        catch (LibException $e) {
            // Validation or business logic error
            Session::flash('error', $e->getMessage());
            Redirect::back();
        }
    }

    /**
     * Display form to edit category
     *
     * Loads category data and all other categories for parent selection.
     * Excludes current category from parent dropdown to prevent circular relationships.
     *
     * @param int $id Category ID from URL
     * @return void
     */
    public function getEdit($id)
    {
        // Get category to edit
        $category = Taxonomy::getById($id, 'category');

        if (!$category) {
            Session::flash('error', 'Category not found.');
            Redirect::to('admin/categories');
        }

        // Get all categories except current one for parent dropdown
        $categories = Taxonomy::getAllExcept('category', $id);

        // Array of data to send to view
        $data = [
            'title' => 'Edit Category',
            'category' => $category,
            'categories' => $categories,
            'settings' => $this->settings
        ];

        View::render('admin/categories-edit', $data);
    }

    /**
     * Process category edit
     *
     * Validates CSRF token, delegates update to Taxonomy service which handles
     * validation, slug sanitization, uniqueness checking, circular parent prevention,
     * and database update.
     *
     * @param int $id Category ID from URL
     * @return void Redirects to /admin/categories on success, back on error
     */
    public function postEdit($id)
    {
        // Verify CSRF token
        if (!Csrf::verify()) {
            Session::flash('error', 'Invalid security token. Please try again.');
            Redirect::back();
        }

        try {
            // Update category via service
            Taxonomy::update($id, Input::post(), 'category');

            // Success - redirect to list
            Session::flash('success', 'Category updated successfully!');
            Redirect::to('admin/categories');
        }
        catch (LibException $e) {
            // Validation or business logic error
            Session::flash('error', $e->getMessage());
            Redirect::back();
        }
    }

    /**
     * Soft delete category (move to trash)
     *
     * Delegates deletion to Taxonomy service which sets deleted_at timestamp.
     * Child categories become orphaned (parent_id remains but points to deleted category).
     * Posts remain associated but category won't show in queries filtering deleted_at.
     *
     * @param int $id Category ID from URL
     * @return void Redirects to /admin/categories with status message
     */
    public function getDelete($id)
    {
        try {
            // Soft delete via service
            Taxonomy::delete($id, 'category');

            // Success - redirect to list
            Session::flash('success', 'Category moved to trash.');
            Redirect::to('admin/categories');
        }
        catch (LibException $e) {
            // Category not found
            Session::flash('error', $e->getMessage());
            Redirect::to('admin/categories');
        }
    }
}

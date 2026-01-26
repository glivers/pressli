<?php namespace Controllers;

/**
 * API Categories Controller - Pressli CMS
 *
 * REST API endpoint for managing categories via Bearer token authentication.
 * Reuses Taxonomy service for business logic, returns JSON responses instead
 * of HTML. All state-changing operations require valid Bearer token (verified
 * in ApiController constructor).
 *
 * Routes (automatic URL-based routing):
 * - GET  /api/categories           List all categories
 * - GET  /api/categories/show/{id} Show single category
 * - POST /api/categories/create    Create new category
 * - POST /api/categories/update/{id} Update category
 * - POST /api/categories/delete/{id} Delete category
 *
 * Authentication: Bearer token in Authorization header (handled by ApiController)
 * Input: JSON body parsed into Input class (handled by ApiController)
 * CSRF: Bypassed for API requests (session flag set in ApiController)
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */

use Rackage\View;
use Rackage\Input;
use Lib\Services\Taxonomy;
use Controllers\ApiController;
use Lib\Exceptions\ServiceException;

class ApiCategoriesController extends ApiController
{
    /**
     * List all categories with metadata
     *
     * Returns all non-deleted categories ordered by name with total count.
     * Useful for populating dropdowns, navigation menus, or category browsers
     * in headless CMS integrations.
     *
     * @return void JSON response with categories array and total count
     */
    public function getIndex()
    {
        // Get all categories from service
        $categories = Taxonomy::getAll('category');

        // Get total count for metadata
        $totalCount = Taxonomy::count('category');

        // Return JSON response with data and metadata
        View::json([
            'success' => true,
            'data' => $categories,
            'meta' => [
                'total' => $totalCount
            ]
        ], 200);
    }

    /**
     * Show single category by ID
     *
     * Returns category details including parent_id, description, slug, and
     * post_count. Returns 404 if category not found or deleted.
     *
     * @param int $id Category ID from URL
     * @return void JSON response with category data or error
     */
    public function getShow($id)
    {
        // Get category by ID (excludes deleted)
        $category = Taxonomy::getById($id, 'category');

        if (!$category) {
            View::json([
                'success' => false,
                'error' => 'Category not found',
                'message' => 'The category you requested does not exist or has been deleted'
            ], 404);
            return;
        }

        // Return category data
        View::json([
            'success' => true,
            'data' => $category
        ], 200);
    }

    /**
     * Create new category from JSON input
     *
     * Validates input, generates slug if not provided, checks uniqueness,
     * and creates category record. Returns created category ID and data.
     *
     * Expected JSON body:
     * {
     *   "name": "Technology",
     *   "slug": "tech",           // optional - auto-generated from name if empty
     *   "description": "...",     // optional
     *   "parent_id": 5            // optional - for hierarchical categories
     * }
     *
     * @return void JSON response with created category ID or validation errors
     */
    public function postCreate()
    {
        try {
            // Create category via service (validates, generates slug, checks uniqueness)
            $categoryId = Taxonomy::create(Input::post(), 'category');

            // Get created category data for response
            $category = Taxonomy::getById($categoryId, 'category');

            // Return success with created resource
            View::json([
                'success' => true,
                'message' => 'Category created successfully',
                'data' => $category
            ], 201);
        }
        catch (ServiceException $e) {
            // Validation or business logic error (user-friendly message)
            View::json([
                'success' => false,
                'error' => 'Validation failed',
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Update existing category
     *
     * Validates input, sanitizes slug, checks uniqueness excluding current
     * record, prevents circular parent relationships, and updates category.
     *
     * Expected JSON body (all fields optional):
     * {
     *   "name": "Updated Name",
     *   "slug": "updated-slug",
     *   "description": "...",
     *   "parent_id": 3
     * }
     *
     * @param int $id Category ID from URL
     * @return void JSON response with updated category or validation errors
     */
    public function postUpdate($id)
    {
        try {
            // Update category via service (validates, checks uniqueness, prevents circular parent)
            Taxonomy::update($id, Input::post(), 'category');

            // Get updated category data for response
            $category = Taxonomy::getById($id, 'category');

            // Return success with updated resource
            View::json([
                'success' => true,
                'message' => 'Category updated successfully',
                'data' => $category
            ], 200);
        }
        catch (ServiceException $e) {
            // Validation or business logic error (user-friendly message)
            View::json([
                'success' => false,
                'error' => 'Validation failed',
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Soft delete category (move to trash)
     *
     * Sets deleted_at timestamp on category record. Child categories become
     * orphaned (parent_id remains but points to deleted category). Posts
     * remain associated but category won't appear in queries filtering
     * deleted_at.
     *
     * @param int $id Category ID from URL
     * @return void JSON response with success message or error
     */
    public function postDelete($id)
    {
        try {
            // Soft delete via service (sets deleted_at timestamp)
            Taxonomy::delete($id, 'category');

            // Return success message
            View::json([
                'success' => true,
                'message' => 'Category moved to trash'
            ], 200);
        }
        catch (ServiceException $e) {
            // Category not found or already deleted
            View::json([
                'success' => false,
                'error' => 'Delete failed',
                'message' => $e->getMessage()
            ], 404);
        }
    }
}

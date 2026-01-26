<?php namespace Controllers;

/**
 * API Pages Controller - Pressli CMS
 *
 * REST API endpoint for managing static pages via Bearer token authentication.
 * Reuses Page service for business logic, returns JSON responses instead
 * of HTML. All state-changing operations require valid Bearer token (verified
 * in ApiController constructor).
 *
 * Routes (automatic URL-based routing):
 * - GET  /api/pages           List all pages with optional status filter
 * - GET  /api/pages/show/{id} Show single page
 * - POST /api/pages/create    Create new page
 * - POST /api/pages/update/{id} Update page metadata
 * - POST /api/pages/delete/{id} Soft delete page
 *
 * Authentication: Bearer token in Authorization header (handled by ApiController)
 * Input: JSON body for create/update, query params for filters
 * CSRF: Bypassed for API requests (session flag set in ApiController)
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */

use Rackage\View;
use Rackage\Input;
use Rackage\Session;
use Lib\Services\Page;
use Controllers\ApiController;
use Lib\Exceptions\ServiceException;

class ApiPagesController extends ApiController
{
    /**
     * List all pages with optional status filter
     *
     * Returns all pages with author info, filtered by status if provided
     * via query parameter. Supports filtering by published, draft, or trash.
     * Includes status counts for dashboard widgets.
     *
     * Query parameters:
     * - status (optional): published, draft, trash
     *
     * @return void JSON response with pages array and status counts
     */
    public function getIndex()
    {
        // Get status filter from query string
        $status = Input::get('status');

        // Get all pages with optional status filter
        $pages = Page::getAll($status);

        // Get status counts for metadata
        $statusCounts = Page::getStatusCounts();

        // Return JSON response with data and metadata
        View::json([
            'success' => true,
            'data' => $pages,
            'meta' => [
                'counts' => $statusCounts
            ]
        ], 200);
    }

    /**
     * Show single page by ID
     *
     * Returns page details including title, slug, content, template,
     * parent relationship, featured image, and metadata. Returns 404
     * if page not found or deleted.
     *
     * @param int $id Page ID from URL
     * @return void JSON response with page data or error
     */
    public function getShow($id)
    {
        // Get page by ID (excludes deleted)
        $page = Page::getById($id);

        if (!$page) {
            View::json([
                'success' => false,
                'error' => 'Page not found',
                'message' => 'The page you requested does not exist or has been deleted'
            ], 404);
            return;
        }

        // Return page data
        View::json([
            'success' => true,
            'data' => $page
        ], 200);
    }

    /**
     * Create new page
     *
     * Validates input, auto-generates slug from title if not provided,
     * checks slug uniqueness, handles publication status, and creates
     * page with optional parent relationship and template. Author is
     * current authenticated user.
     *
     * Expected JSON body:
     * {
     *   "title": "About Us",
     *   "slug": "about-us",                  // Optional, auto-generated if not provided
     *   "content": "Page content...",
     *   "excerpt": "Page excerpt...",        // Optional
     *   "template": "default",               // Optional, defaults to 'default'
     *   "parent_id": 5,                      // Optional
     *   "status": "published",               // Optional, defaults to 'draft'
     *   "meta_title": "SEO title",           // Optional
     *   "meta_description": "SEO desc",      // Optional
     *   "featured_image_id": 10              // Optional
     * }
     *
     * @return void JSON response with created page data or validation errors
     */
    public function postCreate()
    {
        try {
            // Prepare page data from JSON body
            $data = [
                'title' => Input::post('title'),
                'slug' => Input::post('slug'),
                'content' => Input::post('content'),
                'excerpt' => Input::post('excerpt'),
                'template' => Input::post('template'),
                'parent_id' => Input::post('parent_id'),
                'status' => Input::post('status'),
                'meta_title' => Input::post('meta_title'),
                'meta_description' => Input::post('meta_description'),
                'featured_image_id' => Input::post('featured_image_id')
            ];

            // Create page via service (author is authenticated API user)
            $pageId = Page::create($data, Session::get('user_id'));

            // Get created page for response
            $page = Page::getById($pageId);

            // Return success with created page data
            View::json([
                'success' => true,
                'message' => 'Page created successfully',
                'data' => $page
            ], 201);
        }
        catch (ServiceException $e) {
            // Validation or business logic error (user-friendly message)
            View::json([
                'success' => false,
                'error' => 'Creation failed',
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Update page metadata
     *
     * Updates page information including title, slug, content, template,
     * parent relationship, status, and metadata. Validates slug uniqueness
     * excluding current page. Prevents circular parent relationships.
     *
     * Expected JSON body (all fields optional):
     * {
     *   "title": "Updated Title",
     *   "slug": "updated-slug",
     *   "content": "Updated content...",
     *   "excerpt": "Updated excerpt...",
     *   "template": "full-width",
     *   "parent_id": 3,
     *   "status": "published",
     *   "meta_title": "Updated SEO title",
     *   "meta_description": "Updated SEO desc",
     *   "featured_image_id": 15
     * }
     *
     * @param int $id Page ID from URL
     * @return void JSON response with updated page or error
     */
    public function postUpdate($id)
    {
        try {
            // Prepare page data from JSON body
            $data = [
                'title' => Input::post('title'),
                'slug' => Input::post('slug'),
                'content' => Input::post('content'),
                'excerpt' => Input::post('excerpt'),
                'template' => Input::post('template'),
                'parent_id' => Input::post('parent_id'),
                'status' => Input::post('status'),
                'meta_title' => Input::post('meta_title'),
                'meta_description' => Input::post('meta_description'),
                'featured_image_id' => Input::post('featured_image_id')
            ];

            // Update page via service
            Page::update($id, $data);

            // Get updated page data for response
            $page = Page::getById($id);

            // Return success with updated resource
            View::json([
                'success' => true,
                'message' => 'Page updated successfully',
                'data' => $page
            ], 200);
        }
        catch (ServiceException $e) {
            // Page not found or validation error
            View::json([
                'success' => false,
                'error' => 'Update failed',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Soft delete page (move to trash)
     *
     * Sets deleted_at timestamp on page record. Child pages remain but
     * parent reference is maintained. Page won't appear in queries that
     * filter whereNull('deleted_at').
     *
     * @param int $id Page ID from URL
     * @return void JSON response with success message or error
     */
    public function postDelete($id)
    {
        try {
            // Soft delete via service
            Page::delete($id);

            // Return success message
            View::json([
                'success' => true,
                'message' => 'Page moved to trash'
            ], 200);
        }
        catch (ServiceException $e) {
            // Page not found or already deleted
            View::json([
                'success' => false,
                'error' => 'Delete failed',
                'message' => $e->getMessage()
            ], 404);
        }
    }
}

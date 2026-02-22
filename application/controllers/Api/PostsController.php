<?php namespace Controllers\Api;

/**
 * API Posts Controller - Pressli CMS
 *
 * REST API endpoint for managing blog posts via Bearer token authentication.
 * Reuses Post service for business logic, returns JSON responses instead
 * of HTML. All state-changing operations require valid Bearer token (verified
 * in ApiController constructor).
 *
 * Routes (automatic URL-based routing):
 * - GET  /api/posts           List all posts with optional status filter
 * - GET  /api/posts/show/{id} Show single post with full details
 * - POST /api/posts/create    Create new post
 * - POST /api/posts/update/{id} Update existing post
 * - POST /api/posts/delete/{id} Soft delete post
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
use Rackage\Session;
use Lib\Services\Post;
use Controllers\Api\ApiController;
use Lib\Exceptions\ServiceException;

class ApiPostsController extends ApiController
{
    /**
     * List all posts with optional status filter
     *
     * Returns all posts with author names and categories. Supports filtering
     * by status (published/draft/scheduled/trash) via query parameter. Includes
     * status counts for dashboard widgets.
     *
     * Query parameters:
     * - status (optional): published, draft, scheduled, trash
     *
     * @return void JSON response with posts array and status counts
     */
    public function getIndex()
    {
        // Get status filter from query string
        $status = Input::get('status');

        // Get all posts with optional status filter
        $posts = Post::getAll('post', $status);

        // Get status counts for metadata
        $statusCounts = Post::getStatusCounts();

        // Return JSON response with data and metadata
        View::json([
            'success' => true,
            'data' => $posts,
            'meta' => [
                'counts' => $statusCounts
            ]
        ], 200);
    }

    /**
     * Show single post by ID
     *
     * Returns post details including content, metadata, author info, featured
     * image, and assigned categories. Returns 404 if post not found or deleted.
     *
     * @param int $id Post ID from URL
     * @return void JSON response with post data or error
     */
    public function getShow($id)
    {
        // Get post by ID with featured image (excludes deleted)
        $post = Post::getById($id);

        if (!$post) {
            View::json([
                'success' => false,
                'error' => 'Post not found',
                'message' => 'The post you requested does not exist or has been deleted'
            ], 404);
            return;
        }

        // Get post's assigned category IDs
        $post['category_ids'] = Post::getPostCategories($id);

        // Return post data
        View::json([
            'success' => true,
            'data' => $post
        ], 200);
    }

    /**
     * Create new post from JSON input
     *
     * Validates input, generates slug if not provided, checks uniqueness,
     * handles published_at based on status, and creates post record with
     * category relationships. Author is current authenticated user.
     *
     * Expected JSON body:
     * {
     *   "title": "Post Title",
     *   "slug": "custom-slug",           // optional - auto-generated from title
     *   "content": "Post content...",
     *   "excerpt": "Brief summary",      // optional
     *   "status": "draft",               // draft|published|scheduled (default: draft)
     *   "visibility": "public",          // public|private|password (default: public)
     *   "published_at": "2024-12-31",    // required if status=scheduled
     *   "allow_comments": true,          // boolean (default: false)
     *   "meta_title": "SEO title",       // optional
     *   "meta_description": "SEO desc",  // optional
     *   "featured_image_id": 123,        // optional - media ID
     *   "categories": [1, 2, 3]          // optional - taxonomy IDs
     * }
     *
     * @return void JSON response with created post ID or validation errors
     */
    public function postCreate()
    {
        try {
            // Prepare post data from JSON body
            $data = [
                'title' => Input::post('title'),
                'slug' => Input::post('slug'),
                'content' => Input::post('content'),
                'excerpt' => Input::post('excerpt'),
                'type' => 'post',
                'status' => Input::post('status', 'draft'),
                'visibility' => Input::post('visibility', 'public'),
                'allow_comments' => Input::post('allow_comments') ? 1 : 0,
                'meta_title' => Input::post('meta_title'),
                'meta_description' => Input::post('meta_description'),
                'featured_image_id' => Input::post('featured_image_id'),
                'published_at' => Input::post('published_at'),
                'categories' => Input::post('categories')
            ];

            // Create post via service (author is authenticated API user)
            $postId = Post::create($data, Session::get('user_id'));

            // Get created post data for response
            $post = Post::getById($postId);
            $post['category_ids'] = Post::getPostCategories($postId);

            // Return success with created resource
            View::json([
                'success' => true,
                'message' => 'Post created successfully',
                'data' => $post
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
     * Update existing post
     *
     * Validates input, sanitizes slug, checks uniqueness excluding current
     * record, handles status transitions and published_at, updates post
     * record, and syncs category relationships.
     *
     * Expected JSON body (all fields optional):
     * {
     *   "title": "Updated Title",
     *   "slug": "updated-slug",
     *   "content": "Updated content...",
     *   "excerpt": "Updated summary",
     *   "status": "published",
     *   "visibility": "public",
     *   "published_at": "2024-12-31",
     *   "allow_comments": false,
     *   "meta_title": "Updated SEO title",
     *   "meta_description": "Updated SEO desc",
     *   "featured_image_id": 456,
     *   "categories": [2, 3, 4]
     * }
     *
     * @param int $id Post ID from URL
     * @return void JSON response with updated post or validation errors
     */
    public function postUpdate($id)
    {
        try {
            // Prepare post data from JSON body
            $data = [
                'title' => Input::post('title'),
                'slug' => Input::post('slug'),
                'content' => Input::post('content'),
                'excerpt' => Input::post('excerpt'),
                'type' => 'post',
                'status' => Input::post('status', 'draft'),
                'visibility' => Input::post('visibility', 'public'),
                'allow_comments' => Input::post('allow_comments') ? 1 : 0,
                'meta_title' => Input::post('meta_title'),
                'meta_description' => Input::post('meta_description'),
                'featured_image_id' => Input::post('featured_image_id'),
                'published_at' => Input::post('published_at'),
                'categories' => Input::post('categories')
            ];

            // Update post via service
            Post::update($id, $data);

            // Get updated post data for response
            $post = Post::getById($id);
            $post['category_ids'] = Post::getPostCategories($id);

            // Return success with updated resource
            View::json([
                'success' => true,
                'message' => 'Post updated successfully',
                'data' => $post
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
     * Soft delete post (move to trash)
     *
     * Sets deleted_at timestamp on post record. Post won't appear in queries
     * that filter whereNull('deleted_at'). Can be restored later.
     *
     * @param int $id Post ID from URL
     * @return void JSON response with success message or error
     */
    public function postDelete($id)
    {
        try {
            // Soft delete via service
            Post::delete($id);

            // Return success message
            View::json([
                'success' => true,
                'message' => 'Post moved to trash'
            ], 200);
        }
        catch (ServiceException $e) {
            // Post not found or already deleted
            View::json([
                'success' => false,
                'error' => 'Delete failed',
                'message' => $e->getMessage()
            ], 404);
        }
    }
}

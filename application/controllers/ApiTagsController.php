<?php namespace Controllers;

/**
 * API Tags Controller - Pressli CMS
 *
 * REST API endpoint for managing post tags via Bearer token authentication.
 * Reuses Tag service for business logic, returns JSON responses instead
 * of HTML. All state-changing operations require valid Bearer token (verified
 * in ApiController constructor).
 *
 * Routes (automatic URL-based routing):
 * - GET  /api/tags           List all tags
 * - GET  /api/tags/show/{id} Show single tag
 * - POST /api/tags/create    Create new tag
 * - POST /api/tags/update/{id} Update tag metadata
 * - POST /api/tags/delete/{id} Soft delete tag
 *
 * Authentication: Bearer token in Authorization header (handled by ApiController)
 * Input: JSON body for create/update
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

class ApiTagsController extends ApiController
{
    /**
     * List all tags
     *
     * Returns all non-deleted tags ordered by name. Includes total count
     * for metadata.
     *
     * @return void JSON response with tags array and total count
     */
    public function getIndex()
    {
        // Get all tags and total count
        $tags = Taxonomy::getAll('tag');
        $totalCount = Taxonomy::count('tag');

        // Return JSON response with data and metadata
        View::json([
            'success' => true,
            'data' => $tags,
            'meta' => [
                'total_count' => $totalCount
            ]
        ], 200);
    }

    /**
     * Show single tag by ID
     *
     * Returns tag details including name, slug, description, and post count.
     * Returns 404 if tag not found or deleted.
     *
     * @param int $id Tag ID from URL
     * @return void JSON response with tag data or error
     */
    public function getShow($id)
    {
        // Get tag by ID (excludes deleted)
        $tag = Taxonomy::getById($id, 'tag');

        if (!$tag) {
            View::json([
                'success' => false,
                'error' => 'Tag not found',
                'message' => 'The tag you requested does not exist or has been deleted'
            ], 404);
            return;
        }

        // Return tag data
        View::json([
            'success' => true,
            'data' => $tag
        ], 200);
    }

    /**
     * Create new tag
     *
     * Validates input, auto-generates slug from name if not provided,
     * checks slug uniqueness, and creates tag.
     *
     * Expected JSON body:
     * {
     *   "name": "Technology",
     *   "slug": "technology",           // Optional, auto-generated if not provided
     *   "description": "Tech articles"  // Optional
     * }
     *
     * @return void JSON response with created tag data or validation errors
     */
    public function postCreate()
    {
        try {
            // Prepare tag data from JSON body
            $data = [
                'name' => Input::post('name'),
                'slug' => Input::post('slug'),
                'description' => Input::post('description')
            ];

            // Create tag via service
            $tagId = Taxonomy::create($data, 'tag');

            // Get created tag for response
            $tag = Taxonomy::getById($tagId, 'tag');

            // Return success with created tag data
            View::json([
                'success' => true,
                'message' => 'Tag created successfully',
                'data' => $tag
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
     * Update tag metadata
     *
     * Updates tag name, slug, or description. Validates slug uniqueness
     * excluding current tag. All fields are optional - only provided
     * fields are updated.
     *
     * Expected JSON body (all fields optional):
     * {
     *   "name": "Updated Name",
     *   "slug": "updated-slug",
     *   "description": "Updated description"
     * }
     *
     * @param int $id Tag ID from URL
     * @return void JSON response with updated tag or error
     */
    public function postUpdate($id)
    {
        try {
            // Prepare tag data from JSON body
            $data = [
                'name' => Input::post('name'),
                'slug' => Input::post('slug'),
                'description' => Input::post('description')
            ];

            // Update tag via service
            Taxonomy::update($id, $data, 'tag');

            // Get updated tag data for response
            $tag = Taxonomy::getById($id, 'tag');

            // Return success with updated resource
            View::json([
                'success' => true,
                'message' => 'Tag updated successfully',
                'data' => $tag
            ], 200);
        }
        catch (ServiceException $e) {
            // Tag not found or validation error
            View::json([
                'success' => false,
                'error' => 'Update failed',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Soft delete tag (move to trash)
     *
     * Sets deleted_at timestamp on tag record. Posts remain associated but
     * tag won't appear in queries that filter whereNull('deleted_at').
     *
     * @param int $id Tag ID from URL
     * @return void JSON response with success message or error
     */
    public function postDelete($id)
    {
        try {
            // Soft delete via service
            Taxonomy::delete($id, 'tag');

            // Return success message
            View::json([
                'success' => true,
                'message' => 'Tag moved to trash'
            ], 200);
        }
        catch (ServiceException $e) {
            // Tag not found or already deleted
            View::json([
                'success' => false,
                'error' => 'Delete failed',
                'message' => $e->getMessage()
            ], 404);
        }
    }
}

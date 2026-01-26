<?php namespace Controllers;

/**
 * API Media Controller - Pressli CMS
 *
 * REST API endpoint for managing media library via Bearer token authentication.
 * Reuses Media service for business logic, returns JSON responses instead
 * of HTML. All state-changing operations require valid Bearer token (verified
 * in ApiController constructor).
 *
 * Routes (automatic URL-based routing):
 * - GET  /api/media           List all media with optional type filter
 * - GET  /api/media/show/{id} Show single media item
 * - POST /api/media/upload    Upload new media file
 * - POST /api/media/update/{id} Update media metadata
 * - POST /api/media/delete/{id} Soft delete media
 *
 * Authentication: Bearer token in Authorization header (handled by ApiController)
 * Input: Multipart form-data for uploads, JSON for metadata updates
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
use Lib\Services\Media;
use Controllers\ApiController;
use Lib\Exceptions\ServiceException;

class ApiMediaController extends ApiController
{
    /**
     * List all media with optional type filter
     *
     * Returns all non-deleted media with author info. Supports filtering
     * by file type category (image/video/document/audio/other) via query
     * parameter. Includes type counts for dashboard widgets.
     *
     * Query parameters:
     * - type (optional): image, video, document, audio, other
     *
     * @return void JSON response with media array and type counts
     */
    public function getIndex()
    {
        // Get type filter from query string
        $type = Input::get('type');

        // Get all media with optional type filter
        $media = Media::getAll($type);

        // Get type counts for metadata
        $typeCounts = Media::getTypeCounts();

        // Return JSON response with data and metadata
        View::json([
            'success' => true,
            'data' => $media,
            'meta' => [
                'counts' => $typeCounts
            ]
        ], 200);
    }

    /**
     * Show single media item by ID
     *
     * Returns media details including filename, file path, type, MIME type,
     * file size, dimensions (for images), and metadata. Returns 404 if media
     * not found or deleted.
     *
     * @param int $id Media ID from URL
     * @return void JSON response with media data or error
     */
    public function getShow($id)
    {
        // Get media by ID (excludes deleted)
        $media = Media::getById($id);

        if (!$media) {
            View::json([
                'success' => false,
                'error' => 'Media not found',
                'message' => 'The media file you requested does not exist or has been deleted'
            ], 404);
            return;
        }

        // Return media data
        View::json([
            'success' => true,
            'data' => $media
        ], 200);
    }

    /**
     * Upload new media file
     *
     * Handles multipart form-data file upload. Validates file type and size,
     * stores in public/uploads/YYYY/MM/ with unique SHA1 filename, determines
     * file type category from MIME type, extracts image dimensions if applicable,
     * and saves metadata to database. Author is current authenticated user.
     *
     * Expected multipart/form-data:
     * - file: File to upload (required)
     *
     * Allowed types: jpg, jpeg, png, gif, webp, pdf, doc, docx, mp4, mp3, zip
     * Max size: 10MB
     *
     * @return void JSON response with media data or validation errors
     */
    public function postUpload()
    {
        try {
            // Upload file via service (author is authenticated API user)
            $media = Media::upload('file', Session::get('user_id'));

            // Return success with uploaded media data
            View::json([
                'success' => true,
                'message' => 'File uploaded successfully',
                'data' => $media
            ], 201);
        }
        catch (ServiceException $e) {
            // Upload failed or validation error (user-friendly message)
            View::json([
                'success' => false,
                'error' => 'Upload failed',
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Update media metadata
     *
     * Updates media title, alt text (for accessibility), and description without
     * modifying the physical file. Returns updated media data.
     *
     * Expected JSON body (all fields optional):
     * {
     *   "title": "Updated Title",
     *   "alt_text": "Image description for screen readers",
     *   "description": "Detailed description of media file"
     * }
     *
     * @param int $id Media ID from URL
     * @return void JSON response with updated media or error
     */
    public function postUpdate($id)
    {
        try {
            // Prepare metadata from JSON body
            $data = [
                'title' => Input::post('title'),
                'alt_text' => Input::post('alt_text'),
                'description' => Input::post('description')
            ];

            // Update media via service
            Media::update($id, $data);

            // Get updated media data for response
            $media = Media::getById($id);

            // Return success with updated resource
            View::json([
                'success' => true,
                'message' => 'Media updated successfully',
                'data' => $media
            ], 200);
        }
        catch (ServiceException $e) {
            // Media not found or validation error
            View::json([
                'success' => false,
                'error' => 'Update failed',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Soft delete media (move to trash)
     *
     * Sets deleted_at timestamp on media record. Physical file remains on disk
     * allowing for potential recovery. Media won't appear in library queries.
     *
     * @param int $id Media ID from URL
     * @return void JSON response with success message or error
     */
    public function postDelete($id)
    {
        try {
            // Soft delete via service
            Media::delete($id);

            // Return success message
            View::json([
                'success' => true,
                'message' => 'Media moved to trash'
            ], 200);
        }
        catch (ServiceException $e) {
            // Media not found or already deleted
            View::json([
                'success' => false,
                'error' => 'Delete failed',
                'message' => $e->getMessage()
            ], 404);
        }
    }
}

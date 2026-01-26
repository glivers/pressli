<?php namespace Controllers\Api;

/**
 * API Comments Controller - Pressli CMS
 *
 * REST API endpoint for comment moderation via Bearer token authentication.
 * Reuses Comment service for business logic, returns JSON responses instead
 * of HTML. All state-changing operations require valid Bearer token (verified
 * in ApiController constructor).
 *
 * Routes (automatic URL-based routing):
 * - GET  /api/comments           List all comments with optional status filter
 * - GET  /api/comments/show/{id} Show single comment
 * - POST /api/comments/approve/{id} Approve comment
 * - POST /api/comments/unapprove/{id} Unapprove comment
 * - POST /api/comments/spam/{id} Mark comment as spam
 * - POST /api/comments/delete/{id} Soft delete comment
 * - POST /api/comments/bulk      Bulk actions (approve, spam, trash)
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
use Lib\Services\Comment;
use Controllers\Api\ApiController;
use Lib\Exceptions\ServiceException;

class ApiCommentsController extends ApiController
{
    /**
     * List all comments with optional status filter
     *
     * Returns all non-deleted comments with post title. Supports filtering
     * by status (pending/approved/spam) via query parameter. Includes status
     * counts for dashboard widgets.
     *
     * Query parameters:
     * - status (optional): pending, approved, spam
     *
     * @return void JSON response with comments array and status counts
     */
    public function getIndex()
    {
        // Get status filter from query string
        $status = Input::get('status');

        // Get all comments with optional status filter
        $comments = Comment::getAll($status);

        // Get status counts for metadata
        $statusCounts = Comment::getStatusCounts();

        // Return JSON response with data and metadata
        View::json([
            'success' => true,
            'data' => $comments,
            'meta' => [
                'counts' => $statusCounts
            ]
        ], 200);
    }

    /**
     * Show single comment by ID
     *
     * Returns comment details including author info, content, status, and
     * timestamps. Returns 404 if comment not found or deleted.
     *
     * @param int $id Comment ID from URL
     * @return void JSON response with comment data or error
     */
    public function getShow($id)
    {
        // Get comment by ID (excludes deleted)
        $comment = Comment::getById($id);

        if (!$comment) {
            View::json([
                'success' => false,
                'error' => 'Comment not found',
                'message' => 'The comment you requested does not exist or has been deleted'
            ], 404);
            return;
        }

        // Return comment data
        View::json([
            'success' => true,
            'data' => $comment
        ], 200);
    }

    /**
     * Approve a pending comment
     *
     * Changes status from pending to approved, making comment visible on
     * public site. Returns updated comment data.
     *
     * @param int $id Comment ID from URL
     * @return void JSON response with success message or error
     */
    public function postApprove($id)
    {
        try {
            // Approve comment via service
            Comment::approve($id);

            // Get updated comment for response
            $comment = Comment::getById($id);

            // Return success with updated resource
            View::json([
                'success' => true,
                'message' => 'Comment approved successfully',
                'data' => $comment
            ], 200);
        }
        catch (ServiceException $e) {
            // Comment not found
            View::json([
                'success' => false,
                'error' => 'Approval failed',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Unapprove an approved comment
     *
     * Changes status from approved to pending, hiding comment from public
     * site. Returns updated comment data.
     *
     * @param int $id Comment ID from URL
     * @return void JSON response with success message or error
     */
    public function postUnapprove($id)
    {
        try {
            // Unapprove comment via service
            Comment::unapprove($id);

            // Get updated comment for response
            $comment = Comment::getById($id);

            // Return success with updated resource
            View::json([
                'success' => true,
                'message' => 'Comment unapproved successfully',
                'data' => $comment
            ], 200);
        }
        catch (ServiceException $e) {
            // Comment not found
            View::json([
                'success' => false,
                'error' => 'Unapproval failed',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Mark comment as spam
     *
     * Changes status to spam, hiding comment from both public site and
     * normal admin views. Returns updated comment data.
     *
     * @param int $id Comment ID from URL
     * @return void JSON response with success message or error
     */
    public function postSpam($id)
    {
        try {
            // Mark comment as spam via service
            Comment::markAsSpam($id);

            // Get updated comment for response
            $comment = Comment::getById($id);

            // Return success with updated resource
            View::json([
                'success' => true,
                'message' => 'Comment marked as spam',
                'data' => $comment
            ], 200);
        }
        catch (ServiceException $e) {
            // Comment not found
            View::json([
                'success' => false,
                'error' => 'Spam marking failed',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Soft delete comment (move to trash)
     *
     * Sets deleted_at timestamp on comment record. Comment won't appear in
     * any status views but can be restored later.
     *
     * @param int $id Comment ID from URL
     * @return void JSON response with success message or error
     */
    public function postDelete($id)
    {
        try {
            // Soft delete via service
            Comment::delete($id);

            // Return success message
            View::json([
                'success' => true,
                'message' => 'Comment moved to trash'
            ], 200);
        }
        catch (ServiceException $e) {
            // Comment not found or already deleted
            View::json([
                'success' => false,
                'error' => 'Delete failed',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Process bulk actions on selected comments
     *
     * Handles mass approve, mark as spam, or delete operations. Processes
     * array of comment IDs from request body. Returns count of affected items.
     *
     * Expected JSON body:
     * {
     *   "action": "approve|spam|trash",
     *   "ids": [1, 2, 3, 4, 5]
     * }
     *
     * @return void JSON response with count of affected comments or error
     */
    public function postBulk()
    {
        // Get action and comment IDs from JSON body
        $action = Input::post('action');
        $commentIds = Input::post('ids');

        try {
            // Process bulk action via service
            switch ($action) {
                case 'approve':
                    $count = Comment::bulkApprove($commentIds);
                    View::json([
                        'success' => true,
                        'message' => "{$count} comment(s) approved successfully",
                        'meta' => ['affected' => $count]
                    ], 200);
                    break;

                case 'spam':
                    $count = Comment::bulkSpam($commentIds);
                    View::json([
                        'success' => true,
                        'message' => "{$count} comment(s) marked as spam",
                        'meta' => ['affected' => $count]
                    ], 200);
                    break;

                case 'trash':
                    $count = Comment::bulkDelete($commentIds);
                    View::json([
                        'success' => true,
                        'message' => "{$count} comment(s) moved to trash",
                        'meta' => ['affected' => $count]
                    ], 200);
                    break;

                default:
                    View::json([
                        'success' => false,
                        'error' => 'Invalid action',
                        'message' => 'Action must be one of: approve, spam, trash'
                    ], 422);
            }
        }
        catch (ServiceException $e) {
            // Validation error (no IDs selected)
            View::json([
                'success' => false,
                'error' => 'Validation failed',
                'message' => $e->getMessage()
            ], 422);
        }
    }
}

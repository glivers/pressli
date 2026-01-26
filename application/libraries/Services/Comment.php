<?php namespace Lib\Services;

/**
 * Comment Service - Pressli CMS
 *
 * Business logic layer for comment moderation workflow (approve, spam, delete).
 * Provides reusable functions for status management, bulk actions, and filtering
 * with validation and soft delete handling.
 *
 * USAGE CONTEXTS:
 * - Admin controllers (web UI for moderating comments)
 * - API controllers (REST endpoints for headless CMS)
 * - CLI commands (bulk comment cleanup operations)
 * - Plugins (programmatic comment moderation)
 * - Cron jobs (automated spam detection)
 *
 * VALIDATION RULES:
 * - Comment must exist and not be deleted
 * - Status must be one of: pending, approved, spam
 * - Bulk operations validate all IDs before processing
 *
 * STATUS WORKFLOW:
 * - pending → approved (visible on public site)
 * - approved → pending (hidden from public site)
 * - any → spam (hidden from both public and admin)
 * - any → deleted_at set (soft delete, can be restored)
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

use Rackage\Date;
use Models\CommentModel;
use Lib\Exceptions\ServiceException;

class Comment
{
    /**
     * Approve a pending comment
     *
     * Changes status from pending to approved, making comment visible on public site.
     * Validates comment exists and is not deleted before approval.
     *
     * @param int $id Comment ID to approve
     * @return bool True on successful approval
     * @throws ServiceException If comment not found or already deleted
     */
    public static function approve($id)
    {
        // Fetch comment to approve (must exist and not be deleted)
        $comment = CommentModel::where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$comment) {
            throw new ServiceException('Comment not found.');
        }

        // Update status to approved
        CommentModel::where('id', $id)->save(['status' => 'approved']);

        return true;
    }

    /**
     * Unapprove an approved comment
     *
     * Changes status from approved to pending, hiding comment from public site.
     * Useful for re-reviewing comments or responding to abuse reports.
     *
     * @param int $id Comment ID to unapprove
     * @return bool True on successful unapproval
     * @throws ServiceException If comment not found or already deleted
     */
    public static function unapprove($id)
    {
        // Fetch comment to unapprove (must exist and not be deleted)
        $comment = CommentModel::where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$comment) {
            throw new ServiceException('Comment not found.');
        }

        // Update status to pending
        CommentModel::where('id', $id)->save(['status' => 'pending']);

        return true;
    }

    /**
     * Mark comment as spam
     *
     * Changes status to spam, hiding comment from both public site and normal
     * admin views. Can be reversed by approving again. Helps train spam filters.
     *
     * @param int $id Comment ID to mark as spam
     * @return bool True on successful spam marking
     * @throws ServiceException If comment not found or already deleted
     */
    public static function markAsSpam($id)
    {
        // Fetch comment to mark as spam (must exist and not be deleted)
        $comment = CommentModel::where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$comment) {
            throw new ServiceException('Comment not found.');
        }

        // Update status to spam
        CommentModel::where('id', $id)->save(['status' => 'spam']);

        return true;
    }

    /**
     * Soft delete comment (move to trash)
     *
     * Sets deleted_at timestamp without removing from database. Allows recovery.
     * Comment won't appear in any status views but can be restored later.
     *
     * @param int $id Comment ID to delete
     * @return bool True on successful deletion
     * @throws ServiceException If comment not found or already deleted
     */
    public static function delete($id)
    {
        // Fetch comment to delete (must exist and not be deleted)
        $comment = CommentModel::where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$comment) {
            throw new ServiceException('Comment not found.');
        }

        // Soft delete by setting timestamp
        CommentModel::where('id', $id)->save([
            'deleted_at' => Date::now()
        ]);

        return true;
    }

    /**
     * Bulk approve multiple comments
     *
     * Changes status to approved for all provided comment IDs. Skips comments
     * that don't exist or are deleted. Returns count of successfully approved.
     *
     * @param array $ids Array of comment IDs to approve
     * @return int Count of comments approved
     * @throws ServiceException If no IDs provided or invalid array
     */
    public static function bulkApprove($ids)
    {
        // Validate IDs array is provided
        if (!$ids || !is_array($ids)) {
            throw new ServiceException('Please select comments to approve.');
        }

        $count = 0;

        // Approve each comment (skips if not found/deleted)
        foreach ($ids as $id) {
            $comment = CommentModel::where('id', $id)
                ->whereNull('deleted_at')
                ->first();

            if ($comment) {
                CommentModel::where('id', $id)->save(['status' => 'approved']);
                $count++;
            }
        }

        return $count;
    }

    /**
     * Bulk mark multiple comments as spam
     *
     * Changes status to spam for all provided comment IDs. Skips comments
     * that don't exist or are deleted. Returns count of successfully marked.
     *
     * @param array $ids Array of comment IDs to mark as spam
     * @return int Count of comments marked as spam
     * @throws ServiceException If no IDs provided or invalid array
     */
    public static function bulkSpam($ids)
    {
        // Validate IDs array is provided
        if (!$ids || !is_array($ids)) {
            throw new ServiceException('Please select comments to mark as spam.');
        }

        $count = 0;

        // Mark each comment as spam (skips if not found/deleted)
        foreach ($ids as $id) {
            $comment = CommentModel::where('id', $id)
                ->whereNull('deleted_at')
                ->first();

            if ($comment) {
                CommentModel::where('id', $id)->save(['status' => 'spam']);
                $count++;
            }
        }

        return $count;
    }

    /**
     * Bulk soft delete multiple comments
     *
     * Sets deleted_at timestamp for all provided comment IDs. Skips comments
     * that don't exist or are already deleted. Returns count of successfully deleted.
     *
     * @param array $ids Array of comment IDs to delete
     * @return int Count of comments deleted
     * @throws ServiceException If no IDs provided or invalid array
     */
    public static function bulkDelete($ids)
    {
        // Validate IDs array is provided
        if (!$ids || !is_array($ids)) {
            throw new ServiceException('Please select comments to delete.');
        }

        $count = 0;

        // Delete each comment (skips if not found/already deleted)
        foreach ($ids as $id) {
            $comment = CommentModel::where('id', $id)
                ->whereNull('deleted_at')
                ->first();

            if ($comment) {
                CommentModel::where('id', $id)->save(['deleted_at' => Date::now()]);
                $count++;
            }
        }

        return $count;
    }

    /**
     * Get all non-deleted comments with optional status filter
     *
     * Fetches comments with post title via JOIN for "In Response To" column.
     * Excludes soft-deleted comments, ordered by newest first. Optionally
     * filters by status (pending/approved/spam).
     *
     * @param string|null $status Optional status filter (pending, approved, spam)
     * @return array Array of comment records with post_title
     */
    public static function getAll($status = null)
    {
        // Build query with post title JOIN
        $query = CommentModel::select([
                'id', 'post_id', 'author_name', 'author_email', 'author_url',
                'content', 'status', 'created_at'
            ])
            ->leftJoin('posts', 'post_id = id', ['title as post_title']);

        // Apply status filter if provided
        if ($status && in_array($status, ['pending', 'approved', 'spam'])) {
            $query->where('status', $status);
        }

        // Exclude deleted comments and order by newest first
        $query->whereNull('comments.deleted_at');
        return $query->order('comments.created_at', 'desc')->all();
    }

    /**
     * Get single comment by ID
     *
     * Fetches comment matching ID, excluding soft-deleted records.
     * Used for loading comment details in edit forms and API responses.
     *
     * @param int $id Comment ID
     * @return array|null Comment record or null if not found
     */
    public static function getById($id)
    {
        return CommentModel::where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }

    /**
     * Get status counts for all comment states
     *
     * Returns count of comments in each status (all, pending, approved, spam).
     * Used for displaying status tabs with counts in admin UI. Excludes
     * soft-deleted comments from all counts.
     *
     * @return array Associative array with status counts
     */
    public static function getStatusCounts()
    {
        return [
            'all' => CommentModel::whereNull('deleted_at')->count(),
            'pending' => CommentModel::where('status', 'pending')->whereNull('deleted_at')->count(),
            'approved' => CommentModel::where('status', 'approved')->whereNull('deleted_at')->count(),
            'spam' => CommentModel::where('status', 'spam')->whereNull('deleted_at')->count(),
        ];
    }
}

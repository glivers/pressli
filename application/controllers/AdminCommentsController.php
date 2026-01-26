<?php namespace Controllers;

use Rackage\Csrf;
use Rackage\View;
use Rackage\Input;
use Rackage\Session;
use Rackage\Redirect;
use Lib\Services\Comment;
use Controllers\AdminController;
use Lib\Exceptions\ServiceException;

/**
 * Comments Controller - Pressli CMS
 *
 * Manages comment moderation workflow: view, approve, spam, delete.
 * Supports bulk actions, status filtering, and threaded replies.
 * All state-changing operations are CSRF-protected.
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class AdminCommentsController extends AdminController
{
    /**
     * Display comments list with filtering
     *
     * Shows comments table with status tabs (all/pending/approved/spam) and author info.
     * Excludes soft-deleted comments. Fetches post title via JOIN for "In Response To" column.
     * Ordered by newest first.
     *
     * @return void
     */
    public function getIndex()
    {
        // Get status filter from query string
        $status = Input::get('status');

        // Get all comments with optional status filter
        $comments = Comment::getAll($status);

        // Get status counts for tabs
        $statusCounts = Comment::getStatusCounts();

        View::render('admin/comments', [
            'title' => 'Comments',
            'comments' => $comments,
            'statusCounts' => $statusCounts
        ]);
    }

    /**
     * Approve a pending comment
     *
     * Changes status from pending to approved, making comment visible on public site.
     * Redirects back to comments list with success message.
     *
     * @param int $id Comment ID from URL
     * @return void Redirects to comments list
     */
    public function getApprove($id)
    {
        try {
            // Approve comment via service
            Comment::approve($id);

            // Success - redirect to list
            Session::flash('success', 'Comment approved successfully.');
            Redirect::to('admin/comments');
        }
        catch (ServiceException $e) {
            // Comment not found
            Session::flash('error', $e->getMessage());
            Redirect::to('admin/comments');
        }
    }

    /**
     * Unapprove an approved comment
     *
     * Changes status from approved to pending, hiding comment from public site.
     * Useful for re-reviewing comments or responding to abuse reports.
     *
     * @param int $id Comment ID from URL
     * @return void Redirects to comments list
     */
    public function getUnapprove($id)
    {
        try {
            // Unapprove comment via service
            Comment::unapprove($id);

            // Success - redirect to list
            Session::flash('success', 'Comment unapproved successfully.');
            Redirect::to('admin/comments');
        }
        catch (ServiceException $e) {
            // Comment not found
            Session::flash('error', $e->getMessage());
            Redirect::to('admin/comments');
        }
    }

    /**
     * Mark comment as spam
     *
     * Changes status to spam, hiding comment from both public site and normal admin views.
     * Can be reversed by approving again. Helps train spam filters.
     *
     * @param int $id Comment ID from URL
     * @return void Redirects to comments list
     */
    public function getSpam($id)
    {
        try {
            // Mark comment as spam via service
            Comment::markAsSpam($id);

            // Success - redirect to list
            Session::flash('success', 'Comment marked as spam.');
            Redirect::to('admin/comments');
        }
        catch (ServiceException $e) {
            // Comment not found
            Session::flash('error', $e->getMessage());
            Redirect::to('admin/comments');
        }
    }

    /**
     * Soft delete comment (move to trash)
     *
     * Sets deleted_at timestamp without removing from database. Allows recovery.
     * Comment won't appear in any status views but can be restored later.
     *
     * @param int $id Comment ID from URL
     * @return void Redirects to comments list
     */
    public function getDelete($id)
    {
        try {
            // Soft delete via service
            Comment::delete($id);

            // Success - redirect to list
            Session::flash('success', 'Comment moved to trash.');
            Redirect::to('admin/comments');
        }
        catch (ServiceException $e) {
            // Comment not found
            Session::flash('error', $e->getMessage());
            Redirect::to('admin/comments');
        }
    }

    /**
     * Process bulk actions on selected comments
     *
     * Handles mass approve, mark as spam, or delete operations. Processes array of
     * comment IDs from checkboxes. CSRF-protected. Redirects with count of affected items.
     *
     * @return void Redirects to comments list with result message
     */
    public function postBulk()
    {
        // Verify CSRF token
        if (!Csrf::verify()) {
            Session::flash('error', 'Invalid security token. Please try again.');
            Redirect::back();
        }

        // Get action and comment IDs from form
        $action = Input::post('action');
        $commentIds = Input::post('ids');

        try {
            // Process bulk action via service
            switch ($action) {
                case 'approve':
                    $count = Comment::bulkApprove($commentIds);
                    Session::flash('success', "{$count} comment(s) approved successfully.");
                    Redirect::to('admin/comments');
                    break;

                case 'spam':
                    $count = Comment::bulkSpam($commentIds);
                    Session::flash('success', "{$count} comment(s) marked as spam.");
                    Redirect::to('admin/comments');
                    break;

                case 'trash':
                    $count = Comment::bulkDelete($commentIds);
                    Session::flash('success', "{$count} comment(s) moved to trash.");
                    Redirect::to('admin/comments');
                    break;

                default:
                    Session::flash('error', 'Invalid bulk action selected.');
                    Redirect::back();
            }
        }
        catch (ServiceException $e) {
            // Validation error (no IDs selected)
            Session::flash('error', $e->getMessage());
            Redirect::back();
        }
    }
}

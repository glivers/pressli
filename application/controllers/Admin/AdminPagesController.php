<?php namespace Controllers\Admin;

use Rackage\Csrf;
use Rackage\View;
use Rackage\Input;
use Rackage\Session;
use Rackage\Request;
use Rackage\Redirect;
use Lib\Services\Page;
use Controllers\Admin\AdminController;
use Lib\Exceptions\ServiceException;

/**
 * Pages Controller - Pressli CMS
 *
 * Manages static pages with hierarchical structure and template support.
 * Handles creating, editing, and deleting pages with publication workflow.
 * All state-changing operations are CSRF-protected.
 *
 * Routes (automatic URL-based routing):
 * - GET  /pages           List all pages
 * - GET  /pages/new       Display page creation form
 * - POST /pages/new       Process new page creation
 * - GET  /pages/edit/{id} Display page edit form
 * - POST /pages/edit/{id} Process page update
 * - GET  /pages/delete/{id} Soft delete page
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class AdminPagesController extends AdminController
{
    /**
     * Display list of all pages
     *
     * Fetches pages with author info, filtered by status if provided.
     * Supports filtering: ?status=published|draft|trash
     *
     * @return void
     */
    public function getIndex()
    {
        // Get status filter from query string
        $status = Input::get('status');

        // Get all pages with optional status filter
        $pages = Page::getAll($status);

        // Get status counts for tabs
        $statusCounts = Page::getStatusCounts();

        View::render('admin/pages', [
            'title' => 'Pages',
            'pages' => $pages,
            'statusCounts' => $statusCounts
        ]);
    }

    /**
     * Display form to create new page
     *
     * Loads all pages for parent selection dropdown.
     *
     * @return void
     */
    public function getNew()
    {
        // Get all non-deleted pages for parent selection
        $pages = Page::getPagesForParentDropdown();

        // Build hierarchical list with » prefix
        $hierarchicalPages = Page::buildHierarchy($pages);

        View::render('admin/pages-new', [
            'title' => 'New Page',
            'pages' => $hierarchicalPages
        ]);
    }

    /**
     * Process new page creation
     *
     * Validates input, auto-generates slug from title if not provided,
     * and creates page with optional parent relationship.
     *
     * @return void Redirects to edit page on success, back on error
     */
    public function postNew()
    {
        // Verify CSRF token
        if (!Csrf::verify()) {
            Session::flash('error', 'Invalid security token. Please try again.');
            Redirect::back();
        }

        try {
            // Prepare page data from form input
            $data = [
                'title' => Input::post('title'),
                'slug' => Input::post('slug'),
                'content' => Input::post('content'),
                'excerpt' => Input::post('excerpt'),
                'type' => Input::post('type'),
                'template' => Input::post('template'),
                'parent_id' => Input::post('parent_id'),
                'status' => Input::post('status'),
                'meta_title' => Input::post('meta_title'),
                'meta_description' => Input::post('meta_description'),
                'featured_image_id' => Input::post('featured-image-id')
            ];

            // Create page via service
            $pageId = Page::create($data, Session::get('user_id'));

            // Success - redirect to edit page
            Session::flash('success', 'Page created successfully!');
            Redirect::to('admin/pages/edit/' . $pageId);
        }
        catch (ServiceException $e) {
            // Validation or business logic error
            Session::flash('error', $e->getMessage());
            Redirect::back();
        }
    }

    /**
     * Display form to edit page
     *
     * Loads page data and all other pages for parent selection.
     * Returns 404 if page not found or already deleted.
     *
     * @param int $id Page ID from URL
     * @return void
     */
    public function getEdit($id)
    {
        // Get page with featured image details
        $page = Page::getById($id);

        if (!$page) {
            Session::flash('error', 'Page not found.');
            Redirect::to('admin/pages');
        }

        // Get all pages except current one (can't be its own parent)
        $pages = Page::getPagesForParentDropdown($id);

        // Build hierarchical list with » prefix
        $hierarchicalPages = Page::buildHierarchy($pages);

        View::render('admin/pages-edit', [
            'title' => 'Edit Page',
            'page' => $page,
            'pages' => $hierarchicalPages
        ]);
    }

    /**
     * Process page edit
     *
     * Updates page information. Validates slug uniqueness excluding current page.
     * Prevents circular parent relationships.
     *
     * @param int $id Page ID from URL
     * @return void Redirects to edit page on success, back on error
     */
    public function postEdit($id)
    {
        // Verify CSRF token
        if (!Csrf::verify()) {
            if (Request::ajax()) {
                View::json(['success' => false, 'message' => 'Invalid security token. Please try again.'], 403);
                return;
            }
            Session::flash('error', 'Invalid security token. Please try again.');
            Redirect::back();
        }

        try {
            // Prepare page data from form input
            $data = [
                'title' => Input::post('title'),
                'slug' => Input::post('slug'),
                'content' => Input::post('content'),
                'excerpt' => Input::post('excerpt'),
                'type' => Input::post('type'),
                'template' => Input::post('template'),
                'parent_id' => Input::post('parent_id'),
                'status' => Input::post('status'),
                'meta_title' => Input::post('meta_title'),
                'meta_description' => Input::post('meta_description'),
                'featured_image_id' => Input::post('featured-image-id')
            ];

            // Update page via service
            Page::update($id, $data);

            // Return JSON for AJAX requests
            if (Request::ajax()) {
                View::json([
                    'success' => true,
                    'message' => 'Page updated successfully!',
                    'page' => [
                        'id' => $id,
                        'title' => $data['title'],
                        'slug' => $data['slug'],
                        'status' => $data['status']
                    ]
                ]);
                return;
            }

            // Traditional redirect for non-AJAX
            Session::flash('success', 'Page updated successfully!');
            Redirect::to('admin/pages/edit/' . $id);
        }
        catch (ServiceException $e) {
            // Validation or business logic error
            if (Request::ajax()) {
                View::json(['success' => false, 'message' => $e->getMessage()], 400);
                return;
            }
            Session::flash('error', $e->getMessage());
            Redirect::back();
        }
    }

    /**
     * Soft delete page (move to trash)
     *
     * Sets deleted_at timestamp. Child pages remain but parent reference maintained.
     *
     * @param int $id Page ID from URL
     * @return void Redirects to /pages with status message
     */
    public function getDelete($id)
    {
        try {
            // Soft delete via service
            Page::delete($id);

            // Success - redirect to pages list
            Session::flash('success', 'Page moved to trash.');
            Redirect::to('admin/pages');
        }
        catch (ServiceException $e) {
            // Page not found or already deleted
            Session::flash('error', $e->getMessage());
            Redirect::to('admin/pages');
        }
    }

}

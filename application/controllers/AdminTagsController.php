<?php namespace Controllers;

use Rackage\Csrf;
use Rackage\View;
use Rackage\Input;
use Rackage\Session;
use Rackage\Redirect;
use Lib\Services\Taxonomy;
use Controllers\AdminController;
use Lib\Exceptions\ServiceException;

/**
 * Tags Controller - Pressli CMS
 *
 * Manages post tags (flat taxonomies). Handles creating, editing,
 * and deleting tags without hierarchical relationships. All state-changing
 * operations are CSRF-protected.
 *
 * Routes (automatic URL-based routing):
 * - GET  /tags           List all tags
 * - GET  /tags/new       Display tag creation form
 * - POST /tags/new       Process new tag creation
 * - GET  /tags/edit/{id} Display tag edit form
 * - POST /tags/edit/{id} Process tag update
 * - GET  /tags/delete/{id} Soft delete tag
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class AdminTagsController extends AdminController
{
    /**
     * Display list of all tags
     *
     * Fetches all non-deleted tags ordered by name. Shows flat list
     * (no hierarchy).
     *
     * @return void
     */
    public function getIndex()
    {
        // Get all tags and total count
        $tags = Taxonomy::getAll('tag');
        $totalCount = Taxonomy::count('tag');

        View::render('admin/tags', [
            'title' => 'Tags',
            'tags' => $tags,
            'totalCount' => $totalCount
        ]);
    }

    /**
     * Display form to create new tag
     *
     * @return void
     */
    public function getNew()
    {
        View::render('admin/tags-new', [
            'title' => 'New Tag'
        ]);
    }

    /**
     * Process new tag creation
     *
     * Validates input, auto-generates slug from name if not provided,
     * and creates tag.
     *
     * @return void Redirects to /tags on success, back on error
     */
    public function postNew()
    {
        // Verify CSRF token
        if (!Csrf::verify()) {
            Session::flash('error', 'Invalid security token. Please try again.');
            Redirect::back();
        }

        try {
            // Prepare tag data from form input
            $data = [
                'name' => Input::post('name'),
                'slug' => Input::post('slug'),
                'description' => Input::post('description')
            ];

            // Create tag via service
            Taxonomy::create($data, 'tag');

            // Success - redirect to tags list
            Session::flash('success', 'Tag created successfully!');
            Redirect::to('admin/tags');
        }
        catch (ServiceException $e) {
            // Validation or business logic error
            Session::flash('error', $e->getMessage());
            Redirect::back();
        }
    }

    /**
     * Display form to edit tag
     *
     * Loads tag data. Returns 404 if tag not found or already deleted.
     *
     * @param int $id Tag ID from URL
     * @return void
     */
    public function getEdit($id)
    {
        // Get tag by ID
        $tag = Taxonomy::getById($id, 'tag');

        if (!$tag) {
            Session::flash('error', 'Tag not found.');
            Redirect::to('admin/tags');
        }

        View::render('admin/tags-edit', [
            'title' => 'Edit Tag',
            'tag' => $tag
        ]);
    }

    /**
     * Process tag edit
     *
     * Updates tag information including name, slug, and description.
     * Validates slug uniqueness excluding current tag.
     *
     * @param int $id Tag ID from URL
     * @return void Redirects to /tags on success, back on error
     */
    public function postEdit($id)
    {
        // Verify CSRF token
        if (!Csrf::verify()) {
            Session::flash('error', 'Invalid security token. Please try again.');
            Redirect::back();
        }

        try {
            // Prepare tag data from form input
            $data = [
                'name' => Input::post('name'),
                'slug' => Input::post('slug'),
                'description' => Input::post('description')
            ];

            // Update tag via service
            Taxonomy::update($id, $data, 'tag');

            // Success - redirect to tags list
            Session::flash('success', 'Tag updated successfully!');
            Redirect::to('admin/tags');
        }
        catch (ServiceException $e) {
            // Validation or business logic error
            Session::flash('error', $e->getMessage());
            Redirect::back();
        }
    }

    /**
     * Soft delete tag (move to trash)
     *
     * Sets deleted_at timestamp. Posts remain associated but tag won't show.
     *
     * @param int $id Tag ID from URL
     * @return void Redirects to /tags with status message
     */
    public function getDelete($id)
    {
        try {
            // Soft delete via service
            Taxonomy::delete($id, 'tag');

            // Success - redirect to tags list
            Session::flash('success', 'Tag moved to trash.');
            Redirect::to('admin/tags');
        }
        catch (ServiceException $e) {
            // Tag not found or already deleted
            Session::flash('error', $e->getMessage());
            Redirect::to('admin/tags');
        }
    }
}

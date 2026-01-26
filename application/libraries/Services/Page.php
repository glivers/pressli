<?php namespace Lib\Services;

/**
 * Page Service - Pressli CMS
 *
 * Business logic layer for managing static pages with hierarchical structure
 * and template support. Provides reusable functions for creating, updating,
 * deleting pages with validation, slug generation, and parent-child relationships.
 *
 * USAGE CONTEXTS:
 * - Admin controllers (web UI for managing pages)
 * - API controllers (REST endpoints for headless CMS)
 * - CLI commands (bulk page operations, imports)
 * - Plugins (programmatic page creation)
 * - Cron jobs (automated page publishing)
 *
 * VALIDATION RULES:
 * - Title is required (cannot be empty)
 * - Slug must be unique among non-deleted pages
 * - Slug auto-generated from title if not provided
 * - Parent cannot be self (circular reference prevention)
 * - Status must be: draft, published
 * - Slug contains only lowercase letters, numbers, hyphens
 *
 * HIERARCHICAL STRUCTURE:
 * - Pages can have parent-child relationships via parent_id
 * - Top-level pages have parent_id = null
 * - Circular relationships prevented (page cannot be its own parent)
 * - buildHierarchy() provides formatted list with » prefix for depth
 *
 * TEMPLATE SUPPORT:
 * - Pages can use custom templates (default, full-width, etc.)
 * - Template field stores template filename
 * - Defaults to 'default' if not specified
 *
 * STATUS WORKFLOW:
 * - draft: Not visible on public site
 * - published: Sets published_at to now, visible on public site
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
use Models\PostModel;
use Lib\Exceptions\ServiceException;

class Page
{
    /**
     * Create new page
     *
     * Validates input, generates slug if not provided, checks uniqueness,
     * handles published_at based on status, and creates page record in
     * posts table with type='page'.
     *
     * @param array $data Input data (title, slug, content, parent_id, template, etc.)
     * @param int $authorId User ID of page author
     * @return int Created page ID
     * @throws ServiceException If title empty or slug exists
     */
    public static function create($data, $authorId)
    {
        // Validate title is provided
        if (empty($data['title'])) {
            throw new ServiceException('Page title is required.');
        }

        // Generate slug from title if not provided, otherwise sanitize user input
        $slug = empty($data['slug'])
            ? self::generateSlug($data['title'])
            : self::sanitizeSlug($data['slug']);

        // Check slug uniqueness among pages (excluding deleted)
        if (PostModel::where('type', 'page')
            ->where('slug', $slug)
            ->whereNull('deleted_at')
            ->exists()) {
            throw new ServiceException('Slug already exists. Please choose a different one.');
        }

        // Set published_at based on status
        $status = $data['status'] ?? 'draft';
        $publishedAt = ($status === 'published') ? Date::now() : null;

        // Validate featured image ID if provided
        $featuredImageId = !empty($data['featured_image_id']) ? $data['featured_image_id'] : null;

        // Create page with all fields
        $pageId = PostModel::save([
            'type' => 'page',
            'title' => $data['title'],
            'slug' => $slug,
            'content' => $data['content'] ?? null,
            'excerpt' => $data['excerpt'] ?? null,
            'author_id' => $authorId,
            'parent_id' => !empty($data['parent_id']) ? $data['parent_id'] : null,
            'template' => $data['template'] ?? 'default',
            'status' => $status,
            'menu_order' => 0,
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'published_at' => $publishedAt,
            'featured_image_id' => $featuredImageId
        ]);

        return $pageId;
    }

    /**
     * Update existing page
     *
     * Validates input, fetches existing page, sanitizes slug, checks uniqueness
     * excluding current record, prevents circular parent relationships, handles
     * status transitions and published_at, and updates page record.
     *
     * @param int $id Page ID to update
     * @param array $data Updated data (title, slug, content, parent_id, template, etc.)
     * @return bool True on successful update
     * @throws ServiceException If page not found, title empty, slug exists, or circular parent
     */
    public static function update($id, $data)
    {
        // Fetch page to update (must exist, be a page, and not be deleted)
        $page = PostModel::where('type', 'page')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$page) {
            throw new ServiceException('Page not found.');
        }

        // Validate title is provided
        if (empty($data['title'])) {
            throw new ServiceException('Page title is required.');
        }

        // Generate slug from title if not provided, otherwise sanitize user input
        $slug = empty($data['slug'])
            ? self::generateSlug($data['title'])
            : self::sanitizeSlug($data['slug']);

        // Check slug uniqueness excluding current page
        $existingSlug = PostModel::where('type', 'page')
            ->where('slug', $slug)
            ->where('id != ?', $id)
            ->whereNull('deleted_at')
            ->first();

        if ($existingSlug) {
            throw new ServiceException('Slug already exists. Please choose a different one.');
        }

        // Prevent circular parent relationship
        if (!empty($data['parent_id']) && $data['parent_id'] == $id) {
            throw new ServiceException('A page cannot be its own parent.');
        }

        // Handle published_at based on status transition
        $status = $data['status'] ?? 'draft';
        $publishedAt = $page['published_at'];

        if ($status === 'published' && empty($publishedAt)) {
            // Publishing for the first time
            $publishedAt = Date::now();
        }
        elseif ($status === 'draft') {
            // Drafts don't have publication date
            $publishedAt = null;
        }

        // Validate featured image ID if provided
        $featuredImageId = !empty($data['featured_image_id']) ? $data['featured_image_id'] : null;

        // Update page fields
        PostModel::where('id', $id)->save([
            'title' => $data['title'],
            'slug' => $slug,
            'content' => $data['content'] ?? null,
            'excerpt' => $data['excerpt'] ?? null,
            'parent_id' => !empty($data['parent_id']) ? $data['parent_id'] : null,
            'template' => $data['template'] ?? 'default',
            'status' => $status,
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'published_at' => $publishedAt,
            'featured_image_id' => $featuredImageId
        ]);

        return true;
    }

    /**
     * Soft delete page (move to trash)
     *
     * Sets deleted_at timestamp on page record. Child pages remain but parent
     * reference maintained. Page won't appear in queries that filter
     * whereNull('deleted_at').
     *
     * @param int $id Page ID to delete
     * @return bool True on successful deletion
     * @throws ServiceException If page not found or already deleted
     */
    public static function delete($id)
    {
        // Fetch page to delete (must exist, be a page, and not be deleted)
        $page = PostModel::where('type', 'page')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$page) {
            throw new ServiceException('Page not found.');
        }

        // Soft delete by setting timestamp
        PostModel::where('id', $id)->save([
            'deleted_at' => Date::now()
        ]);

        return true;
    }

    /**
     * Get all non-deleted pages with optional status filter
     *
     * Fetches pages with author names via LEFT JOIN, filtered by status if provided.
     * Excludes or includes soft-deleted based on status filter. Ordered by updated_at
     * descending (most recently updated first).
     *
     * @param string|null $status Optional status filter (published, draft, trash)
     * @return array Array of page records with author info
     */
    public static function getAll($status = null)
    {
        // Build query with author JOIN
        $query = PostModel::select([
                'id', 'title', 'slug', 'template', 'status',
                'menu_order', 'author_id', 'parent_id',
                'published_at', 'created_at', 'updated_at', 'deleted_at'
            ])
            ->leftJoin('users', 'author_id = id', ['first_name', 'last_name', 'email'])
            ->where('type', 'page');

        // Apply status filter (trash vs active statuses)
        if ($status === 'trash') {
            $query->whereNotNull('deleted_at');
        }
        else {
            $query->whereNull('deleted_at');
            if ($status && in_array($status, ['published', 'draft'])) {
                $query->where('status', $status);
            }
        }

        // Order by most recently updated first
        return $query->order('updated_at', 'desc')->all();
    }

    /**
     * Get single page by ID with featured image
     *
     * Fetches page matching ID with featured image details via LEFT JOIN,
     * excluding soft-deleted records. Used for loading page in edit forms.
     *
     * @param int $id Page ID
     * @return array|null Page record with featured_image fields or null if not found
     */
    public static function getById($id)
    {
        return PostModel::where('type', 'page')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->leftJoin('media', 'featured_image_id = id', [
                'file_path as featured_image',
                'alt_text as featured_image_alt',
                'title as featured_image_title'
            ])
            ->first();
    }

    /**
     * Get all pages for parent selection dropdown
     *
     * Returns all non-deleted pages ordered by title. Optionally excludes
     * specific page ID to prevent circular parent relationships in edit forms.
     *
     * @param int|null $excludeId Optional page ID to exclude (for edit form)
     * @return array Array of page records
     */
    public static function getPagesForParentDropdown($excludeId = null)
    {
        // Start query for pages
        $query = PostModel::where('type', 'page')
            ->whereNull('deleted_at');

        // Exclude specific ID if provided (can't be its own parent)
        if ($excludeId) {
            $query->where('id != ?', $excludeId);
        }

        return $query->order('title', 'asc')->all();
    }

    /**
     * Get status counts for all page states
     *
     * Returns count of pages in each status (all, published, draft, trash).
     * Used for displaying status tabs with counts in admin UI.
     *
     * @return array Associative array with status counts
     */
    public static function getStatusCounts()
    {
        return [
            'all' => PostModel::where('type', 'page')->whereNull('deleted_at')->count(),
            'published' => PostModel::where('type', 'page')->where('status', 'published')->whereNull('deleted_at')->count(),
            'draft' => PostModel::where('type', 'page')->where('status', 'draft')->whereNull('deleted_at')->count(),
            'trash' => PostModel::where('type', 'page')->whereNotNull('deleted_at')->count()
        ];
    }

    /**
     * Build hierarchical page list with » prefix
     *
     * Recursively formats pages with » prefix based on depth level for display
     * in parent selection dropdowns. Top-level pages have no prefix, children
     * get », grandchildren get » », etc. Creates display_title field with prefix.
     *
     * @param array $pages All pages to format
     * @param int|null $parentId Current parent ID (null for top level)
     * @param int $depth Current depth level (0 for top level)
     * @return array Formatted pages with hierarchy and display_title field
     */
    public static function buildHierarchy($pages, $parentId = null, $depth = 0)
    {
        $result = [];
        $prefix = str_repeat('» ', $depth);

        // Find pages at current level
        foreach ($pages as $page) {
            if ($page['parent_id'] == $parentId) {
                // Add current page with prefix
                $page['display_title'] = $prefix . $page['title'];
                $result[] = $page;

                // Recursively add children
                $children = self::buildHierarchy($pages, $page['id'], $depth + 1);
                $result = array_merge($result, $children);
            }
        }

        return $result;
    }

    /**
     * Generate URL-friendly slug from title
     *
     * Converts title to lowercase, replaces spaces with hyphens, removes special
     * characters (keeps only a-z, 0-9, hyphens), removes consecutive hyphens,
     * trims hyphens from edges, and ensures uniqueness by appending counter
     * (-1, -2, -3, etc.) if slug already exists among pages.
     *
     * @param string $title Page title to convert to slug
     * @return string URL-friendly unique slug
     */
    private static function generateSlug($title)
    {
        // Convert to lowercase
        $slug = strtolower($title);

        // Replace spaces with hyphens
        $slug = str_replace(' ', '-', $slug);

        // Remove special characters (keep alphanumeric and hyphens)
        $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);

        // Remove multiple consecutive hyphens
        $slug = preg_replace('/-+/', '-', $slug);

        // Trim hyphens from start and end
        $slug = trim($slug, '-');

        // Ensure uniqueness by appending counter if needed
        $originalSlug = $slug;
        $counter = 1;

        while (PostModel::where('type', 'page')
            ->where('slug', $slug)
            ->whereNull('deleted_at')
            ->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Sanitize user-provided slug
     *
     * Ensures slug contains only valid URL-friendly characters by converting to
     * lowercase, removing invalid characters (keeps only a-z, 0-9, hyphens),
     * collapsing consecutive hyphens, and trimming hyphens from start and end.
     *
     * @param string $slug User-provided slug to sanitize
     * @return string Sanitized slug containing only valid characters
     */
    private static function sanitizeSlug($slug)
    {
        // Convert to lowercase
        $slug = strtolower($slug);

        // Remove invalid characters (keep alphanumeric and hyphens)
        $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);

        // Remove multiple consecutive hyphens
        $slug = preg_replace('/-+/', '-', $slug);

        // Trim hyphens from start and end
        $slug = trim($slug, '-');

        return $slug;
    }
}

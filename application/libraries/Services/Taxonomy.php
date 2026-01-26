<?php namespace Lib\Services;

/**
 * Taxonomy Service - Pressli CMS
 *
 * Business logic layer for managing taxonomies (categories and tags).
 * Provides reusable functions for creating, updating, and deleting taxonomies
 * with validation, slug generation, uniqueness checking, and relationship handling.
 *
 * USAGE CONTEXTS:
 * - Admin controllers (web UI for managing categories/tags)
 * - API controllers (REST endpoints for headless CMS)
 * - CLI commands (bulk import/export operations)
 * - Plugins (programmatic taxonomy creation)
 * - Cron jobs (automated taxonomy management)
 *
 * VALIDATION RULES:
 * - Name is required (cannot be empty)
 * - Slug must be unique per type (category/tag) among non-deleted records
 * - Slug auto-generated from name if not provided
 * - Parent cannot be self (circular reference prevention)
 * - Slug contains only lowercase letters, numbers, hyphens
 *
 * SLUG GENERATION:
 * - Converts name to lowercase
 * - Replaces spaces with hyphens
 * - Removes special characters (keeps a-z, 0-9, hyphens)
 * - Removes multiple consecutive hyphens
 * - Trims hyphens from start and end
 * - Ensures uniqueness with counter suffix (-1, -2, -3, etc.) if needed
 *
 * ERROR HANDLING:
 * All methods throw LibException on validation or business logic errors.
 * Controllers catch exceptions and format response appropriately (flash messages or JSON).
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */

use Rackage\Date;
use Models\TaxonomyModel;
use Lib\Exceptions\ServiceException;

class Taxonomy
{
    /**
     * Create new taxonomy (category or tag)
     *
     * Validates input, generates slug if not provided, checks uniqueness against
     * non-deleted records, and creates taxonomy record in database with all fields.
     *
     * @param array $data Input data (name, slug, description, parent_id)
     * @param string $type Taxonomy type ('category' or 'tag')
     * @return int Created taxonomy ID
     * @throws LibException If name is empty or slug already exists
     */
    public static function create($data, $type)
    {
        // Validate name is provided
        if (empty($data['name'])) {
            $typeName = ucfirst($type);
            throw new ServiceException("{$typeName} name is required.");
        }

        // Generate slug from name if not provided, otherwise sanitize user input
        $slug = empty($data['slug'])
            ? self::generateSlug($data['name'], $type)
            : self::sanitizeSlug($data['slug']);

        // Check slug uniqueness for this taxonomy type (excluding deleted)
        if (TaxonomyModel::where('type', $type)
            ->where('slug', $slug)
            ->whereNull('deleted_at')
            ->exists()) {
            throw new ServiceException('Slug already exists. Please choose a different one.');
        }

        // Create taxonomy with all fields
        $taxonomyId = TaxonomyModel::save([
            'name' => $data['name'],
            'slug' => $slug,
            'type' => $type,
            'description' => $data['description'] ?? null,
            'parent_id' => !empty($data['parent_id']) ? $data['parent_id'] : null,
            'sort_order' => 0,
            'post_count' => 0
        ]);

        return $taxonomyId;
    }

    /**
     * Update existing taxonomy
     *
     * Validates input, fetches existing taxonomy, sanitizes slug, checks uniqueness
     * excluding current record, prevents circular parent relationships, and updates
     * taxonomy record in database.
     *
     * @param int $id Taxonomy ID to update
     * @param array $data Updated data (name, slug, description, parent_id)
     * @param string $type Taxonomy type ('category' or 'tag')
     * @return bool True on successful update
     * @throws LibException If taxonomy not found, name empty, slug exists, or circular parent
     */
    public static function update($id, $data, $type)
    {
        // Fetch taxonomy to update (must exist and not be deleted)
        $taxonomy = TaxonomyModel::where('id', $id)
            ->where('type', $type)
            ->whereNull('deleted_at')
            ->first();

        if (!$taxonomy) {
            $typeName = ucfirst($type);
            throw new ServiceException("{$typeName} not found.");
        }

        // Validate name is provided
        if (empty($data['name'])) {
            $typeName = ucfirst($type);
            throw new ServiceException("{$typeName} name is required.");
        }

        // Generate slug from name if not provided, otherwise sanitize user input
        $slug = empty($data['slug'])
            ? self::generateSlug($data['name'], $type)
            : self::sanitizeSlug($data['slug']);

        // Check slug uniqueness excluding current taxonomy
        $existingSlug = TaxonomyModel::where('type', $type)
            ->where('slug', $slug)
            ->where('id != ?', $id)
            ->whereNull('deleted_at')
            ->first();

        if ($existingSlug) {
            throw new ServiceException('Slug already exists. Please choose a different one.');
        }

        // Prevent circular parent relationship
        if (!empty($data['parent_id']) && $data['parent_id'] == $id) {
            $typeName = ucfirst($type);
            throw new ServiceException("A {$type} cannot be its own parent.");
        }

        // Update taxonomy fields
        TaxonomyModel::where('id', $id)->save([
            'name' => $data['name'],
            'slug' => $slug,
            'description' => $data['description'] ?? null,
            'parent_id' => !empty($data['parent_id']) ? $data['parent_id'] : null
        ]);

        return true;
    }

    /**
     * Soft delete taxonomy (move to trash)
     *
     * Sets deleted_at timestamp on taxonomy record. Child taxonomies become orphaned
     * (parent_id remains but points to deleted parent). Posts remain associated but
     * taxonomy won't appear in queries that filter whereNull('deleted_at').
     *
     * @param int $id Taxonomy ID to delete
     * @param string $type Taxonomy type ('category' or 'tag')
     * @return bool True on successful deletion
     * @throws LibException If taxonomy not found or already deleted
     */
    public static function delete($id, $type)
    {
        // Fetch taxonomy to delete (must exist and not be deleted)
        $taxonomy = TaxonomyModel::where('id', $id)
            ->where('type', $type)
            ->whereNull('deleted_at')
            ->first();

        if (!$taxonomy) {
            $typeName = ucfirst($type);
            throw new ServiceException("{$typeName} not found.");
        }

        // Soft delete by setting timestamp
        TaxonomyModel::where('id', $id)->save([
            'deleted_at' => Date::now()
        ]);

        return true;
    }

    /**
     * Get all non-deleted taxonomies of specific type
     *
     * Fetches all taxonomies matching type, excluding soft-deleted records,
     * ordered alphabetically by name for consistent display in lists and dropdowns.
     *
     * @param string $type Taxonomy type ('category' or 'tag')
     * @return array Array of taxonomy records
     */
    public static function getAll($type)
    {
        return TaxonomyModel::where('type', $type)
            ->whereNull('deleted_at')
            ->order('name', 'asc')
            ->all();
    }

    /**
     * Get single taxonomy by ID
     *
     * Fetches taxonomy matching ID and type, excluding soft-deleted records.
     * Used for loading taxonomy details in edit forms and API responses.
     *
     * @param int $id Taxonomy ID
     * @param string $type Taxonomy type ('category' or 'tag')
     * @return array|null Taxonomy record or null if not found
     */
    public static function getById($id, $type)
    {
        return TaxonomyModel::where('id', $id)
            ->where('type', $type)
            ->whereNull('deleted_at')
            ->first();
    }

    /**
     * Get all taxonomies except specific ID
     *
     * Fetches taxonomies excluding specified ID, used for parent selection dropdown
     * in edit forms to prevent taxonomy from being its own parent.
     *
     * @param string $type Taxonomy type ('category' or 'tag')
     * @param int|null $excludeId Taxonomy ID to exclude from results
     * @return array Array of taxonomy records ordered by name
     */
    public static function getAllExcept($type, $excludeId = null)
    {
        // Start query for type and non-deleted
        $query = TaxonomyModel::where('type', $type)
            ->whereNull('deleted_at');

        // Exclude specific ID if provided
        if ($excludeId) {
            $query->where('id != ?', $excludeId);
        }

        return $query->order('name', 'asc')->all();
    }

    /**
     * Count non-deleted taxonomies of specific type
     *
     * Returns total count of taxonomies matching type, excluding soft-deleted records.
     * Used for displaying taxonomy statistics in admin dashboard and list pages.
     *
     * @param string $type Taxonomy type ('category' or 'tag')
     * @return int Total count of non-deleted taxonomies
     */
    public static function count($type)
    {
        return TaxonomyModel::where('type', $type)
            ->whereNull('deleted_at')
            ->count();
    }

    /**
     * Generate URL-friendly slug from name
     *
     * Converts name to lowercase, replaces spaces with hyphens, removes special
     * characters (keeps only a-z, 0-9, hyphens), removes consecutive hyphens,
     * trims hyphens from edges, and ensures uniqueness by appending counter
     * (-1, -2, -3, etc.) if slug already exists for the taxonomy type.
     *
     * @param string $name Taxonomy name to convert to slug
     * @param string $type Taxonomy type ('category' or 'tag') for uniqueness check
     * @return string URL-friendly unique slug
     */
    private static function generateSlug($name, $type)
    {
        // Convert to lowercase
        $slug = strtolower($name);

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

        while (TaxonomyModel::where('type', $type)
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

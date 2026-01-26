<?php namespace Lib;

use Models\UserModel;
use Models\MenuModel;
use Models\PostModel;
use Models\CommentModel;
use Models\MenuItemModel;
use Models\TaxonomyModel;
use Models\PostTaxonomyModel;

/**
 * Core Providers - Pressli CMS
 *
 * Registers essential data providers used by themes and templates.
 * Provides common data like related posts, author information, recent content,
 * popular content, and navigation data.
 *
 * REGISTRATION:
 * Call CoreProviders::register() once during application bootstrap
 * before any controllers execute. Providers become available to all
 * templates via ProviderRegistry.
 *
 * PROVIDER CONTEXT:
 * Most providers expect $context['post'] or $context['page'] to be present.
 * Controllers pass current content as context when fetching providers.
 *
 * PROVIDER OPTIONS:
 * Providers accept $options array for customization (limit, filters, etc.)
 * Example: ['limit' => 10, 'exclude_current' => true]
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class CoreProviders
{
    /**
     * Register all core data providers
     *
     * Registers essential providers used across all themes.
     * Called once during application bootstrap to make providers
     * available throughout the application lifecycle.
     *
     * @return void
     */
    public static function register()
    {
        self::registerPostProviders();
        self::registerTaxonomyProvider();
        self::registerCategoryProviders();
        self::registerAuthorProviders();
        self::registerMenuProvider();
        self::registerNavigationProviders();
    }

    /**
     * Register post-related providers
     *
     * Registers four core providers for fetching post content with various filters and sorting:
     *
     * 1. 'related_posts' - Posts in same categories as current post
     *    Context: Requires $context['post'] with 'id' key
     *    Options: ['limit' => int] (default: 5)
     *    Returns: Array of posts with same category tags, ordered by published_at DESC
     *    Query: Joins post_taxonomies to find posts sharing categories, excludes current post
     *
     * 2. 'recent_posts' - Latest published posts
     *    Context: Optional $context['post']['id'] to exclude current post
     *    Options: ['limit' => int] (default: 5)
     *    Returns: Array of posts ordered by published_at DESC
     *    Query: Simple WHERE type='post' AND status='published' with date ordering
     *
     * 3. 'popular_posts' - Most viewed posts
     *    Context: Optional $context['post']['id'] to exclude current post
     *    Options: ['limit' => int] (default: 5)
     *    Returns: Array of posts ordered by view_count DESC
     *    Query: Same as recent_posts but sorted by view_count instead of date
     *
     * 4. 'featured_posts' - Posts manually marked as featured
     *    Context: None required
     *    Options: ['limit' => int] (default: 3)
     *    Returns: Array of posts with meta_key='featured' AND meta_value='1'
     *    Query: Joins post_meta table to find posts with featured flag
     *
     * All providers filter by: type='post', status='published', deleted_at IS NULL.
     * All return arrays with fields: id, title, slug, excerpt, featured_image_id, published_at.
     * Used in theme sidebars, widgets, related content sections, and homepage featured areas.
     *
     * @return void
     */
    protected static function registerPostProviders()
    {
        // Related posts - same category as current post
        ProviderRegistry::register('related_posts', function($context, $options = []) {
            if (!isset($context['post'])) {
                return [];
            }

            $post = $context['post'];
            $limit = $options['limit'] ?? 5;

            // Get post's taxonomy IDs (categories only)
            $taxonomies = PostTaxonomyModel::select(['taxonomy_id'])
                ->where('post_id', $post['id'])
                ->all();

            if (empty($taxonomies)) {
                return [];
            }

            $taxonomyIds = array_column($taxonomies, 'taxonomy_id');

            // Find posts with same taxonomies, excluding current post
            return PostModel::select([
                    'id', 'title', 'slug', 'excerpt',
                    'featured_image_id', 'published_at'
                ])
                ->innerJoin('post_taxonomies', 'posts.id = post_id', [])
                ->where('type', 'post')
                ->where('status', 'published')
                ->where('id != ?', $post['id'])
                ->whereNull('deleted_at')
                ->whereIn('post_taxonomies.taxonomy_id', $taxonomyIds)
                ->unique()
                ->order('published_at', 'desc')
                ->limit($limit)
                ->all();
        });

        // Recent posts - latest published
        ProviderRegistry::register('recent_posts', function($context, $options = []) {
            $limit = $options['limit'] ?? 5;
            $excludeCurrentId = isset($context['post']) ? $context['post']['id'] : null;

            $query = PostModel::select([
                    'id', 'title', 'slug', 'excerpt', 'featured_image_id', 'published_at'
                ])
                ->where('type', 'post')
                ->where('status', 'published')
                ->whereNull('deleted_at')
                ->order('published_at', 'desc')
                ->limit($limit);

            if ($excludeCurrentId) {
                $query->where('id != ?', $excludeCurrentId);
            }

            return $query->all();
        });

        // Popular posts - most viewed
        ProviderRegistry::register('popular_posts', function($context, $options = []) {
            $limit = $options['limit'] ?? 5;
            $excludeCurrentId = isset($context['post']) ? $context['post']['id'] : null;

            $query = PostModel::select([
                    'id', 'title', 'slug', 'excerpt', 'featured_image_id',
                    'published_at', 'view_count'
                ])
                ->where('type', 'post')
                ->where('status', 'published')
                ->whereNull('deleted_at')
                ->order('view_count', 'desc')
                ->limit($limit);

            if ($excludeCurrentId) {
                $query->where('id != ?', $excludeCurrentId);
            }

            return $query->all();
        });

        // Featured posts - manually marked as featured
        ProviderRegistry::register('featured_posts', function($context, $options = []) {
            $limit = $options['limit'] ?? 3;

            return PostModel::select([
                    'posts.id', 'posts.title', 'posts.slug', 'posts.excerpt',
                    'posts.featured_image_id', 'posts.published_at'
                ])
                ->innerJoin('post_meta', 'posts.id = post_id', [])
                ->where('posts.type', 'post')
                ->where('posts.status', 'published')
                ->whereNull('posts.deleted_at')
                ->where('post_meta.meta_key', 'featured')
                ->where('post_meta.meta_value', '1')
                ->order('posts.published_at', 'desc')
                ->limit($limit)
                ->all();
        });

        // Post comments - approved comments for current post
        ProviderRegistry::register('post_comments', function($context, $options = []) {
            if (!isset($context['post'])) {
                return [];
            }

            $post = $context['post'];

            return CommentModel::select([
                    'id', 'author_name', 'author_email', 'author_url',
                    'content', 'created_at', 'parent_id'
                ])
                ->where('post_id', $post['id'])
                ->where('status', 'approved')
                ->order('created_at', 'asc')
                ->all();
        });

        // Post comment count - count of approved comments
        ProviderRegistry::register('comments_count', function($context, $options = []) {
            if (!isset($context['post'])) {
                return 0;
            }

            $post = $context['post'];

            return CommentModel::where('post_id', $post['id'])
                ->where('status', 'approved')
                ->count();
        });
    }

    /**
     * Register optimized taxonomy provider
     *
     * Single provider that fetches all taxonomies (categories + tags) in one query.
     * Returns organized array split by type for easy template access.
     *
     * @return void
     */
    protected static function registerTaxonomyProvider()
    {
        // Site taxonomies - all categories and tags in one query
        ProviderRegistry::register('site_taxonomies', function($context, $options = []) {
            // Single query for all taxonomy types
            $allTaxonomies = TaxonomyModel::whereNull('deleted_at')
                ->order('name', 'asc')
                ->all();

            // Split by type in memory
            $result = [
                'categories' => [],
                'tags' => []
            ];

            foreach ($allTaxonomies as $taxonomy) {
                if ($taxonomy['type'] === 'category') {
                    $result['categories'][] = $taxonomy;
                } elseif ($taxonomy['type'] === 'tag') {
                    $result['tags'][] = $taxonomy;
                }
            }

            return $result;
        });
    }

    /**
     * Register category-related providers
     *
     * Registers three core providers for fetching category and taxonomy data:
     *
     * 1. 'categories' - All categories in the system
     *    Context: None required
     *    Options: None
     *    Returns: Array of all categories ordered by name ASC
     *    Query: Simple SELECT * FROM categories ORDER BY name
     *    Use: Category navigation menus, filter dropdowns, category widgets
     *
     * 2. 'categories_with_count' - Categories with published post counts
     *    Context: None required
     *    Options: None
     *    Returns: Array of categories with additional 'post_count' field
     *    Query: LEFT JOIN post_taxonomies and posts to count published posts per category
     *    Use: Category archives showing post counts, popular categories widget
     *    Performance: Joins 3 tables, use caching for high-traffic sites
     *
     * 3. 'post_categories' - Categories assigned to current post
     *    Context: Requires $context['post'] with 'id' key
     *    Options: None
     *    Returns: Array of categories for specific post, ordered by name ASC
     *    Query: INNER JOIN post_taxonomies on post_id to find assigned categories
     *    Use: Post detail pages showing category tags/badges
     *
     * All category providers return full category records (id, name, slug, description, parent_id).
     * Used in navigation menus, archive pages, post metadata, and filter interfaces.
     *
     * @return void
     */
    protected static function registerCategoryProviders()
    {
        // All categories
        ProviderRegistry::register('categories', function($context, $options = []) {
            return TaxonomyModel::where('type', 'category')
                ->whereNull('deleted_at')
                ->order('name', 'asc')
                ->all();
        });

        // Categories with post count
        ProviderRegistry::register('categories_with_count', function($context, $options = []) {
            // NOTE: This needs raw SQL because Rachie can't do COUNT() in SELECT
            $result = TaxonomyModel::sql(
                'SELECT t.*, COUNT(pt.post_id) as post_count
                 FROM taxonomies t
                 LEFT JOIN post_taxonomies pt ON t.id = pt.taxonomy_id
                 LEFT JOIN posts p ON pt.post_id = p.id
                 AND p.status = ? AND p.type = ? AND p.deleted_at IS NULL
                 WHERE t.type = ? AND t.deleted_at IS NULL
                 GROUP BY t.id
                 ORDER BY t.name ASC',
                'published', 'post', 'category'
            );

            $categories = [];
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $categories[] = $row;
                }
            }

            return $categories;
        });

        // Post categories - categories for current post
        ProviderRegistry::register('post_categories', function($context, $options = []) {
            if (!isset($context['post'])) {
                return [];
            }

            $post = $context['post'];

            return TaxonomyModel::innerJoin('post_taxonomies', 'id = taxonomy_id', [])
                ->where('post_taxonomies.post_id', $post['id'])
                ->where('taxonomies.type', 'category')
                ->whereNull('taxonomies.deleted_at')
                ->order('taxonomies.name', 'asc')
                ->all();
        });
    }

    /**
     * Register author-related providers
     *
     * Registers two core providers for fetching author data and statistics:
     *
     * 1. 'author_bio' - Full author profile information
     *    Context: Requires $context['post'] OR $context['page'] with 'author_id' key
     *    Options: None
     *    Returns: User record with fields: id, first_name, last_name, email, bio, avatar
     *    Query: Simple WHERE id = author_id on users table
     *    Use: Author bylines on posts, author bio boxes, author cards in sidebars
     *    Note: Returns null if no content in context or author_id missing
     *
     * 2. 'author_post_count' - Number of published posts by author
     *    Context: Requires $context['post'] OR $context['page'] with 'author_id' key
     *    Options: None
     *    Returns: Integer count of published posts by this author
     *    Query: COUNT WHERE author_id AND type='post' AND status='published'
     *    Use: Author profile pages, "More from this author" sections
     *    Note: Returns 0 if no content in context or author_id missing
     *
     * Both providers work with posts AND pages - they check for author_id in either.
     * Used in post/page detail views, author archive pages, and contributor listings.
     * Sensitive data (password, tokens) deliberately excluded from author_bio query.
     *
     * @return void
     */
    protected static function registerAuthorProviders()
    {
        // Author bio - full author information
        ProviderRegistry::register('author_bio', function($context, $options = []) {
            $content = $context['post'] ?? $context['page'] ?? null;

            if (!$content || !isset($content['author_id'])) {
                return null;
            }

            return UserModel::select([
                    'id', 'first_name', 'last_name', 'email', 'bio', 'avatar'
                ])
                ->where('id', $content['author_id'])
                ->first();
        });

        // Author post count
        ProviderRegistry::register('author_post_count', function($context, $options = []) {
            $content = $context['post'] ?? $context['page'] ?? null;

            if (!$content || !isset($content['author_id'])) {
                return 0;
            }

            return PostModel::where('author_id', $content['author_id'])
                ->where('type', 'post')
                ->where('status', 'published')
                ->whereNull('deleted_at')
                ->count();
        });
    }

    /**
     * Register optimized menu provider
     *
     * Single provider that fetches all active menus and their items in two queries.
     * Returns organized array keyed by location for easy template access.
     *
     * @return void
     */
    protected static function registerMenuProvider()
    {
        // Site menus - all menus for all locations in two queries
        ProviderRegistry::register('site_menus', function($context, $options = []) {
            // Query 1: Get all active menus
            $menus = MenuModel::where('status', 'active')
                ->whereNotNull('location')
                ->all();

            if (empty($menus)) {
                return [];
            }

            // Extract menu IDs
            $menuIds = array_column($menus, 'id');

            // Query 2: Get all menu items for these menus
            $allItems = MenuItemModel::whereIn('menu_id', $menuIds)
                ->where('status', 'active')
                ->order('sort_order', 'asc')
                ->all();

            // Organize items by menu_id in memory
            $itemsByMenu = [];
            foreach ($allItems as $item) {
                $itemsByMenu[$item['menu_id']][] = $item;
            }

            // Build final structure organized by location
            $result = [];
            foreach ($menus as $menu) {
                $items = $itemsByMenu[$menu['id']] ?? [];

                // Build hierarchical tree (1 level nesting)
                $tree = [];
                $children = [];

                // First pass: separate parents and children
                foreach ($items as $item) {
                    if ($item['parent_id']) {
                        $children[$item['parent_id']][] = $item;
                    } else {
                        $tree[] = $item;
                    }
                }

                // Second pass: attach children to parents
                foreach ($tree as &$parent) {
                    if (isset($children[$parent['id']])) {
                        $parent['children'] = $children[$parent['id']];
                    } else {
                        $parent['children'] = [];
                    }
                }

                $result[$menu['location']] = $tree;
            }

            return $result;
        });
    }

    /**
     * Register navigation-related providers
     *
     * Registers two core providers for site navigation and menu systems:
     *
     * 1. 'primary_menu' - Menu items for a specific menu location
     *    Context: None required
     *    Options: ['location' => string] (default: 'primary')
     *    Returns: Array of menu items ordered by position ASC, or empty array if menu not found
     *    Query: First finds menu by location, then fetches all menu_items for that menu
     *    Use: Header navigation, footer menus, any registered menu location
     *    Common locations: 'primary', 'footer', 'mobile', 'sidebar'
     *    Note: Returns empty array if no menu assigned to location
     *
     * 2. 'page_hierarchy' - All published pages for navigation
     *    Context: Optional $context['page']['id'] to mark current page
     *    Options: None
     *    Returns: Flat array of all pages ordered by menu_order ASC
     *    Query: WHERE type='page' AND status='published' with parent_id for hierarchy
     *    Use: Page navigation trees, sitemap generation, breadcrumb trails
     *    Note: Currently returns flat array - can be enhanced to build tree structure
     *    Fields: id, title, slug, parent_id, menu_order for hierarchy building
     *
     * Both providers used in theme headers, footers, and sidebar navigation areas.
     * Menu items include: id, title, url, target, css_class for full customization.
     * Page hierarchy can be recursively processed in templates to build nested menus.
     *
     * @return void
     */
    protected static function registerNavigationProviders()
    {
        // Primary menu
        ProviderRegistry::register('primary_menu', function($context, $options = []) {
            $menuLocation = $options['location'] ?? 'primary';

            // Find menu by location
            $menu = MenuModel::where('location', $menuLocation)
                ->where('status', 'active')
                ->first();

            if (!$menu) {
                return [];
            }

            // Get all menu items ordered by sort_order
            $items = MenuItemModel::where('menu_id', $menu['id'])
                ->where('status', 'active')
                ->order('sort_order', 'asc')
                ->all();

            // Build hierarchical tree (1 level nesting)
            $tree = [];
            $children = [];

            // First pass: separate parents and children
            foreach ($items as $item) {
                if ($item['parent_id']) {
                    $children[$item['parent_id']][] = $item;
                } else {
                    $tree[] = $item;
                }
            }

            // Second pass: attach children to parents
            foreach ($tree as &$parent) {
                if (isset($children[$parent['id']])) {
                    $parent['children'] = $children[$parent['id']];
                } else {
                    $parent['children'] = [];
                }
            }

            return $tree;
        });

        // Page hierarchy - for page navigation
        ProviderRegistry::register('page_hierarchy', function($context, $options = []) {
            $currentPageId = isset($context['page']) ? $context['page']['id'] : null;

            // Get top-level pages
            $pages = PostModel::select(['id', 'title', 'slug', 'parent_id', 'menu_order'])
                ->where('type', 'page')
                ->where('status', 'published')
                ->whereNull('deleted_at')
                ->order('menu_order', 'asc')
                ->all();

            // Build hierarchy (simple flat array for now - can enhance later)
            return $pages;
        });
    }
}

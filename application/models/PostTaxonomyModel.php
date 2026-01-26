<?php namespace Models;

use Rackage\Model;

/**
 * Post Taxonomy Model - Pressli CMS
 *
 * Junction table implementing many-to-many relationship between posts and taxonomies.
 * Enables posts to have multiple categories and tags, and taxonomies to be assigned
 * to multiple posts. CASCADE deletes ensure referential integrity when either side removed.
 *
 * USAGE:
 * - Assign taxonomy to post: PostTaxonomyModel::save(['post_id' => 5, 'taxonomy_id' => 2])
 * - Remove taxonomy: PostTaxonomyModel::where('post_id', 5)->where('taxonomy_id', 2)->delete()
 * - Get post's taxonomies: TaxonomyModel::innerJoin('post_taxonomies', '...')->where('post_id', 5)
 * - Get taxonomy's posts: PostModel::innerJoin('post_taxonomies', '...')->where('taxonomy_id', 2)
 *
 * IMPORTANT: Update taxonomy.post_count when adding/removing assignments
 *
 * Table: post_taxonomies
 * Primary Key: id (auto-increment)
 * Foreign Keys: post_id → posts(id), taxonomy_id → taxonomies(id)
 *
 * @compositeUnique (post_id, taxonomy_id)
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class PostTaxonomyModel extends Model
{
    protected static $table = 'post_taxonomies';
    protected static $timestamps = false;

    /**
     * Unique junction record identifier
     *
     * Auto-incremented primary key.
     * Rarely used directly in queries (use post_id + taxonomy_id instead).
     *
     * @column
     * @autonumber
     */
    protected $id;

    /**
     * Post identifier
     *
     * Foreign key to posts table.
     * CASCADE delete removes this record when post deleted.
     *
     * @column
     * @int
     * @unsigned
     * @index
     * @foreign posts(id)
     * @ondelete CASCADE
     */
    protected $post_id;

    /**
     * Taxonomy identifier (category or tag)
     *
     * Foreign key to taxonomies table.
     * CASCADE delete removes this record when taxonomy deleted.
     *
     * @column
     * @int
     * @unsigned
     * @index
     * @foreign taxonomies(id)
     * @ondelete CASCADE
     */
    protected $taxonomy_id;
}


<?php namespace Models;

use Rackage\Model;

/**
 * Plugin Model - Pressli CMS
 *
 * Manages installed plugins and their metadata. Tracks plugin state
 * (active/inactive), version info, and configuration settings.
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class PluginModel extends Model
{
    protected static $table = 'plugins';
    protected static $timestamps = true;

    /**
     * Unique plugin identifier
     * @column
     * @autonumber
     */
    protected $id;

    /**
     * Plugin slug (directory name)
     * @column
     * @varchar 100
     * @unique
     */
    protected $slug;

    /**
     * Plugin display name
     * @column
     * @varchar 255
     */
    protected $name;

    /**
     * Plugin version number
     * @column
     * @varchar 20
     */
    protected $version;

    /**
     * Plugin description
     * @column
     * @text
     * @nullable
     */
    protected $description;

    /**
     * Plugin author name
     * @column
     * @varchar 100
     * @nullable
     */
    protected $author;

    /**
     * Plugin author website
     * @column
     * @varchar 255
     * @nullable
     */
    protected $author_uri;

    /**
     * Plugin activation status
     * @column
     * @enum active,inactive
     * @default inactive
     * @index
     */
    protected $status;

    /**
     * Plugin configuration data
     * @column
     * @json
     * @nullable
     */
    protected $config;

    /**
     * When plugin was installed
     * @column
     * @datetime
     * @nullable
     */
    protected $created_at;

    /**
     * When plugin was last updated
     * @column
     * @datetime
     * @nullable
     */
    protected $updated_at;
}

<?php namespace Models;

use Rackage\Model;

/**
 * Media Model - Pressli CMS
 *
 * Central media library for uploaded files. Stores file metadata (dimensions, MIME type,
 * size) and supports categorization by type (image/video/document/audio). Files are stored
 * in public/uploads/ with year/month organization.
 *
 * RELATIONSHIPS:
 * - Author: Many media belong to one user (RESTRICT delete)
 *
 * FILE TYPES:
 * - image: JPEG, PNG, GIF, WebP
 * - video: MP4, WebM, AVI
 * - document: PDF, DOCX, XLSX
 * - audio: MP3, WAV, OGG
 * - other: ZIP, TXT, etc.
 *
 * Table: media
 * Primary Key: id (auto-increment)
 * Foreign Keys: author_id → users(id)
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class MediaModel extends Model
{
    protected static $table = 'media';
    protected static $timestamps = true;

    /**
     * Unique media identifier
     *
     * Auto-incremented primary key for media library items.
     *
     * @column
     * @autonumber
     */
    protected $id;

    /**
     * Original filename
     *
     * Filename as uploaded by user (e.g., "vacation-photo.jpg").
     * Preserved for display and download purposes.
     *
     * @column
     * @varchar 255
     */
    protected $filename;

    /**
     * Stored file path
     *
     * Relative path from public/ directory (e.g., "uploads/2024/01/abc123.jpg").
     * Used to locate and serve the file.
     *
     * @column
     * @varchar 500
     * @index
     */
    protected $file_path;

    /**
     * File type category
     *
     * Broad category for filtering: image, video, document, audio, other.
     * Used in media library filtering and icon display.
     *
     * @column
     * @enum image,video,document,audio,other
     * @default other
     * @index
     */
    protected $file_type;

    /**
     * MIME type
     *
     * Actual MIME type (e.g., "image/jpeg", "application/pdf").
     * Detected during upload for proper content serving.
     *
     * @column
     * @varchar 100
     */
    protected $mime_type;

    /**
     * File size in bytes
     *
     * Used for storage tracking and display in human-readable format.
     * Stored as bigint to support files over 4GB.
     *
     * @column
     * @bigint
     * @unsigned
     */
    protected $file_size;

    /**
     * Image width in pixels
     *
     * NULL for non-image files.
     * Used for responsive image sizing and dimension display.
     *
     * @column
     * @int
     * @unsigned
     * @nullable
     */
    protected $width;

    /**
     * Image height in pixels
     *
     * NULL for non-image files.
     * Used for aspect ratio calculation and dimension display.
     *
     * @column
     * @int
     * @unsigned
     * @nullable
     */
    protected $height;

    /**
     * Alternative text for images
     *
     * Accessibility description for screen readers.
     * Required for WCAG compliance on public-facing images.
     *
     * @column
     * @varchar 255
     * @nullable
     */
    protected $alt_text;

    /**
     * Media title
     *
     * Display title for the media item.
     * Defaults to filename if not provided.
     *
     * @column
     * @varchar 255
     * @nullable
     */
    protected $title;

    /**
     * Media description
     *
     * Longer description or caption for the media.
     * Used in media library and attachment details.
     *
     * @column
     * @text
     * @nullable
     */
    protected $description;

    /**
     * User who uploaded the file
     *
     * Author/uploader user ID for attribution and permissions.
     * RESTRICT: Cannot delete user with uploaded media.
     *
     * @column
     * @int
     * @unsigned
     * @index
     * @foreign users(id)
     * @ondelete RESTRICT
     */
    protected $author_id;

    /**
     * Upload timestamp
     *
     * When file was uploaded to the media library.
     * Auto-set by Rachie when $timestamps = true.
     *
     * @column
     * @datetime
     * @nullable
     */
    protected $created_at;

    /**
     * Last metadata update timestamp
     *
     * When title, alt text, or other metadata was last modified.
     * Auto-updated by Rachie on every save().
     *
     * @column
     * @datetime
     * @nullable
     */
    protected $updated_at;

    /**
     * Soft delete timestamp
     *
     * When media was moved to trash. NULL for active media.
     * Allows recovery before permanent deletion.
     *
     * @column
     * @datetime
     * @nullable
     * @index
     */
    protected $deleted_at;
}

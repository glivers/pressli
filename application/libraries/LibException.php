<?php namespace Lib;

/**
 * Library Exception Handler - Pressli CMS
 *
 * Handles all exceptions thrown by classes in the Lib namespace including services,
 * helpers, utilities, and custom libraries. Extends Rachie's ExceptionClass to ensure
 * unified error handling with logging, dev/prod mode display, and custom error pages.
 *
 * FEATURES:
 * - Inherits error logging from ExceptionClass
 * - Inherits dev/prod mode handling (stack trace in dev, friendly message in prod)
 * - Inherits stack trace formatting from ExceptionClass
 * - Provides library-specific exception type for targeted catch blocks
 *
 * USAGE:
 * In any Lib class (services, helpers, utilities):
 *   throw new LibException("Category name is required");
 *   throw new LibException("Invalid file format");
 *   throw new LibException("Slug already exists");
 *
 * In controllers (exceptions bubble up and log automatically via ExceptionClass):
 *   try {
 *       $id = Taxonomy::create($data, 'category');
 *   }
 *   catch (LibException $e) {
 *       Redirect::back()->flash('error', $e->getMessage());
 *   }
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */

use Exceptions\ExceptionClass;

class LibException extends ExceptionClass {}

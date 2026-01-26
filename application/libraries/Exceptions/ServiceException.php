<?php namespace Lib\Exceptions;

use Lib\LibException;

/**
 * Service Exception Handler - Pressli CMS
 *
 * Handles validation and business logic exceptions thrown by service classes.
 * Extends LibException to provide service-specific exception type with guarantee
 * that error messages are user-friendly and safe to display directly to users.
 *
 * PURPOSE:
 * ServiceException is specifically for user-facing errors (validation failures,
 * business rule violations) that should be displayed to users via flash messages
 * or API error responses. Messages are always single-line, descriptive, and
 * never contain technical details, stack traces, or sensitive information.
 *
 * USAGE:
 * In service classes (validation and business logic errors):
 *   throw new ServiceException("Category name is required");
 *   throw new ServiceException("Slug already exists");
 *   throw new ServiceException("A category cannot be its own parent");
 *
 * In controllers (safe to show users):
 *   try {
 *       $id = Taxonomy::create($data, 'category');
 *   }
 *   catch (ServiceException $e) {
 *       // Guaranteed user-friendly message
 *       Session::flash('error', $e->getMessage());
 *       Redirect::back();
 *   }
 *
 * EXCEPTION HIERARCHY:
 * - LibException (technical errors from any Lib class)
 *   └── ServiceException (user-friendly validation/business errors)
 *
 * WHY SEPARATE FROM LibException:
 * LibException catches ALL Lib namespace errors including technical ones
 * from helpers and utilities. ServiceException guarantees message is safe
 * to display to users without exposing system internals.
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 0.0.1
 */
class ServiceException extends LibException {}

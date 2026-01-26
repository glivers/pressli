<?php namespace Plugins\Jobs;

use Lib\Plugin;
use Lib\ContentRegistry;

/**
 * Jobs Plugin - Pressli CMS
 *
 * Provides job listing functionality for recruitment sites.
 * Displays job postings with salary, location, and apply functionality.
 *
 * @author Pressli Team
 * @copyright Copyright (c) 2015 - 2030 Pressli Team
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 1.0.0
 */
class JobsPlugin extends Plugin
{
    /**
     * Boot the plugin
     *
     * Called when plugin is active. Registers routes, content types,
     * and any other initialization logic.
     *
     * @return void
     */
    public function boot()
    {
        // Register job content type with routing
        ContentRegistry::register('job', [
            'label' => 'Jobs',
            'route' => 'jobs',
            'controller' => \Plugins\Jobs\JobsController::class,
            'searchable' => true,
        ]);
    }

    /**
     * Activate the plugin
     *
     * Called when plugin is first activated. Creates database tables,
     * sets default options, or performs one-time setup.
     *
     * @return void
     */
    public function activate()
    {
        // Create jobs table (if using dedicated table)
        // For this demo, we'll use the posts table with type='job'
    }

    /**
     * Deactivate the plugin
     *
     * Called when plugin is deactivated. Cleanup tasks, remove cron jobs,
     * but keep data intact.
     *
     * @return void
     */
    public function deactivate()
    {
        // Unregister content type
        ContentRegistry::unregister('job');
    }
}

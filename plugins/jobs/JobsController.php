<?php namespace Plugins\Jobs;

use Models\PostModel;
use Rackage\Input;

/**
 * Jobs Controller
 *
 * Handles all /jobs/* URLs via plugin routing system.
 * Registered route: 'jobs' -> JobsController
 *
 * URL Patterns:
 * - /jobs                    → Job archive (paginated list)
 * - /jobs/software-engineer  → Single job view
 *
 * Returns data arrays for PageController to render.
 * Does NOT render directly - maintains theme control.
 *
 * @author Pressli Team
 * @version 1.0.0
 */
class JobsController
{
    /**
     * Handle job requests
     *
     * @param string $slug Full URL slug (e.g., "jobs/software-engineer")
     * @return array|null Data array or null for 404
     */
    public function run($slug)
    {
        $parts = explode('/', $slug);
        array_shift($parts);

        if (empty($parts) || empty($parts[0])) {
            return $this->archive();
        }

        return $this->single($parts[0]);
    }

    /**
     * Job archive listing
     *
     * @return array Data for rendering
     */
    protected function archive()
    {
        $page = (int) (Input::get('page') ?? 1);
        $result = PostModel::select(['id', 'title', 'slug', 'excerpt', 'created_at'])
            ->where('type', 'job')
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->order('created_at', 'desc')
            ->paginate(10, $page);

        return [
            'type' => 'job-archive',
            'template' => 'jobs/archive',
            'data' => [
                'jobs' => $result->data,
                'pagination' => [
                    'current_page' => $result->current_page,
                    'last_page' => $result->last_page,
                    'total' => $result->total,
                ],
            ]
        ];
    }

    /**
     * Single job view
     *
     * @param string $jobSlug Job slug
     * @return array|null Data for rendering or null if not found
     */
    protected function single($jobSlug)
    {
        $job = PostModel::select(['id', 'title', 'slug', 'content', 'excerpt', 'created_at'])
            ->where('type', 'job')
            ->where('slug', $jobSlug)
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->first();

        if (!$job) {
            return null;
        }

        $relatedJobs = PostModel::select(['id', 'title', 'slug'])
            ->where('type', 'job')
            ->where('status', 'published')
            ->where('id !=', $job['id'])
            ->whereNull('deleted_at')
            ->limit(3)
            ->all();

        return [
            'type' => 'job-single',
            'template' => 'jobs/single',
            'data' => [
                'job' => $job,
                'related_jobs' => $relatedJobs,
            ]
        ];
    }
}

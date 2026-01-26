<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job['title'] }} - Jobs</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; line-height: 1.6; color: #333; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        header { background: #2c3e50; color: white; padding: 20px 0; margin-bottom: 30px; }
        header a { color: white; text-decoration: none; }
        header a:hover { text-decoration: underline; }
        .job-header { background: white; padding: 30px; margin-bottom: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .job-header h1 { font-size: 32px; margin-bottom: 15px; color: #2c3e50; }
        .job-header .meta { color: #666; margin-bottom: 20px; }
        .job-header .apply-btn { display: inline-block; background: #27ae60; color: white; padding: 12px 30px; text-decoration: none; border-radius: 4px; font-weight: bold; }
        .job-header .apply-btn:hover { background: #229954; }
        .job-content { background: white; padding: 30px; margin-bottom: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .job-content h2 { margin-top: 20px; margin-bottom: 10px; color: #2c3e50; }
        .related { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .related h2 { margin-bottom: 20px; color: #2c3e50; }
        .related-job { padding: 15px; border-left: 3px solid #3498db; margin-bottom: 15px; background: #f8f9fa; }
        .related-job h3 { font-size: 18px; margin-bottom: 5px; }
        .related-job a { color: #3498db; text-decoration: none; }
        .related-job a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <a href="{{ Url::link('jobs') }}">&larr; Back to Jobs</a>
        </div>
    </header>

    <div class="container">
        <div class="job-header">
            <h1>{{ $job['title'] }}</h1>
            <div class="meta">Posted: {{ Date::format($job['created_at'], 'M j, Y') }}</div>
            <a href="#" class="apply-btn">Apply Now</a>
        </div>

        <div class="job-content">
            {{{ $job['content'] or $job['excerpt'] or 'No description available' }}}
        </div>

        @if(!empty($related_jobs))
            <div class="related">
                <h2>Related Jobs</h2>
                @foreach($related_jobs as $related)
                    <div class="related-job">
                        <h3><a href="{{ Url::link('jobs', $related['slug']) }}">{{ $related['title'] }}</a></h3>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>

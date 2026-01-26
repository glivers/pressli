<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs - Pressli</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; line-height: 1.6; color: #333; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        header { background: #2c3e50; color: white; padding: 20px 0; margin-bottom: 30px; }
        h1 { font-size: 32px; margin-bottom: 10px; }
        .job-card { background: white; padding: 20px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .job-card h2 { font-size: 24px; margin-bottom: 10px; color: #2c3e50; }
        .job-card .excerpt { color: #666; margin-bottom: 15px; }
        .job-card .meta { font-size: 14px; color: #999; }
        .job-card a { display: inline-block; background: #3498db; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; margin-top: 10px; }
        .job-card a:hover { background: #2980b9; }
        .pagination { text-align: center; margin-top: 30px; }
        .pagination a { display: inline-block; padding: 8px 16px; margin: 0 4px; background: white; border-radius: 4px; text-decoration: none; color: #3498db; }
        .pagination a:hover { background: #3498db; color: white; }
        .pagination .active { background: #3498db; color: white; }
        .empty { text-align: center; padding: 60px 20px; }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Job Listings</h1>
            <p>Find your next opportunity</p>
        </div>
    </header>

    <div class="container">
        @loopelse($jobs as $job)
            <div class="job-card">
                <h2>{{ $job['title'] }}</h2>
                <div class="excerpt">{{ $job['excerpt'] or 'No description available' }}</div>
                <div class="meta">Posted: {{ Date::format($job['created_at'], 'M j, Y') }}</div>
                <a href="{{ Url::link('jobs', $job['slug']) }}">View Details</a>
            </div>
        @empty
            <div class="empty">
                <h2>No jobs available</h2>
                <p>Check back soon for new opportunities!</p>
            </div>
        @endloop

        @if($pagination['last_page'] > 1)
            <div class="pagination">
                @if($pagination['current_page'] > 1)
                    <a href="?page={{ $pagination['current_page'] - 1 }}">Previous</a>
                @endif

                @for($i = 1; $i <= $pagination['last_page']; $i++)
                    <a href="?page={{ $i }}" class="{{ $i === $pagination['current_page'] ? 'active' : '' }}">{{ $i }}</a>
                @endfor

                @if($pagination['current_page'] < $pagination['last_page'])
                    <a href="?page={{ $pagination['current_page'] + 1 }}">Next</a>
                @endif
            </div>
        @endif
    </div>
</body>
</html>

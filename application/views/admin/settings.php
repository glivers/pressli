@extends('admin/layout')

@section('content')

        <!-- Settings Content -->
        <main class="content">
            <div class="content-header">
                <h1 class="page-title">Settings</h1>
            </div>

            @if(Session::hasFlash('success'))
                <div class="alert alert-success" style="margin-bottom: 1.5rem;">
                    {{ Session::flash('success') }}
                </div>
            @endif

            @if(Session::hasFlash('error'))
                <div class="alert alert-error" style="margin-bottom: 1.5rem;">
                    {{ Session::flash('error') }}
                </div>
            @endif

            <form method="POST" action="{{ Url::link('admin/settings/update') }}">
                {{{ Csrf::field() }}}

                <div class="settings-container">
                <!-- General Settings -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">General</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label" for="site-title">Site Title</label>
                            <input type="text" id="site-title" name="site-title" class="text-input" value="{{ $settings['site_title'] ?? 'Pressli CMS' }}">
                            <p class="form-help">The name of your website</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="site-tagline">Tagline</label>
                            <input type="text" id="site-tagline" name="site-tagline" class="text-input" value="{{ $settings['site_tagline'] ?? 'Just another Pressli site' }}">
                            <p class="form-help">A short description of your site</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="site-url">Site URL</label>
                            <input type="url" id="site-url" name="site-url" class="text-input" value="{{ Url::base() }}" readonly>
                            <p class="form-help">The URL where your site can be accessed</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="admin-email">Administration Email</label>
                            <input type="email" id="admin-email" name="admin-email" class="text-input" value="{{ $settings['admin_email'] ?? 'admin@pressli.com' }}">
                            <p class="form-help">This email is used for admin purposes and notifications</p>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="timezone">Timezone</label>
                                <select id="timezone" name="timezone" class="select-input">
                                    <option value="UTC" {{ ($settings['timezone'] ?? 'America/New_York') == 'UTC' ? 'selected' : '' }}>UTC</option>
                                    <option value="America/New_York" {{ ($settings['timezone'] ?? 'America/New_York') == 'America/New_York' ? 'selected' : '' }}>Eastern Time (New York)</option>
                                    <option value="America/Chicago" {{ ($settings['timezone'] ?? '') == 'America/Chicago' ? 'selected' : '' }}>Central Time (Chicago)</option>
                                    <option value="America/Los_Angeles" {{ ($settings['timezone'] ?? '') == 'America/Los_Angeles' ? 'selected' : '' }}>Pacific Time (Los Angeles)</option>
                                    <option value="Europe/London" {{ ($settings['timezone'] ?? '') == 'Europe/London' ? 'selected' : '' }}>London</option>
                                    <option value="Europe/Paris" {{ ($settings['timezone'] ?? '') == 'Europe/Paris' ? 'selected' : '' }}>Paris</option>
                                    <option value="Asia/Tokyo" {{ ($settings['timezone'] ?? '') == 'Asia/Tokyo' ? 'selected' : '' }}>Tokyo</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="date-format">Date Format</label>
                                <select id="date-format" name="date-format" class="select-input">
                                    <option value="F j, Y" {{ ($settings['date_format'] ?? 'F j, Y') == 'F j, Y' ? 'selected' : '' }}>January 14, 2026</option>
                                    <option value="Y-m-d" {{ ($settings['date_format'] ?? '') == 'Y-m-d' ? 'selected' : '' }}>2026-01-14</option>
                                    <option value="m/d/Y" {{ ($settings['date_format'] ?? '') == 'm/d/Y' ? 'selected' : '' }}>01/14/2026</option>
                                    <option value="d/m/Y" {{ ($settings['date_format'] ?? '') == 'd/m/Y' ? 'selected' : '' }}>14/01/2026</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="time-format">Time Format</label>
                                <select id="time-format" name="time-format" class="select-input">
                                    <option value="g:i a" {{ ($settings['time_format'] ?? 'g:i a') == 'g:i a' ? 'selected' : '' }}>3:45 pm</option>
                                    <option value="g:i A" {{ ($settings['time_format'] ?? '') == 'g:i A' ? 'selected' : '' }}>3:45 PM</option>
                                    <option value="H:i" {{ ($settings['time_format'] ?? '') == 'H:i' ? 'selected' : '' }}>15:45</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="week-starts-on">Week Starts On</label>
                                <select id="week-starts-on" name="week-starts-on" class="select-input">
                                    <option value="0" {{ ($settings['week_starts_on'] ?? '1') == '0' ? 'selected' : '' }}>Sunday</option>
                                    <option value="1" {{ ($settings['week_starts_on'] ?? '1') == '1' ? 'selected' : '' }}>Monday</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Save All Settings</button>
                        </div>
                    </div>
                </div>

                <!-- Reading Settings -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Reading</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Your homepage displays</label>
                            <div class="radio-group">
                                <label class="radio-label">
                                    <input type="radio" name="homepage-type" value="posts" {{ ($settings['homepage_type'] ?? 'posts') == 'posts' ? 'checked' : '' }}>
                                    <span>Your latest posts</span>
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="homepage-type" value="page" {{ ($settings['homepage_type'] ?? '') == 'page' ? 'checked' : '' }}>
                                    <span>A static page</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group" id="homepage-page-select" style="display: {{ ($settings['homepage_type'] ?? '') == 'page' ? 'block' : 'none' }};">
                            <label class="form-label" for="homepage-page-id">Select page:</label>
                            <select id="homepage-page-id" name="homepage-page-id" class="select-input">
                                <option value="">— Select —</option>
                                @foreach($pages as $page)
                                    <option value="{{ $page['id'] }}" {{ ($settings['homepage_page_id'] ?? '') == $page['id'] ? 'selected' : '' }}>
                                        {{ $page['title'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="posts-per-page">Posts per page</label>
                                <input type="number" id="posts-per-page" name="posts-per-page" class="text-input" value="{{ $settings['posts_per_page'] ?? '10' }}" min="1" max="100">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="syndication-feeds">Syndication feeds show</label>
                                <input type="number" id="syndication-feeds" name="syndication-feeds" class="text-input" value="{{ $settings['syndication_feeds'] ?? '10' }}" min="1" max="50">
                                <p class="form-help">Most recent items</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" class="checkbox" id="search-engine-visibility" name="search-engine-visibility" value="1" {{ ($settings['search_engine_visibility'] ?? '0') == '1' ? 'checked' : '' }}>
                                <span>Discourage search engines from indexing this site</span>
                            </label>
                            <p class="form-help">It is up to search engines to honor this request</p>
                        </div>
                    </div>
                </div>

                <!-- Discussion Settings -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Discussion</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Default post settings</label>
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" class="checkbox" id="allow-comments" name="allow-comments" value="1" {{ ($settings['allow_comments'] ?? '1') == '1' ? 'checked' : '' }}>
                                    <span>Allow people to submit comments on new posts</span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" class="checkbox" id="allow-pingbacks" name="allow-pingbacks" value="1" {{ ($settings['allow_pingbacks'] ?? '0') == '1' ? 'checked' : '' }}>
                                    <span>Allow link notifications from other blogs (pingbacks and trackbacks)</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Comment moderation</label>
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" class="checkbox" id="comments-manual-approval" name="comments-manual-approval" value="1" {{ ($settings['comments_manual_approval'] ?? '1') == '1' ? 'checked' : '' }}>
                                    <span>Comments must be manually approved</span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" class="checkbox" id="comment-author-approved" name="comment-author-approved" value="1" {{ ($settings['comment_author_approved'] ?? '0') == '1' ? 'checked' : '' }}>
                                    <span>Comment author must have a previously approved comment</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="hold-comments-links">Hold a comment if it contains</label>
                            <input type="number" id="hold-comments-links" name="hold-comments-links" class="text-input" value="{{ $settings['hold_comments_links'] ?? '2' }}" min="0">
                            <p class="form-help">or more links (common indicator of spam)</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="disallowed-keys">Disallowed comment keys</label>
                            <textarea id="disallowed-keys" name="disallowed-keys" class="textarea-input" rows="5" placeholder="One word or IP per line. Comments containing these will be marked as spam.">{{ $settings['disallowed_keys'] ?? '' }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" class="checkbox" id="show-avatars" name="show-avatars" value="1" {{ ($settings['show_avatars'] ?? '1') == '1' ? 'checked' : '' }}>
                                <span>Show avatars</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Media Settings -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Media</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Image sizes</label>
                            <p class="text-secondary" style="margin-bottom: 16px;">The sizes listed below determine the maximum dimensions in pixels to use when adding an image.</p>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="thumbnail-width">Thumbnail width</label>
                                <input type="number" id="thumbnail-width" name="thumbnail-width" class="text-input" value="{{ $settings['thumbnail_width'] ?? '150' }}" min="0">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="thumbnail-height">Thumbnail height</label>
                                <input type="number" id="thumbnail-height" name="thumbnail-height" class="text-input" value="{{ $settings['thumbnail_height'] ?? '150' }}" min="0">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="medium-width">Medium width</label>
                                <input type="number" id="medium-width" name="medium-width" class="text-input" value="{{ $settings['medium_width'] ?? '300' }}" min="0">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="medium-height">Medium height</label>
                                <input type="number" id="medium-height" name="medium-height" class="text-input" value="{{ $settings['medium_height'] ?? '300' }}" min="0">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="large-width">Large width</label>
                                <input type="number" id="large-width" name="large-width" class="text-input" value="{{ $settings['large_width'] ?? '1024' }}" min="0">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="large-height">Large height</label>
                                <input type="number" id="large-height" name="large-height" class="text-input" value="{{ $settings['large_height'] ?? '1024' }}" min="0">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Permalinks Settings -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Permalinks</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Permalink structure</label>
                            <div class="radio-group">
                                <label class="radio-label">
                                    <input type="radio" name="permalink" value="plain" {{ ($settings['permalink_structure'] ?? 'postname') == 'plain' ? 'checked' : '' }}>
                                    <span>Plain: <code>https://pressli.com/?p=123</code></span>
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="permalink" value="day" {{ ($settings['permalink_structure'] ?? 'postname') == 'day' ? 'checked' : '' }}>
                                    <span>Day and name: <code>https://pressli.com/2026/01/14/sample-post/</code></span>
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="permalink" value="month" {{ ($settings['permalink_structure'] ?? 'postname') == 'month' ? 'checked' : '' }}>
                                    <span>Month and name: <code>https://pressli.com/2026/01/sample-post/</code></span>
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="permalink" value="numeric" {{ ($settings['permalink_structure'] ?? 'postname') == 'numeric' ? 'checked' : '' }}>
                                    <span>Numeric: <code>https://pressli.com/archives/123</code></span>
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="permalink" value="postname" {{ ($settings['permalink_structure'] ?? 'postname') == 'postname' ? 'checked' : '' }}>
                                    <span>Post name: <code>https://pressli.com/sample-post/</code></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="custom-permalink">Custom structure</label>
                            <input type="text" id="custom-permalink" name="custom-permalink" class="text-input" value="{{ $settings['custom_permalink'] ?? '' }}" placeholder="/%year%/%monthnum%/%postname%/">
                            <p class="form-help">Available tags: %year% %monthnum% %day% %hour% %minute% %second% %postname% %post_id% %category%</p>
                        </div>
                    </div>
                </div>

                <!-- Privacy Settings -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Privacy</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label" for="privacy-page">Privacy Policy page</label>
                            <select id="privacy-page" name="privacy-page" class="select-input">
                                <option value="">— Select —</option>
                                <option value="privacy-policy" {{ ($settings['privacy_page'] ?? '') == 'privacy-policy' ? 'selected' : '' }}>Privacy Policy</option>
                                <option value="about" {{ ($settings['privacy_page'] ?? '') == 'about' ? 'selected' : '' }}>About</option>
                                <option value="contact" {{ ($settings['privacy_page'] ?? '') == 'contact' ? 'selected' : '' }}>Contact</option>
                            </select>
                            <p class="form-help">This page will be used for privacy policy link in footer</p>
                        </div>

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" class="checkbox" id="user-registration" name="user-registration" value="1" {{ ($settings['user_registration'] ?? '1') == '1' ? 'checked' : '' }}>
                                <span>Enable user registration</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="default-role">New user default role</label>
                            <select id="default-role" name="default-role" class="select-input">
                                <option value="subscriber" {{ ($settings['default_role'] ?? 'subscriber') == 'subscriber' ? 'selected' : '' }}>Subscriber</option>
                                <option value="author" {{ ($settings['default_role'] ?? 'subscriber') == 'author' ? 'selected' : '' }}>Author</option>
                                <option value="editor" {{ ($settings['default_role'] ?? 'subscriber') == 'editor' ? 'selected' : '' }}>Editor</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </main>
@endsection

@section('scripts')
    @parent
    <script>
        // Show/hide homepage page selector based on homepage type
        const homepageTypeRadios = document.querySelectorAll('input[name="homepage-type"]');
        const pageSelect = document.getElementById('homepage-page-select');

        homepageTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'page') {
                    pageSelect.style.display = 'block';
                }
                else {
                    pageSelect.style.display = 'none';
                }
            });
        });
    </script>
@endsection

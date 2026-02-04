@extends('admin/layout')

@section('content')

        <!-- Settings Content -->
        <main class="content">
            <div class="content-header">
                <h1 class="page-title">Settings</h1>
            </div>

            <div class="settings-container">
                <!-- General Settings -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">General</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label" for="siteTitle">Site Title</label>
                            <input type="text" id="siteTitle" class="text-input" value="Pressli CMS">
                            <p class="form-help">The name of your website</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="siteTagline">Tagline</label>
                            <input type="text" id="siteTagline" class="text-input" value="Just another Pressli site">
                            <p class="form-help">A short description of your site</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="siteUrl">Site URL</label>
                            <input type="url" id="siteUrl" class="text-input" value="https://pressli.com" readonly>
                            <p class="form-help">The URL where your site can be accessed</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="adminEmail">Administration Email</label>
                            <input type="email" id="adminEmail" class="text-input" value="admin@pressli.com">
                            <p class="form-help">This email is used for admin purposes and notifications</p>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="timezone">Timezone</label>
                                <select id="timezone" class="select-input">
                                    <option value="UTC">UTC</option>
                                    <option value="America/New_York" selected>Eastern Time (New York)</option>
                                    <option value="America/Chicago">Central Time (Chicago)</option>
                                    <option value="America/Los_Angeles">Pacific Time (Los Angeles)</option>
                                    <option value="Europe/London">London</option>
                                    <option value="Europe/Paris">Paris</option>
                                    <option value="Asia/Tokyo">Tokyo</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="dateFormat">Date Format</label>
                                <select id="dateFormat" class="select-input">
                                    <option value="F j, Y" selected>January 14, 2026</option>
                                    <option value="Y-m-d">2026-01-14</option>
                                    <option value="m/d/Y">01/14/2026</option>
                                    <option value="d/m/Y">14/01/2026</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="timeFormat">Time Format</label>
                                <select id="timeFormat" class="select-input">
                                    <option value="g:i a" selected>3:45 pm</option>
                                    <option value="g:i A">3:45 PM</option>
                                    <option value="H:i">15:45</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="weekStartsOn">Week Starts On</label>
                                <select id="weekStartsOn" class="select-input">
                                    <option value="0">Sunday</option>
                                    <option value="1" selected>Monday</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button class="btn btn-primary">Save General Settings</button>
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
                                    <input type="radio" name="homepageDisplay" value="posts" checked>
                                    <span>Your latest posts</span>
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="homepageDisplay" value="page">
                                    <span>A static page</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="postsPerPage">Posts per page</label>
                                <input type="number" id="postsPerPage" class="text-input" value="10" min="1" max="100">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="syndicationFeeds">Syndication feeds show</label>
                                <input type="number" id="syndicationFeeds" class="text-input" value="10" min="1" max="50">
                                <p class="form-help">Most recent items</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" class="checkbox" id="searchEngineVisibility">
                                <span>Discourage search engines from indexing this site</span>
                            </label>
                            <p class="form-help">It is up to search engines to honor this request</p>
                        </div>

                        <div class="form-actions">
                            <button class="btn btn-primary">Save Reading Settings</button>
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
                                    <input type="checkbox" class="checkbox" checked>
                                    <span>Allow people to submit comments on new posts</span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" class="checkbox">
                                    <span>Allow link notifications from other blogs (pingbacks and trackbacks)</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Comment moderation</label>
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" class="checkbox" checked>
                                    <span>Comments must be manually approved</span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" class="checkbox">
                                    <span>Comment author must have a previously approved comment</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="holdCommentsWords">Hold a comment if it contains</label>
                            <input type="number" id="holdCommentsWords" class="text-input" value="2" min="0">
                            <p class="form-help">or more links (common indicator of spam)</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="disallowedKeys">Disallowed comment keys</label>
                            <textarea id="disallowedKeys" class="textarea-input" rows="5" placeholder="One word or IP per line. Comments containing these will be marked as spam."></textarea>
                        </div>

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" class="checkbox" checked>
                                <span>Show avatars</span>
                            </label>
                        </div>

                        <div class="form-actions">
                            <button class="btn btn-primary">Save Discussion Settings</button>
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
                                <label class="form-label" for="thumbnailWidth">Thumbnail width</label>
                                <input type="number" id="thumbnailWidth" class="text-input" value="150" min="0">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="thumbnailHeight">Thumbnail height</label>
                                <input type="number" id="thumbnailHeight" class="text-input" value="150" min="0">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="mediumWidth">Medium width</label>
                                <input type="number" id="mediumWidth" class="text-input" value="300" min="0">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="mediumHeight">Medium height</label>
                                <input type="number" id="mediumHeight" class="text-input" value="300" min="0">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="largeWidth">Large width</label>
                                <input type="number" id="largeWidth" class="text-input" value="1024" min="0">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="largeHeight">Large height</label>
                                <input type="number" id="largeHeight" class="text-input" value="1024" min="0">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="uploadsPath">Uploads folder</label>
                            <input type="text" id="uploadsPath" class="text-input" value="/wp-content/uploads" readonly>
                            <p class="form-help">Default location for uploaded files</p>
                        </div>

                        <div class="form-actions">
                            <button class="btn btn-primary">Save Media Settings</button>
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
                                    <input type="radio" name="permalink" value="plain">
                                    <span>Plain: <code>https://pressli.com/?p=123</code></span>
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="permalink" value="day">
                                    <span>Day and name: <code>https://pressli.com/2026/01/14/sample-post/</code></span>
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="permalink" value="month">
                                    <span>Month and name: <code>https://pressli.com/2026/01/sample-post/</code></span>
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="permalink" value="numeric">
                                    <span>Numeric: <code>https://pressli.com/archives/123</code></span>
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="permalink" value="postname" checked>
                                    <span>Post name: <code>https://pressli.com/sample-post/</code></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="customPermalink">Custom structure</label>
                            <input type="text" id="customPermalink" class="text-input" placeholder="/%year%/%monthnum%/%postname%/">
                            <p class="form-help">Available tags: %year% %monthnum% %day% %hour% %minute% %second% %postname% %post_id% %category%</p>
                        </div>

                        <div class="form-actions">
                            <button class="btn btn-primary">Save Permalink Settings</button>
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
                            <label class="form-label" for="privacyPage">Privacy Policy page</label>
                            <select id="privacyPage" class="select-input">
                                <option value="">— Select —</option>
                                <option value="privacy-policy" selected>Privacy Policy</option>
                                <option value="about">About</option>
                                <option value="contact">Contact</option>
                            </select>
                            <p class="form-help">This page will be used for privacy policy link in footer</p>
                        </div>

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" class="checkbox" checked>
                                <span>Enable user registration</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="defaultRole">New user default role</label>
                            <select id="defaultRole" class="select-input">
                                <option value="subscriber" selected>Subscriber</option>
                                <option value="author">Author</option>
                                <option value="editor">Editor</option>
                            </select>
                        </div>

                        <div class="form-actions">
                            <button class="btn btn-primary">Save Privacy Settings</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection

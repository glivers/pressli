@extends('admin/layout')

@section('content')

        <!-- Pages Content -->
        <main class="content">
            <div class="content-header">
                <h1 class="page-title">Pages</h1>
                <a href="{{ Url::link('admin/pages/new') }}" class="btn btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    New Page
                </a>
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

            <!-- Filters & Actions Bar -->
            <div class="card">
                <div class="table-toolbar">
                    <div class="table-tabs">
                        <a href="{{ Url::link('admin/pages') }}" class="tab-btn {{ !Input::get('status') ? 'active' : '' }}">
                            All <span class="tab-count">{{ $statusCounts['all'] }}</span>
                        </a>
                        <a href="{{ Url::link('admin/pages?status=published') }}" class="tab-btn {{ Input::get('status') === 'published' ? 'active' : '' }}">
                            Published <span class="tab-count">{{ $statusCounts['published'] }}</span>
                        </a>
                        <a href="{{ Url::link('admin/pages?status=draft') }}" class="tab-btn {{ Input::get('status') === 'draft' ? 'active' : '' }}">
                            Draft <span class="tab-count">{{ $statusCounts['draft'] }}</span>
                        </a>
                        <a href="{{ Url::link('admin/pages?status=trash') }}" class="tab-btn {{ Input::get('status') === 'trash' ? 'active' : '' }}">
                            Trash <span class="tab-count">{{ $statusCounts['trash'] }}</span>
                        </a>
                    </div>

                    <div class="table-actions">
                        <div class="bulk-actions">
                            <select class="select-input" disabled id="bulkAction">
                                <option value="">Bulk Actions</option>
                                <option value="publish">Publish</option>
                                <option value="draft">Move to Draft</option>
                                <option value="trash">Move to Trash</option>
                                <option value="delete">Delete Permanently</option>
                            </select>
                            <button class="btn btn-secondary" disabled id="applyBulk">Apply</button>
                        </div>

                        <div class="search-box">
                            <input type="search" placeholder="Search pages..." class="search-input">
                            <svg class="search-box-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pages Table -->
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="col-check">
                                    <input type="checkbox" id="selectAll" class="checkbox">
                                </th>
                                <th class="col-title">Title</th>
                                <th class="col-author">Author</th>
                                <th class="col-template">Template</th>
                                <th class="col-status">Status</th>
                                <th class="col-date">Date</th>
                                <th class="col-actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @loopelse($pages as $page)
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-title">
                                    <div class="title-cell">
                                        <a href="{{ Url::link('admin/pages/edit/' . $page['id']) }}" class="post-title">{{ $page['title'] }}</a>
                                        <div class="row-actions">
                                            <a href="{{ Url::link('admin/pages/edit/' . $page['id']) }}">Edit Page</a>
                                            <span class="separator">|</span>
                                            @if($page['status'] === 'published')
                                                <a href="{{ Url::link($page['slug']) }}" target="_blank">View Page</a>
                                            @else
                                                <a href="#" title="Preview (not yet implemented)">Preview</a>
                                            @endif
                                            <span class="separator">|</span>
                                            <a href="{{ Url::link('admin/pages/delete/' . $page['id']) }}" class="danger" onclick="return confirm('Move this page to trash?')">Trash</a>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-author">
                                    <div class="author-cell">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($page['first_name'] . ' ' . $page['last_name']) }}&background=4f46e5&color=fff" alt="Author" class="author-avatar">
                                        <span>{{ $page['first_name'] }} {{ $page['last_name'] }}</span>
                                    </div>
                                </td>
                                <td class="col-template">
                                    <span class="template-tag">{{ ucfirst($page['template'] or 'default') }}</span>
                                </td>
                                <td class="col-status">
                                    <span class="status-badge status-{{ $page['status'] }}">{{ ucfirst($page['status']) }}</span>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">
                                        @if($page['updated_at'])
                                            {{ Date::format($page['updated_at'], 'M j, Y') }} <span class="date-time">{{ Date::format($page['updated_at'], 'g:i A') }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="col-actions">
                                    <div class="action-buttons">
                                        <a href="{{ Url::link('admin/pages/edit/' . $page['id']) }}" class="btn-icon" title="Edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ Url::link('admin/pages/delete/' . $page['id']) }}" class="btn-icon" title="Trash" onclick="return confirm('Move this page to trash?')">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 3rem;">
                                    <p style="color: #6b7280;">No pages yet. Create your first page to get started.</p>
                                </td>
                            </tr>
                            @endloop
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="table-footer">
                    <div class="table-info">
                        Showing {{ count($pages) }} pages
                    </div>
                </div>
            </div>
        </main>
@endsection

<!-- JS Scripts -->
@section('scripts')
    @parent
    <script src="{{Url::assets('js/posts.js')}}"></script>
@endsection

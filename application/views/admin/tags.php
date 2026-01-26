@extends('admin/layout')

@section('content')

        <!-- Tags Content -->
        <main class="content">
            <div class="content-header">
                <div>
                    <h1 class="content-title">Tags</h1>
                    <p style="font-size: 13px; color: var(--text-tertiary); margin-top: 4px;">Organize your posts with tags</p>
                </div>
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

            <div class="categories-layout">
                <!-- Add New Tag -->
                <div class="categories-sidebar">
                    <div class="card">
                        <div class="card-header">
                            <h3>Add New Tag</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ Url::link('admin/tags/new') }}">
                                {{{ Csrf::field() }}}

                                <div class="form-group">
                                    <label class="form-label" for="tag-name">Name</label>
                                    <input type="text" id="tag-name" name="name" class="text-input" placeholder="JavaScript" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="tag-slug">Slug</label>
                                    <input type="text" id="tag-slug" name="slug" class="text-input" placeholder="javascript">
                                    <p class="form-help">URL-friendly version (lowercase, no spaces)</p>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="tag-desc">Description</label>
                                    <textarea id="tag-desc" name="description" class="textarea-input" rows="4" placeholder="Brief description of this tag"></textarea>
                                    <p class="form-help">Optional. May be displayed by some themes.</p>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">Add Tag</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tags List -->
                <div class="categories-content">
                    <div class="card">
                        <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                            <h3>All Tags</h3>
                            <div style="display: flex; gap: var(--spacing-sm); align-items: center;">
                                <input type="search" class="text-input" placeholder="Search tags..." style="width: 240px;">
                            </div>
                        </div>

                        <table class="data-table categories-table">
                            <thead>
                                <tr>
                                    <th class="col-check">
                                        <input type="checkbox" id="selectAll">
                                    </th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Description</th>
                                    <th class="col-count">Posts</th>
                                    <th class="col-actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @loopelse($tags as $tag)
                                <tr>
                                    <td class="col-check">
                                        <input type="checkbox">
                                    </td>
                                    <td><strong>{{ $tag['name'] }}</strong></td>
                                    <td><code class="slug-code">{{ $tag['slug'] }}</code></td>
                                    <td class="text-secondary">{{ $tag['description'] or '—' }}</td>
                                    <td class="col-count">{{ $tag['post_count'] }}</td>
                                    <td class="col-actions">
                                        <a href="{{ Url::link('admin/tags/edit/' . $tag['id']) }}" class="action-link">Edit</a>
                                        <span class="action-separator">|</span>
                                        <a href="{{ Url::link('admin/posts?tag=' . $tag['id']) }}" class="action-link">View Posts</a>
                                        <span class="action-separator">|</span>
                                        <a href="{{ Url::link('admin/tags/delete/' . $tag['id']) }}" class="action-link danger" onclick="return confirm('Delete this tag?')">Delete</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 3rem;">
                                        <p style="color: #6b7280;">No tags yet. Add your first tag using the form on the left.</p>
                                    </td>
                                </tr>
                                @endloop
                            </tbody>
                        </table>

                        <div class="table-footer">
                            <div class="bulk-actions">
                                <select class="text-input">
                                    <option>Bulk Actions</option>
                                    <option>Delete</option>
                                </select>
                                <button class="btn btn-secondary btn-sm">Apply</button>
                            </div>
                            <div class="pagination">
                                <span class="pagination-info">Showing {{ count($tags) }} of {{ $totalCount }} tags</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection

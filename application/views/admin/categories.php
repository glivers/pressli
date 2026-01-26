@extends('admin/layout')

@section('content')

        <!-- Categories Content -->
        <main class="content">
            <div class="content-header">
                <div>
                    <h1 class="content-title">Categories</h1>
                    <p style="font-size: 13px; color: var(--text-tertiary); margin-top: 4px;">Organize your posts into categories</p>
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
                <!-- Add New Category -->
                <div class="categories-sidebar">
                    <div class="card">
                        <div class="card-header">
                            <h3>Add New Category</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ Url::link('admin/categories/new') }}">
                                {{{ Csrf::field() }}}

                                <div class="form-group">
                                    <label class="form-label" for="cat-name">Name</label>
                                    <input type="text" id="cat-name" name="name" class="text-input" placeholder="Technology" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="cat-slug">Slug</label>
                                    <input type="text" id="cat-slug" name="slug" class="text-input" placeholder="technology">
                                    <p class="form-help">URL-friendly version (lowercase, no spaces)</p>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="cat-parent">Parent Category</label>
                                    <select id="cat-parent" name="parent_id" class="text-input">
                                        <option value="">None</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <p class="form-help">Create a hierarchy of categories</p>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="cat-desc">Description</label>
                                    <textarea id="cat-desc" name="description" class="textarea-input" rows="4" placeholder="Brief description of this category"></textarea>
                                    <p class="form-help">Optional. May be displayed by some themes.</p>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">Add Category</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Categories List -->
                <div class="categories-content">
                    <div class="card">
                        <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                            <h3>All Categories</h3>
                            <div style="display: flex; gap: var(--spacing-sm); align-items: center;">
                                <input type="search" class="text-input" placeholder="Search categories..." style="width: 240px;">
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
                                @loopelse($categories as $category)
                                <tr>
                                    <td class="col-check">
                                        <input type="checkbox">
                                    </td>
                                    <td>
                                        <div class="category-name">
                                            @if($category['parent_id'])
                                                <span class="category-indent">—</span>
                                            @endif
                                            <strong>{{ $category['name'] }}</strong>
                                        </div>
                                    </td>
                                    <td><code class="slug-code">{{ $category['slug'] }}</code></td>
                                    <td class="text-secondary">{{ $category['description'] or '—' }}</td>
                                    <td class="col-count">{{ $category['post_count'] }}</td>
                                    <td class="col-actions">
                                        <a href="{{ Url::link('admin/categories/edit/' . $category['id']) }}" class="action-link">Edit</a>
                                        <span class="action-separator">|</span>
                                        <a href="{{ Url::link('admin/posts?category=' . $category['id']) }}" class="action-link">View Posts</a>
                                        <span class="action-separator">|</span>
                                        <a href="{{ Url::link('admin/categories/delete/' . $category['id']) }}" class="action-link danger" onclick="return confirm('Delete this category?')">Delete</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 3rem;">
                                        <p style="color: #6b7280;">No categories yet. Add your first category using the form on the left.</p>
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
                                <span class="pagination-info">Showing {{ count($categories) }} of {{ $totalCount }} categories</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection

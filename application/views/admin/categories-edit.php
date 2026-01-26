@extends('admin/layout')

@section('content')

        <!-- Edit Category Content -->
        <main class="content">
            <div class="content-header">
                <div class="header-breadcrumb">
                    <a href="{{ Url::link('admin/categories') }}" class="breadcrumb-link">Categories</a>
                    <svg class="breadcrumb-separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                    <span class="breadcrumb-current">Edit Category</span>
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

            <div style="max-width: 800px;">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Edit Category</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ Url::link('admin/categories/edit/' . $category['id']) }}">
                            {{{ Csrf::field() }}}

                            <div class="form-group">
                                <label class="form-label" for="cat-name">Name</label>
                                <input type="text" id="cat-name" name="name" class="text-input" value="{{ $category['name'] }}" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="cat-slug">Slug</label>
                                <input type="text" id="cat-slug" name="slug" class="text-input" value="{{ $category['slug'] }}">
                                <p class="form-help">URL-friendly version (lowercase, no spaces)</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="cat-parent">Parent Category</label>
                                <select id="cat-parent" name="parent_id" class="text-input">
                                    <option value="">None</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat['id'] }}" {{ $category['parent_id'] == $cat['id'] ? 'selected' : '' }}>{{ $cat['name'] }}</option>
                                    @endforeach
                                </select>
                                <p class="form-help">Create a hierarchy of categories</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="cat-desc">Description</label>
                                <textarea id="cat-desc" name="description" class="textarea-input" rows="5">{{ $category['description'] or '' }}</textarea>
                                <p class="form-help">Optional. May be displayed by some themes.</p>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Update Category</button>
                                <a href="{{ Url::link('admin/categories') }}" class="btn btn-secondary">Cancel</a>
                                <a href="{{ Url::link('admin/categories/delete/' . $category['id']) }}" class="btn btn-danger" style="margin-left: auto;" onclick="return confirm('Delete this category?')">Delete Category</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
@endsection

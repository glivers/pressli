@extends('admin/layout')

@section('content')

        <!-- Edit Tag Content -->
        <main class="content">
            <div class="content-header">
                <div class="header-breadcrumb">
                    <a href="{{ Url::link('admin/tags') }}" class="breadcrumb-link">Tags</a>
                    <svg class="breadcrumb-separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                    <span class="breadcrumb-current">Edit Tag</span>
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
                        <h2 class="card-title">Edit Tag</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ Url::link('admin/tags/edit/' . $tag['id']) }}">
                            {{{ Csrf::field() }}}

                            <div class="form-group">
                                <label class="form-label" for="tag-name">Name</label>
                                <input type="text" id="tag-name" name="name" class="text-input" value="{{ $tag['name'] }}" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="tag-slug">Slug</label>
                                <input type="text" id="tag-slug" name="slug" class="text-input" value="{{ $tag['slug'] }}">
                                <p class="form-help">URL-friendly version (lowercase, no spaces)</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="tag-desc">Description</label>
                                <textarea id="tag-desc" name="description" class="textarea-input" rows="5">{{ $tag['description'] or '' }}</textarea>
                                <p class="form-help">Optional. May be displayed by some themes.</p>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Update Tag</button>
                                <a href="{{ Url::link('admin/tags') }}" class="btn btn-secondary">Cancel</a>
                                <a href="{{ Url::link('admin/tags/delete/' . $tag['id']) }}" class="btn btn-danger" style="margin-left: auto;" onclick="return confirm('Delete this tag?')">Delete Tag</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
@endsection

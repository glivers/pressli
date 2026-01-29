@extends('admin/layout')

@section('content')

        <!-- Edit Tag Content -->
        <main class="content">
            <div class="content-header">
                <div class="header-breadcrumb">
                    <a href="tags.html" class="breadcrumb-link">Tags</a>
                    <svg class="breadcrumb-separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                    <span class="breadcrumb-current">Edit Tag</span>
                </div>
            </div>

            <div style="max-width: 800px;">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Edit Tag</h2>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label class="form-label" for="tag-name">Name</label>
                                <input type="text" id="tag-name" class="text-input" value="JavaScript" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="tag-slug">Slug</label>
                                <input type="text" id="tag-slug" class="text-input" value="javascript">
                                <p class="form-help">URL-friendly version (lowercase, no spaces)</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="tag-desc">Description</label>
                                <textarea id="tag-desc" class="textarea-input" rows="5">Programming language for web development</textarea>
                                <p class="form-help">Optional. May be displayed by some themes.</p>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Update Tag</button>
                                <a href="tags.html" class="btn btn-secondary">Cancel</a>
                                <button type="button" class="btn btn-danger" style="margin-left: auto;">Delete Tag</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
@endsection
@extends('admin/layout')

@section('content')

        <!-- Edit Category Content -->
        <main class="content">
            <div class="content-header">
                <div class="header-breadcrumb">
                    <a href="categories.html" class="breadcrumb-link">Categories</a>
                    <svg class="breadcrumb-separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                    <span class="breadcrumb-current">Edit Category</span>
                </div>
            </div>

            <div style="max-width: 800px;">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Edit Category</h2>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label class="form-label" for="cat-name">Name</label>
                                <input type="text" id="cat-name" class="text-input" value="Technology" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="cat-slug">Slug</label>
                                <input type="text" id="cat-slug" class="text-input" value="technology">
                                <p class="form-help">URL-friendly version (lowercase, no spaces)</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="cat-parent">Parent Category</label>
                                <select id="cat-parent" class="text-input">
                                    <option value="">None</option>
                                    <option value="1">Design</option>
                                    <option value="2">Business</option>
                                </select>
                                <p class="form-help">Create a hierarchy of categories</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="cat-desc">Description</label>
                                <textarea id="cat-desc" class="textarea-input" rows="5">Posts about tech, software, and innovation</textarea>
                                <p class="form-help">Optional. May be displayed by some themes.</p>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Update Category</button>
                                <a href="categories.html" class="btn btn-secondary">Cancel</a>
                                <button type="button" class="btn btn-danger" style="margin-left: auto;">Delete Category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
@endsection

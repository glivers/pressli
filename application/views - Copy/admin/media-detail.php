@extends('admin/layout')

@section('content')

        <!-- Media Detail Content -->
        <main class="content">
            <div class="content-header">
                <div class="header-breadcrumb">
                    <a href="media.html" class="breadcrumb-link">Media</a>
                    <svg class="breadcrumb-separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                    <span class="breadcrumb-current">summer-landscape.jpg</span>
                </div>
            </div>

            <div class="media-detail-container">
                <!-- Left Column - Preview -->
                <div class="media-detail-preview">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Preview</h2>
                        </div>
                        <div class="card-body">
                            <div class="media-preview-wrapper">
                                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop" alt="Summer Landscape" class="media-preview-image">
                            </div>
                            <div class="media-preview-actions">
                                <button class="btn btn-secondary">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                    Download
                                </button>
                                <button class="btn btn-secondary">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path>
                                    </svg>
                                    Replace File
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Details -->
                <div class="media-detail-info">
                    <!-- Attachment Details -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Attachment Details</h2>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">File Name</label>
                                <input type="text" class="text-input" value="summer-landscape.jpg" readonly>
                            </div>

                            <div class="form-group">
                                <label class="form-label">File Type</label>
                                <input type="text" class="text-input" value="image/jpeg" readonly>
                            </div>

                            <div class="form-group">
                                <label class="form-label">File Size</label>
                                <input type="text" class="text-input" value="342 KB" readonly>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Dimensions</label>
                                <input type="text" class="text-input" value="1920 × 1280 pixels" readonly>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Uploaded</label>
                                <input type="text" class="text-input" value="January 14, 2026 at 2:30 PM" readonly>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Uploaded By</label>
                                <input type="text" class="text-input" value="Admin User" readonly>
                            </div>

                            <div class="form-group">
                                <label class="form-label">File URL</label>
                                <div class="input-group">
                                    <input type="text" class="text-input" value="https://example.com/wp-content/uploads/2026/01/summer-landscape.jpg" readonly>
                                    <button class="btn btn-secondary" title="Copy to clipboard">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Metadata -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Metadata</h2>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label" for="mediaTitle">Title</label>
                                <input type="text" id="mediaTitle" class="text-input" value="Summer Mountain Landscape">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="mediaCaption">Caption</label>
                                <textarea id="mediaCaption" class="textarea-input" rows="3">Beautiful summer landscape with mountains and clear blue sky</textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="mediaAlt">Alt Text</label>
                                <input type="text" id="mediaAlt" class="text-input" value="Mountain landscape with green meadow in summer" placeholder="Describe this image for accessibility">
                                <p class="form-help">Describe the purpose of the image. Leave empty if decorative.</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="mediaDescription">Description</label>
                                <textarea id="mediaDescription" class="textarea-input" rows="4">A stunning summer landscape featuring rolling green meadows and majestic mountains under a clear blue sky.</textarea>
                            </div>

                            <div class="form-actions">
                                <button class="btn btn-primary">Update</button>
                                <button class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>

                    <!-- Delete -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Delete</h2>
                        </div>
                        <div class="card-body">
                            <p class="text-secondary" style="margin-bottom: 16px;">Once you delete this media file, there is no going back. This action cannot be undone.</p>
                            <button class="btn danger-btn">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                Delete Permanently
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection
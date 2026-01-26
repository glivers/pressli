@extends('admin/layout')

@section('content')

        <!-- Media Detail Content -->
        <main class="content">
            <div class="content-header">
                <div class="header-breadcrumb">
                    <a href="{{ Url::link('admin/media') }}" class="breadcrumb-link">Media</a>
                    <svg class="breadcrumb-separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                    <span class="breadcrumb-current">{{ $media['filename'] }}</span>
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

            <div class="media-detail-container">
                <!-- Left Column - Preview -->
                <div class="media-detail-preview">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Preview</h2>
                        </div>
                        <div class="card-body">
                            <div class="media-preview-wrapper">
                                @if($media['file_type'] === 'image')
                                    <img src="{{ Url::base() . $media['file_path'] }}" alt="{{ $media['alt_text'] or $media['title'] }}" class="media-preview-image">
                                @else
                                    <div style="padding: 3rem; text-align: center; background: #f3f4f6;">
                                        <p style="color: #6b7280;">Preview not available for this file type</p>
                                        <p style="color: #9ca3af; font-size: 0.875rem;">{{ strtoupper($media['file_type']) }} • {{ strtoupper(pathinfo($media['filename'], PATHINFO_EXTENSION)) }}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="media-preview-actions">
                                <a href="{{ Url::base() . $media['file_path'] }}" class="btn btn-secondary" download>
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                    Download
                                </a>
                                <a href="{{ Url::base() . $media['file_path'] }}" class="btn btn-secondary" target="_blank">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                        <polyline points="15 3 21 3 21 9"></polyline>
                                        <line x1="10" y1="14" x2="21" y2="3"></line>
                                    </svg>
                                    View Live
                                </a>
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
                                <input type="text" class="text-input" value="{{ $media['filename'] }}" readonly>
                            </div>

                            <div class="form-group">
                                <label class="form-label">File Type</label>
                                <input type="text" class="text-input" value="{{ $media['mime_type'] }}" readonly>
                            </div>

                            <div class="form-group">
                                <label class="form-label">File Size</label>
                                <input type="text" class="text-input" value="{{ round($media['file_size'] / 1024, 1) }} KB" readonly>
                            </div>

                            @if($media['width'] && $media['height'])
                            <div class="form-group">
                                <label class="form-label">Dimensions</label>
                                <input type="text" class="text-input" value="{{ $media['width'] }} × {{ $media['height'] }} pixels" readonly>
                            </div>
                            @endif

                            <div class="form-group">
                                <label class="form-label">Uploaded</label>
                                <input type="text" class="text-input" value="{{ Date::format($media['created_at'], 'F j, Y') }} at {{ Date::format($media['created_at'], 'g:i A') }}" readonly>
                            </div>

                            <div class="form-group">
                                <label class="form-label">File URL</label>
                                <div class="input-group">
                                    <input type="text" class="text-input" value="{{ Url::base() . $media['file_path'] }}" readonly>
                                    <button class="btn btn-secondary" title="Copy to clipboard" onclick="navigator.clipboard.writeText('{{ Url::base() . $media['file_path'] }}'); alert('URL copied to clipboard!')">
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
                            <form method="POST" action="{{ Url::link('admin/media/edit/' . $media['id']) }}">
                                {{{ Csrf::field() }}}

                                <div class="form-group">
                                    <label class="form-label" for="mediaTitle">Title</label>
                                    <input type="text" id="mediaTitle" name="title" class="text-input" value="{{ $media['title'] }}">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="mediaAlt">Alt Text</label>
                                    <input type="text" id="mediaAlt" name="alt_text" class="text-input" value="{{ $media['alt_text'] }}" placeholder="Describe this image for accessibility">
                                    <p class="form-help">Describe the purpose of the image. Leave empty if decorative.</p>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="mediaDescription">Description</label>
                                    <textarea id="mediaDescription" name="description" class="textarea-input" rows="4">{{ $media['description'] }}</textarea>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ Url::link('admin/media') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Delete -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Delete</h2>
                        </div>
                        <div class="card-body">
                            <p class="text-secondary" style="margin-bottom: 16px;">Once you delete this media file, it will be moved to trash. The physical file will remain on the server.</p>
                            <a href="{{ Url::link('admin/media/delete/' . $media['id']) }}" class="btn danger-btn" onclick="return confirm('Move this media file to trash?')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                Move to Trash
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection
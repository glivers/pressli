@extends('admin/layout')

@section('content')

        <!-- Media Library Content -->
        <main class="content">
            <div class="content-header">
                <h1 class="page-title">Media Library</h1>
                <button class="btn btn-primary" id="uploadBtn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                    Upload Files
                </button>
            </div>

            <!-- Filters & Actions -->
            <div class="card">
                <div class="table-toolbar">
                    <div class="table-tabs">
                        <button class="tab-btn active" data-filter="all">
                            All <span class="tab-count">48</span>
                        </button>
                        <button class="tab-btn" data-filter="images">
                            Images <span class="tab-count">32</span>
                        </button>
                        <button class="tab-btn" data-filter="documents">
                            Documents <span class="tab-count">12</span>
                        </button>
                        <button class="tab-btn" data-filter="videos">
                            Videos <span class="tab-count">4</span>
                        </button>
                    </div>

                    <div class="table-actions">
                        <div class="bulk-actions">
                            <input type="checkbox" class="checkbox" id="selectAllMedia">
                            <label for="selectAllMedia" style="margin-right: 8px; font-size: 13px; color: var(--text-secondary);">Select All</label>
                            <select class="select-input" disabled id="bulkActionMedia">
                                <option value="">Bulk Actions</option>
                                <option value="delete">Delete</option>
                            </select>
                            <button class="btn btn-secondary" disabled id="applyBulkMedia">Apply</button>
                        </div>

                        <div class="search-box">
                            <input type="search" placeholder="Search media..." class="search-input">
                            <svg class="search-box-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Media Grid -->
                <div class="media-grid">
                    <!-- Media Item 1 - Image -->
                    <div class="media-item">
                        <input type="checkbox" class="media-checkbox checkbox row-check">
                        <div class="media-thumbnail">
                            <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=400&h=300&fit=crop" alt="Media">
                            <div class="media-overlay">
                                <button class="media-action-btn view-media-btn" title="View" data-media="hero-image.jpg">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                                <button class="media-action-btn" title="Download">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                </button>
                                <button class="media-action-btn" title="Delete">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="media-info">
                            <div class="media-name">hero-image.jpg</div>
                            <div class="media-meta">1920×1080 • 245 KB</div>
                        </div>
                    </div>

                    <!-- Media Item 2 - Image -->
                    <div class="media-item">
                        <input type="checkbox" class="media-checkbox checkbox row-check">
                        <div class="media-thumbnail">
                            <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?w=400&h=300&fit=crop" alt="Media">
                            <div class="media-overlay">
                                <button class="media-action-btn view-media-btn" title="View">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                                <button class="media-action-btn" title="Download">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                </button>
                                <button class="media-action-btn" title="Delete">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="media-info">
                            <div class="media-name">team-photo.jpg</div>
                            <div class="media-meta">1600×900 • 182 KB</div>
                        </div>
                    </div>

                    <!-- Media Item 3 - Document -->
                    <div class="media-item">
                        <input type="checkbox" class="media-checkbox checkbox row-check">
                        <div class="media-thumbnail media-document">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            <span class="file-ext">PDF</span>
                            <div class="media-overlay">
                                <button class="media-action-btn view-media-btn" title="View">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                                <button class="media-action-btn" title="Download">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                </button>
                                <button class="media-action-btn" title="Delete">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="media-info">
                            <div class="media-name">company-brochure.pdf</div>
                            <div class="media-meta">PDF • 2.4 MB</div>
                        </div>
                    </div>

                    <!-- Media Item 4 - Image -->
                    <div class="media-item">
                        <input type="checkbox" class="media-checkbox checkbox row-check">
                        <div class="media-thumbnail">
                            <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=400&h=300&fit=crop" alt="Media">
                            <div class="media-overlay">
                                <button class="media-action-btn view-media-btn" title="View">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                                <button class="media-action-btn" title="Download">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                </button>
                                <button class="media-action-btn" title="Delete">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="media-info">
                            <div class="media-name">product-laptop.jpg</div>
                            <div class="media-meta">2400×1600 • 512 KB</div>
                        </div>
                    </div>

                    <!-- Media Item 5 - Video -->
                    <div class="media-item">
                        <input type="checkbox" class="media-checkbox checkbox row-check">
                        <div class="media-thumbnail media-video">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polygon points="23 7 16 12 23 17 23 7"></polygon>
                                <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                            </svg>
                            <span class="file-ext">MP4</span>
                            <div class="media-overlay">
                                <button class="media-action-btn view-media-btn" title="View">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                                <button class="media-action-btn" title="Download">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                </button>
                                <button class="media-action-btn" title="Delete">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="media-info">
                            <div class="media-name">intro-video.mp4</div>
                            <div class="media-meta">1080p • 15.2 MB</div>
                        </div>
                    </div>

                    <!-- Media Item 6 - Image -->
                    <div class="media-item">
                        <div class="media-thumbnail">
                            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&h=300&fit=crop" alt="Media">
                            <div class="media-overlay">
                                <button class="media-action-btn" title="View">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                                <button class="media-action-btn" title="Delete">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="media-info">
                            <div class="media-name">analytics-chart.png</div>
                            <div class="media-meta">1280×720 • 95 KB</div>
                        </div>
                    </div>

                    <!-- Media Item 7 - Document -->
                    <div class="media-item">
                        <div class="media-thumbnail media-document">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                            </svg>
                            <span class="file-ext">DOCX</span>
                            <div class="media-overlay">
                                <button class="media-action-btn" title="Download">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                </button>
                                <button class="media-action-btn" title="Delete">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="media-info">
                            <div class="media-name">press-release.docx</div>
                            <div class="media-meta">DOCX • 124 KB</div>
                        </div>
                    </div>

                    <!-- Media Item 8 - Image -->
                    <div class="media-item">
                        <div class="media-thumbnail">
                            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400&h=300&fit=crop" alt="Media">
                            <div class="media-overlay">
                                <button class="media-action-btn" title="View">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                                <button class="media-action-btn" title="Delete">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="media-info">
                            <div class="media-name">dashboard-preview.jpg</div>
                            <div class="media-meta">1920×1080 • 324 KB</div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="table-footer">
                    <div class="table-info">
                        Showing 1 to 8 of 48 items
                    </div>
                    <div class="pagination">
                        <button class="page-btn" disabled>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                        </button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn">4</button>
                        <button class="page-btn">5</button>
                        <button class="page-btn">6</button>
                        <button class="page-btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Upload Modal -->
            <div class="modal" id="uploadModal">
                <div class="modal-overlay"></div>
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Upload Files</h2>
                        <button class="modal-close" id="closeUploadModal">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="upload-area">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                            <h3>Drop files here or click to browse</h3>
                            <p>Supported formats: JPG, PNG, GIF, PDF, DOC, MP4</p>
                            <input type="file" id="fileInput" multiple hidden>
                            <button class="btn btn-primary">Select Files</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View Media Modal -->
            <div class="modal" id="viewModal">
                <div class="modal-overlay"></div>
                <div class="modal-content modal-large">
                    <div class="modal-header">
                        <h2 class="modal-title">Media Details</h2>
                        <button class="modal-close" id="closeViewModal">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="media-detail-layout">
                            <div class="media-preview">
                                <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=800&h=600&fit=crop" alt="Media Preview" id="mediaPreviewImg">
                            </div>
                            <div class="media-details">
                                <div class="detail-section">
                                    <label class="detail-label">Filename</label>
                                    <div class="detail-value" id="mediaFilename">hero-image.jpg</div>
                                </div>
                                <div class="detail-section">
                                    <label class="detail-label">File Type</label>
                                    <div class="detail-value" id="mediaType">Image (JPEG)</div>
                                </div>
                                <div class="detail-section">
                                    <label class="detail-label">Dimensions</label>
                                    <div class="detail-value" id="mediaDimensions">1920 × 1080 pixels</div>
                                </div>
                                <div class="detail-section">
                                    <label class="detail-label">File Size</label>
                                    <div class="detail-value" id="mediaSize">245 KB</div>
                                </div>
                                <div class="detail-section">
                                    <label class="detail-label">Uploaded</label>
                                    <div class="detail-value" id="mediaUploaded">Jan 14, 2026 at 2:30 PM</div>
                                </div>
                                <div class="detail-section">
                                    <label class="detail-label">URL</label>
                                    <div class="detail-value detail-url">
                                        <input type="text" class="form-input" value="https://yoursite.com/uploads/hero-image.jpg" readonly id="mediaUrl">
                                        <button class="btn-icon" title="Copy URL">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="modal-actions">
                                    <button class="btn btn-secondary" id="viewLiveBtn">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                            <polyline points="15 3 21 3 21 9"></polyline>
                                            <line x1="10" y1="14" x2="21" y2="3"></line>
                                        </svg>
                                        View Live
                                    </button>
                                    <button class="btn btn-secondary">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="7 10 12 15 17 10"></polyline>
                                            <line x1="12" y1="15" x2="12" y2="3"></line>
                                        </svg>
                                        Download
                                    </button>
                                    <button class="btn btn-secondary danger-btn">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection

<!-- JS Scripts -->
@section('scripts')
    @parent
    <script src="{{Url::assets('js/media.js')}}"></script>
@endsection

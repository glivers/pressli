@extends('admin/layout')

@section('content')

        <!-- Comment Detail Content -->
        <main class="content">
            <div class="content-header">
                <div class="header-breadcrumb">
                    <a href="comments.html" class="breadcrumb-link">Comments</a>
                    <svg class="breadcrumb-separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                    <span class="breadcrumb-current">Comment by Jane Cooper</span>
                </div>
            </div>

            <div class="comment-detail-container">
                <!-- Left Column - Comment Content -->
                <div class="comment-detail-main">
                    <!-- Comment -->
                    <div class="card">
                        <div class="comment-detail-header">
                            <div class="comment-detail-author">
                                <img src="https://ui-avatars.com/api/?name=Jane+Cooper&background=10b981&color=fff" alt="Jane Cooper" class="comment-detail-avatar">
                                <div>
                                    <h3 class="comment-detail-author-name">Jane Cooper</h3>
                                    <p class="comment-detail-meta">
                                        Commented on <a href="#" class="post-link">Getting Started with Pressli CMS</a>
                                        <span class="separator">•</span>
                                        <span class="date-text">Jan 14, 2026 at 3:45 PM</span>
                                    </p>
                                </div>
                            </div>
                            <div class="comment-detail-status">
                                <span class="status-badge status-warning">Pending</span>
                            </div>
                        </div>
                        <div class="comment-detail-body">
                            <p>This is exactly what I was looking for! Thank you for sharing this comprehensive guide. I've been struggling with setting up my CMS for the past week, and your tutorial made everything so much clearer.</p>
                            <p>I especially appreciated the detailed explanation of the plugin system. That was the part I found most confusing in the documentation.</p>
                        </div>
                    </div>

                    <!-- Edit Form (Hidden by default) -->
                    <div class="card" id="editCommentForm" style="display: none;">
                        <div class="card-header">
                            <h2 class="card-title">Edit Comment</h2>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label" for="editCommentContent">Comment Content</label>
                                <textarea id="editCommentContent" class="textarea-input" rows="8">This is exactly what I was looking for! Thank you for sharing this comprehensive guide. I've been struggling with setting up my CMS for the past week, and your tutorial made everything so much clearer.

I especially appreciated the detailed explanation of the plugin system. That was the part I found most confusing in the documentation.</textarea>
                            </div>
                            <div class="form-actions">
                                <button class="btn btn-primary">Save Changes</button>
                                <button class="btn btn-secondary" id="cancelEdit">Cancel</button>
                            </div>
                        </div>
                    </div>

                    <!-- Reply Form -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Reply</h2>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label" for="replyContent">Your Reply</label>
                                <textarea id="replyContent" class="textarea-input" rows="6" placeholder="Write your reply..."></textarea>
                            </div>
                            <div class="form-actions">
                                <button class="btn btn-primary">Submit Reply</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Details & Actions -->
                <div class="comment-detail-sidebar">
                    <!-- Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Actions</h2>
                        </div>
                        <div class="card-body">
                            <div class="comment-actions-list">
                                <button class="btn btn-primary btn-full">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                    Approve
                                </button>
                                <button class="btn btn-secondary btn-full" id="editCommentBtn">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                    Edit
                                </button>
                                <button class="btn btn-secondary btn-full">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M3 6h18"></path>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                        <path d="m19 6-1 14c0 1-1 2-2 2H8c-1 0-2-1-2-2L5 6"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                    Mark as Spam
                                </button>
                                <button class="btn danger-btn btn-full">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                    Move to Trash
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Author Information -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Author Information</h2>
                        </div>
                        <div class="card-body">
                            <div class="detail-row">
                                <span class="detail-label">Name:</span>
                                <span class="detail-value">Jane Cooper</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Email:</span>
                                <a href="mailto:jane@example.com" class="detail-value detail-link">jane@example.com</a>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Website:</span>
                                <a href="https://janecooper.com" target="_blank" class="detail-value detail-link">janecooper.com</a>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">IP Address:</span>
                                <span class="detail-value">192.168.1.42</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">User Agent:</span>
                                <span class="detail-value" style="font-size: 12px; word-break: break-all;">Mozilla/5.0 (Windows NT 10.0; Win64; x64)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Comment Details -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Comment Details</h2>
                        </div>
                        <div class="card-body">
                            <div class="detail-row">
                                <span class="detail-label">Status:</span>
                                <span class="detail-value">
                                    <span class="status-badge status-warning">Pending</span>
                                </span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Submitted:</span>
                                <span class="detail-value">Jan 14, 2026 3:45 PM</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">On Post:</span>
                                <a href="#" class="detail-value detail-link">Getting Started with Pressli CMS</a>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Comment ID:</span>
                                <span class="detail-value">#1847</span>
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
    <script>
        // Simple edit toggle
        document.getElementById('editCommentBtn').addEventListener('click', function() {
            const editForm = document.getElementById('editCommentForm');
            editForm.style.display = editForm.style.display === 'none' ? 'block' : 'none';
        });

        document.getElementById('cancelEdit').addEventListener('click', function() {
            document.getElementById('editCommentForm').style.display = 'none';
        });
    </script>
@endsection
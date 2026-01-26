@extends('admin/layout')

@section('content')

        <!-- Comments Content -->
        <main class="content">
            <div class="content-header">
                <h1 class="page-title">Comments</h1>
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

            <!-- Filters & Actions Bar -->
            <div class="card">
                <div class="table-toolbar">
                    <div class="table-tabs">
                        <a href="{{ Url::link('admin/comments') }}" class="tab-btn {{ !Input::get('status') ? 'active' : '' }}">
                            All <span class="tab-count">{{ $statusCounts['all'] }}</span>
                        </a>
                        <a href="{{ Url::link('admin/comments?status=pending') }}" class="tab-btn {{ Input::get('status') === 'pending' ? 'active' : '' }}">
                            Pending <span class="tab-count">{{ $statusCounts['pending'] }}</span>
                        </a>
                        <a href="{{ Url::link('admin/comments?status=approved') }}" class="tab-btn {{ Input::get('status') === 'approved' ? 'active' : '' }}">
                            Approved <span class="tab-count">{{ $statusCounts['approved'] }}</span>
                        </a>
                        <a href="{{ Url::link('admin/comments?status=spam') }}" class="tab-btn {{ Input::get('status') === 'spam' ? 'active' : '' }}">
                            Spam <span class="tab-count">{{ $statusCounts['spam'] }}</span>
                        </a>
                    </div>

                    <div class="table-actions">
                        <form method="POST" action="{{ Url::link('admin/comments/bulk') }}" id="bulkForm">
                            {{{ Csrf::field() }}}
                            <div class="bulk-actions">
                                <select class="select-input" disabled id="bulkAction" name="action">
                                    <option value="">Bulk Actions</option>
                                    <option value="approve">Approve</option>
                                    <option value="spam">Mark as Spam</option>
                                    <option value="trash">Move to Trash</option>
                                </select>
                                <button type="submit" class="btn btn-secondary" disabled id="applyBulk">Apply</button>
                            </div>
                        </form>

                        <div class="search-box">
                            <input type="search" placeholder="Search comments..." class="search-input">
                            <svg class="search-box-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Comments Table -->
                <div class="table-container">
                    <table class="data-table comments-table">
                        <thead>
                            <tr>
                                <th class="col-check">
                                    <input type="checkbox" id="selectAll" class="checkbox">
                                </th>
                                <th class="col-author-comment">Author</th>
                                <th class="col-comment">Comment</th>
                                <th class="col-post">In Response To</th>
                                <th class="col-date">Submitted On</th>
                            </tr>
                        </thead>
                        <tbody>
                            @loopelse($comments as $comment)
                            <tr class="{{ $comment['status'] === 'pending' ? 'comment-pending' : '' }}">
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check" name="ids[]" value="{{ $comment['id'] }}" form="bulkForm">
                                </td>
                                <td class="col-author-comment">
                                    <div class="comment-author-cell">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($comment['author_name']) }}&background=random&color=fff" alt="{{ $comment['author_name'] }}" class="author-avatar">
                                        <div>
                                            <div class="comment-author-name">{{ $comment['author_name'] }}</div>
                                            <div class="comment-author-email">{{ $comment['author_email'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-comment">
                                    <div class="comment-content">
                                        {{ $comment['content'] }}
                                    </div>
                                    <div class="row-actions">
                                        @if($comment['status'] === 'pending')
                                            <a href="{{ Url::link('admin/comments/approve/' . $comment['id']) }}" class="approve-link">Approve</a>
                                        @else
                                            <a href="{{ Url::link('admin/comments/unapprove/' . $comment['id']) }}" class="unapprove-link">Unapprove</a>
                                        @endif
                                        <span class="separator">|</span>
                                        <a href="#">Reply</a>
                                        <span class="separator">|</span>
                                        <a href="#">Edit</a>
                                        <span class="separator">|</span>
                                        <a href="{{ Url::link('admin/comments/spam/' . $comment['id']) }}" class="spam-link">Spam</a>
                                        <span class="separator">|</span>
                                        <a href="{{ Url::link('admin/comments/delete/' . $comment['id']) }}" class="danger" onclick="return confirm('Move this comment to trash?')">Trash</a>
                                    </div>
                                </td>
                                <td class="col-post">
                                    <a href="#" class="post-link">{{ $comment['post_title'] or 'Unknown Post' }}</a>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">
                                        {{ Date::format($comment['created_at'], 'M j, Y') }} <span class="date-time">{{ Date::format($comment['created_at'], 'g:i A') }}</span>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 3rem; color: #6b7280;">
                                    No comments found.
                                </td>
                            </tr>
                            @endloop
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="table-footer">
                    <div class="table-info">
                        Showing {{ count($comments) }} {{ count($comments) === 1 ? 'comment' : 'comments' }}
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
                        <button class="page-btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </main>
@endsection

<!-- JS Scripts -->
@section('scripts')
    @parent
    <script>
        // Select all checkbox functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.row-check');
            const bulkAction = document.getElementById('bulkAction');
            const applyBtn = document.getElementById('applyBulk');

            checkboxes.forEach(cb => cb.checked = this.checked);

            bulkAction.disabled = !this.checked;
            applyBtn.disabled = !this.checked;
        });

        // Individual checkbox change
        document.querySelectorAll('.row-check').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const anyChecked = document.querySelectorAll('.row-check:checked').length > 0;
                document.getElementById('bulkAction').disabled = !anyChecked;
                document.getElementById('applyBulk').disabled = !anyChecked;
            });
        });
    </script>
@endsection

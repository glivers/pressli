@extends('admin/layout')

@section('content')

        <!-- Comments Content -->
        <main class="content">
            <div class="content-header">
                <h1 class="page-title">Comments</h1>
            </div>

            <!-- Filters & Actions Bar -->
            <div class="card">
                <div class="table-toolbar">
                    <div class="table-tabs">
                        <button class="tab-btn active" data-filter="all">
                            All <span class="tab-count">45</span>
                        </button>
                        <button class="tab-btn" data-filter="pending">
                            Pending <span class="tab-count">3</span>
                        </button>
                        <button class="tab-btn" data-filter="approved">
                            Approved <span class="tab-count">38</span>
                        </button>
                        <button class="tab-btn" data-filter="spam">
                            Spam <span class="tab-count">4</span>
                        </button>
                    </div>

                    <div class="table-actions">
                        <div class="bulk-actions">
                            <select class="select-input" disabled id="bulkAction">
                                <option value="">Bulk Actions</option>
                                <option value="approve">Approve</option>
                                <option value="unapprove">Unapprove</option>
                                <option value="spam">Mark as Spam</option>
                                <option value="trash">Move to Trash</option>
                            </select>
                            <button class="btn btn-secondary" disabled id="applyBulk">Apply</button>
                        </div>

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
                                <th class="col-date">Submitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Comment Row 1 - Pending -->
                            <tr class="comment-pending">
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-author-comment">
                                    <div class="comment-author-cell">
                                        <img src="https://ui-avatars.com/api/?name=Jane+Cooper&background=10b981&color=fff" alt="Author" class="author-avatar">
                                        <div>
                                            <div class="comment-author-name">Jane Cooper</div>
                                            <div class="comment-author-email">jane@example.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-comment">
                                    <div class="comment-content">
                                        This is exactly what I was looking for! Thank you for sharing this comprehensive guide.
                                    </div>
                                    <div class="row-actions">
                                        <a href="#" class="approve-link">Approve</a>
                                        <span class="separator">|</span>
                                        <a href="#">Reply</a>
                                        <span class="separator">|</span>
                                        <a href="#">Edit</a>
                                        <span class="separator">|</span>
                                        <a href="#" class="spam-link">Spam</a>
                                        <span class="separator">|</span>
                                        <a href="#" class="danger">Trash</a>
                                    </div>
                                </td>
                                <td class="col-post">
                                    <a href="#" class="post-link">Getting Started with Pressli CMS</a>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">
                                        Jan 14, 2026 <span class="date-time">3:45 PM</span>
                                    </div>
                                </td>
                            </tr>

                            <!-- Comment Row 2 - Approved -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-author-comment">
                                    <div class="comment-author-cell">
                                        <img src="https://ui-avatars.com/api/?name=Robert+Fox&background=f59e0b&color=fff" alt="Author" class="author-avatar">
                                        <div>
                                            <div class="comment-author-name">Robert Fox</div>
                                            <div class="comment-author-email">robert@example.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-comment">
                                    <div class="comment-content">
                                        Great tutorial! I followed along and got everything working in under an hour.
                                    </div>
                                    <div class="row-actions">
                                        <a href="#" class="unapprove-link">Unapprove</a>
                                        <span class="separator">|</span>
                                        <a href="#">Reply</a>
                                        <span class="separator">|</span>
                                        <a href="#">Edit</a>
                                        <span class="separator">|</span>
                                        <a href="#" class="spam-link">Spam</a>
                                        <span class="separator">|</span>
                                        <a href="#" class="danger">Trash</a>
                                    </div>
                                </td>
                                <td class="col-post">
                                    <a href="#" class="post-link">10 Tips for Better Content Management</a>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">
                                        Jan 13, 2026 <span class="date-time">11:20 AM</span>
                                    </div>
                                </td>
                            </tr>

                            <!-- Comment Row 3 - Pending -->
                            <tr class="comment-pending">
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-author-comment">
                                    <div class="comment-author-cell">
                                        <img src="https://ui-avatars.com/api/?name=Sarah+Miller&background=4f46e5&color=fff" alt="Author" class="author-avatar">
                                        <div>
                                            <div class="comment-author-name">Sarah Miller</div>
                                            <div class="comment-author-email">sarah.m@example.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-comment">
                                    <div class="comment-content">
                                        Quick question - does this work with PHP 8.2? I'm planning to upgrade soon.
                                    </div>
                                    <div class="row-actions">
                                        <a href="#" class="approve-link">Approve</a>
                                        <span class="separator">|</span>
                                        <a href="#">Reply</a>
                                        <span class="separator">|</span>
                                        <a href="#">Edit</a>
                                        <span class="separator">|</span>
                                        <a href="#" class="spam-link">Spam</a>
                                        <span class="separator">|</span>
                                        <a href="#" class="danger">Trash</a>
                                    </div>
                                </td>
                                <td class="col-post">
                                    <a href="#" class="post-link">Understanding PHP MVC Architecture</a>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">
                                        Jan 12, 2026 <span class="date-time">2:15 PM</span>
                                    </div>
                                </td>
                            </tr>

                            <!-- Comment Row 4 - Approved -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-author-comment">
                                    <div class="comment-author-cell">
                                        <img src="https://ui-avatars.com/api/?name=Tom+Wilson&background=ec4899&color=fff" alt="Author" class="author-avatar">
                                        <div>
                                            <div class="comment-author-name">Tom Wilson</div>
                                            <div class="comment-author-email">tom.w@example.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-comment">
                                    <div class="comment-content">
                                        Bookmarking this for later. Very detailed and well-explained!
                                    </div>
                                    <div class="row-actions">
                                        <a href="#" class="unapprove-link">Unapprove</a>
                                        <span class="separator">|</span>
                                        <a href="#">Reply</a>
                                        <span class="separator">|</span>
                                        <a href="#">Edit</a>
                                        <span class="separator">|</span>
                                        <a href="#" class="spam-link">Spam</a>
                                        <span class="separator">|</span>
                                        <a href="#" class="danger">Trash</a>
                                    </div>
                                </td>
                                <td class="col-post">
                                    <a href="#" class="post-link">How to Create Custom Themes</a>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">
                                        Jan 11, 2026 <span class="date-time">9:30 AM</span>
                                    </div>
                                </td>
                            </tr>

                            <!-- Comment Row 5 - Approved -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-author-comment">
                                    <div class="comment-author-cell">
                                        <img src="https://ui-avatars.com/api/?name=Emily+Davis&background=14b8a6&color=fff" alt="Author" class="author-avatar">
                                        <div>
                                            <div class="comment-author-name">Emily Davis</div>
                                            <div class="comment-author-email">emily@example.com</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-comment">
                                    <div class="comment-content">
                                        The theming system looks really flexible. Can't wait to try building my own!
                                    </div>
                                    <div class="row-actions">
                                        <a href="#" class="unapprove-link">Unapprove</a>
                                        <span class="separator">|</span>
                                        <a href="#">Reply</a>
                                        <span class="separator">|</span>
                                        <a href="#">Edit</a>
                                        <span class="separator">|</span>
                                        <a href="#" class="spam-link">Spam</a>
                                        <span class="separator">|</span>
                                        <a href="#" class="danger">Trash</a>
                                    </div>
                                </td>
                                <td class="col-post">
                                    <a href="#" class="post-link">Building a Plugin System in PHP</a>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">
                                        Jan 10, 2026 <span class="date-time">4:50 PM</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="table-footer">
                    <div class="table-info">
                        Showing 1 to 5 of 45 comments
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
                        <button class="page-btn">9</button>
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
    <script src="{{Url::assets('js/comments.js')}}"></script>
@endsection

@extends('admin/layout')

@section('content')

        <!-- Posts Content -->
        <main class="content">
            <div class="content-header">
                <h1 class="page-title">Posts</h1>
                <button class="btn btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    New Post
                </button>
            </div>

            <!-- Filters & Actions Bar -->
            <div class="card">
                <div class="table-toolbar">
                    <div class="table-tabs">
                        <button class="tab-btn active" data-filter="all">
                            All <span class="tab-count">147</span>
                        </button>
                        <button class="tab-btn" data-filter="published">
                            Published <span class="tab-count">128</span>
                        </button>
                        <button class="tab-btn" data-filter="draft">
                            Draft <span class="tab-count">16</span>
                        </button>
                        <button class="tab-btn" data-filter="trash">
                            Trash <span class="tab-count">3</span>
                        </button>
                    </div>

                    <div class="table-actions">
                        <div class="bulk-actions">
                            <select class="select-input" disabled id="bulkAction">
                                <option value="">Bulk Actions</option>
                                <option value="publish">Publish</option>
                                <option value="draft">Move to Draft</option>
                                <option value="trash">Move to Trash</option>
                                <option value="delete">Delete Permanently</option>
                            </select>
                            <button class="btn btn-secondary" disabled id="applyBulk">Apply</button>
                        </div>

                        <div class="search-box">
                            <input type="search" placeholder="Search posts..." class="search-input">
                            <svg class="search-box-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.35-4.35"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Posts Table -->
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="col-check">
                                    <input type="checkbox" id="selectAll" class="checkbox">
                                </th>
                                <th class="col-title">Title</th>
                                <th class="col-author">Author</th>
                                <th class="col-category">Category</th>
                                <th class="col-status">Status</th>
                                <th class="col-date">Date</th>
                                <th class="col-actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Post Row 1 -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-title">
                                    <div class="title-cell">
                                        <a href="#" class="post-title">Getting Started with Pressli CMS</a>
                                        <div class="row-actions">
                                            <a href="#">Edit</a>
                                            <span class="separator">|</span>
                                            <a href="#">View</a>
                                            <span class="separator">|</span>
                                            <a href="#" class="danger">Trash</a>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-author">
                                    <div class="author-cell">
                                        <img src="https://ui-avatars.com/api/?name=John+Doe&background=4f46e5&color=fff" alt="Author" class="author-avatar">
                                        <span>John Doe</span>
                                    </div>
                                </td>
                                <td class="col-category">
                                    <span class="category-tag">Tutorials</span>
                                </td>
                                <td class="col-status">
                                    <span class="status-badge status-published">Published</span>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">
                                        Jan 14, 2026 <span class="date-time">2:30 PM</span>
                                    </div>
                                </td>
                                <td class="col-actions">
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                        <button class="btn-icon" title="More options">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Post Row 2 -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-title">
                                    <div class="title-cell">
                                        <a href="#" class="post-title">10 Tips for Better Content Management</a>
                                        <div class="row-actions">
                                            <a href="#">Edit</a>
                                            <span class="separator">|</span>
                                            <a href="#">View</a>
                                            <span class="separator">|</span>
                                            <a href="#" class="danger">Trash</a>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-author">
                                    <div class="author-cell">
                                        <img src="https://ui-avatars.com/api/?name=Sarah+Smith&background=10b981&color=fff" alt="Author" class="author-avatar">
                                        <span>Sarah Smith</span>
                                    </div>
                                </td>
                                <td class="col-category">
                                    <span class="category-tag">Tips & Tricks</span>
                                </td>
                                <td class="col-status">
                                    <span class="status-badge status-published">Published</span>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">
                                        Jan 13, 2026 <span class="date-time">4:15 PM</span>
                                    </div>
                                </td>
                                <td class="col-actions">
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                        <button class="btn-icon" title="More options">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Post Row 3 - Draft -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-title">
                                    <div class="title-cell">
                                        <a href="#" class="post-title">Understanding PHP MVC Architecture</a>
                                        <div class="row-actions">
                                            <a href="#">Edit</a>
                                            <span class="separator">|</span>
                                            <a href="#">Preview</a>
                                            <span class="separator">|</span>
                                            <a href="#" class="danger">Trash</a>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-author">
                                    <div class="author-cell">
                                        <img src="https://ui-avatars.com/api/?name=Admin+User&background=4f46e5&color=fff" alt="Author" class="author-avatar">
                                        <span>Admin User</span>
                                    </div>
                                </td>
                                <td class="col-category">
                                    <span class="category-tag">Development</span>
                                </td>
                                <td class="col-status">
                                    <span class="status-badge status-draft">Draft</span>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">
                                        Jan 11, 2026 <span class="date-time">Modified</span>
                                    </div>
                                </td>
                                <td class="col-actions">
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                        <button class="btn-icon" title="More options">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Post Row 4 -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-title">
                                    <div class="title-cell">
                                        <a href="#" class="post-title">How to Create Custom Themes</a>
                                        <div class="row-actions">
                                            <a href="#">Edit</a>
                                            <span class="separator">|</span>
                                            <a href="#">View</a>
                                            <span class="separator">|</span>
                                            <a href="#" class="danger">Trash</a>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-author">
                                    <div class="author-cell">
                                        <img src="https://ui-avatars.com/api/?name=Mike+Johnson&background=f59e0b&color=fff" alt="Author" class="author-avatar">
                                        <span>Mike Johnson</span>
                                    </div>
                                </td>
                                <td class="col-category">
                                    <span class="category-tag">Design</span>
                                </td>
                                <td class="col-status">
                                    <span class="status-badge status-published">Published</span>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">
                                        Jan 9, 2026 <span class="date-time">11:20 AM</span>
                                    </div>
                                </td>
                                <td class="col-actions">
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                        <button class="btn-icon" title="More options">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Post Row 5 - Scheduled -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-title">
                                    <div class="title-cell">
                                        <a href="#" class="post-title">Building a Plugin System in PHP</a>
                                        <div class="row-actions">
                                            <a href="#">Edit</a>
                                            <span class="separator">|</span>
                                            <a href="#">Preview</a>
                                            <span class="separator">|</span>
                                            <a href="#" class="danger">Trash</a>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-author">
                                    <div class="author-cell">
                                        <img src="https://ui-avatars.com/api/?name=Admin+User&background=4f46e5&color=fff" alt="Author" class="author-avatar">
                                        <span>Admin User</span>
                                    </div>
                                </td>
                                <td class="col-category">
                                    <span class="category-tag">Development</span>
                                </td>
                                <td class="col-status">
                                    <span class="status-badge status-scheduled">Scheduled</span>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">
                                        Jan 20, 2026 <span class="date-time">9:00 AM</span>
                                    </div>
                                </td>
                                <td class="col-actions">
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                        <button class="btn-icon" title="More options">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Post Row 6 -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-title">
                                    <div class="title-cell">
                                        <a href="#" class="post-title">SEO Best Practices for 2026</a>
                                        <div class="row-actions">
                                            <a href="#">Edit</a>
                                            <span class="separator">|</span>
                                            <a href="#">View</a>
                                            <span class="separator">|</span>
                                            <a href="#" class="danger">Trash</a>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-author">
                                    <div class="author-cell">
                                        <img src="https://ui-avatars.com/api/?name=Sarah+Smith&background=10b981&color=fff" alt="Author" class="author-avatar">
                                        <span>Sarah Smith</span>
                                    </div>
                                </td>
                                <td class="col-category">
                                    <span class="category-tag">SEO</span>
                                </td>
                                <td class="col-status">
                                    <span class="status-badge status-published">Published</span>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">
                                        Jan 7, 2026 <span class="date-time">3:45 PM</span>
                                    </div>
                                </td>
                                <td class="col-actions">
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                        <button class="btn-icon" title="More options">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Post Row 7 -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-title">
                                    <div class="title-cell">
                                        <a href="#" class="post-title">Advanced Database Optimization Techniques</a>
                                        <div class="row-actions">
                                            <a href="#">Edit</a>
                                            <span class="separator">|</span>
                                            <a href="#">View</a>
                                            <span class="separator">|</span>
                                            <a href="#" class="danger">Trash</a>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-author">
                                    <div class="author-cell">
                                        <img src="https://ui-avatars.com/api/?name=John+Doe&background=4f46e5&color=fff" alt="Author" class="author-avatar">
                                        <span>John Doe</span>
                                    </div>
                                </td>
                                <td class="col-category">
                                    <span class="category-tag">Development</span>
                                </td>
                                <td class="col-status">
                                    <span class="status-badge status-published">Published</span>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">
                                        Jan 5, 2026 <span class="date-time">10:15 AM</span>
                                    </div>
                                </td>
                                <td class="col-actions">
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                        <button class="btn-icon" title="More options">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Post Row 8 -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-title">
                                    <div class="title-cell">
                                        <a href="#" class="post-title">Responsive Design Patterns for Modern Web Apps</a>
                                        <div class="row-actions">
                                            <a href="#">Edit</a>
                                            <span class="separator">|</span>
                                            <a href="#">Preview</a>
                                            <span class="separator">|</span>
                                            <a href="#" class="danger">Trash</a>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-author">
                                    <div class="author-cell">
                                        <img src="https://ui-avatars.com/api/?name=Mike+Johnson&background=f59e0b&color=fff" alt="Author" class="author-avatar">
                                        <span>Mike Johnson</span>
                                    </div>
                                </td>
                                <td class="col-category">
                                    <span class="category-tag">Design</span>
                                </td>
                                <td class="col-status">
                                    <span class="status-badge status-draft">Draft</span>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">
                                        Jan 3, 2026 <span class="date-time">Modified</span>
                                    </div>
                                </td>
                                <td class="col-actions">
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                        <button class="btn-icon" title="More options">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Post Row 9 -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-title">
                                    <div class="title-cell">
                                        <a href="#" class="post-title">Content Marketing Strategies That Work</a>
                                        <div class="row-actions">
                                            <a href="#">Edit</a>
                                            <span class="separator">|</span>
                                            <a href="#">View</a>
                                            <span class="separator">|</span>
                                            <a href="#" class="danger">Trash</a>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-author">
                                    <div class="author-cell">
                                        <img src="https://ui-avatars.com/api/?name=Sarah+Smith&background=10b981&color=fff" alt="Author" class="author-avatar">
                                        <span>Sarah Smith</span>
                                    </div>
                                </td>
                                <td class="col-category">
                                    <span class="category-tag">Marketing</span>
                                </td>
                                <td class="col-status">
                                    <span class="status-badge status-published">Published</span>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">
                                        Dec 28, 2025 <span class="date-time">1:20 PM</span>
                                    </div>
                                </td>
                                <td class="col-actions">
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                        <button class="btn-icon" title="More options">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Post Row 10 -->
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="checkbox row-check">
                                </td>
                                <td class="col-title">
                                    <div class="title-cell">
                                        <a href="#" class="post-title">Migrating Legacy Applications to Cloud Infrastructure</a>
                                        <div class="row-actions">
                                            <a href="#">Edit</a>
                                            <span class="separator">|</span>
                                            <a href="#">View</a>
                                            <span class="separator">|</span>
                                            <a href="#" class="danger">Trash</a>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-author">
                                    <div class="author-cell">
                                        <img src="https://ui-avatars.com/api/?name=Admin+User&background=4f46e5&color=fff" alt="Author" class="author-avatar">
                                        <span>Admin User</span>
                                    </div>
                                </td>
                                <td class="col-category">
                                    <span class="category-tag">DevOps</span>
                                </td>
                                <td class="col-status">
                                    <span class="status-badge status-published">Published</span>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">
                                        Dec 22, 2025 <span class="date-time">8:30 AM</span>
                                    </div>
                                </td>
                                <td class="col-actions">
                                    <div class="action-buttons">
                                        <button class="btn-icon" title="Edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                        <button class="btn-icon" title="More options">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="table-footer">
                    <div class="table-info">
                        Showing 1 to 10 of 147 posts
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
                        <span class="page-dots">...</span>
                        <button class="page-btn">25</button>
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
    <script src="{{Url::assets('js/posts.js')}}"></script>
@endsection

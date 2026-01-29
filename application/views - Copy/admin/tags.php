@extends('admin/layout')

@section('content')

        <!-- Tags Content -->
        <main class="content">
            <div class="content-header">
                <div>
                    <h1 class="content-title">Tags</h1>
                    <p style="font-size: 13px; color: var(--text-tertiary); margin-top: 4px;">Organize your posts with tags</p>
                </div>
            </div>

            <div class="categories-layout">
                <!-- Add New Tag -->
                <div class="categories-sidebar">
                    <div class="card">
                        <div class="card-header">
                            <h3>Add New Tag</h3>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label class="form-label" for="tag-name">Name</label>
                                    <input type="text" id="tag-name" class="text-input" placeholder="JavaScript" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="tag-slug">Slug</label>
                                    <input type="text" id="tag-slug" class="text-input" placeholder="javascript">
                                    <p class="form-help">URL-friendly version (lowercase, no spaces)</p>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="tag-desc">Description</label>
                                    <textarea id="tag-desc" class="textarea-input" rows="4" placeholder="Brief description of this tag"></textarea>
                                    <p class="form-help">Optional. May be displayed by some themes.</p>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">Add Tag</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tags List -->
                <div class="categories-content">
                    <div class="card">
                        <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                            <h3>All Tags</h3>
                            <div style="display: flex; gap: var(--spacing-sm); align-items: center;">
                                <input type="search" class="text-input" placeholder="Search tags..." style="width: 240px;">
                            </div>
                        </div>

                        <table class="data-table categories-table">
                            <thead>
                                <tr>
                                    <th class="col-check">
                                        <input type="checkbox" id="selectAll">
                                    </th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Description</th>
                                    <th class="col-count">Posts</th>
                                    <th class="col-actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="col-check">
                                        <input type="checkbox">
                                    </td>
                                    <td><strong>JavaScript</strong></td>
                                    <td><code class="slug-code">javascript</code></td>
                                    <td class="text-secondary">Programming language for web development</td>
                                    <td class="col-count">24</td>
                                    <td class="col-actions">
                                        <button class="action-link">Edit</button>
                                        <span class="action-separator">|</span>
                                        <button class="action-link">View Posts</button>
                                        <span class="action-separator">|</span>
                                        <button class="action-link danger">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-check">
                                        <input type="checkbox">
                                    </td>
                                    <td><strong>React</strong></td>
                                    <td><code class="slug-code">react</code></td>
                                    <td class="text-secondary">JavaScript library for building user interfaces</td>
                                    <td class="col-count">18</td>
                                    <td class="col-actions">
                                        <button class="action-link">Edit</button>
                                        <span class="action-separator">|</span>
                                        <button class="action-link">View Posts</button>
                                        <span class="action-separator">|</span>
                                        <button class="action-link danger">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-check">
                                        <input type="checkbox">
                                    </td>
                                    <td><strong>CSS</strong></td>
                                    <td><code class="slug-code">css</code></td>
                                    <td class="text-secondary">Styling and layout for web pages</td>
                                    <td class="col-count">16</td>
                                    <td class="col-actions">
                                        <button class="action-link">Edit</button>
                                        <span class="action-separator">|</span>
                                        <button class="action-link">View Posts</button>
                                        <span class="action-separator">|</span>
                                        <button class="action-link danger">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-check">
                                        <input type="checkbox">
                                    </td>
                                    <td><strong>Node.js</strong></td>
                                    <td><code class="slug-code">nodejs</code></td>
                                    <td class="text-secondary">Server-side JavaScript runtime</td>
                                    <td class="col-count">14</td>
                                    <td class="col-actions">
                                        <button class="action-link">Edit</button>
                                        <span class="action-separator">|</span>
                                        <button class="action-link">View Posts</button>
                                        <span class="action-separator">|</span>
                                        <button class="action-link danger">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-check">
                                        <input type="checkbox">
                                    </td>
                                    <td><strong>Tutorial</strong></td>
                                    <td><code class="slug-code">tutorial</code></td>
                                    <td class="text-secondary">Step-by-step guides and tutorials</td>
                                    <td class="col-count">22</td>
                                    <td class="col-actions">
                                        <button class="action-link">Edit</button>
                                        <span class="action-separator">|</span>
                                        <button class="action-link">View Posts</button>
                                        <span class="action-separator">|</span>
                                        <button class="action-link danger">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-check">
                                        <input type="checkbox">
                                    </td>
                                    <td><strong>Best Practices</strong></td>
                                    <td><code class="slug-code">best-practices</code></td>
                                    <td class="text-secondary">Recommended approaches and patterns</td>
                                    <td class="col-count">12</td>
                                    <td class="col-actions">
                                        <button class="action-link">Edit</button>
                                        <span class="action-separator">|</span>
                                        <button class="action-link">View Posts</button>
                                        <span class="action-separator">|</span>
                                        <button class="action-link danger">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-check">
                                        <input type="checkbox">
                                    </td>
                                    <td><strong>Performance</strong></td>
                                    <td><code class="slug-code">performance</code></td>
                                    <td class="text-secondary">Optimization and speed improvements</td>
                                    <td class="col-count">9</td>
                                    <td class="col-actions">
                                        <button class="action-link">Edit</button>
                                        <span class="action-separator">|</span>
                                        <button class="action-link">View Posts</button>
                                        <span class="action-separator">|</span>
                                        <button class="action-link danger">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-check">
                                        <input type="checkbox">
                                    </td>
                                    <td><strong>API</strong></td>
                                    <td><code class="slug-code">api</code></td>
                                    <td class="text-secondary">Application programming interfaces</td>
                                    <td class="col-count">11</td>
                                    <td class="col-actions">
                                        <button class="action-link">Edit</button>
                                        <span class="action-separator">|</span>
                                        <button class="action-link">View Posts</button>
                                        <span class="action-separator">|</span>
                                        <button class="action-link danger">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-check">
                                        <input type="checkbox">
                                    </td>
                                    <td><strong>Security</strong></td>
                                    <td><code class="slug-code">security</code></td>
                                    <td class="text-secondary">Web security and best practices</td>
                                    <td class="col-count">8</td>
                                    <td class="col-actions">
                                        <button class="action-link">Edit</button>
                                        <span class="action-separator">|</span>
                                        <button class="action-link">View Posts</button>
                                        <span class="action-separator">|</span>
                                        <button class="action-link danger">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-check">
                                        <input type="checkbox">
                                    </td>
                                    <td><strong>Database</strong></td>
                                    <td><code class="slug-code">database</code></td>
                                    <td class="text-secondary">Database design and management</td>
                                    <td class="col-count">7</td>
                                    <td class="col-actions">
                                        <button class="action-link">Edit</button>
                                        <span class="action-separator">|</span>
                                        <button class="action-link">View Posts</button>
                                        <span class="action-separator">|</span>
                                        <button class="action-link danger">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="table-footer">
                            <div class="bulk-actions">
                                <select class="text-input">
                                    <option>Bulk Actions</option>
                                    <option>Delete</option>
                                </select>
                                <button class="btn btn-secondary btn-sm">Apply</button>
                            </div>
                            <div class="pagination">
                                <span class="pagination-info">Showing 1-10 of 10</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection

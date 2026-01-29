@extends('admin/layout')

@section('content')

        <!-- Categories Content -->
        <main class="content">
            <div class="content-header">
                <div>
                    <h1 class="content-title">Categories</h1>
                    <p style="font-size: 13px; color: var(--text-tertiary); margin-top: 4px;">Organize your posts into categories</p>
                </div>
            </div>

            <div class="categories-layout">
                <!-- Add New Category -->
                <div class="categories-sidebar">
                    <div class="card">
                        <div class="card-header">
                            <h3>Add New Category</h3>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label class="form-label" for="cat-name">Name</label>
                                    <input type="text" id="cat-name" class="text-input" placeholder="Technology" required>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="cat-slug">Slug</label>
                                    <input type="text" id="cat-slug" class="text-input" placeholder="technology">
                                    <p class="form-help">URL-friendly version (lowercase, no spaces)</p>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="cat-parent">Parent Category</label>
                                    <select id="cat-parent" class="text-input">
                                        <option value="">None</option>
                                        <option value="1">Technology</option>
                                        <option value="2">Design</option>
                                        <option value="3">Business</option>
                                    </select>
                                    <p class="form-help">Create a hierarchy of categories</p>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="cat-desc">Description</label>
                                    <textarea id="cat-desc" class="textarea-input" rows="4" placeholder="Brief description of this category"></textarea>
                                    <p class="form-help">Optional. May be displayed by some themes.</p>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">Add Category</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Categories List -->
                <div class="categories-content">
                    <div class="card">
                        <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                            <h3>All Categories</h3>
                            <div style="display: flex; gap: var(--spacing-sm); align-items: center;">
                                <input type="search" class="text-input" placeholder="Search categories..." style="width: 240px;">
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
                                    <td>
                                        <div class="category-name">
                                            <strong>Technology</strong>
                                        </div>
                                    </td>
                                    <td><code class="slug-code">technology</code></td>
                                    <td class="text-secondary">Posts about tech, software, and innovation</td>
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
                                    <td>
                                        <div class="category-name">
                                            <span class="category-indent">—</span> <strong>Web Development</strong>
                                        </div>
                                    </td>
                                    <td><code class="slug-code">web-development</code></td>
                                    <td class="text-secondary">Frontend, backend, and full-stack development</td>
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
                                    <td>
                                        <div class="category-name">
                                            <span class="category-indent">—</span> <strong>Mobile Apps</strong>
                                        </div>
                                    </td>
                                    <td><code class="slug-code">mobile-apps</code></td>
                                    <td class="text-secondary">iOS and Android app development</td>
                                    <td class="col-count">6</td>
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
                                    <td>
                                        <div class="category-name">
                                            <strong>Design</strong>
                                        </div>
                                    </td>
                                    <td><code class="slug-code">design</code></td>
                                    <td class="text-secondary">UI/UX design, graphic design, and more</td>
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
                                    <td>
                                        <div class="category-name">
                                            <span class="category-indent">—</span> <strong>UI Design</strong>
                                        </div>
                                    </td>
                                    <td><code class="slug-code">ui-design</code></td>
                                    <td class="text-secondary">User interface design principles</td>
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
                                    <td>
                                        <div class="category-name">
                                            <span class="category-indent">—</span> <strong>UX Design</strong>
                                        </div>
                                    </td>
                                    <td><code class="slug-code">ux-design</code></td>
                                    <td class="text-secondary">User experience and research</td>
                                    <td class="col-count">6</td>
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
                                    <td>
                                        <div class="category-name">
                                            <strong>Business</strong>
                                        </div>
                                    </td>
                                    <td><code class="slug-code">business</code></td>
                                    <td class="text-secondary">Entrepreneurship and business strategy</td>
                                    <td class="col-count">10</td>
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
                                    <td>
                                        <div class="category-name">
                                            <strong>Marketing</strong>
                                        </div>
                                    </td>
                                    <td><code class="slug-code">marketing</code></td>
                                    <td class="text-secondary">Digital marketing and growth strategies</td>
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
                                    <td>
                                        <div class="category-name">
                                            <strong>Lifestyle</strong>
                                        </div>
                                    </td>
                                    <td><code class="slug-code">lifestyle</code></td>
                                    <td class="text-secondary">Health, wellness, and lifestyle tips</td>
                                    <td class="col-count">7</td>
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
                                    <td>
                                        <div class="category-name">
                                            <strong>Uncategorized</strong>
                                        </div>
                                    </td>
                                    <td><code class="slug-code">uncategorized</code></td>
                                    <td class="text-secondary">Default category for posts</td>
                                    <td class="col-count">3</td>
                                    <td class="col-actions">
                                        <button class="action-link">Edit</button>
                                        <span class="action-separator">|</span>
                                        <button class="action-link">View Posts</button>
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

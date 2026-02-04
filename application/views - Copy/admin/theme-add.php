@extends('admin/layout')

@section('content')

        <!-- Add Theme Content -->
        <main class="content">
            <div class="content-header">
                <div class="header-breadcrumb">
                    <a href="themes.html" class="breadcrumb-link">Themes</a>
                    <svg class="breadcrumb-separator" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                    <span class="breadcrumb-current">Add New</span>
                </div>
            </div>

            <!-- Upload Theme -->
            <div class="card" style="margin-bottom: 32px;">
                <div class="card-header">
                    <h2 class="card-title">Upload Theme</h2>
                </div>
                <div class="card-body">
                    <p class="text-secondary" style="margin-bottom: 16px;">If you have a theme in a .zip format, you can install it by uploading it here.</p>
                    <div class="upload-area">
                        <svg class="upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" y1="3" x2="12" y2="15"></line>
                        </svg>
                        <p class="upload-text">Drop theme .zip file here or <span class="upload-link">browse</span></p>
                        <p class="upload-help">Maximum file size: 50 MB</p>
                        <input type="file" class="upload-input" accept=".zip">
                    </div>
                    <div class="form-actions">
                        <button class="btn btn-primary">Install Now</button>
                    </div>
                </div>
            </div>

            <!-- Browse Theme Directory -->
            <h2 class="section-title">Browse Theme Directory</h2>

            <!-- Theme Filters -->
            <div class="theme-directory-filters">
                <div class="search-box" style="flex: 1;">
                    <input type="search" placeholder="Search themes..." class="search-input">
                    <svg class="search-box-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                </div>
                <select class="select-input" style="width: 200px;">
                    <option>All Categories</option>
                    <option>Blog</option>
                    <option>Business</option>
                    <option>Portfolio</option>
                    <option>E-commerce</option>
                    <option>Magazine</option>
                </select>
                <select class="select-input" style="width: 180px;">
                    <option selected>Popular</option>
                    <option>Newest</option>
                    <option>Highest Rated</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                </select>
            </div>

            <!-- Theme Directory Grid -->
            <div class="themes-grid">
                <!-- Theme Item 1 -->
                <div class="theme-card">
                    <div class="theme-screenshot">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&h=300&fit=crop" alt="Nova">
                        <div class="theme-overlay">
                            <button class="btn btn-primary">Install</button>
                            <button class="btn btn-secondary">Preview</button>
                        </div>
                    </div>
                    <div class="theme-card-body">
                        <h4 class="theme-card-name">Nova</h4>
                        <p class="theme-card-author">By StudioWorks</p>
                        <div class="theme-card-meta">
                            <div class="theme-price">$49</div>
                            <div class="theme-rating-mini">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                4.8
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Theme Item 2 -->
                <div class="theme-card">
                    <div class="theme-screenshot">
                        <img src="https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=400&h=300&fit=crop" alt="Zenith">
                        <div class="theme-overlay">
                            <button class="btn btn-primary">Install</button>
                            <button class="btn btn-secondary">Preview</button>
                        </div>
                    </div>
                    <div class="theme-card-body">
                        <h4 class="theme-card-name">Zenith</h4>
                        <p class="theme-card-author">By PixelCraft</p>
                        <div class="theme-card-meta">
                            <div class="theme-price">Free</div>
                            <div class="theme-rating-mini">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                4.6
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Theme Item 3 -->
                <div class="theme-card">
                    <div class="theme-screenshot">
                        <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=400&h=300&fit=crop" alt="Quantum">
                        <div class="theme-overlay">
                            <button class="btn btn-primary">Install</button>
                            <button class="btn btn-secondary">Preview</button>
                        </div>
                    </div>
                    <div class="theme-card-body">
                        <h4 class="theme-card-name">Quantum</h4>
                        <p class="theme-card-author">By TechThemes</p>
                        <div class="theme-card-meta">
                            <div class="theme-price">$69</div>
                            <div class="theme-rating-mini">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                4.9
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Theme Item 4 -->
                <div class="theme-card">
                    <div class="theme-screenshot">
                        <img src="https://images.unsplash.com/photo-1504384764586-bb4cdc1707b0?w=400&h=300&fit=crop" alt="Pulse">
                        <div class="theme-overlay">
                            <button class="btn btn-primary">Install</button>
                            <button class="btn btn-secondary">Preview</button>
                        </div>
                    </div>
                    <div class="theme-card-body">
                        <h4 class="theme-card-name">Pulse</h4>
                        <p class="theme-card-author">By DesignHub</p>
                        <div class="theme-card-meta">
                            <div class="theme-price">$39</div>
                            <div class="theme-rating-mini">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                4.7
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Theme Item 5 -->
                <div class="theme-card">
                    <div class="theme-screenshot">
                        <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=400&h=300&fit=crop" alt="Nexus">
                        <div class="theme-overlay">
                            <button class="btn btn-primary">Install</button>
                            <button class="btn btn-secondary">Preview</button>
                        </div>
                    </div>
                    <div class="theme-card-body">
                        <h4 class="theme-card-name">Nexus</h4>
                        <p class="theme-card-author">By CreativeLab</p>
                        <div class="theme-card-meta">
                            <div class="theme-price">Free</div>
                            <div class="theme-rating-mini">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                4.5
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Theme Item 6 -->
                <div class="theme-card">
                    <div class="theme-screenshot">
                        <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=400&h=300&fit=crop" alt="Apex">
                        <div class="theme-overlay">
                            <button class="btn btn-primary">Install</button>
                            <button class="btn btn-secondary">Preview</button>
                        </div>
                    </div>
                    <div class="theme-card-body">
                        <h4 class="theme-card-name">Apex</h4>
                        <p class="theme-card-author">By ProDesign</p>
                        <div class="theme-card-meta">
                            <div class="theme-price">$79</div>
                            <div class="theme-rating-mini">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                5.0
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
@endsection
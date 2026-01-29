@extends('bota/templates/layout')

@section('main-content')

    <!-- 404 Content -->
    <section class="section">
        <div class="container">
            <div style="max-width: 800px; margin: 0 auto; text-align: center;">

                <!-- Error Code -->
                <div style="font-size: 8rem; font-weight: 700; color: var(--color-primary); line-height: 1; margin-bottom: 1rem; opacity: 0.2;">404</div>

                <h1 style="font-size: 2.5rem; margin-bottom: 1rem; color: var(--color-dark);">Page Not Found</h1>

                <p class="card-text" style="font-size: 1.125rem; margin-bottom: 2rem; color: var(--color-gray-600);">This page doesn't exist or was moved. If you clicked a link on our site, <a href="contact.html" style="color: var(--color-primary); text-decoration: underline;">let us know</a> so we can fix it.</p>

                <!-- Helpful Links -->
                <div style="margin: 3rem 0;">
                    <h2 style="font-size: 1.5rem; margin-bottom: 2rem; color: var(--color-dark);">Here's Where You Probably Want to Go</h2>
                    <div class="grid grid-3">
                        <a href="index.html" style="text-decoration: none;">
                            <div class="card" style="text-align: center; transition: transform 0.3s;">
                                <svg style="width: 48px; height: 48px; margin: 0 auto 1rem; color: var(--color-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <h3 class="card-title" style="font-size: 1.125rem; margin-bottom: 0.5rem;">Homepage</h3>
                                <p class="card-text" style="margin: 0;">Start from the beginning</p>
                            </div>
                        </a>
                        <a href="services.html" style="text-decoration: none;">
                            <div class="card" style="text-align: center; transition: transform 0.3s;">
                                <svg style="width: 48px; height: 48px; margin: 0 auto 1rem; color: var(--color-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <h3 class="card-title" style="font-size: 1.125rem; margin-bottom: 0.5rem;">Our Services</h3>
                                <p class="card-text" style="margin: 0;">See what we offer</p>
                            </div>
                        </a>
                        <a href="free-audit.html" style="text-decoration: none;">
                            <div class="card" style="text-align: center; transition: transform 0.3s;">
                                <svg style="width: 48px; height: 48px; margin: 0 auto 1rem; color: var(--color-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <h3 class="card-title" style="font-size: 1.125rem; margin-bottom: 0.5rem;">Free Audit</h3>
                                <p class="card-text" style="margin: 0;">Get your growth roadmap</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Search or Contact -->
                <div class="card" style="background-color: var(--color-light); margin-top: 3rem;">
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: var(--color-dark);">Still Can't Find What You Need?</h3>
                    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                        <a href="contact.html" class="btn btn-primary">Contact Us</a>
                        <a href="blog.html" class="btn btn-secondary" style="background-color: white; color: var(--color-primary); border-color: var(--color-primary);">Browse Blog</a>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
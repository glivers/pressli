@extends('bota/templates/layout')

@section('main-content')

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-content">
                    <div class="hero-badge">Trusted by 50+ SaaS Companies</div>
                    <h1 class="hero-title">Turn Organic Search Into Your Most Profitable Acquisition Channel</h1>
                    <p class="hero-subtitle">We help SaaS companies build sustainable customer acquisition engines through strategic SEO—without burning cash on ads that stop working the moment you pause them.</p>

                    <ul class="hero-benefits">
                        <li class="hero-benefit-item">
                            <svg class="hero-check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>2X trial signups in 90 days targeting high-intent searchers</span>
                        </li>
                        <li class="hero-benefit-item">
                            <svg class="hero-check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>$100K+ revenue generated through content-driven SEO</span>
                        </li>
                        <li class="hero-benefit-item">
                            <svg class="hero-check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>8.53% average CVR from cold organic traffic (vs industry 2-3%)</span>
                        </li>
                        <li class="hero-benefit-item">
                            <svg class="hero-check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Lower CAC by building organic channels that compound over time</span>
                        </li>
                    </ul>

                    <div class="hero-cta">
                        <a href="free-audit.html" class="btn btn-primary btn-large">Get Your SaaS Growth Audit</a>
                        <a href="services.html" class="btn btn-secondary btn-large">Our Services</a>
                    </div>
                </div>
                <div class="hero-visual">
                    <div class="hero-image-placeholder">
                        <!-- Placeholder for hero image/illustration -->
                        <svg class="hero-placeholder-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <p class="placeholder-text">Your Hero Image Here</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Overview -->
    <section id="services" class="section bg-light">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title">What We Do Best</h2>
                <p class="section-subtitle">Comprehensive SEO solutions tailored for SaaS businesses</p>
            </div>
            <div class="grid grid-3">
                <div class="card">
                    <div class="card-icon">
                        <svg class="icon icon-large" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="card-title">SaaS SEO Strategy</h3>
                    <p class="card-text">Custom SEO roadmaps designed specifically for SaaS growth metrics and customer acquisition goals.</p>
                    <a href="services/saas-seo-strategy.html" class="link-arrow">Learn more</a>
                </div>
                <div class="card">
                    <div class="card-icon">
                        <svg class="icon icon-large" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                        </svg>
                    </div>
                    <h3 class="card-title">Technical SEO</h3>
                    <p class="card-text">Deep technical audits, site performance optimization, and schema implementation for maximum visibility.</p>
                    <a href="services/technical-seo.html" class="link-arrow">Learn more</a>
                </div>
                <div class="card">
                    <div class="card-icon">
                        <svg class="icon icon-large" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <h3 class="card-title">Content Marketing</h3>
                    <p class="card-text">SEO-driven content strategies that attract, engage, and convert your ideal customers.</p>
                    <a href="services/content-marketing.html" class="link-arrow">Learn more</a>
                </div>
                <div class="card">
                    <div class="card-icon">
                        <svg class="icon icon-large" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                    </div>
                    <h3 class="card-title">Link Building</h3>
                    <p class="card-text">White-hat link acquisition strategies that build authority and improve domain rankings.</p>
                    <a href="services/link-building.html" class="link-arrow">Learn more</a>
                </div>
                <div class="card">
                    <div class="card-icon">
                        <svg class="icon icon-large" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="card-title">Keyword Research</h3>
                    <p class="card-text">Data-driven keyword analysis to identify high-value opportunities and search intent.</p>
                    <a href="services/keyword-research.html" class="link-arrow">Learn more</a>
                </div>
                <div class="card">
                    <div class="card-icon">
                        <svg class="icon icon-large" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="card-title">Video SEO</h3>
                    <p class="card-text">Optimize video content across YouTube, TikTok, and other platforms to capture high-intent searches and drive organic traffic.</p>
                    <a href="services/video-seo.html" class="link-arrow">Learn more</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="section">
        <div class="container">
            <div class="two-column">
                <div class="column">
                    <h2 class="section-title">Why Work With Us?</h2>
                    <p class="feature-intro">Unlike agencies that hand you off to junior teams after the sales call, you work directly with senior strategists who've done this before. We intentionally limit our client roster to 8 active projects—so your business gets the attention it deserves, not lost in a corporate pipeline.</p>
                    <div class="feature-list">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div class="feature-content">
                                <h3 class="feature-title">We Speak SaaS, Not Generic SEO</h3>
                                <p class="feature-text">If you're a founder, you care about MRR, CAC, and trial-to-paid conversion—not vanity traffic. We get it. Our strategies are built around the metrics that actually matter to your board.</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div class="feature-content">
                                <h3 class="feature-title">You'll See ROI, Not Just Reports</h3>
                                <p class="feature-text">Every strategy is tied to revenue. You'll get transparent monthly reports showing exactly how organic traffic impacts your trial signups, demo bookings, and customer acquisition costs.</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div class="feature-content">
                                <h3 class="feature-title">No Junior Teams, No Handoffs</h3>
                                <p class="feature-text">You work directly with the strategists building your campaigns. The person on your kickoff call? That's who's doing the work. No bait-and-switch.</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div class="feature-content">
                                <h3 class="feature-title">Built for Growing SaaS</h3>
                                <p class="feature-text">Whether you're pre-revenue or pushing toward $10M ARR, we've helped SaaS companies at your stage turn organic search into a predictable acquisition channel.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="stats-card">
                        <div class="stat">
                            <div class="stat-number">250%</div>
                            <div class="stat-label">Average Organic Growth</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number">94%</div>
                            <div class="stat-label">Client Retention Rate</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number">50+</div>
                            <div class="stat-label">SaaS Companies Served</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number">8 Years</div>
                            <div class="stat-label">Industry Experience</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Proof / Testimonials -->
    <section class="section bg-light">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title">What Our Clients Say</h2>
                <p class="section-subtitle">Real results from real SaaS businesses</p>
            </div>
            <div class="grid grid-2">
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "Boterns transformed our organic traffic. We went from page 3 to position 1 for our core keywords within 6 months. Their SaaS expertise made all the difference."
                    </div>
                    <div class="testimonial-author">
                        <div class="author-info">
                            <div class="author-name">Sarah Chen</div>
                            <div class="author-title">CEO, CloudMetrics</div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "The technical SEO audit alone was worth the investment. Our site speed improved by 60%, and we're finally ranking for competitive terms in our industry."
                    </div>
                    <div class="testimonial-author">
                        <div class="author-info">
                            <div class="author-name">Michael Rodriguez</div>
                            <div class="author-title">VP Marketing, DataSync Pro</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@endsection
@extends('bota/templates/layout')

@section('main-content')

    <!-- Service Hero -->
    <section class="hero">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-content">
                    <div class="hero-badge">Foundation Service</div>
                    <h1 class="hero-title">Technical SEO That Actually Moves the Needle</h1>
                    <p class="hero-subtitle">Your content might be great, but if Google can't crawl your site properly, you're invisible. Technical SEO fixes the foundational issues preventing you from ranking—and converts more of the traffic you already have.</p>
                    <div class="hero-cta">
                        <a href="../free-audit.html" class="btn btn-primary btn-large">Get a Technical Audit</a>
                        <a href="../contact.html" class="btn btn-secondary btn-large">Talk to an Expert</a>
                    </div>
                </div>
                <div class="hero-visual">
                    <div class="stats-card">
                        <div class="stat">
                            <div class="stat-number">60%</div>
                            <div class="stat-label">Site Speed Improvement</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number">340%</div>
                            <div class="stat-label">Organic Traffic Increase</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number">47</div>
                            <div class="stat-label">New Page 1 Rankings</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number">100%</div>
                            <div class="stat-label">Indexation Issues Fixed</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- What We Fix -->
    <section class="section">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title">Common Technical Issues We Fix</h2>
                <p class="section-subtitle">The problems silently killing your rankings and traffic</p>
            </div>
            <div class="grid grid-2">
                <div class="card">
                    <h3 class="card-title">Site Speed & Core Web Vitals</h3>
                    <p class="card-text">Slow sites don't rank and don't convert. We optimize your Core Web Vitals (LCP, FID, CLS) to meet Google's standards and improve user experience. Faster sites = better rankings = more trial signups.</p>
                    <p class="card-text">We've helped clients improve page speed by 40-60%, resulting in better rankings and higher conversion rates.</p>
                </div>
                <div class="card">
                    <h3 class="card-title">Crawl Budget & Indexation</h3>
                    <p class="card-text">If Google can't crawl your important pages or is wasting time on low-value URLs, you won't rank. We optimize your crawl budget, fix indexation issues, and ensure your high-priority pages get discovered and ranked.</p>
                    <p class="card-text">This is especially critical for SaaS platforms with hundreds or thousands of pages.</p>
                </div>
                <div class="card">
                    <h3 class="card-title">Mobile Optimization</h3>
                    <p class="card-text">Google uses mobile-first indexing. If your site doesn't work perfectly on mobile, you're losing rankings. We audit and fix mobile usability issues, responsive design problems, and mobile page speed.</p>
                    <p class="card-text">Over 60% of B2B SaaS searches happen on mobile—you can't afford to ignore this.</p>
                </div>
                <div class="card">
                    <h3 class="card-title">Structured Data & Schema Markup</h3>
                    <p class="card-text">Structured data helps Google understand your content and can unlock rich results in search. We implement SoftwareApplication schema, FAQ markup, and other relevant structured data to maximize your SERP real estate.</p>
                    <p class="card-text">Rich results can improve click-through rates by 20-30%.</p>
                </div>
                <div class="card">
                    <h3 class="card-title">Duplicate Content & Canonicalization</h3>
                    <p class="card-text">Duplicate content confuses Google and dilutes your ranking potential. We identify and fix duplicate content issues, implement proper canonical tags, and consolidate link equity to your most important pages.</p>
                    <p class="card-text">This is common with SaaS sites that have multiple URL variations or staging environments leaking into search.</p>
                </div>
                <div class="card">
                    <h3 class="card-title">Site Architecture & URL Structure</h3>
                    <p class="card-text">Poor site architecture makes it harder for Google to understand your content hierarchy and for users to navigate your site. We design clean, logical URL structures and internal linking systems that improve both rankings and user experience.</p>
                    <p class="card-text">Good architecture = better crawlability = higher rankings.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- What's Included -->
    <section class="section bg-light">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title">What's Included in Technical SEO</h2>
            </div>
            <div class="grid grid-3">
                <div class="card">
                    <h3 class="card-title">Comprehensive Technical Audit</h3>
                    <p class="card-text">We crawl your entire site and identify every technical issue impacting your SEO performance: indexation problems, crawl errors, speed issues, mobile problems, and more.</p>
                </div>
                <div class="card">
                    <h3 class="card-title">Prioritized Fix Roadmap</h3>
                    <p class="card-text">Not all technical issues are equal. We prioritize fixes based on impact—what will move the needle fastest for your rankings and traffic.</p>
                </div>
                <div class="card">
                    <h3 class="card-title">Implementation Support</h3>
                    <p class="card-text">We don't just hand you a report. We work directly with your dev team to implement fixes, or we can handle implementation ourselves if needed.</p>
                </div>
                <div class="card">
                    <h3 class="card-title">Core Web Vitals Optimization</h3>
                    <p class="card-text">We optimize your LCP, FID, and CLS scores to meet Google's standards. This includes image optimization, lazy loading, code minification, and server response improvements.</p>
                </div>
                <div class="card">
                    <h3 class="card-title">Structured Data Implementation</h3>
                    <p class="card-text">We add relevant schema markup to help Google understand your content and unlock rich results in search.</p>
                </div>
                <div class="card">
                    <h3 class="card-title">Ongoing Monitoring</h3>
                    <p class="card-text">Technical SEO isn't one-and-done. We continuously monitor for new issues, algorithm updates, and opportunities for improvement.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section cta-section">
        <div class="container">
            <div class="cta-content text-center">
                <h2 class="cta-title">Find Out What's Holding Your Site Back</h2>
                <p class="cta-text">Get a free technical audit showing the exact issues preventing you from ranking and how to fix them.</p>
                <a href="../free-audit.html" class="btn btn-primary btn-large">Get Your Free Technical Audit</a>
            </div>
        </div>
    </section>

@endsection
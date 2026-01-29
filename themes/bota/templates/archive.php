@extends('bota/templates/layout')

@section('main-content')

    <!-- Blog Hero -->
    <section class="hero">
        <div class="container">
            <div class="hero-content-center">
                <h1 class="hero-title">SaaS SEO Strategies That Actually Work</h1>
                <p class="hero-subtitle">No fluff. No generic SEO advice. Just actionable strategies for building sustainable customer acquisition channels for your SaaS.</p>
            </div>
        </div>
    </section>

    <!-- Featured Post -->
    <section class="section">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title">Featured Post</h2>
            </div>
            <div class="card" style="max-width: 900px; margin: 0 auto;">
                <div class="two-column">
                    <div>
                        <div style="background-color: #F3F4F6; height: 300px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #9CA3AF;">
                            [Featured Image]
                        </div>
                    </div>
                    <div>
                        <div style="display: inline-block; background-color: #047857; color: white; padding: 0.375rem 0.75rem; border-radius: 4px; font-size: 0.875rem; font-weight: 600; margin-bottom: 1rem;">SaaS Strategy</div>
                        <h3 style="font-size: 1.75rem; margin-bottom: 1rem; line-height: 1.3;">How to Identify High-Intent Keywords That Actually Drive Trial Signups</h3>
                        <p class="card-text">Most SaaS companies waste time chasing keywords with high volume but zero commercial intent. Here's how to find the searches that actually convert to trial signups and demo bookings.</p>
                        <div style="display: flex; align-items: center; gap: 1rem; margin-top: 1.5rem; color: #6B7280; font-size: 0.875rem;">
                            <span>By Sarah Chen</span>
                            <span>•</span>
                            <span>January 20, 2026</span>
                            <span>•</span>
                            <span>8 min read</span>
                        </div>
                        <a href="blog/high-intent-keywords.html" class="btn btn-primary" style="margin-top: 1.5rem;">Read Article</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Filter -->
    <section class="section bg-light">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title">Browse by Category</h2>
            </div>
            <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap; margin-bottom: 3rem;">
                <a href="blog.html?category=all" class="btn btn-primary btn-small">All Posts</a>
                <a href="blog.html?category=saas-strategy" class="btn btn-secondary btn-small" style="background-color: white; color: #0F4C81; border-color: #0F4C81;">SaaS Strategy</a>
                <a href="blog.html?category=content-marketing" class="btn btn-secondary btn-small" style="background-color: white; color: #0F4C81; border-color: #0F4C81;">Content Marketing</a>
                <a href="blog.html?category=technical-seo" class="btn btn-secondary btn-small" style="background-color: white; color: #0F4C81; border-color: #0F4C81;">Technical SEO</a>
                <a href="blog.html?category=link-building" class="btn btn-secondary btn-small" style="background-color: white; color: #0F4C81; border-color: #0F4C81;">Link Building</a>
                <a href="blog.html?category=case-studies" class="btn btn-secondary btn-small" style="background-color: white; color: #0F4C81; border-color: #0F4C81;">Case Studies</a>
            </div>

            <!-- Blog Posts Grid -->
            <div class="grid grid-3">
                <!-- Blog Post 1 -->
                <div class="card">
                    <div style="background-color: #F3F4F6; height: 200px; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: center; color: #9CA3AF;">
                        [Post Image]
                    </div>
                    <div style="display: inline-block; background-color: #047857; color: white; padding: 0.375rem 0.75rem; border-radius: 4px; font-size: 0.875rem; font-weight: 600; margin-bottom: 1rem;">Content Marketing</div>
                    <h3 class="card-title">Why Your SaaS Blog Isn't Driving Signups (And How to Fix It)</h3>
                    <p class="card-text">Publishing content consistently but not seeing trial signups? You're targeting the wrong keywords. Here's what to do instead.</p>
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin: 1rem 0; color: #6B7280; font-size: 0.875rem;">
                        <span>January 18, 2026</span>
                        <span>•</span>
                        <span>6 min read</span>
                    </div>
                    <a href="blog/saas-blog-not-driving-signups.html" class="link-arrow">Read More</a>
                </div>

                <!-- Blog Post 2 -->
                <div class="card">
                    <div style="background-color: #F3F4F6; height: 200px; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: center; color: #9CA3AF;">
                        [Post Image]
                    </div>
                    <div style="display: inline-block; background-color: #0F4C81; color: white; padding: 0.375rem 0.75rem; border-radius: 4px; font-size: 0.875rem; font-weight: 600; margin-bottom: 1rem;">Technical SEO</div>
                    <h3 class="card-title">7 Technical SEO Issues Killing Your SaaS Site Rankings</h3>
                    <p class="card-text">Your content might be great, but these technical issues are preventing Google from ranking you. Here's how to fix them.</p>
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin: 1rem 0; color: #6B7280; font-size: 0.875rem;">
                        <span>January 15, 2026</span>
                        <span>•</span>
                        <span>10 min read</span>
                    </div>
                    <a href="blog/technical-seo-issues.html" class="link-arrow">Read More</a>
                </div>

                <!-- Blog Post 3 -->
                <div class="card">
                    <div style="background-color: #F3F4F6; height: 200px; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: center; color: #9CA3AF;">
                        [Post Image]
                    </div>
                    <div style="display: inline-block; background-color: #047857; color: white; padding: 0.375rem 0.75rem; border-radius: 4px; font-size: 0.875rem; font-weight: 600; margin-bottom: 1rem;">SaaS Strategy</div>
                    <h3 class="card-title">How to Calculate SEO ROI for Your SaaS (With Real Examples)</h3>
                    <p class="card-text">Stop reporting on vanity metrics. Here's how to prove SEO is driving actual revenue for your business using metrics your CFO cares about.</p>
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin: 1rem 0; color: #6B7280; font-size: 0.875rem;">
                        <span>January 12, 2026</span>
                        <span>•</span>
                        <span>12 min read</span>
                    </div>
                    <a href="blog/calculate-seo-roi.html" class="link-arrow">Read More</a>
                </div>

                <!-- Blog Post 4 -->
                <div class="card">
                    <div style="background-color: #F3F4F6; height: 200px; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: center; color: #9CA3AF;">
                        [Post Image]
                    </div>
                    <div style="display: inline-block; background-color: #F97316; color: white; padding: 0.375rem 0.75rem; border-radius: 4px; font-size: 0.875rem; font-weight: 600; margin-bottom: 1rem;">Link Building</div>
                    <h3 class="card-title">The Only Link Building Strategy That Works for B2B SaaS</h3>
                    <p class="card-text">Guest posting is dead. Here's the link building strategy that actually moves the needle for SaaS companies in competitive markets.</p>
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin: 1rem 0; color: #6B7280; font-size: 0.875rem;">
                        <span>January 10, 2026</span>
                        <span>•</span>
                        <span>9 min read</span>
                    </div>
                    <a href="blog/link-building-strategy.html" class="link-arrow">Read More</a>
                </div>

                <!-- Blog Post 5 -->
                <div class="card">
                    <div style="background-color: #F3F4F6; height: 200px; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: center; color: #9CA3AF;">
                        [Post Image]
                    </div>
                    <div style="display: inline-block; background-color: #0F4C81; color: white; padding: 0.375rem 0.75rem; border-radius: 4px; font-size: 0.875rem; font-weight: 600; margin-bottom: 1rem;">Case Studies</div>
                    <h3 class="card-title">How We Doubled Trial Signups in 90 Days With Comparison Content</h3>
                    <p class="card-text">Inside look at the exact comparison content strategy we used to help a customer support SaaS double their weekly trial signups.</p>
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin: 1rem 0; color: #6B7280; font-size: 0.875rem;">
                        <span>January 8, 2026</span>
                        <span>•</span>
                        <span>11 min read</span>
                    </div>
                    <a href="blog/doubled-trial-signups.html" class="link-arrow">Read More</a>
                </div>

                <!-- Blog Post 6 -->
                <div class="card">
                    <div style="background-color: #F3F4F6; height: 200px; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: center; color: #9CA3AF;">
                        [Post Image]
                    </div>
                    <div style="display: inline-block; background-color: #047857; color: white; padding: 0.375rem 0.75rem; border-radius: 4px; font-size: 0.875rem; font-weight: 600; margin-bottom: 1rem;">Content Marketing</div>
                    <h3 class="card-title">Bottom-of-Funnel Content: The Fastest Way to SEO Revenue</h3>
                    <p class="card-text">Why bottom-of-funnel content drives 10x more revenue than top-of-funnel, and how to build a BOFU content strategy for your SaaS.</p>
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin: 1rem 0; color: #6B7280; font-size: 0.875rem;">
                        <span>January 5, 2026</span>
                        <span>•</span>
                        <span>7 min read</span>
                    </div>
                    <a href="blog/bottom-funnel-content.html" class="link-arrow">Read More</a>
                </div>
            </div>

            <!-- Pagination -->
            <div style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 3rem;">
                <button class="btn btn-primary btn-small" disabled style="opacity: 0.5;">Previous</button>
                <button class="btn btn-primary btn-small">1</button>
                <button class="btn btn-secondary btn-small" style="background-color: white; color: #0F4C81; border-color: #0F4C81;">2</button>
                <button class="btn btn-secondary btn-small" style="background-color: white; color: #0F4C81; border-color: #0F4C81;">3</button>
                <button class="btn btn-secondary btn-small" style="background-color: white; color: #0F4C81; border-color: #0F4C81;">Next</button>
            </div>
        </div>
    </section>

    <!-- Newsletter Signup -->
    <section class="section">
        <div class="container">
            <div class="card" style="max-width: 700px; margin: 0 auto; text-align: center; padding: 3rem;">
                <h2 class="section-title">Get SaaS SEO Insights in Your Inbox</h2>
                <p class="card-text" style="font-size: 1.125rem; margin-bottom: 2rem;">Join 500+ SaaS founders and marketers getting actionable SEO strategies every week. No fluff, no generic advice.</p>
                <form style="display: flex; gap: 1rem; max-width: 500px; margin: 0 auto;">
                    <input type="email" placeholder="Your email address" class="form-input" style="flex: 1;">
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </form>
                <p style="font-size: 0.875rem; color: #6B7280; margin-top: 1rem;">Unsubscribe anytime. We respect your inbox.</p>
            </div>
        </div>
    </section>

@endsection
@extends('bota/templates/layout')

@section('main-content')

    <!-- Terms Hero -->
    <section class="section bg-light">
        <div class="container">
            <div class="hero-content-center">
                <h1 class="hero-title" style="color: var(--color-dark);">Terms of Service</h1>
                <p class="hero-subtitle" style="color: var(--color-gray-600); opacity: 1;">Our commitment to transparent and fair business practices</p>
                <div style="display: inline-block; background-color: var(--color-gray-200); padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.875rem; margin-top: 1rem;">
                    Last Updated: January 26, 2026
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Summary -->
    <section class="section">
        <div class="container">
            <div style="max-width: 900px; margin: 0 auto;">
                <div class="card" style="border-left: 4px solid var(--color-secondary); background-color: #F0FDF4;">
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: var(--color-dark);">The Basics</h3>
                    <p class="card-text">We provide SEO services. You pay us. We do great work. We can't guarantee specific rankings (no one can), but we promise to use white-hat methods and transparent communication. Either party can terminate with proper notice after the minimum commitment period.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Terms Content -->
    <section class="section">
        <div class="container">
            <div style="max-width: 900px; margin: 0 auto;">

                <!-- Section 1 -->
                <div class="card" style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">1. Acceptance of Terms</h2>
                    <p class="card-text">By accessing or using Boterns' services, you agree to be bound by these Terms of Service. If you do not agree with any part of these terms, you may not use our services.</p>
                </div>

                <!-- Section 2 -->
                <div class="card" style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">2. Services Provided</h2>
                    <p class="card-text" style="margin-bottom: 1rem;">Boterns provides SEO and digital marketing services including but not limited to:</p>
                    <div class="grid grid-2">
                        <div style="background-color: var(--color-light); padding: 1.25rem; border-radius: var(--border-radius);">
                            <p class="card-text" style="font-weight: 600; margin-bottom: 0.5rem;">Strategy & Consulting</p>
                            <p class="card-text" style="margin: 0;">SaaS SEO strategy and consulting</p>
                        </div>
                        <div style="background-color: var(--color-light); padding: 1.25rem; border-radius: var(--border-radius);">
                            <p class="card-text" style="font-weight: 600; margin-bottom: 0.5rem;">Technical SEO</p>
                            <p class="card-text" style="margin: 0;">Audits and implementation</p>
                        </div>
                        <div style="background-color: var(--color-light); padding: 1.25rem; border-radius: var(--border-radius);">
                            <p class="card-text" style="font-weight: 600; margin-bottom: 0.5rem;">Content Marketing</p>
                            <p class="card-text" style="margin: 0;">Content creation and optimization</p>
                        </div>
                        <div style="background-color: var(--color-light); padding: 1.25rem; border-radius: var(--border-radius);">
                            <p class="card-text" style="font-weight: 600; margin-bottom: 0.5rem;">Link Building</p>
                            <p class="card-text" style="margin: 0;">White-hat link building and outreach</p>
                        </div>
                        <div style="background-color: var(--color-light); padding: 1.25rem; border-radius: var(--border-radius);">
                            <p class="card-text" style="font-weight: 600; margin-bottom: 0.5rem;">Keyword Research</p>
                            <p class="card-text" style="margin: 0;">High-intent keyword analysis</p>
                        </div>
                        <div style="background-color: var(--color-light); padding: 1.25rem; border-radius: var(--border-radius);">
                            <p class="card-text" style="font-weight: 600; margin-bottom: 0.5rem;">Video SEO</p>
                            <p class="card-text" style="margin: 0;">YouTube, TikTok, and video optimization</p>
                        </div>
                    </div>
                </div>

                <!-- Section 3 -->
                <div class="card" style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">3. Engagement Terms</h2>
                    <div style="background-color: var(--color-light); padding: 1.5rem; border-radius: var(--border-radius); margin-bottom: 1rem;">
                        <p style="font-weight: 600; margin-bottom: 0.5rem; color: var(--color-dark);">Service Agreements</p>
                        <p class="card-text" style="margin: 0;">Specific service terms, deliverables, and pricing will be outlined in individual service agreements or statements of work.</p>
                    </div>
                    <div style="background-color: var(--color-light); padding: 1.5rem; border-radius: var(--border-radius); margin-bottom: 1rem;">
                        <p style="font-weight: 600; margin-bottom: 0.5rem; color: var(--color-dark);">Payment Terms</p>
                        <p class="card-text" style="margin: 0;">Payment is due according to the terms specified in your service agreement. Late payments may result in service suspension or termination.</p>
                    </div>
                    <div style="background-color: var(--color-light); padding: 1.5rem; border-radius: var(--border-radius);">
                        <p style="font-weight: 600; margin-bottom: 0.5rem; color: var(--color-dark);">Contract Duration</p>
                        <p class="card-text" style="margin: 0;">Most engagements require a minimum commitment period as specified in the service agreement. Early termination may incur fees as outlined in your agreement.</p>
                    </div>
                </div>

                <!-- Section 4 -->
                <div class="card" style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">4. Client Responsibilities</h2>
                    <p class="card-text" style="margin-bottom: 1rem;">As a client, you agree to:</p>
                    <ul style="list-style: disc; margin-left: 2rem;">
                        <li class="card-text" style="margin-bottom: 0.5rem;">Provide accurate information about your business and website</li>
                        <li class="card-text" style="margin-bottom: 0.5rem;">Grant necessary access to your website, analytics, and other relevant platforms</li>
                        <li class="card-text" style="margin-bottom: 0.5rem;">Respond to requests for information in a timely manner</li>
                        <li class="card-text" style="margin-bottom: 0.5rem;">Review and approve deliverables as outlined in the service agreement</li>
                        <li class="card-text" style="margin-bottom: 0.5rem;">Maintain ownership and responsibility for your website and content</li>
                    </ul>
                </div>

                <!-- Section 5 - Important -->
                <div class="card" style="margin-bottom: 2rem; border-left: 4px solid var(--color-accent);">
                    <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">5. Results and Guarantees</h2>
                    <p class="card-text" style="margin-bottom: 1rem;">While we strive to deliver excellent results, SEO outcomes depend on many factors including search engine algorithms, competition, and your website's history.</p>
                    <div style="background-color: #FFF7ED; padding: 1.5rem; border-radius: var(--border-radius); border-left: 4px solid var(--color-accent); margin: 1.5rem 0;">
                        <p style="font-weight: 600; margin-bottom: 0.75rem; color: var(--color-dark);">We Cannot Guarantee:</p>
                        <ul style="list-style: disc; margin-left: 2rem;">
                            <li class="card-text" style="margin-bottom: 0.5rem;">Specific rankings for any keywords</li>
                            <li class="card-text" style="margin-bottom: 0.5rem;">Exact traffic increases or conversion numbers</li>
                            <li class="card-text" style="margin-bottom: 0.5rem;">Immediate or guaranteed results</li>
                            <li class="card-text" style="margin-bottom: 0.5rem;">Protection against search engine algorithm changes</li>
                        </ul>
                    </div>
                    <p class="card-text">We commit to using best practices and industry-standard methodologies to achieve the best possible results for your business.</p>
                </div>

                <!-- Section 6 -->
                <div class="card" style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">6. Intellectual Property</h2>
                    <div class="grid grid-3" style="margin-top: 1.5rem;">
                        <div style="background-color: var(--color-light); padding: 1.5rem; border-radius: var(--border-radius); text-align: center;">
                            <p style="font-weight: 600; margin-bottom: 0.75rem; color: var(--color-dark);">Your Content</p>
                            <p class="card-text" style="margin: 0;">You retain ownership of all content, data, and materials you provide to us</p>
                        </div>
                        <div style="background-color: var(--color-light); padding: 1.5rem; border-radius: var(--border-radius); text-align: center;">
                            <p style="font-weight: 600; margin-bottom: 0.75rem; color: var(--color-dark);">Deliverables</p>
                            <p class="card-text" style="margin: 0;">Upon full payment, you own the rights to content we create for your business</p>
                        </div>
                        <div style="background-color: var(--color-light); padding: 1.5rem; border-radius: var(--border-radius); text-align: center;">
                            <p style="font-weight: 600; margin-bottom: 0.75rem; color: var(--color-dark);">Our Property</p>
                            <p class="card-text" style="margin: 0;">We retain ownership of our methodologies, processes, and general strategies</p>
                        </div>
                    </div>
                </div>

                <!-- Sections 7-9 in Grid -->
                <div class="grid grid-2" style="margin-bottom: 2rem;">
                    <div class="card">
                        <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem;">7. Confidentiality</h3>
                        <p class="card-text">We will keep confidential any proprietary information you share with us. We will not disclose your business strategies, revenue data, or other sensitive information to third parties without your consent.</p>
                    </div>
                    <div class="card">
                        <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem;">8. Termination</h3>
                        <p class="card-text">Either party may terminate the service agreement after the minimum commitment period with 30 days written notice. Early termination fees may apply as outlined in your service agreement.</p>
                    </div>
                </div>

                <!-- Section 10 -->
                <div class="card" style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">9. Limitation of Liability</h2>
                    <p class="card-text">Boterns shall not be liable for any indirect, incidental, special, consequential, or punitive damages resulting from your use of our services. Our total liability shall not exceed the amount paid by you for services in the three months preceding the claim.</p>
                </div>

                <!-- Section 11 -->
                <div class="card" style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">10. Refund Policy</h2>
                    <p class="card-text" style="margin-bottom: 1rem;">Due to the nature of our services, we generally do not offer refunds once work has commenced. However:</p>
                    <ul style="list-style: disc; margin-left: 2rem;">
                        <li class="card-text" style="margin-bottom: 0.5rem;">If we fail to deliver agreed-upon services, we will work with you to remedy the situation</li>
                        <li class="card-text" style="margin-bottom: 0.5rem;">One-time audits may be eligible for partial refunds if not delivered within the specified timeframe</li>
                        <li class="card-text" style="margin-bottom: 0.5rem;">Refund requests will be evaluated on a case-by-case basis</li>
                    </ul>
                </div>

                <!-- Section 12 - White Hat -->
                <div class="card" style="margin-bottom: 2rem; border-left: 4px solid var(--color-secondary); background-color: #F0FDF4;">
                    <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">11. White-Hat Practices</h2>
                    <p class="card-text" style="font-weight: 600; margin-bottom: 0.5rem;">We commit to using only white-hat, Google-compliant SEO methods.</p>
                    <p class="card-text">We will never engage in tactics that violate search engine guidelines or put your website at risk of penalties. Your long-term success is more important than short-term ranking gains.</p>
                </div>

                <!-- Remaining Sections in Grid -->
                <div class="grid grid-2" style="margin-bottom: 2rem;">
                    <div class="card">
                        <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem;">12. Governing Law</h3>
                        <p class="card-text">These Terms of Service are governed by the laws of the State of Washington, United States. Any disputes will be resolved in the courts located in Seattle, Washington.</p>
                    </div>
                    <div class="card">
                        <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem;">13. Changes to Terms</h3>
                        <p class="card-text">We reserve the right to modify these terms at any time. We will notify active clients of any significant changes. Continued use of our services after changes constitutes acceptance of the new terms.</p>
                    </div>
                </div>

                <!-- Contact Section -->
                <div class="card" style="background-color: var(--color-light);">
                    <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">Questions About These Terms?</h2>
                    <p class="card-text" style="margin-bottom: 1.5rem;">If you have questions about these Terms of Service, we're here to help.</p>
                    <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
                        <div>
                            <p style="font-weight: 600; margin-bottom: 0.5rem; color: var(--color-dark);">Email</p>
                            <a href="mailto:hello@boterns.com" style="color: var(--color-primary); text-decoration: underline;">hello@boterns.com</a>
                        </div>
                        <div>
                            <p style="font-weight: 600; margin-bottom: 0.5rem; color: var(--color-dark);">Phone</p>
                            <a href="tel:+12065551234" style="color: var(--color-primary); text-decoration: underline;">(206) 555-1234</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
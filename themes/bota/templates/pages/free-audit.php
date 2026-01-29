@extends('bota/templates/layout')

@section('main-section')

    <!-- Audit Hero -->
    <section class="hero">
        <div class="container">
            <div class="audit-hero-content">
                <div class="hero-badge">100% Free. No Sales Pitch. Actionable Insights Only.</div>
                <h1 class="hero-title">Get Your SaaS Growth Audit</h1>
                <p class="hero-subtitle">Find out exactly where you're leaving trial signups and revenue on the table—and get a clear 90-day roadmap to fix it.</p>

                <div class="audit-results-preview">
                    <h3 class="audit-results-title">Here's What You'll Get:</h3>
                    <ul class="audit-deliverables">
                        <li class="audit-deliverable-item">
                            <svg class="hero-check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                            <div>
                                <strong>Personalized Video Walkthrough</strong> - I'll record a custom Loom showing quick wins you can implement this week to start seeing results
                            </div>
                        </li>
                        <li class="audit-deliverable-item">
                            <svg class="hero-check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                            <div>
                                <strong>Traffic-to-Revenue Analysis</strong> - See exactly how much potential revenue you're missing from organic search based on your industry benchmarks
                            </div>
                        </li>
                        <li class="audit-deliverable-item">
                            <svg class="hero-check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                            <div>
                                <strong>Content Gap Analysis</strong> - Discover the high-intent keywords your competitors are ranking for that you're completely missing
                            </div>
                        </li>
                        <li class="audit-deliverable-item">
                            <svg class="hero-check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                            <div>
                                <strong>Competitor Acquisition Strategy</strong> - See what's actually driving trial signups for your top 3 competitors and how to outrank them
                            </div>
                        </li>
                        <li class="audit-deliverable-item">
                            <svg class="hero-check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                            <div>
                                <strong>90-Day Organic Growth Roadmap</strong> - Prioritized action plan showing exactly what to tackle first for maximum impact on your customer acquisition
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Audit Form Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="audit-form-wrapper">
                <div class="audit-form-intro">
                    <h2 class="section-title">Tell Me About Your SaaS</h2>
                    <p class="audit-form-description">Fill out this quick form and I'll personally analyze your site. You'll get your custom audit within 2 business days.</p>
                </div>

                <form class="audit-form" id="auditForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name" class="form-label">Your Name *</label>
                            <input type="text" id="name" name="name" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" id="email" name="email" class="form-input" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="company" class="form-label">Company Name *</label>
                            <input type="text" id="company" name="company" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label for="website" class="form-label">Website URL *</label>
                            <input type="url" id="website" name="website" class="form-input" placeholder="https://" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="role" class="form-label">What's Your Role? *</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="">Select your role</option>
                            <option value="founder">Founder / Co-Founder</option>
                            <option value="ceo">CEO / Executive</option>
                            <option value="marketing">Head of Marketing / CMO</option>
                            <option value="growth">Head of Growth</option>
                            <option value="product">Product Manager</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="stage" class="form-label">What Stage Is Your SaaS? *</label>
                        <select id="stage" name="stage" class="form-select" required>
                            <option value="">Select your stage</option>
                            <option value="pre-revenue">Pre-Revenue / Building MVP</option>
                            <option value="early">Early Stage (First Customers)</option>
                            <option value="growing">Growing ($100K - $1M ARR)</option>
                            <option value="scaling">Scaling ($1M - $10M ARR)</option>
                            <option value="established">Established ($10M+ ARR)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="challenge" class="form-label">What's Your Biggest Customer Acquisition Challenge Right Now?</label>
                        <textarea id="challenge" name="challenge" class="form-textarea" rows="4" placeholder="E.g., We get traffic but low trial signups... Our CAC is too high... Competitors outrank us for key terms... etc."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="competitors" class="form-label">Who Are Your Top 3 Competitors? (Optional)</label>
                        <input type="text" id="competitors" name="competitors" class="form-input" placeholder="competitor1.com, competitor2.com, competitor3.com">
                        <p class="form-help">This helps me show you exactly what's working for them</p>
                    </div>

                    <button type="submit" class="btn btn-primary btn-large btn-full">Get My Free SaaS Growth Audit</button>

                    <p class="form-privacy">We respect your privacy. Your information will never be shared with third parties.</p>
                </form>
            </div>
        </div>
    </section>

    <!-- Social Proof -->
    <section class="section">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title">Real Results From Real SaaS Companies</h2>
            </div>
            <div class="grid grid-3">
                <div class="result-card">
                    <div class="result-stat">2X Trial Signups</div>
                    <p class="result-description">Glassix went from 6 to 11 weekly trial signups in 90 days by targeting high-intent keywords we identified in their audit.</p>
                </div>
                <div class="result-card">
                    <div class="result-stat">$100K Revenue</div>
                    <p class="result-description">FileCenter generated $100K in 6 months from organic search after implementing our content strategy roadmap.</p>
                </div>
                <div class="result-card">
                    <div class="result-stat">200% ROI</div>
                    <p class="result-description">$21,500 in revenue from a $10,000 content investment in just 90 days.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="faq-wrapper">
                <h2 class="section-title text-center">Common Questions</h2>
                <div class="faq-grid">
                    <div class="faq-item">
                        <h3 class="faq-question">Is this actually free, or is there a catch?</h3>
                        <p class="faq-answer">It's 100% free. No credit card required, no sales call forced on you. I analyze your site, send you the audit, and you decide if you want to work together. Simple as that.</p>
                    </div>
                    <div class="faq-item">
                        <h3 class="faq-question">How is this different from automated SEO tools?</h3>
                        <p class="faq-answer">Tools like Ahrefs or SEMrush show you data. I show you strategy. You'll get a personalized video from me explaining exactly what's holding you back and what to do about it—based on what's actually working for SaaS companies in your space.</p>
                    </div>
                    <div class="faq-item">
                        <h3 class="faq-question">How long does it take to get my audit?</h3>
                        <p class="faq-answer">You'll receive your custom audit within 2 business days. For complex SaaS platforms, it might take an extra day, but I'll let you know.</p>
                    </div>
                    <div class="faq-item">
                        <h3 class="faq-question">What if I'm just getting started and don't have much traffic yet?</h3>
                        <p class="faq-answer">Perfect. The best time to build your organic acquisition channel is early. I'll show you exactly which keywords to target and what content to create to start generating qualified traffic from day one.</p>
                    </div>
                    <div class="faq-item">
                        <h3 class="faq-question">Will you really send me actionable insights, or just generic advice?</h3>
                        <p class="faq-answer">Every audit is custom. I'll analyze your specific competitors, identify the exact keywords driving their signups, and show you content gaps you're missing. You'll get a prioritized roadmap—not generic "improve your meta tags" nonsense.</p>
                    </div>
                    <div class="faq-item">
                        <h3 class="faq-question">Do I have to hire you after getting the audit?</h3>
                        <p class="faq-answer">Nope. Use the audit to DIY your SEO, hire someone else, or work with us—whatever makes sense for your business. I'm not going to hound you with sales emails.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="section cta-section">
        <div class="container">
            <div class="cta-content text-center">
                <h2 class="cta-title">Ready to See What You're Missing?</h2>
                <p class="cta-text">Get your custom audit and find out exactly how to turn organic search into a predictable customer acquisition channel for your SaaS.</p>
                <a href="#auditForm" class="btn btn-primary btn-large">Get My Free SaaS Growth Audit</a>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    @parent
    <script>
        // Simple form handling - you'll replace this with your actual form processor
        document.getElementById('auditForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Form submitted! In production, this would send to your email/CRM.');
            // Add your form handling logic here (email service, CRM integration, etc.)
        });
    </script>
@endsection

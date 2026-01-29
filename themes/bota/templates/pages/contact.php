@extends('bota/templates/layout')

@section('main-content')

    <!-- Contact Hero -->
    <section class="hero">
        <div class="container">
            <div class="hero-content-center">
                <h1 class="hero-title">Let's Talk About Growing Your SaaS</h1>
                <p class="hero-subtitle">Whether you're ready to get started or just want to chat about your customer acquisition strategy, we're here to help. No sales pitch—just real talk about what's working in SaaS SEO right now.</p>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="audit-form-wrapper">
                <div class="audit-form-intro">
                    <h2 class="section-title">Send Us a Message</h2>
                    <p class="audit-form-description">Fill out the form below and we'll get back to you within 24 hours.</p>
                </div>

                <form class="audit-form" id="contactForm">
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
                            <label for="company" class="form-label">Company Name</label>
                            <input type="text" id="company" name="company" class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="website" class="form-label">Website URL</label>
                            <input type="url" id="website" name="website" class="form-input" placeholder="https://">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="subject" class="form-label">What Can We Help You With? *</label>
                        <select id="subject" name="subject" class="form-select" required>
                            <option value="">Select a topic</option>
                            <option value="audit">I want a free SaaS growth audit</option>
                            <option value="services">I'm interested in your SEO services</option>
                            <option value="question">I have a question about SEO strategy</option>
                            <option value="partnership">Partnership or collaboration inquiry</option>
                            <option value="other">Something else</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message" class="form-label">Your Message *</label>
                        <textarea id="message" name="message" class="form-textarea" rows="6" placeholder="Tell us about your SaaS, what you're trying to achieve, or any questions you have..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-large btn-full">Send Message</button>

                    <p class="form-privacy">We respect your privacy. Your information will never be shared with third parties.</p>
                </form>
            </div>
        </div>
    </section>

    <!-- Alternative Contact Methods -->
    <section class="section">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title">Other Ways to Reach Us</h2>
                <p class="section-subtitle">Prefer to reach out directly? Here are other ways to get in touch.</p>
            </div>
            <div class="grid grid-3">
                <div class="card">
                    <svg class="icon-large card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="card-title">Email Us</h3>
                    <p class="card-text">For general inquiries or support questions.</p>
                    <a href="mailto:hello@boterns.com" class="link-arrow">hello@boterns.com</a>
                </div>
                <div class="card">
                    <svg class="icon-large card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <h3 class="card-title">Call Us</h3>
                    <p class="card-text">Let's have a real conversation about your goals.</p>
                    <a href="tel:+12065551234" class="link-arrow">(206) 555-1234</a>
                </div>
                <div class="card">
                    <svg class="icon-large card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="card-title">Get a Free Audit</h3>
                    <p class="card-text">See exactly where you're leaving revenue on the table.</p>
                    <a href="free-audit.html" class="link-arrow">Request Your Audit</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="faq-wrapper">
                <h2 class="section-title text-center">Common Questions</h2>
                <div class="grid grid-2">
                    <div class="faq-item">
                        <h3 class="faq-question">How quickly will you respond?</h3>
                        <p class="faq-answer">We respond to all inquiries within 24 hours during business days. If you reach out on a weekend, we'll get back to you first thing Monday morning.</p>
                    </div>
                    <div class="faq-item">
                        <h3 class="faq-question">Do you work with companies outside the US?</h3>
                        <p class="faq-answer">Absolutely. While we're based in the US, we work with SaaS companies globally. Time zones have never been an issue—we're flexible with meeting times.</p>
                    </div>
                    <div class="faq-item">
                        <h3 class="faq-question">Will I get a sales call immediately after contacting you?</h3>
                        <p class="faq-answer">No pushy sales calls here. If you're asking a question, we'll answer it. If you want to explore working together, we'll have a real conversation about whether we're a good fit.</p>
                    </div>
                    <div class="faq-item">
                        <h3 class="faq-question">What if I'm not ready to hire an agency yet?</h3>
                        <p class="faq-answer">That's totally fine. Many of our best clients started by asking a few questions, getting a free audit, and then reaching back out when they were ready. No pressure.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section cta-section">
        <div class="container">
            <div class="cta-content text-center">
                <h2 class="cta-title">Want to See What You're Missing First?</h2>
                <p class="cta-text">Get a free SaaS growth audit before reaching out. We'll show you exactly where you're leaving trial signups and revenue on the table.</p>
                <a href="free-audit.html" class="btn btn-primary btn-large">Get Your Free SaaS Growth Audit</a>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    @parent
    <script>
        // Simple form handling
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Form submitted! In production, this would send to your email/CRM.');
            // Add your form handling logic here
        });
    </script>
@endsection

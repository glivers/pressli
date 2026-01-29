@extends('bota/templates/layout')

@section('main-content')

    <!-- Privacy Policy Hero -->
    <section class="section bg-light">
        <div class="container">
            <div class="hero-content-center">
                <h1 class="hero-title" style="color: var(--color-dark);">Privacy Policy</h1>
                <p class="hero-subtitle" style="color: var(--color-gray-600); opacity: 1;">How we collect, use, and protect your information</p>
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
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: var(--color-dark);">The Short Version</h3>
                    <p class="card-text">We don't sell your data. We don't spam you. We collect what we need to provide our services and analyze our website performance. You can request to see or delete your data anytime.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Table of Contents -->
    <section class="section bg-light">
        <div class="container">
            <div style="max-width: 900px; margin: 0 auto;">
                <h2 class="section-title text-center" style="margin-bottom: 2rem;">Contents</h2>
                <div class="grid grid-3">
                    <a href="#section-1" style="text-decoration: none;">
                        <div class="card" style="text-align: center; transition: transform 0.3s;">
                            <p style="font-weight: 600; color: var(--color-primary); margin-bottom: 0.5rem;">1. Information We Collect</p>
                        </div>
                    </a>
                    <a href="#section-2" style="text-decoration: none;">
                        <div class="card" style="text-align: center;">
                            <p style="font-weight: 600; color: var(--color-primary); margin-bottom: 0.5rem;">2. How We Use Your Information</p>
                        </div>
                    </a>
                    <a href="#section-3" style="text-decoration: none;">
                        <div class="card" style="text-align: center;">
                            <p style="font-weight: 600; color: var(--color-primary); margin-bottom: 0.5rem;">3. Information Sharing</p>
                        </div>
                    </a>
                    <a href="#section-4" style="text-decoration: none;">
                        <div class="card" style="text-align: center;">
                            <p style="font-weight: 600; color: var(--color-primary); margin-bottom: 0.5rem;">4. Cookies & Tracking</p>
                        </div>
                    </a>
                    <a href="#section-5" style="text-decoration: none;">
                        <div class="card" style="text-align: center;">
                            <p style="font-weight: 600; color: var(--color-primary); margin-bottom: 0.5rem;">5. Data Security</p>
                        </div>
                    </a>
                    <a href="#section-6" style="text-decoration: none;">
                        <div class="card" style="text-align: center;">
                            <p style="font-weight: 600; color: var(--color-primary); margin-bottom: 0.5rem;">6. Your Rights</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Privacy Policy Sections -->
    <section class="section">
        <div class="container">
            <div style="max-width: 900px; margin: 0 auto;">

                <!-- Section 1 -->
                <div id="section-1" class="card" style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">1. Information We Collect</h2>
                    <p class="card-text" style="margin-bottom: 1rem;">We collect information that you provide directly to us, including:</p>
                    <ul style="list-style: disc; margin-left: 2rem; margin-bottom: 1rem;">
                        <li class="card-text" style="margin-bottom: 0.5rem;">Name, email address, and company information when you fill out forms</li>
                        <li class="card-text" style="margin-bottom: 0.5rem;">Website URL and business details when requesting audits or consultations</li>
                        <li class="card-text" style="margin-bottom: 0.5rem;">Communications when you email us or use our contact forms</li>
                        <li class="card-text" style="margin-bottom: 0.5rem;">Usage data and analytics through cookies and similar technologies</li>
                    </ul>
                </div>

                <!-- Section 2 -->
                <div id="section-2" class="card" style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">2. How We Use Your Information</h2>
                    <p class="card-text" style="margin-bottom: 1rem;">We use the information we collect to:</p>
                    <ul style="list-style: disc; margin-left: 2rem; margin-bottom: 1rem;">
                        <li class="card-text" style="margin-bottom: 0.5rem;">Provide, maintain, and improve our services</li>
                        <li class="card-text" style="margin-bottom: 0.5rem;">Respond to your inquiries and provide customer support</li>
                        <li class="card-text" style="margin-bottom: 0.5rem;">Conduct audits and analysis as requested</li>
                        <li class="card-text" style="margin-bottom: 0.5rem;">Send you marketing communications (with your consent)</li>
                        <li class="card-text" style="margin-bottom: 0.5rem;">Understand how visitors use our website to improve user experience</li>
                    </ul>
                </div>

                <!-- Section 3 -->
                <div id="section-3" class="card" style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">3. Information Sharing</h2>
                    <p class="card-text" style="margin-bottom: 1rem; font-weight: 600;">We do not sell, trade, or rent your personal information to third parties.</p>
                    <p class="card-text" style="margin-bottom: 1rem;">We may share your information only in the following circumstances:</p>
                    <ul style="list-style: disc; margin-left: 2rem; margin-bottom: 1rem;">
                        <li class="card-text" style="margin-bottom: 0.5rem;">With service providers who assist in operating our website and conducting our business</li>
                        <li class="card-text" style="margin-bottom: 0.5rem;">When required by law or to protect our rights</li>
                        <li class="card-text" style="margin-bottom: 0.5rem;">With your explicit consent</li>
                    </ul>
                </div>

                <!-- Section 4 -->
                <div id="section-4" class="card" style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">4. Cookies and Tracking Technologies</h2>
                    <p class="card-text" style="margin-bottom: 1rem;">We use cookies and similar tracking technologies to collect information about your browsing activities. You can control cookies through your browser settings, though disabling cookies may limit your ability to use certain features of our website.</p>
                    <div style="background-color: var(--color-light); padding: 1.5rem; border-radius: var(--border-radius); border-left: 4px solid var(--color-primary); margin-top: 1.5rem;">
                        <p class="card-text" style="margin: 0;"><strong>Note:</strong> Most browsers accept cookies automatically, but you can modify your browser settings to decline cookies if you prefer.</p>
                    </div>
                </div>

                <!-- Section 5 -->
                <div id="section-5" class="card" style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">5. Data Security</h2>
                    <p class="card-text" style="margin-bottom: 1rem;">We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>
                    <p class="card-text">However, no internet transmission is completely secure, and we cannot guarantee absolute security. We encourage you to use caution when transmitting personal information online.</p>
                </div>

                <!-- Section 6 -->
                <div id="section-6" class="card" style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">6. Your Rights</h2>
                    <p class="card-text" style="margin-bottom: 1rem;">You have the right to:</p>
                    <div class="grid grid-2" style="margin-bottom: 1.5rem;">
                        <div style="background-color: var(--color-light); padding: 1.5rem; border-radius: var(--border-radius);">
                            <p style="font-weight: 600; margin-bottom: 0.5rem; color: var(--color-dark);">Access & Correction</p>
                            <p class="card-text" style="margin: 0;">Access, correct, or delete your personal information</p>
                        </div>
                        <div style="background-color: var(--color-light); padding: 1.5rem; border-radius: var(--border-radius);">
                            <p style="font-weight: 600; margin-bottom: 0.5rem; color: var(--color-dark);">Opt-Out</p>
                            <p class="card-text" style="margin: 0;">Unsubscribe from marketing communications</p>
                        </div>
                        <div style="background-color: var(--color-light); padding: 1.5rem; border-radius: var(--border-radius);">
                            <p style="font-weight: 600; margin-bottom: 0.5rem; color: var(--color-dark);">Data Export</p>
                            <p class="card-text" style="margin: 0;">Request a copy of the data we hold about you</p>
                        </div>
                        <div style="background-color: var(--color-light); padding: 1.5rem; border-radius: var(--border-radius);">
                            <p style="font-weight: 600; margin-bottom: 0.5rem; color: var(--color-dark);">Withdraw Consent</p>
                            <p class="card-text" style="margin: 0;">Withdraw consent for data processing where applicable</p>
                        </div>
                    </div>
                    <p class="card-text">To exercise any of these rights, please <a href="contact.html" style="color: var(--color-primary); text-decoration: underline;">contact us</a>.</p>
                </div>

                <!-- Additional Sections in Grid -->
                <div class="grid grid-2" style="margin-bottom: 2rem;">
                    <div class="card">
                        <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem;">Data Retention</h3>
                        <p class="card-text">We retain your personal information for as long as necessary to fulfill the purposes outlined in this privacy policy, unless a longer retention period is required by law.</p>
                    </div>
                    <div class="card">
                        <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem;">Children's Privacy</h3>
                        <p class="card-text">Our services are not directed to individuals under the age of 18. We do not knowingly collect personal information from children.</p>
                    </div>
                </div>

                <!-- Third-Party Links -->
                <div class="card" style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">Third-Party Links</h2>
                    <p class="card-text">Our website may contain links to third-party websites. We are not responsible for the privacy practices of these external sites. We encourage you to review their privacy policies before providing any personal information.</p>
                </div>

                <!-- Changes to Policy -->
                <div class="card" style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">Changes to This Policy</h2>
                    <p class="card-text">We may update this privacy policy from time to time. We will notify you of any changes by posting the new privacy policy on this page and updating the "Last Updated" date at the top.</p>
                </div>

                <!-- Contact Section -->
                <div class="card" style="background-color: var(--color-light);">
                    <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">Questions About This Policy?</h2>
                    <p class="card-text" style="margin-bottom: 1.5rem;">If you have questions about this privacy policy or how we handle your data, we're here to help.</p>
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
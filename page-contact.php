<?php
/**
 * Template Name: Contact Page
 *
 * @package ShopCo
 */

get_header();
?>

<main class="shopco-main">
    <div class="container">
        <div class="page-header">
            <h1 class="page-header__title">Contact Us</h1>
        </div>

        <div class="contact-section">
            <div class="contact-info">
                <h2 style="font-family: var(--font-heading); font-size: 28px; font-weight: 700; margin-bottom: 16px;">
                    Get In Touch
                </h2>
                <p style="color: var(--color-gray-500); margin-bottom: 32px; line-height: 1.6;">
                    We'd love to hear from you. Whether you have a question about products, pricing, or anything else, our team is ready to answer all your questions.
                </p>

                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div style="display: flex; align-items: flex-start; gap: 16px;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <div>
                            <strong>Address</strong><br>
                            <span style="color: var(--color-gray-500);">123 Fashion Street, Style City, SC 12345</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: flex-start; gap: 16px;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/>
                        </svg>
                        <div>
                            <strong>Phone</strong><br>
                            <span style="color: var(--color-gray-500);">+1 (234) 567-890</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: flex-start; gap: 16px;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        <div>
                            <strong>Email</strong><br>
                            <span style="color: var(--color-gray-500);">support@shop.co</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contact-form">
                <form action="#" method="post">
                    <div class="form-group">
                        <label for="contact-name">Full Name</label>
                        <input type="text" id="contact-name" name="name" placeholder="Your full name" required>
                    </div>
                    <div class="form-group">
                        <label for="contact-email">Email Address</label>
                        <input type="email" id="contact-email" name="email" placeholder="your@email.com" required>
                    </div>
                    <div class="form-group">
                        <label for="contact-subject">Subject</label>
                        <input type="text" id="contact-subject" name="subject" placeholder="What is this about?">
                    </div>
                    <div class="form-group">
                        <label for="contact-message">Message</label>
                        <textarea id="contact-message" name="message" placeholder="Write your message..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn--primary">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>

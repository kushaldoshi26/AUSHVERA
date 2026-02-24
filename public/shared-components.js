// Shared Navigation and Footer
document.addEventListener('DOMContentLoaded', function() {
    // Insert Navigation
    const navHTML = `
    <nav class="nav-home">
        <div class="nav-container">
            <div class="nav-left">
                <ul class="nav-links">
                    <li><a href="index.html">HOME</a></li>
                    <li><a href="about.html">ABOUT</a></li>
                    <li><a href="philosophy.html">PHILOSOPHY</a></li>
                </ul>
            </div>
            <a class="nav-center" href="index.html">
                <img src="assets/img/logo.png" alt="AUSHVERA Logo" class="nav-logo">
                <span>AUSHVERA</span>
            </a>
            <div class="nav-right">
                <ul class="nav-links">
                    <li><a href="products.html">PRODUCT</a></li>
                    <li><a href="ritual.html">RITUAL</a></li>
                    <li><a href="contact.html">CONTACT</a></li>
                </ul>
                <a href="chart.html" class="cart-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"/>
                        <circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    <span class="cart-count">0</span>
                </a>
                <a href="profile.html" class="nav-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/>
                    </svg>
                </a>
            </div>
        </div>
    </nav>`;

    // Insert Footer
    const footerHTML = `
    <footer>
        <div class="footer-top">
            <div class="footer-logo">
                <img src="assets/img/logo.png" alt="AUSHVERA">
            </div>
            <p class="footer-tagline">Rooted in heritage. Refined for modern ritual.</p>
            <div class="footer-divider"></div>
        </div>
        <div class="footer-columns">
            <div class="footer-column">
                <h3>About Aushvera</h3>
                <p>A premium Ayurvedic wellness brand honoring ancient botanical wisdom through refined, modern formulations. Each product embodies our commitment to purity, transparency, and timeless elegance.</p>
            </div>
            <div class="footer-column">
                <h3>Explore</h3>
                <ul class="footer-links">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="philosophy.html">Philosophy</a></li>
                    <li><a href="products.html">Product</a></li>
                    <li><a href="ritual.html">Ritual</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Connect</h3>
                <ul class="footer-contact">
                    <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <span>Gurukul Rd, Gandhidham, India, 370201</span>
                    </li>
                    <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        <span>aushveraglobalbiz1718@gmail.com</span>
                    </li>
                </ul>
                <div class="footer-social">
                    <a href="https://www.instagram.com/theaushvera" aria-label="Instagram">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="Facebook">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/in/aushvera-globalbiz-llp-322470380" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/>
                            <rect x="2" y="9" width="4" height="12"/>
                            <circle cx="4" cy="4" r="2"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 AUSHVERA. All rights reserved. | <a href="#" style="color: #C6A75E; text-decoration: none;">Terms & Conditions</a></p>
        </div>
    </footer>`;

    // Insert at beginning of body
    if (document.body.firstChild) {
        document.body.insertAdjacentHTML('afterbegin', navHTML);
    }
    
    // Insert at end of body
    document.body.insertAdjacentHTML('beforeend', footerHTML);
});

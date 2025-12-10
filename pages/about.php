<?php 
include '../includes/db.php'; 
include '../includes/header.php'; 
?>

<section class="about-section">
    <div class="container">
        <div class="about-hero-grid">
            <div class="about-hero-image">
                <img src="../assets/img/about-illustration.png" alt="Musubi ingredients illustration" loading="lazy">
            </div>

            <div class="about-hero-text">
                <h2 style="font-family: 'Feeling Passionate', cursive;">
                    We are RR Musubi
                </h2>
                <p>
                    There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.
                </p>
            </div>
        </div>

        <div class="info-cards-grid">
            <div class="info-card-group">
                <h3 style="font-family: 'Feeling Passionate', cursive;">
                    Contact Us
                </h3>
                <div class="contact-item">
                    <i class="material-icons">location_on</i>
                    <p>22-D Santillan St. Navotas, Manila</p>
                </div>
                <div class="contact-item">
                    <i class="material-icons">phone</i>
                    <p>+63 9127658987</p>
                </div>
                <div class="contact-item">
                    <i class="material-icons">mail</i>
                    <p>rrmusubi@gmail.com</p>
                </div>
            </div>

            <div class="info-card-group">
                <h3 style="font-family: 'Feeling Passionate', cursive;">
                    RR Musubi
                </h3>
                <p class="text-gray-700 leading-relaxed">
                    Necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with
                </p>
                <div class="social-links">
                    <a href="#facebook" class="social-link social-facebook" title="Facebook">
                        <i class="material-icons">public</i> 
                    </a>
                    <a href="#tiktok" class="social-link social-tiktok" title="TikTok">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                        </svg>
                    </a>
                    <a href="#instagram" class="social-link social-instagram" title="Instagram">
                        <i class="material-icons">camera_alt</i> 
                    </a>
                </div>
            </div>

            <div class="info-card-group">
                <h3 style="font-family: 'Feeling Passionate', cursive;">
                    Opening Hours
                </h3>
                <div class="hours-item">
                    <div>
                        <p>Weekdays</p>
                        <p class="text-gray-700">10:00 AM - 6:00 PM</p>
                    </div>
                </div>
                <div class="hours-item">
                    <div>
                        <p>Weekends</p>
                        <p class="text-gray-700">10:00 AM - 4:00 PM</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>
<?php
// Determine the base path for relative links
$rootPath = (basename(dirname($_SERVER['PHP_SELF'])) == 'pages') ? '../' : './';
?>
<footer class="footer-section">
        <div class="container">
            <div class="info-cards-grid">
                <div class="info-card-group">
                    <h3>Contact Us</h3>
                    <div class="contact-item">
                        <i class="material-icons">location_on</i>
                        <p>22-D Santillan St. Navotas, Manila</p>
                    </div>
                    <div class="contact-item">
                        <i class="material-icons">phone</i>
                        <p><a href="tel:+6391276589876">+63 91276589876</a></p>
                    </div>
                    <div class="contact-item">
                        <i class="material-icons">mail</i>
                        <p><a href="mailto:rrmusubi@gmail.com">rrmusubi@gmail.com</a></p>
                    </div>
                </div>

                <div class="info-card-group footer-middle-content">
                    <h3 style="text-align: center;">RR Musubi</h3>
                    <p>
                        Experience the taste of home-made musubi, a perfect blend of sweet, savory, and satisfying flavors. Simple ingredients, extraordinary taste.
                    </p>
                    <div class="social-links">
                        <a href="#facebook" class="social-link" title="Facebook">
                            <i class="material-icons">facebook</i> 
                        </a>
                        <a href="#tiktok" class="social-link" title="TikTok">
                            <i class="material-icons">tiktok</i> </a>
                        <a href="#instagram" class="social-link" title="Instagram">
                            <i class="material-icons">camera_alt</i> 
                        </a>
                    </div>
                </div>

                <div class="info-card-group">
                    <h3>Opening Hours</h3>
                    <div class="hours-item">
                        <p>Weekdays</p>
                        <p>10:00 AM - 6:00 PM</p>
                    </div>
                    <div class="hours-item">
                        <p>Weekends</p>
                        <p>10:00 AM - 4:00 PM</p>
                    </div>
                </div>
            </div>

            <div class="footer-copyright">
                <p>
                    &copy; 2024 RR Musubi. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>

    <script src="<?php echo $rootPath; ?>assets/js/global.js"></script>
</body>
</html>
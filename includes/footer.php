<?php
// Determine the base path for relative links
$rootPath = (basename(dirname($_SERVER['PHP_SELF'])) == 'pages') ? '../' : './';
?>
<footer>
    <div class="container">
        <p>&copy; <?php echo date('Y'); ?> RR Musubi. All rights reserved.</p>
        <p>22-D Santillan St. Navotas, Manila | +63 91276589876 | rrmusubi@gmail.com</p>
    </div>
</footer>

<script src="<?php echo $rootPath; ?>assets/js/global.js"></script>
</body>
</html>
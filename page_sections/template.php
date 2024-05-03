<?php
include 'config/config.php';

session_start();

list($user_id, $username, $access_level) = get_session_data();

if (!$user_id) {
    header('location:login.php');
    exit;
}
?>
<!-- Head tag -->
<?php
include 'page_sections/head.php';
?>

<body>
    <!-- Navbar -->
    <?php
    include 'page_sections/navbar.php';
    ?>
    <div class="container-sm w-75 pb-3" style="min-width: 800px;">
        
    </div>
    <!-- Footer -->
    <?php
    include 'page_sections/footer.php';
    ?>
</body>
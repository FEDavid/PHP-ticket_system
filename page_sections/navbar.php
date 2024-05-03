<?php
if (isset($_POST['logout'])) {
    unset($_SESSION['user_id']);
    session_destroy();
    echo '<script>window.location.href="login.php";</script>';
    exit;
}
?>
<nav class="navbar navbar-expand-lg mb-3 py-0">
    <div class="container-fluid p-0">
    <h2 class="nav-text mx-3 mt-2 mb-3 text-white fw-bold">Tickets</h2>
    <button class="navbar-toggler bg-white me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <?php
    $current_page = basename($_SERVER['REQUEST_URI']);
    if ($current_page != 'login.php') {
        echo '<div class="collapse navbar-collapse text-start ps-lg-0 pt-lg-0 pb-lg-0 p-2" id="navbarTogglerDemo02">';
        echo '<ul class="navbar-nav me-auto mb-2 mb-lg-0"><li class="nav-item">';
        echo '<a class="nav-item btn btn-primary bpBtn" href="main.php">Home</a>';
        echo '</li><li class="nav-item">';
        echo '<a class="nav-item btn btn-primary bpBtn" href="dashboard.php">Dashboard</a>';
        echo '</li><li class="nav-item">';
        echo '<a class="nav-item btn btn-primary bpBtn" href="tickets.php">Tickets</a>';
        echo '</li><li class="nav-item">';
        echo '<a class="nav-item btn btn-primary bpBtn" href="http://localhost/phpmyadmin/" target="blank">Open Database</a>';
        echo '</li></ul>';
        echo '<form class="d-flex mb-2 mb-lg-0 me-0 me-lg-3" role="search" action="" method="post">';
        echo '<input class="h-50 align-self-sm-center form-control me-2" type="number" name="search" placeholder="Search for a ticket by ID">';
        echo '<input class="btn h-50 align-self-sm-center btn-dark py-1" type="submit" value="Search" name="search_submit">';
        echo '</form>';
        echo '<div class="options-container d-flex flex-row justify-content-center">';
        echo '<form class="nav-item" action="profile.php" method="post">';
        echo '<button class="btn btn-secondary rounded-pill me-3 ms-lg-0 px-5 px-lg-3" type="submit" name="profile">' . $username . '</button>';
        echo '</form>';
        echo '<form class="nav-item" action="" method="post">';
        echo '<button class="btn btn-danger rounded-pill ms-3 ms-lg-0 px-5 px-lg-3" type="submit" name="logout">Logout</button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
    }
    ?>
    </div>
</nav>
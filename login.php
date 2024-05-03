<?php

include 'config/config.php';

get_session_status();

session_start();

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    $select = mysqli_query($conn, "SELECT * FROM `users` WHERE username = '$username' AND password = '$password'") or die('query failed');

    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['access_level'] = $row['access_level'];
        header('location:main.php');
    } else {
        $message = 'Incorrect username or password!' . $username . '!' . $password;
    }
}

// Testing password; password123 - davidjones, emilybrown
?>

<?php
    include 'page_sections/head.php';
?>

<body>
    <?php
    include 'page_sections/navbar.php';
    ?>
    <form action="" method="post" enctype="multipart/form-data" id="login_form">
        <h2>Login</h2>
        <?php
            if (isset($message)) {
                if (is_array($message)) {
                    foreach ($message as $msg) {
                        echo '<div class="message">' . $msg . '</div>';
                    }
                } else {
                    echo '<div class="message">' . $message . '</div>';
                }
            }
        ?>

        <input type="username" name="username" placeholder="Enter username" class="box" required>
        <input type="password" name="password" placeholder="Enter password" class="box" required>
        <input type="submit" name="submit" value="Login" class="btn btn-primary">

        <!-- Testing -->
        <p class="testing w-100">User: nrodriguez<br>Password: password123</p>
        
    </form>
    <?php
    include 'page_sections/footer.php';
    ?>
</body>

</html>
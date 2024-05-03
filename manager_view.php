<?php
include 'config/config.php';

session_start();
get_session_status();

list($user_id, $username, $access_level) = get_session_data();

$view_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$user_id) {
    header('location:login.php');
    exit;
}

if ($access_level !== 'manager' && $access_level !== 'owner') {
    header('location:profile.php');
    exit;
}

?>

<?php
include 'page_sections/head.php';
?>

<body>
    <?php include 'page_sections/navbar.php'; ?>
    <div class="manager_container">
        <div class='card mb-3'>
            <div class='card-header bg-primary text-white'>
                <h2 class='fw-semibold'>Manager panel</h2>
            </div>
            <div class='card-body'>
                <table>
                    <?php
                    $sql = "SELECT * FROM users WHERE id = $view_id";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = $row["id"];
                            $username = $row["username"];
                            $access_level = $row["access_level"];

                            echo "<tr><td class='fw-bold pe-3'>User ID:</td><td>$id</td></tr>";
                            echo "<tr><td class='fw-bold pe-3'>Username:</td><td>$username</td></tr>";
                            echo "<tr><td class='fw-bold pe-3'>Access level:</td><td>$access_level</td></tr>";
                        }
                    }
                    ?>
                </table>
            </div>
            <div class='card-footer bg-secondary'></div>
        </div>
        <div class='card mb-3'>
            <div class='card-header bg-primary text-white'>
                <h2 class='fw-semibold'>Assigned tickets</h2>
            </div>
                <?php
                $sql = "SELECT * FROM tickets WHERE assigned_to = $view_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<ul class='list-group list-group-flush'>";

                    while ($row = $result->fetch_assoc()) {
                        $id = $row["id"];
                        $date_logged = $row["date_logged"];
                        $content = $row["content"];
                        
                        echo '<li class="list-group-item p-3 bg-body-secondary">';
                        echo '<div class="card">';
                        echo '<div class="card-header fw-bold"><p class="mb-0">ID: ' . $id . ' - Date logged: ' . $date_logged . '</p></div>';
                        echo '<div class="card-body">';
                        echo '<p class="mb-0">' . $content . '</p>';
                        echo '</div>';
                        echo "<div class='card-footer p-0'>";
                        echo '<div class="options d-flex flex-row justify-content-between align-items-center">';
                        echo "<form action=\"view_ticket.php?id=" . $id . "\" method=\"post\">";
                        echo "<input type=\"hidden\" name=\"id\" value=\"{$id}\">";
                        echo "<input class=\"btn btn-primary no-rounding rounded-bottom\" type=\"submit\" value=\"View ticket\">";
                        echo "</form>";
                        echo "</div>";
                        echo '</div>';
                    }
                } else {
                    echo "<p>No tickets assigned to this user.</p>";
                }
                ?>
            </div>
        </div>
    </div>
    <?php include 'page_sections/footer.php'; ?>
</body>

</html>
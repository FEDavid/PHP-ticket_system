<?php
include 'config/config.php';

session_start();

list($user_id, $username, $access_level) = get_session_data();

if (!$user_id) {
    header('location:login.php');
    exit;
}

if (isset($_POST['unassign_ticket'])) {
    $id = $_POST['id'];
    $sql = "UPDATE tickets SET assigned_to = NULL WHERE id = $id";
    $conn->query($sql);
}

?>

<?php
include 'page_sections/head.php';
?>

<body>
    <?php
    include 'page_sections/navbar.php';
    ?>
    <div class="container-sm w-50" style="min-width: 600px">
        <div class="staff_section card mb-3">
            <div class="card-header class='card-header bg-primary text-white">
                <h2 class="fw-semibold">Your profile</h2>
            </div>
            <div class="card-body">
                <?php
                $sql = "SELECT * FROM users WHERE id = $user_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<p class='mb-1'><span class='fw-bold'>Username:</span>&nbsp;&emsp;" . $row["username"] . "</p>";
                        echo "<p class='mb-0'><span class='fw-bold'>Access level:</span>&nbsp; " . $row["access_level"] . "</p>";
                    }
                }
                ?>
            </div>
        </div>

        <!-- Manager panel -->
        <?php
        if ($access_level == 'manager' || $access_level == 'owner') {
            $sql = "SELECT users.id, users.username, users.access_level, users.first_name, users.surname, COUNT(tickets.id) AS count_tickets
            FROM users
            LEFT JOIN tickets ON users.id = tickets.assigned_to
            WHERE users.reports_to = $user_id
            GROUP BY users.id
            ORDER BY count_tickets DESC";
            $result = $conn->query($sql);

            echo "<div class='card mb-3'><div class='card-header bg-primary text-white'><h2 class='fw-semibold'>Your staff</h2></div>";
            echo "<div class='card-body p-0'>";
            echo "<table class='full_table'>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Full name</th>";
            echo "<th>Username</th>";
            echo "<th>Access level</th>";
            echo "<th># of tickets</th>";
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $username = $row["username"];
                $access_level = $row["access_level"];
                $full_name = $row["first_name"] . " " . $row["surname"];
                $count_tickets = $row["count_tickets"];

                echo "<tr>";
                echo "<form action=\"manager_view.php?id=" . $id . "\" method=\"post\">";
                echo "<input type=\"hidden\" name=\"id\" value=\"{$id}\">";
                echo "<td><input class=\"tbl_btn\" type=\"submit\" value=" . $id . "></td>";
                echo "</form>";
                echo "<td>" . $full_name . "</td>";
                echo "<td>" . $username . "</td>";
                echo "<td>" . $access_level . "</td>";
                echo "<td>" . $count_tickets . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div></div>";
        }
        ?>

        <!-- Viewing assigned tickets -->
        <div class="card mb-3">
            <?php
            $sql = "SELECT * FROM tickets WHERE assigned_to = $user_id";
            $result = $conn->query($sql);

            echo "<div class='card-header bg-primary text-white'><h2 class='fw-semibold'>Your assigned tickets</h2></div>";
            if ($result->num_rows > 0) {
                echo "<ul class='list-group list-group-flush'>";
                while ($row = $result->fetch_assoc()) {
                    $content = $row["content"];
                    $logged_by = $row["logged_by"];
                    $date_logged = date("d/m/Y", strtotime($row["date_logged"]));
                    $id = $row["id"];

                    $sql = "SELECT * FROM users WHERE id = $logged_by";
                    $result_assigned = $conn->query($sql);
                    $row_assigned = $result_assigned->fetch_assoc();
                    $logged_by = $row_assigned["username"];

                    echo '<li class="list-group-item p-3 bg-body-secondary">';
                    echo '<div class="card">';
                    echo '<div class="card-header fw-bold"><p class="mb-0">ID: ' . $id . ' - Logged by: ' . $logged_by . ' - Date logged: ' . $date_logged . '</p></div>';
                    echo '<div class="card-body">';
                    echo '<p class="mb-0">' . $content . '</p>';
                    echo '</div>';
                    echo "<div class='card-footer p-0'>";
                    echo '<div class="options d-flex flex-row justify-content-between">';
                    echo '<form action="view_ticket.php?id=' . $id . '" method="post">';
                    echo '<input type="hidden" name="id" value="' . $id . '">';
                    echo '<button class="btn btn-primary no-rounding rounded-bottom" type="submit" value="View ticket">View ticket</button>';
                    echo '</form>';
                    echo '<form action="" method="post">';
                    echo '<input type="hidden" name="id" value="' . $id . '">';
                    echo '<button class="btn btn-danger no-rounding rounded-bottom" type="submit" value="Unassign ticket" name="unassign_ticket">Unassign ticket</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</li>';
                }
                echo "</ul>";
                echo "</div>";
            } else {
                echo "<p class='card-body pb-0'>You have no tickets assigned to you.</p>";
            }
            ?>

            <!-- Viewing logged tickets -->
            <div class="card mb-3">
                <?php
                // FIX ME, LOGGED TICKETS DON'T HAVE A USER ID
                $sql = "SELECT * FROM tickets WHERE logged_by = $user_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<div class='card-header bg-primary text-white'><h2 class='fw-semibold'>Your logged tickets</h2></div>";
                    echo "<ul class='list-group list-group-flush'>";
                    while ($row = $result->fetch_assoc()) {
                        $content = $row["content"];
                        $date_logged = date("d/m/Y", strtotime($row["date_logged"]));
                        $id = $row["id"];
                        $assigned_to = $row["assigned_to"];

                        $sql = "SELECT * FROM users WHERE id = $assigned_to";
                        $result_assigned = $conn->query($sql);
                        $row_assigned = $result_assigned->fetch_assoc();
                        $assigned_to = $row_assigned["username"];

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
                        echo "<p class='m-0 p-0 pe-2 fw-semibold'>Assigned to: $assigned_to";
                        echo "</div>";
                        echo "</li>";
                    }
                    echo "</ul>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
        <?php
        include 'page_sections/footer.php';
        ?>
</body>

</html>
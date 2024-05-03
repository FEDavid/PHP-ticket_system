<?php
include 'config/config.php';

session_start();

list($user_id, $username, $access_level) = get_session_data();

if (!$user_id) {
    header('location:login.php');
    exit;
}

if (isset($_POST['search_submit'])) {
    search_tickets($conn);
}

// Functions
function view_tickets($conn)
{
    echo '<h2 class="page_header mb-3 text-white">Showing top high priority tickets</h2>';

    $sql = "SELECT * FROM tickets ORDER BY date_logged ASC LIMIT 5";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sql = "SELECT * FROM users WHERE id = " . $row["logged_by"];           
            $result_assigned = $conn->query($sql);
            $row_assigned = $result_assigned->fetch_assoc();
            $logged_by = $row_assigned["username"];


            echo '<div class="card mb-3 text-bg-primary-emphasis">';
            echo '<h4 class="card-header mb-1 text-nowrap bg-body-secondary">Ticket number: ' . $row["id"] . ' / Date Logged: ' . date("d/m/Y", strtotime($row["date_logged"])) . '</h4>';
            echo '<div class="card-body">';
            echo '<p class="mb-0">' . $row["content"] . '</p>';
            echo '</div>';
            echo '<div class="card-footer bg-body-secondary p-0">';
            echo '<div class="options d-flex flex-row justify-content-between align-items-center">';
            echo '<form action="view_ticket.php?id=' . $row["id"] . '" method="post">';
            echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
            echo '<input class="btn btn-primary no-rounding rounded-bottom" type="submit" value="View ticket">';
            echo '</form>';	
            echo '<p class="mb-0 me-2 fw-bold"> Logged by: ' . $logged_by . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
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
        <!-- Errors & Messages -->
        <div class="errors_container">
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
        </div>

        <!-- Tickets container -->
        <div class="tickets_container">
            <?php
            view_tickets($conn);
            ?>
        </div>

    </div>
    <?php
    include 'page_sections/footer.php';
    ?>
</body>

</html>
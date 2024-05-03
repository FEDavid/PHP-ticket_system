<?php
include 'config/config.php';

session_start();

list($user_id, $username, $access_level) = get_session_data();

if (!$user_id) {
    header('location:login.php');
    exit;
}

function ticket_data($conn){

    echo "<h3 class='text-center bg-primary text-white py-2 fw-semibold mb-0'>Ticket data</h3>";
    echo "<table class='table table-striped table-hover text lh-1' style='font-size: 0.9rem'>";
    echo "<thead><tr class='text-center'><th class='border-end'>Ticket number</th><th>Date Logged</th></tr></thead>";

    $sql = "SELECT * FROM tickets";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ticket_id = $row['id'];
            $date_logged = $row['date_logged'];

            echo "<tr class='text-center'><td class='border-end'>$ticket_id</td><td>$date_logged</td></tr>";
        }
    }

    echo "</table>";

}
?>

<?php
include 'page_sections/head.php';
?>

<body>
    <?php
    include 'page_sections/navbar.php';
    ?>
    <div class="container-sm w-75 pb-3" style="min-width: 800px;">
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

        <div class="container-fluid d-flex flex-row dashboard">
                <div class="col-3 p-0"><div class="border bg-light h-100"><?php ticket_data($conn); ?></div></div>
                <div class="col p-0"><div class="border bg-light h-100 d-flex flex-column">
                    <h3 class="text-center bg-primary text-white py-2 fw-semibold mb-0">Dashboard</h3>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="row h-50">
                            <div class="w-50 h-100 border-end border-bottom" id="div1" ondrop="drop(event)" ondragover="allowDrop(event)"><?php include 'graph.php'; ?></div>
                            <div class="w-50 h-100 border-bottom" id="div2" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        </div>
                        <div class="row h-50">
                            <div class="h-100 w-50 border-end" id="div3" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                            <div class="h-100 w-50" id="div4" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                        </div>
                    </div>
                </div></div>
            </div>
        </div>

    </div>
    <?php
    include 'page_sections/footer.php';
    ?>
</body>

</html>
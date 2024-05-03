<?php
include 'config/config.php';

session_start();

list($user_id, $username, $access_level) = get_session_data();

if (!$user_id) {
    header('location:login.php');
    exit;
}

if (isset($_POST['assign_self'])) {
    $ticketID = $_GET['id'];

    $sql = "UPDATE tickets SET assigned_to = $user_id WHERE id = $ticketID";
    if (mysqli_query($conn, $sql)) {
        $message = "Ticket assigned to you.";
    } else {
        $message = "Error assigning ticket.";
    }
}

if(isset($_POST['add_comment'])){
    $ticketID = $_POST['ticketid'];
    $content = $conn->real_escape_string($_POST['content']);
    $author = $username;

    $sql = "INSERT INTO comments (ticketid, content, author) VALUES ($ticketID, '$content', '$author')";
    if (mysqli_query($conn, $sql)) {
        $message = "Comment added.";
    } else {
        $message = "Error adding comment.";
    }
}

if(isset($_POST['delete_comment'])){
    $commentID = $_POST['commentid'];

    $sql = "DELETE FROM comments WHERE id = $commentID";
    if (mysqli_query($conn, $sql)) {
        $message = "Comment deleted.";
    } else {
        $message = "Error deleting comment.";
    }
}

if (isset($_POST['unassign_ticket'])){
    $id = $_POST['id'];
    $sql = "UPDATE tickets SET assigned_to = NULL WHERE id = $id";
    $conn->query($sql);
}

function display_ticket($conn){
    global $access_level;
    global $user_id;
    // Check if the tickets ID is provided in the URL
    if (isset($_GET['id'])) {
        $ticketID = $_GET['id'];
    } else {
        echo "Ticket ID not provided.";
        exit;
    }

    $sql = "SELECT * FROM tickets WHERE id = $ticketID";
    $result = mysqli_query($conn, $sql);

    // Check if the ticket exists
    if (mysqli_num_rows($result) > 0) {
        $ticket = mysqli_fetch_assoc($result);
        echo "<div class='ticket card mb-3'>";
        echo "<div class='card-header '><h3 class='mb-0 fw-semibold'>Ticket ID: " . $ticket["id"] . "</h3></div>";
        echo "<div class='card-body'>";
        echo "<p class='mb-0'>" . $ticket["content"] . "</p>";
        echo "</div>";
        echo "<div class='card-footer p-0 options d-flex flex-row justify-content-between'>";
        if($access_level == 'admin' || $access_level == 'manager' || $access_level == 'owner'){

            if($ticket['assigned_to'] == null){
                echo "<form action='' method='post'>";
                echo "<input class='btn btn-primary no-rounding rounded-bottom' type='submit' name='assign_self' value='Assign to me'>";
                echo "</form>";
            }

            if($ticket['assigned_to'] != null){
                if($ticket['assigned_to'] == $user_id){
                    echo "<button class='btn btn-danger no-rounding rounded-bottom' style='cursor: not-allowed;'>Assigned to: Me</button>";
                    echo '<form action="" method="post">';
                    echo '<input type="hidden" name="id" value="' . $ticket["id"] . '">';
                    echo '<button class="btn btn-danger no-rounding rounded-bottom" type="submit" value="Unassign ticket" name="unassign_ticket">Unassign ticket</button>';
                    echo '</form>';
                } else {
                    echo "<button class='btn btn-danger no-rounding rounded-bottom' style='cursor: not-allowed;'>Assigned to: " . $ticket['assigned_to'] . "</button>";
                }
            }
            
        }
        echo "</div>";
        echo "</div>";
    } else {
        echo "Ticket not found.";
        exit;
    }

    $sql = "SELECT * FROM comments WHERE ticketid = $ticketID";
    $result = mysqli_query($conn, $sql);

    echo "<div class='comments'>";
    echo "<h2>Comments</h2>";
    if (mysqli_num_rows($result) > 0) {
        while ($comment = mysqli_fetch_assoc($result)) {
            echo "<div class='card mb-3'>";
            echo "<div class='card-header'><p class='bold mb-0'>Posted by " . $comment['author'] . " - " . date("d/m/Y", strtotime($comment['date_added'])) . "</p></div>";
            echo "<div class='card-body'>";
            echo "<p class='comment_content'>" . $comment["content"] . "</p>";
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='commentid' value='" . $comment['id'] . "'>";
            echo "</div>";
            echo "<div class='card-footer p-0'>";
            echo "<input type='submit' class='btn btn-danger no-rounding rounded-bottom' value='Delete comment' name='delete_comment'>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>No comments</p>";
    }
    echo "</div>";
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
        <?php
            if (isset($message)) {
                echo '<div class="errors_container">';
                if (is_array($message)) {
                    foreach ($message as $msg) {
                        echo '<div class="message">' . $msg . '</div>';
                    }
                } else {
                    echo '<div class="message">' . $message . '</div>';
                }
                echo '</div>';
            }
        ?>
        <?php
            display_ticket($conn);
        ?>
        <div class="comments_box">
            <form action="" method="post">
                <input type="hidden" name="ticketid" value="<?php echo $_GET['id']; ?>">
                <textarea name="content" placeholder="Add comment" rows="4"></textarea>
                <input class="btn btn-primary no-rounding rounded-bottom" type="submit" value="Add comment" name="add_comment">
            </form>
        </div>
    </div>

    <?php
        include 'page_sections/footer.php';
    ?>
</body>
</html>
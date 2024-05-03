<?php
// Path: config.php
// $conn = mysqli_connect('mysql', 'root', getenv('MYSQL_ROOT_PASSWORD'), getenv('MYSQL_DATABASE')) or die('connection failed');
$conn = mysqli_connect('localhost', 'root', '', 'ticket_system') or die('connection failed');

function get_session_data()
{
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
    $access_level = isset($_SESSION['access_level']) ? $_SESSION['access_level'] : null;

    return array($user_id, $username, $access_level);
}

function get_session_status()
{
    $status = session_status();

    // Convert session status to descriptive text
    $statusText = '';
    switch ($status) {
        case PHP_SESSION_DISABLED:
            $statusText = 'Sessions are disabled';
            break;
        case PHP_SESSION_NONE:
            $statusText = 'No active session';
            break;
        case PHP_SESSION_ACTIVE:
            $statusText = 'Session is active';
            break;
        default:
            $statusText = 'Unknown session status';
            break;
    }

    echo '<script type="text/javascript">console.log("' . $statusText . '")</script>';
}

function search_tickets($conn)
{
    $search = $_POST['search'];
    $sql = "SELECT * FROM tickets WHERE id LIKE '%$search%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the first row and redirect
        $row = $result->fetch_assoc();
        header("Location: view_ticket.php?id=" . $row["id"]);
        exit; // Exit after redirection
    } else {
        // No search results found
        echo "<script>alert('No search results found.');</script>";
    }
}

if (isset($_SESSION['message']) && $_SESSION['message'] !== '') {
    // If there's a message in the session variable, assign it to $message
    $message = $_SESSION['message'];
    // Clear the session variable to prevent displaying the message again
    unset($_SESSION['message']);
}

?>
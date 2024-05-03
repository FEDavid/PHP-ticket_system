<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Test Page</title>
</head>
<body>
    <h1>PHP Test Page</h1>
    <p>This is a basic PHP page to test if PHP is working correctly.</p>
    <?php
    // Output the current PHP version
    echo "<p>PHP version: " . phpversion() . "</p>";
    try {
        // Connect to the MySQL database
        $conn = new mysqli('localhost', 'root', '', 'website');
        // $conn = new mysqli('db5015720478.hosting-data.io ', 'dbu85572', 'phpDBtest', 'dbs12829611');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        echo "<p>Connected successfully to the MySQL database.</p>";
    } catch (Exception $e) {
        echo "<p>Error connecting to the MySQL database: " . $e->getMessage() . "</p>";
    }
    ?>
</body>
</html>

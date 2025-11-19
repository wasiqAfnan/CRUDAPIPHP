<?php
// config.php
// Database connection file

$host = "localhost";   // Host name
$user = "root";        // MySQL username
$pass = "root";            // MySQL password
$db   = "college_db";  // Database name

// Default MySQL port is 3306, But I have customized the port to 3406
// So I have to specify the port number here but if you are using default port then you can skip this line
$port = 3406;

// Establish connection
$conn = mysqli_connect($host, $user, $pass, $db, $port);

// Check connection error
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set character encoding to UTF-8
mysqli_set_charset($conn, "utf8mb4");
?>

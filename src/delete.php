<?php
// delete.php
require '../Config/config.php';

// Get ID from URL parameter
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$message = "";

if ($id) {
    // SQL query with placeholder
    $sql  = "DELETE FROM students WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind ID as integer
        mysqli_stmt_bind_param($stmt, "i", $id);

        // Execute deletion
        if (mysqli_stmt_execute($stmt)) {
            $message = "Record deleted successfully.";
        } else {
            $message = "Deletion failed: " . mysqli_error($conn);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        $message = "Failed to prepare statement: " . mysqli_error($conn);
    }
} else {
    $message = "Invalid request.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Student</title>
    <meta http-equiv="refresh" content="2;url=../index.php">
</head>
<body>
    <p><?= htmlspecialchars($message) ?></p>
    <p>Redirecting to the list...</p>
    <p><a href="../index.php">Click here if you are not redirected</a></p>
</body>
</html>

<?php
// view.php
require '../Config/config.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$sql = "SELECT * FROM students WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row    = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
} else {
    die("Failed to prepare statement: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Student</title>
</head>
<body>
    <h1>Student Details</h1>

    <?php if ($row): ?>
        <p><strong>ID:</strong> <?= htmlspecialchars($row['id']) ?></p>
        <p><strong>Name:</strong> <?= htmlspecialchars($row['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
        <p><strong>Course:</strong> <?= htmlspecialchars($row['course']) ?></p>
        <p><strong>Created At:</strong> <?= htmlspecialchars($row['created_at']) ?></p>
    <?php else: ?>
        <p>Student not found.</p>
    <?php endif; ?>

    <p><a href="../index.php">Back to List</a></p>
</body>
</html>

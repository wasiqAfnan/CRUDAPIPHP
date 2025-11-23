<?php
// edit.php
require '../Config/config.php';

// Get student ID from URL parameter
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Step 1: Fetch existing record
$sql  = "SELECT name, email, course FROM students WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id); // Bind integer parameter
    mysqli_stmt_execute($stmt);
    $result  = mysqli_stmt_get_result($stmt);
    $student = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
} else {
    die("Failed to prepare statement: " . mysqli_error($conn));
}

// If record not found, handle gracefully
if (!$student) {
    die("Student not found.");
}

// Step 2: Handle update form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name   = trim($_POST['name'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $course = trim($_POST['course'] ?? '');

    if (!empty($name) && !empty($email) && !empty($course)) {
        $sql  = "UPDATE students SET name = ?, email = ?, course = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $course, $id);

            if (mysqli_stmt_execute($stmt)) {
                $message = "Record updated successfully.";
                // Refresh $student array with new values
                $student['name']   = $name;
                $student['email']  = $email;
                $student['course'] = $course;
            } else {
                $message = "Update failed: " . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt);
        } else {
            $message = "Failed to prepare statement: " . mysqli_error($conn);
        }
    } else {
        $message = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
</head>
<body>
    <h1>Edit Student</h1>

    <?php if (!empty($message)): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <!-- Update form pre-filled with existing data -->
    <form method="post" action="">
        <label>
            Name:<br>
            <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required>
        </label>
        <br><br>

        <label>
            Email:<br>
            <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required>
        </label>
        <br><br>

        <label>
            Course:<br>
            <input type="text" name="course" value="<?= htmlspecialchars($student['course']) ?>" required>
        </label>
        <br><br>

        <button type="submit">Update</button>
    </form>

    <p><a href="../index.php">Back to List</a></p>
</body>
</html>

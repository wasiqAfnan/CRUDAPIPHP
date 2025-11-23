<?php
// create.php
require '../Config/config.php';

// Check if the form is submitted using POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize input by trimming spaces
    $name   = trim($_POST['name'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $course = trim($_POST['course'] ?? '');

    // Validate: All fields must be filled
    if (!empty($name) && !empty($email) && !empty($course)) {

        // SQL query with placeholders (avoids SQL injection)
        $sql = "INSERT INTO students (name, email, course) VALUES (?, ?, ?)";

        // Prepare the query
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            // Bind parameters: "sss" = three strings
            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $course);

            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                echo "New student record created successfully.";
            } else {
                // If execution fails, show error
                echo "Error: " . mysqli_error($conn);
            }

            // Close statement to free resources
            mysqli_stmt_close($stmt);
        } else {
            echo "Failed to prepare statement: " . mysqli_error($conn);
        }
    } else {
        echo "All fields are required.";
    }
}
?>

<!-- Simple HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Student</title>
</head>
<body>
    <h1>Add New Student</h1>

    <form method="post" action="">
        <input type="text" name="name" placeholder="Full Name" required>
        <br><br>
        <input type="email" name="email" placeholder="Email" required>
        <br><br>
        <input type="text" name="course" placeholder="Course" required>
        <br><br>
        <button type="submit">Add Student</button>
    </form>

    <p><a href="../index.php">Back to List</a></p>
</body>
</html>

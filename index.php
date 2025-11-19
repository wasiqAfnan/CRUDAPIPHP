<?php
// index.php
require './Config/config.php';

// SQL query to fetch all students ordered by latest ID
$sql = "SELECT id, name, email, course, created_at FROM students ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students List</title>
</head>
<body>
    <h1>Students</h1>

    <p><a href="./src/create.php">Add New Student</a></p>

    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <!-- Escape output to prevent XSS -->
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['course']) ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                    <td>
                        <a href="./src/view.php?id=<?=  urlencode($row['id']) ?>">View</a> |
                        <a href="./src/edit.php?id=<?=  urlencode($row['id']) ?>">Edit</a> |
                        <a href="./src/delete.php?id=<?=  urlencode($row['id']) ?>" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No students found.</p>
    <?php endif; ?>
</body>
</html>

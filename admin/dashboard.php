<?php
session_start();
include '../db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT blogs.*, categories.name AS category 
          FROM blogs 
          JOIN categories ON blogs.category_id = categories.id 
          ORDER BY created_at DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h2>Admin Dashboard</h2>

    <a href="add_blog.php" class="btn btn-success mb-3">Add Blog</a>
    <a href="logout.php" class="btn btn-danger mb-3">Logout</a>

    <table class="table table-bordered">
        <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['category']; ?></td>
            <td><?php echo $row['created_at']; ?></td>
            <td>
                <a href="edit_blog.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete_blog.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        <?php } ?>

    </table>

</div>

</body>
</html>
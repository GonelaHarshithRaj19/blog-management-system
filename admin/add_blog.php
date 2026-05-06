<?php
session_start();
include '../db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];

    $query = "INSERT INTO blogs (title, content, category_id) 
              VALUES ('$title', '$content', '$category')";

    $conn->query($query);

    echo "<script>alert('Blog Added');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Add Blog</h2>

    <form method="POST">
        <input type="text" name="title" placeholder="Title" class="form-control mb-2" required>

        <textarea name="content" placeholder="Content" class="form-control mb-2" required></textarea>

        <select name="category" class="form-control mb-2">
            <option value="1">Admit Card</option>
            <option value="2">Result</option>
            <option value="3">Jobs</option>
            <option value="4">News</option>
        </select>

        <button class="btn btn-primary">Add Blog</button>
    </form>
</div>

</body>
</html>
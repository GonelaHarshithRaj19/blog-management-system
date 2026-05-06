<?php
session_start();
include '../db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];

    $query = "UPDATE blogs 
              SET title='$title', content='$content', category_id='$category'
              WHERE id=$id";

    $conn->query($query);

    header("Location: dashboard.php");
}

$query = "SELECT * FROM blogs WHERE id=$id";
$result = $conn->query($query);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Edit Blog</h2>

    <form method="POST">
        <input type="text" name="title" value="<?php echo $row['title']; ?>" class="form-control mb-2">

        <textarea name="content" class="form-control mb-2"><?php echo $row['content']; ?></textarea>

        <select name="category" class="form-control mb-2">
            <option value="1">Admit Card</option>
            <option value="2">Result</option>
            <option value="3">Jobs</option>
            <option value="4">News</option>
        </select>

        <button class="btn btn-primary">Update</button>
    </form>
</div>

</body>
</html>
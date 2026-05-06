<?php
include 'db.php';

$id = intval($_GET['id']);

$query = "SELECT blogs.*, categories.name AS category 
          FROM blogs 
          JOIN categories ON blogs.category_id = categories.id 
          WHERE blogs.id = $id";

$result = $conn->query($query);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $row['title']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1><?php echo $row['title']; ?></h1>
    <p class="text-muted"><?php echo $row['category']; ?></p>
    <p><?php echo $row['content']; ?></p>
    <small><?php echo $row['created_at']; ?></small>
</div>

</body>
</html>
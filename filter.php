<?php
include 'db.php';

$where = [];

if (!empty($_POST['category'])) {
    $where[] = "blogs.category_id = " . intval($_POST['category']);
}

if (!empty($_POST['date'])) {
    $where[] = "DATE(blogs.created_at) = '" . $conn->real_escape_string($_POST['date']) . "'";
}

$query = "SELECT blogs.*, categories.name AS category 
          FROM blogs 
          JOIN categories ON blogs.category_id = categories.id";

if (!empty($where)) {
    $query .= " WHERE " . implode(" AND ", $where);
}

$query .= " ORDER BY blogs.created_at DESC";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>

<div class="col-md-4">
    <div class="card mb-4 shadow">
        <div class="card-body">
            <h5>
                <a href="blog.php?id=<?php echo $row['id']; ?>" style="text-decoration:none;">
                    <?php echo $row['title']; ?>
                </a>
            </h5>
            <p class="text-muted"><?php echo $row['category']; ?></p>
            <p><?php echo substr($row['content'], 0, 80); ?>...</p>
            <small><?php echo $row['created_at']; ?></small>
        </div>
    </div>
</div>

<?php
    }
} else {
    echo "<h4 class='text-center'>No blogs found</h4>";
}
?>
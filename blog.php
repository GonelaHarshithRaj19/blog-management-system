<?php

include 'db.php';

$id = intval($_GET['id']);

$query = "SELECT blogs.*, categories.name AS category
          FROM blogs
          JOIN categories
          ON blogs.category_id = categories.id
          WHERE blogs.id = $id";

$result = $conn->query($query);

$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html>
<head>

    <title>
        <?php echo $row['title']; ?>
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background:#f5f5f5;
        }

        .blog-card{
            border:none;
            border-radius:12px;
            overflow:hidden;
        }

        .blog-image{
            width:100%;
            height:400px;
            object-fit:cover;
        }

        .blog-content{
            line-height:2;
            font-size:18px;
        }

    </style>

</head>

<body>

<div class="container mt-5">

    <!-- BACK BUTTON -->

    <a href="index.php" class="btn btn-dark mb-4">

        ← Back to Blogs

    </a>

    <!-- BLOG CARD -->

    <div class="card blog-card shadow-sm">

        <?php if(!empty($row['image'])) { ?>

            <img src="<?php echo $row['image']; ?>"
                 class="blog-image"
                 alt="Blog Image">

        <?php } ?>

        <div class="card-body p-4">

            <!-- CATEGORY -->

            <span class="badge bg-primary mb-3">

                <?php echo $row['category']; ?>

            </span>

            <!-- TITLE -->

            <h1 class="mb-3">

                <?php echo $row['title']; ?>

            </h1>

            <!-- DATE -->

            <p class="text-muted">

                <?php echo date("F d, Y", strtotime($row['created_at'])); ?>

            </p>

            <hr>

            <!-- CONTENT -->

            <div class="blog-content">

                <?php echo nl2br($row['content']); ?>

            </div>

        </div>

    </div>

</div>

</body>
</html>

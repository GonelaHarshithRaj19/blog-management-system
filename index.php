<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>

    <title>Blog Management System</title>

    <!-- FAVICON -->

    <link rel="icon" href="images/news.jpg">

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{
            background:#f5f5f5;
        }

        .navbar{
            border-radius:12px;
        }

        .card{
            border:none;
            border-radius:12px;
            overflow:hidden;
            transition:all 0.3s ease;
            box-shadow:0 2px 10px rgba(0,0,0,0.08);
        }

        .card:hover{
            transform:translateY(-5px);
        }

        .card img{
            height:170px;
            width:100%;
            object-fit:cover;
        }

        .filters input,
        .filters select{
            height:50px;
            border-radius:10px;
        }

        footer{
            margin-top:60px;
        }

    </style>

</head>

<body>

<div class="container mt-4">

    <!-- NAVBAR -->

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3 mb-4">

        <a class="navbar-brand fw-bold" href="index.php">

            Blog Management System

        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <div class="ms-auto d-flex align-items-center">

                <span class="text-light me-3">

                    Developed by Harshith Raj

                </span>

                <ul class="navbar-nav">

                    <li class="nav-item">

                        <a class="nav-link active" href="index.php">

                            <i class="bi bi-house"></i> Home

                        </a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link" href="admin/login.php">

                            <i class="bi bi-person-lock"></i> Admin Login

                        </a>

                    </li>

                </ul>

            </div>

        </div>

    </nav>

    <!-- TITLE -->

    <h1 class="text-center mb-3 fw-bold">

        All Blogs

    </h1>

    <!-- BLOG COUNT -->

    <?php

    $countQuery = "SELECT COUNT(*) AS total FROM blogs";

    $countResult = $conn->query($countQuery);

    $totalBlogs = $countResult->fetch_assoc()['total'];

    ?>

    <div class="alert alert-primary text-center mb-4">

        Total Blogs Available:
        <strong><?php echo $totalBlogs; ?></strong>

    </div>

    <!-- FILTERS -->

    <div class="row mb-4 filters">

        <div class="col-md-4 mb-2">

            <select id="categoryFilter" class="form-control">

                <option value="">All Categories</option>

                <?php

                $cats = $conn->query("SELECT * FROM categories");

                while($cat = $cats->fetch_assoc()) {

                    echo "<option value='{$cat['id']}'>{$cat['name']}</option>";

                }

                ?>

            </select>

        </div>

        <div class="col-md-4 mb-2">

            <input type="date"
                   id="dateFilter"
                   class="form-control">

        </div>

        <div class="col-md-4 mb-2">

            <input type="text"
                   id="searchFilter"
                   class="form-control"
                   placeholder="Search by title...">

        </div>

    </div>

    <!-- BLOGS -->

    <div class="row" id="blogContainer">

    <?php

    $query = "SELECT blogs.*, categories.name AS category
              FROM blogs
              JOIN categories
              ON blogs.category_id = categories.id
              ORDER BY blogs.created_at DESC";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

    ?>

        <div class="col-md-4">

            <div class="card mb-4 shadow-sm">

                <!-- IMAGE -->

                <?php if(!empty($row['image'])) { ?>

                    <img src="<?php echo $row['image']; ?>"
                         alt="Blog Image">

                <?php } else { ?>

                    <img src="https://via.placeholder.com/600x300"
                         class="card-img-top">

                <?php } ?>

                <div class="card-body">

                    <!-- CATEGORY -->

                    <span class="badge bg-primary mb-2">

                        <?php echo $row['category']; ?>

                    </span>

                    <!-- TITLE -->

                    <h5>

                        <a href="blog.php?id=<?php echo $row['id']; ?>"
                           style="
                                text-decoration:none;
                                color:black;
                           ">

                            <?php echo $row['title']; ?>

                        </a>

                    </h5>

                    <!-- SHORT CONTENT -->

                    <p>

                        <?php echo substr($row['content'], 0, 80); ?>...

                    </p>

                    <!-- DATE -->

                    <small class="text-muted d-block mb-2">

                        <?php echo date("F d, Y", strtotime($row['created_at'])); ?>

                    </small>

                    <!-- BUTTON -->

                    <a href="blog.php?id=<?php echo $row['id']; ?>"
                       class="btn btn-primary btn-sm">

                        Read More

                    </a>

                </div>

            </div>

        </div>

    <?php

        }

    } else {

        echo "

        <div class='text-center mt-5'>

            <h3>No Blogs Found</h3>

            <p class='text-muted'>

                Try changing filters or search.

            </p>

        </div>

        ";

    }

    ?>

    </div>

</div>

<!-- FOOTER -->

<footer class="bg-dark text-white text-center py-3">

    © 2026 Blog Management System | Developed by Harshith Raj

</footer>

<!-- jQuery -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>

$(document).ready(function () {

    function loadBlogs() {

        let category = $("#categoryFilter").val();
        let date = $("#dateFilter").val();
        let search = $("#searchFilter").val();

        // LOADING SPINNER

        $("#blogContainer").html(`

            <div class="text-center mt-5">

                <div class="spinner-border text-primary" role="status">

                    <span class="visually-hidden">

                        Loading...

                    </span>

                </div>

            </div>

        `);

        $.ajax({

            url: "filter.php",

            method: "POST",

            data: {
                category: category,
                date: date,
                search: search
            },

            success: function (response) {

                $("#blogContainer").html(response);

            }

        });

    }

    $("#categoryFilter, #dateFilter").on("change", function () {

        loadBlogs();

    });

    $("#searchFilter").on("keyup", function () {

        loadBlogs();

    });

});

</script>

</body>
</html>

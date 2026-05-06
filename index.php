<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog System</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h1 class="text-center mb-4">All Blogs</h1>

    <!-- FILTERS -->
    <div class="row mb-4">
        <div class="col-md-4">
            <select id="categoryFilter" class="form-control">
                <option value="">All Categories</option>
                <option value="1">Admit Card</option>
                <option value="2">Result</option>
                <option value="3">Jobs</option>
                <option value="4">News</option>
            </select>
        </div>

        <div class="col-md-4">
            <input type="date" id="dateFilter" class="form-control">
        </div>
    </div>

    <!-- BLOGS -->
    <div class="row" id="blogContainer">

    <?php
    $query = "SELECT blogs.*, categories.name AS category 
              FROM blogs 
              JOIN categories ON blogs.category_id = categories.id 
              ORDER BY created_at DESC";

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

    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {

    $("#categoryFilter, #dateFilter").on("change", function () {

        let category = $("#categoryFilter").val();
        let date = $("#dateFilter").val();

        // Loading effect
        $("#blogContainer").html("<h5 class='text-center'>Loading...</h5>");

        $.ajax({
            url: "filter.php",
            method: "POST",
            data: {
                category: category,
                date: date
            },
            success: function (response) {
                $("#blogContainer").html(response);
            }
        });

    });

});
</script>

</body>
</html>
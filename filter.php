<?php

include 'db.php';

$where = [];

$category = $_POST['category'] ?? '';
$date = $_POST['date'] ?? '';
$search = $_POST['search'] ?? '';

/* CATEGORY FILTER */

if (!empty($category)) {

    $where[] = "blogs.category_id = " . intval($category);

}

/* DATE FILTER */

if (!empty($date)) {

    $safeDate = $conn->real_escape_string($date);

    $where[] = "DATE(blogs.created_at) = '$safeDate'";

}

/* SEARCH FILTER */

if (!empty($search)) {

    $safeSearch = $conn->real_escape_string($search);

    $where[] = "blogs.title LIKE '%$safeSearch%'";

}

/* MAIN QUERY */

$query = "SELECT blogs.*, categories.name AS category
          FROM blogs
          JOIN categories
          ON blogs.category_id = categories.id";

/* APPLY CONDITIONS */

if (!empty($where)) {

    $query .= " WHERE " . implode(" AND ", $where);

}

/* SORT */

$query .= " ORDER BY blogs.created_at DESC";

/* RUN QUERY */

$result = $conn->query($query);

/* DISPLAY BLOGS */

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

?>

<div class="col-md-4">

    <div class="card mb-4 shadow-sm"
         style="
            border:none;
            border-radius:12px;
            overflow:hidden;
            transition:all 0.3s ease;
            box-shadow:0 2px 10px rgba(0,0,0,0.08);
         ">

        <!-- IMAGE -->

        <?php if(!empty($row['image'])) { ?>

            <img src="<?php echo $row['image']; ?>"
                 class="card-img-top"
                 alt="Blog Image"
                 style="
                    height:170px;
                    width:100%;
                    object-fit:cover;
                 ">

        <?php } else { ?>

            <img src="https://via.placeholder.com/600x300"
                 class="card-img-top"
                 style="
                    height:170px;
                    width:100%;
                    object-fit:cover;
                 ">

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

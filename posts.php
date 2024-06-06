<?php
if (!isset($_GET["post_id"])) {
    header("location: index.php");
}
$post_id = $_GET["post_id"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search - ChitKit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-light">
    <?php require "partials/navbar.php" ?>

    <div class="container main-container d-flex gap-5 justify-content-center">
        <?php require "partials/sidebar.php";
        $user_id = $_SESSION["user_id"];
        ?>

        <!-- Posts -->
        <div class="posts" style="margin-top: 7rem;">
            <div class="container posts-container mt-4">

                <?php
                $video_file_types = array("mp4", "mkv", "mov", "webm", "avi");

                // fetch post details here =>
                $sql = "SELECT * FROM posts WHERE id = '$post_id'";
                $result = mysqli_query($con, $sql);
                if ($result) {
                    $num = mysqli_num_rows($result);
                    if ($num == 1) {
                        $row = mysqli_fetch_assoc($result);

                        // check if liked by user =>
                        $is_liked = false;
                        $sql = "SELECT COUNT(*) AS num_of_likes FROM likes WHERE post_id = '$post_id' AND user_id = '$user_id'";
                        $liked_data = mysqli_query($con, $sql);
                        if ($liked_data) {
                            $liked_row = mysqli_fetch_assoc($liked_data);
                            if ($liked_row["num_of_likes"] > 0) {
                                $is_liked = true;
                            }
                        }
                        // Fetch likes =>
                        $num_of_likes = 0;
                        $sql = "SELECT COUNT(*) AS num_of_likes FROM likes WHERE post_id = '$post_id'";
                        $like_data = mysqli_query($con, $sql);
                        if ($like_data) {
                            $like_row = mysqli_fetch_assoc($like_data);
                            $num_of_likes = $like_row["num_of_likes"];
                        }

                        // Get file paths =>
                        $file_paths = json_decode($row["file_json_array"], true);

                        $post_user_id = $row["user_id"];
                        $sql = "SELECT id, profile_picture, name, about FROM users WHERE id = '$post_user_id'";
                        $user_data = mysqli_query($con, $sql);
                        if (!$user_data) {
                            header("location: index.php");
                        } else {
                            $user_row = mysqli_fetch_assoc($user_data);
                ?>

                            <div class="post-item">
                                <!-- Delete post if owner => -->
                                <?php
                                if ($row["user_id"] == $user_id) {
                                ?>
                                    <div class="d-flex justify-content-center mb-2">
                                        <button onclick="deletePost(<?php echo $post_id ?>)" class="btn btn-danger w-50">Delete Post</button>
                                    </div>
                                <?php
                                }
                                ?>
                                <!-- Delete post if owner END -->
                                <div class="card mb-3">
                                    <div class="d-flex p-3 mb-0">
                                        <div class="d-flex align-items-center" style="width: 70%;">
                                            <?php
                                            if ($user_row["profile_picture"] == "") { ?>
                                                <img width="60" height="60" class="rounded-circle" src="img/icons/user-icon.png" alt="">
                                            <?php } else { ?>
                                                <img width="60" height="60" class="rounded-circle" src="<?php echo $user_row["profile_picture"] ?>" alt="">
                                            <?php } ?>
                                            <span class="mx-3">
                                                <a href="profile.php?user_id=<?php echo $user_row["id"] ?>" style="text-decoration: none;" class="card-text text-black fw-bold m-0"><?php echo $user_row["name"] ?></a>
                                                <p class="card-text text-secondary m-0"><?php echo $user_row["about"] ?></p>
                                            </span>
                                        </div>
                                        <p class="card-text text-body-secondary"><?php echo $row["post_date"] ?></p>

                                    </div>

                                    <!-- Post images => -->
                                    <?php
                                    $len = count($file_paths);
                                    if ($len == 1) {
                                        $extention = explode(".", $file_paths[0]);
                                        $extention = strtolower(end($extention));
                                        if (in_array($extention, $video_file_types)) { ?>
                                            <video class="mt-3 w-100" controls>
                                                <source src="<?php echo $file_paths[0] ?>" type="
                                                <?php
                                                if ($extention == "mp4") {
                                                    echo "video/mp4";
                                                } elseif ($extention == "mkv") {
                                                    echo "video/mkv";
                                                } elseif ($extention == "mov") {
                                                    echo "video/mov";
                                                } elseif ($extention == "webm") {
                                                    echo "video/webm";
                                                } elseif ($extention == "avi") {
                                                    echo "video/avi";
                                                }
                                                ?>">
                                                Your browser does not support the video tag.
                                            </video>
                                        <?php } ?>
                                        <img class="mt-3" src="<?php echo $file_paths[0] ?>" alt="...">
                                    <?php } elseif ($len > 1) { ?>

                                        <!-- SLIDER => -->
                                        <div id="carouselExample" class="carousel slide">
                                            <div class="carousel-inner">
                                                <?php
                                                foreach ($file_paths as $index => $img) {
                                                    $extention = explode(".", $file_paths[$index]);
                                                    $extention = strtolower(end($extention));
                                                    if (in_array($extention, $video_file_types)) {
                                                ?>
                                                        <div class="carousel-item 
                                                            <?php
                                                            if ($index == 0) {
                                                                echo "active";
                                                            }
                                                            ?>">
                                                            <video class="mt-3 w-100" controls>
                                                                <source src="<?php echo $file_paths[$index] ?>" type="
                                                                <?php
                                                                if ($extention == "mp4") {
                                                                    echo "video/mp4";
                                                                } elseif ($extention == "mkv") {
                                                                    echo "video/mkv";
                                                                } elseif ($extention == "mov") {
                                                                    echo "video/mov";
                                                                } elseif ($extention == "webm") {
                                                                    echo "video/webm";
                                                                } elseif ($extention == "avi") {
                                                                    echo "video/avi";
                                                                }
                                                                ?>">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        </div>
                                                    <?php
                                                    } else {

                                                    ?>
                                                        <div class="carousel-item 
                                                    <?php
                                                        if ($index == 0) {
                                                            echo "active";
                                                        }
                                                    ?>">
                                                            <img src="<?php echo $file_paths[$index] ?>" class="d-block w-100" alt="...">
                                                        </div>
                                                <?php }
                                                } ?>

                                            </div>
                                            <button class="carousel-btn carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-btn carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                        <!-- SLIDER END -->
                                    <?php } ?>
                                    <!-- Post images end -->

                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row["heading"] ?></h5>
                                        <p class="card-text"><?php echo $row["content"] ?></p>
                                    </div>

                                    <div class="post-actions d-flex justify-content-around my-4">
                                        <button onclick="
                                        <?php
                                        if ($is_liked) { ?>
                                          unlike(this, <?php echo $user_id ?>, <?php echo $post_id; ?>);
                                        <?php
                                        } else { ?>
                                          like(this, <?php echo $user_id ?>, <?php echo $post_id; ?>);
                                        <?php } ?>" class="mx-1 d-flex align-items-center bg-transparent border-0"><img width="25" height="25" class="mx-2" src="
                                        <?php
                                        if ($is_liked) {
                                            echo "img/icons/liked-icon.png";
                                        } else {
                                            echo "img/icons/like-icon.png";
                                        } ?>
                                        " alt="">
                                            <p style="margin: 0;">
                                                <?php
                                                if ($num_of_likes > 0) {
                                                    echo $num_of_likes;
                                                }
                                                ?>
                                            </p>
                                        </button>
                                        <?php
                                        // Get post link =>
                                        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
                                        $post_url = $protocol . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "?post_id=" . $row["id"];
                                        ?>
                                        <button onclick="copyToClipboard('<?php echo $post_url ?>')" class="bg-transparent border-0"><img width="25" height="25" class="mx-2" src="img/icons/share-icon.png" alt=""></button>
                                        <button class="mx-1 bg-transparent border-0"><img width="25" height="25" class="mx-2" src="img/icons/comment-icon.png" alt=""></button>
                                        <button class="mx-1 bg-transparent border-0"><img width="25" height="25" class="mx-2" src="img/icons/view-icon.png" alt=""></button>
                                    </div>
                                </div>
                            </div>

                <?php

                        } // user data else

                    } else {
                        echo "No post found";
                    }
                } else {
                    echo "An error occured while fetching post";
                }
                ?>

                <div class="post-item">
                    <!-- Comments section => -->

                    <!-- Add comment Form => -->
                    <form action="api/comment.php" method="post" class="mb-4 d-flex flex-column align-items-center">
                        <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
                        <input type="hidden" name="post_id" value="<?php echo $post_id ?>">
                        <div class="form-floating mt-1">
                            <textarea name="comment" required style="height: auto;" class="form-control" rows="3" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                            <label for="floatingTextarea">Add your comment</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-50 mt-3">Comment</button>
                    </form>
                    <!-- Add comment Form END -->

                    <!-- comment list => -->

                    <!-- Fetch comments here => -->

                    <?php
                    $sql = "SELECT * FROM comments WHERE post_id = '$post_id' ORDER BY date DESC";
                    $result = mysqli_query($con, $sql);

                    if ($result) {
                        $num = mysqli_num_rows($result);
                        if ($num == 0) { ?>
                            <div class="card mb-5">
                                <div class="card-body">
                                    <p class="card-text text-center">This post has no comments yet!</p>
                                </div>
                            </div>
                        <?php } else {
                        ?>
                            <div class="card mb-2">
                                <div href="profile.php?user_id=<?php echo $row["user_id"] ?>" class="card-header text-end">
                                    Total <?php echo $num;
                                            if ($num == 1) {
                                                echo " comment";
                                            } else {
                                                echo " comments";
                                            }
                                            ?>
                                </div>
                            </div>
                        <?php
                        }
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <div class="card mb-2">
                                <a style="text-decoration: none;" href="profile.php?user_id=<?php echo $row["user_id"] ?>" class="card-header">
                                    By <b><?php echo $row["user_name"] ?></b> on <?php echo $row["date"] ?>
                                </a>
                                <div class="card-body">
                                    <p class="card-text"><?php echo $row["comment"] ?></p>
                                </div>
                            </div>
                    <?php }
                    }
                    ?>
                    <!-- comment list end -->
                </div>

            </div>

        </div>
        <!-- Posts end -->
        <div class="space space-2" style="width: 18rem;"></div>
    </div>

    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
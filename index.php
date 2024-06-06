<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ChitKit</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-light">
  <?php require "partials/navbar.php" ?>

  <div class="container main-container d-flex gap-5 justify-content-center">
    <?php require "partials/sidebar.php" ?>
    <?php
    $user_id = $_SESSION["user_id"];
    ?>
    <!-- Posts -->
    <div class="posts" style="margin-top: 90px;">

      <div class="container posts-container mt-4">

        <?php
        // Fetch posts =>
        $video_file_types = array("mp4", "mkv", "mov", "webm", "avi");
        $posts_array = [];

        $sql = "SELECT * FROM posts ORDER BY post_date DESC";
        $result = mysqli_query($con, $sql);

        if ($result) {
          while ($row = mysqli_fetch_assoc($result)) {
            $post_user_id = $row["user_id"];
            $sql = "SELECT id, profile_picture, name, about FROM users WHERE id = '$post_user_id'";
            $user_data = mysqli_query($con, $sql);
            if ($user_data) {
              $user_row = mysqli_fetch_assoc($user_data);
              $file_paths = json_decode($row["file_json_array"], true);

              // Fetch likes =>
              $current_post_id = $row["id"];
              $num_of_likes = 0;
              $sql = "SELECT COUNT(*) AS num_of_likes FROM likes WHERE post_id = '$current_post_id'";
              $like_data = mysqli_query($con, $sql);
              if ($like_data) {
                $like_row = mysqli_fetch_assoc($like_data);
                $num_of_likes = $like_row["num_of_likes"];
              }

              // Check if the current user has liked the post =>
              $is_liked = false;
              $sql = "SELECT COUNT(*) AS num_of_likes FROM likes WHERE post_id = '$current_post_id' AND user_id = '$user_id'";
              $liked_data = mysqli_query($con, $sql);
              if ($liked_data) {
                $liked_row = mysqli_fetch_assoc($liked_data);
                if ($liked_row["num_of_likes"] > 0) {
                  $is_liked = true;
                }
              }

              if ($file_paths) {
                // if json decoded data
                array_push($posts_array, [
                  "user" => ["id" => $user_row["id"], "name" => $user_row["name"], "profile_picture" => $user_row["profile_picture"], "about" => $user_row["about"]],
                  "id" => $current_post_id,
                  "heading" => $row["heading"],
                  "content" => $row["content"],
                  "file_paths" => $file_paths,
                  "date" => $row["post_date"],
                  "likes" => $num_of_likes,
                  "is_liked" => $is_liked
                ]);
              } else {
                array_push($posts_array, [
                  "user" => ["id" => $user_row["id"], "name" => $user_row["name"], "profile_picture" => $user_row["profile_picture"], "about" => $user_row["about"]],
                  "id" => $current_post_id,
                  "heading" => $row["heading"],
                  "content" => $row["content"],
                  "file_paths" => [],
                  "date" => $row["post_date"],
                  "likes" => $num_of_likes,
                  "is_liked" => $is_liked
                ]);
              }
            } // user sql condition

          } // while loop
        } else {
        ?>
          <div id="this"><?php echo mysqli_error($con); ?></div>
          <script>
            // setTimeout(() => {

            //   let err = document.getElementById("this").innerHTML;
            //   alert(err)
            alert("An error occured while fetching posts!")
            // }, 1000);
          </script>
        <?php
        }
        ?>


        <?php
        // Show posts here =>

        $carousel_index = 0;
        foreach ($posts_array as $key => $value) {
          $carousel_index++;
        ?>
          <div class="post-item">
            <div class="card mb-3">

              <div class="d-flex p-3 mb-0">
                <div class="d-flex align-items-center" style="width: 70%;">
                  <?php
                  if ($posts_array[$key]["user"]["profile_picture"] == "") { ?>
                    <img width="60" height="60" class="rounded-circle" src="img/icons/user-icon.png" alt="profile image">
                  <?php } else { ?>
                    <img width="60" height="60" class="rounded-circle" src="<?php echo $posts_array[$key]["user"]["profile_picture"] ?>" alt="profile image">
                  <?php } ?>
                  <span class="mx-3">
                    <a href="profile.php?user_id=<?php echo $posts_array[$key]['user']['id'] ?>" style="text-decoration: none;" class="card-text text-black fw-bold m-0"><?php echo $posts_array[$key]["user"]["name"] ?></a>
                    <p class="card-text text-secondary m-0"><?php echo $posts_array[$key]["user"]["about"] ?></p>
                  </span>
                </div>
                <p class="card-text text-body-secondary"><?php echo $posts_array[$key]["date"] ?></p>

              </div>
              <?php
              $len = count($posts_array[$key]["file_paths"]);
              if ($len == 1) {
                $extention = explode(".", $posts_array[$key]["file_paths"][0]);
                $extention = strtolower(end($extention));
                if (in_array($extention, $video_file_types)) {
              ?>
                  <video class="mt-3" controls>
                    <source src="<?php echo $posts_array[$key]["file_paths"][0] ?>" type="
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
                <?php
                } else {
                ?>
                  <img class="mt-3" src="<?php echo $posts_array[$key]["file_paths"][0] ?>" alt="...">
                <?php
                }
                ?>
              <?php } elseif ($len > 1) { ?>

                <!-- SLIDER => -->
                <div id="carousel<?php echo $carousel_index ?>" class="carousel slide">
                  <div class="carousel-inner">
                    <?php
                    foreach ($posts_array[$key]["file_paths"] as $index => $img) {
                      $extention = explode(".", $posts_array[$key]["file_paths"][$index]);
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
                            <!-- "mp4", "mkv", "mov", "webm", "avi" -->
                            <source src="<?php echo $posts_array[$key]["file_paths"][$index] ?>" type="
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

                      <?php } else {
                      ?>
                        <div class="carousel-item 
                      <?php
                        if ($index == 0) {
                          echo "active";
                        }
                      ?>">
                          <img src="<?php echo $posts_array[$key]["file_paths"][$index] ?>" class="d-block w-100" alt="...">
                        </div>
                    <?php
                      }
                    } ?>

                  </div>
                  <button class="carousel-btn carousel-control-prev" type="button" data-bs-target="#carousel<?php echo $carousel_index ?>" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-btn carousel-control-next" type="button" data-bs-target="#carousel<?php echo $carousel_index ?>" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
                </div>
                <!-- SLIDER END -->
              <?php } ?>

              <?php
              if ($posts_array[$key]["heading"] != "" || $posts_array[$key]["content"] != "") { ?>
                <div class="card-body">
                  <h5 class="card-title">
                    <?php echo substr($posts_array[$key]["heading"], 0, 50);
                    if ($posts_array[$key]["heading"] != "" && strlen($posts_array[$key]["heading"]) > 50) {
                      echo "...";
                    } ?></h5>
                  <p class="card-text">
                    <?php echo substr($posts_array[$key]["content"], 0, 250);
                    if ($posts_array[$key]["content"] != "" && strlen($posts_array[$key]["content"]) > 250) {
                      echo "...";
                    }
                    ?></p>
                </div>
              <?php } ?>

              <div class="post-actions d-flex justify-content-around my-4">
                <button onclick="
                <?php
                if ($posts_array[$key]['is_liked']) { ?>
                  unlike(this, <?php echo $user_id ?>, <?php echo $posts_array[$key]['id']; ?>);
                <?php
                } else { ?>
                  like(this, <?php echo $user_id ?>, <?php echo $posts_array[$key]['id']; ?>);
                <?php } ?>" class="mx-1 d-flex align-items-center bg-transparent border-0" value="<?php echo $posts_array[$key]["likes"] ?>"><img width="25" height="25" class="mx-2" src="
                <?php
                if ($posts_array[$key]['is_liked']) {
                  echo "img/icons/liked-icon.png";
                } else {
                  echo "img/icons/like-icon.png";
                } ?>
                " alt="">
                  <p style="margin: 0;">
                    <?php
                    if ($posts_array[$key]["likes"] > 0) {
                      echo $posts_array[$key]["likes"];
                    }
                    ?>
                  </p>
                </button>
                <?php
                // Get post link =>
                $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
                $post_url = $protocol . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "?post_id=" . $posts_array[$key]["id"];
                ?>
                <button onclick="copyToClipboard('<?php echo $post_url ?>')" class="bg-transparent border-0"><img width="25" height="25" class="mx-2" src="img/icons/share-icon.png" alt=""></button>
                <a href="posts.php?post_id=<?php echo $posts_array[$key]['id']; ?>" style="text-decoration: none; color: black" class="mx-1 bg-transparent border-0"><img width="25" height="25" class="mx-2" src="img/icons/comment-icon.png" alt=""></a>
                <a href="posts.php?post_id=<?php echo $posts_array[$key]['id']; ?>" style="text-decoration: none; color: black" class="mx-1 bg-transparent border-0"><img width="25" height="25" class="mx-2" src="img/icons/view-icon.png" alt=""></a>
              </div>
            </div>
          </div>
        <?php } ?>

      </div>

    </div>
    <!-- Posts end -->

    <div class="space space-2" style="width: 18rem;"></div>
  </div>

  <script src="js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<?php require "./partials/helper.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile - ChitKit</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-light">
  <?php require "partials/navbar.php" ?>

  <?php
  // Update profile =>
  // Variable for showing errors
  $type_err = false;
  $show_photo_err = false;
  $size_err = false;

  $user_id = $_SESSION["user_id"];
  $update_success = false;
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $file_path = "";

    if (isset($_FILES["update-profile-picture"]) && !empty($_FILES["update-profile-picture"]["tmp_name"])) {

      // Update Photo =>
      $photo = $_FILES["update-profile-picture"];
      $photo_name = $photo["name"];
      $photo_tmp_name = $photo["tmp_name"];
      $photo_size = $photo["size"];
      $photo_err = $photo["error"];
      $photo_type = $photo["type"];

      $allowed_file_types = array("jpeg", "jpg", "png");
      $photo_ex = explode(".", $photo_name);
      $photo_ext = strtolower(end($photo_ex));

      if (!in_array($photo_ext, $allowed_file_types)) {
        $type_err = true;
      } elseif ($photo_err != 0) {
        $show_photo_err = true;
      } elseif ($photo_size > 5242880) {
        // 5242880: 5mb
        $size_err = true;
      } else {
        $uniqueId = uniqid('', true);
        $new_file_name = $user_id . "-" . $uniqueId . '.' . $photo_ext;

        $file_path = "uploads/profile/" . $new_file_name;
        $move_file = move_uploaded_file($photo_tmp_name, $file_path);
        if (!$move_file) {
          $show_photo_err = true;
        } else {
          // Delete previous photo if exists =>
          $sql = "SELECT profile_picture FROM users WHERE `id` = $user_id";
          $result = mysqli_query($con, $sql);
          if ($result) {
            $row = mysqli_fetch_assoc($result);
            $previous_file_path = $row["profile_picture"];

            if (file_exists($previous_file_path) && $previous_file_path != "") {
              unlink($previous_file_path);
            }
          }
        }

      }
    } // isset curly bracket

    $help = new Helper();
    $name = $help->test_input($_POST["update-name"]);
    $about = $help->test_input($_POST["update-about"]);
    $sql = "UPDATE `users` SET `name` = '$name', `about` = '$about', `profile_picture` = '$file_path' WHERE `users`.`id` = '$user_id'";
    if ($file_path == "") {
      $sql = "UPDATE `users` SET `name` = '$name', `about` = '$about' WHERE `users`.`id` = '$user_id'";
    }
    $result = mysqli_query($con, $sql);
    if (!$result) { ?>
      <script>
        alert("Internal server error!");
      </script>
  <?php
    }
  } ?>

  <?php

  $user_array = array("name" => "", "about" => "", "profile_picture" => "");
  $current_user_id = $user_id;
  if (isset($_GET["user_id"]) && !empty($_GET["user_id"])) {
    $current_user_id = $_GET["user_id"];
  }
  // Fetch user details =>

  $sql = "SELECT name, about, profile_picture FROM users WHERE `id` = '$current_user_id'";
  $result = mysqli_query($con, $sql);
  if (!$result) {
  ?>
    <script>
      alert("Internal server error while fetching your details!");
    </script>
  <?php
  } else {
    $row = mysqli_fetch_assoc($result);
    $user_array["name"] = $row["name"];
    $user_array["about"] = $row["about"];
    $user_array["profile_picture"] = $row["profile_picture"];
  }
  ?>

  <?php
  // Fetch user posts

  $media_posts = [];
  $note_posts = [];

  $sql = "SELECT * FROM posts WHERE user_id = '$current_user_id'";
  $result = mysqli_query($con, $sql);

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      $file_paths = json_decode($row["file_json_array"], true); // true tells to php to decode as associative array.
      if (json_last_error() === JSON_ERROR_NONE) {
        $length = count($file_paths);
        if ($length > 0) {
          array_push($media_posts, ["id" => $row["id"], "heading" => $row["heading"], "content" => $row["content"], "file_paths" => $file_paths]);
        } else {
          array_push($note_posts, ["id" => $row["id"], "heading" => $row["heading"], "content" => $row["content"]]);
        }
      }
    }
  } else {
  ?> <script>
      console.log("An error occured while fetching user posts")
    </script>
  <?php } ?>

  <!-- MODAL => -->
  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editModalLabel">Edit Profile</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" enctype="multipart/form-data">
            <div class="input-group flex-nowrap mb-3">
              <span class="input-group-text" id="addon-wrapping">Name</span>
              <input name="update-name" value="<?php echo $user_array['name'] ?>" type="text" class="form-control" placeholder="Name" aria-label="Name" aria-describedby="addon-wrapping">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text">About</span>
              <textarea name="update-about" class="form-control" aria-label="With textarea"><?php echo $user_array['about'] ?></textarea>
            </div>
            <div class="input-group mb-3">
              <input accept="image/*" name="update-profile-picture" type="file" class="form-control" id="inputGroupFile02">
              <label class="input-group-text" for="inputGroupFile02">Photo</label>
            </div>
            <button type="submit" class="btn btn-primary rounded-0 w-100 mt-3">Update</button>
          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- MODAL END -->

  <div class="container main-container d-flex gap-5 justify-content-center">

    <?php require "partials/sidebar.php" ?>

    <!-- Posts -->
    <div class="posts" style="margin-top: 90px;">

      <section class="h-100 gradient-custom-2">
        <div class="container py-5 h-100">
          <div id="profile-sub-container" class="row d-flex justify-content-center">
            <div class="col col-lg-9 col-xl-8">
              <div class="card">
                <div class="rounded-top text-white d-flex flex-row flex-wrap" style="background-color: #000; height:200px;">
                  <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
                    <?php
                    if ($user_array["profile_picture"] == "") { ?>
                      <img src="img/icons/user-icon.png" alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2" style="width: 150px; z-index: 1">
                    <?php } else { ?>
                      <img src="<?php echo $user_array["profile_picture"] ?>" alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2" style="width: 150px; z-index: 1">
                    <?php } ?>
                  </div>
                  <div class="ms-3" style="margin-top: 80px;">
                    <h5><?php echo $user_array['name'] ?></h5>
                    <?php
                    if (isset($_GET["user_id"]) && !empty($_GET["user_id"])) {
                      // Check if already followed =>
                      $sql = "SELECT COUNT(*) AS follower_num FROM followers WHERE user_id = '$current_user_id' AND follower_id = '$user_id'";
                      $result = mysqli_query($con, $sql);
                      $followed = false;
                      if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        $num = $row["follower_num"];
                        if ($num > 0) {
                          $followed = true;
                        }
                      }

                      if ($followed) {
                    ?>
                        <button onclick="unfollow(<?php echo $user_id ?>, <?php echo $current_user_id ?>)" type="button" data-mdb-button-init data-mdb-ripple-init class="btn follow-btn btn-outline-light text-light" data-mdb-ripple-color="dark" style="z-index: 1;">
                          Unfollow
                        </button>
                      <?php
                      } else {
                      ?>
                        <button onclick="follow(<?php echo $user_id ?>, <?php echo $current_user_id ?>)" type="button" data-mdb-button-init data-mdb-ripple-init class="btn follow-btn btn-outline-light text-light" data-mdb-ripple-color="dark" style="z-index: 1;">
                          Follow
                        </button>
                      <?php
                      }
                    } else { ?>
                      <button type="button" data-bs-toggle="modal" data-bs-target="#editModal" data-mdb-button-init data-mdb-ripple-init class="btn follow-btn btn-outline-light text-light" data-mdb-ripple-color="dark" style="z-index: 1;">
                        Edit
                      </button>
                    <?php
                    }
                    ?>
                  </div>
                </div>
                <div class="p-4 text-black bg-body-tertiary">
                  <div class="d-flex justify-content-end text-center py-1 text-body">
                    <div>
                      <?php
                      // Fetch no of uploaded posts =>
                      $sql = "SELECT COUNT(*) AS num_of_posts FROM posts WHERE user_id  = '$current_user_id'";
                      $result = mysqli_query($con, $sql);

                      $num_of_posts = 0;
                      if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        $num_of_posts = $row["num_of_posts"];
                      }
                      ?>
                      <p class="mb-1 h5"><?php echo $num_of_posts ?></p>
                      <p class="small text-muted mb-0">Posts</p>
                    </div>
                    <div class="px-3">
                      <?php
                      // Fetch no of followers =>
                      $sql = "SELECT COUNT(*) AS num_of_followers FROM followers WHERE user_id = '$current_user_id'";
                      $result = mysqli_query($con, $sql);

                      $num_of_followers = 0;
                      if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        $num_of_followers = $row["num_of_followers"];
                      }
                      ?>
                      <p class="mb-1 h5"><?php echo $num_of_followers ?></p>
                      <p class="small text-muted mb-0">Followers</p>
                    </div>
                    <div>
                      <?php
                      // Fetch no of following =>
                      $sql = "SELECT COUNT(*) AS num_of_following FROM followers WHERE follower_id = '$current_user_id'";
                      $result = mysqli_query($con, $sql);

                      $num_of_following = 0;
                      if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        $num_of_following = $row["num_of_following"];
                      }
                      ?>
                      <p class="mb-1 h5"><?php echo $num_of_following ?></p>
                      <p class="small text-muted mb-0">Following</p>
                    </div>
                  </div>
                </div>
                <div class="card-body p-4 text-black">
                  <div class="mb-5  text-body">
                    <p class="lead fw-normal mb-1">About</p>
                    <div class="p-4 bg-body-tertiary">
                      <p class="font-italic mb-1 about-container"><?php echo $user_array['about'] ?></p>
                    </div>
                  </div>
                  <div class="d-flex justify-content-between align-items-center mb-4 text-body">
                    <p class="lead fw-normal mb-0">Recent Posts</p>
                  </div>
                  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Media</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Notes</button>
                    </li>
                  </ul>
                  <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                      <!-- Media -->
                      <div class="d-flex flex-wrap gap-2">
                        <?php
                        foreach ($media_posts as $key => $value) {
                          if (isset($media_posts[$key]["file_paths"][0])) { ?>
                            <a href="posts.php?post_id=<?php echo $media_posts[$key]["id"] ?>" class="w-48">
                              <img src="<?php echo $media_posts[$key]["file_paths"][0] ?>" alt="post image" class="w-100 rounded-1">
                            </a>
                        <?php }
                        } ?>
                      </div>

                      <!-- Media ends -->
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                      <!-- Notes -->
                      <div class="flex justify-content-center">

                        <?php
                        foreach ($note_posts as $key => $value) { ?>
                          <script>
                            console.log("what is this")
                          </script>
                          <div class="card my-2 profile-note-card">
                            <div class="card-body">
                              <?php
                              if (!empty($note_posts[$key]["heading"])) { ?>
                                <h6 class="card-subtitle mb-2 text-body-secondary"><?php echo substr($note_posts[$key]["heading"], 0, 40) . "..." ?></h6>
                              <?php } ?>
                              <?php
                              if (!empty($note_posts[$key]["content"])) { ?>
                                <p class="card-text"><?php echo substr($note_posts[$key]["content"], 0, 100) . "..." ?></p>
                              <?php } ?>
                              <a href="posts.php?post_id=<?php echo $note_posts[$key]["id"] ?>" class="card-link">Read more &rarr;</a>
                            </div>
                          </div>
                        <?php } ?>

                      </div>
                      <!-- Notes end -->
                    </div>
                  </div>


                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

    </div>
    <!-- Posts end -->

    <div class="space space-2" style="width: 18rem;"></div>
  </div>

  <?php
  if ($type_err) {
  ?>
    <script>
      alert("Photo can only be of type: jpeg, jpg or png.")
    </script>
  <?php
  }
  if ($show_photo_err) {
  ?>
    <script>
      alert("There was an error while updating your profile picture.")
    </script>
  <?php
  }
  if ($size_err) {
  ?>
    <script>
      alert("Photo size should be less than 5mb.")
    </script>
  <?php
  }
  ?>

  <script src="js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
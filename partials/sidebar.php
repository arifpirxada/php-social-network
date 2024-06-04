<!-- Sidebar => -->
<div class="sidebar-container">

  <div class="sidebar shadow-sm position-fixed rounded p-4 list-unstyled d-flex flex-column bg-white">
    <a href="index.php" class="p-3 flex align-items-center"><img width="30" height="30" src="./img/icons/home-icon.png" alt="home icon"><span class="m-2">Home</span></a>
    <a href="search.php" class="p-3 flex align-items-center"><img width="30" height="30" src="./img/icons/search-icon.png" alt=""><span class="m-2">Search</span></a>
    <a href="message.php" class="p-3 flex align-items-center"><img width="30" height="30" src="./img/icons/message-icon.png" alt=""><span class="m-2">Messages</span></a>
    <a href="profile.php" class="p-3 flex align-items-center"><img width="30" height="30" src="./img/icons/user-icon.png" alt=""><span class="m-2">Profile</span></a>
    <a href="create-post.php" class="p-3 flex align-items-center"><img width="30" height="30" src="./img/icons/create-post-icon.png" alt=""><span class="m-2">Create Post</span></a>
  </div>

  <?php if (!isset($hideExplore)) { ?>

    <div class="explore position-fixed bg-white my-4 shadow-sm rounded p-4">
      <h3 class="mb-1">Explore</h3>

      <!-- FETCH USERS HERE => -->

      <?php
      $sql = "SELECT * FROM users LIMIT 3";
      $result = mysqli_query($con, $sql);
      if (!$result) {
        echo "No user found!";
      } else {
        while ($row = mysqli_fetch_assoc($result)) {
      ?>
          <a href="profile.php?user_id=<?php echo $row["id"] ?>" class="user-item">
            <div class="d-flex align-items-center">
              <?php
              if ($row["profile_picture"] == "") { ?>
                <a href="profile.php?user_id=<?php echo $row["id"] ?>">
                  <img width="60" height="60" class="rounded-circle" src="img/icons/user-icon.png" alt="">
                </a>
              <?php } else { ?>
                <a href="profile.php?user_id=<?php echo $row["id"] ?>">
                  <img width="60" height="60" class="rounded-circle" src="<?php echo $row["profile_picture"] ?>" alt="">
                </a>
              <?php } ?>
              <span class="mx-3">
                <p class="fw-bold m-0">
                  <?php
                  if (strlen($row["name"]) > 10) {
                    echo substr($row["name"], 0, 10) . "...";
                  } else {
                    echo $row["name"];
                  }
                  ?>
                </p>
                <p class="text-secondary m-0">
                  <?php
                  if (strlen($row["about"]) > 18) {
                    echo substr($row["about"], 0, 18) . "...";
                  } else {
                    echo $row["about"];
                  }
                  ?>
                </p>
              </span>
            </div>
          </a>
      <?php }
      } ?>

      <div class="d-flex justify-content-center mt-2">
        <a class="text-al" href="browse-users.php">Browse more &rarr;</a>
      </div>
    </div>
  <?php } ?>

</div>

<div class="space" style="width: 14rem;"></div>
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

      <a href="#" class="user-item">
        <div class="d-flex align-items-center">
          <img width="60" height="60" class="rounded-circle" src="./img/users/user-1.jpg" alt="">
          <span class="mx-3">
            <p class="fw-bold m-0">Henry</p>
            <p class="text-secondary m-0">Exploring the world...</p>
          </span>
        </div>
      </a>

      <a href="#" class="user-item">
        <div class="d-flex align-items-center">
          <img width="60" height="60" class="rounded-circle" src="./img/users/user-2.jpg" alt="">
          <span class="mx-3">
            <p class="fw-bold m-0">Jerry</p>
            <p class="text-secondary m-0">Life is better with ...</p>
          </span>
        </div>
      </a>

      <a href="#" class="user-item">
        <div class="d-flex align-items-center">
          <img width="60" height="60" class="rounded-circle" src="./img/users/user-3.jpg" alt="">
          <span class="mx-3">
            <p class="fw-bold m-0">Justin</p>
            <p class="text-secondary m-0">Not all who wander...</p>
          </span>
        </div>
      </a>

      <div class="d-flex justify-content-center mt-2">
        <a class="text-al" href="#">Browse more &rarr;</a>
      </div>
    </div>
  <?php } ?>

</div>

<div class="space" style="width: 14rem;"></div>
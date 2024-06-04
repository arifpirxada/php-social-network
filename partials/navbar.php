<?php
session_start();
if (!isset($_SESSION["user_login"]) && !isset($_SESSION["user_id"])) {
    header("location: login.php");
}

require "dbcon.php";
?>
<header>
    <!-- Navbar -->
    <nav class="navbar position-fixed navbar-expand-lg bg-body-tertiary px-4">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img width="80" height="80" class="logo rounded-circle mx-5"
            src="img/brand/ChitKit-logo.png" alt="logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- tabs -->
          <ul class="nav nav-tabs mx-3">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Latest</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Following</a>
            </li>
          </ul>
          <div class="nav-item account-dropdown dropdown mx-5">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              More
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="profile.php"><img width="20" height="20" class="mx-2" src="img/icons/user-icon.png" alt="">Profile</a></li>
              <li><a class="dropdown-item" href="logout.php"><img width="20" height="20" class="mx-2" src="img/icons/logout-icon.png" alt="">Logout</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="create-post.php"><img class="mx-1" src="img/icons/create-post-icon.png" width="23" height="23"
                    alt="icon">Create Post</a></li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <!-- Navigation for small and medium devices -->
    <nav class="navbar mobile-navbar navbar-light bg-light position-fixed bottom-0 px-4 py-0">
      <a href="index.php" class="mobile-nav-item navbar-brand p-3 flex align-items-center"><img width="30" height="30"
          src="img/icons/home-icon.png" alt="home icon"></a>
      <a href="search.php" class="mobile-nav-item navbar-brand p-3 flex align-items-center"><img width="23" height="23"
          src="img/icons/search-icon.png" alt=""></a>
      <a href="message.php" class="mobile-nav-item navbar-brand p-3 flex align-items-center"><img width="23" height="23"
          src="img/icons/message-icon.png" alt=""></a>
      <a href="profile.php" class="mobile-nav-item right-mobile-nav navbar-brand p-3 flex align-items-center"><img
          width="23" height="23" src="img/icons/user-icon.png" alt=""></a>
    </nav>
    <!-- Navbar end -->
  </header>
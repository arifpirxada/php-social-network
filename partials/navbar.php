<?php
session_start();
if (!isset($_SESSION["user_login"]) && !isset($_SESSION["user_id"])) {
  header("location: login.php");
}

$user_id = $_SESSION["user_id"];

require "dbcon.php";
?>
<script>
  const scrollToBottom = (messageBox) => {
    messageBox.scrollTop = messageBox.scrollHeight;
  }

  // WebSocket logic - chatting =>

  var conn = new WebSocket('ws://localhost:8081');
  conn.onopen = function(e) {
    console.log("Connection established!");
    conn.send(JSON.stringify({
      type: "register",
      userId: <?php echo $user_id ?>
    }))
  };


  // Get the selected user id if any user is selected =>
  const url = window.location.href;
  const urlObj = new URL(url);
  const params = new URLSearchParams(urlObj.search);
  let selectedUserId = params.get('message_user_id');

  conn.onmessage = function(e) {
    data = JSON.parse(e.data);
    let messageBox = document.getElementById("message-box");

    if (selectedUserId != null && messageBox != null) {
      messageBox.insertAdjacentHTML("beforeend", `
      <div class="incoming_msg">
          <div class="received_msg my-3">
              <div class="received_withd_msg">
                  <p>${data.message}</p>
                  <span class="time_date"> 11:01 AM | June 9</span>
              </div>
          </div>
      </div>
      `)

      scrollToBottom(messageBox)
    } else {
      // Notify user =>
      const notifyBox = document.getElementById("notifications");
      notifyBox.insertAdjacentHTML("afterbegin", `
      <li><a class="dropdown-item" href="message.php?message_user_id=${data.sender}">New Message</a></li>
      `)
      const notificationSound = document.getElementById('notificationSound');
      notificationSound.play();
      let notifyNum = document.getElementById("message-notifications");
      notifyNum.removeAttribute("hidden");
      notifyNum.innerText = parseInt(notifyNum.innerText) + 1;
    }

  };

  // Send message here 

  const sendMessage = (e, receiverId) => {
    e.preventDefault();
    let messageBox = document.getElementById("message-box");

    messageBox.insertAdjacentHTML("beforeend", `
    <div class="outgoing_msg">
        <div class="sent_msg">
            <p>${e.target.children[0].value}</p>
            <span class="time_date"> 11:01 AM | Today</span>
        </div>
    </div>
    `)

    conn.send(JSON.stringify({
      sender: <?php echo $user_id ?>,
      receiver: receiverId,
      message: e.target.children[0].value
    }));

    e.target.children[0].value = ""
    scrollToBottom(messageBox)
  }
</script>
<header>
  <!-- Navbar -->
  <audio class="d-none" id="notificationSound">
    <source src="sounds/notification.mp3" type="audio/mpeg">
  </audio>
  <nav class="navbar position-fixed navbar-expand-lg bg-body-tertiary px-4">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php"><img width="80" height="80" class="logo rounded-circle mx-5" src="img/brand/ChitKit-logo.png" alt="logo"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <div class="d-flex justify-content-end align-items-center w-50">

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
              <li><a class="dropdown-item" href="create-post.php"><img class="mx-1" src="img/icons/create-post-icon.png" width="23" height="23" alt="icon">Create Post</a></li>
            </ul>
          </div>

          <div class="dropdown">
            <?php
            // Fetch notification here =>
            $sql = "SELECT * FROM notifications WHERE user_id = '$user_id'";
            $result = mysqli_query($con, $sql);
            if ($result) {
              $num = mysqli_num_rows($result);
            ?>
              <button class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img width="25" src="img/icons/notification-icon.png" alt="notifications">
                <span <?php if ($num == 0) {
                        echo "hidden";
                      } ?> id="message-notifications"><?php echo $num ?></span>
              </button>
              <ul id="notifications" class="dropdown-menu">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                  if ($row["type"] == "message") {
                ?>
                    <li><span onclick="deleteNotification(<?php echo $row['id'] ?>, 'message', <?php echo $row['refrence_id'] ?>, <?php echo $row['user_id'] ?>)" class="dropdown-item c-pointer">New message</span></li>
                  <?php
                  } else if ($row["type"] == "like") {
                  ?>
                    <li><span onclick="deleteNotification(<?php echo $row['id'] ?>, 'like', <?php echo $row['refrence_id'] ?>, <?php echo $row['user_id'] ?>)" class="dropdown-item c-pointer">Someone liked your post!</span></li>
                  <?php
                  } else if ($row["type"] == "comment") {
                  ?>
                    <li><span onclick="deleteNotification(<?php echo $row['id'] ?>, 'comment', <?php echo $row['refrence_id'] ?>, <?php echo $row['user_id'] ?>)" class="dropdown-item c-pointer">New comment!</span></li>
                  <?php
                  }
                }
                ?>
              </ul>
            <?php
            }
            ?>
          </div>

        </div>

      </div>
    </div>
  </nav>

  <!-- Navigation for small and medium devices -->
  <nav class="navbar mobile-navbar navbar-light bg-light position-fixed bottom-0 px-4 py-0">
    <a href="index.php" class="mobile-nav-item navbar-brand p-3 flex align-items-center"><img width="30" height="30" src="img/icons/home-icon.png" alt="home icon"></a>
    <a href="search.php" class="mobile-nav-item navbar-brand p-3 flex align-items-center"><img width="23" height="23" src="img/icons/search-icon.png" alt=""></a>
    <a href="message.php" class="mobile-nav-item navbar-brand p-3 flex align-items-center"><img width="23" height="23" src="img/icons/message-icon.png" alt=""></a>
    <a href="profile.php" class="mobile-nav-item right-mobile-nav navbar-brand p-3 flex align-items-center"><img width="23" height="23" src="img/icons/user-icon.png" alt=""></a>
  </nav>
  <!-- Navbar end -->
</header>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message - ChitKit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/message.css">
</head>

<body class="bg-light">
    <?php require "partials/navbar.php" ?>

    <div class="container main-container d-flex gap-5 justify-content-center">

        <?php
        $hideExplore = true;
        require "partials/sidebar.php"
        ?>

        <?php

        $selected_user_id = -1;
        $selected_user_img = "";
        if (isset($_GET["message_user_id"])) {
            $selected_user_id = $_GET["message_user_id"];
        }

        $user_id = $_SESSION["user_id"];

        if ($user_id == $selected_user_id) {
        ?>
            <script>
                window.location.href = "message.php";
            </script>
        <?php
        }
        // Fetch recent users / search users =>

        $recent_users_array = [];

        // if user searched =>

        if (isset($_GET["search"])) {
            // add searched users to recent users array =>
            $query = $_GET["search"];
            $sql = "SELECT * FROM users WHERE name LIKE '%$query%'";
            $result = mysqli_query($con, $sql);

            if (!$result) {
                array_push($recent_users_array, ["error" => "could not search users"]);
            } else {
                $num = mysqli_num_rows($result);
                if ($num == 0) {
                    array_push($recent_users_array, ["error" => "No user found!"]);
                } else {
                    while ($row = mysqli_fetch_assoc($result)) {
                        array_push($recent_users_array, ["id" => $row["id"], "name" => $row["name"], "profile_picture" => $row["profile_picture"]]);
                    }
                }
            }
        } else {
            // add recent users to recent users array =>

            $sql = "SELECT * FROM recents WHERE user_id = '$user_id'";
            $result = mysqli_query($con, $sql);

            if (!$result) {
                array_push($recent_users_array, ["error" => "could not fetch recent users"]);
            } else {

                while ($row = mysqli_fetch_assoc($result)) {
                    $current_user_id = $row["recent_user_id"];
                    $sql = "SELECT id, name, profile_picture FROM users WHERE id = '$current_user_id'";
                    $user_data = mysqli_query($con, $sql);

                    if ($user_data) {
                        $user_row = mysqli_fetch_assoc($user_data);
                        array_push($recent_users_array, ["id" => $user_row["id"], "name" => $user_row["name"], "profile_picture" => $user_row["profile_picture"]]);
                    }
                }
            } // result

        }


        ?>

        <!-- Posts -->
        <div class="posts" style="margin-top: 7rem;">
            <!-- <div class="d-flex justify-content-end px-4 py-2">
                <button class="btn btn-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                aria-controls="offcanvasRight">Recent</button>
            </div> -->

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasRightLabel">Recent conversations</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="inbox_people" style="width: 100%;">
                        <div class="headind_srch">
                            <div class="recent_heading">
                                <h4>Recent</h4>
                            </div>
                            <div class="srch_bar">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" class="stylish-input-group">
                                    <input required name="search" type="text" class="search-bar" placeholder="Search">
                                    <input name="sidebar" value="open" type="hidden">
                                    <span class="input-group-addon">
                                        <button type="submit"><img width="20" height="20" src="img/icons/search-icon.png" alt="search"></img></button>
                                    </span>
                                </form>
                            </div>
                        </div>
                        <div class="inbox_chat">

                            <!-- recent users list => -->

                            <?php
                            if (isset($recent_users_array[0]["error"])) { ?>
                                <div class="chat_people">
                                    <div class="chat_ib">
                                        <h5><?php echo $recent_users_array[0]["error"] ?></h5>
                                    </div>
                                </div>
                                <?php
                            } else {
                                foreach ($recent_users_array as $key => $value) {
                                ?>

                                    <div class="chat_list 
                                    <?php
                                    if ($selected_user_id != -1 && $selected_user_id == $recent_users_array[$key]["id"]) {
                                        $selected_user_img = $recent_users_array[$key]["profile_picture"];
                                        echo "active_chat";
                                    }
                                    ?>">
                                        <div class="chat_people">
                                            <?php
                                            $is_searched = false;
                                            if (isset($_GET["search"])) {
                                                $is_searched = true;
                                            }
                                            ?>
                                            <div onclick="addToRecent(<?php echo $user_id; ?>, <?php echo $recent_users_array[$key]['id'] ?>, <?php echo $is_searched; ?>)" class="c-pointer">
                                                <?php
                                                if ($recent_users_array[$key]["profile_picture"] == "") {
                                                ?>
                                                    <div class="chat_img"><img class="rounded-circle" src="img/icons/user-icon.png" alt="user"></div>
                                                <?php
                                                } else {
                                                ?>
                                                    <div class="chat_img"><img class="rounded-circle" src="<?php echo $recent_users_array[$key]["profile_picture"] ?>" alt="user"></div>
                                                <?php
                                                }
                                                ?>
                                                <div class="chat_ib">
                                                    <h5><?php echo $recent_users_array[$key]["name"] ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            <?php
                                }
                            }
                            ?>

                            <!-- recent users list ends -->

                        </div>
                    </div>
                </div>
            </div>

            <div class="container outside_msg_container">
                <div class="messaging">
                    <div class="inbox_msg">
                        <div class="inbox_people outside_inbox_people">
                            <div class="headind_srch">
                                <div class="recent_heading">
                                    <h4>Recent</h4>
                                </div>
                                <div class="srch_bar">
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" class="stylish-input-group">
                                        <input required name="search" type="text" class="search-bar" placeholder="Search">
                                        <span class="input-group-addon">
                                            <button type="submit"><img width="20" height="20" src="img/icons/search-icon.png" alt="search"></img></button>
                                        </span>
                                    </form>
                                </div>
                            </div>
                            <div class="inbox_chat">
                                <!-- recent users list => -->

                                <?php
                                if (isset($recent_users_array[0]["error"])) { ?>
                                    <div class="chat_people">
                                        <div class="chat_ib">
                                            <h5><?php echo $recent_users_array[0]["error"] ?></h5>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    foreach ($recent_users_array as $key => $value) { ?>

                                        <div class="chat_list 
                                        <?php
                                        if ($selected_user_id != -1 && $selected_user_id == $recent_users_array[$key]["id"]) {
                                            echo "active_chat";
                                        }
                                        ?>">
                                            <div class="chat_people">
                                                <?php
                                                $is_searched = false;
                                                if (isset($_GET["search"])) {
                                                    $is_searched = true;
                                                }
                                                ?>
                                                <div onclick="addToRecent(<?php echo $user_id; ?>, <?php echo $recent_users_array[$key]['id'] ?>, <?php echo $is_searched; ?>)" class="c-pointer">
                                                    <div class="chat_img"> <img class="rounded-circle" src="
                                                    <?php
                                                    if ($recent_users_array[$key]["profile_picture"] == "") {
                                                        echo "img/icons/user-icon.png";
                                                    } else {
                                                        echo $recent_users_array[$key]["profile_picture"];
                                                    }
                                                    ?>" alt="user">
                                                    </div>
                                                    <div class="chat_ib">
                                                        <h5><?php echo $recent_users_array[$key]["name"] ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                <?php
                                    }
                                }
                                ?>

                                <!-- recent users list ends -->
                            </div>
                        </div>
                        <div class="mesgs">
                            <div class="d-flex justify-content-between px-4 pb-2">
                                <img class="rounded-circle" width="40" height="40" src="
                                <?php
                                if ($selected_user_img == "") {
                                    echo "img/icons/user-icon.png";
                                } else {
                                    echo $selected_user_img;
                                }
                                ?>" alt="user">
                                <div>
                                    <button id="recent-toggle" class="btn btn-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Recent</button>
                                    <?php
                                    if (isset($_GET["message_user_id"])) {
                                    ?>
                                        <div class="dropdown d-inline">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                More
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><span onclick="removeFromRecent(<?php echo $user_id ?>, <?php echo $selected_user_id ?>)" class="dropdown-item c-pointer">Remove</span></li>
                                                <li><span onclick="deleteMessages(<?php echo $user_id ?>, <?php echo $selected_user_id ?>)" class="dropdown-item c-pointer">Delete chats</span></li>
                                            </ul>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div id="message-box" class="msg_history py-4">

                                <?php
                                // Fetch Previous messages here ->
                                $message_limit = 20;
                                if (isset($_GET["limit"])) {
                                    $message_limit = $_GET["limit"];
                                }
                                $sql = "SELECT * FROM `messages` WHERE (sender_id = '$user_id' AND receiver_id = '$selected_user_id') OR (sender_id = '$selected_user_id' AND receiver_id = '$user_id') ORDER BY date DESC LIMIT $message_limit";
                                $result = mysqli_query($con, $sql);

                                if (!$result) {
                                ?>
                                    <script>
                                        alert("Could not fetch previous messages!");
                                    </script>
                                    <?php
                                } else {
                                    $sql = "SELECT COUNT(*) AS num_of_msgs FROM `messages` WHERE (sender_id = '$user_id' AND receiver_id = '$selected_user_id') OR (sender_id = '$selected_user_id' AND receiver_id = '$user_id')";
                                    $get_num = mysqli_query($con, $sql);
                                    if ($get_num) {
                                        $num_of_msgs_row = mysqli_fetch_assoc($get_num);
                                        $num_of_msgs = $num_of_msgs_row["num_of_msgs"];

                                        if ($num_of_msgs > $message_limit) {
                                    ?>
                                            <div class="text-center mb-5 mt-3">
                                                <a href="message.php?message_user_id=<?php echo $selected_user_id ?>&limit=<?php echo $message_limit + 20 ?>" class="c-pointer">Load more</a>
                                            </div><?php
                                                }
                                            }

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                if ($row["sender_id"] == $user_id) {
                                                    ?>
                                            <div class="outgoing_msg">
                                                <div class="sent_msg">
                                                    <p><?php echo $row["message"] ?></p>
                                                    <span class="time_date"><?php echo $row["date"] ?></span>
                                                </div>
                                            </div>
                                        <?php
                                                } else {
                                        ?>
                                            <div class="incoming_msg">
                                                <div class="received_msg">
                                                    <div class="received_withd_msg">
                                                        <p><?php echo $row["message"] ?></p>
                                                        <span class="time_date"><?php echo $row["date"] ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                <?php
                                                }
                                            }
                                        }
                                ?>
                            </div>
                            <div class="type_msg">
                                <form onsubmit="sendMessage(event, <?php echo $selected_user_id ?>)" class="input_msg_write">
                                    <input required style="outline: none;" type="text" class="write_msg" placeholder="Type a message" />
                                    <button type="submit" class="msg_send_btn" type="button"><img width="50" src="img/icons/send_icon.png" alt="send"></button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
        <!-- Posts end -->

    </div>

    <?php
    // Keep the sidebar open after search =>
    if (isset($_GET["sidebar"]) && $_GET["sidebar"] == "open") {
    ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("recent-toggle").click();
            });
        </script>
    <?php
    }
    ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const url = window.location.href;
            const urlObj = new URL(url);
            const params = new URLSearchParams(urlObj.search);
            const limit = params.get('limit');

            if (limit == null || limit == 20) {
                let messageBox = document.getElementById("message-box");
                messageBox.scrollTop = messageBox.scrollHeight;
            }
        });
    </script>
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
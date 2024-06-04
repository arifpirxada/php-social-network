<?php
if (!isset($_GET["user_id"])) {
    header("location: index.php");
}
$current_user_id = $_GET["user_id"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search - ChitKit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/users.css">
</head>

<body class="bg-light">
    <?php require "partials/navbar.php" ?>

    <div class="container main-container d-flex gap-5 justify-content-center">
        <?php require "partials/sidebar.php" ?>

        <!-- Posts -->
        <div class="posts" style="margin-top: 7rem;">
            <div class="container posts-container mt-4">

                <!-- USERS => -->

                <!-- Fetch users here => -->

                <?php
                $sql = "SELECT * FROM followers WHERE follower_id = '$current_user_id'";
                $result = mysqli_query($con, $sql);
                if (!$result) {
                    echo "No user found!";
                } else {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Fetch user details here =>
                        $followed_user = $row["user_id"];
                        $sql = "SELECT id, name, profile_picture, about FROM users WHERE id = '$followed_user'";
                        $followed_user_data = mysqli_query($con, $sql);

                        if ($followed_user_data) {
                            $followed_user_row = mysqli_fetch_assoc($followed_user_data);
                ?>
                            <div class="card mb-1" style="max-width: 540px; padding-right: 35px">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <?php
                                        if ($followed_user_row["profile_picture"] == "") { ?>
                                            <a href="profile.php?user_id=<?php echo $followed_user_row["id"] ?>">
                                                <img src="img/icons/user-icon.png" class="rounded-circle m-1 follow-insight-user-img" alt="...">
                                            </a>
                                        <?php } else { ?>
                                            <a href="profile.php?user_id=<?php echo $followed_user_row["id"] ?>">
                                                <img src="<?php echo $followed_user_row["profile_picture"] ?>" class="rounded-circle m-1 follow-insight-user-img" alt="...">
                                            </a>
                                        <?php } ?>
                                    </div>
                                    <div>
                                        <div class="card-body">
                                            <div style="right: 16px;" class="d-flex position-absolute w-100 justify-content-end">
                                                <a href="profile.php?user_id=<?php echo $followed_user_row["id"] ?>">
                                                    <img width="25" height="25" src="img/icons/view-icon.png" alt="view icon">
                                                </a>
                                            </div>
                                            <h5 class="card-title">
                                                <?php
                                                if (strlen($followed_user_row["name"]) > 16) {
                                                    echo substr($followed_user_row["name"], 0, 16) . "...";
                                                } else {
                                                    echo $followed_user_row["name"];
                                                }
                                                ?>
                                            </h5>
                                            <p class="card-text">
                                                <?php
                                                if (strlen($followed_user_row["about"]) > 40) {
                                                    echo substr($followed_user_row["about"], 0, 40) . "...";
                                                } else {
                                                    echo $followed_user_row["about"];
                                                }
                                                ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <?php
                        }
                    }
                }
                ?>

                <!-- USERS END -->

            </div>

        </div>
        <!-- Posts end -->
        <div class="space space-2" style="width: 18rem;"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
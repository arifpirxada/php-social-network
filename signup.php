<?php
session_start();
if (isset($_SESSION["user_login"]) && isset($_SESSION["user_id"])) {
    header("location: index.php");
}

require "./partials/dbcon.php";
require "./partials/helper.php";

$server_err = false;
$pass_match = true;
$user_exists = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $help = new Helper();
    $name = $help->test_input($_POST["signup-name"]);
    $email = $help->test_input($_POST["signup-email"]);
    $password = $help->test_input($_POST["signup-password"]);
    $con_password = $help->test_input($_POST["confirm-password"]);

    if ($password != $con_password) {
        $passMatch = false;
    } else {

        $sql = "SELECT id FROM users WHERE `email` = '$email'";
        $result = mysqli_query($con, $sql);
        if (!$result) {
            $server_err = true;
        } else {
            if (mysqli_num_rows($result) > 0) {
                $user_exists = true;
            } else {
                // INSERT USER INTO DATABASE
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO `users`(`name`, `email`, `password`, `profile_picture`) VALUES ('$name','$email','$hashed_password','')";
                $result = mysqli_query($con, $sql);

                if (!$result) {
                    $server_err = true;
                } else {
                    $_SESSION["user_login"] = true;
                    $_SESSION["user_id"] = mysqli_insert_id($con);
                    header("location: index.php");
                }
            }
        }
    }
}
?>
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
    <div class="container d-flex align-items-center pt-5 p-2 flex-column" style="min-height: 100vh;">
        <ul class="nav nav-pills mb-3 mt-5" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="login.php" class="nav-link">Login</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="signup.php" class="nav-link active">Signup</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" class="mt-2 registration-form">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="signup-name" name="signup-name" placeholder="name@example.com">
                        <label for="signup-name">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="signup-email" name="signup-email" placeholder="name@example.com">
                        <label for="signup-email">Email address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="signup-password" name="signup-password" placeholder="Password">
                        <label for="signup-password">Password</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Password">
                        <label for="confirm-password">Confirm Password</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-4">Signup</button>
                    <?php if ($user_exists) { ?>
                        <div class="mt-3 alert alert-warning" role="alert">User already exists! use different email.</div>
                    <?php } ?>
                    <?php if (!$pass_match) { ?>
                        <div class="mt-3 alert alert-warning" role="alert">Passwords do not match!</div>
                    <?php } ?>
                    <?php if ($server_err) { ?>
                        <div class="mt-3 alert alert-warning" role="alert">Internal server error!</div>
                    <?php } ?>
                </form>

            </div>
        </div>
    </div>

    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
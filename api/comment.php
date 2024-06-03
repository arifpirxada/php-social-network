<?php
require "../partials/dbcon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $post_id = $_POST["post_id"];
    $user_id = $_POST["user_id"];

    $sql = "SELECT name FROM users WHERE id = '$user_id'";
    $result = mysqli_query($con, $sql);


    if ($result) {
        $user = mysqli_fetch_assoc($result);
        $name = $user["name"];

        $sql = "INSERT INTO `comments`(`comment`, `post_id`, `user_id`, `user_name`) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("siis", $_POST["comment"], $post_id, $user_id, $name);

        $exec = $stmt->execute();
        if (!$exec) {
            echo "An error occured while adding your comment!";
        } else {
            header("location: ../posts.php?post_id=$post_id");
        }
    } else {
        echo "internal server error!";
    }
}
?>
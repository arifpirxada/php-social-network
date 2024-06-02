<?php
require "../partials/dbcon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    $user_id = $data['user_id'];
    $follower_id = $data['follower_id'];

    $sql = "DELETE FROM `followers` WHERE user_id = '$user_id' AND follower_id = '$follower_id'";
    $result = mysqli_query($con, $sql);

    if ($result) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
}
?>
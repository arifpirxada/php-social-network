<?php
require "../partials/dbcon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    $notification_id = $data['notification_id'];
    $type = $data['type'];

    $sql = "DELETE FROM `notifications` WHERE notification_id";
    if ($type == "message" && isset($data["user_id"]) && isset($data["refrence_id"])) {
        $user_id = $data["user_id"];
        $refrence_id = $data["refrence_id"];
        $sql = "DELETE FROM `notifications` WHERE user_id = '$user_id' AND refrence_id = '$refrence_id'";
    }

    $result = mysqli_query($con, $sql);

    if ($result) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
}
?>
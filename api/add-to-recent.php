<?php
require "../partials/dbcon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    $user_id = $data['user_id'];
    $recent_user_id = $data['recent_user_id'];

    $sql = "INSERT INTO `recents`(`user_id`, `recent_user_id`) VALUES (?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $user_id, $recent_user_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
}
?>
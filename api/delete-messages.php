<?php
require "../partials/dbcon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    $sender_id = $data['sender_id'];
    $receiver_id = $data['receiver_id'];

    $sql = "DELETE FROM `messages` WHERE sender_id = ? AND receiver_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $sender_id, $receiver_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
}
?>
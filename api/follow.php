<?php
require "../partials/dbcon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    $sql = "INSERT INTO followers (`user_id`, `follower_id`) VALUES (?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $data["user_id"], $data["follower_id"]);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
}
?>
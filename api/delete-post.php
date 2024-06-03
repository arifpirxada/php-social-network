<?php
require "../partials/dbcon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    $post_id = $data['post_id'];

    $sql = "SELECT file_json_array FROM `posts` WHERE id = $post_id";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo json_encode(["success" => false]);
        die();
    }
    $row = mysqli_fetch_assoc($result);

    $message_array = ["success" => true, "comments-delete" => true, "files-delete" => true];

    // Delete files =>
    $file_paths = json_decode($row["file_json_array"], true);
    if ($file_paths) {
        foreach ($file_paths as $key => $value) {
            $delete = unlink("../".$file_paths[$key]);
            if (!$delete) {
                $message_array["files-delete"] = false;
            }
        }
    }

    // Delete comments =>

    $sql = "DELETE FROM `comments` WHERE post_id = '$post_id'";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        $message_array["comments-delete"] = false;
    }

    $sql = "DELETE FROM `posts` WHERE id = '$post_id'";
    $result = mysqli_query($con, $sql);

    if ($result) {
        echo json_encode($message_array);
    } else {
        $message_array["success"] = false;
        echo json_encode($message_array);
    }
}

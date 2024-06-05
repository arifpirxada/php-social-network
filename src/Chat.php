<?php

namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface
{
    protected $clients;
    protected $users = [];
    protected $con;

    public function __construct($con)
    {
        $this->clients = new \SplObjectStorage;
        $this->con = $con;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    // Insert message into database function =>

    public function insertMessage($data, $notify)
    {
        $sender = $data["sender"];
        $receiver = $data["receiver"];

        $sql = "INSERT INTO `messages`(`message`, `sender_id`, `receiver_id`) VALUES (?, ?, ?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("sii", $data["message"], $sender, $receiver);
        $message_insert = $stmt->execute();

        if (!$message_insert) {
            echo "Message could not be inserted!" . mysqli_error($this->con);
            return;
        }
        if ($notify) {
            $sql = "INSERT INTO `notifications`(`user_id`, `type`, `refrence_id`) VALUES (?, ?, ?)";
            $stmt = $this->con->prepare($sql);
            $type = "message";
            $stmt->bind_param("isi", $data["receiver"], $type, $data["sender"]);
            $insert_notification = $stmt->execute();

            if (!$insert_notification) {
                echo "Message could not be inserted!" . mysqli_error($this->con);
            }
        }
        // Add user to recent if not =>

        $sql = "SELECT COUNT(*) AS num FROM `recents` WHERE user_id = '$receiver' AND recent_user_id = '$sender'";
        $result = mysqli_query($this->con, $sql);
        if ($result) {
            $num_row = mysqli_fetch_assoc($result);
            $num = $num_row["num"];
            if ($num == 0) {
                // INSERT USER INTO RECENTS =>
                $sql = "INSERT INTO `recents`(`user_id`, `recent_user_id`) VALUES ('$receiver','$sender')";
                $result = mysqli_query($this->con, $sql);
            }
        }
    }

    // Send message to a specific user function =>
    public function sendMessage($data, $id)
    {
        $data = json_encode(["message" => $data["message"], "sender" => $data["sender"]]);
        $receiver = $this->users[$id];
        $receiver->send($data);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);

        // Client registration =>
        if (isset($data["type"]) && $data["type"] === "register" && isset($data["userId"])) {
            $from->id = $data["userId"];
            $this->users[$data["userId"]] = $from;

            echo "Client registered with ID: {$data['userId']}\n";
            return;
        }

        if (isset($data["sender"]) && isset($data["receiver"]) && isset($data["message"])) {
            if (isset($this->users[$data["receiver"]])) {
                $this->sendMessage($data, $data["receiver"]);
                $this->insertMessage($data, false);
            } else {
                // Save message to database only with notification
                $this->insertMessage($data, true);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // Set the messages as unseen if user has not seen some messages =>

        unset($this->users[$conn->id]);
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}

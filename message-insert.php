<?php
require "db.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    date_default_timezone_set("AMERICA/SAO_PAULO");
    $text = $_POST['chatText'];
    $user = $_POST['chatUser'];
    $date = date("Y-m-d H:i:s");

    $sql = "INSERT INTO messages (Sender, Message, CreatedAt) VALUES ('$user', '$text', '$date')";
    chat_query($sql);
    header("Content-Type: application/json");
    echo json_encode(["insertMessage" => "success"]);
}

<?php
require "db.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    date_default_timezone_set("AMERICA/SAO_PAULO");
    $response = ['success' => false, 'message' => ''];
    $text = $_POST['chatText'];
    $user = $_POST['chatUser'];
    $date = date("Y-m-d H:i:s");

    $sql = "INSERT INTO messages (Sender, Message, CreatedAt) VALUES ('$user', '$text', '$date')";
    chat_query($sql);
    echo "{ \"insertMessage\": \"success\" }";
    header("Content-Type: application/json");
}

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        date_default_timezone_set("AMERICA/SAO_PAULO");
        $text = $_POST['chatText'];
        $user = $_POST['chatUser'];
        $date = date("Y-m-d H:i:s");
    
        $link = mysqli_connect('127.0.0.1', 'root', '', 'chat');
        if (!$link) {
            echo "Connection error: " . mysqli_connect_errno();
            die();
        }
    
        $sql = "INSERT INTO messages (Sender, Message, Date) VALUES ($user, '$text', '$date')";
        $result = mysqli_query($link, $sql);
    
        mysqli_close($link);
    }
    else
    {
        echo "Hello GET";
    }
?>
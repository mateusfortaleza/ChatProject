<?php 
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        date_default_timezone_set("AMERICA/SAO_PAULO");
        $text = $_POST['chatText'];
        $date = date("Y-m-d H:i:s");
        
        $link = mysqli_connect('127.0.0.1', 'root', '', 'chat');
        if(!$link) {
            echo "Connection error: " . mysqli_connect_errno();
            die();
        }

        $sql = "INSERT INTO messages (Sender, Message, Date) VALUES (" . $_COOKIE['user'] . ", '$text', '$date')";
        $result = mysqli_query($link, $sql);
          

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <main>
        <h1 class="chat-title">Chat</h1>
        
        <form class="chatArea" action="chat.php" method="POST">
            <label for="chatText" class="sr-only">Chat</label>
            <input type="text" name="chatText" id="chatText" required/>
            <input type="submit" value="Submit" class="TextSubmit" />
        </form>
    </main>
</body>
</html>
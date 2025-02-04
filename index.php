<?php 
    $link = mysqli_connect("127.0.0.1", "root", "", "mateus");

    if(!$link) {
        echo "Connection unsuccesfull";
        die();
    }

    echo "Connection succesfull";
    mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <title>Chat</title>
</head>
<body>
    <main>
        <h1>Welcome to the Chat</h1>
        <form action="index.php" method="post">
            <label> Name: 
                <input type="text" name="chatName" id="name" placeholder="Your name" required>
            </label>
            <label> Email: 
                <input type="email" name="chatEmail" id="email" placeholder="example@example.com" required/>
            </label>
            <label for="password"> Password: 
                <input type="password" name="chatPassword" id="password" required>
            </label>
        </form>
        <input type="submit" value="Submit" />
    </main>
    <p>Don't have a account?</p>
    <a href="register.php"><input type="button" value="Register Now" /></a>
</body>
</html>
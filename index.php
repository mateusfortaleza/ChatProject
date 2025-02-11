<?php
    $loginSucessful = false;
    $validForm = false;
    $validationError = "";
    
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        // Assign POST data
        $formEmail = $_POST['chatEmail'];
        $formPassword = $_POST['chatPassword'];

        $validForm = true;

        // Login user
        if ($validForm) {
            $link = mysqli_connect("127.0.0.1","root","","chat");
            if (!$link) {
                echo "Connection unsuccessfull"; 
                exit;
            }
        
            $sql = "SELECT * FROM user WHERE Email = '$formEmail' AND password = '$formPassword'";
            $result = mysqli_query($link, $sql);
        
            if ($result) {
                $hasRows = mysqli_num_rows($result) > 0;

                if ($hasRows) {
                    // Está logado
                    $loginSucessful = true;
                    header('Location: http://localhost/ChatProject/chat.php');
                }

            } else {
                echo "Access denied";
                echo mysqli_error($link);
            }
            
            mysqli_close($link);
        }
    }
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
            <label> Email: 
                <input type="email" name="chatEmail" id="email" placeholder="example@example.com" required/>
            </label>
            <label for="password"> Password: 
                <input type="password" name="chatPassword" id="password" required>
            </label>
            <?php if (!$loginSucessful && $_SERVER['REQUEST_METHOD'] == "POST") {?>
                <p>Email or password incorrect. Try again</p>
            <?php }?>
            <input type="submit" value="Sign In" class="IndexButton"/>
        </form>
    </main>
    <p>Don't have a account?</p>
    <a href="register.php"><input type="button" value="Register Now" /></a>
</body>
</html>
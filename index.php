<?php
    $loginSucessful = false;
    $validForm = false;
    $validationError = "";

    function validateEmail($email) {
        $conn = mysqli_connect('127.0.0.1','root','','mateus');    
        if(!$conn) {
            echo "Connection failed";
            exit();
        }
        $EmailSql = "SELECT * FROM user WHERE email = '$email'";
        $result = mysqli_query($conn, $EmailSql);
        $numRows = mysqli_num_rows($result);
        mysqli_close($conn);
        if($numRows == 1) {
            return true;
        } else {
            return false;
        }
    };
    
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        // Assign POST data
        $formEmail = $_POST['chatEmail'];
        $formPassword = $_POST['chatPassword'];

        $validEmail = validateEmail($formEmail);

        $validForm = $validEmail;
        // Login user
        if ($validForm) {
            $link = mysqli_connect("127.0.0.1","root","","mateus");
            if (!$link) {
                echo "Connection unsuccessfull"; 
                exit;
            }
        
            $sql = "SELECT * FROM user WHERE Email = '$formEmail'";
        
            if (mysqli_query($link, $sql)) {
                $loginSucessful = true;
                header('Location: http://localhost/Chat-site/chat.php');
            } else {
                echo "Login unsuccessfull. Contact support if this problem persists";
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
            <input type="submit" value="Sign In" />
        </form>
    </main>
    <p>Don't have a account?</p>
    <a href="register.php"><input type="button" value="Register Now" /></a>
</body>
</html>
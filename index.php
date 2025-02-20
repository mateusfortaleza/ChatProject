<?php
    $validForm = false;
    $validationError = "";
    $loginSucessful = false;
    if(isset($_COOKIE['user'])){
        header("Location: chat.php");
    }
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
                    $user = mysqli_fetch_assoc($result);
                    setcookie("user", $user['ID']);
                    header('Location: chat.php');
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Chat</title>
</head>
<body>
    <main>
        <h1 class="indexTitle">Welcome to the Chat</h1>
        <form action="index.php" method="post" class="indexForm">
            <?php if (!$loginSucessful && $_SERVER['REQUEST_METHOD'] == "POST") {?>
                <p class="loginIncorrect">Email or password incorrect. Try again</p>
            <?php }?>
            <label for="email" class="indexInputText">Email: </label>
                <input type="email" name="chatEmail" id="email" placeholder="example@example.com" class="IndexInput" required/>
            <label for="password" class="indexInputText">Password:</label>
                <input type="password" name="chatPassword" id="password" class="IndexInput" required>
            <input type="submit" value="Sign In" class="IndexButton"/>
        </form>
    </main>
    <div class="registerRedirect">
        <p>Don't have a account?</p>
        <a href="register.php"><input type="button" value="Register Now" /></a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
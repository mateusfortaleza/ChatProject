<?php
    // Page level variables
    $registerSucessful = false;
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
        if($numRows == 0) {
            return true;
        } else {
            return false;
        }
    };

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        // Assign POST data
        $formName = $_POST['chatName'];
        $formEmail = $_POST['chatEmail'];
        $formPassword = $_POST['chatPassword'];

        $validEmail = validateEmail($formEmail);

        $validForm = $validEmail;
        // Register user
        if ($validForm) {
            $link = mysqli_connect("127.0.0.1","root","","mateus");
            if (!$link) {
                echo "Connection unsuccessfull"; 
                exit;
            }
        
            $sql = "INSERT INTO user (Name, Email, Password) VALUES ('" . $formName . "', '" . $formEmail . "', '" . $formPassword . "' )";
        
            if (mysqli_query($link, $sql)) {
                $registerSucessful = true;
            } else {
                echo "Registration unsuccessfull. Contact support if this problem persists";
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
    <link rel="stylesheet" href="./styles.css" />
    <title>Register Now</title>
</head>
<body>
    <main>
        <?php if ($registerSucessful) { ?>
            <h2>Registration sucessful</h2>
            <p><a hsref="index.php">Back to Sign In</a></p>
        <?php } else { ?>
            <?php if (!$validForm) { ?>
                <h3><?php echo $validationError ?></h3>
            <?php } ?>
            <form action="register.php" method="post">
                <h1>Register</h1>
                <label> Name: 
                    <input type="text" name="chatName" id="name" required>
                </label>
                <label> Email: 
                    <input type="email" name="chatEmail" id="email" required>
                </label>
                <label> Password: 
                    <input type="password" name="chatPassword" id="password" required>
                </label>
            </form>
            <input type="submit" value="Submit" />
        <?php } ?>
    </main>
    <p> Already have a account?</p>
    <a href="index.php"><input type="button" value="Return"></a>
</body>
</html>
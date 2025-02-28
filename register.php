<?php
    // Page level variables
    require 'db.php';
    $registerSuccessful = false;
    $validForm = false;
    $validationError = "";
    function validateEmail($email) {
        $EmailSql = "SELECT * FROM user WHERE email = '$email' ";
        $result = chat_query($EmailSql);
        $numRows = mysqli_num_rows($result);
        if ($numRows == 0) {
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
            
            $sql = "INSERT INTO user (Name, Email, Password) VALUES ('" . $formName . "', '" . $formEmail . "', '" . $formPassword . "' )";
            $query = chat_query($sql);
            if ($query) {
                $registerSuccessful = true;
            } else {
                echo "Registration unsuccessfull. Contact support if this problem persists";
                echo mysqli_error($link);
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en" class="h-full bg-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Register Now</title>
</head>
<body class="h-full bg-blue-700">
    <main class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8 lg:py-24">
        <div class="bg-white shadow-lg rounded-lg p-6 lg:p-12">
        <?php if ($registerSuccessful) { ?>
            <h2>Registration sucessful</h2>
            <p><a href="index.php">Back to Sign In</a></p>
        <?php } else { ?>
            <?php if (!$validForm) { ?>
                <h3><?php echo $validationError ?></h3>
            <?php } ?>
            <h1 class="text-[50px] flex flex-row justify-center items-center font-semibold">Register</h1>
            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-md">
                <form action="register.php" method="post" class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm/6 font-medium text-gray-900">Name: </label> 
                        <input type="text" name="chatName" id="name" placeholder="" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:-outline-offset-2 focus:outline-blue-900 sm:text-sm/6" required>
                    </div>
                    <div>
                        <label class="block text-sm/6 font-medium text-gray-900">Email: </label>
                        <input type="email" name="chatEmail" id="email" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:-outline-offset-2 focus:outline-blue-900 sm:text-sm/6" required>
                    </div>
                    <div>
                        <label class="block text-sm/6 font-medium text-gray-900">Password: </label>
                        <input type="password" name="chatPassword" id="password" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:-outline-offset-2 focus:outline-blue-900 sm:text-sm/6" required>
                    </div>
                    <div>
                        <input type="submit" value="Submit" class="flex w-full justify-center rounded-md bg-blue-900 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-blue-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:bg-blue-900"/>
                    </div>
                </form>
            </div>
            <p class="mt-10 text-center">Already have a account?</p>
            <a href="index.php" class="font-semibold flex items-center justify-center text-blue-600 hover:text-blue-900">Sign In</a>
             <?php } ?>
        </div>
    </main>
</body>
</html>
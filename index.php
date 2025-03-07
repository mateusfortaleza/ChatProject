<?php
require 'business.php';
$validForm = false;
$validationError = "";
$loginSuccessful = false;
session_start();
if (isset($_SESSION['userID'])) {
    header("Location: chat.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Assign POST data
    $formEmail = $_POST['chatEmail'];
    $formPassword = $_POST['chatPassword'];
    $validForm = true;
    // Login user
    if ($validForm) {
        $user = get_user($formEmail, $formPassword);
        if (login_is_valid($user)) {
            // Está logado
            $loginSuccessful = true;
            $_SESSION['userID'] = $user['ID'];
            $_SESSION['userName'] = $user['Name'];
            $_SESSION['userEmail'] = $user['Email'];
            $_SESSION['userLastMessageDate'] = get_last_message_date();
            header('Location: chat.php');
        }
    } else {
        echo "Access denied";
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="h-full bg-blue-700">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Chat</title>
</head>

<body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8 lg:py-24">
        <div class="bg-white shadow-lg rounded-lg p-6 lg:p-12">
            <h1 class="text-[50px] flex flex-row justify-center items-center font-semibold mt-10">Welcome to the Chat
            </h1>
            <h2 class="text-[30px] flex flex-row justify-center items-center font-semibold mt-5">Sign In</h2>
            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-md">
                <form action="index.php" method="post" class="space-y-6">
                    <?php if (!$loginSuccessful && $_SERVER['REQUEST_METHOD'] == "POST") { ?>
                        <p class="loginIncorrect">Email or password incorrect. Try again</p>
                    <?php } ?>
                    <div>
                        <label for="email" class="block text-sm/6 font-medium text-gray-900 mb-0">Email: </label>
                        <div class="mt-2">
                            <input type="email" name="chatEmail" id="email" placeholder="example@example.com"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:-outline-offset-2 focus:outline-blue-900 sm:text-sm/6"
                                required />
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm/6 font-medium text-gray-900 mb-0">Password:
                            </label>
                        </div>
                        <div class="mt-2">
                            <input type="password" name="chatPassword" id="password" placeholder="********"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:-outline-offset-2 focus:outline-blue-900 sm:text-sm/6"
                                required />
                        </div>
                    </div>
                    <button type="submit" value="Sign In"
                        class="flex w-full justify-center rounded-md bg-blue-900 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-blue-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:bg-blue-900">Sign
                        In</button>
                </form>
                <p class="mt-10 text-center">Don't have an account?</p>
                <a href="register.php"
                    class="font-semibold flex items-center justify-center text-blue-600 hover:text-blue-900">Register
                    Now</a>
            </div>
        </div>
    </div>
</body>

</html>
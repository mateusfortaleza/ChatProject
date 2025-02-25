<?php
if (!isset($_COOKIE['user'])) {
    header("Location: index.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    date_default_timezone_set("AMERICA/SAO_PAULO");
    $text = $_POST['chatText'];
    $date = date("Y-m-d H:i:s");

    $link = mysqli_connect('127.0.0.1', 'root', '', 'chat');
    if (!$link) {
        echo "Connection error: " . mysqli_connect_errno();
        die();
    }

    $sql = "INSERT INTO messages (Sender, Message, Date) VALUES (" . $_COOKIE['user'] . ", '$text', '$date')";
    $result = mysqli_query($link, $sql);

    mysqli_close($link);
}


?>

<!DOCTYPE html>
<html lang="en" class="box-border h-screen bg-white">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    </head>
    <body class="min-h-screen flex justify-center items-center" onload="window.scrollTo(0, document.body.scrollHeight);">
        <main class="min-h-full min-w-full flex flex-col">
            <div class="px-4 flex justify-center items-center sm:px-0">
                <h1 class="text-5xl/15 font-semibold text-gray-900">Chat</h1>
            </div>
            <div class="mt-6 border-t border-gray-200">
                </div>
                <div id="response-messages" class="flex flex-col space-y-4 p-4 overflow-y-auto h-full">
        </div>
        <form class="flex items-center justify-center w-full max-w-full px-4 mb-3" id="chatForm" action="chat.php" method="POST">
            <label for="chatText" class="sr-only">Chat</label>
            <div class="flex items-center w-full space-x-2">
                <div class="flex-grow flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-blue-600">
                    <textarea type="text" name="chatText" id="chatText"
                    class="block w-full py-1.5 pr-3 pl-1 text-xl text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                    required></textarea>
                    <input type="hidden" name="chatUser" id="chatUser" value="<?php echo $_COOKIE['user']; ?>" />
                </div>
                <input type="submit" id="chatSubmit" value="Submit"
                class="flex-shrink-0 w-[90px] h-[60px] justify-center rounded-md bg-blue-900 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-blue-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:bg-blue-900" />
            </div>
            <script type="text/javascript">
                const form = document.getElementById("chatForm");
                form.addEventListener("submit", function (event) {
                    event.preventDefault();
                    
                    const formData = {
                        chatText: document.getElementById("chatText").value,
                        chatUser: document.getElementById("chatUser").value
                    };
                    
                    $.ajax({
                        url: "message-input.php",
                        method: "POST",
                        data: formData
                    }).done(function () {
                        reloadMessages();
                    });
                    
                    document.getElementById("chatText").value = "";
                });
                </script>
        </form>
    </main>
</body>
<script src="script.js"></script>
</html>
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body class="min-h-screen flex justify-center items-center">
    <main class="min-h-screen flex flex-col">
        <div class="px-4 flex justify-center items-center sm:px-0">
            <h1 class="text-5xl/15 font-semibold text-gray-900">Chat</h1>
        </div>
        <div class="mt-6 border-t border-gray-200">
            <div>
            </div>
        </div>

        <div id="response-messages">
            <script type="text/javascript">
                function reloadMessages() {
                    $.ajax({
                    url: "messages.php"
                    }).done(function(data) {
                        document.getElementById("response-messages").innerHTML = "";
                        data.map(msg => {
                            document.getElementById("response-messages").insertAdjacentHTML("beforeend", `<p>${msg.MessageText} | ${msg.MessageName} | ${msg.MessageDate}</p>`);
                        })
                    });
                }

                setInterval(reloadMessages, 500);
            </script>
        </div>

        <form class="chatArea" action="chat.php" method="POST">
            <label for="chatText" class="sr-only">Chat</label>
            <input type="text" name="chatText" id="chatText" required />
            <input type="submit" value="Submit" class="TextSubmit" />
        </form>
    </main>
</body>

</html>
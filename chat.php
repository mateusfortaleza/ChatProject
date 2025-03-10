<?php
require 'db.php';
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    date_default_timezone_set("AMERICA/SAO_PAULO");

    $fileAttachment = '';
    if (isset($_FILES['chatFile']) && $_FILES['chatFile']['error'] == 0) {
        $uploadDir = 'uploads/';
        $fileName = basename($_FILES['chatFile']['name']);
        $filePath = $uploadDir . $fileName;

        // Move uploaded file to the uploads directory
        if (move_uploaded_file($_FILES['chatFile']['tmp_name'], $filePath)) {
            $fileAttachment = $fileName;
        }
    }

    $text = $_POST['chatText'];
    $date = date("Y-m-d H:i:s");

    if (!empty($fileAttachment)) {
        $text .= " [file:" . $fileAttachment . "]";
    }

    $sql = "INSERT INTO messages (Sender, Message, CreatedAt) VALUES (" . $_SESSION['userID'] . ", '$text', '$date')";


    message_with_file();
    mysql_escape_utf8($sql);
    chat_query($sql);
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
        <div class="px-4 pt-5 pb-5 flex justify-center items-center sm:px-0 sticky top-0 bg-white">
            <h1 class="text-5xl font-semibold text-gray-900">Chat</h1>
        </div>
        <div class="border-t border-gray-200 sticky top-[5.5rem]">
        </div>
        <div id="response-messages" class="flex flex-col space-y-4 p-4 overflow-y-auto h-full mb-16">
        </div>
        <form class="flex items-center justify-center w-full max-w-full px-4 mb-3 fixed bottom-0" id="chatForm" action="chat.php" method="POST" enctype="multipart/form-data">
            <label for="chatText" class="sr-only">Chat</label>
            <div class="flex items-center w-full space-x-2">
                <div
                    class="flex-grow flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-blue-600">
                    <textarea name="chatText" id="chatText"
                        class="block w-full py-1.5 pr-3 pl-1 text-xl text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                        required autofocus></textarea>
                    <input type="hidden" name="chatUser" id="chatUser" value="<?php echo $_SESSION['userID']; ?>" />
                </div>
              <div class="flex-shrink-0 flex gap-2">
                <label for="chatFile" class="cursor-pointer w-[60px] h-[60px] inline-flex items-center justify-center rounded-md bg-gray-200 hover:bg-gray-300 text-gray-700">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                  </svg>
                  <span class="sr-only">Attach file</span>
                </label>
                <input type="file" name="chatFile" id="chatFile" class="hidden" onchange="updateFileLabel()" />
                <input type="submit" id="chatSubmit" value="Submit"
                       class="w-[90px] h-[60px] justify-center rounded-md bg-blue-900 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-blue-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:bg-blue-900" />
              </div>
            </div>
          <div id="filePreview" style="display: none;" class="mt-2 p-2 bg-gray-50 rounded-md text-sm text-gray-700 w-full max-w-full">
            <div class="flex items-center justify-between">
              <span id="fileName">No file selected</span>
              <button type="button" onclick="clearFileSelection()" class="text-red-500 hover:text-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>
        </form>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>
<?php
require "db.php";
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        date_default_timezone_set("AMERICA/SAO_PAULO");
        $response = ['success' => false, 'message' => ''];
        $text = $_POST['chatText'];
        $user = $_POST['chatUser'];
        $date = date("Y-m-d H:i:s");

        if (isset($_FILES['chatFile']) && $_FILES['chatFile']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create uploads directory if it doesn’t exist
            }

            $fileName = basename($_FILES['chatFile']['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['chatFile']['tmp_name'], $filePath)) {
                $fileAttachment = $fileName;
                $response['message'] = "File uploaded successfully";
            } else {
                $response['message'] = "Failed to move uploaded file";
                header("Content-Type: application/json");
                echo json_encode($response);
                exit();
            }
        }

        // Append file reference to message text if a file was uploaded
        if (!empty($fileAttachment)) {
            $text .= " [file:" . $fileAttachment . "]";
        }

        if (!empty($text) || !empty($fileAttachment)) {
            $sql = "INSERT INTO messages (Sender, Message, CreatedAt) VALUES ($user, '$text', '$date')";
            if (chat_query($sql)) {
                $response['success'] = true;
                $response['message'] = "Message sent successfully";
                $response['insertMessage'] = "success";
            } else {
                $response['message'] = "Database error";
            }
        } else {
            $response['message'] = "No message or file provided";
        }

        header("Content-Type: application/json");
        echo json_encode($response);
    }
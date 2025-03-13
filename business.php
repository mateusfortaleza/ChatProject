<?php
require 'db.php';

if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $filePath = 'uploads/' . $file;
    if (file_exists($filePath)) {
        $mimeType = mime_content_type($filePath);
        header("Content-Type: $mimeType");
        header("Content-Length: " . filesize($filePath));
        readfile($filePath);
        exit;
    }
    http_response_code(404);
    exit;
}

function get_user($email, $password): array
{
    $sql = "SELECT * FROM user WHERE Email = '$email' AND password = '$password'";
    $result = chat_query($sql);
    return mysqli_fetch_assoc($result);
}

function login_is_valid($user): bool
{
    if (isset($user)) {
        return true;
    } else {
        return false;
    }
}

function message_check_new(): bool
{
    $currentLastMessageDate = get_last_message_date();
    $userLastMessageDate = $_SESSION['userLastMessageDate'];

    if ($currentLastMessageDate > $userLastMessageDate) {
        $_SESSION['userLastMessageDate'] = $currentLastMessageDate;
        return true;
    } else
        return false;
}

function get_last_message_date(): int
{
    $sql = "SELECT MAX(CreatedAt) AS LastMessageDate FROM messages";
    $result = chat_query($sql);
    $arrLastMessageDate = mysqli_fetch_assoc($result);
    return strtotime($arrLastMessageDate['LastMessageDate']);
}

function message_with_file(): void
{
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_FILES["userFile"]) && $_FILES["userFile"]["error"] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['userFile']['tmp_name'];
            $fileName = $_FILES['userFile']['name'];
            $fileSize = $_FILES['userFile']['size'];
            $fileType = $_FILES['userFile']['type'];

            $allowedType = [
                'image/jpeg',       // JPEG images
                'image/png',        // PNG images
                'application/pdf',  // PDF documents
                'text/plain',       // Text files
                'video/mp4',        // MP4 videos
                'video/webm',       // WebM videos
                'video/ogg',        // OGG videos
                'video/mpeg'        // MPEG videos
            ];
            $maxSize = 10485760;
            $uploadDir = 'uploads/';
            $destPath = $uploadDir . basename($fileName);

            if (!in_array($fileType, $allowedType)) {
                echo "Invalid file type.";
            } elseif ($fileSize > $maxSize) {
                echo "File is too big.";
            } elseif (file_exists($destPath)) {
                echo "File already exists.";
            } else {
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    echo "The file " . basename($fileName) . " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            if (isset($_FILES["userFile"])) {
                $errorCode = $_FILES["userFile"]["error"];
                echo "Upload failed. Error code: $errorCode";
            } else {
                echo "No file uploaded.";
            }
        }
    } else {
        echo "Please upload a file";
    }
}

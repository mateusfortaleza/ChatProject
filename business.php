<?php 
require 'db.php';

function get_user($email, $password) {
    $sql = "SELECT * FROM user WHERE Email = '$email' AND password = '$password'";
    $result = chat_query($sql);
    return mysqli_fetch_assoc($result);
}

function login_is_valid($user) {
    if (isset($user)) {
        return true;
    }
    else{
        return false;
    }
}

function message_check_new() {
    $currentLastMessageDate = get_last_message_date();
    $userLastMessageDate = $_SESSION['userLastMessageDate'];

    if ($currentLastMessageDate > $userLastMessageDate) {
        $_SESSION['userLastMessageDate'] = $currentLastMessageDate;
        return true;
    }
    else
        return false;
}

function get_last_message_date() {
    $sql = "SELECT MAX(CreatedAt) AS LastMessageDate FROM messages";
    $result = chat_query($sql);
    $arrLastMessageDate = mysqli_fetch_assoc($result);
    return strtotime($arrLastMessageDate['LastMessageDate']);
}
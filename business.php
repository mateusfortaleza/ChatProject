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

/// Check if there are new messages
function message_check_new() {

    $sql = "SELECT MAX(DATE) AS LastMessageDate FROM messages";
    $rset = chat_query($sql);
    
    $arrMaxDate = mysqli_fetch_assoc($rset);
    $lastMessageDateDatabase = strtotime($arrMaxDate['LastMessageDate']);

    if(!isset($GLOBALS['lastMessageDate'])) {
        $GLOBALS['lastMessageDate'] = $lastMessageDateDatabase;
    };

    $lastMessageDateApp = strtotime($GLOBALS['lastMessageDate']);
    
    if($lastMessageDateDatabase > $lastMessageDateApp) {
        $GLOBALS['lastMessageDate'] = $lastMessageDateDatabase;
        return true;
    } else {
        return false;
    }
}


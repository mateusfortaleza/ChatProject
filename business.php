<?php 
require 'db.php';

function login_is_valid($email, $password) {
    $sql = "SELECT * FROM user WHERE Email = '$email' AND password = '$password'";
    $result = chat_query($sql);
    if ($result) {
        return mysqli_num_rows($result) > 0;
    }
    else
        return false;
}
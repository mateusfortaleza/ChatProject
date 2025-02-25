<?php 
function chat_query($sql) {
    $link = mysqli_connect("127.0.0.1","root","","chat");
    if (!$link) {
        exit("Connection unsuccessfull");
    }
    $result = mysqli_query($link, $sql);
    mysqli_close($link);
    return $result;
}


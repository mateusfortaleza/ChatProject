<?php
function mysql_escape_utf8($string) {
    // Ensure the string is in UTF-8 encoding
    $string = mb_convert_encoding($string, 'UTF-8', 'UTF-8');

    // Escape special characters
    $search  = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
    $replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");

    return str_replace($search, $replace, $string);
}

function chat_query($sql) {
    $link = mysqli_connect("127.0.0.1","root","","chat");
    if (!$link) {
        exit("Connection unsuccessful");
    }
    $result = mysqli_query($link, $sql);
    mysqli_close($link);
    return $result;

}


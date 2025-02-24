<?php
    header('Content-Type: application/json');

    $linkSql = mysqli_connect("127.0.0.1", "root", "", "chat");
    $sqlResult = "SELECT MSG.Message AS MessageText, MSG.Date AS MessageDate, USR.Name AS MessageName FROM messages AS MSG JOIN user AS USR ON MSG.Sender = USR.ID ORDER BY MSG.Date ASC";
    $resultMessages = mysqli_query($linkSql, $sqlResult);
    $arrAllResults = mysqli_fetch_all($resultMessages, MYSQLI_ASSOC);

    mysqli_close($linkSql);

    echo json_encode($arrAllResults);
?>
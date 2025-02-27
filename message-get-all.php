<?php
    header('Content-Type: application/json');

    $sqlResult = "SELECT MSG.Message AS MessageText, MSG.Date AS MessageDate, USR.Name AS MessageName, USR.ID AS MessageUserID FROM messages AS MSG JOIN user AS USR ON MSG.Sender = USR.ID ORDER BY MSG.Date ASC";
    chat_query($sqlResult);
    $resultMessages = chat_query($sqlResult);
    $arrAllResults = mysqli_fetch_all($resultMessages, MYSQLI_ASSOC);
    echo json_encode($arrAllResults);
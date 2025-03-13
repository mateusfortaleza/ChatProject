<?php
require "db.php";

$sqlResult = "SELECT MSG.Message AS MessageText, MSG.CreatedAt AS MessageDate, USR.Name AS MessageName, USR.ID AS MessageUserID FROM messages AS MSG JOIN user AS USR ON MSG.Sender = USR.ID ORDER BY MSG.CreatedAt ASC";
$resultMessages = chat_query($sqlResult);
$arrAllResults = mysqli_fetch_all($resultMessages, MYSQLI_ASSOC);
echo json_encode($arrAllResults);

header('Content-Type: application/json');

<?php
// Create connection
$conn = mysqli_connect("127.0.0.1", 'root', "", "chat");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT MAX(DATE) FROM messages";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "Date: " . $row["date"] . "<br>";
    }
} else {
    echo "No messages found";
}

mysqli_close($conn);
?>
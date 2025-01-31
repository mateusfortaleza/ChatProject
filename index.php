<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <title>Chat</title>
</head>
<body>
    <main>
        <h1>Welcome to the Chat</h1>
        <form action="index.php" method="post">
            <label> Name: 
                <input type="text" name="chatName" id="name">
            </label>
            <label> Email: 
                <input type="email" name="chatEmail" id="email" placeholder="example@example.com" required/>
            </label>
            <label for="password">Password: 
                <input type="password" name="chatPassword" id="password" required>
            </label>
        </form>
        <input type="button" value="Submit" />
    </main>
</body>
</html>
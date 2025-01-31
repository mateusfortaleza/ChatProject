<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form action="register.php" method="post">
        <h1>Register</h1>
        <label>Name: 
            <input type="text" name="chatName" id="name" required>
        </label>
        <label>Email: 
            <input type="email" name="chatEmail" id="email" required>
        </label>
        <label>Password: 
            <input type="password" name="chatPassword" id="password" required>
        </label>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: /socialnet/signin.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>About Page</title>
</head>
<body>
    <div style="margin-bottom:20px;">
        <a href="index.php">Home</a> |
        <a href="setting.php">Setting</a> |
        <a href="profile.php">Profile</a> |
        <a href="about.php">About</a> |
        <a href="signout.php">SignOut</a>
    </div>

    <h2>About Page</h2>

    <p><strong>Student Name:</strong> Le Chi Duc</p>
    <p><strong>Student Number:</strong> 1695112</p>
</body>
</html>

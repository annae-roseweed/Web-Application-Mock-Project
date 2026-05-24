<?php
session_start();
require_once "../includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: /socialnet/signin.php");
    exit();
}

$owner = $_GET["owner"] ?? $_SESSION["username"];

/*
VULNERABLE LAB VERSION

This page is intentionally vulnerable to query-string SQL injection.

Attack surface:
    profile.php?owner=...

Original secure version used:
    SELECT username, fullname, description FROM Account WHERE username = ?

This lab version directly concatenates owner into SQL.
*/

$sql = "SELECT username, fullname, description FROM Account WHERE username = '$owner'";

$result = $conn->query($sql);

if (!$result) {
    die("SQL error: " . $conn->error . "<br><pre>" . htmlspecialchars($sql) . "</pre>");
}

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Profile Page</title>
</head>
<body>
    <div style="margin-bottom:20px;">
        <a href="index.php">Home</a> |
        <a href="setting.php">Setting</a> |
        <a href="profile.php">Profile</a> |
        <a href="about.php">About</a> |
        <a href="signout.php">SignOut</a>
    </div>

    <h2>Profile Page</h2>

    <p style="color:red;">
        <strong>Lab mode:</strong> this page is intentionally vulnerable to UNION-based SQL injection.
    </p>

    <?php if (!empty($users)): ?>
        <?php foreach ($users as $user): ?>
            <div style="border:1px solid #999; padding:10px; margin-bottom:10px;">
                <p><strong>Owner:</strong> <?php echo $user["username"]; ?></p>
                <p><strong>Full Name:</strong> <?php echo $user["fullname"]; ?></p>

                <h3>Profile Page Content</h3>
                <p><?php echo nl2br($user["description"] ?? ""); ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>User not found.</p>
    <?php endif; ?>
</body>
</html>

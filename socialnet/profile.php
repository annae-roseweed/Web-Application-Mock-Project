<?php
session_start();
require_once "../includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: /socialnet/signin.php");
    exit();
}

$owner = $_GET["owner"] ?? $_SESSION["username"];

// Adjust these names if your real table/columns are lowercase
$stmt = $conn->prepare("SELECT username, fullname, description FROM Account WHERE username = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $owner);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
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

    <?php if ($user): ?>
        <p><strong>Owner:</strong> <?php echo htmlspecialchars($user["username"]); ?></p>
        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user["fullname"]); ?></p>

        <h3>Profile Page Content</h3>
        <p><?php echo nl2br(htmlspecialchars($user["description"] ?? "")); ?></p>
    <?php else: ?>
        <p>User not found.</p>
    <?php endif; ?>
</body>
</html>

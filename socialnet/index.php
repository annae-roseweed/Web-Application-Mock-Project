<?php
session_start();
require_once "../includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: /socialnet/signin.php");
    exit();
}

$currentUserId = $_SESSION["user_id"];
$currentusername = $_SESSION["username"];
$currentfullname = $_SESSION["fullname"];

$stmt = $conn->prepare("SELECT id, username, fullname FROM Account WHERE id != ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $currentUserId);
$stmt->execute();

$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Home Page</title>
</head>
<body>
    <div style="margin-bottom:20px;">
        <a href="index.php">Home</a> |
        <a href="setting.php">Setting</a> |
        <a href="profile.php">Profile</a> |
        <a href="about.php">About</a> |
        <a href="signout.php">SignOut</a>
    </div>

    <h2>Home Page</h2>

    <p><strong>Username:</strong> <?php echo htmlspecialchars($currentusername); ?></p>
    <p><strong>Fullname:</strong> <?php echo htmlspecialchars($currentfullname); ?></p>

    <h3>Other Users</h3>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                <?php echo htmlspecialchars($row["username"]); ?>
                -
                <?php echo htmlspecialchars($row["fullname"]); ?>
                -
                <a href="profile.php?owner=<?php echo urlencode($row["username"]); ?>">View Profile</a>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>

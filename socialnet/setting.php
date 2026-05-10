<?php
session_start();
require_once "../includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: /socialnet/signin.php");
    exit();
}

$message = "";
$currentDescription = "";

// Get current description
$stmt = $conn->prepare("SELECT description FROM Account WHERE id = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$currentDescription = $row["description"] ?? "";
$stmt->close();

// Save updated description
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = $_POST["description"] ?? "";

    $stmt = $conn->prepare("UPDATE Account SET description = ? WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("si", $description, $_SESSION["user_id"]);

    if ($stmt->execute()) {
        $message = "Profile updated successfully.";
        $currentDescription = $description;
    } else {
        $message = "Update failed: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Setting Page</title>
</head>
<body>
    <div style="margin-bottom:20px;">
        <a href="index.php">Home</a> |
        <a href="setting.php">Setting</a> |
        <a href="profile.php">Profile</a> |
        <a href="about.php">About</a> |
        <a href="signout.php">SignOut</a>
    </div>

    <h2>Setting Page</h2>

    <?php if ($message != ""): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="setting.php" method="POST">
        <label for="description">Profile Page Content:</label><br>
        <textarea id="description" name="description" rows="8" cols="50"><?php echo htmlspecialchars($currentDescription); ?></textarea><br><br>

        <button type="submit">Save</button>
    </form>
</body>
</html>

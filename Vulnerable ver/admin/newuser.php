<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../includes/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? "";
    $fullname = $_POST["fullname"] ?? "";
    $password = $_POST["password"] ?? "";

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $description = "";

    $stmt = $conn->prepare("INSERT INTO Account (username, fullname, password, description) VALUES (?, ?, ?, ?)");

    if (!$stmt) {
        $message = "Prepare failed: " . $conn->error;
    } else {
        $stmt->bind_param("ssss", $username, $fullname, $hashedPassword, $description);

        if ($stmt->execute()) {
            $message = "New user created successfully.";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New User</title>
</head>
<body>
    <h2>Create New User</h2>

    <?php if ($message != ""): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="newuser.php" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="fullname">Full Name:</label><br>
        <input type="text" id="fullname" name="fullname" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>

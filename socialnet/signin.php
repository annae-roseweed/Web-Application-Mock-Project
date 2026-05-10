<?php
session_start();
require_once "../includes/db.php";

$error = "";

if (isset($_SESSION["user_id"])) {
    header("Location: /socialnet/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    $stmt = $conn->prepare("SELECT id, username, fullname, password FROM Account WHERE username = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["fullname"] = $user["fullname"];

        header("Location: /socialnet/index.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sign In</title>
</head>
<body>
    <h2>Sign In</h2>

    <?php if ($error != ""): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="signin.php" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Sign In</button>
    </form>
</body>
</html>

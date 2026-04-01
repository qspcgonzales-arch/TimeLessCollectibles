<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['currentPassword']) && isset($_POST['newPassword'])) {
    $servername = "";
    $username = "";
    $db_password = "";
    $database = "";
    $conn = new mysqli($servername, $username, $db_password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];

    $email = $_SESSION['email'];
    $query = "SELECT password FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];

        if ($currentPassword === $storedPassword) {
            $updateQuery = "UPDATE users SET password = ? WHERE email = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ss", $newPassword, $email);

            if ($updateStmt->execute()) {
                header("Location: settings.php?success=1");
                exit;
            } else {
                header("Location: settings.php?error=1");
                exit;
            }
        } else {
            header("Location: settings.php?incorrect_password=1");
            exit;
        }
    } else {
        header("Location: settings.php?error=1");
        exit;
    }

    $stmt->close();
    $updateStmt->close();
    $conn->close();
} else {
    header("Location: settings.php");
    exit;
}
?>
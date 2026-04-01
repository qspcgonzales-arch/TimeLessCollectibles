<?php
$token = $_POST["token"];
$token_hash = hash("sha256", $token);
$servername = "";
$username = "";
$password = "";
$database = "";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users WHERE reset_token_hash = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if (!$user) {
    die("Token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("Token has expired");
}

$sql = "UPDATE users
        SET password = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("si", $password, $user_id);

$password = $_POST["password"];
$user_id = $user["id"];

if ($stmt->execute()) {
    header("Location: login.php?success=1");
    exit();
} else {
    echo "Error updating password: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
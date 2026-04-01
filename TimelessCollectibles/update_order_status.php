<?php
$servername = "";
$username = "";
$db_password = "";
$database = "";
$conn = new mysqli($servername, $username, $db_password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$orderId = $_POST['orderId'];
$pending = $_POST['pending'];
$delivering = $_POST['delivering'];
$delivered = $_POST['delivered'];

$orderId = mysqli_real_escape_string($conn, $orderId);
$pending = mysqli_real_escape_string($conn, $pending);
$delivering = mysqli_real_escape_string($conn, $delivering);
$delivered = mysqli_real_escape_string($conn, $delivered);

$sql = "UPDATE user_orders 
        SET pending = '$pending', delivering = '$delivering', delivered = '$delivered' 
        WHERE OrderID = '$orderId'";

if ($conn->query($sql) === TRUE) {
    echo "Order status updated successfully";
} else {
    echo "Error updating order status: " . $conn->error;
}

$conn->close();
?>
<?php
$servername = "";
$username = "";
$db_password = "";
$database = "";
$conn = new mysqli($servername, $username, $db_password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['userId']) && isset($data['products'])) {
    $userId = $data['userId'];
    $products = $data['products'];

    foreach ($products as $product) {
        $productId = $product['productId'];
        $quantity = $product['quantity'];

        $sql = "INSERT INTO user_orders (UserID, ProductID, quantity, pending, delivering, delivered) 
                VALUES ('$userId', '$productId', '$quantity', 1, 0, 0)";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
} else {
    echo "Error: Missing userId or products data";
}

$conn->close();
?>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    error_log("Received POST data: " . print_r($_POST, true)); // This will log the POST data to the PHP error log
    
    session_start();
    if (!isset($_SESSION['email'])) {
        $response = array("status" => "error", "message" => "User is not logged in");
        echo json_encode($response);
        exit;
    }

    $userId = $_POST['user_id'];
    $productId = $_POST['product_id'];
    $servername = "";
    $username = "";
    $db_password = "";
    $database = "";
    $conn = new mysqli($servername, $username, $db_password, $database);

    if ($conn->connect_error) {
        $response = array("status" => "error", "message" => "Database connection failed");
        echo json_encode($response);
        exit;
    }

    $sql = "DELETE FROM cart_items WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        $response = array("status" => "error", "message" => "Prepare failed: (" . $conn->errno . ") " . $conn->error);
        echo json_encode($response);
        exit;
    }

    $stmt->bind_param("is", $userId, $productId);
    
    if (!$stmt) {
        $response = array("status" => "error", "message" => "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
        echo json_encode($response);
        exit;
    }

    if ($stmt->execute()) {
        $response = array("status" => "success", "message" => "Product successfully removed from cart");
        echo json_encode($response);
    } else {
        $response = array("status" => "error", "message" => "Failed to remove product from cart: " . $conn->error);
        echo json_encode($response);
    }

    $stmt->close();
    $conn->close();
} else {
    $response = array("status" => "error", "message" => "Invalid request method");
    echo json_encode($response);
}

?>
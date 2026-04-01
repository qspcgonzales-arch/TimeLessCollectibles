<?php
session_start();

if (isset($_SESSION['email'])) {

    $userEmail = $_SESSION['email'];

    $servername = "";
    $username = "";
    $db_password = "";
    $database = "";
    $conn = new mysqli($servername, $username, $db_password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id FROM users WHERE email = '$userEmail'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userId = $row['id'];

        $productId = $_POST['productId'];

        $check_sql = "SELECT * FROM cart_items WHERE user_id = '$userId' AND product_id = '$productId'";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            $response = array("success" => false, "message" => "Please proceed to your cart to set the quantity.");
            echo json_encode($response);
        } else {
            $sql_insert = "INSERT INTO cart_items (user_id, product_id) VALUES ('$userId', '$productId')";

            if ($conn->query($sql_insert) === TRUE) {
                $response = array("success" => true, "message" => "Product added to cart successfully.");
                echo json_encode($response);
            } else {
                $response = array("success" => false, "message" => "Error adding product to cart: " . $conn->error);
                echo json_encode($response);
            }
        }
    } else {
        $response = array("success" => false, "message" => "Error: User not found.");
        echo json_encode($response);
    }

    $conn->close();
} else {
    $response = array("success" => false, "message" => "Error: User not logged in. Please log in to add products to the cart.");
    echo json_encode($response);
}

?>
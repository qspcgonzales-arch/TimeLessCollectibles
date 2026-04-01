<?php
    $servername = "";
    $username = "";
    $db_password = "";
    $database = "";
    $conn = new mysqli($servername, $username, $db_password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$productId = $_POST['productId'];
$sqlDeleteCartItem = "DELETE FROM cart_items WHERE product_id = '$productId'";
if ($conn->query($sqlDeleteCartItem) === TRUE) {
    $sqlImage = "SELECT image FROM products WHERE ID = '$productId'";
    $resultImage = $conn->query($sqlImage);
    
    if ($resultImage->num_rows > 0) {
        $rowImage = $resultImage->fetch_assoc();
        $imagePath = $rowImage['image'];
        
        if (unlink($imagePath)) {
            $sqlDeleteProduct = "DELETE FROM products WHERE ID = '$productId'";
            if ($conn->query($sqlDeleteProduct) === TRUE) {
                echo "Product deleted successfully.";
            } else {
                echo "Error deleting product: " . $conn->error;
            }
        } else {
            echo "Error deleting image: File not found.";
        }
    } else {
        echo "Error retrieving image: Product not found.";
    }
} else {
    echo "Error deleting cart item: " . $conn->error;
}

$conn->close();
?>
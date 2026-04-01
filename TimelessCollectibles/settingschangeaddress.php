<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newAddress = $_POST['changeAddress'];
    $newCountry = $_POST['changeCountry'];

    if (empty($newAddress)) {
        echo '<script>alert("Please enter a valid address."); window.location.href = "settings.php";</script>';
        exit();
    }

    echo "New Address: " . $newAddress . "<br>";
    echo "New Country: " . $newCountry . "<br>";

    $servername = "";
    $username = "";
    $db_password = "";
    $database = "";
    $conn = new mysqli($servername, $username, $db_password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_email = $_SESSION['email'];

    echo "User Email: " . $user_email . "<br>";

    $sql = "UPDATE users SET";

    if (!empty($newAddress)) {
        $sql .= " address = '$newAddress',";
    }

    if (!empty($newCountry)) {
        $sql .= " country = '$newCountry',";
    }

    $sql = rtrim($sql, ',');

    $sql .= " WHERE email = '$user_email'";

    if ($conn->query($sql) === TRUE) {
        header("Location: settings.php?success=address");
        exit();
    } else {
        header("Location: settings.php?error=address");
        exit();
    }

    $conn->close();
} else {
    header("Location: settings.php");
    exit;
}
?>
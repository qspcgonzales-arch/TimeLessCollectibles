<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['email'];

$pin = mt_rand(100000, 999999);
$expiry = date("Y-m-d H:i:s", time() + 60 * 5); 

$servername = "";
$username = "";
$password = "";
$database = "";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE users
        SET 2FA_Pin = ?,
            2FA_Expire = ?
        WHERE email = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $pin, $expiry, $email);
$stmt->execute();

if ($conn->affected_rows) {

    $mail = require __DIR__ . "/mailer.php";

    $mail->setFrom("TCAdmin101@timelesscollectibles63.shop");
    $mail->addAddress($email);
    $mail->Subject = "Timeless Collectibles 2FA Verification PIN";
    $mail->isHTML(true); 
    $mail->Body = <<<END
    <html>
        <head>
            <title>Email Template</title>
        </head>
        <body style="font-family: Arial, sans-serif; color: rgb(25, 245, 170); background-color: rgb(45, 44, 56); padding: 0; margin: 0;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center" valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" valign="top">
                                    <table width="50%" border="0" cellspacing="0" cellpadding="0" style="border: 10px solid rgb(25, 245, 170); border-radius: 10px;">
                                        <tr>
                                            <td align="center" valign="top">
                                                <img src="https://timelesscollectibles63.shop/assets/img/TC.png" alt="Company Logo" style="max-width: 800px; display: block; margin-bottom: 20px;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top" style="padding: 0 20px;">
                                                <p style="font-size: 18px; font-weight: bold; margin: 0; color: rgb(25, 245, 170);">Hello, user</p>
                                                <p style="font-size: 16px; margin: 10px 0; color: rgb(25, 245, 170);">Your Timeless Collectibles 2FA Verification PIN is: <strong>$pin</strong></p>
                                                <p style="font-size: 16px; margin: 10px 0; color: rgb(25, 245, 170);">This PIN will expire in 5 minutes.</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
    </html>
END;

    try {
        if($mail->send()) {
            $_SESSION['email'] = $email; 
            header("Location: authentication.php"); 
            exit;
        } else {
            echo '<script>alert("Message could not be sent. Mailer error: '.$mail->ErrorInfo.'"); window.location.href = "login.php";</script>';
        }
    } catch (Exception $e) {
        echo '<script>alert("Message could not be sent. Mailer error: '.$e->getMessage().'"); window.location.href = "login.php";</script>';
    }

} else {
    echo '<script>alert("No user found with this email."); window.location.href = "forgot_password.php";</script>';
}

$stmt->close();
$conn->close();
?>
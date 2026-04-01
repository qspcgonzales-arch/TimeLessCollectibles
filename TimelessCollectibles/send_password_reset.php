<?php

$email = $_POST["email"];

$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$servername = "";
$username = "";
$password = "";
$database = "";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE users
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $token_hash, $expiry, $email);
$stmt->execute();

if ($conn->affected_rows) {

    $mail = require __DIR__ . "/mailer.php";

    $mail->setFrom("TCAdmin101@timelesscollectibles63.shop");
    $mail->addAddress($email);
    $mail->Subject = "Timeless Collectibles Account Password Reset";
    $mail->isHTML(true); // Set email format to HTML
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
                                                <p style="font-size: 16px; margin: 10px 0; color: rgb(25, 245, 170);">We received a request to reset your password for your Timeless Collectibles account.</p>
                                                <p style="font-size: 16px; margin: 10px 0; color: rgb(25, 245, 170);">If you initiated this request, please click the button below to reset your password.</p>
                                                <p style="font-size: 16px; margin: 10px 0; color: rgb(25, 245, 170);">If you did not request a password reset, please ignore this email.</p>
                                                <p style="font-size: 16px; margin: 10px 0; color: rgb(25, 245, 170);">Thank you!</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top" style="padding: 20px;">
                                                <a href="https://timelesscollectibles63.shop/reset_password.php?token=$token" style="display: inline-block; padding: 10px 20px; background-color: rgb(45, 44, 56); color: rgb(25, 245, 170); text-decoration: none; border: 1px solid rgb(25, 245, 170); border-radius: 5px;">Reset Password</a>
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
            echo '<script>alert("Message sent, please check your inbox to reset your password."); window.location.href = "login.php";</script>';
        } else {
            echo '<script>alert("Message could not be sent. Mailer error: '.$mail->ErrorInfo.'");</script>';
        }
    } catch (Exception $e) {
        echo '<script>alert("Message could not be sent. Mailer error: '.$e->getMessage().'");</script>';
    }

} else {
    echo '<script>alert("No user found with this email."); window.location.href = "forgot_password.php";</script>';
}

$stmt->close();
$conn->close();
?>
<?php
/**
 * Database Configuration
 * Update these values with your hosting provider's database credentials
 */

// Database connection settings
define('DB_HOST', 'localhost');           // Usually 'localhost' for shared hosting
define('DB_USER', 'your_db_username');    // Replace with your database username
define('DB_PASS', 'your_db_password');    // Replace with your database password
define('DB_NAME', 'your_database_name');  // Replace with your database name
define('DB_PORT', 3306);                  // Usually 3306

// Site settings
define('SITE_URL', 'http://yoursite.infinityfreeapp.com/'); // Update with your domain
define('SITE_NAME', 'Timeless Collectibles');

// Email settings (for PHPMailer)
define('MAILER_HOST', 'your_smtp_host');      // Update with SMTP host
define('MAILER_USER', 'your_email@gmail.com'); // Update with email
define('MAILER_PASS', 'your_app_password');    // Update with app password
define('MAILER_PORT', 587);                    // Usually 587 for TLS

// Create MySQLi connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");

?>

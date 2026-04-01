<?php
session_start();

if(isset($_SESSION['email'])) {
    echo "Email stored in session: " . $_SESSION['email'];
} else {
    echo "Email session variable is not set.";
}
?>
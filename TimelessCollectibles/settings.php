<?php
if (isset($_GET['success']) && $_GET['success'] == 'address') {
    echo '<script>alert("Your address has been changed successfully.");</script>';
} elseif (isset($_GET['error']) && $_GET['error'] == 'address') {
    echo '<script>alert("An error occurred while changing your address. Please try again later.");</script>';
}
?>

<?php
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo '<script>alert("Your password has been changed successfully.");</script>';
}
?>

<?php
if (isset($_GET['incorrect_password']) && $_GET['incorrect_password'] == 1) {
    echo '<script>alert("Incorrect current password.");</script>';
}
?>

<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['email'];

$servername = "";
$username = "";
$db_password = "";
$database = "";
$conn = new mysqli($servername, $username, $db_password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT address, country FROM users WHERE email = '$user_email'";
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing the SQL query: " . $conn->error);
}

$user_address = ""; 
$user_country = ""; // Initialize the variable for country

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (isset($row["address"])) {
        $user_address = $row["address"];
    }
    if (isset($row["country"])) {
        $user_country = $row["country"];
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - Timeless Collectibles</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
    <link rel="stylesheet" href="assets/css/aos.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/Banner-Heading-Image-images.css">

</head>

<body>
    <nav class="navbar navbar-expand-md sticky-top py-3 navbar-dark" id="mainNav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="assets/img/TCgreen.png" alt="TC Logo" class="me-2" style="max-width: 40px;">
                <span>TC</span>
            </a>
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1">
                <span class="visually-hidden">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown"
                            href="#">Products</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="1plushies.php">Plushies</a>
                            <a class="dropdown-item" href="2figurines.php">Action Figurines</a>
                            <a class="dropdown-item" href="3cards.php">Card Collectibles</a>
                            <a class="dropdown-item" href="4cartridges.php">Cds and Cartridges</a>

                            <div class="dropdown-divider"></div>
                        </div>
                    </li>
                </ul>

                <?php
                    session_start();
                    if (isset($_SESSION['email'])) {
                        echo '<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="btn btn-outline-success" href="user_history.php" style="background: rgb(25,245,170);color: rgb(0,0,0);border-color: rgb(25,245,170);margin-right: 10px;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
                                      <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A2 2 0 0 1 4.732 11h5.536a2 2 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
                                    </svg></a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-outline-success" href="usercart.php" style="background: rgb(25,245,170);color: rgb(0,0,0);border-color: rgb(25,245,170);margin-right: 10px;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                    </svg></a>
                                </li>
                                <li class="nav-item">
                                    <form method="post" action="settings.php">
                                        <button class="btn btn-outline-success" type="submit" style="background: rgb(25,245,170);color: rgb(0,0,0);border-color: rgb(25,245,170);margin-right: 10px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                                        <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0"/>
                                        <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z"/>
                                        </svg>
                                        </button>
                                    </form>
                                </li>
                                <li class="nav-item dropdown">
                                    <button class="btn btn-outline-success dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background: rgb(25,245,170);color: rgb(0,0,0);border-color: rgb(25,245,170);margin-right: 10px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                    </svg>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                        <li><span class="dropdown-item-text">' . $_SESSION['email'] . '</span></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><form method="post" action="logout.php"><button class="dropdown-item" type="submit">Logout</button></form></li>
                                        <li><hr class="dropdown-divider"></li>
                                    </ul>
                                </li>
                            </ul>';
                    } else {
                        echo '<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="btn btn-outline-success" href="signup.php" style="background: rgb(25,245,170);color: rgb(0,0,0);border-color: rgb(25,245,170);margin-right: 10px;"> Sign Up</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-outline-success" href="login.php" style="background: rgb(25,245,170);color: rgb(0,0,0);border-color: rgb(25,245,170);margin-right: 10px;">Login</a>
                                </li>
                            </ul>';
                    }
                ?>
            </div>
        </div>
    </nav>

    <section class="py-5" style="margin-bottom: 40px">
        <div class="container py-5">
            <h2 class="fw-bold bounce animated" style="text-align: center; margin-left: 0px; margin-bottom: 32px">
                <span style="color: rgb(25, 245, 170)">User Settings</span>
            </h2>
            <div class="row d-flex justify-content-center">
                <div class="col">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-6 col-xl-4">
                            <div>
                                <form class="p-3 p-xl-4" action="settingschangepassword.php" method="post"
                                    onsubmit="return handlePasswordChange();">
                                    <h3 class="text-center" style="color: rgb(25, 245, 170); font-weight: bold">
                                        Change Password
                                    </h3>
                                    <div class="mb-3">
                                        <input class="form-control" type="password" id="currentPassword"
                                            name="currentPassword" placeholder="Current Password" style="
                      background: rgb(66, 65, 81);
                      border-color: rgb(25, 245, 170);
                      color: rgb(255, 255, 255);
                    " />
                                    </div>
                                    <div class="mb-3">
                                        <input class="form-control" type="password" id="newPassword" name="newPassword"
                                            placeholder="New Password" style="
                      background: rgb(66, 65, 81);
                      border-color: rgb(25, 245, 170);
                      color: rgb(255, 255, 255);
                    " />
                                    </div>
                                    <div>
                                        <button class="btn btn-primary shadow d-block w-100" type="submit"
                                            name="changePasswordBtn" style="
                      background: rgb(25, 245, 170);
                      color: rgb(0, 0, 0);
                      border-color: rgb(25, 245, 170);
                    ">
                                            Confirm
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-4 d-flex justify-content-center justify-content-xl-start">
                            <div class="p-3 p-xl-4">
                                <div class="mb-3">
                                    <div class="d-flex align-items-center p-3">
                                        <div class="bs-icon-md bs-icon-circle bs-icon-primary shadow d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block bs-icon bs-icon-md"
                                            style="background: rgb(25, 245, 170)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                fill="currentColor" viewBox="0 0 16 16" class="bi bi-mailbox"
                                                style="color: var(--bs-emphasis-color)">
                                                <path
                                                    d="M4 4a3 3 0 0 0-3 3v6h6V7a3 3 0 0 0-3-3m0-1h8a4 4 0 0 1 4 4v6a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V7a4 4 0 0 1 4-4m2.646 1A3.99 3.99 0 0 1 8 7v6h7V7a3 3 0 0 0-3-3z">
                                                </path>
                                                <path
                                                    d="M11.793 8.5H9v-1h5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.354-.146l-.853-.854zM5 7c0 .552-.448 0-1 0s-1 .552-1 0a1 1 0 0 1 2 0">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="px-2">
                                            <h6 class="fw-bold mb-0">User Email</h6>
                                            <p class="text-muted mb-0">
                                                <?php echo $_SESSION['email']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center p-3">
                                    <div class="bs-icon-md bs-icon-circle bs-icon-primary shadow d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block bs-icon bs-icon-md"
                                        style="background: rgb(25, 245, 170)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                            fill="currentColor" viewBox="0 0 16 16" class="bi bi-house"
                                            style="color: var(--bs-emphasis-color)">
                                            <path
                                                d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="px-2">
                                        <h6 class="fw-bold mb-0">Home Address</h6>
                                        <?php if (isset($user_address)) : ?>
                                        <p class="text-muted mb-0"><?php echo $user_address; ?></p>
                                        <?php else : ?>
                                        <p class="text-muted mb-0">No address found</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center p-3">
                                    <div class="bs-icon-md bs-icon-circle bs-icon-primary shadow d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block bs-icon bs-icon-md"
                                        style="background: rgb(25, 245, 170)">
                                        <div class="bs-icon-md bs-icon-circle bs-icon-primary shadow d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block bs-icon bs-icon-md"
                                            style="background: rgb(25, 245, 170)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="Black"
                                                class="bi bi-flag" viewBox="0 0 16 16">
                                                <path
                                                    d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12 12 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A20 20 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a20 20 0 0 0 1.349-.476l.019-.007.004-.002h.001M14 1.221c-.22.078-.48.167-.766.255-.81.252-1.872.523-2.734.523-.886 0-1.592-.286-2.203-.534l-.008-.003C7.662 1.21 7.139 1 6.5 1c-.669 0-1.606.229-2.415.478A21 21 0 0 0 3 1.845v6.433c.22-.078.48-.167.766-.255C4.576 7.77 5.638 7.5 6.5 7.5c.847 0 1.548.28 2.158.525l.028.01C9.32 8.29 9.86 8.5 10.5 8.5c.668 0 1.606-.229 2.415-.478A21 21 0 0 0 14 7.655V1.222z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="px-2">
                                        <h6 class="fw-bold mb-0">Country</h6>
                                        <?php if (isset($user_country)) : ?>
                                        <p class="text-muted mb-0"><?php echo $user_country; ?></p>
                                        <?php else : ?>
                                        <p class="text-muted mb-0">No country found</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <form class="p-3 p-xl-4" method="post" action="settingschangeaddress.php"
                                style="margin-top: 5px">
                                <h3 class="text-center" style="color: rgb(25, 245, 170); font-weight: bold">
                                    Change Address
                                </h3>
                                <div class="mb-3">
                                    <input class="form-control" type="text" id="changeAddress" name="changeAddress"
                                        placeholder="Address" style="
                    background: rgb(66, 65, 81);
                    border-color: rgb(25, 245, 170);
                    color: rgb(255, 255, 255);
                  " />
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" type="text" id="changeCountry" name="changeCountry"
                                        placeholder="Country" style="
                    background: rgb(66, 65, 81);
                    border-color: rgb(25, 245, 170);
                    color: rgb(255, 255, 255);
                  " />
                                </div>
                                <div>
                                    <button class="btn btn-primary shadow d-block w-100" type="submit" style="
                    background: rgb(25, 245, 170);
                    color: rgb(0, 0, 0);
                    border-color: rgb(25, 245, 170);
                  ">
                                        Confirm
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <footer class="bg-dark">
        <div class="container py-4 py-lg-5">
            <div class="text-muted d-flex justify-content-between align-items-center pt-3">
                <p class="mb-0">Copyright © 2024 Timeless Collectibles</p>
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                            fill="currentColor" viewBox="0 0 16 16" class="bi bi-facebook">
                            <path
                                d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951">
                            </path>
                        </svg></li>
                    <li class="list-inline-item"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                            fill="currentColor" viewBox="0 0 16 16" class="bi bi-twitter">
                            <path
                                d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15">
                            </path>
                        </svg></li>
                    <li class="list-inline-item"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                            fill="currentColor" viewBox="0 0 16 16" class="bi bi-instagram">
                            <path
                                d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334">
                            </path>
                        </svg></li>
                </ul>
            </div>
        </div>
    </footer>

    <script>
    function handlePasswordChange() {
        var currentPassword = document.getElementById("currentPassword").value.trim();
        var newPassword = document.getElementById("newPassword").value.trim();

        if (currentPassword === "" && newPassword === "") {
            alert("Please fill the required fields first.");
            return false;
        }


        if (currentPassword === "") {
            alert("Please enter your current password.");
            return false;
        }


        if (newPassword === "") {
            alert("Your new password cannot be empty.");
            return false;
        }

        if (newPassword.toLowerCase() === currentPassword.toLowerCase()) {
            alert("You can't use the same password as your old one.");
            return false;
        }

        return true;
    }
    </script>
    <script>
    $(document).ready(function() {
        $("#changeAddressBtn").click(function() {
            var newAddress = $("#changeAddressInput").val();
            var newCountry = $("#changeCountryInput").val();

            if (newAddress.trim() === "") {
                alert("Please enter a valid address.");
                return;
            }

            $.ajax({
                url: "settingschangeaddress.php",
                method: "POST",
                data: {
                    changeAddress: newAddress,
                    changeCountry: newCountry
                },
                success: function(response) {
                    window.location.href = "settings.php";
                },
                error: function() {
                    alert(
                        "An error occurred while changing the address. Please try again later.");
                }
            });
        });
    });
    </script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/bold-and-dark.js"></script>
</body>

</html>
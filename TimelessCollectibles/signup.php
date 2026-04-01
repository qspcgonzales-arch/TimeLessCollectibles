<?php
    $servername = "";
    $username = "";
    $db_password = "";
    $database = "";
    $conn = new mysqli($servername, $username, $db_password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['email']) || empty($_POST['password']) || empty($_POST['address']) || empty($_POST['country'])) {
        echo "<script>alert('Error: All fields are required');</script>";
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $country = $_POST['country'];

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Error: Invalid email format');</script>";
        } else {
            $checkQuery = "SELECT * FROM users WHERE email = ?";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->bind_param("s", $email);
            $checkStmt->execute();
            $result = $checkStmt->get_result();

            if ($result->num_rows > 0) {
                echo "<script>alert('A user with this email already exists, please reset your password.');</script>";
            } else {
                // Insert new user
                $sql = "INSERT INTO users (email, password, address, country) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $email, $password, $address, $country);

                if ($stmt->execute()) {
                    echo "<script>alert('Registration Complete! Please proceed to login');</script>";
                } else {
                    echo "<script>alert('Error: " . $sql . "\\n" . $conn->error . "');</script>";
                }
            }
        }
    }
}

$conn->close();
?>




<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Sign up - Timeless Collectibles</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/Banner-Heading-Image-images.css">
    <style>
    footer.bg-dark {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: #333;
        color: white;
        text-align: center;
        padding: 5px;
    }
    </style>
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
                    <li class="nav-item"><a class="nav-link active" href="about.php">About</a></li>
                    </li>
                </ul>

                <?php
                    session_start();
                    if (isset($_SESSION['email'])) {
                        echo '<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
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
                                    <a class="btn btn-outline-success" href="login.php" style="background: rgb(25,245,170);color: rgb(0,0,0);border-color: rgb(25,245,170);margin-right: 10px;">Login</a>
                                </li>
                            </ul>';
                    }
                ?>

            </div>
        </div>
    </nav>

    <section class="py-5">
        <div class="container py-5">
            <div class="row mb-4 mb-lg-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <p class="fw-bold text-success mb-2">Sign up and start collecting</p>
                    <h2 class="fw-bold">Welcome, Adventure awaits!</h2>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-body text-center d-flex flex-column align-items-center">
                            <div class="bs-icon-xl bs-icon-circle bs-icon-primary shadow bs-icon my-4"
                                style="background: rgb(25,245,170);"><svg xmlns="http://www.w3.org/2000/svg" width="1em"
                                    height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-person"
                                    style="color: rgb(0,0,0);">
                                    <path
                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664z">
                                    </path>
                                </svg></div>
                            <form method="post" onsubmit="return validateForm()">
                                <div class="mb-3"><input class="form-control" type="email" name="email"
                                        placeholder="Email"
                                        style="background: rgb(66,65,81);color: var(--bs-body-color);border-color: #19f5aa;">
                                </div>
                                <div class="mb-3"><input class="form-control" type="password" id="password"
                                        name="password" placeholder="Password"
                                        style="background: rgb(66,65,81);color: var(--bs-btn-disabled-color);border-color: #19f5aa;">
                                </div>
                                <div class="mb-3"><input class="form-control" type="password" id="confirmPassword"
                                        placeholder="Confirm Password"
                                        style="background: rgb(66,65,81);color: var(--bs-btn-disabled-color);border-color: #19f5aa;">
                                </div>
                                <div style="margin-bottom: -19px;padding-bottom: 17px;height: 46.7812px;"><input
                                        class="form-control" type="text" name="address"
                                        style="background: rgb(66,65,81);border-color: rgb(25,245,170);;color:rgb(255,255,255);"
                                        placeholder="Address"></div>
                                <div
                                    style="margin-bottom: -19px;height: 46.7812px;padding-bottom: 0px;padding-top: 0px;">
                                    <input class="form-control" type="text" name="country"
                                        style="background: rgb(66,65,81);border-color: rgb(25,245,170);margin-top: 37px;;color:rgb(255,255,255);"
                                        placeholder="Country"></div>
                                <div class="mb-3"><button class="btn btn-primary shadow d-block w-100" type="submit"
                                        style="background: rgb(25,245,170);border-color: rgb(25,245,170);color: var(--bs-emphasis-color);margin-top: 31px;;color:rgb(255,255,255);">Sign
                                        up</button></div>
                                <p class="text-muted">Already have an account?&nbsp;<a href="login.php">Log in</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/bold-and-dark.js"></script>
</body>

</html>
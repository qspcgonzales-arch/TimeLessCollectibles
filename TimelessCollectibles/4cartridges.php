<?php

$servername = "";
$username = "";
$password = "";
$database = "";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$category = 4;
$sql = "SELECT * FROM products WHERE prodcategory = $category";
$result = $conn->query($sql);

?>


<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Products - Timeless Collectibles</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/Banner-Heading-Image-images.css">

    <style>
    .card-text {
        max-height: 100px;
        overflow: auto;
        text-overflow: ellipsis;
    }

    ::-webkit-scrollbar {
        width: 12px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: rgb(25, 245, 170);
    }

    ::-webkit-scrollbar-track {
        background-color: rgb(45, 44, 56);
    }

    scrollbar-color: rgb(25, 245, 170) rgb(45, 44, 56);
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
    <div class="col-md-8 col-xl-6 text-center mx-auto">
        <h1 class="fw-bold bounce animated" style="color: rgb(25, 245, 170);">Cds And Cartridges</h1>
        <p class="text-muted">"Get your original copy of the brand new releases!"</p>
    </div>
    <section class="py-5">
        <div class="container py-5">
            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Product name or brand"
                style="background-color: rgb(39,38,46); border-color: rgb(25,245,170); color: rgb(25,245,170); font-size: 14px;">

            <div id="cartridgesContainer" class="row">
                <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                <div class="col-lg-4 mb-4 cartridge-item">
                    <div class="card" style="border: 5px solid rgb(25, 245, 170); border-radius: 10px;">
                        <img class="card-img-top w-100 d-block"
                            src="uploads/<?php echo str_replace(' ', '', $row['prodname']) . '.' . pathinfo($row['image'], PATHINFO_EXTENSION); ?>"
                            width="424" height="447" alt="<?php echo $row['prodname']; ?>"
                            style="border-radius: 5px 5px 0 0;">
                        <div class="card-body">
                            <h4 class="card-title" style="text-align: center;"><?php echo $row['prodname']; ?></h4>
                            <p class="card-text"><?php echo $row['description']; ?></p>
                            <button class="btn btn-primary purchase-btn" type="button"
                                data-product-id="<?php echo $row['ID']; ?>"
                                style="background: rgb(25,245,170); color: rgb(0,0,0); border-color: rgb(25,245,170);">₱<?php echo $row['price']; ?></button>
                        </div>
                    </div>
                </div>
                <?php
                }
            } else {
                echo "No products found in the 'Cartridges' category.";
            }

            $conn->close();
            ?>
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
    document.addEventListener('DOMContentLoaded', function() {

        var purchaseButtons = document.querySelectorAll('.purchase-btn');

        purchaseButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var isLoggedIn = <?php echo isset($_SESSION['email']) ? 'true' : 'false'; ?>;
                if (!isLoggedIn) {
                    alert('Please sign up or login to make a purchase');
                } else {
                    var productId = button.getAttribute('data-product-id');
                    var confirmed = confirm('Do you want to add this product to your cart?');
                    if (confirmed) {
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', 'add_to_cart.php', true);
                        xhr.setRequestHeader('Content-Type',
                            'application/x-www-form-urlencoded');
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    var response = JSON.parse(xhr.responseText);
                                    if (response.success) {
                                        alert('Product has been added to your cart.');
                                    } else {
                                        alert('You have already added this, ' + response
                                            .message);
                                    }
                                } else {
                                    alert('Error: ' + xhr.status);
                                }
                            }
                        };
                        xhr.send('productId=' + productId);
                    }
                }
            });
        });
    });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var searchInput = document.getElementById('searchInput');
        var cartridgesContainer = document.getElementById('cartridgesContainer');

        searchInput.addEventListener('input', function() {
            var filter = searchInput.value.toLowerCase();
            var cartridges = cartridgesContainer.getElementsByClassName('cartridge-item');

            Array.from(cartridges).forEach(function(cartridge) {
                var title = cartridge.querySelector('.card-title').textContent.toLowerCase();
                var description = cartridge.querySelector('.card-text').textContent
                .toLowerCase();
                if (title.includes(filter) || description.includes(filter)) {
                    cartridge.style.display = '';
                } else {
                    cartridge.style.display = 'none';
                }
            });
        });
    });
    </script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/bold-and-dark.js"></script>
</body>

</html>
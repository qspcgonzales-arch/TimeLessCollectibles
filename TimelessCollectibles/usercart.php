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
    <link rel="stylesheet" href="assets/css/scroller.css">
    <link rel="stylesheet" href="assets/css/buttons.css">

    <style>
    #productTable th,
    #productTable td {
        color: rgb(25, 245, 170);
    }

    #productTable {
        color: rgb(25, 245, 170);
        margin-bottom: 20px;
        border-collapse: collapse;
        width: 100%;
    }

    #productTable th,
    #productTable td {
        padding: 0.5rem;
        font-size: 14px;
    }

    #productTable .btn {
        background-color: rgb(25, 245, 170);
        color: black;
        padding: 0.6rem 0.6rem;
        font-size: 14px;
    }

    .table-container {
        max-height: 720px;
        overflow-y: auto;
        border: 1px solid rgba(25, 245, 170, 1.0);
        border-radius: 20px;
        padding: 50px;
    }

    .btn.btn-danger:hover {
        background-color: red !important;
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
    <h2 class="fw-bold bounce animated" style="text-align: center;margin-left: 0px;margin-bottom: 32px;"><span
            style="color: rgb(25, 245, 170);">Your Cart</span></h2>
    <div class="container mt-4">
        <input type="text" id="searchInputUserCart" class="form-control mb-3" placeholder="Search by name or category"
            style="background-color: rgb(39,38,46); border-color: rgb(25,245,170); color: rgb(25,245,170); font-size: 14px;">
    </div>

    <?php

$servername = "";
$username = "";
$db_password = "";
$database = "";
$conn = new mysqli($servername, $username, $db_password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    $sqlUserId = "SELECT id FROM users WHERE email = '$email'";
    $resultUserId = $conn->query($sqlUserId);

    if ($resultUserId->num_rows > 0) {
        $rowUserId = $resultUserId->fetch_assoc();
        $userId = $rowUserId['id'];

        $sqlProductIds = "SELECT product_id FROM cart_items WHERE user_id = $userId";
        $resultProductIds = $conn->query($sqlProductIds);

        if ($resultProductIds->num_rows > 0) {
            $products = [];

            while ($rowProductIds = $resultProductIds->fetch_assoc()) {
                $productId = $rowProductIds['product_id'];

                $sqlProductDetails = "SELECT * FROM products WHERE ID = '$productId'";
                $resultProductDetails = $conn->query($sqlProductDetails);

                if ($resultProductDetails->num_rows > 0) {
                    $productDetails = $resultProductDetails->fetch_assoc();

                    switch ($productDetails['prodcategory']) {
                        case 1:
                            $productDetails['category'] = 'Plushie';
                            break;
                        case 2:
                            $productDetails['category'] = 'Action Figurine';
                            break;
                        case 3:
                            $productDetails['category'] = 'Card';
                            break;
                        case 4:
                            $productDetails['category'] = 'CD/Cartridge';
                            break;
                        default:
                            $productDetails['category'] = 'Unknown';
                    }

                    $products[] = $productDetails; 
                } else {
                    echo '<script>alert("Product with ID ' . $productId . ' not found");</script>';
                }
            }

$tableHeader = <<<HTML
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="table-container" style="max-height: 628px; margin-bottom: 10px; overflow-y: auto;">
                <table class="table table-striped" id="productTable" style="width: 100%;">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;">Checkout</th>
                            <th scope="col" style="width: 10%;">Product Picture</th>
                            <th scope="col" style="width: 15%;">Product Name</th>
                            <th scope="col" style="width: 40%;">Product Description</th>
                            <th scope="col" style="width: 15%;">Product Category</th>
                            <th scope="col" style="width: 10%;">Price</th>
                            <th scope="col" style="width: 10%;">Quantity</th>
                            <th scope="col" style="width: 20%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
HTML;
echo $tableHeader;

$totalAmount = 0;

foreach ($products as $product) {
    echo '<tr>';
    echo '<td style="vertical-align: middle;"><input type="checkbox" class="checkout-toggle" data-product-id="' . $product['ID'] . '" data-product-price="' . $product['price'] . '"></td>';
    echo '<td style="vertical-align: middle;"><img src="' . $product['image'] . '" alt="Product Image" style="max-width: 100px; border: 2px solid rgb(25, 245, 170); border-radius: 10px;"></td>';
    echo '<td style="vertical-align: middle;">' . $product['prodname'] . '</td>';
    echo '<td style="vertical-align: middle; max-width: 200px; overflow: hidden; text-overflow: ellipsis; font-size: 10px;;">' . $product['description'] . '</td>';
    echo '<td style="vertical-align: middle;">' . $product['category'] . '</td>';
    echo '<td style="vertical-align: middle;">₱' . $product['price'] . '</td>';
    
    echo '<td style="vertical-align: middle;"><select class="quantity-select" data-product-price="' . $product['price'] . '">';
    for ($i = 1; $i <= 5; $i++) {
        echo '<option value="' . $i . '">' . $i . '</option>';
    }
    echo '</select></td>';
    
    echo '<td style="vertical-align: middle;"><button class="btn btn-danger" onclick="confirmRemove(this)" data-product-id="' . $product['ID'] . '" style="background: rgb(25,245,170); color: rgb(0,0,0); border-color: rgb(25,245,170);">Remove</button></td>';
    
    echo '</tr>';
    
    $totalAmount += $product['price'];
}

echo '</tbody></table></div>';


?>

    <div class="row row-cols-1 row-cols-md-2 justify-content-center">
        <div class="col mb-4">
            <div class="card"
                style="max-width: 1000px; margin-left: auto; background-color: rgb(39,38,46); border: 2px solid rgb(25, 245, 170);">
                <div class="card-body text-center px-4 py-3 px-md-5"
                    style="border-radius: 19px; display: flex; justify-content: space-around; align-items: center;">
                    <div style="text-align: left; margin-right: 10px;">
                        <h6 class="fw-bold card-title mb-3" style="font-size: 16px; color: white;">Total Amount:</h6>
                        <p class="fw-bold" id="total-amount" style="color: rgb(25,245,170); font-size: 18px;">
                            ₱<?php echo number_format($totalAmount, 2); ?></p>
                    </div>
                    <div id="paypal-button-container" style="max-width: 150px;"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function(event) {
        const checkoutToggles = document.querySelectorAll('.checkout-toggle');

        checkoutToggles.forEach(function(toggle) {
            toggle.addEventListener('change', function() {
                updateTotalAmount();
            });
        });

        function updateTotalAmount() {
            let totalAmount = 0;
            checkoutToggles.forEach(function(toggle) {
                if (toggle.checked) {
                    const price = parseFloat(toggle.getAttribute('data-product-price'));
                    totalAmount += price;
                }
            });
            document.getElementById('total-amount').textContent = '₱' + totalAmount.toFixed(2);
            return totalAmount;
        }

        updateTotalAmount();
    });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function(event) {
        const checkoutToggles = document.querySelectorAll('.checkout-toggle');
        const quantitySelects = document.querySelectorAll('.quantity-select');

        checkoutToggles.forEach(function(toggle) {
            toggle.addEventListener('change', function() {
                updateTotalAmount();
            });
        });

        quantitySelects.forEach(function(select) {
            select.addEventListener('change', function() {
                updateTotalAmount();
            });
        });

        function updateTotalAmount() {
            let totalAmount = 0;
            quantitySelects.forEach(function(select, index) {
                if (checkoutToggles[index].checked) {
                    const price = parseFloat(select.getAttribute('data-product-price'));
                    const quantity = parseInt(select.value);
                    totalAmount += price * quantity;
                }
            });
            document.getElementById('total-amount').textContent = '₱' + totalAmount.toFixed(2);
            return totalAmount;
        }

        updateTotalAmount();

        paypal.Buttons({
            createOrder: function(data, actions) {
                const amount = updateTotalAmount();
                if (amount <= 0) {
                    alert("Please select a product to check out first.");
                    return false;
                }
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: amount
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    console.log('Transaction completed by ' + details.payer.name
                    .given_name);
                    alert(
                    "Payment successful! Thank you for choosing Timeless Collectible");
                    const userId = <?php echo $userId; ?>;
                    const selectedProducts = [];
                    checkoutToggles.forEach(function(toggle, index) {
                        if (toggle.checked) {
                            const productId = toggle.getAttribute(
                            'data-product-id');
                            const quantity = quantitySelects[index].value;
                            selectedProducts.push({
                                productId: productId,
                                quantity: quantity
                            });
                        }
                    });

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'user_order_process.php');
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            console.log('Order processed successfully.');

                            window.location.href = 'usercart.php?message=' +
                                encodeURIComponent(xhr.responseText);
                        } else {
                            console.error('Failed to process order.');
                        }
                    };
                    xhr.send(JSON.stringify({
                        userId: userId,
                        products: selectedProducts
                    }));
                });
            },
            onCancel: function(data) {
                console.log('Payment cancelled');
                alert("Payment cancelled");
            },
            onError: function(err) {
                console.log('An error occurred:', err);
            }
        }).render('#paypal-button-container');
    });
    </script>








    <?php
        } else {
            echo '<script>alert("You have no items in your cart.");</script>';
        }
    } else {
        echo '<script>alert("ERROR: User not found");</script>';
    }
} else {

    echo '<script>alert("ERROR: User is not logged in");</script>';
}

$conn->close();
?>

    <script>
    function confirmRemove(button) {
        var productId = button.getAttribute('data-product-id');

        var userId = <?php echo $userId; ?>;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_from_cart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        alert("Product successfully removed from cart");
                        location.reload();
                    } else {
                        alert("Error: " + response.message);
                    }
                } else {
                    alert("Error: Failed to send AJAX request");
                }
            }
        };
        xhr.send('user_id=' + userId + '&product_id=' + productId);
    }
    </script>






    <script>
    function filterTableUserCart() {
        var input, filter, table, tr, tdName, tdCategory, i, txtValueName, txtValueCategory;
        input = document.getElementById("searchInputUserCart");
        filter = input.value.toLowerCase();
        table = document.getElementById("productTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            tdName = tr[i].getElementsByTagName("td")[1];
            tdCategory = tr[i].getElementsByTagName("td")[3];
            if (tdName && tdCategory) {
                txtValueName = tdName.textContent || tdName.innerText;
                txtValueCategory = tdCategory.textContent || tdCategory.innerText;
                if (txtValueName.toLowerCase().indexOf(filter) > -1 || txtValueCategory.toLowerCase().indexOf(filter) >
                    -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
    </script>

    <script>
    document.getElementById("searchInputUserCart").addEventListener("keyup", filterTableUserCart);
    </script>


    <script
        src="https://www.paypal.com/sdk/js?client-id=AbTiWjRBr_yUJvJ5DHdODxf4yYxgB4uhHoIcd0VqMyfhGu5zXRZRRUUQqsDSKzGHrC-uSZQMX_-PLmjv&disable-funding=card">
    </script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/bold-and-dark.js"></script>
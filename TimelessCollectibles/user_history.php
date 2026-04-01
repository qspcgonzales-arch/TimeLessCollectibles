<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$servername = "";
$username = "";
$db_password = "";
$database = "";
$conn = new mysqli($servername, $username, $db_password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email'];

?>


<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>User Order History - Timeless Collectibles</title>
    <title>Home - Timeless Collectibles</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/Banner-Heading-Image-images.css">
    <link rel="stylesheet" href="assets/css/Contact-Details-icons.css">
    <link rel="stylesheet" href="assets/css/scroller.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    <style>
    #orderTable th,
    #orderTable td {
        color: rgb(25, 245, 170);
    }

    #orderTable {
        color: rgb(25, 245, 170);
        margin-bottom: 20px;
        border-collapse: collapse;
        width: 100%;
    }

    #orderTable th,
    #orderTable td {
        padding: 0.5rem;
        font-size: 14px;
    }

    #orderTable .btn {
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

    #orderTable th,
    #orderTable td {
        padding: 20px;
    }

    .status-column {}

    .status-pending {
        color: red;
    }

    .status-transit {
        color: yellow;
    }

    .status-delivered {
        color: green;
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
                </ul>

                <?php
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

    <div class="container mt-4">
        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search by name or category"
            style="background-color: rgb(39, 38, 46); border-color: rgb(25, 245, 170); color: rgb(25, 245, 170); font-size: 14px;">
    </div>

    <div class="table-container">
        <table class='table table-striped' id='orderTable'>
            <thead>
                <tr>
                    <th scope='col'>Product Image</th>
                    <th scope='col'>Product Name</th>
                    <th scope='col'>Quantity</th>
                    <th scope='col'>Email</th>
                    <th scope='col'>Address</th>
                    <th scope='col'>Country</th>
                    <th scope='col'>Status</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $sql = "SELECT uo.*, p.prodname, p.image, u.email, u.address, u.country 
                        FROM user_orders uo 
                        JOIN products p ON uo.ProductID = p.ID 
                        JOIN users u ON uo.UserID = u.id 
                        WHERE u.email = '$email'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output orders
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>";
                        echo "<img src='" . $row['image'] . "' alt='Product Image' style='max-width: 100px; border: 2px solid rgb(25, 245, 170); border-radius: 10px;'>";
                        echo "</td>";

                        echo "<td>";
                        echo $row['prodname'];
                        echo "</td>";

                        echo "<td>";
                        echo $row['quantity'];
                        echo "</td>";

                        echo "<td>";
                        echo $row['email'];
                        echo "</td>";

                        echo "<td>";
                        echo $row['address'];
                        echo "</td>";

                        echo "<td>";
                        echo $row['country'];
                        echo "</td>";

                        echo "<td class='status-column'>";
                        if ($row['pending'] == 1) {
                            echo "<span class='status-pending'>Pending</span><br>";
                        }
                        if ($row['delivering'] == 1) {
                            echo "<span class='status-transit'>In Transit</span><br>";
                        }
                        if ($row['delivered'] == 1) {
                            echo "<span class='status-delivered'>Delivered</span><br>";
                        }
                        echo "</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No orders found.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/bold-and-dark.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#searchInput').on('input', function() {
            let searchText = $(this).val().toLowerCase();
            filterOrders(searchText);
        });
    });

    function filterOrders(searchText) {
        $('#orderTable tbody tr').each(function() {
            let productName = $(this).find('td:eq(1)').text().toLowerCase();
            let email = $(this).find('td:eq(3)').text().toLowerCase();
            let status = $(this).find('.status-column').text().toLowerCase();

            if (productName.includes(searchText) || email.includes(searchText) || status.includes(searchText)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
    </script>

</body>

</html>
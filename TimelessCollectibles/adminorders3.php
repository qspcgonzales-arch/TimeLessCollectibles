<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Admin Orders - Timeless Collectibles</title>
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
        <div class="container"><a class="navbar-brand d-flex align-items-center" href="/">
                <a class="navbar-brand d-flex align-items-center" href="/">
                    <img src="assets/img/TCgreen.png" alt="TC Logo" class="me-2" style="max-width: 40px;">
                    <span>TC</span>
                </a></span>
                <h1 class="fw-bold bounce animated" style="margin-left: 50px;"><span
                        style="color: rgb(25, 245, 170);">Admin Access</span></h1>
            </a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1" disabled><span
                    class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">

                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="btn btn-primary" role="button" data-bss-hover-animate="flash"
                            style="color: rgb(0,0,0);background: rgb(25,245,170);border-color: rgb(25,245,170);"
                            href="adminremove2.php">Remove Product</a></li>
                    &nbsp
                    &nbsp
                    &nbsp
                    <li class="nav-item"><a class="btn btn-primary" role="button" data-bss-hover-animate="flash"
                            style="color: rgb(0,0,0);background: rgb(25,245,170);border-color: rgb(25,245,170);"
                            href="admin.php">Add Product</a></li>
                </ul>
                <form method="post" action="logout.php">
                    <button class="btn btn-primary" type="submit" role="button" data-bss-hover-animate="flash"
                        style="color: rgb(0,0,0); background: rgb(25,245,170); border-color: rgb(25,245,170);">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search by name or category"
            style="background-color: rgb(39,38,46); border-color: rgb(25,245,170); color: rgb(25,245,170); font-size: 14px;">
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
                    <th scope='col'>Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php
            $servername = "";
            $username = "";
            $db_password = "";
            $database = "";
            $conn = new mysqli($servername, $username, $db_password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT uo.*, p.prodname, p.image, u.email, u.address, u.country 
                    FROM user_orders uo 
                    JOIN products p ON uo.ProductID = p.ID 
                    JOIN users u ON uo.UserID = u.id";
            $result = $conn->query($sql);

            if (!$result) {
                die("SQL query failed: " . $conn->error);
            }

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


                    echo "<td>"; 

                    echo "<button class='btn btn-primary btn-sm' onclick='setStatus(\"" . $row['OrderID'] . "\", \"pending\")'>Pending</button>";
                    echo "<button class='btn btn-warning btn-sm' onclick='setStatus(\"" . $row['OrderID'] . "\", \"delivering\")'>In Transit</button>";
                    echo "<button class='btn btn-success btn-sm' onclick='setStatus(\"" . $row['OrderID'] . "\", \"delivered\")'>Delivered</button>";
                    echo "</td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No orders found.</td></tr>";
            }

            $conn->close();
            ?>
            </tbody>
        </table>
    </div>

    <script>
    function setStatus(orderId, status) {
        if (!orderId || !status) {
            console.error("Invalid orderId or status");
            return;
        }

        let pending = 0;
        let delivering = 0;
        let delivered = 0;

        if (status === "pending") {
            pending = 1;
        } else if (status === "delivering") {
            delivering = 1;
        } else if (status === "delivered") {
            delivered = 1;
        }

        $.ajax({
            type: 'POST',
            url: 'update_order_status.php',
            data: {
                orderId: orderId,
                pending: pending,
                delivering: delivering,
                delivered: delivered
            },
            success: function(response) {
                $('#orderTable').load('adminorders3.php #orderTable');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
    </script>

    <script>
    $(document).ready(function() {
        $('#searchInput').on('input', function() {
            let searchText = $(this).val().toLowerCase();
            filterOrders(searchText);
        });
    });

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


    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/bold-and-dark.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</body>

</html>
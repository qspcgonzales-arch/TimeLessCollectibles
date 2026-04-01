    <!DOCTYPE html>
    <html data-bs-theme="light" lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
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
                </a>></span>
                <h1 class="fw-bold bounce animated" style="margin-left: 50px;"><span
                        style="color: rgb(25, 245, 170);">Admin Access</span></h1></a><button data-bs-toggle="collapse"
                    class="navbar-toggler" data-bs-target="#navcol-1" disabled><span class="visually-hidden">Toggle
                        navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">

                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="btn btn-primary" role="button" data-bss-hover-animate="flash"
                                style="color: rgb(0,0,0);background: rgb(25,245,170);border-color: rgb(25,245,170);"
                                href="adminorders3.php">Customer Orders</a></li>
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



        <?php

    $servername = "";
    $username = "";
    $db_password = "";
    $database = "";
    $conn = new mysqli($servername, $username, $db_password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    ?>


        <div class="table-container">
            <table class='table table-striped' id='productTable'>
                <thead>
                    <tr>
                        <th scope='col'>Product Picture</th>
                        <th scope='col'>Product ID</th>
                        <th scope='col'>Product Name</th>
                        <th scope='col'>Product Category</th>
                        <th scope='col'>Price</th>
                        <th scope='col'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $image_path = 'uploads/' . str_replace(' ', '', $row['prodname']) . '.' . pathinfo($row['image'], PATHINFO_EXTENSION);
            echo "<tr>";
            echo "<td>";
            if (file_exists($image_path)) {
                echo "<img src='" . $image_path . "' alt='Product Image' style='max-width: 100px; border: 2px solid rgb(25, 245, 170); border-radius: 10px;'>";
            } else {
                echo "No Image";
            }
            echo "</td>";
            echo "<td style='color: rgb(25,245,170);'>" . $row['ID'] . "</td>";
            echo "<td style='color: rgb(25,245,170);'>" . $row['prodname'] . "</td>";
            $category = "";
            switch ($row['prodcategory']) {
                case 1:
                    $category = "Plushie";
                    break;
                case 2:
                    $category = "Action Figurine";
                    break;
                case 3:
                    $category = "Card";
                    break;
                case 4:
                    $category = "CD/Cartridge";
                    break;
                default:
                    $category = "Unknown";
            }
            echo "<td style='color: rgb(25,245,170);'>" . $category . "</td>";
            echo "<td style='color: rgb(25,245,170);'>₱" . $row['price'] . "</td>";
            echo "<td>";
            echo "<button class='btn btn-danger' onclick='confirmRemove(\"" . $row['ID'] . "\")' style='background-color: rgb(25,245,170); border-color: rgb(25,245,170); color: black;'>Remove</button>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No products found.</td></tr>";
    }
    ?>

                </tbody>
            </table>
        </div>
        </tbody>
        </div>

        <script>
        function confirmRemove(productId) {
            var confirmDelete = confirm("Are you sure you want to remove product with ID " + productId + "?");
            if (confirmDelete) {
                $.ajax({
                    type: 'POST',
                    url: 'delete_product.php',
                    data: {
                        productId: productId
                    },
                    success: function(response) {
                        $('#productTable').load('adminremove2.php #productTable');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                console.log("Deletion of product with ID " + productId + " canceled.");
            }
        }
        </script>

        <script>
        function filterTable() {
            var input, filter, table, tr, tdName, tdCategory, i, txtValueName, txtValueCategory;
            input = document.getElementById("searchInput");
            filter = input.value.toLowerCase();
            table = document.getElementById("productTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                tdName = tr[i].getElementsByTagName("td")[2];
                tdCategory = tr[i].getElementsByTagName("td")[3];
                if (tdName && tdCategory) {
                    txtValueName = tdName.textContent || tdName.innerText;
                    txtValueCategory = tdCategory.textContent || tdCategory.innerText;
                    if (txtValueName.toLowerCase().indexOf(filter) > -1 || txtValueCategory.toLowerCase().indexOf(
                            filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
        </script>
        <script>
        document.getElementById("searchInput").addEventListener("keyup", filterTable);
        </script>


        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/bs-init.js"></script>
        <script src="assets/js/bold-and-dark.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </body>

    </html>
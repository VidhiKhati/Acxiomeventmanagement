<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}

include "connection.php"; 

$vendorType = 'Catering';

$vendors = mysqli_query($conn, "SELECT * FROM vendors WHERE type='$vendorType'");

if (isset($_GET['add_to_cart'])) {
    $vendorId = $_GET['add_to_cart'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (!in_array($vendorId, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $vendorId;
        echo '<script>alert("Vendor added to cart!");</script>';
    } else {
        echo '<script>alert("Vendor is already in the cart!");</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 100px;
        }
        .header {
            background-color: #4285F4;
            color: #fff;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .btn-custom {
            width: 120px;
            margin: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
    </div>
    <div class="d-flex justify-content-center">

        <div class="dropdown me-2">
            <button class="btn btn-primary dropdown-toggle btn-custom" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                Vendor
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="?vendor_type=Catering">Catering</a></li>
                <li><a class="dropdown-item" href="?vendor_type=Florist">Florist</a></li>
                <li><a class="dropdown-item" href="?vendor_type=Decoration">Decoration</a></li>
                <li><a class="dropdown-item" href="?vendor_type=Lighting">Lighting</a></li>
            </ul>
        </div>
        <a href="cart.php" class="btn btn-primary btn-custom">Cart</a>
        <a href="guest_list.php" class="btn btn-primary btn-custom">Guest List</a>
        <a href="order_status.php" class="btn btn-primary btn-custom">Order Status</a>
        <a href="logout.php" class="btn btn-danger btn-custom">LogOut</a>
    </div>

    <div class="mt-5">
        <h4>Vendor List: <?php echo htmlspecialchars($vendorType); ?></h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Vendor Name</th>
                    <th>Category</th>
                    <th>Contact</th>
                    <th>Details</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php

                if (mysqli_num_rows($vendors) > 0) {
                    while ($vendor = mysqli_fetch_assoc($vendors)) {
                        echo "<tr>
                                <td>" . htmlspecialchars($vendor['name']) . "</td>
                                <td>" . htmlspecialchars($vendor['type']) . "</td>
                                <td>" . htmlspecialchars($vendor['contact']) . "</td>
                                <td>" . htmlspecialchars($vendor['details']) . "</td>
                                <td><a href='?add_to_cart=" . $vendor['id'] . "' class='btn btn-success'>Add to Cart</a></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No vendors found for this category.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

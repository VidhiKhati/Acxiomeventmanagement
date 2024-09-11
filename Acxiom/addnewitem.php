<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: loginvendor.php");
    exit;
}
include "connection.php"; 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productImage = $_FILES['product_image']['name'];
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
        // Insert into the database
        $sql = "INSERT INTO products (name, price, image) VALUES ('$productName', '$productPrice', '$productImage')";
        if (mysqli_query($conn, $sql)) {
            echo "Product added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $sql = "DELETE FROM products WHERE id=$deleteId";
    mysqli_query($conn, $sql);
    header("location: dashboard.php"); 
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vendor Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <!-- Left Side: Product Form -->
        <div class="col-md-5">
            <div class="card p-3">
                <h4 class="card-title">Add New Product</h4>
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="text" name="product_name" class="form-control" placeholder="Product Name" required>
                    </div>
                    <div class="mb-3">
                        <input type="number" name="product_price" class="form-control" placeholder="Product Price" required>
                    </div>
                    <div class="mb-3">
                        <input type="file" name="product_image" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add The Product</button>
                </form>
            </div>
        </div>
        <div class="col-md-7">
            <h4>Product List</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM products");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td><img src='uploads/" . htmlspecialchars($row['image']) . "' width='50'></td>
                            <td>" . htmlspecialchars($row['name']) . "</td>
                            <td>Rs " . htmlspecialchars($row['price']) . "</td>
                            <td>
                                <a href='dashboard.php?delete_id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Delete</a>
                                <a href='update_product.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Update</a>
                            </td>
                          </tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

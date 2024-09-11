<?php
session_start();
include "connection.php"; 

if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $_SESSION['cart'][$productId] = $quantity;
}

if (isset($_POST['update_cart'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = $quantity;
    }
}

if (isset($_GET['remove_id'])) {
    $removeId = $_GET['remove_id'];
    unset($_SESSION['cart'][$removeId]);
}

if (isset($_GET['delete_all'])) {
    unset($_SESSION['cart']);
}

$cartProducts = [];
$grandTotal = 0;

if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $productId => $quantity) {
        $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $productId");
        $product = mysqli_fetch_assoc($result);

        $product['quantity'] = $quantity;
        $product['total_price'] = $product['price'] * $quantity;
        $grandTotal += $product['total_price'];

        $cartProducts[] = $product;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        .header, .footer {
            background-color: #4CAF50;
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
        .dropdown-quantity {
            width: 60px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="header">
        <h4>Shopping Cart</h4>
    </div>

    <div class="d-flex justify-content-between mb-4">
        <a href="home.php" class="btn btn-outline-success">Home</a>
        <a href="view_product.php" class="btn btn-outline-success">View Product</a>
        <a href="request_item.php" class="btn btn-outline-success">Request Item</a>
        <a href="product_status.php" class="btn btn-outline-success">Product Status</a>
        <a href="logout.php" class="btn btn-outline-success">Log Out</a>
    </div>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cartProducts as $product): ?>
            <tr>
                <td><img src="uploads/<?= htmlspecialchars($product['image']) ?>" width="50"></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td>Rs <?= htmlspecialchars($product['price']) ?>/-</td>
                <td>
                    <form method="post" class="d-inline">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <select name="quantity" class="dropdown-quantity form-select" onchange="this.form.submit()">
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="<?= $i ?>" <?= $i == $product['quantity'] ? 'selected' : '' ?>><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </form>
                </td>
                <td>Rs <?= htmlspecialchars($product['total_price']) ?>/-</td>
                <td>
                    <a href="cart.php?remove_id=<?= $product['id'] ?>" class="btn btn-danger btn-sm">Remove</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center">
        <h5>Grand Total: Rs <?= htmlspecialchars($grandTotal) ?>/-</h5>
        <a href="cart.php?delete_all=true" class="btn btn-danger">Delete All</a>
    </div>

    <div class="text-center mt-4">
        <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php 
require_once "connection.php";

$product_id = "";
$new_status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST["product_id"];
    $new_status = $_POST["status"];

    $sql = "UPDATE products SET status = ? WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_status, $product_id);

    if ($stmt->execute()) {
        $message = "Product status updated successfully.";
    } else {
        $message = "Error updating status: " . $conn->error;
    }

    $stmt->close();
}

$result = $conn->query("SELECT id, status FROM products");
?>

<!DOCTYPE html>
<html>
<head>
<title>Update Product Status</title>
<style>
    body { font-family: Arial, sans-serif; }
    .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
    table { width: 100%; border-collapse: collapse; }
    table, th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f4f4f4; }
</style>
</head>
<body>

<div class="container">
    <h2>Update Product Status</h2>

    <?php if (isset($message)) { echo "<p>$message</p>"; } ?>

    <form method="post">
        <label for="product_id">Product ID:</label><br>
        <input type="text" id="product_id" name="product_id" required><br><br>

        <label for="status">New Status:</label><br>
        <select id="status" name="status">
            <option value="in_stock">In Stock</option>
            <option value="out_of_stock">Out of Stock</option>
            <option value="backordered">Backordered</option>
        </select><br><br>

        <input type="submit" value="Update">
    </form>

    <h3>Product List with Status</h3>
    <table>
        <tr>
            <th>Product ID</th>
            <th>Status</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>

<?php
$conn->close();
?>

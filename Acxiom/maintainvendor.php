<?php
require_once "connection.php";

$membership_message = "";
$vendor_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'add_update_membership') {
        $vendor_id = $_POST["vendor_id"];
        $membership_type = $_POST["membership_type"];
        $membership_duration = $_POST["membership_duration"];
        
        $sql = "INSERT INTO memberships (vendor_id, membership_type, duration) VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE membership_type = VALUES(membership_type), duration = VALUES(duration)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isi", $vendor_id, $membership_type, $membership_duration);

        if ($stmt->execute()) {
            $membership_message = "Membership added/updated successfully.";
        } else {
            $membership_message = "Error updating membership: " . $conn->error;
        }

        $stmt->close();
    }
    elseif ($action == 'manage_vendor') {
        $vendor_id = $_POST["vendor_id"];
        $vendor_name = $_POST["vendor_name"];

        $sql = "INSERT INTO vendors (id, name) VALUES (?, ?) ON DUPLICATE KEY UPDATE name = VALUES(name)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $vendor_id, $vendor_name);

        if ($stmt->execute()) {
            $vendor_message = "Vendor added/updated successfully.";
        } else {
            $vendor_message = "Error managing vendor: " . $conn->error;
        }

        $stmt->close();
    }
}

$vendor_result = $conn->query("SELECT * FROM vendors");

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: lightgray;
            padding: 20px;
        }

        .container {
            width: 700px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            font-size: 14px;
            margin: 10px 0;
            cursor: pointer;
            border-radius: 5px;
        }

        .button:hover {
            background-color: #3e8e41;
        }

        .message {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #e7f3fe;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], select {
            width: 100%;
            padding: 8px;
            margin: 4px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Dashboard</h2>

    <h3>Add/Update Membership for Vendor</h3>
    <?php if ($membership_message) echo "<div class='message'>$membership_message</div>"; ?>
    <form method="post">
        <input type="hidden" name="action" value="add_update_membership">
        <div class="form-group">
            <label for="vendor_id">Vendor ID:</label>
            <input type="text" name="vendor_id" id="vendor_id" required>
        </div>
        <div class="form-group">
            <label for="membership_type">Membership Type:</label>
            <input type="text" name="membership_type" id="membership_type" required>
        </div>
        <div class="form-group">
            <label for="membership_duration">Membership Duration (Months):</label>
            <input type="text" name="membership_duration" id="membership_duration" required>
        </div>
        <button type="submit" class="button">Add/Update Membership</button>
    </form>

    <h3>Manage Vendors</h3>
    <?php if ($vendor_message) echo "<div class='message'>$vendor_message</div>"; ?>
    <form method="post">
        <input type="hidden" name="action" value="manage_vendor">
        <div class="form-group">
            <label for="vendor_id">Vendor ID:</label>
            <input type="text" name="vendor_id" id="vendor_id" required>
        </div>
        <div class="form-group">
            <label for="vendor_name">Vendor Name:</label>
            <input type="text" name="vendor_name" id="vendor_name" required>
        </div>
        <button type="submit" class="button">Add/Update Vendor</button>
    </form>

    <h3>Vendors List</h3>
    <ul>
        <?php while ($vendor = $vendor_result->fetch_assoc()) { ?>
            <li><?php echo htmlspecialchars($vendor['id']) . " - " . htmlspecialchars($vendor['name']); ?></li>
        <?php } ?>
    </ul>
</div>

</body>
</html>

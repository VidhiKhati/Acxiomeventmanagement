<?php
require_once "connection.php";

$user_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'manage_user') {
        $user_id = $_POST["user_id"];
        $user_name = $_POST["user_name"];

        // SQL to add or update user with the correct column name 'username'
        $sql = "INSERT INTO login (id, username) VALUES (?, ?) ON DUPLICATE KEY UPDATE username = VALUES(username)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $user_id, $user_name);

        if ($stmt->execute()) {
            $user_message = "User added/updated successfully.";
        } else {
            $user_message = "Error managing user: " . $conn->error;
        }

        $stmt->close();
    }
}

$user_result = $conn->query("SELECT * FROM login");

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

        input[type="text"] {
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

    <h3>Manage Users</h3>
    <?php if ($user_message) echo "<div class='message'>$user_message</div>"; ?>
    <form method="post">
        <input type="hidden" name="action" value="manage_user">
        <div class="form-group">
            <label for="user_id">User ID:</label>
            <input type="text" name="user_id" id="user_id" required>
        </div>
        <div class="form-group">
            <label for="user_name">User Name:</label>
            <input type="text" name="user_name" id="user_name" required>
        </div>
        <button type="submit" class="button">Add/Update User</button>
    </form>

    <h3>Users List</h3>
    <ul>
        <?php while ($user = $user_result->fetch_assoc()) { ?>
            <li><?php echo htmlspecialchars($user['id']) . " - " . htmlspecialchars($user['username']); ?></li>
        <?php } ?>
    </ul>
</div>

</body>
</html>

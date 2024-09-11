<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}

include "connection.php";

if (isset($_POST['add_guest'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    
    $sql = "INSERT INTO guests (name, email, phone) VALUES ('$name', '$email', '$phone')";
    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Guest added successfully!");</script>';
    } else {
        echo '<script>alert("Error adding guest: ' . mysqli_error($conn) . '");</script>';
    }
}

if (isset($_POST['update_guest'])) {
    $guestId = $_POST['guest_id'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $sql = "UPDATE guests SET status='$status' WHERE id='$guestId'";
    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Guest status updated successfully!");</script>';
    } else {
        echo '<script>alert("Error updating guest: ' . mysqli_error($conn) . '");</script>';
    }
}

$guests = mysqli_query($conn, "SELECT * FROM guests");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest List Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
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
            margin: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Guest List Management</h2>
    </div>

    <h4>Add New Guest</h4>
    <form action="guest_list.php" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone">
        </div>
        <button type="submit" class="btn btn-primary" name="add_guest">Add Guest</button>
    </form>

    <h4 class="mt-5">Guest List</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($guests) > 0) {
                while ($guest = mysqli_fetch_assoc($guests)) {
                    echo "<tr>
                            <td>" . htmlspecialchars($guest['name']) . "</td>
                            <td>" . htmlspecialchars($guest['email']) . "</td>
                            <td>" . htmlspecialchars($guest['phone']) . "</td>
                            <td>" . htmlspecialchars($guest['status']) . "</td>
                            <td>
                                <form action='guest_list.php' method='POST' class='d-inline'>
                                    <input type='hidden' name='guest_id' value='" . $guest['id'] . "'>
                                    <select name='status' class='form-select form-select-sm'>
                                        <option value='Invited' " . ($guest['status'] == 'Invited' ? 'selected' : '') . ">Invited</option>
                                        <option value='Confirmed' " . ($guest['status'] == 'Confirmed' ? 'selected' : '') . ">Confirmed</option>
                                        <option value='Declined' " . ($guest['status'] == 'Declined' ? 'selected' : '') . ">Declined</option>
                                    </select>
                                    <button type='submit' class='btn btn-secondary btn-sm mt-1' name='update_guest'>Update</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No guests found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

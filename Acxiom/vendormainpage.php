<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: loginvendor.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vendor Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #4285F4;
            color: #fff;
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #fff;
            color: #4285F4;
            padding: 10px;
            text-align: center;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .button {
            background-color: #fff;
            color: #4285F4;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
  </head>
  <body>
    <?php include "navbar.php"; ?>
    <div class="container">
        <div class="header">
            <h1>Welcome <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        </div>
        <div class="buttons">
            <button class="button" onclick="window.location.href='your_item.php'">Your Item</button>
            <button class="button" onclick="window.location.href='addnewitem.php'">Add New Item</button>
            <button class="button" onclick="window.location.href='transaction.php'">Transaction</button>
            <button class="button" onclick="window.location.href='logout.php'">Log Out</button>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>

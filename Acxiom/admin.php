<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: lightgray;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: #f0f0f0;
            padding: 30px;
            margin: 20px auto;
            border-radius: 10px;
            width: 80%;
            max-width: 800px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .button {
            border: 2px solid #008CBA;
            color: #008CBA;
            padding: 12px 25px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px;
            border-radius: 5px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .button:hover {
            background-color: #008CBA;
            color: white;
        }

        .button.full-width {
            width: 100%;
            max-width: 300px;
        }

        .button-group {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .button-group a {
            margin: 10px;
        }

        .welcome-button {
            width: 100%;
            max-width: 300px;
            text-align: center;
        }

        .header-buttons {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .header-buttons a {
            margin: 0;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header-buttons">
        <a href="index.php" class="button">Home</a>
        <a href="logout.php" class="button">LogOut</a>
    </div>

    <div class="button-group" style="margin-top: 30px;">
        <button class="button welcome-button">Welcome Admin</button>
    </div>

    <div class="button-group" style="margin-top: 30px;">
        <a href="maintainuser.php" class="button">Maintain User</a>
        <a href="maintainvendor.php" class="button">Maintain Vendor</a>
    </div>
</div>

</body>
</html>

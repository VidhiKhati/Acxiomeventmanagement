<!DOCTYPE html>
<html>
<head>
    <title>Login Options</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: lightgray;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            text-align: center;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .btn {
            padding: 10px 20px;
            font-size: 14px;
            text-decoration: none;
            border: 1px solid;
            border-radius: 5px;
            margin: 10px 5px;
            display: inline-block;
            cursor: pointer;
        }

        .btn-outline-success {
            color: #28a745;
            border-color: #28a745;
        }

        .btn-outline-primary {
            color: #007bff;
            border-color: #007bff;
        }

        .btn-outline-danger {
            color: #dc3545;
            border-color: #dc3545;
        }
    </style>
</head>
<body>

<div class="login-container">
    <a class="btn btn-outline-success" href="loginadmin.php">Login for Admin</a>
    <a class="btn btn-outline-primary" href="loginvendor.php">Login for Vendor</a>
    <a class="btn btn-outline-danger" href="login.php">Login for User</a>
</div>

</body>
</html>

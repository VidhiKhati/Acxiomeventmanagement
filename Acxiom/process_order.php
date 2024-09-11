<!DOCTYPE html>
<html>
<head>
<title>Thank You Page</title>
<style>
body {
  font-family: sans-serif;
  background-color: #f4f4f4;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}

.container {
  background-color: #fff;
  padding: 30px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.container h2 {
  text-align: center;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
}

.form-group input,
.form-group select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 3px;
  box-sizing: border-box;
}

.btn {
  background-color: #4CAF50; 
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 3px;
  width: 100%;
}

.btn:hover {
  background-color: #3e8e41;
}
</style>
</head>
<body>

<div class="container">
  <h2>Thank You</h2>

  <?php
    require_once "connection.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = isset($_POST["name"]) ? $_POST["name"] : '';
        $number = isset($_POST["number"]) ? $_POST["number"] : '';
        $email = isset($_POST["email"]) ? $_POST["email"] : '';
        $address = isset($_POST["address"]) ? $_POST["address"] : '';
        $state = isset($_POST["state"]) ? $_POST["state"] : '';
        $city = isset($_POST["city"]) ? $_POST["city"] : '';
        $pincode = isset($_POST["pincode"]) ? $_POST["pincode"] : '';
        $paymentMethod = isset($_POST["paymentMethod"]) ? $_POST["paymentMethod"] : '';

        if (!empty($name) && !empty($number) && !empty($email) && !empty($address) && !empty($state) && !empty($city) && !empty($pincode) && !empty($paymentMethod)) {
            $sql = "INSERT INTO orders (name, number, email, address, state, city, pincode, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssssssss", $name, $number, $email, $address, $state, $city, $pincode, $paymentMethod);

                if ($stmt->execute()) {
                    echo "Thank you for your order!";
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
        } else {
            echo "Please fill in all required fields.";
        }
    }
  ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>
    </div>
    <div class="form-group">
      <label for="number">Number:</label>
      <input type="text" id="number" name="number" required>
    </div>
    <div class="form-group">
      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
      <label for="address">Address:</label>
      <input type="text" id="address" name="address" required>
    </div>
    <div class="form-group">
      <label for="state">State:</label>
      <input type="text" id="state" name="state" required>
    </div>
    <div class="form-group">
      <label for="city">City:</label>
      <input type="text" id="city" name="city" required>
    </div>
    <div class="form-group">
      <label for="pincode">Pincode:</label>
      <input type="text" id="pincode" name="pincode" required>
    </div>
    <div class="form-group">
      <label for="paymentMethod">Payment Method:</label>
      <select id="paymentMethod" name="paymentMethod" required>
        <option value="Cash">Cash</option>
        <option value="Card">Card</option>
        <option value="UPI">UPI</option>
      </select>
    </div>
    <button type="submit" class="btn">Continue Shopping</button>
  </form>
</div>

</body>
</html>

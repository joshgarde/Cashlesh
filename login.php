<?php
  session_start();
  include 'database/customer.php';

  if (isset($_POST['email'])) {
    $customer = Customer::getByEmail($_POST['email']);
    $_SESSION['loggedin'] = true;
    $_SESSION['customerID'] = $customer->customerID;

    header("Location: /account.php");
  }
?>
<!doctype html>
<html>
<head>
  <title>Cashlesh - Login</title>
</head>
<body>
  <h1>Login Page</h1>
  <form method="post" action="/login.php">
    <label>Email</label>
    <input type="text" name="email">

    <label>Password</label>
    <input type="password" name="password">

    <input type="submit" value="Login">
  </form>
</body>
</html>

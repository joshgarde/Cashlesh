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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Cashless</a>
  </nav>
  <div class="container">
    <h1>Login Page</h1>

    <form method="post" action="/login.php">
      <div class="form-group">
        <label for="exampleInputEmail1">Email</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="password">
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</body>
</html>

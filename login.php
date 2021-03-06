<?php
  require_once 'lib/all.php';

  $error = false;

  if (requiresAuth(false)) {
    header('Location: /account.php');
    return;
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
      $customer = Customer::getByEmail($_POST['email']);
      $password = $_POST['password'];

      if ($customer->password === $password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['customerID'] = $customer->customerID;

        header('Location: /account.php');
      } else {
        $error = true;
        $errorMessage = 'Invalid login details';
      }
    }
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
    <h1>Login</h1>

    <?php if ($error): ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $errorMessage; ?>
      </div>
    <?php endif; ?>

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

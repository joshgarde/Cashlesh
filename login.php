<?php
  include 'db-config.php';

  if (!$_POST['email'] or !$_POST['password']) {
    return;
  }

  $statement = $mysqli->prepare('SELECT customerId FROM customer WHERE email=? AND password=?');
  $statement->bind_param('ss', $_POST['email'], $_POST['password']);

  $statement->execute();
  $statement->bind_result($customerId);

  $statement->fetch();

  var_dump($customerId);

  $statement->close();
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

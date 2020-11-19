<?php function writeHeader() { ?>
<!doctype html>
<html>
<head>
  <title>Cashlesh - Account Summary</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Cashless</a>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
          <a class="nav-link" href="/account.php">Summary</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/transfer.php">Transfer</a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="/logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </nav>
<?php } ?>

<?php function writeFooter() { ?>
</body>
</html>
<?php } ?>

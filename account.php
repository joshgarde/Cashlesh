<?php
  session_start();
  include 'database/customer.php';
  include 'database/accountholder.php';
  include 'database/account.php';

  if ($_SESSION['loggedin'] == false) {
    header("Location: /login.php");
  } else {
    $accountHolders = AccountHolder::getByCustomerID($_SESSION['customerID']);
    $accounts = [];
    foreach ($accountHolders as &$accountHolder) {
      array_push($accounts, Account::getAccountByID($accountHolder->accountID));
    }
  }
?>
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
        <li class="nav-item active">
          <a class="nav-link" href="/account.php">Account Summary</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="/transfer.php">Transfer</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="#">Transaction History</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="#">Logout</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="container">
    <h1>Welcome to Cashless Bank!</h1>
    <table class="table">
      <tr>
        <th>Account ID</th>
        <th>Account Name</th>
        <th>Balance</th>
        <th>Interest Rate</th>
      </tr>
      <?php foreach ($accounts as &$account): ?>
      <tr>
        <td><?php echo $account->accountID; ?></td>
        <td><?php echo $account->name; ?></td>
        <td><?php echo $account->balance; ?></td>
        <td><?php echo $account->interestRate; ?></td>
      </tr>
    <?php endforeach; ?>
    </table>
  </div>
</body>
</html>

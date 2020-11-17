<?php
session_start();
include 'database/customer.php';
include 'database/accountholder.php';
include 'database/account.php';
include 'database/transaction.php';

$error = false;
$success = false;

if ($_SESSION['loggedin'] == false) {
  header("Location: /login.php");
} else {
  $accountHolders = AccountHolder::getByCustomerID($_SESSION['customerID']);
  $accounts = [];
  foreach ($accountHolders as &$accountHolder) {
    array_push($accounts, Account::getAccountByID($accountHolder->accountID));
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $from = $_POST['from'] - 1;
  $to = $_POST['to'] - 1;
  $amount = $_POST['amount'];

  if ($from === $to) {
    $error = true;
    $errorMessage = 'That\'s the same account!';
  } elseif ($accounts[$from]->balance < $amount) {
    $error = true;
    $errorMessage = 'Not enough money in account!';
  } else {
    $transaction = new Transaction();
    $transaction->fromAccountID = $from;
    $transaction->toAccountID = $to;
    $transaction->amount = $amount;
    $transaction->type = 'deposit';

    $datetime = date("Y-m-d H:i:s", mktime());
    $transaction->timestamp = $datetime;

    $transaction->insertIntoDB();

    $newFromBalance = $accounts[$from]->balance - $amount;
    $newToBalance = $accounts[$to]->balance + $amount;
    $accounts[$from]->updateBalance($newFromBalance);
    $accounts[$to]->updateBalance($newToBalance);

    $success = true;
    $successMessage = 'Successfully transfered!';
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
    <h1>Transfer</h1>

    <?php if ($error): ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $errorMessage; ?>
      </div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="alert alert-success" role="alert">
        <?php echo $successMessage; ?>
      </div>
    <?php endif; ?>

    <form method="post">
      <div class="form-group">
        <label for="exampleFormControlSelect1">From account:</label>
        <select class="form-control" id="exampleFormControlSelect1" name="from">
          <?php foreach ($accounts as &$account): ?>
          <option value="<?php echo $account->accountID; ?>"><?php echo $account->name; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="exampleFormControlSelect1">To account:</label>
        <select class="form-control" id="exampleFormControlSelect1" name="to">
          <?php foreach ($accounts as &$account): ?>
          <option value="<?php echo $account->accountID; ?>"><?php echo $account->name; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="exampleFormControlInput1">Amount</label>
        <input type="number" class="form-control" id="exampleFormControlInput1" name="amount">
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</body>
</html>

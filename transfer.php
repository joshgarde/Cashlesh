<?php
include 'lib/all.php';

$error = false;
$success = false;

if ($_SESSION['loggedin'] == false) {
  header("Location: /login.php");
} else {
  $accountHolders = AccountHolder::getByCustomerID($_SESSION['customerID']);
  $accounts = [];

  foreach ($accountHolders as &$accountHolder) {
    $accounts[$accountHolder->accountID] =  Account::getAccountByID($accountHolder->accountID);
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $from = $_POST['from'];
  $to = $_POST['to'];
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

<?php writeHeader() ?>
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
        <option value="<?php echo $account->accountID; ?>"><?php echo $account->name; ?>: $<?php echo number_format($account->balance, 2); ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="exampleFormControlSelect1">To account:</label>
      <select class="form-control" id="exampleFormControlSelect1" name="to">
        <?php foreach ($accounts as &$account): ?>
        <option value="<?php echo $account->accountID; ?>"><?php echo $account->name; ?>: $<?php echo number_format($account->balance, 2); ?></option>
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
<?php writeFooter(); ?>

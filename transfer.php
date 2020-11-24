<?php
include 'lib/all.php';

$error = false;
$success = false;

if (requiresAuth()) {
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

  # Convert inputted decimal value to integer
  $amount = intval(floatval($amount) * 100);

  if ($amount <= 0) {
    $error = true;
    $errorMessage = 'Please enter a positive non-zero amount';
  } elseif ($from === $to) {
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

    $newFromBalance = $accounts[$from]->balance - $amount;
    $newToBalance = $accounts[$to]->balance + $amount;

    global $mysqli;
    $mysqli->begin_transaction();
    $transaction->insertIntoDB();
    $accounts[$from]->updateBalance($newFromBalance);
    $accounts[$to]->updateBalance($newToBalance);
    $result = $mysqli->commit();

    if ($result === true) {
      $success = true;
      $successMessage = 'Successfully transfered!';
    } else {
      $error = false;
      $errorMessage = 'An unknown error has occured. Contact support.';
    }
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
      <label for="from-account">From account:</label>
      <select class="form-control" id="from-account" name="from">
        <?php foreach ($accounts as &$account): ?>
        <option value="<?php echo $account->accountID; ?>">
          <?php echo $account->name; ?>: $<?php echo $account->getFormattedBalance(); ?>
        </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="to-account">To account:</label>
      <select class="form-control" id="to-account" name="to">
        <?php foreach ($accounts as &$account): ?>
        <option value="<?php echo $account->accountID; ?>">
          <?php echo $account->name; ?>: $<?php echo $account->getFormattedBalance(); ?>
        </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="amount">Amount</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">$</div>
        </div>
        <input class="form-control" id="amount" name="amount" value="0.00">
      </div>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
<?php writeFooter(); ?>

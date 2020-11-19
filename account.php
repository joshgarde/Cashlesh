<?php
  include './lib/all.php';

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

<?php writeHeader(); ?>
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
        <td><a href="/history.php?id=<?php echo $account->accountID; ?>"><?php echo $account->accountID; ?></a></td>
        <td><a href="/history.php?id=<?php echo $account->accountID; ?>"><?php echo $account->name; ?></a></td>
        <td><a href="/history.php?id=<?php echo $account->accountID; ?>">$<?php echo number_format($account->balance, 2); ?></a></td>
        <td><a href="/history.php?id=<?php echo $account->accountID; ?>"><?php echo $account->interestRate; ?></a></td>
      </a>
    </tr>
  <?php endforeach; ?>
  </table>
</div>
<?php writeFooter(); ?>

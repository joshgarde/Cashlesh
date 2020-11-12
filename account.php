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
</head>
<body>
  <h1>Welcome to Cashless Bank!</h1>
  <table>
    <tr>
      <th>Account Name</th>
      <th>Balance</th>
      <th>Interest Rate</th>
    </tr>
    <?php foreach ($accounts as &$account): ?>
    <tr>
      <td><?php echo $account->name; ?></td>
      <td><?php echo $account->balance; ?></td>
      <td><?php echo $account->interestRate; ?></td>
    </tr>
  <?php endforeach; ?>
  </table>

</body>
</html>

<?php
  include './lib/all.php';

  if (requiresAuth()) {
    $accountHolders = AccountHolder::getByCustomerID($_SESSION['customerID']);
    $accounts = [];
    foreach ($accountHolders as &$accountHolder) {
      array_push($accounts, Account::getAccountByID($accountHolder->accountID));
    }
  }
?>

<?php writeHeader(); ?>
<div class="container-fluid">
  <div class="row mt-4">
    <div class="col px-5">
      <h1>Welcome to Cashless Bank!</h1>
    </div>
  </div>

  <div class="row mt-2">
    <div class="col-8 px-5">
      <table class="table">
        <tr>
          <th>Account ID</th>
          <th>Account Name</th>
          <th>Balance</th>
          <th>Account Type</th>
        </tr>
        <?php foreach ($accounts as &$account): ?>
        <tr>
            <td><?php echo $account->accountID; ?></td>
            <td><a href="/history.php?id=<?php echo $account->accountID; ?>"><?php echo $account->name; ?></a></td>
            <td>$<?php echo $account->getFormattedBalance(); ?></td>
            <td><?php echo $account->accountType(); ?></td>
          </a>
        </tr>
      <?php endforeach; ?>
      </table>
    </div>

    <?php $quote = getRandomQuote(); ?>

    <div class="col px-5">
      <div class="card">
        <div class="card-body">
          <blockquote class="blockquote mb-0">
            <p>"<?php echo $quote['quote']; ?>"</p>
            <footer class="blockquote-footer">Cashless Bank CEO, Tom Dickerson (<?php echo $quote['subquote']; ?>)</footer>
          </blockquote>
        </div>
      </div>
    </div>
  </div>
</div>
<?php writeFooter(); ?>

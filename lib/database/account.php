<?php
require_once './lib/database/checkingAccount.php';
require_once './lib/database/savingsAccount.php';

abstract class Account {
  public $accountID;
  public $customerID;
  public $name;
  public $balance;

  abstract public function accountType();

  public static function getAccountByID($id) {
    global $mysqli;
    $statement = $mysqli->prepare('SELECT accountID, name, balance, interestRate, minimumBalance FROM account WHERE accountID=?');
    $statement->bind_param('i', $id);
    $statement->execute();
    $statement->bind_result($accountID, $name, $balance, $interestRate, $minimumBalance);

    $statement->fetch();

    $obj = null;
    if ($interestRate !== null) {
      $obj = new SavingsAccount();
      $obj->interestRate = $interestRate;
    } elseif ($minimumBalance !== null) {
      $obj = new CheckingAccount();
      $obj->interestRate = $minimumBalance;
    }

    $obj->accountID = $accountID;
    $obj->name = $name;
    $obj->balance = $balance;

    return $obj;
  }

  public function updateBalance($amount) {
    $this->balance = $amount;

    global $mysqli;
    $statement = $mysqli->prepare('UPDATE account SET balance = ? WHERE accountID = ?');
    $statement->bind_param('ii', $this->balance, $this->accountID);
    return $statement->execute();
  }

  public function getFormattedBalance() {
    return number_format($this->balance / 100, 2);
  }
}
?>

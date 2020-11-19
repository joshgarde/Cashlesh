<?php
class Account {
  public $accountID;
  public $customerID;
  public $name;
  public $balance;
  public $interestRate;
  public $minimumBalance;

  public static function getAccountByID($id) {
    global $mysqli;
    $statement = $mysqli->prepare('SELECT accountID, name, balance, interestRate, minimumBalance FROM account WHERE accountID=?');
    $statement->bind_param('i', $id);
    $statement->execute();
    $statement->bind_result($accountID, $name, $balance, $interestRate, $minimumBalance);

    $statement->fetch();

    $obj = new Account();
    $obj->accountID = $accountID;
    $obj->name = $name;
    $obj->balance = $balance;
    $obj->interestRate = $interestRate;
    $obj->minimumBalance = $minimumBalance;
    return $obj;
  }

  public function updateBalance($amount) {
    $this->balance = $amount;

    global $mysqli;
    $statement = $mysqli->prepare('UPDATE account SET balance = ? WHERE accountID = ?');
    $statement->bind_param('ii', $this->balance, $this->accountID);
    return $statement->execute();
  }
}
?>

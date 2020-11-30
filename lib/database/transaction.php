<?php
class Transaction {
  public $transactionID;
  public $amount;
  public $timestamp;
  public $type;
  public $fromAccountID;
  public $toAccountID;

  public function insertIntoDB() {
    global $mysqli;
    $statement = $mysqli->prepare('INSERT INTO transaction (amount, timestamp, type, fromAccountID, toAccountID) VALUES (?,?,?,?,?)');
    $statement->bind_param('issii',
      $this->amount,
      $this->timestamp,
      $this->type,
      $this->fromAccountID,
      $this->toAccountID
    );
    $statement->execute();

    return $statement->insert_id;
  }

  public function getTransaction($accountID){
    global $mysqli;
    $statement = $mysqli->prepare('SELECT amount, timestamp, type, fromAccountID, toAccountID FROM Transaction WHERE fromAccountID=? OR toAccountID=?');
    $statement->bind_param('ii', $accountID , $accountID);
    $statement->execute();
    $statement->bind_result($amount, $timestamp, $type, $fromAccountID, $toAccountID);

    $array = [];

    while ($statement->fetch()) {
      $obj = new Transaction();
      $obj->amount = $amount;
      $obj->timestamp = $timestamp;
      $obj->type = $type;
      $obj->fromAccountID = $fromAccountID;
      $obj->toAccountID = $toAccountID;
      array_push($array, $obj);
    }

    return $array;
  }

  public function getFormattedAmount() {
    return number_format($this->amount / 100, 2);
  }
}
?>

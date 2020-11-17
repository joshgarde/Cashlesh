<?php
include 'db-config.php';

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
}
?>

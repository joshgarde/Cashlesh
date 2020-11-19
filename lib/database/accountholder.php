<?php
class AccountHolder {
  public $customerID;
  public $accountID;

  public static function getByCustomerID($id) {
    global $mysqli;
    $statement = $mysqli->prepare('SELECT customerID, accountID FROM accountholders WHERE customerID=?');
    $statement->bind_param('i', $id);
    $statement->execute();
    $statement->bind_result($customerID, $accountID);

    $array = [];

    while ($statement->fetch()) {
      $obj = new AccountHolder();
      $obj->customerID = $customerID;
      $obj->accountID = $accountID;
      array_push($array, $obj);
    }

    return $array;
  }
}
?>

<?php
include 'db-config.php';

class Customer {
  public $customerID;
  public $email;
  public $password;

  public static function getByEmail($email) {
    global $mysqli;
    $statement = $mysqli->prepare('SELECT customerId, email, password FROM customer WHERE email=?');
    $statement->bind_param('s', $_POST['email']);
    $statement->execute();
    $statement->bind_result($customerID, $email, $password);

    $statement->fetch();

    $object = new Customer();
    $object->customerID = $customerID;
    $object->email = $email;
    $object->password = $password;
    return $object;
  }
}
?>

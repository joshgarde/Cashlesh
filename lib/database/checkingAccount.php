<?php
require_once './lib/database/account.php';
class CheckingAccount extends Account {
  public $minimumBalance;

  public function accountType() {
    return "Checking";
  }
}
?>

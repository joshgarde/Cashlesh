<?php
require_once './lib/database/account.php';
class SavingsAccount extends Account {
    public $interestRate;

    public function accountType() {
      return "Savings";
    }
}
?>

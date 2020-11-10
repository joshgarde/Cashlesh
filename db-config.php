<?php
  $username = 'root';
  $password = '';

  $mysqli = new mysqli('localhost', $username, $password, 'cashless');
  if ($mysqli->connect_errno) {
      echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }
?>

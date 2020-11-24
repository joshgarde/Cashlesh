<?php
function requiresAuth($redirect = true) {
  if (!empty($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    return true;
  } else {
    if ($redirect) header('Location: /login.php');
    return false;
  }
}
?>

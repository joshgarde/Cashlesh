<?php
	session_start(); // required line for every php file to access the current session
	include 'database/customer.php';
	include 'database/account.php';
	include 'database/accountholder.php';
	include 'db-config.php';
	
	if($_SESSION['loggedin'] == true) {
		header("Location: /account.php");
	}
	
	$statement = $mysqli->prepare('INSERT INTO customer (email, password) VALUES (?,?)');
	$statement->bind_param('ss', $_POST['email'], $_POST['password']);
	$statement->execute();
	
	$customerID = $statement->insert_id;
	
	$statement = $mysqli->prepare('INSERT INTO account (balance, interestRate, minimumBalance) VALUES (?,?,?)');
	$statement->bind_param('iii', $_POST['balance'], $_POST['interestRate'], $_POST['minimumBalance']);
	$statement->execute();
	
	$accountID = $statement->insert_id;
	
	$statement = $mysqli->prepare('INSERT INTO accountholders (accountID, customerID) VALUES (?,?)');
	$statement->bind_param('ii', $customerID, $accountID);
	$statement->execute();
?>

<!doctype html>
<html>
<head>
	<title>Cashlesh - Register Page</title>
</head>
<body>
	<h1>Register Page</h1>
	<form method="post">
		<label>Email</label>
		<input type="text" name="email">
		
		<label>Password</label>
		<input type="password" name="password">
		
		<label>Starting Balance</label>
		<input type="number" name="balance">
		
		<label>Interest Rate</label>
		<input type="number" name="interestRate">
		
		<label>Minimum Balance</label>
		<input type="number" name="minimumBalance">
		
		<input type="submit" value="Register">
	</form>
</body>
</html>

<!-- customer: email, password)
<!-- account: customerid, name, balance, interestrate, minimumbalance -->
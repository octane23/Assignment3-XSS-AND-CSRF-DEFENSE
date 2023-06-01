<?php
include '../login/security.php';

session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
  header('Location: login.php');
  exit;
}

// Check if user has access to this page
if ($_SESSION['access_level'] != 1) {
  header('Location: access_denied.php');
  exit;
}


?>

<!DOCTYPE html>

<html>
<head>
	<title>Reservation Form</title>
	<link rel="stylesheet" href="style.css">
	<script src="validation.js"></script>
</head>
<body>
	<div class="container">
		<h1>A.Student Details</h1>
		<form method="post" action="submit.php" onsubmit="return validateForm()">
			<label for="name">Name(Legal/Official):</label>
			<input type="text" id="name" name="name" pattern="[a-zA-Z\s]+" required>
			<span id="name_error"></span>
			<label for="matric_no">Matric No:</label>
			<input type="text" id="matric_no" name="matric_no" pattern="[0-9]+" required>
			<span id="matric_no_error"></span>

			<label for="current_address">Current Address:</label>
			<textarea id="current_address" name="current_address" rows="5" required></textarea>
			<span id="current_address_error"></span>

			<label for="home_address">Home Address:</label>
			<textarea id="home_address" name="home_address" rows="5"  required></textarea>
			<span id="home_address_error"></span>
			
			<label for="email">Email(Gmail Account):</label>
			<input type="email" id="email" name="email" required>
			<span id="email_error"></span>
			<label for="mobile_no">Mobile Phone No:</label>
			<input type="tel" id="mobile_no" name="mobile_no" pattern="[0-9]+" required>
			<span id="mobile_no_error"></span>
			<label for="home_no">Home Phone No(Emergency):</label>
			<input type="tel" id="home_no" name="home_no" pattern="[0-9]+" required>
			<span id="home_no_error"></span>
			<input type="submit" value="Submit">
			
		</form>
	</div>
</body>
</html>

<form method="post" action="../login/userlvl1.php">

  <button type="submit" name="submit">Change Email and Password </button>
</form>

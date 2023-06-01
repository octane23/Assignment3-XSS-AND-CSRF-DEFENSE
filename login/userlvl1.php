<?php
include 'security.php';
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['id'])) {
  header("Location: index.php");
  exit();
}

// Connect to database
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'users';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  // Validate form inputs
  if (empty($email) || empty($password) || empty($confirm_password)) {
    $error_message = "Please fill in all fields.";
  } else if ($password !== $confirm_password) {
    $error_message = "Password and confirm password do not match.";
  } else {
    // Hash the password before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $userId = $_SESSION['id'];
    $stmt = $conn->prepare("UPDATE users SET email = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssi", $email, $hashedPassword, $userId);
    $stmt->execute();
    $stmt->close();
    header("Location: user_management.php");
    exit();
  }
}

// Get user data
$userId = $_SESSION['id'];
$sql = "SELECT email FROM users WHERE id = $userId";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$email = $row['email'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Management</title>
 <style>

body {
  background-color: #f2f2f2;
  font-family: Arial, sans-serif;
}

h1 {
  text-align: center;
  margin-top: 50px;
}

form {
  max-width: 400px;
  margin: 50px auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #fff;
}

label {
  display: block;
  margin-bottom: 10px;
  font-size: 16px;
}

input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 3px;
  font-size: 16px;
  margin-bottom: 20px;
}

button[type="submit"] {
  display: block;
  width: 100%;
  padding: 10px;
  background-color: #4CAF50;
  color: #fff;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  font-size: 16px;
}

button[type="submit"]:hover {
  background-color: #3e8e41;
}

a {
  display: block;
  text-align: center;
  margin-top: 20px;
  font-size: 16px;
  color: #666;
}

a:hover {
  color: #333;
}

 </style>
</head>
<body>
  <h1>Update Credential</h1>
  <?php if (isset($error_message)) { ?>
    <p class="error"><?php echo $error_message; ?></p>
  <?php } ?>
  <form method="post">
    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo $email; ?>">
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password">
    <br>
    <label for="confirm_password">Confirm Password:</label>
    <input type="password" name="confirm_password">
    <br>
    <button type="submit" name="submit">Save</button>
  </form>
 
  <a href="index.php">Logout</a>
</body>
</html>

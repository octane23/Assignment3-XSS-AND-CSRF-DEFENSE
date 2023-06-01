<?php
include 'security.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the email and password from the form submission
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Validate the email and password
  if (empty($email) || empty($password)) {
    header("Location: register.php?error=Please fill in all fields");
    exit();
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: register.php?error=Invalid email format");
    exit();
  }

  // Hash the password before storing it in the database
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Insert the user data into the database
  $host = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'users';

  // Create connection
  $conn = new mysqli($host, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Prepare and execute the SQL statement to insert the user data
  $stmt = $conn->prepare(" INSERT INTO users (email, password) VALUES (?, ?)");
  $stmt->bind_param("ss", $email, $hashedPassword);
  $stmt->execute();

  // Close the connection
  $stmt->close();
  $conn->close();

  // Redirect the user to the login page with a success message
  header("Location: index.php?success=Registration successful. Please log in.");
  exit();
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="form-container">
      <h1>Register</h1>
      <form method="post" action="register.php">
        <div class="form-field">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-field">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required>
        </div>
        <div class="form-field">
          <button type="submit" id="login-button">Register</button>
        </div>
      </form>
      <?php if(isset($_GET['error'])) { ?>
      <div id="error-message"><?php echo $_GET['error']; ?></div>
      <?php } ?>
    </div>
  </body>
</html>

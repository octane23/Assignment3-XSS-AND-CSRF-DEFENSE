<?php

session_start();include 'security.php';
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'users';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Check if CSRF token exists and matches the submitted value
  if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email and hashed password match a record in the database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
      $user = mysqli_fetch_assoc($result);

      if (password_verify($password, $user['password'])) {
        // Password is correct, start a session
        session_regenerate_id();
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['id'] = $user['id'];
        $_SESSION['access_level'] = $user['access_level'];

        // Redirect to the appropriate page based on access level
        if ($user['access_level'] == 0) {
          // Guest user, redirect to login page
          header('Location: index.php');
        } else if ($user['access_level'] == 1) {
          // Regular user, redirect to student details page
          header('Location: ../reservationform/index.php');
        } else if ($user['access_level'] == 2) {
          // Administrator, redirect to user management page
          header('Location: user_management.php');
        }
      } else {
        // Password is not correct, show an error message
        $error = "Incorrect password";
        header('Location: index.php?error=' . urlencode($error));
      }
    } else {
      // Email is not found, show an error message
      $error = "Email not found";
      header('Location: index.php?error=' . urlencode($error));
    }
  } else {
    // CSRF token is invalid, reject the form submission
    $error = "CSRF validation failed. Please try again.";
    header('Location: index.php?error=' . urlencode($error));
  }
}

mysqli_close($conn);
?>

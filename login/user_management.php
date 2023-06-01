<?php
include 'security.php';
// Start session
session_start();

// Check if user is logged in as an admin
if (!isset($_SESSION['access_level']) || $_SESSION['access_level'] !== '2') {
  header("Location: login.php");
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

// Check if delete button is clicked
if (isset($_POST['delete'])) {
  $id = $_POST['id'];
  $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->close();
  header("Location: user_management.php");
  exit();
}

// Check if update button is clicked
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $access_level = $_POST['access_level'];
  
    // Hash the password if it is not empty
    if (!empty($password)) {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $conn->prepare("UPDATE users SET  email = ?, password = ?, access_level = ? WHERE id = ?");
      $stmt->bind_param("ssii", $email, $hashedPassword, $access_level, $id);
    } else {
      $stmt = $conn->prepare("UPDATE users SET  email = ?, access_level = ? WHERE id = ?");
      $stmt->bind_param("sii", $email, $access_level, $id);
    }
  
    $stmt->execute();
    $stmt->close();
    header("Location: user_management.php");
    exit();
  }
  

// Get user data
$sql = "SELECT id,  email, password,   access_level FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Management</title>
 <style>

body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
}

h1 {
  text-align: center;
  margin-top: 50px;
}

table {
  margin: 0 auto;
  border-collapse: collapse;
  width: 80%;
}

th, td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: center;
}

th {
  background-color: #f2f2f2;
}

input[type="email"] {
  width: 100%;
  padding: 10px;
  border: none;
  border-radius: 3px;
  box-sizing: border-box;
}

select {
  width: 100%;
  padding: 10px;
  border: none;
  border-radius: 3px;
  box-sizing: border-box;
}

button[type="submit"] {
  background-color: #4CAF50;
  color: #fff;
  border: none;
  border-radius: 3px;
  padding: 10px 20px;
  cursor: pointer;
  margin-right: 10px;
}

button[type="submit"]:hover {
  background-color: #3e8e41;
}

a {
  display: block;
  margin: 50px auto;
  text-align: center;
  color: #4CAF50;
}

a:hover {
  text-decoration: underline;
}

    </style>
</head>
<body>
  <h1>User Management</h1>
  <table>
    <tr>
      <th>ID</th>
      <th>Email</th>
      <th>Access Level</th>
      <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
  <form method="post">
    <td><?php echo $row['id']; ?><input type="hidden" name="id" value="<?php echo $row['id']; ?>"></td>
    <td><input type="email" name="email" value="<?php echo $row['email']; ?>"></td>
    <td>
      <select name="access_level">
        <option value="1"<?php if ($row['access_level'] === '1') { echo ' selected'; } ?>>1</option>
        <option value="2"<?php if ($row['access_level'] === '2') { echo ' selected'; } ?>>2</option>
      </select>
    </td>
    <td>
      <input type="password" name="password" placeholder="New Password">
      <button type="submit" name="update">Update</button>
      <button type="submit" name="delete">Delete</button>
    </td>
  </form>
</tr>

    <?php } ?>
  </table>
  <a href="index.php">Logout</a

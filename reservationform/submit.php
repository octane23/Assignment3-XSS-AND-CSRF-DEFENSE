<?php
include '../login/security.php';


$conn = mysqli_connect('localhost', 'root', '','studentdatabase');

$name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
$matric_no = filter_var($_POST["matric_no"], FILTER_SANITIZE_STRING);
$current_address = filter_var($_POST["current_address"], FILTER_SANITIZE_STRING);
$home_address = filter_var($_POST["home_address"], FILTER_SANITIZE_STRING);
$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
$mobile_phone = filter_var($_POST["mobile_no"], FILTER_SANITIZE_NUMBER_INT);
$home_phone = filter_var($_POST["home_no"], FILTER_SANITIZE_NUMBER_INT);


$name_regex = '/^[a-zA-Z\s]+$/';
$matric_no_regex = '/^[0-9]+$/';
$phone_regex = '/^[0-9]+$/';

if (!preg_match($name_regex, $name)) {
	die("Invalid name");
}

if (!preg_match($matric_no_regex, $matric_no)) {
	die("Invalid matric no");
}

if ($current_address == "" || $home_address == "") {
	die("Please fill in both current and home address");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	die("Invalid email address");
}

if (!preg_match($phone_regex, $mobile_phone)) {
	die("Invalid mobile phone no");
}

if (!preg_match($phone_regex, $home_phone)) {
	die("Invalid home phone no");
}


$sql = "INSERT INTO `studentform` (`name`, `matric_no`, `current_address`, `home_address`, `email`, `mobile_phone`, `home_phone`) VALUES ('$name', '$matric_no', '$current_address', '$home_address', '$email', '$mobile_phone', '$home_phone')";
if (mysqli_query($conn, $sql)) {
	echo "Data submitted successfully";
} else {
	echo "Error: " . mysqli_error($conn);
}
mysqli_close($conn);
?>
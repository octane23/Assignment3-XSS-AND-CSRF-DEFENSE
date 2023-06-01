# Assignment3-XSS-AND-CSRF-DEFENSE

##ADDED FILE - SECURITY.PHP

    <?php
    header("X-Frame-Options: DENY");
    header("Content-Security-Policy: default-src 'self';");

    function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
      if (function_exists('random_bytes')) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
      } else {
        $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
      }
    }
    return $_SESSION['csrf_token'];
    }
    ?>

The X-Frame-Options header is set to DENY to prevent the web page from being loaded inside an iframe, protecting against clickjacking attacks.

The Content-Security-Policy header sets the Content Security Policy for the page. In this example, the default-src directive is set to 'self', which allows resources (such as scripts, stylesheets, images, etc.) to be loaded only from the same origin as the page itself.

#UPDATED login/index.php
 Validate the CSRF token in index.php form


     <input type="hidden" name="csrf_token" value="<?php include 'security.php' ;session_start(); 
    echo generateCSRFToken(); ?>">

 #UPDATED auth.php
 
     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     // Check if CSRF token exists and matches the submitted value
     if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
      $email = $_POST['email'];
     $password = $_POST['password'];
    
 -----------------------------------------------
    
     // CSRF token is invalid, reject the form submission
     $error = "CSRF validation failed. Please try again.";
     header('Location: index.php?error=' . urlencode($error));
   
 Insert this code in every php file to validate the CSRF token
 
        include '../login/security.php';
   
  Sanitizing input to avoid any possible XSS atack
  
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
   
   

<?php
session_start();
if (isset($_SESSION['logged_in'])) {
  include('../configuration/config.php');
  
  // Get the email and username of the logged-in user
  $email = $_COOKIE['Email_Cookie'];
  $userName = $_SESSION['user_name'];
  $logMessage = "Logged out";

  // Insert the logout record into the log table
  $logInsert = "INSERT INTO log (account, action) VALUES ('$userName', '$logMessage')";
  mysqli_query($conx, $logInsert);
  
  // Update activeStatus to "Offline"
  $updateQuery = "UPDATE register SET activeStatus='Offline', autoOut='No' WHERE email='{$email}'";
  mysqli_query($conx, $updateQuery);
  
  session_unset();
  session_destroy();
  setcookie('Email_Cookie', '', time() - 3600, '/');
}
header("Location: ../updatesuccess.php");
exit;
?>
  
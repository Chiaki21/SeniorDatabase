<?php
session_start();
if (isset($_SESSION['logged_in'])) {
  include('../configuration/config.php');
  
  $email = $_COOKIE['Email_Cookie'];
  $userName = $_SESSION['user_name'];
  $logMessage = "Logged out";

  $logInsert = "INSERT INTO log (account, action) VALUES ('$userName', '$logMessage')";
  mysqli_query($conx, $logInsert);

  $updateQuery = "UPDATE register SET activeStatus='Offline', autoOut='No' WHERE email='{$email}'";
  mysqli_query($conx, $updateQuery);
  
  session_unset();
  session_destroy();
  setcookie('Email_Cookie', '', time() - 3600, '/');
}
header("Location: ../index.php");
exit;
?>

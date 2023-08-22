<?php
session_start();
include('../configuration/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_name'])) {
    $user = mysqli_real_escape_string($conx, $_SESSION['user_name']);
    $action = mysqli_real_escape_string($conx, $_POST['action']);
    
    $query = "INSERT INTO log (account, action) VALUES ('$user', '$action')";
    mysqli_query($conx, $query);
}
?>

<?php
include('../configuration/config.php');
include("connect.php");


if (isset($_GET['username'])) {
    $usernameToDelete = $_GET['username'];
    $sql = "DELETE FROM register WHERE Username='$usernameToDelete'";
    if (mysqli_query($conn, $sql)) {
        echo "User deleted successfully";
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }
}
?>

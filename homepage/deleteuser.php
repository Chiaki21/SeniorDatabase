<?php
include('../configuration/config.php');


if (isset($_GET['username'])) {
    $usernameToDelete = $_GET['username'];
    $sql = "DELETE FROM register WHERE Username='$usernameToDelete'";
    if (mysqli_query($conx, $sql)) {
        echo "User deleted successfully";
    } else {
        echo "Error deleting user: " . mysqli_error($conx);
    }
}
?>

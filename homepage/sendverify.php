<?php
session_start();
include('../configuration/config.php');

if (isset($_GET['Verification'])) {
    $email = $_GET['Verification'];
    $query = "SELECT * FROM register WHERE email = '$email'";
    $result = mysqli_query($conx, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $verificationCode = md5(rand());
        $query = "UPDATE register SET CodeV = '$verificationCode', verification = '1' WHERE email = '$email'";
        mysqli_query($conx, $query);

        try {
            $_SESSION['message'] = $email . " account has been verified!";
        } catch (Exception $e) {
            $msg = "<div class='alert alert-danger'>Email verification failed. Please try again later.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Invalid email address.</div>";
    }
}

header('Location: userlog.php');
exit();
?>

<?php
if (isset($_COOKIE['Email_Cookie'])) {
    header("Location:donereset.php");
    die();
}

include('configuration/config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$msg = "";
if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conx, $_POST['email']);
    $CodeReset = mysqli_real_escape_string($conx, md5(rand()));
    if (mysqli_num_rows(mysqli_query($conx, "SELECT * FROM register WHERE email='{$email}'")) > 0) {
        $query = mysqli_query($conx, "UPDATE register SET CodeV='{$CodeReset}' WHERE email='{$email}'");
        if ($query) {
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = 0;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'theictteam@gmail.com';                     //SMTP username
                $mail->Password   = 'zrrxpkdlkvoxydqh';                                //SMTP password
                $mail->SMTPSecure = 'Tls';            //Enable implicit TLS encryption
                $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('theictteam@gmail.com', 'Senior Solutions (ICT TEAM)');
                $mail->addAddress($email);
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Password Reset';
                
                $ipv4Address = gethostbyname(gethostname()); // Get the IPv4 address of your current computer
                
                $mail->Body = '<p> This is the password reset Link<b><a href="http://' . $ipv4Address . '/senior/changepassword.php?Reset=' . $CodeReset . '">"http://' . $ipv4Address . '/senior/changepassword.php?Reset=' . $CodeReset . '"</a></b></p>';

                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            $msg = "<div class='alert alert-info'>we've sent a verification code to your email address</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>This email '{$email}' was not found</div>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
    <link rel="icon" href="img/sslogo.png">
    <title>Forget Password</title>
    <style>
        .alert {
            padding: 1rem;
            border-radius: 5px;
            color: white;
            margin: 1rem 0;
            font-weight: 500;
            width: 65%;
        }

        .alert-success {
            background-color: #42ba96;
        }

        .alert-danger {
            background-color: #fc5555;
        }

        .alert-info {
            background-color: #2E9AFE;
        }

        .alert-warning {
            background-color: #ff9966;
        }
    </style>
</head>

<body>
<div class="container">
  <div class="forms-container">
    <div class="signin-signup" style="left: 50%;z-index:99;">
      <form action="" method="POST" class="sign-in-form">
        <h2 class="title">Forget Password</h2>
        <?php echo $msg ?>
        <div class="input-field">
          <i class="fas fa-user"></i>
          <input type="text" name="email" placeholder="Email" />
        </div>  
        <input type="submit" name="submit" value="Send" class="btn solid" />
        <input type="submit" value="Back to Login" class="btn solid" onclick="window.location.href='index.php'; return false;" />
      
      </form>
    </div>
  </div>
</div>
    
</body>

</html>

<?php
session_start();
if (isset($_COOKIE['Email_Cookie']) && isset($_SESSION['logged_in'])) {
  header("Location: homepage/dashboard.php");
  exit();
}
include('configuration/config.php');
$msg = "";
$Error_Pass = "";

if (isset($_GET['Verification'])) {
    $raquet = mysqli_query($conx, "SELECT * FROM register WHERE CodeV='{$_GET['Verification']}'");
    if (mysqli_num_rows($raquet) > 0) {
        $query = mysqli_query($conx, "UPDATE register SET verification='1' WHERE CodeV='{$_GET['Verification']}'");
        if ($query) {
            $rowv = mysqli_fetch_assoc($raquet);
            header("Location: verifywelcome.php?id='{$rowv['id']}'");
        } else {
            header("Location: index.php");
        } 
    } else {
        header("Location: index.php");
    }
}

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conx, $_POST['email']);
    $password = mysqli_real_escape_string($conx, $_POST['Password']);

    $sql = "SELECT * FROM register WHERE email='{$email}'";
    $resulte = mysqli_query($conx, $sql);
    if (mysqli_num_rows($resulte) === 1) {
        $row = mysqli_fetch_assoc($resulte);
        if ($row['verification'] === '1' && password_verify($password, $row['Password'])) {
          if ($row['status'] === 'Disabled') {
            $msg = "<div class='alert alert-danger'>Your account is disabled, contact your supervisor for assistance.</div>";
          } else {
            $_SESSION['user_name'] = $row['Username'];
            $_SESSION['logged_in'] = true; 
            $_SESSION['role'] = $row['role']; // Store the role in the session
            setcookie('Email_Cookie', $email, time() + (86400 * 30), '/');

            // Update activeStatus to "Online"
            $updateQuery = "UPDATE register SET activeStatus='Online', autoOut='No' WHERE email='{$email}'";
            mysqli_query($conx, $updateQuery);

            $userName = $row['Username'];
            $logMessage = "Logged in";
            $logInsert = "INSERT INTO log (account, action) VALUES ('$userName', '$logMessage')";
            mysqli_query($conx, $logInsert);
            if ($row['role'] === 'Super Admin') {
              header("Location: homepage/dashboard.php");
            } elseif ($row['role'] === 'Admin') {
              header("Location: homepage/dashboard.php");
            } elseif ($row['role'] === 'User') {
              header("Location: homepage/addrecord.php");
            } else {
              header("Location: homepage/addrecord.php");
            }

            exit();
          }
        } elseif ($row['verification'] === '0') {
            $msg = "<div class='alert alert-info'>This account is not verified, contact the admin for assistance.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Email or Password is incorrect</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Email or Password is incorrect</div>";
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
    <title>Senior Solutions</title>
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
        background-color: #fe2e2e;
    }

    .alert-warning {
        background-color: #ff9966;
    }

    .Forget-Pass {
        display: flex;
        width: 50%;
    }

    .Forget {
        color: #2E9AFE;
        font-weight: 500;
        text-decoration: none;
        margin-left: auto;
    }

    .input-field {
        position: relative;
    }

    .input-field input[type="password"] {
        padding-right: 40px;
    }

    .input-field .toggle-password {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        outline: none;
        cursor: pointer;
    }
    </style>




</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="" method="POST" class="sign-in-form">
                    <h2 class="title">Log In</h2>
                    <?php echo $msg ?>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="email" placeholder="Email" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="Password" id="password" placeholder="Password" required />
                        <button type="button" class="toggle-password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="Forget-Pass">
                        <a href="forget.php" class="Forget">Forget Password?</a>
                    </div>
                    <input type="submit" name="submit" value="Login" class="btn solid" />
                    <p class="social-text">Visit our social platforms</p>
                    <div class="social-media">
                        <a href="https://www.facebook.com/NCSC.Philippines.OfficialPage/" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/ncscph" class="social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.ncsc.gov.ph/" class="social-icon">
                            <img src="img/sslogo.png" alt="" class="social-iconncsc">
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h2>Don't have an account? <br>Sign up here!</br></h2>
                    <p class="invitext">
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis,
                        ex ratione. Aliquid!
                    </p>
                    <a href="signup.php" class="btn transparent" id="sign-in-btn"
                        style="padding:10px 20px;text-decoration:none">
                        Sign Up
                    </a>
                </div>
            </div>
        </div>

    </div>

    <script>
    const togglePassword = document.querySelector('.toggle-password');
    const passwordInput = document.querySelector('#password');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        togglePassword.classList.toggle('active');
    });


    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    </script>
</body>

<div class="logo-container">
    <img src="img/ss.png" alt="Logo" class="logo" />
</div>

</html>
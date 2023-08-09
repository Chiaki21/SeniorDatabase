<?php
include('configuration/config.php');

$msg = "";
$Error_Pass = "";

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conx, $_POST['Username']);
    $email = mysqli_real_escape_string($conx, $_POST['Email']);
    $password = mysqli_real_escape_string($conx, $_POST['Password']);
    $confirmPassword = mysqli_real_escape_string($conx, $_POST['Conf-Password']);
    try {
        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            throw new Exception("Username can only contain letters and spaces.");
        } elseif (mysqli_num_rows(mysqli_query($conx, "SELECT * FROM register WHERE email='{$email}'")) > 0) {
            throw new Exception("This Email: '{$email}' already exists.");
        } elseif (mysqli_num_rows(mysqli_query($conx, "SELECT * FROM register WHERE Username='{$name}'")) > 0) {
            throw new Exception("This Username: '{$name}' already exists.");
        } else {
            if ($password === $confirmPassword) {
                if (strlen($password) < 8 || strlen($password) > 32) {
                    throw new Exception("Password must be between 8 and 32 characters long.");
                } elseif (!preg_match("/[~!@#$%^*()_+\-=\[\]{}|:;\"',.?]/", $password)) {
                    throw new Exception("Password must contain at least one special character.");
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                    $query = "INSERT INTO register(`Username`, `email`, `Password`) VALUES ('$name','$email','$hashedPassword')";
                    $result = mysqli_query($conx, $query);
                    if ($result) {
                        $msg = "<div class='alert alert-info'>Sign up successful, now contact the admin for assistance</div>";
                        $logMessage = "{$email} signed up for an account!";
                        $logInsert = "INSERT INTO log (account, action) VALUES ('$name', '$logMessage')";
                        mysqli_query($conx, $logInsert);
                    } else {
                        throw new Exception("Something went wrong");
                    }
                }
            } else {
                throw new Exception("Password and Confirm Password do not match");
            }
        }
    } catch (Exception $e) {
        $msg = "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
        $Error_Pass = 'style="border:1px Solid red;box-shadow:0px 1px 11px 0px red"';
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
    <title>Senior Solutions | Sign Up</title>
    <link rel="icon" href="img/sslogo.png">
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
            background-color: #24c70f;
        }

        .alert-warning {
            background-color: #ff9966;
        }

        .eye-toggle {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }
    </style>
    <script>
        function checkPasswordStrength() {
            const passwordInput = document.getElementById('password-input');
            const strengthText = document.getElementById('password-strength');

            const password = passwordInput.value;
            const strength = calculatePasswordStrength(password);

            strengthText.innerText = 'Password Strength: ' + strength;
            strengthText.style.color = getStrengthColor(strength);
        }

        function calculatePasswordStrength(password) {
            if (password.length < 8) {
                return 'Weak';
            } else if (password.length < 11) {
                return 'Medium';
            } else {
                return 'Strong';
            }
        }

        function getStrengthColor(strength) {
            if (strength === 'Weak') {
                return 'red';
            } else if (strength === 'Medium') {
                return 'yellow';
            } else {
                return '#9efda6';
            }
        }

        function togglePasswordVisibility(inputId) {
        const inputElement = document.getElementById(inputId);
        const toggleIcon = document.getElementById(inputId + "-toggle-icon");

        if (inputElement.type === "password") {
            inputElement.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            inputElement.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }
    </script>

</head>

<body>
    <div class="container sign-up-mode">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="" method="POST" class="sign-up-form">
                    <h2 class="title">Sign up</h2>
                    <?php echo $msg ?>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="Username" placeholder="Username" maxlength="20" value="<?php if (isset($_POST['Username'])) {
                                                                                                            echo $name;
                                                                                                        } ?>" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="Email" placeholder="Email" value="<?php if (isset($_POST['Email'])) {
                                                                                        echo $email;
                                                                                    } ?>" required />
                    </div>
                    <div class="input-field" <?php echo $Error_Pass ?>>
                        <i class="fas fa-lock"></i>
                        <input type="password" name="Password" id="password-input" placeholder="Password" onkeyup="checkPasswordStrength()" required />
                        <span class="eye-toggle" onclick="togglePasswordVisibility('password-input')">
                            <i class="far fa-eye" id="password-toggle-icon"></i>
                        </span>
                    </div>
                    <div class="input-field" <?php echo $Error_Pass ?>>
                        <i class="fas fa-lock"></i>
                        <input type="password" name="Conf-Password" id="conf-password-input" placeholder="Confirm Password" required />
                        <span class="eye-toggle" onclick="togglePasswordVisibility('conf-password-input')">
                            <i class="far fa-eye" id="conf-password-toggle-icon"></i>
                        </span>
                    </div>
                    <span id="password-strength"></span>
                    <input type="submit" name="submit" class="btn" value="Sign up" />


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
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h2>Already have an account? <br>Try logging in!</br></h2>
                    <p class="invitext">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
                        laboriosam ad deleniti.
                    </p>
                    <a href="index.php" class="btn transparent" id="sign-in-btn" style="padding:10px 20px;text-decoration:none">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
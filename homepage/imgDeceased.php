<?php
session_start();

if (!isset($_COOKIE['Email_Cookie']) || !isset($_SESSION['logged_in'])) {
  header("Location: ../index.php");
  exit();
}

include('../configuration/config.php');
$sql = "SELECT * FROM register";
$result = $conx->query($sql);

$email = $_COOKIE['Email_Cookie'];
$autoOutQuery = "SELECT autoOut FROM register WHERE email='{$email}'";
$autoOutResult = mysqli_query($conx, $autoOutQuery);
$autoOutRow = mysqli_fetch_assoc($autoOutResult);
$autoOut = $autoOutRow['autoOut'];
$forStatus = "SELECT status FROM register WHERE email='{$email}'";
$forStatusResult = mysqli_query($conx, $forStatus);
$forStatusRow = mysqli_fetch_assoc($forStatusResult);
$forStatus1 = $forStatusRow['status'];
if ($autoOut == 'Yes' || $forStatus1 == 'Disabled') {
  include("logoutupdate.php");
  exit();
}
if ($_SESSION['role'] === 'User') {
  $error_msg = 'You are in "User" only role, contact your supervisor for assistance';
} else {
  include("connect.php");
  $sql = "SELECT * FROM register";
  $result = $conx->query($sql);

  mysqli_close($conx);
}
$id = isset($_GET['id']) ? $_GET['id'] : null;
if ($id) {
  $sql = "SELECT * FROM people WHERE id = $id";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $imagePath = "{$row['deceasedCert']}";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View | <?php echo $row["firstName"]; ?></title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="../img/sslogo.png"> 
</head>
<style>
    body{
        background-color: gray;
    }
        .userimage {
            text-align: center;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .centered-image {
           height: auto;
           width: auto;
            
        }
        .backbutton {
  position: fixed;
  top: 2vh;
  left: 5vh;
  background-color: #29299B;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 1vh 2vh;
  display: flex;
  align-items: center;
  gap: 5px;
  font-size: 1.6vh;
  font-weight: bold;
  height: 6vh;
  cursor: pointer;
  height: 8%;
  width: 7%;
  align-items: center;
  justify-content: center;
}

.backbutton-icon {
  width: 2vh;
  height: 2vh;
}

.backbutton-text {
  text-transform: uppercase;
}

.backbutton:hover {
  background-color: #46469C;
}

.backbutton:active {
  background-color: #272757;
}

    </style>
<body>
<div class="userimage">
        <img src="<?php echo $imagePath; ?>" alt="Deceased Image" class="centered-image">
    </div>

    <button class="backbutton" id="backbutton">
  <img src="images/backbutton.png" class="backbutton-icon">
  <span class="backbutton-text">Back</span>
</button>
<script>
  var backButton = document.getElementById("backbutton");
  backButton.addEventListener("click", function() {
    history.back();
  });
</script>
</body>
</html>

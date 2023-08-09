<?php
session_start();

if (!isset($_COOKIE['Email_Cookie']) || !isset($_SESSION['logged_in'])) {
  header("Location: ../index.php");
  exit();
}

include('../configuration/config.php');

$email = $_COOKIE['Email_Cookie'];
$autoOutQuery = "SELECT autoOut FROM register WHERE email='{$email}'";
$autoOutResult = mysqli_query($conx, $autoOutQuery);
$autoOutRow = mysqli_fetch_assoc($autoOutResult);
$autoOut = $autoOutRow['autoOut'];

$forStatus = "SELECT status FROM register WHERE email='{$email}'";
$forStatusResult = mysqli_query($conx, $forStatus);
$forStatusRow = mysqli_fetch_assoc($forStatusResult);
$forStatus1 = $forStatusRow['status'];  

$forOffline = "SELECT activeStatus FROM register WHERE email='{$email}'";
$forOfflineResult = mysqli_query($conx, $forOffline);
$forOfflineRow = mysqli_fetch_assoc($forOfflineResult);
$forOffline1 = $forOfflineRow['activeStatus'];

if ($autoOut == 'Yes' || $forStatus1 == 'Disabled' || $forOffline1 == 'Offline') {
  include("logoutupdate.php");
  exit();
}



$sql = "SELECT * FROM register";
$result = $conx->query($sql);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8" />
  <title>Add Record</title>

 
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="../img/sslogo.png">
  <style>
   .home-content {
      padding: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      background-color: lightblue;
      height: 100vh;
    }
    body{
        background-color: lightblue;
    }

    .container {
      max-width: 600px;
      width: 100%;
      margin: 0 auto;
      
    }

    .form-element {
      margin-bottom: 20px;
      
    }

    .form-control {
      width: 100%;
      padding: 10px;
      border-radius: 4px;
      
      border: 1px solid #ccc;
    }

    .btn {
      display: inline-block;
      padding: 10px 20px;
      font-size: 16px;
      font-weight: bold;
      text-align: center;
      text-decoration: none;
      border-radius: 4px;
      background-color: #4e73df;
      color: #fff;
      transition: background-color 0.3s ease;
    }

    .btn:hover {
      background-color: #2653d4;
    }

    @media screen and (max-width: 768px) {
      .container {
        padding: 0 20px;
      }
    }

    /* Import Google font - Poppins */
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
  
  
}


.container {
  margin-top: 70px;
  position: relative;
 text-align: center;
  max-width: 500px;
  width: 100%;
  background: #fff;
  padding: 25px;
  border-radius: 8px;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
  
}
.container header {
  font-size: 1.5rem;  
  color: #333;
  font-weight: 500;
  text-align: center;
  
}
.container .form {
  margin-top: 30px;
  
}
.form .input-box {
  width: 100%;
  margin-top: 20px;
  
}
.input-box label {
  color: #333;
  
}
.form :where(.input-box input, .select-box) {
  position: relative;
  height: 50px;
  width: 100%;
  outline: none;
  font-size: 1rem;
  color: black;
  margin-top: 8px;
  border: 1px solid #ddd;
  border-radius: 6px;
  padding: 0 15px;
  
}
.input-box input:focus {
  box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
}
.form .column {
  display: flex;
  column-gap: 15px;
  
}
.form .gender-box {
  margin-top: 20px;
}
.gender-box h3 {
  color: #333;
  font-size: 1rem;
  font-weight: 400;
  margin-bottom: 8px;
}
.form :where(.gender-option, .gender) {
  display: flex;
  align-items: center;
  column-gap: 50px;
  flex-wrap: wrap;
}
.form .gender {
  column-gap: 5px;
}

.gender input {
  accent-color: (#fff);
}
.form :where(.gender input, .gender label) {
  cursor: pointer;
}
.gender label {
  color: #707070;
}
.address :where(input, .select-box) {
  margin-top: 15px;
}
.select-box select {
  height: 100%;
  width: 100%;
  outline: none;
  border: none;
  color: #707070;
  font-size: 1rem;
}
.form button {
  height: 55px;
  width: 100%;
  color: #fff;
  font-size: 1rem;
  font-weight: 400;
  margin-top: 30px;
  border: none;
  cursor: pointer;
  transition: all 0.2s ease;
  background: rgb(51, 51, 255);
}
.form button:hover {
  background: rgb(0, 0, 255);
}
/*Responsive*/
@media screen and (max-width: 500px) {
  .form .column {
    flex-wrap: wrap;
  }
  .form :where(.gender-option, .gender) {
    row-gap: 15px;
  }
}


input:hover,
input:focus {
  background-color: lightgray;
}

.checkmark {
      font-size: 64px;
      color: #28a745;
      margin-bottom: 20px;
    }

    .message {
      font-size: 18px;
      color: #333;
      margin-bottom: 20px;
    }

    .ok-button {
      padding: 10px 20px;
      font-size: 16px;
      font-weight: bold;
      text-align: center;
      text-decoration: none;
      border-radius: 4px;
      background-color: #4e73df;
      color: #fff;
      transition: background-color 0.3s ease;
      border: none;
      cursor: pointer;
    }

    .ok-button:hover {
      background-color: #2653d4;
    }


  </style>
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <a href="homelog.php">
        <img src="../img/sslogo.png" alt="" class="logo-details">
      </a>
      <span class="logo_name">Senior Solutions</span>
    </div>
    <ul class="nav-links">
  
    <li>
        <a href="dashboard.php">
          <i class="bx bx-grid-alt"></i>
          <span class="links_name">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="homelog.php">
          <i class="bx bx-list-ul"></i>
          <span class="links_name">Record Lists</span>
        </a>
      </li>
      <li>
        <a href="userlog.php">
          <i class="bx bx-user"></i>
          <span class="links_name">User Log</span>
        </a>
      </li>
      <li>
        <a href="addrecord.php">
          <i class="bx bx-box"></i>
          <span class="links_name">Add Record</span>
        </a>
      </li>
    
    
      <li class="log_out">
        <a href="logout.php" id="logoutLink">
          <i class="bx bx-log-out"></i>
          <span class="links_name">Log out</span>
        </a>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class="bx bx-menu sidebarBtn"></i>
        <span class="dashboard">Add Record</span>
      </div>

      <div class="profile-details">
    <img src="../img/profilepicture.jpg" alt="">
    <span class="admin_name">
        <?php 
        if(isset($_SESSION['user_name'])) {
            echo $_SESSION['user_name'];
        }
        ?>
    </span>
</div>
    </nav>
    <div class="home-content">
    
    <section class="container">
    <header>Success!</header>
    <br>
    <i class="fa-regular fa-circle-check"></i>
    <br><br>
      <p class="message">Person Information Added Successfully</p>
      
      <a class="btn ok-button" href="addrecord.php">OK, close</a>
    </section>
        </div>
  </section>

  <script>
    
  let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function() {
  sidebar.classList.toggle("active");
  if(sidebar.classList.contains("active")){
  sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
}else
  sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
}
  </script>
</body>

</html>

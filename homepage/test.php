<?php
session_start();

if (!isset($_COOKIE['Email_Cookie']) || !isset($_SESSION['logged_in'])) {
  header("Location: ../index.php");
  exit();
}

include('../configuration/config.php');
$sql = "SELECT * FROM register";
$result = $conx->query($sql);
include("connect.php");
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
} elseif ($_SESSION['role'] === 'Admin') {
  $error_msg = 'You are in "Admin" role, contact your supervisor for assistance';
} else {
  include("connect.php");
  $sql = "SELECT * FROM register";
  $result = $conx->query($sql);

  mysqli_close($conx);
}

$id = $_GET['id'];
if ($id) {
  $sql = "SELECT * FROM people WHERE id = $id";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_array($result)) {
    $birthDate = new DateTime($row["birthDate"]);
    $currentDate = new DateTime();
    $age = $currentDate->diff($birthDate)->y;

    $selectedSpecializations = explode(",", $row['specialization']);
    $selectedComService = explode(",", $row['communityService']);
    $selectedResidingWith = explode(",", $row['residingwith']);
    $selectedSourceIncome = explode(",", $row['sourceIncome']);
    $selectedAssetsFirst = explode(",", $row['assetsFirst']);
    $selectedAssetsSecond = explode(",", $row['assetsSecond']);
    $selectedProblems = explode(",", $row['problems']);
    $selectedMedicalConcerns = explode(",", $row['medicalConcern']);


$personStatus = $row["personStatus"];

if ($personStatus == "Deceased") {
  $hideClass = "hidden";
} else {
  $hideClass = ""; 
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8" />
  <title>Edit | <?php echo $row["firstName"]; ?></title>

 
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="../img/sslogo.png">
  <style>
   .home-content {
      padding: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      background-color: lightblue;
      
    }

    .container {
      max-width: 600px;
      width: 100%;
      margin: 0 auto;
      position: relative;
    max-width: 1500px;
    background: #fff;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
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
  .nextbutton,
  .nextbutton2,
  .nextbutton3,
  .nextbutton4,
  .nextbutton5,
  .nextbutton6
 {
  height: 55px;
  width: 100%;
  color: #fff;
  font-size: 1rem;
  font-weight: 400;
  margin-top: 30px;
  border: none;
  cursor: pointer;
  transition: all 0.2s ease;
  background: linear-gradient(90deg, rgb(135, 135, 135) 0%, rgb(90, 90, 219) 100%);
  border-radius: 4px;
}

.previousbutton,
  .previousbutton2,
  .previousbutton3,
  .previousbutton4,
  .previousbutton5,
  .previousbutton6{
    height: 55px;
  width: 100%;
  color: #fff;
  font-size: 1rem;
  font-weight: 400;
  margin-top: 30px;
  border: none;
  cursor: pointer;
  transition: all 0.2s ease;
  background: linear-gradient(90deg, rgb(90, 90, 219) 0%, rgb(135, 135, 135) 100%);
  border-radius: 4px;
  }

  .form #addChild2Button,
  #addChild3Button,
  #addChild4Button,
  #addChild5Button,
  #addChild6Button,
  #addChild7Button,
  #addChild8Button,
  #addChild9Button,
  #addChild10Button,
  #dependent2Button,
  #dependent3Button,
  #dependent4Button,
  #dependent5Button{
    height: 40px;
    width: 20%;
    color: #fff;
    font-size: 1rem;
    font-weight: 400;
    margin-top: 15px;
    margin-bottom: 15px;
    border-radius: 30px;
    cursor: pointer;
    transition: all 0.2s ease;
    background: #3244CB;
  }



.nextbutton:hover,
.nextbutton:hover,
  .nextbutton2:hover,
  .nextbutton3:hover,
  .nextbutton4:hover,
  .nextbutton5,
  .nextbutton6,
  .previousbutton:hover,
  .previousbutton2:hover,
  .previousbutton3:hover,
  .previousbutton4:hover,
  .previousbutton5,
  .previousbutton6 {
    background: linear-gradient(90deg, rgb(98, 98, 98) 0%, rgb(41, 41, 155) 100%);
}

.submitbutton {
  height: 55px;
  width: 100%;
  color: #fff;
  font-size: 1rem;
  font-weight: 400;
  margin-top: 30px;
  border: none;
  cursor: pointer;
 
  background: linear-gradient(90deg, rgb(0, 0, 255) 0%, rgb(28, 219, 66) 100%);
  border-radius: 4px;
}

.submitbutton:hover  {
    background: #1CDB42;
}

  .form #deceasedbutton
{
    height: 40px;
    width: 10%;
    color: #fff;
    font-size: 1rem;
    font-weight: 400;
    margin-top: 15px;
    margin-bottom: 15px;
    border-radius: 30px;
    cursor: pointer;
    transition: all 0.2s ease;
    background: red;
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


  .hidden,
  .hidden3,
  .hidden4,
  .hidden5,
  .hidden6,
  .hidden7,
  .hidden8,
  .hidden9,
  .hidden10,
  .dependent2,
  .dependent3,
  .dependent4,
  .dependent5,
  .hide-button,
  .hide-page,
  .page2,
  .page3,
  .page4,
  .page5,
  .page6,
  .hiddendec {
    display: none;
    }
    .invisiblebutton{
      visibility: hidden;
    }

    .progress-bar {
      text-align: center;
    display: flex;
    justify-content: space-between;
    width: 80%;
    margin-bottom: 20px;
    margin: 0 auto 20px;
  }
  
  .progress-bar span {
    width: 150px;
    height: 3px;
    background-color: lightgray;
    display: inline-block;
  }
  
  .progress-bar .active {
    background-color: blue;
  }
  .form .columncheckbox {
  display: grid;
  grid-template-columns: repeat(2, 1fr); /* Adjust the number of columns as needed */
 
}
    

  
  </style>
</head>

<body>

<?php if (isset($error_msg)): ?>
    <div class="error-container">
      <div class="error-message"><?php echo $error_msg; ?></div>
      <button class="go-back-button" onclick="goBack()">Go back</button>
    </div>

    <script>
      function goBack() {
        window.history.back();
      }
    </script>
  <?php else: ?>
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
        <a href="homelog.php" class="active">
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
  <nav class="hidefeature">
  <div class="sidebar-button">
    <i class="bx bx-menu sidebarBtn hidefeature"></i>
    <span class="dashboard">Editing <?php echo $row["firstName"]; ?>'s Profile</span>
    <a href="view.php?id=<?php echo $_GET['id']; ?>" class="btn btn-info">View Profile</a>
</div>


      
      <div class="profile-details">
    <img src="../img/profilepicture.jpg" class="hidefeature">
    <span class="admin_name">
        <?php 
        if(isset($_SESSION['user_name'])) {
            echo $_SESSION['user_name'];
        }
        ?>
    </span>
</div>

<?php      
    if (isset($_GET['id'])) {
        include("connect.php");
        $id = $_GET['id'];
        $sql = "SELECT * FROM people WHERE id=$id";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result);
        ?>

    </nav>
    <div class="home-content">


    <section class="container">

   
      <header> <br>
     <?php echo $row["firstName"]; ?>'s Data Form</header>
      <?php
            }else{
                echo "<h3>Person Does Not Exist</h3>";
            }
            ?>


      <form action="process.php" class="form" method="post" enctype="multipart/form-data">
      <div class="page">

      <div class="progress-bar">
    <span class="active"></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
  </div>
      <h1 style="background-color: lightblue; color: black; font-size: 25px">I. Identifying Information</h1>
    



<div class=" <?php echo $hideClass; ?>">
  <button class="deceasedbutton" id="deceasedbutton">Deceased?</button>
  <div class="">
    <h3 style="color:red;">Deceased.</h3>
    <b>Warning! this will change the person status into deceased, and it cannot change back! <br> Do this only if you are sure!</b>
    <div class="column">
      <div class="select-box">
        <select name="personStatus" id="personStatus">
          <option hidden>Active</option>
          <option value="Active" <?php if($personStatus == "Active"){echo "selected";} ?>>Active</option>
          <option value="Deceased" <?php if($personStatus == "Deceased"){echo "selected";} ?>>Deceased</option>
        </select>
      </div>
      <div class="input-box" id="invitext"></div>
      <div class="input-box" id="invitext"></div>
    </div>
  </div>
</div>
<br>

<label>Upload the image for proof.</label>
<div class="uploadimage1">
  <input type="file" name="deceasedCert" accept="image/*" id="imageInput1" onchange="updateLabel(this)"/>
  <label for="imageInput1">Upload Image</label>
</div>



<input type="hidden" name="dateDeceased" id="dateDeceased" value="">

    <div class="column">
        <button class="previousbutton5" id="previousbutton5">Previous</button>
        <input type="hidden" value="<?php echo $id; ?>" name="id">
          <button class="submitbutton" type="submit" name="edit" value="Submit">Update</button>
      </div>
      </div>

    <!-- END OF PAGE 6!! -->

      </form>
    </section>

    </div>
  </section>












        









  <script>
 function validateCharacterOnly(event) {
    var input = event.target;
    var regex = /^[A-Za-z .]+$/;
    var isValid = regex.test(input.value);
    if (!isValid) {
      input.setCustomValidity("Number inputs aren't allowed!");
    } else {
      input.setCustomValidity("");
    }
  }

  function validateRequired(event) {
    var input = event.target;
    var regex = /^[A-Za-z .]+$/;
    var isValid = regex.test(input.value);
    if (!isValid) {
      input.setCustomValidity("Number inputs aren't allowed!");
    } else {
      input.setCustomValidity("");
    }
  }



  let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function() {
  sidebar.classList.toggle("active");
  if(sidebar.classList.contains("active")){
  sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
}else
  sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
}

   const addChild2Button = document.getElementById('addChild2Button');
   const addChild3Button = document.getElementById('addChild3Button');
   const addChild4Button = document.getElementById('addChild4Button');
   const addChild5Button = document.getElementById('addChild5Button');
   const addChild6Button = document.getElementById('addChild6Button');
   const addChild7Button = document.getElementById('addChild7Button');
   const addChild8Button = document.getElementById('addChild8Button');
   const addChild9Button = document.getElementById('addChild9Button');
   const addChild10Button = document.getElementById('addChild10Button');
   const dependent2Button = document.getElementById('dependent2Button');
   const dependent3Button = document.getElementById('dependent3Button');
   const dependent4Button = document.getElementById('dependent4Button');
   const dependent5Button = document.getElementById('dependent5Button');
   const deceasedbutton = document.getElementById('deceasedbutton');
   const hiddenDiv = document.querySelector('.hidden');
   const hiddenDiv3 = document.querySelector('.hidden3');
   const hiddenDiv4 = document.querySelector('.hidden4');
   const hiddenDiv5 = document.querySelector('.hidden5');
   const hiddenDiv6 = document.querySelector('.hidden6');
   const hiddenDiv7 = document.querySelector('.hidden7');
   const hiddenDiv8 = document.querySelector('.hidden8');
   const hiddenDiv9 = document.querySelector('.hidden9');
   const hiddenDiv10 = document.querySelector('.hidden10');
   const hiddenDivDep2 = document.querySelector('.dependent2');
   const hiddenDivDep3 = document.querySelector('.dependent3');
   const hiddenDivDep4 = document.querySelector('.dependent4');
   const hiddenDivDep5 = document.querySelector('.dependent5');
   const hiddenDivDec = document.querySelector('.hiddendec');


   deceasedbutton.addEventListener('click', function(event) {
     event.preventDefault(); 
     deceasedbutton.classList.add('hide-button');
     hiddenDivDec.classList.remove('hiddendec'); 
   });

   var personStatusSelect = document.getElementById("personStatus");
  var elementsToHide = document.getElementsByClassName("hideifdeceased");

  function updateElementsVisibility() {
    var selectedValue = personStatusSelect.value;

    if (selectedValue === "Deceased") {
      for (var i = 0; i < elementsToHide.length; i++) {
        elementsToHide[i].style.display = "none";
      }
    } else {
      for (var i = 0; i < elementsToHide.length; i++) {
        elementsToHide[i].style.display = "";
      }
    }
  }

  document.getElementById('personStatus').addEventListener('change', function() {
    var statusSelect = document.getElementById('personStatus');
    var dateDeceasedInput = document.getElementById('dateDeceased');

    if (statusSelect.value === 'Deceased') {
      // Set the value of the hidden input field to the current date
      dateDeceasedInput.value = new Date().toISOString().split('T')[0];
    } else {
      // Reset the value of the hidden input field
      dateDeceasedInput.value = '';
    }
  });

dependent2Button.addEventListener('click', function(event) {
     event.preventDefault(); 
     dependent2Button.classList.add('hide-button');
     hiddenDivDep2.classList.remove('dependent2');
     dependent3Button.classList.remove('hidden');
   });


   dependent3Button.addEventListener('click', function(event) {
     event.preventDefault(); 
     dependent3Button.classList.add('hide-button');
     hiddenDivDep3.classList.remove('dependent3'); 
     dependent4Button.classList.remove('hidden'); 
   });

   dependent4Button.addEventListener('click', function(event) {
     event.preventDefault(); 
     dependent4Button.classList.add('hide-button');
     hiddenDivDep4.classList.remove('dependent4'); 
     dependent5Button.classList.remove('hidden'); 
   });

   dependent5Button.addEventListener('click', function(event) {
     event.preventDefault(); 
     dependent5Button.classList.add('hide-button');
     hiddenDivDep5.classList.remove('dependent5');
   });

   addChild2Button.addEventListener('click', function(event) {
     event.preventDefault(); 
     addChild2Button.classList.add('hide-button');
     hiddenDiv.classList.remove('hidden'); 
     addChild3Button.classList.remove('hidden'); 
   });
   
   addChild3Button.addEventListener('click', function(event) {
     event.preventDefault(); 
     addChild3Button.classList.add('hide-button');
     hiddenDiv3.classList.remove('hidden3'); 
     addChild4Button.classList.remove('hidden'); 
   });

   addChild4Button.addEventListener('click', function(event) {
     event.preventDefault(); 
     addChild4Button.classList.add('hide-button');
     hiddenDiv4.classList.remove('hidden4'); 
     addChild5Button.classList.remove('hidden');
   });

   addChild5Button.addEventListener('click', function(event) {
     event.preventDefault();
     addChild5Button.classList.add('hide-button');
     hiddenDiv5.classList.remove('hidden5');
     addChild6Button.classList.remove('hidden'); 
   });

   addChild6Button.addEventListener('click', function(event) {
     event.preventDefault();
     addChild6Button.classList.add('hide-button');
     hiddenDiv6.classList.remove('hidden6');
     addChild7Button.classList.remove('hidden');
   });

   addChild7Button.addEventListener('click', function(event) {
     event.preventDefault(); 
     addChild7Button.classList.add('hide-button');
     hiddenDiv7.classList.remove('hidden7'); 
     addChild8Button.classList.remove('hidden');
   });

   addChild8Button.addEventListener('click', function(event) {
     event.preventDefault(); 
     addChild8Button.classList.add('hide-button');
     hiddenDiv8.classList.remove('hidden8');
     addChild9Button.classList.remove('hidden'); 
   });

   addChild9Button.addEventListener('click', function(event) {
     event.preventDefault(); 
     addChild9Button.classList.add('hide-button');
     hiddenDiv9.classList.remove('hidden9');
     addChild10Button.classList.remove('hidden'); 
   });

   addChild10Button.addEventListener('click', function(event) {
     event.preventDefault(); 
     addChild10Button.classList.add('hide-button');
     hiddenDiv10.classList.remove('hidden10'); 
   });


   function maskTIN(input) {
  const unmaskedValue = input.value.replace(/\D/g, '');
  const maskedValue = unmaskedValue
    .slice(0, 12)
    .replace(/(\d{3})(\d{0,3})(\d{0,3})(\d{0,3})/, function(match, group1, group2, group3, group4) {
      let masked = group1;
      if (group2) masked += '-' + group2;
      if (group3) masked += '-' + group3;
      if (group4) masked += '-' + group4;
      return masked;
    });
  input.value = maskedValue;
}

function restrictToNumbers(input) {
  input.value = input.value.replace(/[^0-9-]/g, '');
}

function restrictToNumbersWithHyphen(input) {
  input.value = input.value.replace(/[^0-9]/g, '');
  const unmaskedValue = input.value.replace(/-/g, '');
  const maskedValue = unmaskedValue
    .slice(0, 12)
    .replace(/^(\d{2})(\d{0,9})(\d{0,2})/, function(match, group1, group2, group3) {
      let masked = group1;
      if (group2) masked += '-' + group2;
      if (group3) masked += '-' + group3;
      return masked;
    });
  input.value = maskedValue;
}

// PREVIOUS AND NEXT PAGE BUTTONS!!!
function scrollToTop() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    document.getElementById('previousbutton').addEventListener('click', scrollToTop);
    document.getElementById('nextbutton').addEventListener('click', scrollToTop);
    document.getElementById('previousbutton2').addEventListener('click', scrollToTop);
    document.getElementById('nextbutton2').addEventListener('click', scrollToTop);
    document.getElementById('previousbutton3').addEventListener('click', scrollToTop);
    document.getElementById('nextbutton3').addEventListener('click', scrollToTop);
    document.getElementById('previousbutton4').addEventListener('click', scrollToTop);
    document.getElementById('nextbutton4').addEventListener('click', scrollToTop);
    document.getElementById('previousbutton5').addEventListener('click', scrollToTop);
    document.getElementById('nextbutton5').addEventListener('click', scrollToTop);

    

   const nextbutton = document.getElementById('nextbutton');  
   const nextbutton2 = document.getElementById('nextbutton2');
   const nextbutton3 = document.getElementById('nextbutton3');
   const nextbutton4 = document.getElementById('nextbutton4');
   const nextbutton5 = document.getElementById('nextbutton5');
   const nextbutton6 = document.getElementById('nextbutton6');

   const previousbutton = document.getElementById('previousbutton');
   const previousbutton2 = document.getElementById('previousbutton2');
   const previousbutton3 = document.getElementById('previousbutton3');
   const previousbutton4 = document.getElementById('previousbutton4');
   const previousbutton5 = document.getElementById('previousbutton5');
   const previousbutton6 = document.getElementById('previousbutton6');

   const hidepage = document.querySelector('.page');
   const hidepage2 = document.querySelector('.page2');
   const hidepage3 = document.querySelector('.page3');
   const hidepage4 = document.querySelector('.page4');
   const hidepage5 = document.querySelector('.page5');
   const hidepage6 = document.querySelector('.page6');

   nextbutton.addEventListener('click', function(event) {
  event.preventDefault();

  const inputLastName = document.getElementsByName('lastName')[0];
  const inputFirstName = document.getElementsByName('firstName')[0];
  const inputProvince = document.getElementsByName('province')[0];
  const inputCity = document.getElementsByName('city')[0];
  const barangaySelect = document.getElementById('barangaySelect');
  const inputHouseNo = document.getElementsByName('houseno')[0];
  const inputStreet = document.getElementsByName('street')[0];
  const inputBirthDate = document.getElementsByName('birthDate')[0];

  if (inputLastName.value.trim() === '') {
    alert('Please enter your last name');
  }
  
  else if (inputFirstName.value.trim() === '') {
    alert('Please enter your first name');
  }
  else if (inputProvince.value.trim() === '') {
    alert('Please enter your province');
  }
  else if (inputCity.value.trim() === '') {
    alert('Please enter your city/municipality');
  }
  else if (barangaySelect.value.trim() === 'Select Barangay') {
    alert('Please enter your barangay');
  }
  else if (inputHouseNo.value.trim() === '') {
    alert('Please enter your house number');
  }
  else if (inputStreet.value.trim() === '') {
    alert('Please enter your street');
  }
  else if (inputBirthDate.value.trim() === '') {
    alert('Please enter your date of birth');
  } 
  else {
    hidepage.classList.add('hide-page');
    hidepage2.classList.remove('page2');
    hidepage2.classList.remove('hide-page');
  }
});
   previousbutton.addEventListener('click', function(event) {
     event.preventDefault(); 
     hidepage.classList.remove('hide-page');
     hidepage2.classList.add('hide-page'); 
   });

   nextbutton2.addEventListener('click', function(event) {
     event.preventDefault(); 
     hidepage2.classList.add('hide-page');
     hidepage3.classList.remove('page3'); 
     hidepage3.classList.remove('hide-page'); 
   });

   previousbutton2.addEventListener('click', function(event) {
     event.preventDefault(); 
     hidepage2.classList.remove('hide-page');
     hidepage3.classList.add('hide-page'); 
   });

   nextbutton3.addEventListener('click', function(event) {
     event.preventDefault(); 
     hidepage3.classList.add('hide-page');
     hidepage4.classList.remove('page4'); 
     hidepage4.classList.remove('hide-page');
   });

   previousbutton2.addEventListener('click', function(event) {
     event.preventDefault(); 
     hidepage2.classList.remove('hide-page');
     hidepage3.classList.add('hide-page'); 
   });

   nextbutton4.addEventListener('click', function(event) {
     event.preventDefault(); 
     hidepage4.classList.add('hide-page');
     hidepage5.classList.remove('page5'); 
     hidepage5.classList.remove('hide-page');
   });

   previousbutton3.addEventListener('click', function(event) {
     event.preventDefault(); 
     hidepage3.classList.remove('hide-page');
     hidepage4.classList.add('hide-page'); 
   });

   nextbutton5.addEventListener('click', function(event) {
     event.preventDefault(); 
     hidepage5.classList.add('hide-page');
     hidepage6.classList.remove('page6'); 
     hidepage6.classList.remove('hide-page');
   });

   previousbutton4.addEventListener('click', function(event) {
     event.preventDefault(); 
     hidepage4.classList.remove('hide-page');
     hidepage5.classList.add('hide-page'); 
   });
   
   previousbutton5.addEventListener('click', function(event) {
     event.preventDefault(); 
     hidepage5.classList.remove('hide-page');
     hidepage6.classList.add('hide-page'); 
   });

   const imageInput = document.getElementById("imageInput");
  const label = document.querySelector(".uploadimage label");

  imageInput.addEventListener("change", function () {
    const file = this.files[0];
    if (file) {
      label.style.backgroundImage = `url('${URL.createObjectURL(file)}')`;
      label.setAttribute("data-filename", file.name);
    } else {
      label.style.backgroundImage = "";
      label.setAttribute("data-filename", "");
    }
  });

  
  function updateLabel(input) {
  const fileName = input.files[0].name;
  const label = input.nextElementSibling;
  label.setAttribute('data-file-name', fileName);
}





  </script>
  <?php endif;
        }
      }
      else{
          echo "<h3>No such person found</h3>";
      }
   ?>
</body>

</html>

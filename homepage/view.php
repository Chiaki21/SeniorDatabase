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
    include('../configuration/config.php');
    $sql = "SELECT * FROM register";
    $result = $conx->query($sql);

    mysqli_close($conx);
}
include('../configuration/config.php');
$id = isset($_GET['id']) ? $_GET['id'] : null;
if ($id) {
    $sql = "SELECT * FROM people WHERE id = $id";
    $result = mysqli_query($conx, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $birthDate = $row["birthDate"];
        $formattedBirthDate = null;

        // Check for valid date formats and convert to desired format
        if (preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $birthDate)) {
            $formattedBirthDate = $birthDate;
        } elseif (preg_match("/^\d{4}-\d{2}-\d{2}$/", $birthDate)) {
            $dateParts = explode('-', $birthDate);
            $formattedBirthDate = $dateParts[1] . '/' . $dateParts[2] . '/' . $dateParts[0];
        } elseif (preg_match("/^\d{2}-\d{2}-\d{4}$/", $birthDate)) {
            $dateParts = explode('-', $birthDate);
            $formattedBirthDate = $dateParts[0] . '/' . $dateParts[1] . '/' . $dateParts[2];
        }

        $age = null;
        if ($formattedBirthDate) {
            $birthDateObj = new DateTime($formattedBirthDate);
            $currentDate = new DateTime();
            $age = $currentDate->diff($birthDateObj)->y;
        }
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <title>View | <?php echo $row["firstName"]; ?></title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
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
  position: relative;
  max-width: 3000px;
  width: 100%;
  background: #fff;
  padding: 25px;
  border-radius: 8px;
  margin: 0 auto;

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
  margin-top: 10px;
  color:#2C2C2C;
  
}

.form .input-boxq {
  width: 100%;
  color:#2C2C2C;
  
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
.uploaded-image {
    width: 200px;
    height: 200px;
    min-width: 100px;
    min-height: 100px;
    border-radius: 20px;

}

.userimage {
  display: flex;
  align-items: center;
  margin-right: 50px;
}
.no-image {
  font-size: 18px;
  color: #888;
  background-color: #f1f1f1;
  width: 200px;
  height: 200px;
  text-align: center;
  border-radius: 20px;
}

.printbutton {
  background-color: #29299B;
  color: #f1f1f1;
  width: 200px;
  height: 60px;
  border: none;
  padding: 10px 20px;
  font-size: 16px;
  border-radius: 4px;
  margin-right:10px;
  position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 9999;
      cursor: pointer;
}
.printbutton .printicon {
  width: 16px;
  height: 16px;
  margin-right: 8px;
  vertical-align: middle;
}
.printbutton:hover {
  background-color: #46469C;
}

.printbutton:focus {
  outline: none;
}
.printbutton:active {
  background-color: #272757;
}
  

.btn-edit {
  background-color: #ffa500;
  color: white;
  margin-right: 20px;
  user-select: none;
}

.btn-edit:hover{
  background-color: #CA8700;
}
.btn-edit:active{
  background-color: #A16B00;
}

.btn-disable {
  background-color: #dc143c;
  color: white;
  margin-right: 20px;
  user-select: none;
}

.btn-disable:hover{
  background-color: #C01235;
}
.btn-disable:active{
  background-color: #9A102C;
}
.status {
    padding: 10px;
    font-weight: bold;
    width:fit-content;
    border-radius: 20px;
}

.status.active {
    background-color: green;
    color: white;
}

.status.deceased {
    background-color: red;
    color: white;
}
.view-image-btn {
  padding: 5px 20px;
  background-color: gray;
  color: white;
  border: none;
  border-radius: 20px;
  font-weight: bold;
  cursor: pointer;
  text-decoration: none; /* Add this line to remove underline */
}

.view-image-btn:active {
  background-color: #333;
}

.modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.6);
}

.modal-content {
  background-color: #f9f9f9;
  margin: 20% auto;
  padding: 20px;
  border-radius: 6px;
  width: 50%;
  max-width: 400px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  cursor:default;
}

.close {
  color: #aaa;
  float: right;
  font-size: 24px;
  font-weight: bold;
  cursor: pointer;
}

.close:hover {
  color: #555;
  transition: all 0.5s ease;
}

.okay-button {
  background-color: #29299B;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-top: 10px;
}

.okay-button:hover {
  background-color: #46469C;
  transition: all 0.3s ease;
}
.view-pdf-btn {
  display: inline-block;
  padding: 8px 16px;
  margin: 5px;
  background-color: #3498db;
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 14px;
  text-decoration: none;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.view-pdf-btn:hover {
  background-color: #2980b9;
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
  <span class="dashboard"><?php echo $row["firstName"]; ?>'s Profile</span>
  <a href="edit.php?id=<?php echo $_GET['id']; ?>" class="btn btn-edit">Edit</a>
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

    </nav>

    <div class="home-content">
    



    <section class="container"  id="home-content">
      
    <p class="status <?php echo strtolower($row["personStatus"]); ?>">
  Status: <?php echo $row["personStatus"]; ?>
  <?php if ($row["personStatus"] === "Deceased"): ?>
    <br>
    <a href="downloadpdf.php?file=<?php echo $row['deceasedCert']; ?>" class="view-pdf-btn">See PDF 1</a>
    <a href="downloadpdf.php?file=<?php echo $row['deceasedCert1']; ?>" class="view-pdf-btn">See PDF 2</a>
  <?php endif; ?>
</p>



      
    <header><?php echo $row["firstName"]; ?>'s Data Form</header>
      <br>
      <h1 style="background-color: lightblue; color: black">I. Identifying Information</h1>
      <form class="form" method="post">
      <div class="column">
      <div class="input-box" style="margin-top: 100px;">
          <b>RBI ID: <?php echo $row["RBIID"]; ?> </b>
          <br>
        </div>
        
        <div class="input-box" style="margin-top: 100px;">
          <b>RRN: <?php echo $row["referenceCode"]; ?></b>
          <br>
        </div>
        <div class="input-box" id="invitext">
        </div>

        <div class="userimage">
  <?php if ($row['imageup'] && $row['imageup'] !== 'imageuploaded/') : ?>
    <img src="<?php echo $row['imageup']; ?>" class="uploaded-image">
  <?php else: ?>
    <p class="no-image">No image</p>
  <?php endif; ?>
</div>


        </div>
        <br>

      <b>1. Name of Senior Citizen</b>
<div class="column">
  <div class="input-box">
    <b>Last Name:</b>
    <br>
    <?php echo $row["lastName"]; ?>
  </div>
  <hr>
  <div class="input-box">
    <b>First Name</b>
    <br>
    <?php echo $row["firstName"]; ?>
  </div>
  <hr>
  <div class="input-box">
    <b>Middle Name</b>
    <br>
    <?php echo $row["middleName"]; ?>
  </div>
  <hr>
  <div class="input-box">
          <b>Extension</b>
          <br>
    <?php echo $row["extensionName"]; ?>
        </div>
</div>
<hr>
        <br>
        
        <b>2. Address</b>
        <div class="column">
        <div class="input-box">
          <b>Region</b>
          <br>
    <?php echo $row["region"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>Province</b>
          <br>
    <?php echo $row["province"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>City / Municipality</b>
          <br>
    <?php echo $row["city"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>Barangay</b>
          <br>
    <?php echo $row["barangay"]; ?>
        </div>
        </div>
        <div class="column">
        <div class="input-box">
          <b>House No./Zone/Purok/Sitio</b>
          <br>
    <?php echo $row["houseno"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>Street</b>
          <br>
    <?php echo $row["street"]; ?>
        </div>
        </div>
        <hr>
        <div class="column">
        <div class="input-box">
            <b>3. Date of Birth | Age</b>
            <br>
 
<?php echo $row["birthDate"]; ?> <?php echo "| "?>
<?php echo $age; ?> Years Old
          </div>
          <hr>
        <div class="input-box">
          <b>4. Place of Birth</b>
          <br>
    <?php echo $row["birthPlace"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>5. Marital Status</b>
          <br>
          <?php echo $row["maritalStatus"]; ?>
        </div>
        </div>
<hr>
        <div class="column">
        <div class="input-box">
          <b>6. Gender</b>
          <br>
    <?php echo $row["gender"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>7. Contact Number</b>
          <br>
    <?php echo $row["contactNumber"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>8. Email Address</b>
          <br>
    <?php echo $row["email"]; ?>
        </div>
        </div>
<hr>
        <div class="column">
        <div class="input-box">
          <b>9. Religion</b>
          <br>
    <?php echo $row["religion"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>10. Ethnic Origin</b>
          <br>
    <?php echo $row["ethnic"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>11. Language Spoken / Written</b>
          <br>
    <?php echo $row["language"]; ?>
        </div>
        </div>
<hr>
        <div class="column">
        <div class="input-box">
          <b>12. OSCA ID</b>
          <br>
    <?php echo $row["oscaID"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>13. GSIS / SSS</b>
          <br>
    <?php echo $row["sss"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>14. TIN ID</b>
          <br>
    <?php echo $row["tin"]; ?>
        </div>
        </div>
<hr>
        <div class="column">
        <div class="input-box">
          <b>15. Philhealth</b>
          <br>
    <?php echo $row["philhealth"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>16. SC Association / Org ID No</b>
          <br>
    <?php echo $row["orgID"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>17. Other Gov't. ID</b>
          <br>
    <?php echo $row["govID"]; ?>
        </div>
        </div>

        <hr>
        <div class="column">
        <div class="gender-box">
          <b>18. Capability to Travel</b>
          <div class="gender-option">
    <?php echo $row["travel"]; ?>
          </div>
          <hr>
        <div class="input-box">
          <b>19. Service / Business / Employment / Specify</b>
          <br>
    <?php echo $row["serviceEmp"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>20. Current Pension / Specify</b>
          <br>
    <?php echo $row["pension"]; ?>
        </div>
        </div>
        </div>
       
        <br><br>
        <h1 style="background-color: lightblue; color: black">II. Family Composition</h1>
        <br>

        <b>21. Name of Spouse</b>
        <div class="column">
        <div class="input-box">
          <b>Last Name</b>
          <br>
    <?php echo $row["spouseLastName"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>First Name</b>
          <br>
    <?php echo $row["spouseFirstName"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>Middle Name</b>
          <br>
    <?php echo $row["spouseMiddleName"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>Extension (Jr, Sr)</b>
          <br>
    <?php echo $row["spouseExtensionName"]; ?>
        </div>
        </div>
        <hr>
        <br>
        
        <b>22. Father's Name</b>
        <div class="column">
        <div class="input-box">
          <b>Last Name</b>
          <br>
    <?php echo $row["fatherLastName"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>First Name</b>
          <br>
    <?php echo $row["fatherFirstName"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>Middle Name</b>
          <br>
    <?php echo $row["fatherMiddleName"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>Extension (Jr, Sr)</b>
          <br>
    <?php echo $row["fatherExtensionName"]; ?>
        </div>
        </div>
<hr>
        <br>
        
        <b>23. Mother's Maiden Name</b>
        <div class="column">
        <div class="input-box">
          <b>Last Name</b>
          <br>
    <?php echo $row["motherLastName"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>First Name</b>
          <br>
    <?php echo $row["motherFirstName"]; ?>
        </div>
        <hr>
        <div class="input-box">
          <b>Middle Name</b>
          <br>
    <?php echo $row["motherMiddleName"]; ?>
        </div>
        </div>
        <hr>
        <br>

        <b>24. Child(ren)</b>
        <div class="column">
        <div class="input-box">
          <b>Full Name</b>
          <br>
    <?php echo $row["child1FullName"]; ?>
        </div>
        <div class="input-box">
          <b>Occupation</b>
          <br>
    <?php echo $row["child1Occupation"]; ?>
        </div>
        <div class="input-box">
          <b>Income</b>
          <br>
    <?php echo $row["child1Income"]; ?>
        </div>
        <div class="input-box">
          <b>Age</b>
          <br>
    <?php echo $row["child1Age"]; ?>
        </div>
        <div class="input-box">
        <b style="font-size:15px;">Working</b>
          <br>
    <?php echo $row["child1Work"]; ?>
        </div>
        </div>
    

        <div class="column">
        <div class="input-boxq">
    <?php echo $row["child2FullName"]; ?>
        </div>
        <div class="input-boxq">
    <?php echo $row["child2Occupation"]; ?>
        </div>
        <div class="input-boxq">
    <?php echo $row["child2Income"]; ?>
        </div>
        <div class="input-boxq">   
    <?php echo $row["child2Age"]; ?>
        </div>
        <div class="input-boxq">
    <?php echo $row["child2Work"]; ?>
        </div>
        </div>

    
        <div class="column">
        <div class="input-boxq">
    <?php echo $row["child3FullName"]; ?>
        </div>
        <div class="input-boxq">
    <?php echo $row["child3Occupation"]; ?>
        </div>
        <div class="input-boxq">
    <?php echo $row["child3Income"]; ?>
        </div>
        <div class="input-boxq">
    <?php echo $row["child3Age"]; ?>
        </div>
        <div class="input-boxq">
    <?php echo $row["child3Work"]; ?>
        </div>
        </div>


        <div class="column">
        <div class="input-boxq">
    <?php echo $row["child4FullName"]; ?>
        </div>
        <div class="input-boxq">      
    <?php echo $row["child4Occupation"]; ?>
        </div>
        <div class="input-boxq">      
    <?php echo $row["child4Income"]; ?>
        </div>   
        <div class="input-boxq">     
    <?php echo $row["child4Age"]; ?>
        </div>
        <div class="input-boxq">
    <?php echo $row["child4Work"]; ?>
        </div>
        </div>
<hr>
        <br>

        <!-- DEPENDENTS!!!!!!! -->

<b>25. Other Dependent</b>
<div class="column">
        <div class="input-boxq">
        <b>Full Name</b>
          <br>
    <?php echo $row["dependentFullName"]; ?>
        </div>
      
        <div class="input-boxq">
          <b>Occupation</b>
          <br>
    <?php echo $row["dependentOccupation"]; ?>
        </div>
     
        <div class="input-boxq">
          <b>Income</b>
          <br>
    <?php echo $row["dependentIncome"]; ?>
        </div>

        <div class="input-boxq">
          <b>Age</b>
          <br>
    <?php echo $row["dependentAge"]; ?>
        </div>

        <div class="input-boxq">
        <b style="font-size:15px;">Working</b>
          <br>
    <?php echo $row["dependentWork"]; ?>
        </div>
        </div>

        <div class="column">
        <div class="input-boxq">
    <?php echo $row["dependent2FullName"]; ?>
        </div>
        <div class="input-boxq">      
    <?php echo $row["dependent2Occupation"]; ?>
        </div>
        <div class="input-boxq">      
    <?php echo $row["dependent2Income"]; ?>
        </div>   
        <div class="input-boxq">     
    <?php echo $row["dependent2Age"]; ?>
        </div>
        <div class="input-boxq">
    <?php echo $row["dependent2Work"]; ?>
        </div>
        </div>

        <div class="column">
        <div class="input-boxq">
    <?php echo $row["dependent3FullName"]; ?>
        </div>
        <div class="input-boxq">      
    <?php echo $row["dependent3Occupation"]; ?>
        </div>
        <div class="input-boxq">      
    <?php echo $row["dependent3Income"]; ?>
        </div>   
        <div class="input-boxq">     
    <?php echo $row["dependent3Age"]; ?>
        </div>
        <div class="input-boxq">
    <?php echo $row["dependent3Work"]; ?>
        </div>
        </div>

      <br><br>
        <h1 style="background-color: lightblue; color: black">III. Education / HR Profile</h1>

        
<br>
        <b>26. Educational Attainment</b>
       <br>
        <?php echo $row["educationalAttainment"]; ?>
      <hr>

          <br>
         
        <b>27. Areas of Specialization / Technical Skills</b>
      
<br>
        <?php echo $row["specialization"]; ?>
        <?php echo $row["specializationOthers"]; ?>
       
        <hr>
         <br>
        <b>28. Share Skill (Community Service)</b>
        <br>
        <label>1. </label>
        <?php echo $row["shareSkill"]; ?>
        <br>
        <label>2. </label>
        <?php echo $row["shareSkill1"]; ?>
        <br>
        <label>3. </label>
        <?php echo $row["shareSkill2"]; ?>
        <hr>
<br>
        <b>29. Community Service and Involvement</b>
        <br>
        <?php echo $row["communityService"]; ?>
        <?php echo $row["communityServiceOthers"]; ?>
          <br><br>
        <h1 style="background-color: lightblue; color: black">IV. Dependency Profile</h1>

      <br>
        <b>30. Living / Residing with</b>
        <br>
        <?php echo $row["residingwith"]; ?>
        <?php echo $row["residingWithOthers"]; ?>
<hr>
       <br>
        <b>31. Household Condition</b>
        <br>
        <?php echo $row["houseHold"]; ?>
        <?php echo $row["houseHoldOthers"]; ?>
<br><br>

          <h1 style="background-color: lightblue; color: black">V. Economic Profile</h1>

        <br>
        
          
        <b>32. Source of Income and Assistance</b>
        <br>
        <?php echo $row["sourceIncome"]; ?>
        <?php echo $row["sourceIncomeOthers"]; ?>
        <hr>
        <br>
        <b>33. Assets: Real and Immovable Properties</b>
        <br>
        <?php echo $row["assetsFirst"]; ?>
        <?php echo $row["assetsFirstOthers"]; ?>
          <hr>
          <br>
        <b>34. Assets: Personal and Movable Properties</b>
        <br>
        <?php echo $row["assetsSecond"]; ?>
        <?php echo $row["assetsSecondOthers"]; ?>
          <hr>
          <br>
     
        <b>35. Monthly Income (in Philippine Peso)</b>
        <br>
        <?php echo $row["monthlyIncome"];?>
       
          <hr>
          <br>
          
        <b>36. Problems / Needs Commonly Encountered</b>
        <br>
        <?php echo $row["problems"]; ?>
        <?php echo $row["problemsOthers"]; ?>

          <br><br>
          <h1 style="background-color: lightblue; color: black">VI. Health Profile</h1>
        <br>

        <b>37. Medical Concern</b>
        <br>
        <div class="column">
        <div class="input-box">
        <b>Blood Type</b>
        <br>
        <?php echo $row["bloodType"]; ?>
  </div>
  
        <hr>
          <br>
          <div class="input-box">
          <b>Other Physical Disability</b>  
          <br>
        <?php echo $row["physicalDisability"]; ?>
        <?php echo $row["medicalConcern"]; ?>
  </div>
  </div>
        <hr>

        <div class="column">
        <div class="input-box">
        <b>38. Dental Concern</b>
        <br>
        <?php echo $row["dentalConcern"]; ?>
        </div>
        <hr>
          <div class="input-box">
        <b>39. Optical</b>
        <br>
        <?php echo $row["optical"]; ?>
        <?php echo $row["opticalOthers"]; ?>
  </div><br>
        <hr>
          <br>
          <div class="input-box">
        <b>40. Hearing</b>
        <br>
        <?php echo $row["hearing"]; ?>
  </div>
        <hr>
          <br>
          <div class="input-box">
        <b>41. Social / Emotional</b>
   
        <br>
        <?php echo $row["socialEmotional"]; ?>
        <?php echo $row["socialEmotionalOthers"]; ?>
  </div>
  </div>
        <hr>
          <div class="column">
          <div class="input-box">
        <b>42. Area / Difficulty</b>
        <br>
        <?php echo $row["areaDifficulty"]; ?>
        <?php echo $row["areaDifficultyOthers"]; ?>
  </div>
        <hr>
    
          <div class="input-box">
        <b>43. List of Medicines for Maintenance</b>
        <br>
        <?php echo $row["medicines"]; ?>
  </div><br>
        <hr>
        <br>
        <div class="input-box">
        <b>44. Have a scheduled medical / physical check-up?</b>
        <br>
        <?php echo $row["scheduledMedical"]; ?>
  </div>
        <hr>
          <br>
          <div class="input-box">
        <b>45. If Yes, when is it done?</b>
        <br>
        <?php echo $row["scheduledMedical1"]; ?>
  </div>
</div>   
      </form>
    
      
      <div class="insertlog" id="insertlog">
  <input type="hidden" name="user_name" value="<?php echo $_SESSION['user_name']; ?>">
  <button class="printbutton" name="printlog" onclick="showModal(<?php echo $row['id']; ?>);">
    <img src="images/printicon.png" class="printicon">
    Print this page
  </button>
</div>

<!-- Modal -->
<div class="modal" id="myModal">
  <div class="modal-content">
    <span class="close" onclick="hideModal()">&times;</span>
    <h2>Important Note:</h2>
    <p>Set the settings into the following:</p>
    <br>
    <p>Letter Size: Legal 8.5in x 13in</p>
    <p>Margins: none</p>
    <p>Scale: Default</p>
    <button class="okay-button" onclick="proceedPrinting(<?php echo $row['id']; ?>)">Okay</button>
  </div>
</div>

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

function showModal(userId) {
    const modal = document.getElementById("myModal");
    modal.style.display = "block";
  }

  function hideModal() {
    const modal = document.getElementById("myModal");
    modal.style.display = "none";
  }

  function proceedPrinting(userId) {
    const modal = document.getElementById("myModal");
    modal.style.display = "none";

    printPage(userId);
  }

  function printPage(userId) {
    var iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    document.body.appendChild(iframe);

    iframe.src = 'print.php?id=' + userId;

    iframe.onload = function() {
      iframe.contentWindow.print();
      setTimeout(function() {
        document.body.removeChild(iframe);
      }, 1000);
    };
  }

  function insertIntoLog() {
    const userName = document.querySelector('input[name="user_name"]').value;
    const lastName = "<?php echo $row['lastName']; ?>";
    const firstName = "<?php echo $row['firstName']; ?>";
    const actionText = `printed the form for ${lastName}, ${firstName}`;
    const data = {
      user_name: userName, 
      action: actionText
    };
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "printlog.php", true);
    xhr.setRequestHeader("Content-type", "application/json");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          showModal(<?php echo $row['id']; ?>); // Show the modal after successful insertion
        } else {
          showModal(<?php echo $row['id']; ?>); // Show the modal even if the insertion fails
          alert("Failed to insert data into the log table.");
        }
      }
    };
    xhr.send(JSON.stringify(data));
  }

  // Adding the onClick event listener to the 'printbutton' button
  const printButton = document.querySelector('.printbutton');
  printButton.addEventListener("click", insertIntoLog);

  </script>

<?php endif; 
}
}
else{
    echo "<h3>No such person found</h3>";
}?>
</body>





</html>

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
  $sql = "SELECT * FROM register";
  $result = $conx->query($sql);
}

$id = $_GET['id'];
if ($id) {
  $sql = "SELECT * FROM people WHERE id = $id";
  $result = mysqli_query($conx, $sql);
  while ($row = mysqli_fetch_array($result)) {
    $birthDate = $row["birthDate"];
    $formattedBirthDate = null;

    // Check for valid date formats and convert to desired format
    if (preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $birthDate)) {
      $dateParts = explode('/', $birthDate);
      $formattedBirthDate = $dateParts[0] . '/' . $dateParts[1] . '/' . $dateParts[2];
    } elseif (preg_match("/^\d{4}-\d{2}-\d{2}$/", $birthDate)) {
      $dateParts = explode('-', $birthDate);
      $formattedBirthDate = $dateParts[1] . '/' . $dateParts[2] . '/' . $dateParts[0];
    }

    $age = null;
    if ($formattedBirthDate) {
      $birthDateObj = new DateTime($birthDate);
      $currentDate = new DateTime();
      $age = $currentDate->diff($birthDateObj)->y;
    }

    $selectedSpecializations = explode(",", $row['specialization']);
    $selectedComService = explode(",", $row['communityService']);
    $selectedResidingWith = explode(",", $row['residingwith']);
    $selectedHouseHold = explode(",", $row['houseHold']);
    $selectedSourceIncome = explode(",", $row['sourceIncome']);
    $selectedAssetsFirst = explode(",", $row['assetsFirst']);
    $selectedAssetsSecond = explode(",", $row['assetsSecond']);
    $selectedProblems = explode(",", $row['problems']);
    $selectedMedicalConcerns = explode(",", $row['medicalConcern']);
    $selectedOptical = explode(",", $row['optical']);
    $selectedSocialEmotional = explode(",", $row['socialEmotional']);
    $selectedAreaDifficulty = explode(",", $row['areaDifficulty']);

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

    .home-section {
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
    .nextbutton6 {
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
    .previousbutton6 {
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
    #dependent5Button {
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

    .submitbutton:hover {
        background: #1CDB42;
    }

    .form #deceasedbutton {
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

    .invisiblebutton {
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
        grid-template-columns: repeat(2, 1fr);
        /* Adjust the number of columns as needed */

    }
    </style>
</head>

<body>

    <?php if (isset($error_msg)) : ?>
    <div class="error-container">
        <div class="error-message"><?php echo $error_msg; ?></div>
        <button class="go-back-button" onclick="goBack()">Go back</button>
    </div>

    <script>
    function goBack() {
        window.history.back();
    }
    </script>
    <?php else : ?>
    <div class="sidebar">
        <div class="logo-details">
            <a href="homelog.php">
                <img src="../img/sslogo.png" alt="" class="logo-details">
            </a>
            <a href="homelog.php">
                <span class="logo_name" style="cursor: pointer;">Senior Solutions</span>
            </a>
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
                if (isset($_SESSION['user_name'])) {
                  echo $_SESSION['user_name'];
                }
                ?>
                </span>
            </div>

            <?php
            if (isset($_GET['id'])) {
              $id = $_GET['id'];
              $sql = "SELECT * FROM people WHERE id=$id";
              $result = mysqli_query($conx, $sql);
              $row = mysqli_fetch_array($result);
            ?>

        </nav>
        <div class="home-content">


            <section class="container">


                <header> <br>
                    <?php echo $row["firstName"]; ?>'s Data Form</header>
                <?php
            } else {
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
                        <h1 style="background-color: lightblue; color: black; font-size: 25px">I. Identifying
                            Information</h1>
                        <br>



                        <div class="column">
                            <div class="input-box" style="margin-top: 100px;">
                                <b>RBI ID</b>
                                <input type="text" class="gray-input" placeholder="Enter RBI ID" name="rbiid"
                                    value="<?php echo $row["RBIID"]; ?>" />
                            </div>
                            <div class="input-box" style="margin-top: 100px;">
                                <b>Reference Code</b>
                                <input type="number" class="gray-input" placeholder="Reference Code"
                                    name="referenceCode" value="<?php echo $row["referenceCode"]; ?>" />
                            </div>
                            <div class="input-box" id="invitext">
                            </div>

                            <div class="uploadimage">
                                <input type="file" name="imageup" accept="image/*" id="imageInput" />
                                <label for="imageInput">Upload Image Here</label>
                            </div>

                        </div>


                        <b>1. Name of Senior Citizen</b>
                        <div class="column">
                            <div class="input-box">
                                <label><span class="red-asterisk">*</span> Last Name</label>
                                <input type="text" class="gray-input" placeholder="Enter last name" name="lastName"
                                    maxlength="20" value="<?php echo $row["lastName"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label><span class="red-asterisk">*</span> First Name</label>
                                <input type="text" class="gray-input" placeholder="Enter first name" maxlength="20"
                                    name="firstName" value="<?php echo $row["firstName"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label>Middle Name</label>
                                <input type="text" class="gray-input" placeholder="Enter middle name" maxlength="20"
                                    name="middleName" value="<?php echo $row["middleName"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label>Extension (JR,SR)</label>
                                <div class="select-box">
                                    <select name="extensionName" id="jrsr">
                                        <option hidden>Enter JR, SR</option>
                                        <option value="JR." <?php if ($row["extensionName"] == "JR.") {
                                              echo "selected";
                                            } ?>>JR.</option>
                                        <option value="SR." <?php if ($row["extensionName"] == "SR.") {
                                              echo "selected";
                                            } ?>>SR.</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <b>2. Address</b>
                        <div class="column">
                            <div class="input-box">
                                <label><span class="red-asterisk">*</span> Region</label>
                                <input type="text" class="gray-input" placeholder="Enter region" name="region"
                                    id="regionSelect" value="<?php echo $row["region"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label><span class="red-asterisk">*</span> Province</label>
                                <input type="text" class="gray-input" placeholder="Enter province" name="province"
                                    value="<?php echo $row["province"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label><span class="red-asterisk">*</span> City / Municipality</label>
                                <input type="text" class="gray-input" placeholder="Enter city/municipality" name="city"
                                    value="<?php echo $row["city"]; ?>" />
                            </div>

                            <div class="input-box">
                                <label><span class="red-asterisk">*</span> Barangay</label>
                                <div class="select-box">
                                    <select name="barangay" id="barangaySelect">
                                        <option value="Aldiano Olaes" <?php if ($row["barangay"] == "Aldiano Olaes") {
                                                                  echo "selected";
                                                                } ?>>Aldiano Olaes</option>
                                        <option value="Poblacion 1" <?php if ($row["barangay"] == "Poblacion 1") {
                                                                echo "selected";
                                                              } ?>>Poblacion 1</option>
                                        <option value="Poblacion 2" <?php if ($row["barangay"] == "Poblacion 2") {
                                                                echo "selected";
                                                              } ?>>Poblacion 2</option>
                                        <option value="Poblacion 3" <?php if ($row["barangay"] == "Poblacion 3") {
                                                                echo "selected";
                                                              } ?>>Poblacion 3</option>
                                        <option value="Poblacion 4" <?php if ($row["barangay"] == "Poblacion 4") {
                                                                echo "selected";
                                                              } ?>>Poblacion 4</option>
                                        <option value="Poblacion 5 - FVR" <?php if ($row["barangay"] == "Poblacion 5 - FVR") {
                                                                echo "selected";
                                                              } ?>>Poblacion 5 - FVR</option>
                                        <option value="Poblacion 5 - Proper" <?php if ($row["barangay"] == "Poblacion 5 - Proper") {
                                                                echo "selected";
                                                              } ?>>Poblacion 5 - Proper</option>
                                        <option value="Benjamin Tirona" <?php if ($row["barangay"] == "Benjamin Tirona") {
                                                                echo "selected";
                                                              } ?>>Benjamin Tirona</option>
                                        <option value="Bernardo Pulido" <?php if ($row["barangay"] == "Bernardo Pulido") {
                                                                    echo "selected";
                                                                  } ?>>Bernardo Pulido</option>
                                        <option value="Epifanio Malia" <?php if ($row["barangay"] == "Epifanio Malia") {
                                                                  echo "selected";
                                                                } ?>>Epifanio Malia</option>
                                        <option value="Francisco De Castro" <?php if ($row["barangay"] == "Francisco De Castro") {
                                                              echo "selected";
                                                            } ?>>Francisco De Castro</option>
                                        <option value="Francisco De Castro - Sunshine" <?php if ($row["barangay"] == "Francisco De Castro - Sunshine") {
                                                              echo "selected";
                                                            } ?>>Francisco De Castro - Sunshine</option>
                                        <option value="Francisco De Castro - Mandarin" <?php if ($row["barangay"] == "Francisco De Castro - Mandarin") {
                                                              echo "selected";
                                                            } ?>>Francisco De Castro - Mandarin</option>
                                        <option value="Francisco De Castro - Kanebo" <?php if ($row["barangay"] == "Francisco De Castro - Kanebo") {
                                                              echo "selected";
                                                            } ?>>Francisco De Castro - Kanebo</option>
                                        <option value="Francisco De Castro - Monteverde" <?php if ($row["barangay"] == "Francisco De Castro - Monteverde") {
                                                              echo "selected";
                                                            } ?>>Francisco De Castro - Monteverde</option>
                                        <option value="Francisco De Castro - Rolling Hills" <?php if ($row["barangay"] == "Francisco De Castro - Rolling Hills") {
                                                              echo "selected";
                                                            } ?>>Francisco De Castro - Rolling Hills</option>
                                        <option value="Francisco Reyes" <?php if ($row["barangay"] == "Francisco Reyes") {
                                                                            echo "selected";
                                                                          } ?>>Francisco Reyes</option>
                                        <option value="Fiorello Calimag" <?php if ($row["barangay"] == "Fiorello Calimag") {
                                                                    echo "selected";
                                                                  } ?>>Fiorello Calimag</option>
                                        <option value="Gavino Maderan" <?php if ($row["barangay"] == "Gavino Maderan") {
                                                                  echo "selected";
                                                                } ?>>Gavino Maderan</option>
                                        <option value="Gregoria De Jesus" <?php if ($row["barangay"] == "Gregoria De Jesus") {
                                                                              echo "selected";
                                                                            } ?>>Gregoria De Jesus</option>
                                        <option value="Inocencio Salud" <?php if ($row["barangay"] == "Inocencio Salud") {
                                                                    echo "selected";
                                                                  } ?>>Inocencio Salud</option>
                                        <option value="Jacinto Lumbreras" <?php if ($row["barangay"] == "Jacinto Lumbreras") {
                                                                      echo "selected";
                                                                    } ?>>Jacinto Lumbreras</option>
                                        <option value="Kapitan Kua" <?php if ($row["barangay"] == "Kapitan Kua") {
                                                                echo "selected";
                                                              } ?>>Kapitan Kua</option>
                                        <option value="Koronel Jose P. Elises" <?php if ($row["barangay"] == "Koronel Jose P. Elises") {
                                                                          echo "selected";
                                                                        } ?>>Koronel Jose P. Elises</option>
                                        <option value="Macario Dacon" <?php if ($row["barangay"] == "Macario Dacon") {
                                                                  echo "selected";
                                                                } ?>>Macario Dacon</option>
                                        <option value="Marcelino Memije" <?php if ($row["barangay"] == "Marcelino Memije") {
                                                                    echo "selected";
                                                                  } ?>>Marcelino Memije</option>
                                        <option value="Nicolasa Virata" <?php if ($row["barangay"] == "Nicolasa Virata") {
                                                                            echo "selected";
                                                                          } ?>>Nicolasa Virata</option>
                                        <option value="Pantaleon Granados" <?php if ($row["barangay"] == "Pantaleon Granados") {
                                                                      echo "selected";
                                                                    } ?>>Pantaleon Granados</option>
                                        <option value="Ramon Cruz Sr." <?php if ($row["barangay"] == "Ramon Cruz Sr.") {
                                                                  echo "selected";
                                                                } ?>>Ramon Cruz Sr. (Area J)</option>
                                        <option value="San Gabriel" <?php if ($row["barangay"] == "San Gabriel") {
                                                                echo "selected";
                                                              } ?>>San Gabriel</option>
                                        <option value="San Jose" <?php if ($row["barangay"] == "San Jose") {
                                                                    echo "selected";
                                                                  } ?>>San Jose</option>
                                        <option value="Severino De Las Alas" <?php if ($row["barangay"] == "Severino De Las Alas") {
                                                                        echo "selected";
                                                                      } ?>>Severino De Las Alas</option>
                                        <option value="Tiniente Tiago" <?php if ($row["barangay"] == "Tiniente Tiago") {
                                                                          echo "selected";
                                                                        } ?>>Tiniente Tiago</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="column">
                            <div class="input-box">
                                <label>House No./Zone/Purok/Sitio</label>
                                <input type="text" class="gray-input" placeholder="Enter house no." name="houseno"
                                    value="<?php echo $row["houseno"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label>Street</label>
                                <input type="text" class="gray-input" placeholder="Enter Street" name="street"
                                    value="<?php echo $row["street"]; ?>" />
                            </div>
                        </div>

                        <div class="column">
                            <div class="input-box">
                                <b><span class="red-asterisk">*</span> 3. Date of Birth</b>
                                <input type="date" class="gray-input" placeholder="Enter birth date" name="birthDate"
                                    value="<?php echo $row["birthDate"]; ?>" id="birthDateInput" />
                            </div>
                            <div class="input-box">
                                <b>4. Place of Birth</b>
                                <input type="text" class="gray-input" placeholder="Enter place of birth"
                                    name="birthPlace" maxlength="20" value="<?php echo $row["birthPlace"]; ?>" />
                            </div>
                            <div class="input-box">
                                <b>5. Marital Status</b>
                                <div class="select-box">
                                    <select name="maritalStatus">
                                        <option hidden>Enter Marital Status</option>
                                        <option value="Married" <?php if ($row["maritalStatus"] == "Married") {
                                                  echo "selected";
                                                } ?>>Married</option>
                                        <option value="Divorced" <?php if ($row["maritalStatus"] == "Divorced") {
                                                    echo "selected";
                                                  } ?>>Divorced</option>
                                        <option value="Seperated" <?php if ($row["maritalStatus"] == "Seperated") {
                                                    echo "selected";
                                                  } ?>>Seperated</option>
                                        <option value="Widowed" <?php if ($row["maritalStatus"] == "Widowed") {
                                                  echo "selected";
                                                } ?>>Widowed</option>
                                        <option value="Never Married" <?php if ($row["maritalStatus"] == "Never Married") {
                                                        echo "selected";
                                                      } ?>>Never Married</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="column">
                            <div class="input-box">
                                <b><span class="red-asterisk">*</span> 6. Gender</b>
                                <div class="select-box">
                                    <select name="gender" id="genderSelect">
                                        <option hidden>Enter Gender</option>
                                        <option value="Male" <?php if ($row["gender"] == "Male") {
                                                echo "selected";
                                              } ?>>Male</option>
                                        <option value="Female" <?php if ($row["gender"] == "Female") {
                                                  echo "selected";
                                                } ?>>Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="input-box">
                                <b>7. Contact Number</b>
                                <input type="number" class="gray-input" placeholder="+63" name="contactNumber"
                                    maxlength="10" id="contactNumberInput"
                                    value="<?php echo $row["contactNumber"]; ?>" />
                            </div>
                            <div class="input-box">
                                <b>8. Email Address</b>
                                <input type="email" class="gray-input" placeholder="example@gmail.com" name="email"
                                    id="email" value="<?php echo $row["email"]; ?>" />
                            </div>
                        </div>

                        <div class="column">
                            <div class="input-box">
                                <b>9. Religion</b>
                                <input type="text" class="gray-input" placeholder="Enter religion" name="religion"
                                    value="<?php echo $row["religion"]; ?>" />
                            </div>
                            <div class="input-box">
                                <b>10. Ethnic Origin</b>
                                <input type="text" class="gray-input" placeholder="Enter ethnic origin" name="ethnic"
                                    value="<?php echo $row["ethnic"]; ?>" />
                            </div>
                            <div class="input-box">
                                <b>11. Language Spoken / Written</b>
                                <input type="text" class="gray-input" placeholder="Enter language spoken"
                                    name="language" value="<?php echo $row["language"]; ?>" />
                            </div>
                        </div>

                        <div class="column">

                            <div class="input-box">
                                <b>12. OSCA ID</b>
                                <input type="text" class="gray-input" placeholder="Enter Osca ID" name="oscaID"
                                    oninput="restrictToNumbers(this)" value="<?php echo $row["oscaID"]; ?>" />
                            </div>
                            <div class="input-box">
                                <b>13. GSIS / SSS</b>
                                <input type="text" class="gray-input" placeholder="0000000000" maxlength="10" name="sss"
                                    oninput="restrictToNumbers(this)" value="<?php echo $row["sss"]; ?>" />
                            </div>
                            <div class="input-box">
                                <b>14. TIN ID</b>
                                <div class="tin-input">
                                    <input type="text" class="gray-input" placeholder="000-000-000-000" name="tin"
                                        oninput="maskTIN(this)" value="<?php echo $row["tin"]; ?>" />
                                </div>

                            </div>
                        </div>

                        <div class="column">
                            <div class="input-box">
                                <b>15. Philhealth</b>
                                <input type="text" class="gray-input" placeholder="00-000000000-0" name="philhealth"
                                    oninput="restrictToNumbersWithHyphen(this)"
                                    value="<?php echo $row["philhealth"]; ?>" />
                            </div>

                            <div class="input-box">
                                <b>16. SC Association / Org ID No</b>
                                <input type="text" class="gray-input" placeholder="Enter Org ID" name="orgID"
                                    value="<?php echo $row["orgID"]; ?>" />
                            </div>
                            <div class="input-box">
                                <b>17. Other Gov't. ID</b>
                                <input type="text" class="gray-input" placeholder="Other Gov't ID" name="govID"
                                    value="<?php echo $row["govID"]; ?>" />
                            </div>
                        </div>


                        <div class="gender-box">
                            <b>18. Capability to Travel</b>
                            <div class="gender-option">
                                <div class="gender">
                                    <input type="radio" id="check-male" name="travel" value="Yes" <?php if ($row["travel"] == "Yes") {
                                                                                      echo "checked";
                                                                                    } ?> />
                                    <label for="check-male">Yes</label>
                                </div>
                                <div class="gender">
                                    <input type="radio" id="check-female" name="travel" value="No" <?php if ($row["travel"] == "No") {
                                                                                        echo "checked";
                                                                                      } ?> />
                                    <label for="check-female">No</label>
                                </div>
                            </div>
                            <div class="column">
                                <div class="input-box">
                                    <b>19. Service / Business / Employment / Specify</b>
                                    <input type="text" class="gray-input" placeholder="Enter Employment"
                                        name="serviceEmp" maxlength="50" value="<?php echo $row["serviceEmp"]; ?>" />
                                </div>
                                <div class="input-box">
                                    <b>20. Current Pension / Specify</b>
                                    <input type="text" class="gray-input" placeholder="Enter current pension"
                                        name="pension" value="<?php echo $row["pension"]; ?>" />
                                </div>
                            </div>
                        </div>

                        <button class="nextbutton" id="nextbutton" type="button">Next</button>

                    </div>
                    <!-- END OF PAGE 1 -->



                    <!-- PAGE 2 -->



                    <div class="page2">


                        <div class="progress-bar">
                            <span class="active"></span>
                            <span class="active"></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>

                        <h1 style="background-color: lightblue; color: black; font-size: 25px">II. Family Composition
                        </h1>
                        <br>
                        <b>21. Name of Spouse</b>
                        <div class="column">
                            <div class="input-box">
                                <label>Last Name</label>

                                <input type="text" class="gray-input" placeholder="Enter last name"
                                    name="spouseLastName" maxlength="20"
                                    value="<?php echo $row["spouseLastName"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label>First Name</label>
                                <input type="text" class="gray-input" placeholder="Enter first name"
                                    name="spouseFirstName" maxlength="20"
                                    value="<?php echo $row["spouseFirstName"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label>Middle Name</label>
                                <input type="text" class="gray-input" placeholder="Enter middle name"
                                    name="spouseMiddleName" maxlength="20"
                                    value="<?php echo $row["spouseMiddleName"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label>Extension (Jr, Sr)</label>
                                <div class="select-box">
                                    <select name="spouseExtensionName">
                                        <option hidden>Enter Jr, Sr</option>
                                        <option value="Jr." <?php if ($row["spouseExtensionName"] == "Jr.") {
                                              echo "selected";
                                            } ?>>Jr.</option>
                                        <option value="Sr." <?php if ($row["spouseExtensionName"] == "Sr.") {
                                              echo "selected";
                                            } ?>>Sr.</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <br>
                        <b>22. Father's Name</b>
                        <div class="column">
                            <div class="input-box">
                                <label>Last Name</label>
                                <input type="text" class="gray-input" placeholder="Enter last name"
                                    name="fatherLastName" maxlength="20"
                                    value="<?php echo $row["fatherLastName"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label>First Name</label>
                                <input type="text" class="gray-input" placeholder="Enter first name"
                                    name="fatherFirstName" maxlength="20"
                                    value="<?php echo $row["fatherFirstName"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label>Middle Name</label>
                                <input type="text" class="gray-input" placeholder="Enter middle name"
                                    name="fatherMiddleName" maxlength="20"
                                    value="<?php echo $row["fatherMiddleName"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label>Extension (Jr, Sr)</label>
                                <div class="select-box">
                                    <select name="fatherExtensionName">
                                        <option hidden>Enter Jr, Sr</option>
                                        <option value="Jr." <?php if ($row["fatherExtensionName"] == "Jr.") {
                                              echo "selected";
                                            } ?>>Jr.</option>
                                        <option value="Sr." <?php if ($row["fatherExtensionName"] == "Sr.") {
                                              echo "selected";
                                            } ?>>Sr.</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <br>
                        <b>23. Mother's Maiden Name</b>
                        <div class="column">
                            <div class="input-box">
                                <label>Last Name</label>
                                <input type="text" class="gray-input" placeholder="Enter last name"
                                    name="motherLastName" maxlength="20"
                                    value="<?php echo $row["motherLastName"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label>First Name</label>
                                <input type="text" class="gray-input" placeholder="Enter first name"
                                    name="motherFirstName" maxlength="20"
                                    value="<?php echo $row["motherFirstName"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label>Middle Name</label>
                                <input type="text" class="gray-input" placeholder="Enter middle name"
                                    name="motherMiddleName" maxlength="20"
                                    value="<?php echo $row["motherMiddleName"]; ?>" />
                            </div>
                        </div>
                        <br>

                        <b>24. Child(ren)</b>
                        <p style="font-size: 14px">(leave blank if none)</p>
                        <div class="column">
                            <div class="input-box">
                                <label><b>1. </b>Full Name</label>
                                <input type="text" class="gray-input" placeholder="Enter last name"
                                    name="child1FullName" maxlength="20"
                                    value="<?php echo $row["child1FullName"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label>Occupation</label>
                                <input type="text" class="gray-input" placeholder="Enter occupation"
                                    name="child1Occupation" maxlength="20"
                                    value="<?php echo $row["child1Occupation"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label>Income</label>
                                <input type="number" class="gray-input" placeholder="Enter income" name="child1Income"
                                    maxlength="20" value="<?php echo $row["child1Income"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label>Age</label>
                                <input type="number" class="gray-input" placeholder="Enter age" name="child1Age"
                                    value="<?php echo $row["child1Age"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label>Working</label>
                                <div class="select-box">
                                    <select name="child1Work">
                                        <option hidden>Working / Not Working</option>
                                        <option value="Working" <?php if ($row["child1Work"] == "Working") {
                                                  echo "selected";
                                                } ?>>Working</option>
                                        <option value="Not Working" <?php if ($row["child1Work"] == "Not Working") {
                                                      echo "selected";
                                                    } ?>>Not Working</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button class="addChild2Button" id="addChild2Button">Add Child</button>
                        <div class="hidden">
                            <div class="column">
                                <div class="input-box">
                                    <label><b>2. </b>Full Name</label>
                                    <input type="text" class="gray-input" placeholder="Enter last name"
                                        name="child2FullName" maxlength="20"
                                        value="<?php echo $row["child2FullName"]; ?>" />
                                </div>
                                <div class="input-box">
                                    <label>Occupation</label>
                                    <input type="text" class="gray-input" placeholder="Enter occupation"
                                        name="child2Occupation" maxlength="20"
                                        value="<?php echo $row["child2Occupation"]; ?>" />
                                </div>
                                <div class="input-box">
                                    <label>Income</label>
                                    <input type="number" class="gray-input" placeholder="Enter income"
                                        name="child2Income" value="<?php echo $row["child2Income"]; ?>" />
                                </div>
                                <div class="input-box">
                                    <label>Age</label>
                                    <input type="number" class="gray-input" placeholder="Enter age" name="child2Age"
                                        maxlength="3" value="<?php echo $row["child2Age"]; ?>" />
                                </div>
                                <div class="input-box">
                                    <label>Working</label>
                                    <div class="select-box">
                                        <select name="child2Work">
                                            <option hidden>Working / Not Working</option>
                                            <option value="Working" <?php if ($row["child2Work"] == "Working") {
                                                echo "selected";
                                              } ?>>Working</option>
                                            <option value="Not Working" <?php if ($row["child2Work"] == "Not Working") {
                                                echo "selected";
                                              } ?>>Not Working</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="hidden" id="addChild3Button">Add Child</button>

                        <div class="hidden3">
                            <div class="column">
                                <div class="input-box">
                                    <label><b>3. </b>Full Name</label>
                                    <input type="text" class="gray-input" placeholder="Enter last name"
                                        name="child3FullName" maxlength="20"
                                        value="<?php echo $row["child3FullName"]; ?>" />
                                </div>
                                <div class="input-box">
                                    <label>Occupation</label>
                                    <input type="text" class="gray-input" placeholder="Enter occupation"
                                        name="child3Occupation" maxlength="20"
                                        value="<?php echo $row["child3Occupation"]; ?>" />
                                </div>
                                <div class="input-box">
                                    <label>Income</label>
                                    <input type="number" class="gray-input" placeholder="Enter income"
                                        name="child3Income" value="<?php echo $row["child3Income"]; ?>" />
                                </div>
                                <div class="input-box">
                                    <label>Age</label>
                                    <input type="number" class="gray-input" placeholder="Enter age" name="child3Age"
                                        maxlength="3" value="<?php echo $row["child3Age"]; ?>" />
                                </div>
                                <div class="input-box">
                                    <label>Working</label>
                                    <div class="select-box">
                                        <select name="child3Work">
                                            <option hidden>Working / Not Working</option>
                                            <option value="Working" <?php if ($row["child3Work"] == "Working") {
                                                echo "selected";
                                              } ?>>Working</option>
                                            <option value="Not Working" <?php if ($row["child3Work"] == "Not Working") {
                                                echo "selected";
                                              } ?>>Not Working</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="hidden" id="addChild4Button">Add Child</button>

                        <div class="hidden4">
                            <div class="column">
                                <div class="input-box">
                                    <label><b>4. </b>Full Name</label>
                                    <input type="text" class="gray-input" placeholder="Enter last name"
                                        name="child4FullName" maxlength="20"
                                        value="<?php echo $row["child4FullName"]; ?>" />
                                </div>
                                <div class="input-box">
                                    <label>Occupation</label>
                                    <input type="text" class="gray-input" placeholder="Enter occupation"
                                        name="child4Occupation" maxlength="20"
                                        value="<?php echo $row["child4Occupation"]; ?>" />
                                </div>
                                <div class="input-box">
                                    <label>Income</label>
                                    <input type="number" class="gray-input" placeholder="Enter income"
                                        name="child4Income" value="<?php echo $row["child4Income"]; ?>" />
                                </div>
                                <div class="input-box">
                                    <label>Age</label>
                                    <input type="number" class="gray-input" placeholder="Enter age" name="child4Age"
                                        maxlength="3" value="<?php echo $row["child4Age"]; ?>" />
                                </div>
                                <div class="input-box">
                                    <label>Working</label>
                                    <div class="select-box">
                                        <select name="child4Work">
                                            <option hidden>Working / Not Working</option>
                                            <option value="Working" <?php if ($row["child4Work"] == "Working") {
                                                echo "selected";
                                              } ?>>Working</option>
                                            <option value="Not Working" <?php if ($row["child4Work"] == "Not Working") {
                                                echo "selected";
                                              } ?>>Not Working</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="hidden" id="addChild5Button" style="display:none;">Add Child</button>

                        <div class="hidden5">
                            <div class="column">
                                <div class="input-box">
                                    <label><b>5. </b>Full Name</label>
                                    <input type="text" class="gray-input" placeholder="Enter last name"
                                        name="child5FullName" maxlength="20" />
                                </div>
                                <div class="input-box">
                                    <label>Occupation</label>
                                    <input type="text" class="gray-input" placeholder="Enter occupation"
                                        name="child5Occupation" maxlength="20" />
                                </div>
                                <div class="input-box">
                                    <label>Income</label>
                                    <input type="number" class="gray-input" placeholder="Enter income"
                                        name="child5Income" />
                                </div>
                                <div class="input-box">
                                    <label>Age</label>
                                    <input type="number" class="gray-input" placeholder="Enter age" name="child5Age"
                                        maxlength="3" />
                                </div>
                                <div class="input-box">
                                    <label>Working</label>
                                    <div class="select-box">
                                        <select name="child5Work">
                                            <option hidden>Yes / No</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="hidden" id="addChild6Button">Add Child</button>

                        <div class="hidden6">
                            <div class="column">
                                <div class="input-box">
                                    <label><b>6. </b>Full Name</label>
                                    <input type="text" class="gray-input" placeholder="Enter last name"
                                        name="child6FullName" maxlength="20" />
                                </div>
                                <div class="input-box">
                                    <label>Occupation</label>
                                    <input type="text" class="gray-input" placeholder="Enter occupation"
                                        name="child6Occupation" maxlength="20" />
                                </div>
                                <div class="input-box">
                                    <label>Income</label>
                                    <input type="number" class="gray-input" placeholder="Enter income"
                                        name="child6Income" />
                                </div>
                                <div class="input-box">
                                    <label>Age</label>
                                    <input type="number" class="gray-input" placeholder="Enter age" name="child6Age"
                                        maxlength="3" />
                                </div>
                                <div class="input-box">
                                    <label>Working</label>
                                    <div class="select-box">
                                        <select name="child6Work">
                                            <option hidden>Yes / No</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="hidden" id="addChild7Button">Add Child</button>

                        <div class="hidden7">
                            <div class="column">
                                <div class="input-box">
                                    <label><b>7. </b>Full Name</label>
                                    <input type="text" class="gray-input" placeholder="Enter last name"
                                        name="child7FullName" maxlength="20" />
                                </div>
                                <div class="input-box">
                                    <label>Occupation</label>
                                    <input type="text" class="gray-input" placeholder="Enter occupation"
                                        name="child7Occupation" maxlength="20" />
                                </div>
                                <div class="input-box">
                                    <label>Income</label>
                                    <input type="number" class="gray-input" placeholder="Enter income"
                                        name="child7Income" />
                                </div>
                                <div class="input-box">
                                    <label>Age</label>
                                    <input type="number" class="gray-input" placeholder="Enter age" name="child7Age"
                                        maxlength="3" />
                                </div>
                                <div class="input-box">
                                    <label>Working</label>
                                    <div class="select-box">
                                        <select name="child7Work">
                                            <option hidden>Yes / No</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="hidden" id="addChild8Button">Add Child</button>

                        <div class="hidden8">
                            <div class="column">
                                <div class="input-box">
                                    <label><b>8. </b>Full Name</label>
                                    <input type="text" class="gray-input" placeholder="Enter last name"
                                        name="child8FullName" maxlength="20" />
                                </div>
                                <div class="input-box">
                                    <label>Occupation</label>
                                    <input type="text" class="gray-input" placeholder="Enter occupation"
                                        name="child8Occupation" maxlength="20" />
                                </div>
                                <div class="input-box">
                                    <label>Income</label>
                                    <input type="number" class="gray-input" placeholder="Enter income"
                                        name="child8Income" />
                                </div>
                                <div class="input-box">
                                    <label>Age</label>
                                    <input type="number" class="gray-input" placeholder="Enter age" name="child8Age"
                                        maxlength="3" />
                                </div>
                                <div class="input-box">
                                    <label>Working</label>
                                    <div class="select-box">
                                        <select name="child8Work">
                                            <option hidden>Yes / No</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="hidden" id="addChild9Button">Add Child</button>

                        <div class="hidden9">
                            <div class="column">
                                <div class="input-box">
                                    <label><b>9. </b>Full Name</label>
                                    <input type="text" class="gray-input" placeholder="Enter last name"
                                        name="child9FullName" maxlength="20" />
                                </div>
                                <div class="input-box">
                                    <label>Occupation</label>
                                    <input type="text" class="gray-input" placeholder="Enter occupation"
                                        name="child9Occupation" maxlength="20" />
                                </div>
                                <div class="input-box">
                                    <label>Income</label>
                                    <input type="number" class="gray-input" placeholder="Enter income"
                                        name="child9Income" />
                                </div>
                                <div class="input-box">
                                    <label>Age</label>
                                    <input type="number" class="gray-input" placeholder="Enter age" name="child9Age"
                                        maxlength="3" />
                                </div>
                                <div class="input-box">
                                    <label>Working</label>
                                    <div class="select-box">
                                        <select name="child9Work">
                                            <option hidden>Yes / No</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="hidden" id="addChild10Button">Add Child</button>

                        <div class="hidden10">
                            <div class="column">
                                <div class="input-box">

                                    <label><b>10. </b>Full Name</label>
                                    <input type="text" class="gray-input" placeholder="Enter last name"
                                        name="child10FullName" maxlength="20">
                                </div>
                                <div class="input-box">
                                    <label>Occupation</label>
                                    <input type="text" class="gray-input" placeholder="Enter occupation"
                                        name="child10Occupation" maxlength="20" />
                                </div>
                                <div class="input-box">
                                    <label>Income</label>
                                    <input type="number" class="gray-input" placeholder="Enter income"
                                        name="child10Income" />
                                </div>
                                <div class="input-box">
                                    <label>Age</label>
                                    <input type="number" class="gray-input" placeholder="Enter age" name="child10Age"
                                        maxlength="3" />
                                </div>
                                <div class="input-box">
                                    <label>Working</label>
                                    <div class="select-box">
                                        <select name="child10Work">
                                            <option hidden>Yes / No</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <br>
                        <b>25. Other Dependent</b>
                        <p style="font-size: 14px">(leave blank if none)</p>


                        <div class="column">

                            <div class="input-box">
                                <label><b>1. </b>Full Name</label>
                                <input type="text" class="gray-input" placeholder="Enter last name"
                                    name="dependentFullName" value="<?php echo $row["dependentFullName"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label>Occupation</label>
                                <input type="text" class="gray-input" placeholder="Enter occupation"
                                    name="dependentOccupation" value="<?php echo $row["dependentOccupation"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label>Income</label>
                                <input type="number" class="gray-input" placeholder="Enter income"
                                    name="dependentIncome" value="<?php echo $row["dependentIncome"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label>Age</label>
                                <input type="number" class="gray-input" placeholder="Enter age" name="dependentAge"
                                    maxlength="3" value="<?php echo $row["dependentAge"]; ?>" />
                            </div>
                            <div class="input-box">
                                <label>Working</label>
                                <div class="select-box">
                                    <select name="dependentWork">
                                        <option hidden>Working / Not Working</option>
                                        <option value="Working" <?php if ($row["dependentWork"] == "Working") {
                                              echo "selected";
                                            } ?>>Working</option>
                                        <option value="Not Working" <?php if ($row["dependentWork"] == "Not Working") {
                                              echo "selected";
                                            } ?>>Not Working</option>
                                    </select>
                                </div>

                            </div>
                        </div>



                        <button class="dependent2Button" id="dependent2Button">Add Dependent</button>


                        <div class="dependent2">
                            <div class="column">
                                <div class="input-box">
                                    <label><b>2. </b>Full Name</label>
                                    <input type="text" class="gray-input" placeholder="Enter last name"
                                        name="dependent2FullName" value="<?php echo $row["dependent2FullName"]; ?>" />
                                </div>
                                <div class="input-box">
                                    <label>Occupation</label>
                                    <input type="text" class="gray-input" placeholder="Enter occupation"
                                        name="dependent2Occupation"
                                        value="<?php echo $row["dependent2Occupation"]; ?>" />
                                </div>
                                <div class="input-box">
                                    <label>Income</label>
                                    <input type="number" class="gray-input" placeholder="Enter income"
                                        name="dependent2Income" value="<?php echo $row["dependent2Income"]; ?>" />
                                </div>
                                <div class="input-box">
                                    <label>Age</label>
                                    <input type="number" class="gray-input" placeholder="Enter age" name="dependent2Age"
                                        maxlength="3" value="<?php echo $row["dependent2Age"]; ?>" />
                                </div>
                                <div class="input-box">
                                    <label>Working</label>
                                    <div class="select-box">
                                        <select name="dependent2Work">
                                            <option hidden>Working / Not Working</option>
                                            <option value="Working" <?php if ($row["dependent2Work"] == "Working") {
                                                echo "selected";
                                              } ?>>Working</option>
                                            <option value="Not Working" <?php if ($row["dependent2Work"] == "Not Working") {
                                                echo "selected";
                                              } ?>>Not Working</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="hidden" id="dependent3Button">Add Dependent</button>

                        <div class="dependent3">
                            <div class="column">
                                <div class="input-box">
                                    <label><b>3. </b>Full Name</label>
                                    <input type="text" class="gray-input" placeholder="Enter last name"
                                        name="dependent3FullName" value="<?php echo $row["dependent3FullName"]; ?>" />
                                </div>
                                <div class="input-box">
                                    <label>Occupation</label>
                                    <input type="text" class="gray-input" placeholder="Enter occupation"
                                        name="dependent3Occupation"
                                        value="<?php echo $row["dependent3Occupation"]; ?>" />
                                </div>
                                <div class="input-box">
                                    <label>Income</label>
                                    <input type="number" class="gray-input" placeholder="Enter income"
                                        name="dependent3Income" value="<?php echo $row["dependent3Income"]; ?>" />
                                </div>
                                <div class="input-box">
                                    <label>Age</label>
                                    <input type="number" class="gray-input" placeholder="Enter age" name="dependent3Age"
                                        maxlength="3" value="<?php echo $row["dependent3Age"]; ?>" />
                                </div>
                                <div class="input-box">
                                    <label>Working</label>
                                    <div class="select-box">
                                        <select name="dependent3Work">
                                            <option hidden>Working / Not Working</option>
                                            <option value="Working" <?php if ($row["dependent3Work"] == "Working") {
                                                echo "selected";
                                              } ?>>Working</option>
                                            <option value="Not Working" <?php if ($row["dependent3Work"] == "Not Working") {
                                                echo "selected";
                                              } ?>>Not Working</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="hidden" id="dependent4Button" style="display:none;">Add Dependent</button>

                        <div class="dependent4">
                            <div class="column">
                                <div class="input-box">
                                    <label><b>4. </b>Full Name</label>
                                    <input type="text" class="gray-input" placeholder="Enter last name"
                                        name="dependent4FullName" />
                                </div>
                                <div class="input-box">
                                    <label>Occupation</label>
                                    <input type="text" class="gray-input" placeholder="Enter occupation"
                                        name="dependent4Occupation" />
                                </div>
                                <div class="input-box">
                                    <label>Income</label>
                                    <input type="number" class="gray-input" placeholder="Enter income"
                                        name="dependent4Income" />
                                </div>
                                <div class="input-box">
                                    <label>Age</label>
                                    <input type="number" class="gray-input" placeholder="Enter age" name="dependent4Age"
                                        maxlength="3" />
                                </div>
                                <div class="input-box">
                                    <label>Working</label>
                                    <div class="select-box">
                                        <select name="dependent4Work">
                                            <option hidden>Yes / No</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="hidden" id="dependent5Button">Add Dependent</button>

                        <div class="dependent5">
                            <div class="column">
                                <div class="input-box">
                                    <label><b>5. </b>Full Name</label>
                                    <input type="text" class="gray-input" placeholder="Enter last name"
                                        name="dependent5FullName" />
                                </div>
                                <div class="input-box">
                                    <label>Occupation</label>
                                    <input type="text" class="gray-input" placeholder="Enter occupation"
                                        name="dependent5Occupation" />
                                </div>
                                <div class="input-box">
                                    <label>Income</label>
                                    <input type="number" class="gray-input" placeholder="Enter income"
                                        name="dependent5Income" />
                                </div>
                                <div class="input-box">
                                    <label>Age</label>
                                    <input type="number" class="gray-input" placeholder="Enter age" name="dependent5Age"
                                        maxlength="3" />
                                </div>
                                <div class="input-box">
                                    <label>Working</label>
                                    <div class="select-box">
                                        <select name="dependent5Work">
                                            <option hidden>Yes / No</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="column">
                            <button class="previousbutton" id="previousbutton">Previous</button>
                            <button class="nextbutton2" id="nextbutton2">Next</button>
                        </div>
                    </div>
                    <!-- END OF PAGE 2 -->


                    <!-- PAGE 3!!!! -->

                    <div class="page3">

                        <div class="progress-bar">
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>

                        <h1 style="background-color: lightblue; color: black; font-size: 25px">III. Education / HR
                            Profile</h1>
                        <br>
                        <div class="gender-box">
                            <b>26. Educational Attainment</b>
                            <div class="input-box">
                                <div class="select-box">
                                    <select name="educationalAttainment">
                                        <option hidden>Select Educational Attainment</option>

                                        <option value="Elementary Level" <?php if ($row["educationalAttainment"] == "Elementary Level") {
                                                            echo "selected";
                                                          } ?>>Elementary Level</option>
                                        <option value="Elementary Graduate" <?php if ($row["educationalAttainment"] == "Elementary Graduate") {
                                                              echo "selected";
                                                            } ?>>Elementary Graduate</option>
                                        <option value="High School Level" <?php if ($row["educationalAttainment"] == "High School Level") {
                                                            echo "selected";
                                                          } ?>>High School Level</option>
                                        <option value="High School Graduate" <?php if ($row["educationalAttainment"] == "High School Graduate") {
                                                                echo "selected";
                                                              } ?>>High School Graduate</option>
                                        <option value="College Level" <?php if ($row["educationalAttainment"] == "College Level") {
                                                        echo "selected";
                                                      } ?>>College Level</option>
                                        <option value="College Graduate" <?php if ($row["educationalAttainment"] == "College Graduate") {
                                                            echo "selected";
                                                          } ?>>College Graduate</option>
                                        <option value="Post Graduate" <?php if ($row["educationalAttainment"] == "Post Graduate") {
                                                        echo "selected";
                                                      } ?>>Post Graduate</option>
                                        <option value="Vocational" <?php if ($row["educationalAttainment"] == "Vocational") {
                                                      echo "selected";
                                                    } ?>>Vocational</option>
                                        <option value="Not Attended School" <?php if ($row["educationalAttainment"] == "Not Attended School") {
                                                              echo "selected";
                                                            } ?>>Not Attended School</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="gender-box">
                            <b>27. Areas of Specialization / Technical Skills (Check all applicable)</b>
                            <div class="gender-option">
                            </div>

                            <div class="columncheckbox">
                                <div class="gender">
                                    <input type="checkbox" id="check-27medical" name="specialization[]" value="Medical"
                                        <?php if (in_array('Medical', $selectedSpecializations)) echo 'checked'; ?> />
                                    <label for="check-27medical">Medical</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-27teaching" name="specialization[]"
                                        value="Teaching"
                                        <?php if (in_array('Teaching', $selectedSpecializations)) echo 'checked'; ?> />
                                    <label for="check-27teaching">Teaching</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-27legal" name="specialization[]"
                                        value="Legal Services"
                                        <?php if (in_array('Legal Services', $selectedSpecializations)) echo 'checked'; ?> />
                                    <label for="check-27legal">Legal Services</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-27dental" name="specialization[]" value="Dental"
                                        <?php if (in_array('Dental', $selectedSpecializations)) echo 'checked'; ?> />
                                    <label for="check-27dental">Dental</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-27counseling" name="specialization[]"
                                        value="Counseling"
                                        <?php if (in_array('Counseling', $selectedSpecializations)) echo 'checked'; ?> />
                                    <label for="check-27counseling">Counseling</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-27farming" name="specialization[]" value="Farming"
                                        <?php if (in_array('Farming', $selectedSpecializations)) echo 'checked'; ?> />
                                    <label for="check-27farming">Farming</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-27fishing" name="specialization[]" value="Fishing"
                                        <?php if (in_array('Fishing', $selectedSpecializations)) echo 'checked'; ?> />
                                    <label for="check-27fishing">Fishing</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-27cooking" name="specialization[]" value="Cooking"
                                        <?php if (in_array('Cooking', $selectedSpecializations)) echo 'checked'; ?> />
                                    <label for="check-27cooking">Cooking</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-27arts" name="specialization[]" value="Arts"
                                        <?php if (in_array('Arts', $selectedSpecializations)) echo 'checked'; ?> />
                                    <label for="check-27arts">Arts</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-27engineering" name="specialization[]"
                                        value="Engineering"
                                        <?php if (in_array('Engineering', $selectedSpecializations)) echo 'checked'; ?> />
                                    <label for="check-27engineering">Engineering</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-27carpenter" name="specialization[]"
                                        value="Carpenter"
                                        <?php if (in_array('Carpenter', $selectedSpecializations)) echo 'checked'; ?> />
                                    <label for="check-27carpenter">Carpenter</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-27plumber" name="specialization[]" value="Plumber"
                                        <?php if (in_array('Plumber', $selectedSpecializations)) echo 'checked'; ?> />
                                    <label for="check-27plumber">Plumber</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-27barber" name="specialization[]" value="Barber"
                                        <?php if (in_array('Barber', $selectedSpecializations)) echo 'checked'; ?> />
                                    <label for="check-27barber">Barber</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-27mason" name="specialization[]" value="Mason"
                                        <?php if (in_array('Mason', $selectedSpecializations)) echo 'checked'; ?> />
                                    <label for="check-27mason">Mason</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-27sapatero" name="specialization[]"
                                        value="Sapatero"
                                        <?php if (in_array('Sapatero', $selectedSpecializations)) echo 'checked'; ?> />
                                    <label for="check-27sapatero">Sapatero</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-27evangelization" name="specialization[]"
                                        value="Evangelization"
                                        <?php if (in_array('Evangelization', $selectedSpecializations)) echo 'checked'; ?> />
                                    <label for="check-27evangelization">Evangelization</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-27tailor" name="specialization[]" value="Tailor"
                                        <?php if (in_array('Tailor', $selectedSpecializations)) echo 'checked'; ?> />
                                    <label for="check-27tailor">Tailor</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-27chef" name="specialization[]" value="Chef / Cook"
                                        <?php if (in_array('Chef / Cook', $selectedSpecializations)) echo 'checked'; ?> />
                                    <label for="check-27chef">Chef / Cook</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-27milwright" name="specialization[]"
                                        value="Milwright"
                                        <?php if (in_array('Milwright', $selectedSpecializations)) echo 'checked'; ?> />
                                    <label for="check-27milwright">Milwright</label>
                                </div>
                            </div>

                            <div class="input-box">
                                <label>Other area of specialization, specify if have</label>
                                <input type="text" class="gray-input" placeholder="Enter other specialization"
                                    name="specializationOthers" value="<?php echo $row["specializationOthers"]; ?>" />
                            </div>

                            <br>
                            <div class="gender-box">
                                <b>28. Share Skill (Community Service)</b>
                                <div class="gender-option">
                                    <div class="gender">
                                        <div class="input-box">
                                            <label>1</label>
                                            <input type="text" class="gray-input" name="shareSkill"
                                                value="<?php echo $row["shareSkill"]; ?>" />
                                        </div>
                                    </div>
                                    <div class="gender">
                                        <div class="input-box">
                                            <label>2</label>
                                            <input type="text" class="gray-input" name="shareSkill1"
                                                value="<?php echo $row["shareSkill1"]; ?>" />
                                        </div>
                                    </div>
                                    <div class="gender">
                                        <div class="input-box">
                                            <label>3</label>
                                            <input type="text" class="gray-input" name="shareSkill2"
                                                value="<?php echo $row["shareSkill2"]; ?>" />
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <div class="gender-box">
                                    <b>29. Community Service and Involvement (Check all applicable)</b>

                                    <div class="columncheckbox">
                                        <div class="gender">
                                            <input type="checkbox" id="check-29medical" name="communityService[]"
                                                value="Medical"
                                                <?php if (in_array('Medical', $selectedComService)) echo 'checked'; ?> />
                                            <label for="check-29medical">Medical</label>
                                        </div>
                                        <div class="gender">
                                            <input type="checkbox" id="check-29resource" name="communityService[]"
                                                value="Resource Volunteer"
                                                <?php if (in_array('Resource Volunteer', $selectedComService)) echo 'checked'; ?> />
                                            <label for="check-29resource">Resource Volunteer</label>
                                        </div>
                                        <div class="gender">
                                            <input type="checkbox" id="check-29beautification" name="communityService[]"
                                                value="Community Beautification"
                                                <?php if (in_array('Community Beautification', $selectedComService)) echo 'checked'; ?> />
                                            <label for="check-29beautification">Community Beautification</label>
                                        </div>
                                        <div class="gender">
                                            <input type="checkbox" id="check-29org" name="communityService[]"
                                                value="Community / Organization Leader"
                                                <?php if (in_array('Community / Organization Leader', $selectedComService)) echo 'checked'; ?> />
                                            <label for="check-29org">Community / Organization Leader</label>
                                        </div>
                                        <div class="gender">
                                            <input type="checkbox" id="check-29dental" name="communityService[]"
                                                value="Dental"
                                                <?php if (in_array('Dental', $selectedComService)) echo 'checked'; ?> />
                                            <label for="check-29dental">Dental</label>
                                        </div>
                                        <div class="gender">
                                            <input type="checkbox" id="check-29friendlyvisits" name="communityService[]"
                                                value="Friendly Visits"
                                                <?php if (in_array('Friendly Visits', $selectedComService)) echo 'checked'; ?> />
                                            <label for="check-29friendlyvisits">Friendly Visits</label>
                                        </div>
                                    </div>

                                    <div class="columncheckbox">
                                        <div class="gender">
                                            <input type="checkbox" id="check-29neighborhood" name="communityService[]"
                                                value="Neighborhood Support Services"
                                                <?php if (in_array('Neighborhood Support Services', $selectedComService)) echo 'checked'; ?> />
                                            <label for="check-29neighborhood">Neighborhood Support Services</label>
                                        </div>
                                        <div class="gender">
                                            <input type="checkbox" id="check-29legalservices" name="communityService[]"
                                                value="Legal Services"
                                                <?php if (in_array('Legal Services', $selectedComService)) echo 'checked'; ?> />
                                            <label for="check-29legalservices">Legal Services</label>
                                        </div>
                                        <div class="gender">
                                            <input type="checkbox" id="check-29religous" name="communityService[]"
                                                value="Religious"
                                                <?php if (in_array('Religious', $selectedComService)) echo 'checked'; ?> />
                                            <label for="check-29religous">Religious</label>
                                        </div>
                                        <div class="gender">
                                            <input type="checkbox" id="check-29counseling" name="communityService[]"
                                                value="Counseling / Referral"
                                                <?php if (in_array('Counseling / Referral', $selectedComService)) echo 'checked'; ?> />
                                            <label for="check-29counseling">Counseling / Referral</label>
                                        </div>
                                        <div class="gender">
                                            <input type="checkbox" id="check-29sponsorship" name="communityService[]"
                                                value="Sponsorship"
                                                <?php if (in_array('Sponsorship', $selectedComService)) echo 'checked'; ?> />
                                            <label for="check-29sponsorship">Sponsorship</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-box">
                                    <label>Other area of involvement, Specify</label>
                                    <input type="text" class="gray-input" placeholder="Enter other specialization"
                                        name="communityServiceOthers"
                                        value="<?php echo $row["communityServiceOthers"]; ?>" />
                                </div>
                            </div>
                            <div class="column">
                                <button class="previousbutton2" id="previousbutton2">Previous</button>
                                <button class="nextbutton3" id="nextbutton3">Next</button>
                            </div>

                        </div>
                    </div>



                    <!-- END OF PAGE 3!!! -->






                    <div class="page4">

                        <div class="progress-bar">
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span></span>
                            <span></span>
                        </div>

                        <h1 style="background-color: lightblue; color: black; font-size: 25px">IV. Dependency Profile
                        </h1>
                        <br>
                        <div class="gender-box">
                            <b>30. Living / Residing with (Check all applicable)</b>


                            <div class="columncheckbox">
                                <div class="gender">
                                    <input type="checkbox" id="check-30alone" name="residingwith[]" value="Alone"
                                        <?php if (in_array('Alone', $selectedResidingWith)) echo 'checked'; ?> />
                                    <label for="check-30alone">Alone</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-30grandchild" name="residingwith[]"
                                        value="Grand Child(ren)"
                                        <?php if (in_array('Grand Child(ren)', $selectedResidingWith)) echo 'checked'; ?> />
                                    <label for="check-30grandchild">Grand Child(ren)</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-30commonlaw" name="residingwith[]"
                                        value="Common Law Spouse"
                                        <?php if (in_array('Common Law Spouse', $selectedResidingWith)) echo 'checked'; ?> />
                                    <label for="check-30commonlaw">Common Law Spouse</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-30spouse" name="residingwith[]" value="Spouse"
                                        <?php if (in_array('Spouse', $selectedResidingWith)) echo 'checked'; ?> />
                                    <label for="check-30spouse">Spouse</label>
                                </div>

                                <div class="gender">
                                    <input type="checkbox" id="check-30inlaw" name="residingwith[]" value="In-law(s)"
                                        <?php if (in_array('In-law(s)', $selectedResidingWith)) echo 'checked'; ?> />
                                    <label for="check-30inlaw">In-law(s)</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-30careinstitution" name="residingwith[]"
                                        value="Care Institution"
                                        <?php if (in_array('Care Institution', $selectedResidingWith)) echo 'checked'; ?> />
                                    <label for="check-30careinstitution">Care Institution</label>
                                </div>
                            </div>

                            <div class="columncheckbox">
                                <div class="gender">
                                    <input type="checkbox" id="check-30children" name="residingwith[]"
                                        value="Child(ren)"
                                        <?php if (in_array('Child(ren)', $selectedResidingWith)) echo 'checked'; ?> />
                                    <label for="check-30children">Child(ren)</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-30relative" name="residingwith[]"
                                        value="Relative(s)"
                                        <?php if (in_array('Relative(s)', $selectedResidingWith)) echo 'checked'; ?> />
                                    <label for="check-30relative">Relative(s)</label>
                                </div>

                                <div class="gender">
                                    <input type="checkbox" id="check-30friend" name="residingwith[]" value="Friend(s)"
                                        <?php if (in_array('Friend(s)', $selectedResidingWith)) echo 'checked'; ?> />
                                    <label for="check-30friend">Friend(s)</label>
                                </div>
                            </div>

                            <div class="input-box">
                                <label>Others, pls specify</label>
                                <input type="text" class="gray-input" placeholder="Enter another involvment with"
                                    name="residingWithOthers" value="<?php echo $row["residingWithOthers"]; ?>" />
                            </div>
                        </div>

                        <br>
                        <div class="gender-box">
                            <b>31. Household Condition</b>
                            <div class="gender">
                                <input type="checkbox" id="check-31noprivacy" name="houseHold[]" value="No privacy"
                                    <?php if (in_array('No privacy', $selectedHouseHold)) echo 'checked'; ?> />
                                <label for="check-31noprivacy">No privacy</label>
                            </div>
                            <div class="gender">
                                <input type="checkbox" id="check-31overcrowded" name="houseHold[]"
                                    value="Overcrowded in home"
                                    <?php if (in_array('Overcrowded in home', $selectedHouseHold)) echo 'checked'; ?> />
                                <label for="check-31overcrowded">Overcrowded in home</label>
                            </div>
                            <div class="gender">
                                <input type="checkbox" id="check-31informal" name="houseHold[]" value="Informal Settler"
                                    <?php if (in_array('Informal Settler', $selectedHouseHold)) echo 'checked'; ?> />
                                <label for="check-31informal">Informal Settler</label>
                            </div>
                            <div class="gender">
                                <input type="checkbox" id="check-31nopermanent" name="houseHold[]"
                                    value="No permanent house"
                                    <?php if (in_array('No permanent house', $selectedHouseHold)) echo 'checked'; ?> />
                                <label for="check-31nopermanent">No permanent house</label>
                            </div>


                            <div class="gender">
                                <input type="checkbox" id="check-31highcostofrent" name="houseHold[]"
                                    value="High cost of rent"
                                    <?php if (in_array('High cost of rent', $selectedHouseHold)) echo 'checked'; ?> />
                                <label for="check-31highcostofrent">High cost of rent</label>
                            </div>

                            <div class="gender">
                                <input type="checkbox" id="check-31longing" name="houseHold[]"
                                    value="Longing for independent living quiet atmosphere"
                                    <?php if (in_array('Longing for independent living quiet atmosphere', $selectedHouseHold)) echo 'checked'; ?> />
                                <label for="check-31longing">Longing for independent living quiet atmosphere</label>
                            </div>

                            <div class="input-box">
                                <label>Others, pls specify</label>
                                <input type="text" placeholder="Others" name="houseHoldOthers"
                                    value="<?php echo $row["houseHoldOthers"]; ?>" maxlength="20" />
                            </div>
                        </div>


                        <div class="column">
                            <button class="previousbutton3" id="previousbutton3">Previous</button>
                            <button class="nextbutton4" id="nextbutton4">Next</button>
                        </div>
                    </div>

                    <!-- END OF PAGE 4!!! -->

                    <!-- START OF PAGE 5!!! -->

                    <div class="page5">

                        <div class="progress-bar">
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span></span>
                        </div>

                        <h1 style="background-color: lightblue; color: black; font-size: 25px">V. Economic Profile</h1>
                        <br>
                        <div class="gender-box">
                            <b>32. Source of Income and Assistance (Check all applicable)</b>

                            <div class="columncheckbox">
                                <div class="gender">
                                    <input type="checkbox" id="check-32ownearnings" name="sourceIncome[]"
                                        value="Own earnings of salary or Wages"
                                        <?php if (in_array('Own earnings of salary or Wages', $selectedSourceIncome)) echo 'checked'; ?> />
                                    <label for="check-32ownearnings">Own earnings of salary or Wages</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-32ownpension" name="sourceIncome[]"
                                        value="Own Pension"
                                        <?php if (in_array('Own Pension', $selectedSourceIncome)) echo 'checked'; ?> />
                                    <label for="check-32ownpension">Own Pension</label>
                                </div>

                                <div class="gender">
                                    <input type="checkbox" id="check-32stocks" name="sourceIncome[]"
                                        value="Stocks / Dividends"
                                        <?php if (in_array('Stocks / Dividends', $selectedSourceIncome)) echo 'checked'; ?> />
                                    <label for="check-32stocks">Stocks / Dividends</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-32dependent" name="sourceIncome[]"
                                        value="Dependent on children / relatives"
                                        <?php if (in_array('Dependent on children / relatives', $selectedSourceIncome)) echo 'checked'; ?> />
                                    <label for="check-32dependent">Dependent on children / relatives</label>
                                </div>

                                <div class="gender">
                                    <input type="checkbox" id="check-32spousesalary" name="sourceIncome[]"
                                        value="Spouse salary"
                                        <?php if (in_array('Spouse salary', $selectedSourceIncome)) echo 'checked'; ?> />
                                    <label for="check-32spousesalary">Spouse salary</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-32insurance" name="sourceIncome[]"
                                        value="Insurance"
                                        <?php if (in_array('Insurance', $selectedSourceIncome)) echo 'checked'; ?> />
                                    <label for="check-32insurance">Insurance</label>
                                </div>
                            </div>

                            <div class="columncheckbox">
                                <div class="gender">
                                    <input type="checkbox" id="check-32spousepension" name="sourceIncome[]"
                                        value="Spouse Pension"
                                        <?php if (in_array('Spouse Pension', $selectedSourceIncome)) echo 'checked'; ?> />
                                    <label for="check-32spousepension">Spouse Pension</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-32rentals" name="sourceIncome[]"
                                        value="Rentals / sharecrops"
                                        <?php if (in_array('Rentals / sharecrops', $selectedSourceIncome)) echo 'checked'; ?> />
                                    <label for="check-32rentals">Rentals / sharecrops</label>
                                </div>

                                <div class="gender">
                                    <input type="checkbox" id="check-32savings" name="sourceIncome[]" value="Savings"
                                        <?php if (in_array('Savings', $selectedSourceIncome)) echo 'checked'; ?> />
                                    <label for="check-32savings">Savings</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-32livestock" name="sourceIncome[]"
                                        value="Livestock / orchard / farm"
                                        <?php if (in_array('Livestock / orchard / farm', $selectedSourceIncome)) echo 'checked'; ?> />
                                    <label for="check-32livestock">Livestock / orchard / farm</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-32fishing" name="sourceIncome[]" value="Fishing"
                                        <?php if (in_array('Fishing', $selectedSourceIncome)) echo 'checked'; ?> />
                                    <label for="check-32fishing">Fishing</label>
                                </div>
                            </div>
                            <div class="input-box">
                                <label>Others, pls specify</label>
                                <input type="text" placeholder="Others source of income" name="sourceIncomeOthers"
                                    value="<?php echo $row["sourceIncomeOthers"]; ?>" maxlength="20" />
                            </div>

                        </div>
                        <br>
                        <div class="gender-box">
                            <b>33. Assets: Real and Immovable Properties (Check all applicable)</b>
                            <br>
                            <div class="gender-option">
                                <div class="gender">
                                    <input type="checkbox" id="check-33house" name="assetsFirst[]" value="House"
                                        <?php if (in_array('House', $selectedAssetsFirst)) echo 'checked'; ?> />
                                    <label for="check-33house">House</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-33lot" name="assetsFirst[]" value="Lot / Farmland"
                                        <?php if (in_array('Lot / Farmland', $selectedAssetsFirst)) echo 'checked'; ?> />
                                    <label for="check-33lot">Lot / Farmland</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-33houselot" name="assetsFirst[]"
                                        value="House & Lot"
                                        <?php if (in_array('House & Lot', $selectedAssetsFirst)) echo 'checked'; ?> />
                                    <label for="check-33houselot">House & Lot</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-33commercial" name="assetsFirst[]"
                                        value="Commercial Building"
                                        <?php if (in_array('Commercial Building', $selectedAssetsFirst)) echo 'checked'; ?> />
                                    <label for="check-33commercial">Commercial Building</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-33fishpond" name="assetsFirst[]"
                                        value="Fishpond / resort"
                                        <?php if (in_array('Fishpond / resort', $selectedAssetsFirst)) echo 'checked'; ?> />
                                    <label for="check-33fishpond">Fishpond / resort</label>
                                </div>
                                <div class="input-box">
                                    <label>Others, pls specify</label>
                                    <input type="text" placeholder="Others" name="assetsFirstOthers"
                                        value="<?php echo $row["assetsFirstOthers"]; ?>" maxlength="20" />
                                </div>
                            </div>

                            <br>
                            <div class="gender-box">
                                <b>34. Assets: Personal and Movable Properties (Check all applicable)</b>
                                <div class="columncheckbox">
                                    <div class="gender">
                                        <input type="checkbox" id="check-34automobile" name="assetsSecond[]"
                                            value="Automobile"
                                            <?php if (in_array('Automobile', $selectedAssetsSecond)) echo 'checked'; ?> />
                                        <label for="check-34automobile">Automobile</label>
                                    </div>
                                    <div class="gender">
                                        <input type="checkbox" id="check-34pc" name="assetsSecond[]"
                                            value="Personal Computer"
                                            <?php if (in_array('Personal Computer', $selectedAssetsSecond)) echo 'checked'; ?> />
                                        <label for="check-34pc">Personal Computer</label>
                                    </div>
                                    <div class="gender">
                                        <input type="checkbox" id="check-34boats" name="assetsSecond[]" value="Boats"
                                            <?php if (in_array('Boats', $selectedAssetsSecond)) echo 'checked'; ?> />
                                        <label for="check-34boats">Boats</label>
                                    </div>
                                    <div class="gender">
                                        <input type="checkbox" id="check-34heavyequipment" name="assetsSecond[]"
                                            value="Heavy Equipment"
                                            <?php if (in_array('Heavy Equipment', $selectedAssetsSecond)) echo 'checked'; ?> />
                                        <label for="check-34heavyequipment">Heavy Equipment</label>
                                    </div>
                                    <div class="gender">
                                        <input type="checkbox" id="check-34laptops" name="assetsSecond[]"
                                            value="Laptops"
                                            <?php if (in_array('Laptops', $selectedAssetsSecond)) echo 'checked'; ?> />
                                        <label for="check-34laptops">Laptops</label>
                                    </div>
                                    <div class="gender">
                                        <input type="checkbox" id="check-34drones" name="assetsSecond[]" value="Drones"
                                            <?php if (in_array('Drones', $selectedAssetsSecond)) echo 'checked'; ?> />
                                        <label for="check-34drones">Drones</label>
                                    </div>
                                </div>

                                <div class="columncheckbox">
                                    <div class="gender">
                                        <input type="checkbox" id="check-34motorcycle" name="assetsSecond[]"
                                            value="Motorcycle"
                                            <?php if (in_array('Motorcycle', $selectedAssetsSecond)) echo 'checked'; ?> />
                                        <label for="check-34motorcycle">Motorcycle</label>
                                    </div>
                                    <div class="gender">
                                        <input type="checkbox" id="check-34mobilephones" name="assetsSecond[]"
                                            value="Mobile Phones"
                                            <?php if (in_array('Mobile Phones', $selectedAssetsSecond)) echo 'checked'; ?> />
                                        <label for="check-34mobilephones">Mobile Phones</label>
                                    </div>
                                </div>
                                <div class="input-box">
                                    <label>Others, pls specify</label>
                                    <input type="text" placeholder="Others" name="assetsSecondOthers"
                                        value="<?php echo $row["assetsSecondOthers"]; ?>" maxlength="20" />
                                </div>



                                <br>
                                <div class="gender-box">
                                    <b>35. Monthly Income (in Philippine Peso)</b>
                                    <div class="gender-option">
                                        <br>
                                        <div class="column">
                                            <div class="gender">
                                                <input type="radio" id="radio-35sixty" name="monthlyIncome"
                                                    value="60,000 and above"
                                                    <?php if ($row["monthlyIncome"] == "60,000 and above") {
                                                                                                                    echo "checked";
                                                                                                                  } ?> />
                                                <label for="radio-35sixty">60,000 and above</label>
                                            </div>
                                            <div class="gender">
                                                <input type="radio" id="radio-35fifty" name="monthlyIncome"
                                                    value="50,000 to 60,000"
                                                    <?php if ($row["monthlyIncome"] == "50,000 to 60,000") {
                                                                                                                    echo "checked";
                                                                                                                  } ?> />
                                                <label for="radio-35fifty">50,000 to 60,000</label>
                                            </div>
                                            <div class="gender">
                                                <input type="radio" id="radio-35fourty" name="monthlyIncome"
                                                    value="40,000 to 50,000"
                                                    <?php if ($row["monthlyIncome"] == "40,000 to 50,000") {
                                                                                                                    echo "checked";
                                                                                                                  } ?> />
                                                <label for="radio-35fourty">40,000 to 50,000</label>
                                            </div>
                                            <div class="gender">
                                                <input type="radio" id="radio-35thirty" name="monthlyIncome"
                                                    value="30,000 to 40,000"
                                                    <?php if ($row["monthlyIncome"] == "30,000 to 40,000") {
                                                                                                                    echo "checked";
                                                                                                                  } ?> />
                                                <label for="radio-35thirty">30,000 to 40,000</label>
                                            </div>
                                            <div class="gender">
                                                <input type="radio" id="radio-35twenty" name="monthlyIncome"
                                                    value="20,000 to 30,000"
                                                    <?php if ($row["monthlyIncome"] == "20,000 to 30,000") {
                                                                                                                    echo "checked";
                                                                                                                  } ?> />
                                                <label for="radio-35twenty">20,000 to 30,000</label>
                                            </div>
                                            <div class="gender">
                                                <input type="radio" id="radio-35ten" name="monthlyIncome"
                                                    value="10,000 to 20,000" <?php if ($row["monthlyIncome"] == "10,000 to 20,000") {
                                                                                                                  echo "checked";
                                                                                                                } ?> />
                                                <label for="radio-35ten">10,000 to 20,000</label>
                                            </div>
                                            <div class="gender">
                                                <input type="radio" id="radio-35five" name="monthlyIncome"
                                                    value="5,000 to 10,000" <?php if ($row["monthlyIncome"] == "5,000 to 10,000") {
                                                                                                                  echo "checked";
                                                                                                                } ?> />
                                                <label for="radio-35five">5,000 to 10,000</label>
                                            </div>
                                            <div class="gender">
                                                <input type="radio" id="radio-35one" name="monthlyIncome"
                                                    value="1,000 to 5,000" <?php if ($row["monthlyIncome"] == "1,000 to 5,000") {
                                                                                                                echo "checked";
                                                                                                              } ?> />
                                                <label for="radio-35one">1,000 to 5,000</label>
                                            </div>
                                            <div class="gender">
                                                <input type="radio" id="radio-35belowone" name="monthlyIncome"
                                                    value="Below 1,000" <?php if ($row["monthlyIncome"] == "Below 1,000") {
                                                                                                                  echo "checked";
                                                                                                                } ?> />
                                                <label for="radio-35belowone">Below 1,000</label>
                                            </div>
                                        </div>


                                    </div>


                                    <br>
                                    <div class="gender-box">
                                        <b>36. Problems / Needs Commonly Encountered (Check all applicable)</b>

                                        <div class="gender">
                                            <input type="checkbox" id="check-36lackofincome" name="problems[]"
                                                value="Lack of income / resources"
                                                <?php if (in_array('Lack of income / resources', $selectedProblems)) echo 'checked'; ?> />
                                            <label for="check-36lackofincome">Lack of income / resources</label>
                                        </div>
                                        <div class="gender">
                                            <input type="checkbox" id="check-36lossofincome" name="problems[]"
                                                value="Loss of income / resources"
                                                <?php if (in_array('Loss of income / resources', $selectedProblems)) echo 'checked'; ?> />
                                            <label for="check-36lossofincome">Loss of income / resources</label>
                                        </div>
                                        <div class="gender">
                                            <input type="checkbox" id="check-36skills" name="problems[]"
                                                value="Skills / capability training"
                                                <?php if (in_array('Skills / capability training', $selectedProblems)) echo 'checked'; ?> />
                                            <label for="check-36skills">Skills / capability training</label>
                                        </div>
                                        <div class="gender">
                                            <input type="checkbox" id="check-36livelihood" name="problems[]"
                                                value="Livelihood opportunities"
                                                <?php if (in_array('Livelihood opportunities', $selectedProblems)) echo 'checked'; ?> />
                                            <label for="check-36livelihood">Livelihood opportunities</label>
                                        </div>

                                        <div class="input-box">
                                            <label>Others, pls specify</label>
                                            <input type="text" class="gray-input" placeholder="Others"
                                                name="problemsOthers" value="<?php echo $row["problemsOthers"]; ?>"
                                                maxlength="20" />
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <button class="previousbutton4" id="previousbutton4">Previous</button>
                            <button class="nextbutton5" id="nextbutton5">Next</button>
                        </div>
                    </div>

                    <!-- END OF PAGE 5!!! -->

                    <!-- START OF PAGE 6!! -->

                    <div class="page6">


                        <div class="progress-bar">
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active"></span>
                            <span class="active" style="background-color:#1CDB42;"></span>
                        </div>

                        <h1 style="background-color: lightblue; color: black;font-size: 25px">VI. Health Profile</h1>
                        <br>

                        <b>37. Medical Concern</b>
                        <br><br>
                        <h3>Blood Type</h3>
                        <div class="column">
                            <div class="select-box">
                                <select name="bloodType">
                                    <option hidden>Select Blood Type</option>
                                    <option value="O" <?php if ($row["bloodType"] == "O") {
                                          echo "selected";
                                        } ?>>O</option>
                                    <option value="A" <?php if ($row["bloodType"] == "A") {
                                          echo "selected";
                                        } ?>>A</option>
                                    <option value="B" <?php if ($row["bloodType"] == "B") {
                                          echo "selected";
                                        } ?>>B</option>
                                    <option value="AB" <?php if ($row["bloodType"] == "AB") {
                                            echo "selected";
                                          } ?>>AB</option>
                                    <option value="Don't Know" <?php if ($row["bloodType"] == "Don't Know") {
                                                    echo "selected";
                                                  } ?>>Don't Know</option>
                                </select>
                            </div>
                            <div class="input-box" id="invitext"></div>
                            <div class="input-box" id="invitext"></div>

                        </div>

                        <div class="input-box">
                            <label>Physical Disablity, specify</label>
                            <input type="text" class="gray-input" placeholder="Others" name="physicalDisability"
                                maxlength="50" value="<?php echo $row["physicalDisability"]; ?>" />
                        </div>

                        <div class="gender-box">
                            <div class="columncheckbox">
                                <div class="gender">
                                    <input type="checkbox" id="check-37healthproblems" name="medicalConcern[]"
                                        value="Health problems/ ailments"
                                        <?php if (in_array('Health problems/ ailments', $selectedMedicalConcerns)) echo 'checked'; ?> />
                                    <label for="check-37healthproblems">Health problems/ ailments</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-37hypertension" name="medicalConcern[]"
                                        value="Hypertension"
                                        <?php if (in_array('Hypertension', $selectedMedicalConcerns)) echo 'checked'; ?> />
                                    <label for="check-37hypertension">Hypertension</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-37arthritis" name="medicalConcern[]"
                                        value="Arthritis / Gout"
                                        <?php if (in_array('Arthritis / Gout', $selectedMedicalConcerns)) echo 'checked'; ?> />
                                    <label for="check-37arthritis">Arthritis / Gout</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-37coronary" name="medicalConcern[]"
                                        value="Coronary Heart Disease"
                                        <?php if (in_array('Coronary Heart Disease', $selectedMedicalConcerns)) echo 'checked'; ?> />
                                    <label for="check-37coronary">Coronary Heart Disease</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-37diabetes" name="medicalConcern[]"
                                        value="Diabetes"
                                        <?php if (in_array('Diabetes', $selectedMedicalConcerns)) echo 'checked'; ?> />
                                    <label for="check-37diabetes">Diabetes</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-37chronic" name="medicalConcern[]"
                                        value="Chronic Kidney Disease"
                                        <?php if (in_array('Chronic Kidney Disease', $selectedMedicalConcerns)) echo 'checked'; ?> />
                                    <label for="check-37chronic">Chronic Kidney Disease</label>
                                </div>
                            </div>
                            <div class="columncheckbox">
                                <div class="gender">
                                    <input type="checkbox" id="check-37alzheimer" name="medicalConcern[]"
                                        value="Alzheimer / Dementia"
                                        <?php if (in_array('Alzheimer / Dementia', $selectedMedicalConcerns)) echo 'checked'; ?> />
                                    <label for="check-37alzheimer">Alzheimer / Dementia</label>
                                </div>
                                <div class="gender">
                                    <input type="checkbox" id="check-37chronicobstructive" name="medicalConcern[]"
                                        value="Pulmonary Disease"
                                        <?php if (in_array('Pulmonary Disease', $selectedMedicalConcerns)) echo 'checked'; ?> />
                                    <label for="check-37chronicobstructive">Chronic Obstructive Pulmonary
                                        Disease</label>
                                </div>
                            </div>
                            <div class="input-box">
                                <label>Others, pls specify</label>
                                <input type="text" class="gray-input" placeholder="Others" name="medicalConcernOthers"
                                    value="<?php echo $row["medicalConcernOthers"]; ?>" maxlength="20" />
                            </div>


                            <br>

                            <b>38. Dental Concern</b>
                            <div class="gender">
                                <input type="radio" id="radio-38dentalcare" name="dentalConcern"
                                    value="Needs Dental Care" <?php if ($row["dentalConcern"] == "Needs Dental Care") {
                                                                                                                  echo "checked";
                                                                                                                } ?> />
                                <label for="radio-38dentalcare">Needs Dental Care</label>
                            </div>
                            <div class="input-box">
                                <label>Others, pls specify</label>
                                <input type="text" class="gray-input" placeholder="Others" name="dentalConcernOthers"
                                    value="<?php echo $row["dentalConcernOthers"]; ?>" maxlength="20" />
                            </div>


                            <br>
                            <b>39. Optical</b>

                            <div class="gender">
                                <input type="checkbox" id="check-39eye" name="optical[]" value="Eye Impairment"
                                    <?php if (in_array('Eye Impairment', $selectedOptical)) echo 'checked'; ?> />
                                <label for="check-39eye">Eye Impairment</label>
                            </div>
                            <div class="gender">
                                <input type="checkbox" id="check-39needseyecare" name="optical[]" value="Needs eye care"
                                    <?php if (in_array('Needs eye care', $selectedOptical)) echo 'checked'; ?> />
                                <label for="check-39needseyecare">Needs eye care</label>
                            </div>
                            <div class="input-box">
                                <label>Others, pls specify</label>
                                <input type="text" class="gray-input" placeholder="Others" name="opticalOthers"
                                    value="<?php echo $row["opticalOthers"]; ?>" maxlength="20" />
                            </div>



                            <br>
                            <b>40. Hearing</b>

                            <div class="gender">
                                <input type="radio" id="radio-40aural" name="hearing"
                                    value="Aural impairment / Hearing impairment"
                                    <?php if ($row["hearing"] == "Aural impairment / Hearing impairment") {
                                                                                                                          echo "checked";
                                                                                                                        } ?> />
                                <label for="radio-40aural">Aural impairment / Hearing impairment</label>
                            </div>
                            <div class="input-box">
                                <label>Others, pls specify</label>
                                <input type="text" class="gray-input" placeholder="Others" name="hearingOthers"
                                    value="<?php echo $row["hearingOthers"]; ?>" maxlength="20" />
                            </div>

                            <br>
                            <b>41. Social / Emotional</b>

                            <div class="gender">
                                <input type="checkbox" id="check-41neglect" name="socialEmotional[]"
                                    value="Feeling neglect / rejection"
                                    <?php if (in_array('Feeling neglect / rejection', $selectedSocialEmotional)) echo 'checked'; ?> />
                                <label for="check-41neglect">Feeling neglect / rejection</label>
                            </div>

                            <div class="gender">
                                <input type="checkbox" id="check-41helplessness" name="socialEmotional[]"
                                    value="Feeling helplessness / worthlessness"
                                    <?php if (in_array('Feeling helplessness / worthlessness', $selectedSocialEmotional)) echo 'checked'; ?> />
                                <label for="check-41helplessness">Feeling helplessness / worthlessness</label>
                            </div>

                            <div class="gender">
                                <input type="checkbox" id="check-41loneliness" name="socialEmotional[]"
                                    value="Feeling loneliness / isolate"
                                    <?php if (in_array('Feeling loneliness / isolate', $selectedSocialEmotional)) echo 'checked'; ?> />
                                <label for="check-41loneliness">Feeling loneliness / isolate</label>
                            </div>

                            <div class="gender">
                                <input type="checkbox" id="check-41leisure" name="socialEmotional[]"
                                    value="Lack leisure / recreational activities"
                                    <?php if (in_array('Lack leisure / recreational activities', $selectedSocialEmotional)) echo 'checked'; ?> />
                                <label for="check-41leisure">Lack leisure / recreational activities</label>
                            </div>

                            <div class="gender">
                                <input type="checkbox" id="check-41lacksc" name="socialEmotional[]"
                                    value="Lack SC friendly environment"
                                    <?php if (in_array('Lack SC friendly environment', $selectedSocialEmotional)) echo 'checked'; ?> />
                                <label for="check-41lacksc">Lack SC friendly environment</label>
                            </div>

                            <div class="input-box">
                                <label>Others, pls specify</label>
                                <input type="text" class="gray-input" placeholder="Others" name="socialEmotionalOthers"
                                    value="<?php echo $row["socialEmotionalOthers"]; ?>" maxlength="20" />
                            </div>

                            <br>
                            <b>42. Area / Difficulty</b>

                            <div class="gender">
                                <input type="checkbox" id="check-42highcost" name="areaDifficulty[]"
                                    value="High Cost of medicines"
                                    <?php if (in_array('High Cost of medicines', $selectedAreaDifficulty)) echo 'checked'; ?> />
                                <label for="check-42highcost">High Cost of medicines</label>
                            </div>
                            <div class="gender">
                                <input type="checkbox" id="check-42lackofmedicines" name="areaDifficulty[]"
                                    value="Lack of medicines"
                                    <?php if (in_array('Lack of medicines', $selectedAreaDifficulty)) echo 'checked'; ?> />
                                <label for="check-42lackofmedicines">Lack of medicines</label>
                            </div>
                            <div class="gender">
                                <input type="checkbox" id="check-42lackofmedical" name="areaDifficulty[]"
                                    value="Lack of medical attention"
                                    <?php if (in_array('Lack of medical attention', $selectedAreaDifficulty)) echo 'checked'; ?> />
                                <label for="check-42lackofmedical">Lack of medical attention</label>
                            </div>
                            <div class="input-box">
                                <label>Others, pls specify</label>
                                <input type="text" class="gray-input" placeholder="Others" name="areaDifficultyOthers"
                                    value="<?php echo $row["areaDifficultyOthers"]; ?>" maxlength="20" />
                            </div>



                            <br>
                            <b>43. List of Medicines for Maintenance</b>
                            <div class="input-box">
                                <label>Please specify, use comma to seperate items.</label>
                                <input type="text" class="gray-input"
                                    placeholder="Example : Amlodiphne 10mg, Losartan 50mg, etc." name="medicines"
                                    value="<?php echo $row["medicines"]; ?>" />
                            </div>

                            <br>
                            <b>44. Do you have a scheduled medical / physical check-up</b>

                            <div class="gender">
                                <input type="radio" id="radio-44yes" name="scheduledMedical" value="Yes" <?php if ($row["scheduledMedical"] == "Yes") {
                                                                                                echo "checked";
                                                                                              } ?> />
                                <label for="radio-44yes">Yes</label>
                            </div>
                            <div class="gender">
                                <input type="radio" id="radio-44no" name="scheduledMedical" value="No" <?php if ($row["scheduledMedical"] == "No") {
                                                                                              echo "checked";
                                                                                            } ?> />
                                <label for="radio-44no">No</label>
                            </div>


                            <br>
                            <b>45. If Yes, when is it done?</b>

                            <div class="gender">
                                <input type="radio" id="radio-45yearly" name="scheduledMedical1" value="Yearly" <?php if ($row["scheduledMedical1"] == "Yearly") {
                                                                                                      echo "checked";
                                                                                                    } ?> />
                                <label for="radio-45yearly">Yearly</label>
                            </div>
                            <div class="gender">
                                <input type="radio" id="radio-45sixmonths" name="scheduledMedical1"
                                    value="Every 6 months" <?php if ($row["scheduledMedical1"] == "Every 6 months") {
                                                                                                                  echo "checked";
                                                                                                                } ?> />
                                <label for="radio-45sixmonths">Every 6 months</label>
                            </div>
                            <div class="input-box">
                                <label>Others, pls specify</label>
                                <input type="text" class="gray-input" placeholder="Others"
                                    name="scheduledMedical1Others"
                                    value="<?php echo $row["scheduledMedical1Others"]; ?>" maxlength="14" />
                            </div>
                        </div>
                        <br><br>



                        <div class="hideifdeceased <?php echo $hideClass; ?>">
                            <button class="deceasedbutton" id="deceasedbutton">Deceased?</button>
                            <div class="hiddendec">
                                <h3 style="color:red;">Deceased.</h3>
                                <b>Warning! this will change the person status into deceased, and it cannot change back!
                                    <br> Do this only if you are sure!</b>
                                <div class="column">
                                    <div class="select-box">
                                        <select name="personStatus" id="personStatus">
                                            <option hidden>Active</option>
                                            <option value="Active"
                                                <?php if ($personStatus == "Active") { echo "selected"; } ?>>Active
                                            </option>
                                            <option value="Deceased"
                                                <?php if ($personStatus == "Deceased") { echo "selected"; } ?>>Deceased
                                            </option>
                                        </select>
                                    </div>
                                    <div class="input-box" id="invitext"></div>
                                    <div class="input-box" id="invitext"></div>
                                </div>
                                <br>
                                <label>Upload a proof here, (ex.Death certificate).</label>
                                <div class="uploadimage1">
                                    <input type="file" name="deceasedCert" accept=".pdf" id="pdfInput"
                                        onchange="updateLabel(this)" />
                                    <label for="pdfInput">Upload PDF</label>
                                </div>
                                <div class="uploadimage1">
                                    <input type="file" name="deceasedCert1" accept=".pdf" id="pdfInput"
                                        onchange="updateLabel(this)" />
                                    <label for="pdfInput">Upload PDF</label>
                                </div>
                            </div>
                        </div>






                        <input type="hidden" name="dateDeceased" id="dateDeceased" value="">

                        <div class="column">
                            <button class="previousbutton5" id="previousbutton5">Previous</button>
                            <input type="hidden" value="<?php echo $id; ?>" name="id">
                            <input type="hidden" name="user_name" value="<?php echo $_SESSION['user_name']; ?>">
                            <button class="submitbutton" type="submit" name="edit" value="Submit">Update</button>
                        </div>
                    </div>

                    <!-- END OF PAGE 6!! -->

                </form>
            </section>

        </div>
    </section>






















    <script>
     const birthDateInput = document.getElementById("birthDateInput");
    const birthDateValue = "<?php echo $row["birthDate"]; ?>";
    function formatDateYMD(date) {
        const d = new Date(date);
        const year = d.getFullYear();
        const month = (d.getMonth() + 1).toString().padStart(2, "0");
        const day = d.getDate().toString().padStart(2, "0");
        return `${year}-${month}-${day}`;
    }
    function formatDateMDY(date) {
        const d = new Date(date);
        const month = (d.getMonth() + 1).toString().padStart(2, "0");
        const day = d.getDate().toString().padStart(2, "0");
        const year = d.getFullYear();
        return `${month}/${day}/${year}`;
    }
    function formatDateMDDY(date) {
        const d = new Date(date);
        const month = (d.getMonth() + 1).toString().padStart(2, "0");
        const day = d.getDate().toString().padStart(2, "0");
        const year = d.getFullYear();
        return `${month}-${day}-${year}`;
    }
    
    document.querySelector('form').addEventListener('submit', function() {
        const formattedDate = formatDateYMD(birthDateInput.value);
        birthDateInput.value = formattedDate;
    });
    
    birthDateInput.value = formatDateYMD(birthDateValue);
    birthDateInput.addEventListener("input", function () {
        birthDateInput.value = formatDateYMD(birthDateValue);
        if (this.value) {
            birthDateInput.value = this.value;
        }
    });

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
        if (sidebar.classList.contains("active")) {
            sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else
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

    var personStatusSelect = document.getElementById("personStatus");
    var elementsToHide = document.getElementsByClassName("hideifdeceased");

    deceasedbutton.addEventListener('click', function(event) {
        event.preventDefault();
        deceasedbutton.classList.add('hide-button');
        hiddenDivDec.classList.remove('hiddendec');
        personStatusSelect.value = 'Deceased';
    });


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
            dateDeceasedInput.value = new Date().toISOString().split('T')[0];
        } else {
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
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
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


    document.addEventListener('keydown', function(event) {
        if (event.key === 'ArrowLeft') {
            if (!hidepage2.classList.contains('hide-page')) {
                previousbutton.click();
            } else if (!hidepage3.classList.contains('hide-page')) {
                previousbutton2.click();
            } else if (!hidepage4.classList.contains('hide-page')) {
                previousbutton3.click();
            } else if (!hidepage5.classList.contains('hide-page')) {
                previousbutton4.click();
            } else if (!hidepage6.classList.contains('hide-page')) {
                previousbutton5.click();
            }
        } else if (event.key === 'ArrowRight') {
            if (!hidepage.classList.contains('hide-page')) {
                nextbutton.click();
            } else if (!hidepage2.classList.contains('hide-page')) {
                nextbutton2.click();
            } else if (!hidepage3.classList.contains('hide-page')) {
                nextbutton3.click();
            } else if (!hidepage4.classList.contains('hide-page')) {
                nextbutton4.click();
            } else if (!hidepage5.classList.contains('hide-page')) {
                nextbutton5.click();
            }
        }
    });


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

        const inputEmail = document.getElementById('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (inputLastName.value.trim() === '') {
            alert('Please enter your last name');
        } else if (inputEmail.value.trim() !== '' && !emailRegex.test(inputEmail.value.trim())) {
            alert('Please enter a valid email address');
            return;
        } else if (inputFirstName.value.trim() === '') {
            alert('Please enter your first name');
        } else if (inputProvince.value.trim() === '') {
            alert('Please enter your province');
        } else if (inputCity.value.trim() === '') {
            alert('Please enter your city/municipality');
        } else if (barangaySelect.value.trim() === 'Select Barangay') {
            alert('Please enter your barangay');
        } else if (inputBirthDate.value.trim() === '') {
            alert('Please enter your date of birth');
        } else {
            // Calculate age
            const birthDate = new Date(inputBirthDate.value);
            const currentDate = new Date();
            const age = currentDate.getFullYear() - birthDate.getFullYear();

            if (age < 60) {
                alert('You must be 60 years old or above to proceed.');
            } else {
                hidepage.classList.add('hide-page');
                hidepage2.classList.remove('page2');
                hidepage2.classList.remove('hide-page');
            }
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

    const inputElement = document.getElementById('contactNumberInput');

    inputElement.addEventListener('input', function() {
        if (this.value.length > 12) {
            this.value = this.value.slice(0, 12);
        }
    });

    const imageInput = document.getElementById("imageInput");
    const label = document.querySelector(".uploadimage label");

    imageInput.addEventListener("change", function() {
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
  } else {
    echo "<h3>No such person found</h3>";
  }
  ?>
</body>

</html>
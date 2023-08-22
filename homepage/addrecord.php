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
  $roleQuery = "SELECT role FROM register WHERE email='{$email}'";
  $roleResult = mysqli_query($conx, $roleQuery);
  $roleRow = mysqli_fetch_assoc($roleResult);
  $role = $roleRow['role'];

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
  ?>

  <!DOCTYPE html>
  <html lang="en" dir="ltr">

  <head>
      <meta charset="UTF-8" />
      <title>Senior Solutions | Add Record</title>


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
          transition: all 0.2s ease;
          background: linear-gradient(90deg, rgb(0, 0, 255) 0%, rgb(28, 219, 66) 100%);
          border-radius: 4px;
      }

      .submitbutton:hover {
          background: #1CDB42;
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
      .page6 {
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
              <?php if ($role !== 'User') { ?>
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
              <?php } ?>
              <li>
                  <a href="addrecord.php" class="active">
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

                  <header style="font-size: 35px">Senior Citizen Data Form</header>

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
                                  <input type="text" class="gray-input" placeholder="Enter RBI ID" name="rbiid" />
                              </div>
                              <div class="input-box" style="margin-top: 100px;">
                                  <b>Reference Code</b>
                                  <input type="number" class="gray-input" placeholder="Reference Code"
                                      name="referenceCode" id="referenceCode" />
                              </div>
                              <div class="input-box" style="margin-top: 100px; visibility:hidden">
                                  <label>Person Status</label>
                                  <div class="select-box">
                                      <select name="personStatus" id="personStatus" disabled>
                                          <option disabled selected>Active</option>
                                          <option>Deceased</option>
                                      </select>
                                  </div>
                              </div>

                              <div class="uploadimage">
                                  <input type="file" name="imageup" accept="image/*" id="imageInput" />Upload Image Here
                                  <label for="imageInput"></label>
                              </div>

                          </div>


                          <b>1. Name of Senior Citizen</b>
                          <div class="column">
                              <div class="input-box">
                                  <label><span class="red-asterisk">*</span> Last Name</label>
                                  <input type="text" class="gray-input" placeholder="Enter last name" name="lastName"
                                      maxlength="20" oninput="this.value = this.value.toUpperCase();" />
                              </div>
                              <div class="input-box">
                                  <label><span class="red-asterisk">*</span> First Name</label>
                                  <input type="text" class="gray-input" placeholder="Enter first name" maxlength="20"
                                      name="firstName" oninput="this.value = this.value.toUpperCase();" />
                              </div>
                              <div class="input-box">
                                  <label>Middle Name</label>
                                  <input type="text" class="gray-input" placeholder="Enter middle name" maxlength="20"
                                      name="middleName" oninput="this.value = this.value.toUpperCase();" />
                              </div>
                              <div class="input-box">
                                  <label>Extension (JR,SR)</label>
                                  <div class="select-box">
                                      <select name="extensionName" id="jrsr">
                                          <option hidden>Enter JR, SR</option>
                                          <option>JR.</option>
                                          <option>SR.</option>
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
                                      id="regionInput" readonly />
                              </div>
                              <div class="input-box">
                                  <label><span class="red-asterisk">*</span> Province</label>
                                  <input type="text" class="gray-input" placeholder="Enter province" name="province"
                                      id="provinceInput" readonly />
                              </div>
                              <div class="input-box">
                                  <label><span class="red-asterisk">*</span> City / Municipality</label>
                                  <input type="text" class="gray-input" placeholder="Enter city/municipality"
                                      name="city" id="cityInput" readonly />
                              </div>

                              <div class="input-box">
                                  <label><span class="red-asterisk">*</span> Barangay</label>
                                  <div class="select-box">
                                      <select name="barangay" id="barangaySelect">
                                          <option hidden>Select Barangay</option>
                                          <option>Aldiano Olaes</option>
                                          <option>Poblacion 1</option>
                                          <option>Poblacion 2</option>
                                          <option>Poblacion 3</option>
                                          <option>Poblacion 4</option>
                                          <option>Poblacion 5 - FVR</option>
                                          <option>Poblacion 5 - Proper</option>
                                          <option>Benjamin Tirona</option>
                                          <option>Bernardo Pulido</option>
                                          <option>Epifanio Malia</option>
                                          <option>Francisco De Castro</option>
                                          <option>Francisco De Castro - Sunshine</option>
                                          <option>Francisco De Castro - Mandarin</option>
                                          <option>Francisco De Castro - Kanebo</option>
                                          <option>Francisco De Castro - Monteverde</option>
                                          <option>Francisco De Castro - Rolling Hills</option>
                                          <option>Francisco Reyes</option>
                                          <option>Fiorello Calimag</option>
                                          <option>Gavino Maderan</option>
                                          <option>Gregoria De Jesus</option>
                                          <option>Inocencio Salud</option>
                                          <option>Jacinto Lumbreras</option>
                                          <option>Kapitan Kua</option>
                                          <option>Koronel Jose P. Elises</option>
                                          <option>Macario Dacon</option>
                                          <option>Marcelino Memije</option>
                                          <option>Nicolasa Virata</option>
                                          <option>Pantaleon Granados</option>
                                          <option>Ramon Cruz Sr.</option>
                                          <option>San Gabriel</option>
                                          <option>San Jose</option>
                                          <option>Severino De Las Alas</option>
                                          <option>Tiniente Tiago</option>
                                      </select>
                                  </div>
                              </div>


                          </div>
                          <div class="column">
                              <div class="input-box">
                                  <label>House No./Zone/Purok/Sitio</label>
                                  <input type="text" class="gray-input" placeholder="Enter house no." name="houseno"
                                      oninput="this.value = this.value.toUpperCase();" />
                              </div>
                              <div class="input-box">
                                  <label>Street</label>
                                  <input type="text" class="gray-input" placeholder="Enter Street" name="street"
                                      oninput="this.value = this.value.toUpperCase();" />
                              </div>
                          </div>

                          <div class="column">
                              <div class="input-box">
                                  <b><span class="red-asterisk">*</span> 3. Date of Birth</b>
                                  <input type="date" class="gray-input" placeholder="Enter birth date" name="birthDate"
                                      onchange="calculateAge()" />
                                  <span id="currentAge"></span>
                              </div>
                              <div class="input-box">
                                  <b>4. Place of Birth</b>
                                  <input type="text" class="gray-input" placeholder="Enter place of birth"
                                      name="birthPlace" maxlength="20" />
                              </div>
                              <div class="input-box">
                                  <b>5. Marital Status</b>
                                  <div class="select-box">
                                      <select name="maritalStatus">
                                          <option hidden>Enter Marital Status</option>
                                          <option>Married</option>
                                          <option>Divorced</option>
                                          <option>Seperated</option>
                                          <option>Widowed</option>
                                          <option>Never Married</option>
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
                                          <option>Male</option>
                                          <option>Female</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="input-box">
                                  <b>7. Contact Number</b>
                                  <input type="number" class="gray-input" placeholder="+63" name="contactNumber"
                                      id="contactNumberInput" />
                              </div>
                              <div class="input-box">
                                  <b>8. Email Address</b>
                                  <input type="email" class="gray-input" placeholder="example@gmail.com" name="email"
                                      id="email" maxlength="28" />
                              </div>
                          </div>

                          <div class="column">
                              <div class="input-box">
                                  <b>9. Religion</b>
                                  <input type="text" class="gray-input" placeholder="Enter religion" name="religion" />
                              </div>
                              <div class="input-box">
                                  <b>10. Ethnic Origin</b>
                                  <input type="text" class="gray-input" placeholder="Enter ethnic origin"
                                      name="ethnic" />
                              </div>
                              <div class="input-box">
                                  <b>11. Language Spoken / Written</b>
                                  <input type="text" class="gray-input" placeholder="Enter language spoken"
                                      name="language" />
                              </div>
                          </div>

                          <div class="column">

                              <div class="input-box">
                                  <b>12. OSCA ID</b>
                                  <input type="text" class="gray-input" placeholder="Enter Osca ID" name="oscaID"
                                      oninput="restrictToNumbers(this)" />
                              </div>
                              <div class="input-box">
                                  <b>13. GSIS / SSS</b>
                                  <input type="text" class="gray-input" placeholder="0000000000" maxlength="10"
                                      name="sss" oninput="restrictToNumbers(this)" />
                              </div>
                              <div class="input-box">
                                  <b>14. TIN ID</b>
                                  <div class="tin-input">
                                      <input type="text" class="gray-input" placeholder="000-000-000-000" name="tin"
                                          oninput="maskTIN(this)" />
                                  </div>

                              </div>
                          </div>

                          <div class="column">
                              <div class="input-box">
                                  <b>15. Philhealth</b>
                                  <input type="text" class="gray-input" placeholder="00-000000000-0" name="philhealth"
                                      oninput="restrictToNumbersWithHyphen(this)" />
                              </div>

                              <div class="input-box">
                                  <b>16. SC Association / Org ID No</b>
                                  <input type="text" class="gray-input" placeholder="Enter Org ID" name="orgID" />
                              </div>
                              <div class="input-box">
                                  <b>17. Other Gov't. ID</b>
                                  <input type="text" class="gray-input" placeholder="Other Gov't ID" name="govID" />
                              </div>
                          </div>


                          <div class="gender-box">
                              <b>18. Capability to Travel</b>
                              <div class="gender-option">
                                  <div class="gender">
                                      <input type="radio" id="check-male" name="travel" value="Yes" />
                                      <label for="check-male">Yes</label>
                                  </div>
                                  <div class="gender">
                                      <input type="radio" id="check-female" name="travel" value="No" />
                                      <label for="check-female">No</label>
                                  </div>
                              </div>
                              <div class="column">
                                  <div class="input-box">
                                      <b>19. Service / Business / Employment / Specify</b>
                                      <input type="text" class="gray-input" placeholder="Enter Employment"
                                          name="serviceEmp" maxlength="50" />
                                  </div>
                                  <div class="input-box">
                                      <b>20. Current Pension / Specify</b>
                                      <input type="text" class="gray-input" placeholder="Enter current pension"
                                          name="pension" />
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

                          <h1 style="background-color: lightblue; color: blackl; font-size: 25px">II. Family Composition
                          </h1>
                          <br>
                          <b>21. Name of Spouse</b>
                          <div class="column">
                              <div class="input-box">
                                  <label>Last Name</label>

                                  <input type="text" class="gray-input" placeholder="Enter last name"
                                      name="spouseLastName" maxlength="20" />
                              </div>
                              <div class="input-box">
                                  <label>First Name</label>
                                  <input type="text" class="gray-input" placeholder="Enter first name"
                                      name="spouseFirstName" maxlength="20" />
                              </div>
                              <div class="input-box">
                                  <label>Middle Name</label>
                                  <input type="text" class="gray-input" placeholder="Enter middle name"
                                      name="spouseMiddleName" maxlength="20" />
                              </div>
                              <div class="input-box">
                                  <label>Extension (Jr, Sr)</label>
                                  <div class="select-box">
                                      <select name="spouseExtensionName">
                                          <option hidden>Enter Jr, Sr</option>
                                          <option>Jr.</option>
                                          <option>Sr.</option>
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
                                      name="fatherLastName" maxlength="20" />
                              </div>
                              <div class="input-box">
                                  <label>First Name</label>
                                  <input type="text" class="gray-input" placeholder="Enter first name"
                                      name="fatherFirstName" maxlength="20" />
                              </div>
                              <div class="input-box">
                                  <label>Middle Name</label>
                                  <input type="text" class="gray-input" placeholder="Enter middle name"
                                      name="fatherMiddleName" maxlength="20" />
                              </div>
                              <div class="input-box">
                                  <label>Extension (Jr, Sr)</label>
                                  <div class="select-box">
                                      <select name="fatherExtensionName">
                                          <option hidden>Enter Jr, Sr</option>
                                          <option>Jr.</option>
                                          <option>Sr.</option>
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
                                      name="motherLastName" maxlength="20" />
                              </div>
                              <div class="input-box">
                                  <label>First Name</label>
                                  <input type="text" class="gray-input" placeholder="Enter first name"
                                      name="motherFirstName" maxlength="20" />
                              </div>
                              <div class="input-box">
                                  <label>Middle Name</label>
                                  <input type="text" class="gray-input" placeholder="Enter middle name"
                                      name="motherMiddleName" maxlength="20" />
                              </div>
                          </div>
                          <br>

                          <b>24. Child(ren)</b>
                          <p style="font-size: 14px">(leave blank if none)</p>
                          <div class="column">
                              <div class="input-box">
                                  <label><b>1. </b>Full Name</label>
                                  <input type="text" class="gray-input" placeholder="Enter last name"
                                      name="child1FullName" maxlength="35" />
                              </div>
                              <div class="input-box">
                                  <label>Occupation</label>
                                  <input type="text" class="gray-input" placeholder="Enter occupation"
                                      name="child1Occupation" maxlength="20" />
                              </div>
                              <div class="input-box">
                                  <label>Income</label>
                                  <input type="number" class="gray-input" placeholder="Enter income" name="child1Income"
                                      maxlength="20" />
                              </div>
                              <div class="input-box">
                                  <label>Age</label>
                                  <input type="number" class="gray-input" placeholder="Enter age" name="child1Age" />
                              </div>
                              <div class="input-box">
                                  <label>Working</label>
                                  <div class="select-box">
                                      <select name="child1Work">
                                          <option hidden>Working / Not Working</option>
                                          <option>Working</option>
                                          <option>Not Working</option>
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
                                          name="child2FullName" maxlength="35" />
                                  </div>
                                  <div class="input-box">
                                      <label>Occupation</label>
                                      <input type="text" class="gray-input" placeholder="Enter occupation"
                                          name="child2Occupation" maxlength="20" />
                                  </div>
                                  <div class="input-box">
                                      <label>Income</label>
                                      <input type="number" class="gray-input" placeholder="Enter income"
                                          name="child2Income" />
                                  </div>
                                  <div class="input-box">
                                      <label>Age</label>
                                      <input type="number" class="gray-input" placeholder="Enter age" name="child2Age"
                                          maxlength="3" />
                                  </div>
                                  <div class="input-box">
                                      <label>Working</label>
                                      <div class="select-box">
                                          <select name="child2Work">
                                              <option hidden>Working / Not Working</option>
                                              <option>Working</option>
                                              <option>Not Working</option>

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
                                          name="child3FullName" maxlength="35" />
                                  </div>
                                  <div class="input-box">
                                      <label>Occupation</label>
                                      <input type="text" class="gray-input" placeholder="Enter occupation"
                                          name="child3Occupation" maxlength="20" />
                                  </div>
                                  <div class="input-box">
                                      <label>Income</label>
                                      <input type="number" class="gray-input" placeholder="Enter income"
                                          name="child3Income" />
                                  </div>
                                  <div class="input-box">
                                      <label>Age</label>
                                      <input type="number" class="gray-input" placeholder="Enter age" name="child3Age"
                                          maxlength="3" />
                                  </div>
                                  <div class="input-box">
                                      <label>Working</label>
                                      <div class="select-box">
                                          <select name="child3Work">
                                              <option hidden>Working / Not Working</option>
                                              <option>Working</option>
                                              <option>Not Working</option>

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
                                          name="child4FullName" maxlength="35" />
                                  </div>
                                  <div class="input-box">
                                      <label>Occupation</label>
                                      <input type="text" class="gray-input" placeholder="Enter occupation"
                                          name="child4Occupation" maxlength="20" />
                                  </div>
                                  <div class="input-box">
                                      <label>Income</label>
                                      <input type="number" class="gray-input" placeholder="Enter income"
                                          name="child4Income" />
                                  </div>
                                  <div class="input-box">
                                      <label>Age</label>
                                      <input type="number" class="gray-input" placeholder="Enter age" name="child4Age"
                                          maxlength="3" />
                                  </div>
                                  <div class="input-box">
                                      <label>Working</label>
                                      <div class="select-box">
                                          <select name="child4Work">
                                              <option hidden>Working / Not Working</option>
                                              <option>Working</option>
                                              <option>Not Working</option>

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
                                          name="child5FullName" maxlength="35" />
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
                                              <option hidden>Working / Not Working</option>
                                              <option>Working</option>
                                              <option>Not Working</option>

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
                                          name="child6FullName" maxlength="35" />
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
                                              <option hidden>Working / Not Working</option>
                                              <option>Working</option>
                                              <option>Not Working</option>

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
                                          name="child7FullName" maxlength="35" />
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
                                              <option hidden>Working / Not Working</option>
                                              <option>Working</option>
                                              <option>Not Working</option>

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
                                          name="child8FullName" maxlength="35" />
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
                                              <option hidden>Working / Not Working</option>
                                              <option>Working</option>
                                              <option>Not Working</option>

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
                                          name="child9FullName" maxlength="35" />
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
                                              <option hidden>Working / Not Working</option>
                                              <option>Working</option>
                                              <option>Not Working</option>

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
                                          name="child10FullName" maxlength="35" />
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
                                              <option hidden>Working / Not Working</option>
                                              <option>Working</option>
                                              <option>Not Working</option>
                                          </select>
                                      </div>
                                  </div>
                              </div>
                          </div>



                          <br>
                          <b>25. Other Dependent</b>
                          <p style="font-size: 14px">(leave blank if none)</p>

                          <div class="column">
                              <div class="column">

                                  <div class="input-box">
                                      <label><b>1. </b>Full Name</label>
                                      <input type="text" class="gray-input" placeholder="Enter last name"
                                          name="dependentFullName" />
                                  </div>
                                  <div class="input-box">
                                      <label>Occupation</label>
                                      <input type="text" class="gray-input" placeholder="Enter occupation"
                                          name="dependentOccupation" />
                                  </div>
                                  <div class="input-box">
                                      <label>Income</label>
                                      <input type="number" class="gray-input" placeholder="Enter income"
                                          name="dependentIncome" />
                                  </div>
                                  <div class="input-box">
                                      <label>Age</label>
                                      <input type="number" class="gray-input" placeholder="Enter age"
                                          name="dependentAge" maxlength="3" />
                                  </div>
                                  <div class="input-box">
                                      <label>Working</label>
                                      <div class="select-box">
                                          <select name="dependentWork">
                                              <option hidden>Working / Not Working</option>
                                              <option>Working</option>
                                              <option>Not Working</option>
                                          </select>
                                      </div>

                                  </div>
                              </div>
                          </div>


                          <button class="dependent2Button" id="dependent2Button">Add Dependent</button>


                          <div class="dependent2">
                              <div class="column">
                                  <div class="input-box">
                                      <label><b>2. </b>Full Name</label>
                                      <input type="text" class="gray-input" placeholder="Enter last name"
                                          name="dependent2FullName" />
                                  </div>
                                  <div class="input-box">
                                      <label>Occupation</label>
                                      <input type="text" class="gray-input" placeholder="Enter occupation"
                                          name="dependent2Occupation" />
                                  </div>
                                  <div class="input-box">
                                      <label>Income</label>
                                      <input type="number" class="gray-input" placeholder="Enter income"
                                          name="dependent2Income" />
                                  </div>
                                  <div class="input-box">
                                      <label>Age</label>
                                      <input type="number" class="gray-input" placeholder="Enter age"
                                          name="dependent2Age" maxlength="3" />
                                  </div>
                                  <div class="input-box">
                                      <label>Working</label>
                                      <div class="select-box">
                                          <select name="dependent2Work">
                                              <option hidden>Working / Not Working</option>
                                              <option>Working</option>
                                              <option>Not Working</option>
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
                                          name="dependent3FullName" />
                                  </div>
                                  <div class="input-box">
                                      <label>Occupation</label>
                                      <input type="text" class="gray-input" placeholder="Enter occupation"
                                          name="dependent3Occupation" />
                                  </div>
                                  <div class="input-box">
                                      <label>Income</label>
                                      <input type="number" class="gray-input" placeholder="Enter income"
                                          name="dependent3Income" />
                                  </div>
                                  <div class="input-box">
                                      <label>Age</label>
                                      <input type="number" class="gray-input" placeholder="Enter age"
                                          name="dependent3Age" maxlength="3" />
                                  </div>
                                  <div class="input-box">
                                      <label>Working</label>
                                      <div class="select-box">
                                          <select name="dependent3Work">
                                              <option hidden>Working / Not Working</option>
                                              <option>Working</option>
                                              <option>Not Working</option>
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
                                      <input type="number" class="gray-input" placeholder="Enter age"
                                          name="dependent4Age" maxlength="3" />
                                  </div>
                                  <div class="input-box">
                                      <label>Working</label>
                                      <div class="select-box">
                                          <select name="dependent4Work">
                                              <option hidden>Working / Not Working</option>
                                              <option>Working</option>
                                              <option>Not Working</option>
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
                                      <input type="number" class="gray-input" placeholder="Enter age"
                                          name="dependent5Age" maxlength="3" />
                                  </div>
                                  <div class="input-box">
                                      <label>Working</label>
                                      <div class="select-box">
                                          <select name="dependent5Work">
                                              <option hidden>Working / Not Working</option>
                                              <option>Working</option>
                                              <option>Not Working</option>
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
                                          <option>Elementary Level</option>
                                          <option>Elementary Graduate</option>
                                          <option>High School Level</option>
                                          <option>High School Graduate</option>
                                          <option>College Level</option>
                                          <option>College Graduate</option>
                                          <option>Post Graduate</option>
                                          <option>Vocational</option>
                                          <option>Not Attended School</option>
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
                                      <input type="checkbox" id="check-27medical" name="specialization[]"
                                          value="Medical" />
                                      <label for="check-27medical">Medical</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-27teaching" name="specialization[]"
                                          value="Teaching" />
                                      <label for="check-27teaching">Teaching</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-27legal" name="specialization[]"
                                          value="Legal Services" />
                                      <label for="check-27legal">Legal Services</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-27dental" name="specialization[]"
                                          value="Dental" />
                                      <label for="check-27dental">Dental</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-27counseling" name="specialization[]"
                                          value="Counseling" />
                                      <label for="check-27counseling">Counseling</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-27farming" name="specialization[]"
                                          value="Farming" />
                                      <label for="check-27farming">Farming</label>
                                  </div>
                              </div>

                              <div class="columncheckbox">
                                  <div class="gender">
                                      <input type="checkbox" id="check-27fishing" name="specialization[]"
                                          value="Fishing" />
                                      <label for="check-27fishing">Fishing</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-27cooking" name="specialization[]"
                                          value="Cooking" />
                                      <label for="check-27cooking">Cooking</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-27arts" name="specialization[]" value="Arts" />
                                      <label for="check-27arts">Arts</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-27engineering" name="specialization[]"
                                          value="Engineering" />
                                      <label for="check-27engineering">Engineering</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-27carpenter" name="specialization[]"
                                          value="Carpenter" />
                                      <label for="check-27carpenter">Carpenter</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-27plumber" name="specialization[]"
                                          value="Plumber" />
                                      <label for="check-27plumber">Plumber</label>
                                  </div>
                              </div>

                              <div class="columncheckbox">
                                  <div class="gender">
                                      <input type="checkbox" id="check-27barber" name="specialization[]"
                                          value="Barber" />
                                      <label for="check-27barber">Barber</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-27mason" name="specialization[]" value="Mason" />
                                      <label for="check-27mason">Mason</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-27sapatero" name="specialization[]"
                                          value="Sapatero" />
                                      <label for="check-27sapatero">Sapatero</label>
                                  </div>

                                  <div class="gender">
                                      <input type="checkbox" id="check-27evangelization" name="specialization[]"
                                          value="Evangelization" />
                                      <label for="check-27evangelization">Evangelization</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-27tailor" name="specialization[]"
                                          value="Tailor" />
                                      <label for="check-27tailor">Tailor</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-27chef" name="specialization[]"
                                          value="Chef / Cook" />
                                      <label for="check-27chef">Chef / Cook</label>
                                  </div>
                              </div>
                              <div class="gender">
                                  <input type="checkbox" id="check-27milwright" name="specialization[]"
                                      value="Milwright" />
                                  <label for="check-27milwright">Milwright</label>
                              </div>


                              <div class="input-box">
                                  <label>Other area of specialization, specify if have</label>
                                  <input type="text" class="gray-input" placeholder="Enter other specialization"
                                      name="specializationOthers" />
                              </div>



                              <br>
                              <div class="gender-box">
                                  <b>28. Share Skill (Community Service)</b>
                                  <div class="gender-option">
                                      <div class="gender">
                                          <div class="input-box">
                                              <label>1</label>
                                              <input type="text" class="gray-input" name="shareSkill" />
                                          </div>
                                      </div>
                                      <div class="gender">
                                          <div class="input-box">
                                              <label>2</label>
                                              <input type="text" class="gray-input" name="shareSkill1" />
                                          </div>
                                      </div>
                                      <div class="gender">
                                          <div class="input-box">
                                              <label>3</label>
                                              <input type="text" class="gray-input" name="shareSkill2" />
                                          </div>
                                      </div>
                                  </div>

                                  <br>
                                  <div class="gender-box">
                                      <b>29. Community Service and Involvement (Check all applicable)</b>

                                      <div class="columncheckbox">
                                          <div class="gender">
                                              <input type="checkbox" id="check-29medical" name="communityService[]"
                                                  value="Medical" />
                                              <label for="check-29medical">Medical</label>
                                          </div>
                                          <div class="gender">
                                              <input type="checkbox" id="check-29resource" name="communityService[]"
                                                  value="Resource Volunteer" />
                                              <label for="check-29resource">Resource Volunteer</label>
                                          </div>
                                          <div class="gender">
                                              <input type="checkbox" id="check-29beautification"
                                                  name="communityService[]" value="Community Beautification" />
                                              <label for="check-29beautification">Community Beautification</label>
                                          </div>
                                          <div class="gender">
                                              <input type="checkbox" id="check-29org" name="communityService[]"
                                                  value="Community / Organization Leader" />
                                              <label for="check-29org">Community / Organization Leader</label>
                                          </div>
                                          <div class="gender">
                                              <input type="checkbox" id="check-29dental" name="communityService[]"
                                                  value="Dental" />
                                              <label for="check-29dental">Dental</label>
                                          </div>
                                          <div class="gender">
                                              <input type="checkbox" id="check-29friendlyvisits"
                                                  name="communityService[]" value="Friendly Visits" />
                                              <label for="check-29friendlyvisits">Friendly Visits</label>
                                          </div>
                                      </div>

                                      <div class="columncheckbox">
                                          <div class="gender">
                                              <input type="checkbox" id="check-29neighborhood" name="communityService[]"
                                                  value="Neighborhood Support Services" />
                                              <label for="check-29neighborhood">Neighborhood Support Services</label>
                                          </div>
                                          <div class="gender">
                                              <input type="checkbox" id="check-29legalservices"
                                                  name="communityService[]" value="Legal Services" />
                                              <label for="check-29legalservices">Legal Services</label>
                                          </div>
                                          <div class="gender">
                                              <input type="checkbox" id="check-29religous" name="communityService[]"
                                                  value="Religious" />
                                              <label for="check-29religous">Religious</label>
                                          </div>
                                          <div class="gender">
                                              <input type="checkbox" id="check-29counseling" name="communityService[]"
                                                  value="Counseling / Referral" />
                                              <label for="check-29counseling">Counseling / Referral</label>
                                          </div>
                                          <div class="gender">
                                              <input type="checkbox" id="check-29sponsorship" name="communityService[]"
                                                  value="Sponsorship" />
                                              <label for="check-29sponsorship">Sponsorship</label>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="input-box">
                                      <label>Other area of involvement, Specify</label>
                                      <input type="text" class="gray-input" placeholder="Enter other involvement"
                                          name="communityServiceOthers" maxlength="20" />
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
                                      <input type="checkbox" id="check-30alone" name="residingwith[]" value="Alone" />
                                      <label for="check-30alone">Alone</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-30grandchild" name="residingwith[]"
                                          value="Grand Child(ren)" />
                                      <label for="check-30grandchild">Grand Child(ren)</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-30commonlaw" name="residingwith[]"
                                          value="Common Law Spouse" />
                                      <label for="check-30commonlaw">Common Law Spouse</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-30spouse" name="residingwith[]" value="Spouse" />
                                      <label for="check-30spouse">Spouse</label>
                                  </div>

                                  <div class="gender">
                                      <input type="checkbox" id="check-30inlaw" name="residingwith[]"
                                          value="In-law(s)" />
                                      <label for="check-30inlaw">In-law(s)</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-30careinstitution" name="residingwith[]"
                                          value="Care Institution" />
                                      <label for="check-30careinstitution">Care Institution</label>
                                  </div>
                              </div>

                              <div class="columncheckbox">
                                  <div class="gender">
                                      <input type="checkbox" id="check-30children" name="residingwith[]"
                                          value="Child(ren)" />
                                      <label for="check-30children">Child(ren)</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-30relative" name="residingwith[]"
                                          value="Relative(s)" />
                                      <label for="check-30relative">Relative(s)</label>
                                  </div>

                                  <div class="gender">
                                      <input type="checkbox" id="check-30friend" name="residingwith[]"
                                          value="Friend(s)" />
                                      <label for="check-30friend">Friend(s)</label>
                                  </div>
                              </div>

                              <div class="input-box">
                                  <label>Others, pls specify</label>
                                  <input type="text" class="gray-input" placeholder="Enter another involvment with"
                                      name="residingWithOthers" maxlength="20" />
                              </div>
                          </div>

                          <br>
                          <div class="gender-box">
                              <b>31. Household Condition</b>
                              <div class="gender">
                                  <input type="checkbox" id="check-31noprivacy" name="houseHold[]" value="No privacy" />
                                  <label for="check-31noprivacy">No privacy</label>
                              </div>
                              <div class="gender">
                                  <input type="checkbox" id="check-31overcrowded" name="houseHold[]"
                                      value="Overcrowded in home" />
                                  <label for="check-31overcrowded">Overcrowded in home</label>
                              </div>
                              <div class="gender">
                                  <input type="checkbox" id="check-31informal" name="houseHold[]"
                                      value="Informal Settler" />
                                  <label for="check-31informal">Informal Settler</label>
                              </div>
                              <div class="gender">
                                  <input type="checkbox" id="check-31nopermanent" name="houseHold[]"
                                      value="No permanent house" />
                                  <label for="check-31nopermanent">No permanent house</label>
                              </div>
                              <div class="gender">
                                  <input type="checkbox" id="check-31highcostofrent" name="houseHold[]"
                                      value="High cost of rent" />
                                  <label for="check-31highcostofrent">High cost of rent</label>
                              </div>
                              <div class="gender">
                                  <input type="checkbox" id="check-31longing" name="houseHold[]"
                                      value="Longing for independent living quiet atmosphere" />
                                  <label for="check-31longing">Longing for independent living quiet atmosphere</label>
                              </div>

                              <div class="input-box">
                                  <label>Others, pls specify</label>
                                  <input type="text" placeholder="Others" name="houseHoldOthers" maxlength="20" />
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

                          <h1 style="background-color: lightblue; color: black; font-size: 25px">V. Economic Profile
                          </h1>
                          <br>
                          <div class="gender-box">
                              <b>32. Source of Income and Assistance (Check all applicable)</b>

                              <div class="columncheckbox">
                                  <div class="gender">
                                      <input type="checkbox" id="check-32ownearnings" name="sourceIncome[]"
                                          value="Own earnings of salary or Wages" />
                                      <label for="check-32ownearnings">Own earnings of salary or Wages</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-32ownpension" name="sourceIncome[]"
                                          value="Own Pension" />
                                      <label for="check-32ownpension">Own Pension</label>
                                  </div>

                                  <div class="gender">
                                      <input type="checkbox" id="check-32stocks" name="sourceIncome[]"
                                          value="Stocks / Dividends" />
                                      <label for="check-32stocks">Stocks / Dividends</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-32dependent" name="sourceIncome[]"
                                          value="Dependent on children / relatives" />
                                      <label for="check-32dependent">Dependent on children / relatives</label>
                                  </div>

                                  <div class="gender">
                                      <input type="checkbox" id="check-32spousesalary" name="sourceIncome[]"
                                          value="Spouse salary" />
                                      <label for="check-32spousesalary">Spouse salary</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-32insurance" name="sourceIncome[]"
                                          value="Insurance" />
                                      <label for="check-32insurance">Insurance</label>
                                  </div>
                              </div>

                              <div class="columncheckbox">
                                  <div class="gender">
                                      <input type="checkbox" id="check-32spousepension" name="sourceIncome[]"
                                          value="Spouse Pension" />
                                      <label for="check-32spousepension">Spouse Pension</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-32rentals" name="sourceIncome[]"
                                          value="Rentals / sharecrops" />
                                      <label for="check-32rentals">Rentals / sharecrops</label>
                                  </div>

                                  <div class="gender">
                                      <input type="checkbox" id="check-32savings" name="sourceIncome[]"
                                          value="Savings" />
                                      <label for="check-32savings">Savings</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-32livestock" name="sourceIncome[]"
                                          value="Livestock / orchard / farm" />
                                      <label for="check-32livestock">Livestock / orchard / farm</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-32fishing" name="sourceIncome[]"
                                          value="Fishing" />
                                      <label for="check-32fishing">Fishing</label>
                                  </div>
                              </div>
                              <div class="input-box">
                                  <label>Others, pls specify</label>
                                  <input type="text" placeholder="Others" name="sourceIncomeOthers" value=""
                                      maxlength="20" />
                              </div>

                          </div>
                          <br>
                          <div class="gender-box">
                              <b>33. Assets: Real and Immovable Properties (Check all applicable)</b>
                              <br>
                              <div class="gender-option">
                                  <div class="gender">
                                      <input type="checkbox" id="check-33house" name="assetsFirst[]" value="House" />
                                      <label for="check-33house">House</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-33lot" name="assetsFirst[]"
                                          value="Lot / Farmland" />
                                      <label for="check-33lot">Lot / Farmland</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-33houselot" name="assetsFirst[]"
                                          value="House & Lot" />
                                      <label for="check-33houselot">House & Lot</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-33commercial" name="assetsFirst[]"
                                          value="Commercial Building" />
                                      <label for="check-33commercial">Commercial Building</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-33fishpond" name="assetsFirst[]"
                                          value="Fishpond / resort" />
                                      <label for="check-33fishpond">Fishpond / resort</label>
                                  </div>
                                  <div class="input-box">
                                      <label>Others, pls specify</label>
                                      <input type="text" placeholder="Others" name="assetsFirstOthers" value=""
                                          maxlength="20" />
                                  </div>
                              </div>

                              <br>
                              <div class="gender-box">
                                  <b>34. Assets: Personal and Movable Properties (Check all applicable)</b>
                                  <div class="columncheckbox">
                                      <div class="gender">
                                          <input type="checkbox" id="check-34automobile" name="assetsSecond[]"
                                              value="Automobile" />
                                          <label for="check-34automobile">Automobile</label>
                                      </div>
                                      <div class="gender">
                                          <input type="checkbox" id="check-34pc" name="assetsSecond[]"
                                              value="Personal Computer" />
                                          <label for="check-34pc">Personal Computer</label>
                                      </div>
                                      <div class="gender">
                                          <input type="checkbox" id="check-34boats" name="assetsSecond[]"
                                              value="Boats" />
                                          <label for="check-34boats">Boats</label>
                                      </div>
                                      <div class="gender">
                                          <input type="checkbox" id="check-34heavyequipment" name="assetsSecond[]"
                                              value="Heavy Equipment" />
                                          <label for="check-34heavyequipment">Heavy Equipment</label>
                                      </div>
                                      <div class="gender">
                                          <input type="checkbox" id="check-34laptops" name="assetsSecond[]"
                                              value="Laptops" />
                                          <label for="check-34laptops">Laptops</label>
                                      </div>
                                      <div class="gender">
                                          <input type="checkbox" id="check-34drones" name="assetsSecond[]"
                                              value="Drones" />
                                          <label for="check-34drones">Drones</label>
                                      </div>
                                  </div>

                                  <div class="columncheckbox">
                                      <div class="gender">
                                          <input type="checkbox" id="check-34motorcycle" name="assetsSecond[]"
                                              value="Motorcycle" />
                                          <label for="check-34motorcycle">Motorcycle</label>
                                      </div>
                                      <div class="gender">
                                          <input type="checkbox" id="check-34mobilephones" name="assetsSecond[]"
                                              value="Mobile Phones" />
                                          <label for="check-34mobilephones">Mobile Phones</label>
                                      </div>
                                  </div>
                                  <div class="input-box">
                                      <label>Others, pls specify</label>
                                      <input type="text" placeholder="Others" name="assetsSecondOthers" value=""
                                          maxlength="20" />
                                  </div>



                                  <br>
                                  <div class="gender-box">
                                      <b>35. Monthly Income (in Philippine Peso)</b>
                                      <div class="gender-option">
                                          <br>
                                          <div class="column">
                                              <div class="gender">
                                                  <input type="radio" id="radio-35sixty" name="monthlyIncome"
                                                      value="60,000 and above" />
                                                  <label for="radio-35sixty">60,000 and above</label>
                                              </div>
                                              <div class="gender">
                                                  <input type="radio" id="radio-35fifty" name="monthlyIncome"
                                                      value="50,000 to 60,000" />
                                                  <label for="radio-35fifty">50,000 to 60,000</label>
                                              </div>
                                              <div class="gender">
                                                  <input type="radio" id="radio-35fourty" name="monthlyIncome"
                                                      value="40,000 to 50,000" />
                                                  <label for="radio-35fourty">40,000 to 50,000</label>
                                              </div>
                                              <div class="gender">
                                                  <input type="radio" id="radio-35thirty" name="monthlyIncome"
                                                      value="30,000 to 40,000" />
                                                  <label for="radio-35thirty">30,000 to 40,000</label>
                                              </div>
                                              <div class="gender">
                                                  <input type="radio" id="radio-35twenty" name="monthlyIncome"
                                                      value="20,000 to 30,000" />
                                                  <label for="radio-35twenty">20,000 to 30,000</label>
                                              </div>
                                              <div class="gender">
                                                  <input type="radio" id="radio-35ten" name="monthlyIncome"
                                                      value="10,000 to 20,000" />
                                                  <label for="radio-35ten">10,000 to 20,000</label>
                                              </div>
                                              <div class="gender">
                                                  <input type="radio" id="radio-35five" name="monthlyIncome"
                                                      value="5,000 to 10,000" />
                                                  <label for="radio-35five">5,000 to 10,000</label>
                                              </div>
                                              <div class="gender">
                                                  <input type="radio" id="radio-35one" name="monthlyIncome"
                                                      value="1,000 to 5,000" />
                                                  <label for="radio-35one">1,000 to 5,000</label>
                                              </div>
                                              <div class="gender">
                                                  <input type="radio" id="radio-35belowone" name="monthlyIncome"
                                                      value="Below 1,000" />
                                                  <label for="radio-35belowone">Below 1,000</label>
                                              </div>
                                          </div>


                                      </div>


                                      <br>
                                      <div class="gender-box">
                                          <b>36. Problems / Needs Commonly Encountered (Check all applicable)</b>

                                          <div class="gender">
                                              <input type="checkbox" id="check-36lackofincome" name="problems[]"
                                                  value="Lack of income / resources" />
                                              <label for="check-36lackofincome">Lack of income / resources</label>
                                          </div>
                                          <div class="gender">
                                              <input type="checkbox" id="check-36lossofincome" name="problems[]"
                                                  value="Loss of income / resources" />
                                              <label for="check-36lossofincome">Loss of income / resources</label>
                                          </div>
                                          <div class="gender">
                                              <input type="checkbox" id="check-36skills" name="problems[]"
                                                  value="Skills / capability training" />
                                              <label for="check-36skills">Skills / capability training</label>
                                          </div>
                                          <div class="gender">
                                              <input type="checkbox" id="check-36livelihood" name="problems[]"
                                                  value="Livelihood opportunities" />
                                              <label for="check-36livelihood">Livelihood opportunities</label>
                                          </div>

                                          <div class="input-box">
                                              <label>Others, pls specify</label>
                                              <input type="text" class="gray-input" placeholder="Others"
                                                  name="problemsOthers" value="" maxlength="20" />
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
                                      <option hidden></option>
                                      <option>A</option>
                                      <option>B</option>
                                      <option>AB</option>
                                      <option>O</option>
                                      <option>Don't Know</option>
                                  </select>
                              </div>
                              <div class="input-box" id="invitext"></div>
                              <div class="input-box" id="invitext"></div>
                          </div>
                          <div class="input-box">
                              <label>Physical Disablity, specify</label>
                              <input type="text" class="gray-input" placeholder="Others" name="physicalDisability"
                                  maxlength="50" />
                          </div>

                          <div class="gender-box">
                              <div class="columncheckbox">
                                  <div class="gender">
                                      <input type="checkbox" id="check-37healthproblems" name="medicalConcern[]"
                                          value="Health problems/ ailments" />
                                      <label for="check-37healthproblems">Health problems/ ailments</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-37hypertension" name="medicalConcern[]"
                                          value="Hypertension" />
                                      <label for="check-37hypertension">Hypertension</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-37arthritis" name="medicalConcern[]"
                                          value="Arthritis / Gout" />
                                      <label for="check-37arthritis">Arthritis / Gout</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-37coronary" name="medicalConcern[]"
                                          value="Coronary Heart Disease" />
                                      <label for="check-37coronary">Coronary Heart Disease</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-37diabetes" name="medicalConcern[]"
                                          value="Diabetes" />
                                      <label for="check-37diabetes">Diabetes</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-37chronic" name="medicalConcern[]"
                                          value="Chronic Kidney Disease" />
                                      <label for="check-37chronic">Chronic Kidney Disease</label>
                                  </div>
                              </div>
                              <div class="columncheckbox">
                                  <div class="gender">
                                      <input type="checkbox" id="check-37alzheimer" name="medicalConcern[]"
                                          value="Alzheimer / Dementia" />
                                      <label for="check-37alzheimer">Alzheimer / Dementia</label>
                                  </div>
                                  <div class="gender">
                                      <input type="checkbox" id="check-37chronicobstructive" name="medicalConcern[]"
                                          value="Pulmonary Disease" />
                                      <label for="check-37chronicobstructive">Chronic Obstructive Pulmonary
                                          Disease</label>
                                  </div>
                              </div>
                              <div class="input-box">
                                  <label>Others, pls specify</label>
                                  <input type="text" class="gray-input" placeholder="Others" name="medicalConcernOthers"
                                      maxlength="20" />
                              </div>


                              <br>

                              <b>38. Dental Concern</b>
                              <div class="gender">
                                  <input type="radio" id="radio-38dentalcare" name="dentalConcern"
                                      value="Needs Dental Care" />
                                  <label for="radio-38dentalcare">Needs Dental Care</label>
                              </div>
                              <div class="input-box">
                                  <label>Others, pls specify</label>
                                  <input type="text" class="gray-input" placeholder="Others" name="dentalConcernOthers"
                                      maxlength="20" />
                              </div>


                              <br>
                              <b>39. Optical</b>

                              <div class="gender">
                                  <input type="checkbox" id="check-39eye" name="optical[]" value="Eye Impairment" />
                                  <label for="check-39eye">Eye Impairment</label>
                              </div>
                              <div class="gender">
                                  <input type="checkbox" id="check-39needseyecare" name="optical[]"
                                      value="Needs eye care" />
                                  <label for="check-39needseyecare">Needs eye care</label>
                              </div>
                              <div class="input-box">
                                  <label>Others, pls specify</label>
                                  <input type="text" class="gray-input" placeholder="Others" name="opticalOthers"
                                      maxlength="20" />
                              </div>



                              <br>
                              <b>40. Hearing</b>

                              <div class="gender">
                                  <input type="radio" id="radio-40aural" name="hearing"
                                      value="Aural impairment / Hearing impairment" />
                                  <label for="radio-40aural">Aural impairment / Hearing impairment</label>
                              </div>
                              <div class="input-box">
                                  <label>Others, pls specify</label>
                                  <input type="text" class="gray-input" placeholder="Others" name="hearingOthers"
                                      maxlength="20" />
                              </div>

                              <br>
                              <b>41. Social / Emotional</b>

                              <div class="gender">
                                  <input type="checkbox" id="check-41neglect" name="socialEmotional[]"
                                      value="Feeling neglect / rejection" />
                                  <label for="check-41neglect">Feeling neglect / rejection</label>
                              </div>

                              <div class="gender">
                                  <input type="checkbox" id="check-41helplessness" name="socialEmotional[]"
                                      value="Feeling helplessness / worthlessness" />
                                  <label for="check-41helplessness">Feeling helplessness / worthlessness</label>
                              </div>

                              <div class="gender">
                                  <input type="checkbox" id="check-41loneliness" name="socialEmotional[]"
                                      value="Feeling loneliness / isolate" />
                                  <label for="check-41loneliness">Feeling loneliness / isolate</label>
                              </div>

                              <div class="gender">
                                  <input type="checkbox" id="check-41leisure" name="socialEmotional[]"
                                      value="Lack leisure / recreational activities" />
                                  <label for="check-41leisure">Lack leisure / recreational activities</label>
                              </div>

                              <div class="gender">
                                  <input type="checkbox" id="check-41lacksc" name="socialEmotional[]"
                                      value="Lack SC friendly environment" />
                                  <label for="check-41lacksc">Lack SC friendly environment</label>
                              </div>

                              <div class="input-box">
                                  <label>Others, pls specify</label>
                                  <input type="text" class="gray-input" placeholder="Others"
                                      name="socialEmotionalOthers" maxlength="20" />
                              </div>

                              <br>
                              <b>42. Area / Difficulty</b>

                              <div class="gender">
                                  <input type="checkbox" id="check-42highcost" name="areaDifficulty[]"
                                      value="High Cost of medicines" />
                                  <label for="check-42highcost">High Cost of medicines</label>
                              </div>
                              <div class="gender">
                                  <input type="checkbox" id="check-42lackofmedicines" name="areaDifficulty[]"
                                      value="Lack of medicines" />
                                  <label for="check-42lackofmedicines">Lack of medicines</label>
                              </div>
                              <div class="gender">
                                  <input type="checkbox" id="check-42lackofmedical" name="areaDifficulty[]"
                                      value="Lack of medical attention" />
                                  <label for="check-42lackofmedical">Lack of medical attention</label>
                              </div>
                              <div class="input-box">
                                  <label>Others, pls specify</label>
                                  <input type="text" class="gray-input" placeholder="Others" name="areaDifficultyOthers"
                                      maxlength="20" />
                              </div>


                              <br>
                              <b>43. List of Medicines for Maintenance</b>
                              <div class="input-box">
                                  <label>Please specify, use comma to seperate items.</label>
                                  <input type="text" class="gray-input"
                                      placeholder="Example : Amlodiphne 10mg, Losartan 50mg, etc." name="medicines" />
                              </div>

                              <br>
                              <b>44. Do you have a scheduled medical / physical check-up</b>

                              <div class="gender">
                                  <input type="radio" id="radio-44yes" name="scheduledMedical" value="Yes" />
                                  <label for="radio-44yes">Yes</label>
                              </div>
                              <div class="gender">
                                  <input type="radio" id="radio-44no" name="scheduledMedical" value="No" />
                                  <label for="radio-44no">No</label>
                              </div>


                              <br>
                              <b>45. If Yes, when is it done?</b>

                              <div class="gender">
                                  <input type="radio" id="radio-45yearly" name="scheduledMedical1" value="Yearly" />
                                  <label for="radio-45yearly">Yearly</label>
                              </div>
                              <div class="gender">
                                  <input type="radio" id="radio-45sixmonths" name="scheduledMedical1"
                                      value="Every 6 months" />
                                  <label for="radio-45sixmonths">Every 6 months</label>
                              </div>
                              <div class="input-box">
                                  <label>Others, pls specify</label>
                                  <input type="text" class="gray-input" placeholder="Others"
                                      name="scheduledMedical1Others" maxlength="14" />
                              </div>
                          </div>
                          <br><br>
                          <div class="gender">
                              <input type="checkbox" id="lastrequired" name="lastrequired" value="This certifies that I have willingly given my personal consent and willfully participated in the provision of data and relevant information regarding my
person, being part of the establishment of database of Senior Citizens." required />
                              <label for="lastrequired">This certifies that I have willingly given my personal consent
                                  and willfully participated in the provision of data and relevant information regarding
                                  my
                                  person, being part of the establishment of database of Senior Citizens.</label>
                          </div>
                          <div class="column">
                              <button class="previousbutton5" id="previousbutton5">Previous</button>
                              <input type="hidden" name="user_name" value="<?php echo $_SESSION['user_name']; ?>">
                              <button class="submitbutton" type="submit" name="create"
                                  value="Add Person">Submit</button>
                          </div>
                      </div>

                      <!-- END OF PAGE 6!! -->
                  </form>
              </section>

          </div>
      </section>




















      <script src="homescript.js"></script>
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

      function calculateAge() {
          var birthdateInput = document.querySelector('input[name="birthDate"]');
          var birthdate = new Date(birthdateInput.value);
          var currentDate = new Date();

          var age = currentDate.getFullYear() - birthdate.getFullYear();

          if (currentDate.getMonth() < birthdate.getMonth() ||
              (currentDate.getMonth() === birthdate.getMonth() && currentDate.getDate() < birthdate.getDate())) {
              age--;
          }

          var currentAgeElement = document.getElementById('currentAge');
          currentAgeElement.textContent = 'Age: ' + age;
      }


      document.getElementById("regionInput").value = "CALABARZON (REGION IV-A)";
      document.getElementById("provinceInput").value = "CAVITE";
      document.getElementById("cityInput").value = "GMA";



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
          const inputBirthDate = document.getElementsByName('birthDate')[0];
          const genderSelect = document.getElementById('genderSelect');
          const inputReferenceCode = document.getElementById('referenceCode').value;

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
          } else if (genderSelect.value.trim() === 'Enter Gender') {
              alert('Please enter your gender');
          } else if (inputBirthDate.value.trim() === '') {
              alert('Please enter your date of birth');
          } else {
              // Calculate age
              var birthdate = new Date(inputBirthDate.value);
              var currentDate = new Date();
              var age = currentDate.getFullYear() - birthdate.getFullYear();

              if (
                  currentDate.getMonth() < birthdate.getMonth() ||
                  (currentDate.getMonth() === birthdate.getMonth() &&
                      currentDate.getDate() < birthdate.getDate())
              ) {
                  age--;
              }
              if (age < 60) {
                  alert('You must be at least 60 years old to proceed.');
              } else {
                  if (inputReferenceCode.trim() !== '') {
                      const xhr = new XMLHttpRequest();
                      xhr.open('POST', 'checkRRN.php', true);
                      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                      xhr.onreadystatechange = function() {
                          if (xhr.readyState === XMLHttpRequest.DONE) {
                              if (xhr.status === 200) {
                                  const response = JSON.parse(xhr.responseText);
                                  if (response.exists) {
                                      alert('This reference code is already registered!');
                                  } else {
                                      hidepage.classList.add('hide-page');
                                      hidepage2.classList.remove('page2');
                                      hidepage2.classList.remove('hide-page');
                                  }
                              } else {
                                  alert('An error occurred while checking the reference code.');
                              }
                          }
                      };

                      const data = 'referenceCode=' + encodeURIComponent(inputReferenceCode);
                      xhr.send(data);
                  } else {
                      hidepage.classList.add('hide-page');
                      hidepage2.classList.remove('page2');
                      hidepage2.classList.remove('hide-page');
                  }
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

      imageInput.addEventListener("change", function() {
          const file = this.files[0];
          if (file) {
              label.style.backgroundImage = `url('${URL.createObjectURL(file)}')`;
              label.setAttribute("data-filename", file.name);
          } else {
              1
              label.style.backgroundImage = "";
              label.setAttribute("data-filename", "");
          }
      });
      const inputElement = document.getElementById('contactNumberInput');

      inputElement.addEventListener('input', function() {
          if (this.value.length > 12) {
              this.value = this.value.slice(0, 12);
          }
      });

      const radioContainer = document.getElementById("radio-container");
      const radios = radioContainer.querySelectorAll('input[type="radio"]');

      radioContainer.addEventListener("click", (event) => {
          const clickedRadio = event.target;

          if (clickedRadio.tagName === "INPUT" && clickedRadio.type === "radio") {
              const isAlreadySelected = clickedRadio.checked;
              if (isAlreadySelected) {
                  clickedRadio.checked = false;
              }
          }
      });
      </script>
  </body>

  </html>
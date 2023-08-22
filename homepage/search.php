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
if ($autoOut == 'Yes' || $forStatus1 == 'Disabled') {
  include("logoutupdate.php");
  exit();
}
if ($_SESSION['role'] === 'User') {
  $error_msg = 'You are in "User" only role, contact your supervisor for assistance';
}else {
  $sql = "SELECT * FROM register";
  $result = $conx->query($sql);

}

if (isset($_GET['searchQuery']) && !empty($_GET['searchQuery'])) {
    $searchQuery = $_GET['searchQuery'];
    $sqlCount = "SELECT COUNT(*) as total FROM people WHERE firstName LIKE '%$searchQuery%' OR lastName LIKE '%$searchQuery%' OR RBIID LIKE '%$searchQuery%' OR middleName LIKE '%$searchQuery%' OR medicalConcern LIKE '%$searchQuery%' OR barangay LIKE '%$searchQuery%'";
  $sqlSelect = "SELECT * FROM people WHERE firstName LIKE '%$searchQuery%' OR lastName LIKE '%$searchQuery%' OR RBIID LIKE '%$searchQuery%' OR middleName LIKE '%$searchQuery%' OR medicalConcern LIKE '%$searchQuery%' OR barangay LIKE '%$searchQuery%' ORDER BY updated_date";
} else {
    $searchQuery = '';
    $sqlCount = "SELECT COUNT(*) as total FROM people";
}

$countResult = mysqli_query($conx, $sqlCount);
$row = mysqli_fetch_assoc($countResult);
$totalRecords = $row['total'];

$result = mysqli_query($conx, $sqlSelect);

if (mysqli_num_rows($result) == 0) {
    $noPersonFound = true;
} else {
    $noPersonFound = false;
}
?>

    <!DOCTYPE html>
    <html lang="en" dir="ltr">

    <head>
    <meta charset="UTF-8" />
    <title>NCSC | Search</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../img/sslogo.png">
    <style>
        .home-content {
        padding: 20px;
        
        }

        .table-container {
        overflow-x: auto;
        }

        .table {
        width: 100%;
        border-collapse: collapse;
        }

        .table th,
        .table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        }

        .table th {
        background-color: #f2f2f2;
        }

        .home-content {
        padding: 20px;
        }

        .table-container {
        overflow-x: auto;
        }

        .table {
        width: 100%;
        border-collapse: collapse;
        }

        .table th,
        .table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        }

        .table th {
        background-color: #f2f2f2;
        }

        .btn-container {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        }

        .btn {
        display: inline-block;
        padding: 10px 15px;
        border-radius: 4px;
        font-size: 14px;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
        }

        .btn-info {
        background-color: #3E39DE ;
        color: white;
        }

        .btn-warning {
        background-color: #ffa500;
        color: white;
        }

        .btn-danger {
        background-color: #dc143c;
        color: white;
        }

    

        @media screen and (max-width: 768px) {
        .table th,
        .table td {
            padding: 8px 10px;
        }

        .btn-container {
            flex-direction: column;
            gap: 8px;
        }

        .btn {
            width: 100%;
        }
        }

        .alert {
    padding: 10px;
    border-radius: 4px;
    font-size: 16px;
    margin-bottom: 20px;
                }

    .create-alert {
    background-color: #28a745;
    color: #fff;
    }

    .update-alert {
    background-color: #ffc107;
    color: #000;
    }

    .delete-alert {
    background-color: #dc3545;
    color: #fff;
    }

    button.show-modal,
    .modal-box {
    
    top: 50%;
    left: 50%;

    }
    .close-btn{
    font-size: 18px;
    font-weight: 400;
    color: #fff;
    padding: 14px 22px;
    border: none;
    background: #4070f4;
    border-radius: 6px;
    cursor: pointer;
    }

    .delete-btn{
    font-size: 18px;
    font-weight: 400;
    color: #fff;
    padding: 14px 22px;
    border: none;
    background: red;
    border-radius: 6px;
    cursor: pointer;
    }
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        }

        .modal-box {
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .modal-box h2 {
        margin-top: 0;
        }

        .modal-box .buttons {
        margin-top: 20px;
        display: flex;
        justify-content: flex-end;
        }

        .modal-box button {
        padding: 10px 20px;
        border-radius: 4px;
        margin-left: 10px;
        cursor: pointer;
        }

        .modal-box button.close-btn {
        background-color: #ccc;
        color: #333;
        }

        .modal-box button.close-btn:hover {
        background-color: #999;
        }

        .modal-box button.delete-btn {
        background-color: #dc143c;
        color: #fff;
        }

        .modal-box button.delete-btn:hover {
        background-color: #b20c2b;
        }
        .no-person-found {
            padding: 20px;
            background-color: #f8f8f8;
            color: #555;
            text-align: center;
            font-size: 18px;
        }


        .person-status {
    position: relative;
    margin-top: 10px;
    font-weight: bold;
    padding: 5px;
    display: flex; 
    align-items: center; 
    border-radius: 20px;
    width: 110px;
}

.status-icon {
    height: 16px;
    width: auto;
    margin-right: 5px; 
}


.my-active-class {
    background-color: green;
    color: white;
    cursor: default;
}

.my-deceased-class {
    background-color: red;
    color: white;
    cursor: default;
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
        <span class="dashboard" style="color:#555">Searching for: <strong> <?php echo isset($_GET['searchQuery']) ? $_GET['searchQuery'] : ''; ?> </strong></span>

      </div>
        <form action="search.php" method="GET" class="search-box">
  <input type="text" placeholder="Search..." name="searchQuery" id="searchInput" required/>
  <button type="submit" class="bx bx-search"></button>
</form>


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
            <?php if ($noPersonFound): ?>
                <div class="no-person-found">
                    No person found.
                </div>
            <?php else: ?>
                <div class="table-container">
    <table class="table">
      <thead>
        <tr>
          <th>RBI ID</th>
          <th>Last Name</th>
          <th>First Name</th>
          <th>Middle Name</th>
          <th>Barangay</th>
          <th>Date Recorded</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php while ($data = mysqli_fetch_array($result)): ?>
    <tr>
        <td><?php echo $data['RBIID']; ?></td>
        <td><?php echo $data['lastName']; ?></td>
        <td><?php echo $data['firstName'] . ' ' . $data['extensionName']; ?></td>
        <td><?php echo $data['middleName']; ?></td>
        <td><?php echo $data['barangay']; ?></td>
        <td>
                <?php 
                $updated_date = $data['updated_date'];
                echo ($updated_date !== '0000-00-00 00:00:00') ? date('m-d-y g:ia', strtotime($updated_date)) : '';
                ?>
            </td>
        <td class="person-status <?php echo strtolower($data['personStatus']) === 'active' ? 'my-active-class' : (strtolower($data['personStatus']) === 'deceased' ? 'my-deceased-class' : ''); ?>">
    <?php if (strtolower($data['personStatus']) === 'active'): ?>
        <img src="images/check.png" alt="Checkmark" class="status-icon">
    <?php elseif (strtolower($data['personStatus']) === 'deceased'): ?>
      
    <?php endif; ?>
    <?php echo $data['personStatus']; ?>
</td>

        <td>
            <a href="view.php?id=<?php echo $data['id']; ?>"class="btn btn-info">View</a>
            <a href="edit.php?id=<?php echo $data['id']; ?>" class="btn btn-warning">Edit</a>
            <!-- <a class="show-modal btn btn-danger" data-id="<?php echo $data['id']; ?> &page=<?php echo $currentpage; ?>">Disable</a> -->
                                        <span class="overlay"></span>
                                        <div class="modal-overlay" id="modal-<?php echo $data['id']; ?>">
                                            <div class="modal-box">
                                                <img src="images/warningicon.png" alt="">
                                                <h2>WARNING!</h2>
                                                <h3>Record: <?php echo $data['firstName']; ?> </h3>
                                                <br>
                                                <h3>Will be deleted and it will not be retrieve!</h3>
                                                <div class="buttons">
                                                    <button class="close-btn">Close</button>
                                                    <a href="delete.php?id=<?php echo $data['id']; ?>">
                                                        <button class="delete-btn">Delete</button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <script>
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".sidebarBtn");
    sidebarBtn.onclick = function() {
    sidebar.classList.toggle("active");
    if (sidebar.classList.contains("active")) {
        sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
    } else {
        sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
    }
    };

    const showModalButtons = document.querySelectorAll(".show-modal");
    const modalOverlays = document.querySelectorAll(".modal-overlay");
    const closeModalButtons = document.querySelectorAll(".close-btn");

    showModalButtons.forEach((button, index) => {
    button.addEventListener("click", () => {
        modalOverlays[index].style.display = "flex";
    });
    });

    closeModalButtons.forEach((button, index) => {
    button.addEventListener("click", () => {
        modalOverlays[index].style.display = "none";
    });
    });


    function attachEventListeners() {
    showModalButtons = document.querySelectorAll(".show-modal");
    modalOverlays = document.querySelectorAll(".modal-overlay");
    closeModalButtons = document.querySelectorAll(".close-btn");

    showModalButtons.forEach((button, index) => {
        button.addEventListener("click", () => {
        modalOverlays[index].style.display = "flex";
        });
    });

    closeModalButtons.forEach((button, index) => {
        button.addEventListener("click", () => {
        modalOverlays[index].style.display = "none";
        });
    });
    }


    function performSearch() {

    const searchInput = document.getElementById("searchInput");
    const searchQuery = searchInput.value.trim();

   
    attachEventListeners();
    }
    const searchButton = document.getElementById("searchButton");
    searchButton.addEventListener("click", performSearch);


    
    </script>
    </body>

    </html>
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

if ($_SESSION['role'] === 'User') {
  $error_msg = 'You are in "User" only role, contact your supervisor for assistance';
} else {
  $sql = "SELECT * FROM register";
  $result = $conx->query($sql);

}
$recordsPerPage = 10;
$currentpage = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($currentpage - 1) * $recordsPerPage;

if (isset($_GET['searchQuery']) && !empty($_GET['searchQuery'])) {
  $searchQuery = $_GET['searchQuery'];
  $sqlCount = "SELECT COUNT(*) as total FROM people WHERE firstName LIKE '%$searchQuery%' OR lastName LIKE '%$searchQuery%' OR RBIID LIKE '%$searchQuery%' OR middleName LIKE '%$searchQuery%' OR medicalConcern LIKE '%$searchQuery%' OR barangay LIKE '%$searchQuery%'";
  $sqlSelect = "SELECT * FROM people WHERE firstName LIKE '%$searchQuery%' OR lastName LIKE '%$searchQuery%' OR RBIID LIKE '%$searchQuery%' OR middleName LIKE '%$searchQuery%' OR medicalConcern LIKE '%$searchQuery%' OR barangay LIKE '%$searchQuery%' ORDER BY updated_date DESC LIMIT $offset, $recordsPerPage";
} else {
  $searchQuery = '';
  $sqlCount = "SELECT COUNT(*) as total FROM people";
  $sqlSelect = "SELECT * FROM people ORDER BY updated_date DESC LIMIT $offset, $recordsPerPage";
}

$countResult = mysqli_query($conx, $sqlCount);
$row = mysqli_fetch_assoc($countResult);
$totalRecords = $row['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);


$maxPagesToShow = 5;
$startPage = max(1, $currentpage - floor($maxPagesToShow / 2));
$endPage = min($totalPages, $startPage + $maxPagesToShow - 1);
$startPage = max(1, $endPage - $maxPagesToShow + 1);

$result = mysqli_query($conx, $sqlSelect);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <title>Senior Solutions | Record Lists</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />

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


    .table-container {
        overflow-x: auto;
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
        background-color: #3E39DE;
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




    .close-btn {
        font-size: 18px;
        font-weight: 400;
        color: #fff;
        padding: 14px 22px;
        border: none;
        background: #4070f4;
        border-radius: 6px;
        cursor: pointer;
    }

    .delete-btn {
        font-size: 18px;
        font-weight: 400;
        color: #fff;
        padding: 14px 22px;
        border: none;
        background: red;
        border-radius: 6px;
        cursor: pointer;
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

    .pagination {
        margin-top: 20px;
        text-align: center;
    }

    .pagination a,
    .pagination span {
        display: inline-block;
        padding: 8px 12px;
        margin: 0 5px;
        border: 1px solid #ccc;
        border-radius: 3px;
        text-decoration: none;
        color: #333;
    }

    .pagination .current-page {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    .pagination a:hover {
        background-color: #d6d6d6;
    }

    .pagination a:first-child,
    .pagination a:last-child {
        margin: 0;
    }

    .pagination .dots {
        pointer-events: none;
    }

    .barangay-dropdown {
        margin-top: 10px;
    }

    #barangaySelect {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
        font-size: 16px;
        color: #333;
        cursor: pointer;
    }

    #barangaySelect option {
        font-size: 16px;
        color: #333;
    }



    .exportbutton {
        background-color: #1b8a0c;
        color: #f1f1f1;
        width: 200px;
        height: 60px;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 4px;
        margin-right: 10px;
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        cursor: pointer;
    }

    .exportbutton .exporticon {
        width: 16px;
        height: 16px;
        margin-right: 8px;
        vertical-align: middle;
    }

    .exportbutton:hover {
        background-color: #17680c;
    }

    .exportbutton:focus {
        outline: none;
    }

    .exportbutton:active {
        background-color: #0e4607;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 10000;
    }

    .modal-content {
        background-color: #fff;
        width: 80%;
        /* Change the width to auto */
        max-width: 100%;
        /* Set a maximum width to avoid overly wide content */
        padding: 20px;
        border-radius: 4px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .item-list {
        list-style: none;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        padding: 15px;
    }

    .modal-item {
        padding: 12px;
        background-color: #f2f2f2;
        /* Initial background color */
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .modal-item:hover {
        background-color: #ddd;
        /* Change to the desired gray color */
    }

    .close-button {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 30px;
        color: #333;
        /* Change the color of the X symbol */
        background-color: transparent;
        border: none;
        cursor: pointer;
        transition: color 0.3s ease;
        /* Add transition for color change */
    }

    .close-button:hover {
        color: black;
        /* Change to the desired hover color */
    }


    @media only screen and (max-width: 480px) {

        .pagination a,
        .pagination span {
            padding: 6px 10px;
        }
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
                <span class="dashboard">Record Lists</span>
            </div>
            <div class="barangay-dropdown">
                <select id="barangaySelect" onchange="handleBarangayChange()">
                    <option value="" selected disabled>Select Barangay</option>
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


            <form action="search.php" method="GET" class="search-box">
                <input type="text" placeholder="Search..." name="searchQuery" id="searchInput" required />
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

         

            <div class="exportlog" id="exportlog">
                <button class="exportbutton" id="exportbutton">
                    <img src="images/printicon.png" class="exporticon">
                    Export to CSV
                </button>
                <div class="modal" id="modal">
                    <div class="modal-content">
                        <button class="close-button">X</button>
                        <h2>Select a Barangay to Export</h2>
                        <ul class="item-list">
                            <li class="modal-item" id="export-all">Export All</li>
                            <li class="modal-item">Aldiano Olaes</li>
                            <li class="modal-item">Poblacion 1</li>
                            <li class="modal-item">Poblacion 2</li>
                            <li class="modal-item">Poblacion 3</li>
                            <li class="modal-item">Poblacion 4</li>
                            <li class="modal-item">Poblacion 5 - FVR</li>
                            <li class="modal-item">Poblacion 5 - Proper</li>
                            <li class="modal-item">Benjamin Tirona</li>
                            <li class="modal-item">Bernardo Pulido</li>
                            <li class="modal-item">Epifanio Malia</li>
                            <li class="modal-item">Francisco De Castro</li>
                            <li class="modal-item">Francisco De Castro - Sunshine</li>
                            <li class="modal-item">Francisco De Castro - Mandarin</li>
                            <li class="modal-item">Francisco De Castro - Kanebo</li>
                            <li class="modal-item">Francisco De Castro - Monteverde</li>
                            <li class="modal-item">Francisco De Castro - Rolling Hills</li>
                            <li class="modal-item">Francisco Reyes</li>
                            <li class="modal-item">Fiorello Calimag</li>
                            <li class="modal-item">Gavino Maderan</li>
                            <li class="modal-item">Gregoria De Jesus</li>
                            <li class="modal-item">Inocencio Salud</li>
                            <li class="modal-item">Jacinto Lumbreras</li>
                            <li class="modal-item">Kapitan Kua</li>
                            <li class="modal-item">Koronel Jose P. Elises</li>
                            <li class="modal-item">Macario Dacon</li>
                            <li class="modal-item">Marcelino Memije</li>
                            <li class="modal-item">Nicolasa Virata</li>
                            <li class="modal-item">Pantaleon Granados</li>
                            <li class="modal-item">Ramon Cruz Sr.</li>
                            <li class="modal-item">San Gabriel</li>
                            <li class="modal-item">San Jose</li>
                            <li class="modal-item">Severino De Las Alas</li>
                            <li class="modal-item">Tiniente Tiago</li>
                        </ul>
                    </div>
                </div>
            </div>



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
                            <td
                                class="person-status <?php echo strtolower($data['personStatus']) === 'active' ? 'my-active-class' : (strtolower($data['personStatus']) === 'deceased' ? 'my-deceased-class' : ''); ?>">
                                <?php if (strtolower($data['personStatus']) === 'active'): ?>
                                <img src="images/check.png" alt="Checkmark" class="status-icon">
                                <?php elseif (strtolower($data['personStatus']) === 'deceased'): ?>

                                <?php endif; ?>
                                <?php echo $data['personStatus']; ?>
                            </td>
                            <td>
                                <a href="view.php?id=<?php echo $data['id']; ?>&page=<?php echo $currentpage; ?>"
                                    class="btn btn-info">View</a>
                                <a href="edit.php?id=<?php echo $data['id']; ?>&page=<?php echo $currentpage; ?>"
                                    class="btn btn-warning">Edit</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>

                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <?php if ($currentpage > 1) : ?>
                <a href="?page=1<?php echo $searchQuery ? '&searchQuery=' . urlencode($searchQuery) : ''; ?>">First</a>
                <a
                    href="?page=<?php echo ($currentpage - 1); ?><?php echo $searchQuery ? '&searchQuery=' . urlencode($searchQuery) : ''; ?>">Previous</a>
                <?php endif; ?>

                <?php for ($i = $startPage; $i <= $endPage; $i++) : ?>
                <?php if ($currentpage == $i) : ?>
                <span class="current-page"><?php echo $i; ?></span>
                <?php else : ?>
                <a
                    href="?page=<?php echo $i; ?><?php echo $searchQuery ? '&searchQuery=' . urlencode($searchQuery) : ''; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
                <?php endfor; ?>

                <?php if ($currentpage < $totalPages) : ?>
                <a
                    href="?page=<?php echo ($currentpage + 1); ?><?php echo $searchQuery ? '&searchQuery=' . urlencode($searchQuery) : ''; ?>">Next</a>
                <a
                    href="?page=<?php echo $totalPages; ?><?php echo $searchQuery ? '&searchQuery=' . urlencode($searchQuery) : ''; ?>">Last</a>
                <?php endif; ?>
            </div>


        </div>
    </section>


    <script src="homescript.js"></script>
    <script>
  const exportButton = document.querySelector('#exportbutton');
const modal = document.querySelector('#modal');
const closeBtn = document.querySelector('.close-button');
const modalItems = document.querySelectorAll('.modal-item');

exportButton.addEventListener('click', function() {
    modal.style.display = 'block';
});

closeBtn.addEventListener('click', function() {
    modal.style.display = 'none';
});

modal.addEventListener('click', function(event) {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

modalItems.forEach(item => {
    item.addEventListener('click', function() {
        if (item.id === 'export-all') {
            exportAllData();
            const actionText = 'Exported a CSV for all the barangay';
            insertLogData(actionText);
        } else {
            const selectedBarangay = item.textContent.trim();
            exportByBarangay(selectedBarangay);
            const actionText = `Exported a CSV of ${selectedBarangay}`;
            insertLogData(actionText);
        }
    });
});

function exportAllData() {
    window.location.href = 'export.php';
}

function exportByBarangay(barangay) {
    window.location.href = `export.php?barangay=${encodeURIComponent(barangay)}`;
}

function insertLogData(action) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'exportlog.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            // You can perform additional actions here if needed
        }
    };
    
    const data = `action=${encodeURIComponent(action)}`;
    xhr.send(data);
}




    function handleBarangayChange() {
        var select = document.getElementById("barangaySelect");
        var selectedValue = select.options[select.selectedIndex].value;
        window.location.href = "barangay.php?barangay=" + encodeURIComponent(selectedValue);
    }
    </script>
    <?php endif; ?>
</body>

</html>
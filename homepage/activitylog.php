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
}
?>




<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <title>Senior Solutions | Activity Log</title>
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

    .activity-log {
        margin-top: 20px;
        position: relative;
    }

    .activity-log h2 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .activity-log table {
        width: 100%;
        border-collapse: collapse;
    }

    .activity-log th,
    .activity-log td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ccc;
        cursor: default;
    }

    .activity-log th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .activity-log tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .activity-log tbody tr:hover {
        background-color: #eaeaea;
    }

    .log-table {
        width: 100%;
        border-collapse: collapse;
    }

    .log-table th,
    .log-table td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ccc;
    }

    .log-table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .log-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .log-table tbody tr:hover {
        background-color: #eaeaea;
    }

    .log-action-added {
        font-weight: bold;
        color: green;
    }

    .log-action-updated {
        font-weight: bold;
        color: #999b1b;
    }

    .btn-activitylog {
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

    .btn-activitylog:hover {
        background-color: #2653d4;
    }

    .btn-activitylog:active {
        background-color: #1F45B0;
    }

    .date-selection-form {
        display: flex;
        align-items: center;
        margin: 20px 0;
    }

    .date-selection-form label {
        font-weight: bold;
        margin-right: 10px;
    }

    .date-selection-form input[type="date"] {
        padding: 8px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        cursor: pointer;
    }

    .date-selection-form input[type="submit"] {
        margin-left: 10px;
        padding: 8px 20px;
        font-size: 16px;
        border: none;
        background-color: #007BFF;
        color: #fff;
        border-radius: 4px;
        cursor: pointer;
    }

    .date-selection-form input[type="submit"]:hover {
        background-color: #0056b3;
    }

    .date-selection-form input[type="submit"]:focus {
        outline: none;
    }

    .btn-clear {
        background-color: #ffa500;
        color: white;
        margin-left: 10px;
        user-select: none;
        display: none;
    }

    .btn-clear:hover {
        background-color: #CA8700;
    }

    .btn-clear:active {
        background-color: #A16B00;
    }

    .btn-clear:focus {
        outline: none;
    }

    .added {
        font-weight: bold;
        color: green;
    }

    .updated {
        font-weight: bold;
        color: #999b1b;
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
                <span class="dashboard">Activity Log</span>
                <a href="userlog.php" class="btn btn-activitylog">Show User Log</a>
            </div>

            <div class="profile-details">
                <img src="../img/profilepicture.jpg" alt="">
                <span class="admin_name">
                    <?php 
          if (isset($_SESSION['user_name'])) {
              echo $_SESSION['user_name'];
          }
          ?>
                </span>
            </div>
        </nav>

        <div class="home-content">
            <form id="dateSelectionForm" class="date-selection-form">
                <label for="selected_date">Select Date:</label>
                <input type="date" name="selected_date" id="selected_date" value="<?php echo date('Y-m-d'); ?>"
                    required>
                <input type="submit" value="Filter">
                <a href="activitylog.php" class="btn btn-clear" id="clearButton">Clear</a>
            </form>

            <section class="activity-log">
                <h1>History for today:</h1><br>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Account</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="logData">
                        <?php
  $currentDate = date('Y-m-d');
  $logQuery = "SELECT * FROM log WHERE DATE(date) = '{$currentDate}' ORDER BY date DESC";
  $logResult = mysqli_query($conx, $logQuery);
  while ($row = mysqli_fetch_assoc($logResult)) {
    $logDate = date('m-d-y g:ia', strtotime($row['date']));
    $account = $row['account'];
    $action = $row['action'];

    // Wrap "added" and "updated" in HTML elements and apply colors
    $action = preg_replace('/\b(added)\b/i', '<span class="added">$1</span>', $action);
    $action = preg_replace('/\b(updated)\b/i', '<span class="updated">$1</span>', $action);
  ?>
                        <tr>
                            <td><?php echo $logDate; ?></td>
                            <td><?php echo $account; ?></td>
                            <td><?php echo $action; ?></td>
                        </tr>
                        <?php
  }
  ?>
                    </tbody>


                </table>
            </section>
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

    function filterLog(event) {
        event.preventDefault();
        let selectedDate = document.getElementById("selected_date").value;
        window.location.href = `activitylogdate.php?selected_date=${selectedDate}`;
    }
    document.getElementById("dateSelectionForm").addEventListener("submit", filterLog);
    </script>

    <?php endif; ?>
</body>

</html>
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
} elseif ($_SESSION['role'] === 'Admin') {
  $error_msg = 'You are in "Admin" role, contact your supervisor for assistance';
} else {


  


  $records_per_page = 15;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $records_per_page;

$sql = "SELECT * FROM register ORDER BY id DESC LIMIT {$offset}, {$records_per_page}";
$result = $conx->query($sql);

$total_records_query = "SELECT COUNT(*) AS total FROM register";
$total_records_result = $conx->query($total_records_query);
$total_records_row = $total_records_result->fetch_assoc();
$total_records = $total_records_row['total'];
$total_pages = ceil($total_records / $records_per_page);

}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <title>Senior Solutions | Admin Dashboard</title>


    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../img/sslogo.png">
    <style>
    .home-content {
        padding: 20px;
    }

    .home-content table {
        width: 100%;
        border-collapse: collapse;
    }

    .home-content th,
    .home-content td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .home-content th {
        background-color: #f2f2f2;
        font-weight: bold;
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

    @media screen and (max-width: 768px) {

        .home-content th,
        .home-content td {
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

    .select-box {
        display: inline-block;
        position: relative;
    }

    .select-box label {
        display: block;
        margin-bottom: 5px;
    }

    .select-box select {
        padding: 8px 12px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
    }

    .select-box select:focus {
        outline: none;
        border-color: blue;
    }

    .select-box::before {
        content: "\25BC";
        position: absolute;
        top: 70%;
        right: 10px;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .btn-more {
        background-color: #5250b1;
        color: white;
        user-select: none;
        border: none;
    }

    .btn-more:hover {
        background-color: #3e3cb8;
    }

    .btn-more:active {
        background-color: #0a07db;
    }


    .btn-verify {
        background-color: #3f3cf1;
        color: white;
        user-select: none;
        margin-top: 10px;
        margin-left: 10px;
    }

    .btn-verify:hover {
        background-color: #CA8700;
    }

    .btn-verify:active {
        background-color: #A16B00;
    }

    .verified {
        color: white;
        background-color: green;
        position: relative;
        margin-top: 10px;
        font-weight: bold;
        padding: 5px;
        display: inline-flex;
        align-items: center;
        border-radius: 20px;
        width: fit-content;
    }

    .not-verified {
        color: white;
        background-color: red;
        position: relative;
        margin-top: 10px;
        font-weight: bold;
        padding: 5px;
        display: inline-flex;
        align-items: center;
        border-radius: 20px;
        width: fit-content;
    }

    .custom-select {
        display: block;
        width: 80%;
        height: calc(1.5em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        cursor: pointer;
    }

    .custom-select:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .butcontent {
        position: relative;

    }

    .custom-button {
        margin: 30px;
        position: absolute;
        bottom: 0;
        right: 0;
        display: inline-block;
        padding: 0.5rem 1rem;
        font-size: 1rem;
        font-weight: 600;
        line-height: 1.5;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        cursor: pointer;
        user-select: none;
        border: 1px solid transparent;
        border-radius: 0.25rem;
        background-color: #007bff;
        color: #fff;
        transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .custom-button:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }

    .custom-button:focus {
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
    }

    .custom-button:active {
        background-color: #0056b3;
        border-color: #004b9a;
    }

    .status-online {
        color: #14b114;
        font-weight: bold;

    }

    .status-offline {
        color: red;
        font-weight: bold;
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

    .delete-button {
        background-color: #ff0000;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer; 

    }
    .delete-button::before {
        content: url('images/deleteicon.png');
        margin-right: 5px;
        vertical-align: middle;
    }
    .delete-button:hover {
        background-color: #cc0000;
    }

    .darker-gray-row {
        background-color: #d3d3d3;
    }

    .modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.4);
  
}

.modal-content {
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  width: 50%;
  max-width: 400px;
  margin: 15% auto;
  padding: 20px;
  text-align: center;
}

.close {
  color: #aaa;
  float: right;
  font-size: 24px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

.modal p {
  margin-bottom: 20px;
}

.modal button {
  padding: 10px 20px;
  background-color: red;
  color: #fff;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}

.modal button:hover {
  background-color: #a80d0d;
}

.modal button:focus {
  outline: none;
}

/* Media query to make the modal responsive */
@media (max-width: 600px) {
  .modal-content {
    width: 90%;
  }
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
                <a href="homelog.php">
                    <i class="bx bx-list-ul"></i>
                    <span class="links_name">Record Lists</span>
                </a>
            </li>
            <li>
                <a href="userlog.php" class="active">
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
                <span class="dashboard">User Log</span>
                <a href="activitylog.php" class="btn btn-activitylog">Show Activity Log</a>
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
            <?php
if (isset($_GET['Verification'])) {
    include('sendverify.php');
}
?>

            <?php if (isset($_SESSION['message'])): ?>
            <div id="alert-message" class="alert alert-info"
                style="background-color: #45d429; color: #fff; padding: 10px; border-radius: 4px; width: 500px;">
                <?php echo $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']); ?>
            <script>
            setTimeout(function() {
                document.getElementById('alert-message').style.display = 'none';
            }, 5000);
            </script>
            <?php endif; ?>


            <table class="table">
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Active Status</th>
            <th>Verification</th>
            <th>Role</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $rowClass = $row['email'] === 'ictgma@gmail.com' ? 'darker-gray-row' : '';
            echo "<tr class='{$rowClass}'>";
            echo "<td>" . $row['Username'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            $statusClass = $row['activeStatus'] == 'Online' ? 'status-online' : 'status-offline';
            echo "<td class='{$statusClass}'>" . $row['activeStatus'] . "</td>";
            echo "<td>";
            if ($row['verification'] == 1) {
                echo "<span class='verified'>Account Verified</span>";
            } else {
                echo "<span class='not-verified'>Account Not Verified</span>";
                echo "<a href='sendverify.php?Verification=" . $row['email'] . "' class='btn btn-verify'>Verify this account</a>";
            }
            echo "</td>";
            echo "<td>";
            echo "<select id='role-select-" . $row['Username'] . "' name='role-select' class='custom-select' " . ($row['email'] === 'ictgma@gmail.com' ? 'disabled' : '') . ">";
            echo "<option value='User' " . ($row['role'] == 'User' ? 'selected' : '') . ">User</option>";
            echo "<option value='Admin' " . ($row['role'] == 'Admin' ? 'selected' : '') . ">Admin</option>";
            echo "<option value='Super Admin' " . ($row['role'] == 'Super Admin' ? 'selected' : '') . ">Super Admin</option>";
            echo "</select>";
            echo "</td>";
            echo "<td>";
            echo "<select id='status-select-" . $row['Username'] . "' name='status-select' class='custom-select' " . ($row['email'] === 'ictgma@gmail.com' ? 'disabled' : '') . ">";
            echo "<option value='Active' " . ($row['status'] == 'Active' ? 'selected' : '') . ">Active</option>";
            echo "<option value='Disabled' " . ($row['status'] == 'Disabled' ? 'selected' : '') . ">Disabled</option>";
            echo "</select>";
            echo "</td>";
            echo "<td>";
            if ($row['email'] !== 'ictgma@gmail.com') {
                echo "<input type='button' class='delete-button' value='Delete' onclick='deleteUser(\"" . $row['Username'] . "\")'>";
            } else {
                echo "<span></span>";
            }
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<div id="deleteModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <p id="modalText">Are you sure you want<br>to delete this user?</p>
    <button onclick="deleteUserConfirmed()">Delete</button>
  </div>
</div>

        </div>
        <div class="pagination">
            <?php if ($total_pages > 1): ?>
            <?php if ($current_page > 1): ?>
            <a href="?page=1" class="first-page">First</a>
            <a href="?page=<?php echo ($current_page - 1); ?>">Previous</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <?php if ($i == $current_page): ?>
            <span class="current-page"><?php echo $i; ?></span>
            <?php else: ?>
            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php endif; ?>
            <?php endfor; ?>
            <?php if ($current_page < $total_pages): ?>
            <a href="?page=<?php echo ($current_page + 1); ?>">Next</a>
            <a href="?page=<?php echo $total_pages; ?>" class="last-page">Last</a>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>

    <div class="butcontent">
        <input type="hidden" name="user_name" value="<?php echo $_SESSION['user_name']; ?>">
        <button id="save-settings-button" onclick="saveSettings()" class="custom-button">Save Settings</button>
    </div>





    <script src="homescript.js"></script>
    <script>
    function saveSettings() {
        var roleSelectBoxes = document.getElementsByName('role-select');
        var statusSelectBoxes = document.getElementsByName('status-select');
        var data = [];
        for (var i = 0; i < roleSelectBoxes.length; i++) {
            var roleSelectBox = roleSelectBoxes[i];
            var statusSelectBox = statusSelectBoxes[i];
            var username = roleSelectBox.id.replace('role-select-', '');
            var username1 = roleSelectBox.id.replace('status-select-', '');
            var selectedRole = roleSelectBox.value;
            var selectedStatus = statusSelectBox.value;
            data.push({
                username: username,
                username1,
                role: selectedRole,
                status: selectedStatus
            });
        }
        var form = document.createElement('form');
        form.style.display = 'none';
        form.method = 'POST';
        form.action = 'updateuser.php';
        var dataField = document.createElement('input');
        dataField.type = 'hidden';
        dataField.name = 'data';
        dataField.value = JSON.stringify(data);
        form.appendChild(dataField);
        document.body.appendChild(form);
        form.submit();
    }


    function deleteUser(username) {
  const modal = document.getElementById("deleteModal");
  const deleteButton = modal.querySelector("button");
  const modalText = modal.querySelector("#modalText");
  modalText.innerHTML = `Are you sure you want to delete <strong>${username}</strong>?`;
  modal.style.display = "block";
  deleteButton.onclick = function () {
    deleteUserConfirmed(username);
    closeModal();
  };
}



function closeModal() {
  const modal = document.getElementById("deleteModal");
  modal.style.display = "none";
}

function deleteUserConfirmed(username) {
  const xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
      location.reload();
    }
  };
  xmlhttp.open("GET", "deleteuser.php?username=" + username, true);
  xmlhttp.send();
}

    </script>
    <?php endif; ?>
</body>

</html>
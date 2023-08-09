<?php
include('../configuration/config.php');
include("connect.php");

$data = $_POST['data'];
$data = json_decode($data, true);
foreach ($data as $row) {
  $username = $row['username'];
  $role = $row['role'];
  $status = $row['status'];

  $query = "SELECT role, status, activeStatus, autoOut FROM register WHERE Username = '$username'";
  $result = mysqli_query($conn, $query);
  $dbRow = mysqli_fetch_assoc($result);
  $oldRole = $dbRow['role'];
  $oldStatus = $dbRow['status'];
  $oldActiveStatus = $dbRow['activeStatus'];
  $oldAutoOut = $dbRow['autoOut'];

  $updateQuery = "UPDATE register SET role = '$role', status = '$status'";
  if ($status != $oldStatus) {
    $updateQuery .= ", activeStatus = 'Offline'"; // Always set to 'Offline' when status changes
}
  if ($role != $oldRole) {
    $updateQuery .= ", activeStatus = 'Offline'";
  }

  if ($oldAutoOut == 'Yes') {
    $updateQuery .= ", autoOut = 'Yes'";
  }

  $updateQuery .= " WHERE Username = '$username'";

  if (mysqli_query($conn, $updateQuery)) {
    session_start();
    $_SESSION['message'] = "Settings saved successfully.";
  } else {
    session_start();
    $_SESSION['message'] = "Error updating roles and status: " . mysqli_error($conn);
    break;
  }
}

mysqli_close($conn);
header("Location: userlog.php");
exit();
?>

<?php
include('../configuration/config.php');
include("connect.php");

// Get the count for all genders for each barangay
$query = "SELECT barangay, COUNT(*) AS count, SUM(CASE WHEN gender = 'Male' THEN 1 ELSE 0 END) AS male_count, SUM(CASE WHEN gender = 'Female' THEN 1 ELSE 0 END) AS female_count FROM people GROUP BY barangay";
$result = mysqli_query($conn, $query);

$labels = [];
$data = [];
$maleCount = [];
$femaleCount = [];

while ($row = mysqli_fetch_assoc($result)) {
  $labels[] = $row['barangay'];
  $data[] = $row['count'];
  $maleCount[] = $row['male_count'];
  $femaleCount[] = $row['female_count'];
}

mysqli_free_result($result);
mysqli_close($conn);
?>

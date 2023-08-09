<?php

include('../configuration/config.php');
include("connect.php");
$registrantsData = array();
for ($age = 60; $age <= 100; $age++) {
  $ageSql = "SELECT COUNT(*) AS count FROM people WHERE YEAR(CURDATE()) - YEAR(birthDate) = $age";
  $ageResult = mysqli_query($conn, $ageSql);
  $registrantsData[] = mysqli_fetch_assoc($ageResult)['count'];
}
?>
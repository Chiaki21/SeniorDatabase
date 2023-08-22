<?php

include('../configuration/config.php');
$registrantsData = array();

for ($age = 60; $age <= 100; $age++) {
  $ageSql = "SELECT COUNT(*) AS count FROM people WHERE YEAR(CURDATE()) - YEAR(birthDate) = $age
             OR YEAR(CURDATE()) - YEAR(STR_TO_DATE(birthDate, '%m/%d/%Y')) = $age
             OR YEAR(CURDATE()) - YEAR(STR_TO_DATE(birthDate, '%m-%d-%Y')) = $age";
  $ageResult = mysqli_query($conx, $ageSql);
  $registrantsData[] = mysqli_fetch_assoc($ageResult)['count'];
}

?>

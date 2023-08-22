<?php
include('../configuration/config.php');

if (isset($_GET['gender']) && isset($_GET['barangay'])) {
  $selectedGender = $_GET['gender'];
  $selectedBarangay = $_GET['barangay'];
  $query = "SELECT COUNT(*) AS genderCount FROM people WHERE gender = ? AND barangay LIKE ?";
  $stmt = $conx->prepare($query);
  $stmt->bind_param("ss", $selectedGender, $selectedBarangay);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result) {
    $row = $result->fetch_assoc();
    echo $row['genderCount'];
  } else {
    echo "Error fetching gender count.";
  }

  $stmt->close();
  mysqli_close($conx);
} else {
  echo "Invalid parameters.";
}
?>

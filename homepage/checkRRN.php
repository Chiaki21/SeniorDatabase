<?php
include('../configuration/config.php');

if (isset($_POST['referenceCode'])) {
    $referenceCode = $_POST['referenceCode'];
    
    // Check if the reference code already exists in the database
    $query = "SELECT COUNT(*) AS count FROM people WHERE referenceCode = '{$referenceCode}'";
    $result = $conx->query($query);
    $row = $result->fetch_assoc();
    $count = $row['count'];

    echo json_encode(['exists' => ($count > 0)]);
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
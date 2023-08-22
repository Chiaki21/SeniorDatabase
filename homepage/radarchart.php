<?php
include('../configuration/config.php');
$disabilities = [
    "Health problems/ ailments",
    "Hypertension",
    "Arthritis / Gout",
    "Coronary Heart Disease",
    "Diabetes",
    "Chronic Kidney Disease", 
    "Alzheimer / Dementia",
    "Pulmonary Disease"
];


$query = "SELECT medicalConcern FROM people";
$result = mysqli_query($conx, $query);
$counts = array_fill_keys($disabilities, 0);
while ($row = mysqli_fetch_assoc($result)) {
    $concerns = explode(",", $row['medicalConcern']);
    foreach ($concerns as $concern) {
        $concern = trim($concern);
        if (in_array($concern, $disabilities)) {
            $counts[$concern]++;
        }
    }
}
$labels = array_keys($counts);
$data = array_values($counts);

?>
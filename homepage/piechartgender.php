<?php
include('../configuration/config.php');


$sql = "SELECT gender, COUNT(*) AS count FROM people WHERE gender IN ('Male', 'Female') GROUP BY gender";
$result = $conx->query($sql);

$labels = array();
$data = array();
$colors = array();
$totalCount = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $gender = $row["gender"];
        $count = $row["count"];
        $labels[] = $gender;
        $data[] = $count;
        $totalCount += $count;

        if ($gender == "Male") {
            $colors[] = "#2F46D8";
        } elseif ($gender == "Female") {
            $colors[] = "#E34949";
        }
    }
}



$labels_json = json_encode($labels);
$data_json = json_encode($data);
$colors_json = json_encode($colors);
?>

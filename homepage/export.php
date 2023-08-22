<?php
include('../configuration/config.php');

$barangayFilter = $_GET['barangay'] ?? null;

$sql = "SELECT * FROM people";
if ($barangayFilter !== null) {
    $sql .= " WHERE barangay = '" . mysqli_real_escape_string($conx, $barangayFilter) . "'";
}
$result = mysqli_query($conx, $sql);

$columnNames = [];
while ($fieldInfo = mysqli_fetch_field($result)) {
    $columnNames[] = $fieldInfo->name;
}
$csv = implode(',', $columnNames) . "\n";
while ($row = mysqli_fetch_assoc($result)) {
    $escapedRow = array_map(function ($value) use ($conx) {
        return '"' . mysqli_real_escape_string($conx, $value) . '"';
    }, $row);

    $csv .= implode(',', $escapedRow) . "\n";
}
if ($barangayFilter !== null) {
    $filename = $barangayFilter . '.csv';
} else {
    $filename = 'GMA_Senior_Data.csv';
}
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');


echo $csv;
mysqli_close($conx);
?>

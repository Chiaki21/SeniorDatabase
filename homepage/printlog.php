<?php
include('../configuration/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['CONTENT_TYPE'] === 'application/json') {

    $data = json_decode(file_get_contents('php://input'), true);
    $account = isset($data['user_name']) ? $data['user_name'] : '';
    $action = isset($data['action']) ? $data['action'] : '';
    $account = mysqli_real_escape_string($conx, $account);
    $action = mysqli_real_escape_string($conx, $action);
    $query = "INSERT INTO log (account, action) VALUES ('$account', '$action')";
    $result = mysqli_query($conx, $query);
    if ($result) {
        http_response_code(200);
    } else {
        http_response_code(500);
    }
} else {
    http_response_code(400);
}
?>
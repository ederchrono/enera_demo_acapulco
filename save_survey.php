<?php
//Start of controller

include('dbconfig.php');

session_start();
$success_url = $_POST["success_url"]; //Get the success_url

$data = array();
for ($index = 1; $index <= ((count($_POST) - 1) / 2); $index++) {
    $data[$index]['title'] = $_POST["entry$index-title"];
    $data[$index]['answer'] = $_POST["entry$index-answer"];
}

$timestamp = date('U');

if ($stmt = $mysqli->prepare("INSERT INTO `survey_answers` (`id_branch`, `user_mac`, `ap_mac`, `id_view`, `answer_data`, `timestamp`) VALUES (?, ?, ?, ?, ?, ?)")) {
    $stmt->bind_param("issisi", $_SESSION['id_branch'], $_SESSION['user_mac'], $_SESSION['ap_mac'], $_SESSION['id_view'], utf8_decode(json_encode($data, JSON_UNESCAPED_UNICODE)), $timestamp);
    $stmt->execute();
    $mysqli->close();
} else {
    trigger_error($mysqli->error, E_USER_ERROR);
    $mysqli->close();
}

$client_mac = $_SESSION['client_mac'];
$base_grant_url = $_SESSION['base_grant_url'];
$user_continue_url = $_SESSION['user_continue_url'];
$ap_mac = $_SESSION['ap_mac'];

$branch_url = "https://www.facebook.com/pages/Punto-M%C3%A9xico/442308712577566";
$success_url = $base_grant_url . "?continue_url=$branch_url&duration=3600";

//echo "base_grant_url=$base_grant_url"

header('Location: ' . $success_url);
session_destroy();
die();

//End of controller
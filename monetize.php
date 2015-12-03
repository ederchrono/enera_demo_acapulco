<?php

session_start();
include('dbconfig.php');

//We recieve variables
$ap_mac = $_SESSION['ap_mac'];
$id_branch = $_SESSION['id_branch'];
$id_group = $_SESSION['id_branch'];
$user_mac = $_SESSION['user_mac'];
$user_fb_id = $_SESSION['user_fb_id'];
$type = $_SESSION['type'];
$type_id = $_SESSION['type_id'];
$content = $_SESSION['content'];

$table_monetize = "monetize_logs";

date_default_timezone_set('America/Mexico_City');
$timestamp = date('U');

if ($stmt = $mysqli->prepare("INSERT INTO $table_monetize (`ap_mac`, `user_mac`, `id_branch`, `user_fb_id`, `id_group`, `type`, `type_id`, `content`, `timestamp`) VALUES (?,?,?,?,?,?,?,?,?)")) {
  	$stmt->bind_param("ssisisssi", $ap_mac, $user_mac, $id_branch, $user_fb_id, $id_group, $type, $type_id, $content, $timestamp);
  	$stmt->execute();
  	$stmt->close();
} else {
  	trigger_error($mysqli->error, E_USER_ERROR);
}

$mysqli->close();
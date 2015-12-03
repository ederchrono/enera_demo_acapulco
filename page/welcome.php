<?php //Start of controller

//Load data needed to show the portal
session_start();
$user_mac = $_SESSION['user_mac'];
$base_grant_url = $_SESSION['base_grant_url'];
$user_continue_url = $_SESSION['user_continue_url'];
$ap_mac = $_SESSION['ap_mac'];
$force_portal = $_SESSION['force_portal'];

require 'functions.php';
require 'dbconfig.php';
require 'fbconfig.php';

$table = "user";
$table2 = "user_logs";
$table3 = "company_branch";
$table4 = "passenger_logs";
$table5 = "company_ap_historical";

$fb_user_id_string = "user_fb_id";
$ap_mac_string = "ap_mac";

//echo "user_mac" . $user_mac;

//Obtain branch information based on AP's mac address
if ($stmt = $mysqli->prepare("SELECT b.name, b.id, b.id_group, b.message, b.url, b.fb_url, b.fb_pageid, b.style FROM $table3 b INNER JOIN $table5 ON b.id=company_ap_historical.id_branch WHERE $ap_mac_string = ? ")){
    $stmt->bind_param("s", $ap_mac);
    $stmt->execute();
    $stmt->bind_result($name, $id_branch, $id_group, $branch_message, $branch_url, $branch_fb_url, $branch_fb_pageid, $style);
    $stmt->fetch();
    $stmt->close();

    if ($branch_url == '') $branch_url = $user_continue_url;
    $success_url = $base_grant_url . "?continue_url=" . $branch_url . "&duration=1800";

    $s_style = explode('||', $style);
    $style = "background-color:" . $s_style[0] . ";" . "font-family:" . $s_style[1];
} else {
    trigger_error($mysqli->error, E_USER_ERROR);
}

$name = utf8_encode($name);

$user_os = getOS();
$user_browser = getBrowser();

//End of controller ?>
<!doctype html>
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
    <!-- Meta setup - Required for apple device -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="project/img/welcome/favicon.png" />
    <!-- Title -->
    <title>Metro STC Demo Wi-Fi</title>
    <!-- Include fonts -->
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
    <!-- Include webplate -->
    <script id="webplate-stack" src="stack.js"></script>
    <!-- Portal custom CSS -->
    <link href='css/portal_styles.css' rel='stylesheet' type='text/css'>
    <!-- Login buttons -->
    <link href='css/auth-buttons.css' rel='stylesheet' type='text/css'>
    <!-- Video JS -->
    <link href="css/video-js.css" rel="stylesheet">
    <script src="js/video.js"></script>
</head>
<body style="display: none;" data-icon-font="font-awesome" data-ui="stripe" data-project-css="welcome.css" data-project-js="min/welcome.min.js" data-formplate-colour="aqua" class="invert">
<div id="fb-root"></div>

<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&appId=282363058604879&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
        console.log("Facebook SDK loaded");
    }(document, 'script', 'facebook-jssdk'));
</script>

<?php
if ($user != null) {
    //If the user has not logged into Facebook yet
    include('userdb_core.php');
    include('page/loginmethod/choose.php');
} else {
    //If the user has already logged into Facebook
    if($stmt = $mysqli->prepare("SELECT MAX(`timestamp`) FROM $table4 WHERE `user_mac` = ? LIMIT 1")) {
        $stmt->bind_param("s", $user_mac);
        $stmt->execute();
        $stmt->bind_result($last_timestamp);
        $stmt->fetch();
        $stmt->close();
    } else {
        trigger_error($mysqli->error, E_USER_ERROR);
    }

    $diff = (date('U') - $last_timestamp);
    if ($diff < 300) {

    } else {
        if($stmt = $mysqli->prepare("INSERT INTO $table4 (`user_mac`, `ap_mac`, `user_browser`, `user_os`, `timestamp`) VALUES (?,?,?,?,?)")){
            $stmt->bind_param("ssssi", $user_mac, $ap_mac, $user_browser, $user_os, $timestamp);
            $stmt->execute();
            $stmt->close();
            $_SESSION['passenger_log']=1;
        } else {
            trigger_error($mysqli->error, E_USER_ERROR);
        }
    }

    include 'page/section/header.php';
    include 'page/section/footer.php';
}
?>

<script src="js/functions.js"></script>
</body>
</html>

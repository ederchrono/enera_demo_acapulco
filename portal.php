<?php //Start of controller

require 'dbconfig.php';
$use_timed_session = true; //Set this value to true to open a temporal session before login in

//Define if this is a fake session (for portal visualization) or a real session
if (empty($_GET['client_mac']) || empty($_GET['base_grant_url']) || empty($_GET['user_continue_url']) || empty($_GET['node_mac'])) {
    //Check if there are values for a fake session
    if (empty($_GET['force_portal']) || empty($_GET['force_id_branch'])) {
        include 'page/other/error.php';
        die();
    }
    //This is a fake session
    $force_id_branch = $_GET['force_id_branch']; //TODO: Sanitize

    //Values that won't change for fake sessions
    $user_mac = 'FF:FF:FF:FF:FF:FF';
    $base_grant_url = 'https://n81.network-auth.com/splash/grant';
    $user_continue_url = 'https://www.google.com/';
    //Force values depending on the portal to test
    $force_portal = $_GET['force_portal'];
    $force_id_branch = $_GET['force_id_branch']; //TODO: Sanitize

    if ($stmt = $mysqli->prepare("SELECT ap_mac FROM company_ap_historical WHERE id_branch = ? LIMIT 1")) {
        $stmt->bind_param("i", $force_id_branch);
        $stmt->execute();
        $stmt->bind_result($ap_mac);
        $stmt->fetch();
        $stmt->close();
    } else {
        trigger_error($mysqli->error, E_USER_ERROR);
    }

    $relocation = "http://sandbox.enera-intelligence.mx/demos/acapulco/load.php";
} else {
    //This is a normal and real session
    $user_mac = $_GET['client_mac'];
    $base_grant_url = $_GET['base_grant_url'];
    $user_continue_url = $_GET['user_continue_url'];
    $ap_mac = $_GET['node_mac'];
    $force_portal = null;
    if ($use_timed_session) {
        $relocation = $base_grant_url . "?continue_url=http://sandbox.enera-intelligence.mx/demos/acapulco/load.php&duration=180";
    } else {
        $relocation = 'http://sandbox.enera-intelligence.mx/demo_metro/load.php';
    }
}

//Save session values
session_start();
$_SESSION['user_mac'] = $user_mac;
$_SESSION['base_grant_url'] = $base_grant_url;
$_SESSION['user_continue_url'] = $user_continue_url;
$_SESSION['ap_mac'] = $ap_mac;
$_SESSION['force_portal'] = $force_portal;
//TODO: Filter the last data chunk to ensure it is valid and that does not contains insecure data

header("Location: $relocation");
die();

//End of controller

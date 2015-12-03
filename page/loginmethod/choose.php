<?php //Start of controller

include('dbconfig.php');
include_once('constants.php');

date_default_timezone_set('America/Mexico_City');

//TODO: Create a special file for this type of functions

/*
 * getBitCount
 *
 * Will count bits in 1 of a current view filter so that this number can be used to select the best match (video, survey, banner, etc)
 *
 * @param   [int]   value   The filter value to get bit count from
 *
 * @return  [int]   count   The bit count result
 *
 */
function getBitCount($value) {
    $count = 0;
    while($value)
    {
        $count += ($value & 1);
        $value = $value >> 1;
    }
    return $count;
}

session_start();
$_SESSION['ap_mac'] = $ap_mac;
$_SESSION['user_mac'] = $user_mac;
$_SESSION['user_fb_id'] = $user_fb_id;
$_SESSION['id_branch'] = $id_branch;
$_SESSION['id_group'] = $id_group;
$_SESSION['content'] = "";

$base_grant_url = $_GET['base_grant_url'];
$user_continue_url = $_GET['user_continue_url'];

if ($branch_url == '') $branch_url = $user_continue_url;
$success_url = $base_grant_url . "?continue_url=" . $branch_url . "&duration=10800";

$cmonstr = "monetize_logs";
$typestr = "type";
$type_idstr = "type_id";
$like = "like";
$fb_idstr = "user_fb_id";

$response_string = "Bienvenido " . $fb_fullname . "!";

if (!is_null($force_portal)) {
    $status = $force_portal;
} else {
    $status = 4;
}

//$status = $force_status; //TODO: Instead of this status there must be a filter rule to choose the appropriate view, remove this hard-code
//$status = 3;

if ($status == 1) {
    include 'page/loginmethod/like.php';
} else if ($status == 2) {
    include 'page/loginmethod/banner.php';
} else if ($status == 3) {
    include 'page/loginmethod/video.php';
} else if ($status == 4) {
    include 'page/loginmethod/survey.php';
} else if ($status == 5) {
    include 'page/loginmethod/promotion.php';
} else if ($status == 6) {
    include 'page/loginmethod/feedback.php';
}

//End of controller

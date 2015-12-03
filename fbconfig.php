<?php

require 'src/facebook.php';  // Include facebook SDK file

$facebook = new Facebook(array(
    //Real app
    'appId'  => '282363058604879',   // Facebook App ID
    'secret' => 'b61e5fe63f4c5e0544ad94684a9c3ec9',  // Facebook App Secret
    //Sandbox app (WARNING: Does not work with all facebook ids!)
    //'appId'  => '444284585746058',   // Facebook App ID
    //'secret' => 'e14d3e69af32118b449ffc5ac1555185',  // Facebook App Secret
    //'cookie' => true
));

$user = $facebook->getUser();

date_default_timezone_set('America/Mexico_City');
$timestamp = date('U');

if ($user) {
    try {
        $user_profile = $facebook->api('/me');
        $fb_id = $user_profile['id'];
        $user_fb_id = $user_profile['id'];
        $fb_fullname = $user_profile['name'];
        $fb_email = (isset($user_profile['email'])) ? $user_profile['email'] : 'No permission granted';
        $fb_birthday = (isset($user_profile['birthday'])) ? $user_profile['birthday'] : 'No permission granted';
        $fb_gender = $user_profile['gender'];
        $fb_location = (isset($user_profile['location'])) ? $user_profile['location']['name'] : 'No permission granted';
        $fb_hometown = (isset($user_profile['hometown'])) ? $user_profile['hometown']['name'] : 'No permission granted';
        $user_profile = $facebook->api('/me/likes?limit=100');
        $fb_user_likes = (isset($user_profile['data'])) ? $user_profile['data'] : 'No permission granted';



        //TODO: Check if user_lastupdate from the DB is more equal to 30 days or more
        //TODO: *Implement* a way to get more than 100 likes (the current Facebook JSON limit is 100)
        //TODO: Update user_lastupdate from the DB to the current date
    } catch (FacebookApiException $e) {
        error_log($e);
    }
} else {
    $debug = "debug";
    $loginUrl = $facebook->getLoginUrl(array(
        'scope'   => 'public_profile,email,user_birthday,user_location,user_likes', // Permissions to request from the user
        'display' => 'popup'
    ));
    /*if ($user_os == 'Mac OS X' || $user_os = 'Mac OS 9') {
        $loginUrl = $facebook->getLoginUrl(array(
            'scope'   => 'public_profile,email,user_birthday,user_location,user_likes', // Permissions to request from the user
            'display' => 'popup'
        ));
    } else {
        $loginUrl = $facebook->getLoginUrl(array(
            'scope'   => 'public_profile,email,user_birthday,user_location,user_likes', // Permissions to request from the user
            'display' => 'page'
        ));
    }*/
}

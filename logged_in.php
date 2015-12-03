<?php
//Start of controller
//No longer used...
require_once 'autoload.php';

//date_default_timezone_set('America/Mexico_City');
session_start();

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\FacebookRequestException;
use Facebook\GraphUser;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookJavaScriptLoginHelper;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;

//List of available promotions (TODO: This information should be obtained from a database instead of a variable)
$all_promotions = array(
    "J.K. Rowling" => "<div class='image' data-wallpaper='http://www.jkrowling.com/uploads/images/large/en_US-timeline-image-harry-potter-and-the-deathly-hallows-1333632499.jpg'></div><div class='text'><p>Harry Potter series 50%</p></div>",
    "Suzanne Collins" => "<div class='image' data-wallpaper='http://upload.wikimedia.org/wikipedia/en/a/ab/Hunger_games.jpg'></div><div class='text'><p>Hunger Games 5% discount</p></div>",
    "Angry Birds" => "<div class='image' data-wallpaper='http://mcdn4.angrybirdsnest.com/wp-content/uploads/2011/12/Angry-Birds-Seasons-Christmas-Comic-Part-25.jpg'></div><div class='text'><p>Buy Angry Birds and get a free Angry X-Mas bird card</p></div>",
    "Facebook" => "<div class='image' data-wallpaper='http://ecx.images-amazon.com/images/I/51i8emtv9PL._SX258_BO1,204,203,200_.jpg'></div><div class='text'><p>Buy the book \"Ultimate Guide to Facebook Advertising: How to <br/>Access 1 Billion Potential Customers in 10 Minutes\" (Ultimate Series)</p></div>",
);

$selected_promotions = array();
array_push($selected_promotions, $all_promotions['Facebook']);

// init app with app id and secret
FacebookSession::setDefaultApplication('282363058604879','b61e5fe63f4c5e0544ad94684a9c3ec9');

//$helper = new FacebookRedirectLoginHelper();

$helper = new FacebookRedirectLoginHelper('http://sandbox.enera-intelligence.mx/demo_metro/logged_in.php');

try {
    $session = $helper->getSessionFromRedirect();
} catch(FacebookRequestException $ex) {
    // When Facebook returns an error
    //echo "ex $ex";
} catch(\Exception $ex) {
    // When validation fails or other local issues
    //echo "ex $ex";
}

if ($session) {
    //Logged in
    try {
        //Get profile main info
        $user_profile = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className())->asArray();
        $user_name = $user_profile['name'];

        //Get profile likes
        $user_likes = (new FacebookRequest($session, 'GET', '/me/likes/'))->execute()->getGraphObject()->asArray();
        $user_likes = $user_likes['data'];
        //var_dump($user_likes['data'][0]->name);
    } catch(FacebookRequestException $e) {
        //echo "Exception occured, code: " . $e->getCode();
        //echo " with message: " . $e->getMessage();
    }

    //Process fb_user_likes variable to get the recommendations
    foreach($all_promotions as $key => $promotion) {
        foreach ($user_likes as $user_like) {
            //echo "---" . $user_like['name'];
            if ($key == $user_like->name)
            {
                array_push($selected_promotions, $promotion);
            }
        }
    }
}

//End of controller
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Meta setup - Required for apple device -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="project/img/welcome/favicon.png" />
    <!-- Title -->
    <title>Walmart Free WiFi</title>
    <!-- Include fonts -->
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
    <!-- Include webplate -->
    <script id="webplate-stack" src="stack.js"></script>
    <!-- Portal custom CSS -->
    <link href='css/portal_styles.css' rel='stylesheet' type='text/css'>
</head>
<body style="display: none;" data-icon-font="icomoon" data-ui="stripe" data-project-css="welcome.css" data-project-js="min/welcome.min.js" data-formplate-colour="aqua" class="invert">

<!-- Facebook like box -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=550968091700617&version=v2.0";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<!-- Header -->
<header class="stripe full">
    <!-- <a href="#" class="navigation-trigger icon-menu"></a> -->
    <div class="contain">
        <div class="text-center-tight">
            <div class="inner">
                <img id="logo" src="images/999.png" alt="No image found."/>
                <br/>
                <h2>Welcome <span id="user_name" style="color: white;"></span>!</h2>
                <p style="color: white;">Please like our Facebook page (optional):</p>
                <div class="fb-like-box" data-href="https://www.facebook.com/walmart" data-width="200" data-colorscheme="light" data-show-faces="false" data-header="false" data-stream="false" data-show-border="false"></div>
                <br/>
                <p style="color: white;">And scroll down<br/>to continue</p>
            </div>
        </div>
        <a href="#" class="scroll-down icon-angle-down" style="left: 90%;"></a>
    </div>
    <div class="bg-image"></div>
</header>

<!-- Showcase -->
<div class="stripe" id="stripe-showcase"><div class="contain">
        <h3>You might be interested in these products:</h3>
        <div class="showcase-list">
            <?php
            foreach ($selected_promotions as $promotion)
            {
                echo "<a href='#' class='showcase'>";
                echo $promotion;
                echo "</a>";
            }
            ?>
        </div>
    </div>
</div>

<!-- Footer -->
<div class="stripe dark" id="footer">
    <div class="contain">
        <a href="https://www.google.com/" class="button extra-large">Continue</a>
    </div>
</div>
</body>
</html>

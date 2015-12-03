<?php
//Start of controller
//File fb-requests-index.php for Facebook permission requests

session_start();
date_default_timezone_set('America/Mexico_City');

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
    <!-- Login buttons -->
    <link href='css/auth-buttons.css' rel='stylesheet' type='text/css'>
</head>
<body style="display: none;" data-icon-font="icomoon" data-ui="stripe" data-project-css="welcome.css" data-project-js="min/welcome.min.js" data-formplate-colour="aqua" class="invert">

<!-- Facebook script -->
<script>
    // This is called with the results from from FB.getLoginStatus().
    function statusChangeCallback(response) {
        console.log('statusChangeCallback');
        console.log(response);
        // The response object is returned with a status field that lets the
        // app know the current login status of the person.
        // Full docs on the response object can be found in the documentation
        // for FB.getLoginStatus().
        if (response.status === 'connected') {
            // Logged into your app and Facebook.
            console.log('Logged');
            testAPI();
        } else if (response.status === 'not_authorized') {
            // The person is logged into Facebook, but not your app.
            document.getElementById('status').innerHTML = 'Please log ' +
                'into this app.';
        } else {
            // The person is not logged into Facebook, so we're not sure if
            // they are logged into this app or not.
            document.getElementById('status').innerHTML = 'Please log ' +
                'into Facebook.';
        }
    }

    // This function is called when someone finishes with the Login
    // Button.  See the onlogin handler attached to it in the sample
    // code below.
    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    }

    window.fbAsyncInit = function() {
        FB.init({
            appId      : '282363058604879',
            cookie     : true,  // enable cookies to allow the server to access
            // the session
            xfbml      : true,  // parse social plugins on this page
            version    : 'v2.1' // use version 2.1
        });

        // Now that we've initialized the JavaScript SDK, we call
        // FB.getLoginStatus().  This function gets the state of the
        // person visiting this page and can return one of three states to
        // the callback you provide.  They can be:
        //
        // 1. Logged into your app ('connected')
        // 2. Logged into Facebook, but not your app ('not_authorized')
        // 3. Not logged into Facebook and can't tell if they are logged into
        //    your app or not.
        //
        // These three cases are handled in the callback function.

        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    };

    // Load the SDK asynchronously
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    // Here we run a very simple test of the Graph API after login is
    // successful.  See statusChangeCallback() for when this call is made.
    function testAPI() {
        console.log('Welcome!  Fetching your information.... ');
        FB.api('/me', function(response) {
            //console.log('Successful login for: ' + response.name);
            document.getElementById('status').innerHTML =
                'Thanks for logging in, ' + response.name + '!';
        });
        FB.api('/me/likes', function(response) {
            //console.log(response.data);
            //TODO: Make a conditional to check if this exists
            matchPromotions(response.data);
        });
    }

    //TODO: For testing purposes only, change to the AJAX call to PHP from captive portal instead for a faster response...
    function matchPromotions(user_likes) {
        console.log("on matchPromotions");

        var all_promotions = {
            0: {"name":"Facebook", "content": "<div class='single-promotion'><img src='http://ecx.images-amazon.com/images/I/51i8emtv9PL._SX258_BO1,204,203,200_.jpg'/><p style='font-size: 10px;'>Buy the book \"Ultimate Guide to Facebook Advertising\"</p></div>"},
            1: {"name":"J.K. Rowling", "content": "<div class='single-promotion'><img src='http://www.jkrowling.com/uploads/images/large/en_US-timeline-image-harry-potter-and-the-deathly-hallows-1333632499.jpg'/><p style='font-size: 10px;'>Harry Potter series 50%</p></div>"},
            2: {"name":"Suzanne Collins", "content": "<div class='single-promotion'><img src='http://upload.wikimedia.org/wikipedia/en/a/ab/Hunger_games.jpg'/><p style='font-size: 10px;'>Hunger Games 5% discount</p></div>"},
            3: {"name":"Angry Birds", "content": "<div class='single-promotion'><img src='http://mcdn4.angrybirdsnest.com/wp-content/uploads/2011/12/Angry-Birds-Seasons-Christmas-Comic-Part-25.jpg'/><p style='font-size: 10px;'>Buy Angry Birds and get a free Angry X-Mas bird card</p></div>"}
        };
        var selected_promotions = {};
        var index = 0;
        selected_promotions[index] = all_promotions[0].content;
        index++;

        //Loop through all available promotions
        for (var key_promotion in all_promotions) {
            var promotion = all_promotions[key_promotion];

            for (var key_likes in user_likes) {
                var like = user_likes[key_likes];
                if (promotion.name == like.name) {
                    selected_promotions[index] = promotion.content;
                    //console.log("match" + promotion.name);
                    index++;
                }
            }
        }

        //console.log("+++");
        //console.log(selected_promotions);

        //Erase promotions container
        document.getElementById("promotions_container").innerHTML = "";
        //Add promotions to the showcase
        for (var key_promotion in selected_promotions) {
            var promotion = selected_promotions[key_promotion];
            //console.log(promotion);
            var item = document.createElement("div");
            //item.setAttribute("href", "#");
            item.setAttribute("class", "span-4");//
            item.innerHTML = promotion;
            document.getElementById("promotions_container").appendChild(item);
            //console.log(item);
        }

        //console.log("zxy");
        //Show elements
        document.getElementById("secondary-text").setAttribute("style", "");
        document.getElementById("showcase-container").setAttribute("style", "");
        document.getElementById("secondary-footer").setAttribute("style", "");
        //Hide elements
        document.getElementById("main-text").setAttribute("style", "display: none;");
        document.getElementById("main-footer").setAttribute("style", "display: none;");
        //TODO: Hide the Privacy Policy

        //Refresh the showcase (needed so that the images are shown)
        $.web_wallpaper('.image-hover, .showcase .image');
        window.dispatchEvent(new Event('resize'));
    }
</script>

<!-- Header -->
<header class="stripe full fixed-height">
    <!-- <a href="#" class="navigation-trigger icon-menu"></a> -->
    <div class="contain">
        <div class="text-center-tight">
            <div class="inner">
                <img id="logo" src="images/999.png" alt="No image found."/>
                <br/>
                <h2>Hey there!</h2>
                <br/>
                <div id="main-text">
                    <h5 style="color: white;">Welcome to Walmart Guadalajara! Please log in with Facebook to get free internet access.</h5>
                    <fb:login-button scope="public_profile,email,user_likes" onlogin="checkLoginState();"></fb:login-button>
                    <h5 id="status" style="color: white; margin-top: 10px;"></h5>
                </div>
                <div id="secondary-text" style="display: none;">
                    <h5 style="color: white;">Please like our Facebook page (optional):</h5>
                    <div class="fb-like-box" data-href="https://www.facebook.com/walmart" data-width="200" data-colorscheme="light" data-show-faces="false" data-header="false" data-stream="false" data-show-border="false"></div>
                    <h5 style="color: white; margin-top: 10px;">And scroll down<br/>to continue</h5>
                </div>
            </div>
        </div>
        <!-- <a href="#" class="scroll-down icon-angle-down"></a> -->
    </div>
    <div class="bg-image"></div>
</header>

<!-- Test showcase -->
<div id='showcase-container' class="stripe" style="display: none;">
    <h3>You might be interested in these products:</h3>
    <div id="promotions_container" class="row"></div>
</div>

<!-- Footer -->
<div class="stripe dark padding-3" id="footer">
    <div id="main-footer" class="contain text-center">
        <p style="font-size: 12px; font-family: Helvetica, 'Trebuchet MS', sans-serif">See our <a href="ap.php">Privacy Policy</a>.</p>
        <h5>Enera Free WiFi</h5>
    </div>
    <div id="secondary-footer" class="contain" style="display: none;">
        <a href="https://www.google.com/" class="button extra-large">Continue</a>
    </div>
</div>

</body>
</html>
<?php
//No longer used...
/**
 * Created by PhpStorm.
 * User: adelriosantiago
 * Date: 11/4/14
 * Time: 4:08 PM
 */

require 'fbconfig.php'; //Get the facebook information

//List of available promotions (TODO: This information should be obtained from a database instead of a variable)
$all_promotions = array(
    "J.K. Rowling" => "<li><img src='http://www.jkrowling.com/uploads/images/large/en_US-timeline-image-harry-potter-and-the-deathly-hallows-1333632499.jpg' style='max-width: 200px;'/><div><h4>Harry Potter series 50%</h4></div></li>",
    "Suzanne Collins" => "<li><img src='http://upload.wikimedia.org/wikipedia/en/a/ab/Hunger_games.jpg' style='max-width: 200px;'/><div><h4>Hunger Games 5% discount</h4></div></li>",
    "Angry Birds" => "<li><img src='http://mcdn4.angrybirdsnest.com/wp-content/uploads/2011/12/Angry-Birds-Seasons-Christmas-Comic-Part-25.jpg' style='max-width: 200px;'/><div><h4>Buy Angry Birds and get a free Angry X-Mas bird card</h4></div></li>",
);

$selected_promotions = array(
    "<li><img src='http://ecx.images-amazon.com/images/I/51i8emtv9PL._SX258_BO1,204,203,200_.jpg' style='max-width: 200px;'/><div><h4>Buy the book \"Ultimate Guide to Facebook Advertising: How to <br/>Access 1 Billion Potential Customers in 10 Minutes\" (Ultimate Series)</h4></div></li>"
);

//Process fb_user_likes variable to get the recommendations
foreach($all_promotions as $key => $promotion) {
    foreach ($fb_user_likes as $user_like) {
        if ($key == $user_like['name'])
        {
            array_push($selected_promotions, $promotion);
        }
    }
}
?>

<!doctype html>
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/video-js.css" rel="stylesheet" type="text/css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <style>
        .container{ background-color:#ffffff; font-family: 'Gill Sans', Geneva, sans-serif }
    </style>
</head>
<body>
    <div class="container">
        <table class="not_connected">
            <tr>
                <td>
                    <?php echo '<img class="logo" src="images/999.png">'; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>Thanks, here are some product recommendations for you:</h3>
                </td>
            </tr>
            <tr>
                <td>
                    <ul style="list-style: none;">
                        <?php
                            foreach ($selected_promotions as $promotion) {
                                echo $promotion;
                                echo "<br/>";
                            }
                        ?>
                    </ul>
                </td>
            </tr>
            <tr>
                <td>
                    <h3>None of your friends is currently on the store</h3>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="https://www.google.com" class="fb_access">Continue</a>
                    <br/>
                    <br/>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
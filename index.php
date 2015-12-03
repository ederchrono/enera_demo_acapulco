<?php //Start of controller

//...

//End of controller ?>
<!DOCTYPE html>
<html>
<head>
    <!-- Meta setup - Required for apple device -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="project/img/welcome/favicon.png" />
    <!-- Title -->
    <title>Metro DF Wi-Fi</title>
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

<div class="stripe" id="stripe-showcase">
    <div class="contain">
        <h3 style="text-align: center;">Portales de demostración Cinépolis</h3>
        <div class="row">
            <div class="span-3">
                <a id='like' href="#" class="showcase">
                    <img src="images/temporal/like.png" alt=""/>
                    <h4 style="text-align: center;">Like simple</h4>
                </a>
            </div>
            <div class="span-3">
                <a id='banner' href="#" class="showcase">
                    <img src="images/temporal/banner.png" alt=""/>
                    <h4 style="text-align: center;">Banner</h4>
                </a>
            </div>
            <div class="span-3">
                <a id='video' href="#" class="showcase">
                    <img src="images/temporal/video.png" alt=""/>
                    <h4 style="text-align: center;">Video</h4>
                </a>
            </div>
            <div class="span-3">
                <a id='encuesta' href="#" class="showcase">
                    <img src="images/temporal/survey.png" alt=""/>
                    <h4 style="text-align: center;">Encuestas</h4>
                </a>
            </div>
            <!-- <div class="span-3">
                <a id='like' href="#" class="showcase">
                    <div class="image" data-wallpaper="images/temporal/like.png">
                        <div class="caption"><h6>Like simple</h6></div>
                    </div>
                </a>
            </div>
            <div class="span-3">
                <a id='banner' href="#" class="showcase">
                    <div class="image" data-wallpaper="images/temporal/banner.png">
                        <div class="caption"><h6>Banner</h6></div>
                    </div>
                </a>
            </div>
            <div class="span-3">
                <a id='video' href="#" class="showcase">
                    <div class="image" data-wallpaper="images/temporal/video.png">
                        <div class="caption"><h6>Video</h6></div>
                    </div>
                </a>
            </div>
            <div class="span-3">
                <a id='encuesta' href="#" class="showcase">
                    <div class="image" data-wallpaper="images/temporal/survey.png">
                        <div class="caption"><h6>Encuesta</h6></div>
                    </div>
                </a>
            </div>-->
            <!--
            <div class="span-2">
                <a id='promotion' href="#" class="showcase">
                    <div class="image" data-wallpaper="images/temporal/promos.png">
                        <div class="caption"><h6>Tienda</h6></div>
                    </div>
                </a>
            </div>
            <div class="span-2">
                <a id='sugerencia' href="#" class="showcase">
                    <div class="image" data-wallpaper="images/temporal/feedback.png">
                        <div class="caption"><h6>Sugerencia</h6></div>
                    </div>
                </a>
            </div>
            -->
            <!--  -->
            <!-- <div class="span-2">
                <img src="" alt=""/>
                <a id='like' href="#" class="showcase">
                    <div class="image" data-wallpaper="images/temporal/like.png">
                        <div class="caption"><h6>Like simple</h6></div>
                    </div>
                </a>
            </div> -->
        </div>
    </div>
</div>

<!-- Footer -->
<div class="stripe dark padding-3" id="footer" style="background-color: #000;">
    <div id="main-footer" class="contain text-center">
        <img src="images/logo_enera_blanco.png" style="max-width: 150px;">
    </div>
</div>

<script>
    var wnd_handle;
    var force_portal;
    var force_id_branch;

    var button1 = document.getElementById("like");
    button1.addEventListener("click",function(e){
        var settings = '_blank", "location=no, menubar=no, status=no, toolbar=no, scrollbars=yes, resizable=no, top=100, left=100, width=500, height=600'; //Assume smartphone settings
        force_portal = 1;
        force_id_branch = 1003;
        reload_window(settings);
    },false);

    var button2 = document.getElementById("banner");
    button2.addEventListener("click",function(e){
        var settings = '_blank", "location=no, menubar=no, status=no, toolbar=no, scrollbars=yes, resizable=no, top=100, left=100, width=500, height=600'; //Assume smartphone settings
        force_portal = 2;
        force_id_branch = 1003;
        reload_window(settings);
    },false);

    var button3 = document.getElementById("video");
    button3.addEventListener("click",function(e){
        var settings = '_blank", "location=no, menubar=no, status=no, toolbar=no, scrollbars=yes, resizable=no, top=100, left=100, width=500, height=600'; //Assume smartphone settings
        force_portal = 3;
        force_id_branch = 1003;
        reload_window(settings);
    },false);

    var button4 = document.getElementById("encuesta");
    button4.addEventListener("click",function(e){
        var settings = '_blank", "location=no, menubar=no, status=no, toolbar=no, scrollbars=yes, resizable=no, top=100, left=100, width=500, height=600'; //Assume smartphone settings
        force_portal = 4;
        force_id_branch = 1003;
        reload_window(settings);
    },false);

    var button5 = document.getElementById("promotion");
    button5.addEventListener("click",function(e){
        var settings = '_blank", "location=no, menubar=no, status=no, toolbar=no, scrollbars=yes, resizable=no, top=100, left=100, width=500, height=600'; //Assume smartphone settings
        force_portal = 5;
        force_id_branch = 1003;
        reload_window(settings);
    },false);

    var button6 = document.getElementById("sugerencia");
    button6.addEventListener("click",function(e){
        var settings = '_blank", "location=no, menubar=no, status=no, toolbar=no, scrollbars=yes, resizable=no, top=100, left=100, width=500, height=600'; //Assume smartphone settings
        force_portal = 6;
        force_id_branch = 1003;
        reload_window(settings);
    },false);


    function reload_window(settings) {
        var full_path = 'http://sandbox.enera-intelligence.mx/demos/cinepolis/portal.php?force_portal=' + force_portal + '&force_id_branch=' + force_id_branch;

        if (wnd_handle != null) {
            wnd_handle.close();
        }
        wnd_handle = window.open(full_path, '_blank', settings);
    }
</script>

</body>
</html>

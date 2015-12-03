<?php //Start of controller
$_SESSION['type'] = "video";

$view_data = null; //Assume it is empty
if ($stmt = $mysqli->prepare("SELECT view_data FROM `company_views` WHERE `id_branch` = ? AND `data_type` = 'video'")) {
    $stmt->bind_param("i", $id_branch);
    $stmt->execute();
    $stmt->bind_result($view_data);
    $stmt->fetch();
    $stmt->close();
} else {
    $video_path = 'test'; //If an error occurred show a sample video
}

$view_data = json_decode($view_data);
$video_path = $view_data->video_href;

//End of controller ?>

<!-- Header with the like box -->
<?php /*include 'page/section/header_like.php';*/ ?>

<header class="stripe full fixed-height">
    <div class="contain">
        <div class="text-center-tight">
            <div class="inner">
                <h3 class="margin-bottom-20 margin-top-20" style="text-shadow: 1px 1px #000000;">Para tener internet por favor ve este video:</h3>
                <div class="margin-bottom-20">
                    <video id="video" class="video-js vjs-default-skin" controls preload="true" width="100%" height="300" poster="images/<?= $id_branch ?>.png" data-setup='{}'>
                        <source src="videos/<?= $video_path ?>" type='video/mp4'>
                        <p class="vjs-no-js">
                            To view this video please enable JavaScript, and consider upgrading to a web browser
                            that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                        </p>
                    </video>
                </div>
                <div id='countdown'></div>
                <button id='navigate_button' type="submit" class="btn-download" style="display: none;">Navegar en Internet</button>
            </div>
        </div>
    </div>
    <div class="bg-image" style="background-image: url('images/<?= $id_branch ?>-bg.jpg');"></div>
    <!-- TODO: Add a "See more" text on the side of the button -->
    <!-- <a id="scroller-down" href="#" class="scroll-down"><i class="fa fa-arrow-down"></i></a> -->
</header>

<!-- Load the like footer -->
<?php include 'page/section/like_footer.php'; ?>

<!-- Footer -->
<?php include 'page/section/footer.php'; ?>

<script>
    var player = videojs('video', { /* Options */ }, function() {
        //this.play(); // if you don't trust autoplay for some reason
    });

    //Show button when the video stops playing
    player.on('ended', function() {
        document.getElementById('navigate_button').style.display = ''; //Show the button by removing the "display: none;" rule
    });

    //Timer functionality, uncomment to enable seeing only X seconds of a video after showing the button
    /*
     var interval;
     var minutes = 0;
     var seconds = 10;
     window.onload = function() {
     countdown('countdown');
     }

     function countdown(element) {
     interval = setInterval(function() {
     var el = document.getElementById(element);
     if(seconds == 0) {
     if(minutes == 0) {
     document.getElementById('send-survey').style.display = ''; //Show the button by removing the "display: none;" rule
     document.getElementById('countdown').style.display = 'none';
     clearInterval(interval);
     return;
     } else {
     minutes--;
     seconds = 60;
     }
     }
     if(minutes > 0) {
     var minute_text = minutes + (minutes > 1 ? 'minutos' : 'minutos');
     } else {
     var minute_text = '';
     }
     var second_text = seconds > 1 ? 'segundos' : 'segundo';
     el.innerHTML = 'Podrás navegar en internet en ' + minute_text + ' ' + seconds + ' ' + second_text;
     seconds--;
     }, 1000);
     }*/
</script>

<?php

/**
 * Login_method.php
 * Login methods for the Enera Intellignece captive portals
 *
 * Login methods available for the Enera Intelligence captive portals. Currently:
 * Facebook Like (1) -- Implemented
 * Video (2) -- Partially Implemented
 * Add/Banner (3) -- Not implemented
 * Survey (4) -- Not implemented
 *
 * @author Luis Gerardo Martín del Campo <lmartin@enera.mx>
 * 
 */

include('dbconfig.php');
include_once('./constants.php');

date_default_timezone_set('America/Mexico_City');

session_start();
$_SESSION['ap_mac'] = $ap_mac;
$_SESSION['user_mac'] = $client_mac;
$_SESSION['user_fb_id'] = $fb_id;
$_SESSION['id_branch'] = $id_branch;
$_SESSION['id_group'] = $id_group;
$_SESSION['content'] = "";

$cmonstr = "monetize_logs";
$typestr = "type";
$type_idstr = "type_id";
$like = "like";
$fb_idstr = "user_fb_id";

//$response_string = "Bienvenido " . $fb_fullname . "!";
$response_string = "Welcome " . $fb_fullname . "!";

$status = 5;


/*if ($status == "1") {
    if ($stmt = $mysqli->prepare("SELECT `timestamp` FROM $cmonstr WHERE $fb_idstr = ? AND $typestr = ? AND $type_idstr = ? ")) {
        $stmt->bind_param("sss", $fb_id, $like, $branch_fb_pageid);
        $stmt->execute();
        $stmt->bind_result($tmp);
        $stmt->fetch();
        $stmt->close();
    } else {
        trigger_error($mysqli->error, E_USER_ERROR);
    }

    //$mysqli->close(); //Commented, seems to deny the next query

    //We redirect the user if he already liked the page
    if ($tmp != 0) {
        header('Location: '.$success_url);
    }
}*/
?>

<?php if ($status == "1") : //Facebook Like login ?>
    <?php
    $_SESSION['type'] = "like";
    $_SESSION['type_id'] = $branch_fb_pageid;

    $company_views = "company_views"; //FIXME: This should be on a const file
    $str_sv = "sv";
    $id_view = "";
    $view_data = "";

    if ($stmt = $mysqli->prepare("SELECT `view_data`, `id` FROM $company_views WHERE `id_branch` = ? AND `data_type` = ?")) {
        $stmt->bind_param("is", $id_branch, $str_sv);
        $stmt->execute();
        $stmt->bind_result($view_data, $id_view);
        $stmt->fetch();
        $stmt->close();

        $_SESSION['id_view'] = $id_view;
    } else {
        trigger_error($mysqli->error, E_USER_ERROR);
    }

    $mysqli->close();

    $data_object = json_decode($view_data);
    $fb_url_settings[0] = $data_object->show_faces;
    $fb_url_settings[1] = $data_object->header;
    $fb_url_settings[2] = $data_object->stream;
    $fb_url_settings[3] = $data_object->show_border;
    $fb_url_settings[4] = $data_object->colorscheme;
    //TODO: Add the success_url and facebook_url page here
    ?>

    <div class="container">
      <table class="not_connected">
        <tr>
          <?php echo '<td><img class="logo" src="images/' . $id_branch . '.png"></td>'; ?>
        </tr>
        <tr>
          <td><h3><?=$response_string?></h3></td>
        </tr>
        <tr>
          <td>
              <!-- <div class="message" style="margin:12px 0 12px 0;">Adicionalmente puedes dar like</div> -->
              <div class="message" style="margin:12px 0 12px 0;">Please like our page (optional)</div>
              <!-- <div class="hider"> -->
                <!-- Old line, the new iframe may cause an error -->
                <fb:like href="<?php echo $branch_fb_url; ?>" width="300" layout="box_count" action="like" show_faces="false" share="false"></fb:like>
              <!-- </div> -->
              <div class="message" style="margin:12px 0 12px 0;">Or</div>
              <!-- <div class="shower"><a href="<?php /*echo $success_url; */?>"><button>Continue</button></a></div> -->
              <a href="<?php echo $success_url; ?>" class="fb_access">Continue</a>
              <br/>
          </td>
        </tr>
      </table>
    </div>

<?php elseif ($status == "2") : //Video login ?>
    <?php
        $_SESSION['type'] = "video";
        $_SESSION['type_id'] = "video_1"; //Needs to be configured to accept random ads videos
    ?>

    <div class="container">
        <div class="container_video">
        <video id="video" class="video-js vjs-default-skin" controls preload="true" autoplay="true" width="90%" height="90%"
            poster="<?php echo $video_url; ?>"
            data-setup="{}">
            <source src="<?php echo $video_url; ?>" type='video/mp4' />
        </video>
        </div>
        <div class="message">Podrás navegar al terminar el video</div>
        <div class="shower"><a href="<?php echo $success_url; ?>"><button>Navegar en Internet</button></a></div>
    </div>

    <?php elseif ($status == "3") : //Add Login ?>

    <?php
        $_SESSION['type'] = "banner";
    ?>

    <div class="container">
        <div class="container_image">
            <a href=""><img src=""></a>
        </div>
        <div class="message">Podrás navegar al dar click en el banner</div>
    </div>
  
<?php elseif ($status == "4") : //Survey login ?>

    <?php
        //$_SESSION['type'] = "video";
        //$_SESSION['type_id'] = "video_1";

        $company_views = "company_views"; //FIXME: This should be on a const file
        $str_sv = "sv";
        $id_view = "";
        $filter = ""; //Assume empty filter

        echo $id_branch;

        if ($stmt = $mysqli->prepare("SELECT `view_data`, `id`, `filter` FROM $company_views WHERE `id_branch` = ? AND `data_type` = ?")) {
            $stmt->bind_param("is", $id_branch, $str_sv);
            $stmt->execute();
            $stmt->bind_result($view_data, $id_view, $filter);

            $cont = 0;
            while ($stmt->fetch()) {
                $survey[$cont] = array(
                    "view_data" => $view_data,
                    "id_view" => $id_view,
                    "filter" => $filter,
                );
                $cont++;
            }

            $stmt->close();

            $_SESSION['id_view'] = $id_view;
        } else {
            trigger_error($mysqli->error, E_USER_ERROR);
        }

        //TODO: Get the appropiate survey to show
        //var_dump($survey);

        $client_date = getdate();
        $client_day = $client_date['wday'];
        $client_hour = 1 << (HOUR_BIT_SHIFTER + $client_date['hours']);

        $client_recurrent = 0; //TODO: Define this value
        $client_gender = 0; //TODO: Define this value

        $current_filter = $client_day | $client_hour; //TODO: Add the other filters gender | recurrent | etc
        //var_dump($client_date['hours']);

        $best_match = 0;
        $highest_match = 0;

        for ($i = 0; $i < count($survey); $i++)
        {
            echo $i . " operation " . $current_filter . " & " . $survey[$i]['filter'] . " scores " . ($current_filter & $survey[$i]['filter']) . "\n";
            if ($current_filter & $survey[$i]['filter'])
            {
                $bit_count = getBitCount($survey[$i]['filter']);
                if ($bit_count > $highest_match)
                {
                    $highest_match = $bit_count;
                    $best_match = $i;
                }
                //echo $i . " operation " . $current_filter . " & " . $survey[$i]['filter'] . " score " . $bit_count . "\n";
            }
        }

        //Survey final step to decode info
        $data_object = json_decode($survey[$best_match]['view_data']);

        $mysqli->close();
    ?>

    <div class="container">
        <table class="not_connected">
            <form action="save_survey.php" method="POST">
                <tr>
                    <?php echo '<td><img class="logo" src="images/' . $id_branch . '.png"></td>'; ?>
                </tr>
                <tr>
                    <td>
                        <h3><?= $response_string ?></h3>
                        <p>Podrás navegar después de contestar la siguiente encuesta:</p>
                        <div class="question-1">
                            <br/>
                            <h5 class="title"><?= $data_object->{'question-1'}[0] ?></h5>
                            <input type="hidden" name="entry1-title" value="<?= $data_object->{'question-1'}[0] ?>"/>
                            <?php
                            //var_dump($data_object);

                            $count = count($data_object->{'question-1'});
                            for ($item = 1; $item < $count; $item++) {
                                $option = $data_object->{'question-1'}[$item];
                                if ($option) {
                                    echo "<label class='radio-inline interaction-'$item>";
                                        echo "<input class='icheck' type='radio' checked='' name='entry1-answer' value='". $option ."'/>";
                                        echo "<span name='text'>$option</span>";
                                    echo "</label>";
                                    echo "<br/>";
                                }
                            }
                            ?>
                        </div>
                        <div class="question-2">
                            <br/>
                            <h5 class="title"><?= $data_object->{'question-2'}[0] ?></h5>
                            <input type="hidden" name="entry2-title" value="<?= $data_object->{'question-2'}[0] ?>"/>
                            <?php
                            $count = count($data_object->{'question-2'});
                            for ($item = 1; $item < $count; $item++) {
                                $option = $data_object->{'question-2'}[$item];
                                if ($option) {
                                    echo "<label class='radio-inline interaction-'$item>";
                                        echo "<input class='icheck' type='radio' checked='' name='entry2-answer' value='". $option ."'/>";
                                        echo "<span name='text'>$option</span>";
                                    echo "</label>";
                                    echo "<br/>";
                                }
                            }
                            ?>
                        </div>
                        <div class="question-3">
                            <br/>
                            <h5 class="title"><?= $data_object->{'question-3'}[0] ?></h5>
                            <input type="hidden" name="entry3-title" value="<?= $data_object->{'question-3'}[0] ?>"/>
                            <?php
                            $count = count($data_object->{'question-3'});
                            for ($item = 1; $item < $count; $item++) {
                                $option = $data_object->{'question-3'}[$item];
                                if ($option) {
                                    echo "<label class='radio-inline interaction-'$item>";
                                        echo "<input class='icheck' type='radio' checked='' name='entry3-answer' value='". $option ."'/>";
                                        echo "<span name='text'>$option</span>";
                                    echo "</label>";
                                    echo "<br/>";
                                }
                            }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <!-- <div><a href="http://www.google.com"><button>Navegar en Internet</button></a></div> -->
                        <br/>
                        <div><input type="submit" value="Navegar en Internet"></div>
                        <br/>
                    </td>
                </tr>
            </form>
        </table>
    </div>
<?php endif ?>

<?php
    function getBitCount($value) {
        $count = 0;
        while($value)
        {
            $count += ($value & 1);
            $value = $value >> 1;
        }
        return $count;
    }
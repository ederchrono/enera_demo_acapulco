<?php
//Start of controller
session_start();
$_SESSION['type'] = "like";
$_SESSION['content'] = ""; //TODO: Remove hard-code when there is a use for content field

$company_views = "company_views"; //FIXME: This should be on a const file
$id_view = "";
$filter = ""; //Assume empty filter

if ($stmt = $mysqli->prepare("SELECT `view_data`, `id`, `filter` FROM $company_views WHERE `id_branch` = ? AND `data_type` = 'survey'")) {
    $stmt->bind_param("i", $id_branch);
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
} else {
    trigger_error($mysqli->error, E_USER_ERROR);
}

//TODO: Get the appropiate survey to show
$client_date = getdate();
$client_day = $client_date['wday'];
$client_hour = 1 << (HOUR_BIT_SHIFTER + $client_date['hours']);

$client_recurrent = 0; //TODO: Define this value

if ($fb_gender == 'female') {
    $client_gender = FEMALE_BIT;
} else if ($fb_gender == 'male') {
    $client_gender = MALE_BIT;
}

$current_filter = $client_day | $client_hour | $client_gender; //TODO: Add the other filters gender | recurrent | etc

$best_match = 0;
$highest_match = 0;

for ($i = 0; $i < count($survey); $i++)
{
    //echo $i . " operation " . $current_filter . " & " . $survey[$i]['filter'] . " scores " . ($current_filter & $survey[$i]['filter']);
    //echo "<br/>";

    //$select_random_survey = true; //TODO: Implement a way to select a random survey

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

$survey_answers = "survey_answers"; //FIXME: This should be on a const file
$id_view = "";

if ($stmt = $mysqli->prepare("SELECT `id_view` FROM $survey_answers WHERE `id_branch` = ? AND `user_mac` = ?")) {
    $stmt->bind_param("is", $id_branch, $user_mac);
    $stmt->execute();
    $stmt->bind_result($id_view);

    $cont = 0;
    while ($stmt->fetch()) {
        $answered_surveys[$cont] = array(
            "id_view" => $id_view,
        );
        $cont++;
    }

    $stmt->close();
} else {
    trigger_error($mysqli->error, E_USER_ERROR);
}

$_SESSION['type_id'] = $id_view;

$select_random_survey = false;
for ($q = 0; $q < count($answered_surveys); $q++) {
    //echo $answered_surveys[$q]['id_view'];
    if ($survey[$best_match]['id_view'] == $answered_surveys[$q]['id_view']) {
        $select_random_survey = true;
    }
}

if ($select_random_survey) {
    $random_survey = rand(0, count($survey) - 1);
    //echo "selecting random survey $random_survey";
    $data_object = json_decode(utf8_encode($survey[$random_survey]['view_data']));
    $_SESSION['id_view'] = $survey[$random_survey]['id_view'];
} else {
    //echo "selecting best match";
    $data_object = json_decode(utf8_encode($survey[$best_match]['view_data']));
    $_SESSION['id_view'] = $survey[$best_match]['id_view'];
}

$mysqli->close();

//End of controller
?>

<header id="small-header" class="stripe">
    <div class="contain">
        <div class="row">
            <div class="span-2"><br/></div>
            <div class="span-8">
                <h3 class="enera-white-color" style="text-shadow: 1px 1px #000000;">Por favor contesta las siguientes 3 preguntas para tener internet.</h3>
            </div>
            <div class="span-2"><br/></div>
        </div>
    </div>
    <div class="bg-image" style="background-image: url('images/<?= $id_branch ?>-bg.jpg');"></div>
    <!-- <a id="scroller-down" href="#" class="scroll-down"><i class="fa fa-arrow-down"></i></a> -->
</header>

<div class="stripe">
    <div class="container">
        <div class="not_connected">
            <form action="#" method="POST">
                <input type="hidden" name="success_url" value="<?= $success_url ?>"/>
                <!-- TODO: Erase tr's and td's -->
                <div class="text-center">
                    <div id='checkboxes-container'>
                        <div class="question-1">
                            <br/>
                            <h5 class="title bold"><?= $data_object->{'question-1'}[0] ?></h5>
                            <input type="hidden" name="entry1-title" value="<?= $data_object->{'question-1'}[0] ?>"/>
                            <?php
                            $count = count($data_object->{'question-1'});
                            for ($item = 1; $item < $count; $item++) {
                                $option = $data_object->{'question-1'}[$item];
                                if ($option) {
                                    echo "<div class='fp-colour-red'>";
                                    echo "<div class='formplate radio-inline big-radio interaction-$item'>";
                                    echo "<input class='icheck' type='radio' name='entry1-answer' value='". $option ."' id='". $option ."'/>";
                                    echo "<label for='" . $option . "' name='text'>$option</span>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "<br/>";
                                }
                            }
                            ?>
                        </div>
                        <div class="question-2">
                            <br/>
                            <h5 class="title bold"><?= $data_object->{'question-2'}[0] ?></h5>
                            <input type="hidden" name="entry2-title" value="<?= $data_object->{'question-2'}[0] ?>"/>
                            <?php
                            $count = count($data_object->{'question-2'});
                            for ($item = 1; $item < $count; $item++) {
                                $option = $data_object->{'question-2'}[$item];
                                if ($option) {
                                    echo "<div class='fp-colour-red'>";
                                    echo "<div class='formplate radio-inline big-radio interaction-$item'>";
                                    echo "<input class='icheck' type='radio' name='entry2-answer' value='". $option ."' id='". $option ."'/>";
                                    echo "<label for='" . $option . "' name='text'>$option</span>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "<br/>";
                                }
                            }
                            ?>
                        </div>
                        <div class="question-3">
                            <br/>
                            <h5 class="title bold"><?= $data_object->{'question-3'}[0] ?></h5>
                            <input type="hidden" name="entry3-title" value="<?= $data_object->{'question-3'}[0] ?>"/>
                            <?php
                            $count = count($data_object->{'question-3'});
                            for ($item = 1; $item < $count; $item++) {
                                $option = $data_object->{'question-3'}[$item];
                                if ($option) {
                                    echo "<div class='fp-colour-red'>";
                                    echo "<div class='formplate radio-inline big-radio interaction-$item'>";
                                    echo "<input class='icheck' type='radio' name='entry3-answer' value='". $option ."' id='". $option ."'/>";
                                    echo "<label for='" . $option . "' name='text'>$option</span>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "<br/>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="text-center">
                        <br/>
                        <br/>
                        <button id='navigate_button' type="submit" class="btn-download" style="display: none;">Navegar en Internet</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Load the like footer -->
<?php include 'page/section/like_footer.php'; ?>

<!-- Footer -->
<?php include 'page/section/footer.php'; ?>

<script>
    var theParent = document.getElementById('checkboxes-container');
    theParent.addEventListener("click", doSomething, false);

    function doSomething(event) {
        if (theParent.getElementsByClassName('checked').length >= 3) {
            document.getElementById('navigate_button').style.display = ''; //Show the button by removing the "display: none;" rule
        }
        event.stopPropagation();
    }
</script>

<?php
//Start of controller
$_SESSION['type'] = "promotion";

$str_pr = 'pr'; //TODO: Change to a constant files
$id_branch = 576; //TODO: Replace with the actual value
$promotions = array();

if ($stmt = $mysqli->prepare("SELECT `view_data`, `id`, `filter` FROM `company_views` WHERE `id_branch` = ? AND `data_type` = ?")) {
    $stmt->bind_param("is", $id_branch, $str_pr);
    $stmt->execute();
    $stmt->bind_result($view_data, $id_view, $filter);

    $cont = 0;
    while ($stmt->fetch()) {
        $promotions[$cont] = array(
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

$matching_promotions = array();
$match_count = 0;

foreach ($promotions as $single_promotion) {
    $view_data = json_decode($single_promotion['view_data']);

    foreach ($fb_user_likes as $like) {
        if ($like['name'] == $view_data->name) {
            //echo "match: " . $like['name'];
            $matching_promotions[$match_count] = $view_data->content;
            $match_count++;
        }
    }
}

//End of controller
?>

<!-- Header with the like box -->
<?php include 'page/section/header_like.php'; ?>

<!-- Test showcase -->
<div id='showcase-container' class="stripe">
    <h3>Estas promociones te pueden interesar:</h3>
    <div id="promotions_container" class="row">
        <?php
        foreach ($matching_promotions as $item) {
            echo "<div class='span-4'>";
            echo $item;
            echo "</div>";
        }
        ?>
    </div>
</div>

<!-- Promotions showcase -->
<div id='showcase-container' class="stripe" style="display: none;">
    <h3>You might be interested in these products:</h3>
    <div id="promotions_container" class="row"></div>
</div>

<!-- Load the like footer -->
<?php include 'page/section/like_footer.php'; ?>

<!-- Footer -->
<?php include 'page/section/footer.php'; ?>
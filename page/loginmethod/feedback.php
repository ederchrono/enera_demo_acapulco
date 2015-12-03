<?php
//Start of controller

$_SESSION['type'] = "feedback";

$str_fd = 'fd'; //TODO: Change to a constant files
$id_branch = 576; //TODO: Replace with the actual value

$id_view = 0;
$view_data = '';
$filter = '';

if ($stmt = $mysqli->prepare("SELECT `id`, `view_data`, `filter` FROM `company_views` WHERE `id_branch` = ? AND `data_type` = ?")) {
    $stmt->bind_param("is", $id_branch, $str_fd);
    $stmt->execute();
    $stmt->bind_result($id_view, $view_data, $filter);
    $stmt->fetch();
    $stmt->close();
} else {
    trigger_error($mysqli->error, E_USER_ERROR);
}

$view_data = json_decode($view_data);
$feedback_name = $view_data->name;

//End of controller
?>

<!-- Header with the like box -->
<?php include 'page/section/header_like.php'; ?>

<!-- Test showcase -->
<div class="stripe">
    <h3>Tu opinion es importante para nosotros:</h3>
    <div class="formplate">
        <?= $feedback_name ?>
        <textarea placeholder="Tu opinion"></textarea>
    </div>
</div>

<!-- Load the like footer -->
<?php include 'page/section/like_footer.php'; ?>

<!-- Footer -->
<?php include 'page/section/footer.php'; ?>
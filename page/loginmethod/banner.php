<?php //Start of controller
$_SESSION['type'] = "banner";

$view_data = null; //Assume it is empty
if ($stmt = $mysqli->prepare("SELECT view_data FROM `company_views` WHERE `id_branch` = ? AND `data_type` = 'banner'")) {
    $stmt->bind_param("i", $id_branch);
    $stmt->execute();
    $stmt->bind_result($view_data);
    $stmt->fetch();
    $stmt->close();
} else {
    trigger_error($mysqli->error, E_USER_ERROR);
}

$view_data = json_decode(utf8_encode($view_data));
$link_url = $view_data->link_url;
$link_text = $view_data->link_text;
$link_href = $view_data->link_href;

//echo "data: $id_branch";
//var_dump($view_data);
//var_dump($id_branch);

//End of controller ?>

<!-- Header with the like box -->
<!-- This view is no longer used erase on next release -->
<?php /*include 'page/section/header_like.php';*/ ?>

<!-- TODO: MVC'ify this part -->
<header class="stripe full fixed-height">
    <div class="contain">
        <div class="text-center-tight">
            <div class="inner">
                <h3 class="margin-bottom-20 margin-top-20" style="text-shadow: 1px 1px #000000;">Anuncio de nuestros patrocinadores:</h3>
                <div class="margin-bottom-20">
                    <div id="promotions_container">
                        <div class="single-promotion">
                            <div class="row">
                                <div class="span-12">
                                    <!-- Use the first line when there is a way to upload images on the server -->
                                    <a href="<?= $link_href ?>"><img src="<?= $link_url ?>" style="width: 100%; max-width: 250px; display: block; margin: 3px auto;"/></a>
                                </div>
                            </div>
                            <p style="font-size: 15px; color: white; text-shadow: 1px 1px #000000;"><?= $link_text ?></p>
                        </div>
                    </div>
                </div>
                <div id='countdown'></div>
                <button id='navigate_button' type="submit" class="btn-download">Navegar en Internet</button>
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

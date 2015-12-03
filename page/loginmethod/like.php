<?php //Start of controller

//Should we include db_connect?

$view_data = null; //Assume it is empty
if ($stmt = $mysqli->prepare("SELECT view_data FROM `company_views` WHERE `data_type` = 'fb' AND `id_branch` = ?")) {
    $stmt->bind_param("i", $id_branch);
    $stmt->execute();
    $stmt->bind_result($view_data);
    $stmt->fetch();
    $stmt->close();
} else {
    $fb_url_to_show = $branch_fb_url; //If an error ocurred
}

$view_data = json_decode($view_data);

//If some values from view_data are not set, set them to a default value
//TODO: Sanitize these values!
if (empty($view_data->fb_url)) { $fb_url_to_show = $branch_fb_url; } else { $fb_url_to_show = $view_data->fb_url; }
if (empty($view_data->success_url)) { $success_url_to_show = $branch_fb_url; } else { $success_url_to_show = $view_data->success_url; }
if (empty($view_data->show_faces)) { $show_faces = false; } else { $show_faces = $view_data->show_faces; }
if (empty($view_data->header)) { $header = false; } else { $header = $view_data->header; }
if (empty($view_data->stream)) { $stream = false; } else { $stream = $view_data->stream; }
if (empty($view_data->show_border)) { $show_border = false; } else { $show_border = $view_data->show_border; }

//End of controller ?>
<!-- Header TODO: Use the same header on page/section/header.php -->
<header class="stripe full fixed-height">
    <div class="contain">
        <div class="text-center-tight">
            <div class="inner">
                <h2 style="text-shadow: 1px 1px #000000;">Hola <?= $fb_fullname ?>!</h2>
                <!-- <h5 class="enera-white-color margin-top-50" style="text-shadow: 1px 1px #000000;">Regálanos un like (opcional):</h5> -->
                <div class="fb-like-box" data-href="<?= $fb_url_to_show ?>" data-width="300" data-colorscheme="light" data-show-faces="<?= $show_faces ?>" data-header="<?= $header ?>" data-stream="<?= $stream ?>" data-show-border="<?= $show_border ?>"></div>
                <h5 class="enera-white-color margin-top-50">Y da click en:</h5>
                <button id='navigate_button' success_url="<?= $success_url_to_show ?>" type="submit" class="btn-download">Navegar en Internet</button>
            </div>
        </div>
    </div>
    <div class="bg-image" style="background-image: url('images/<?= $id_branch ?>-bg.jpg');"></div>
</header>

<!-- Footer -->
<?php include 'page/section/footer.php'; ?>
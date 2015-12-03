<?php //Start of controller

//...

//End of controller ?>
<!-- Header -->
<header class="stripe full fixed-height">
    <!-- <a href="#" class="navigation-trigger icon-menu"></a> -->
    <div class="contain">
        <div class="text-center-tight">
            <div class="inner">
                <!-- <h5 class='enera-white-color margin-top-20'>Te damos la bienvenida a la red Wifi patrocinada por:</h5> -->
                <!-- TODO: Remove hard-code and read image from images/$id_branch when testing is done -->
                <img id="logo" src="images/<?= $id_branch ?>.png" alt="No image found."/>
                <div id="main-text">
                    <h5 style="color: white;"><?php echo utf8_encode($branch_message); ?></h5>
                    <br/><br/>
                    <!-- <img id="logo" src="images/<?= $id_branch ?>-post.png" style="max-width: 200px;" alt="No image found."/> -->
                    <a href="<?= $loginUrl ?>" class="btn-facebook btn-auth">Login con Facebook</a>
                    <p class="font-75 enera-white-color">Al hacer click en Login con Facebook aceptas los terminos y condiciones.</p>
                    <h5 id="status" style="color: white; margin-top: 10px;"></h5>
                </div>
            </div>
        </div>
        <!-- <a href="#" class="scroll-down icon-angle-down"></a> -->
    </div>
    <div class="bg-image" style="background-image: url('images/<?= $id_branch ?>-bg.jpg');"></div>
    <a id="scroller-down" href="#" class="scroll-down" style="display: none;"><i class="fa fa-arrow-down"></i></a>
</header>

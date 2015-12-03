/* Privacy policy & Terms and Conditions buttons */
var ap = document.getElementById("ap");
var open_ap = document.getElementById('open_ap');
var close_ap_tac = document.getElementById('close_ap_tac');
var ap_tac_containers = document.getElementById('ap_tac_containers');

open_ap.addEventListener('click', function(e) {
    ap.style.display = 'block';
    close_ap_tac.style.display = 'block';
    ap_tac_containers.style.display = 'none';
}, false);

open_tac.addEventListener('click', function(e) {
    ap.style.display = 'block';
    close_ap_tac.style.display = 'block';
    ap_tac_containers.style.display = 'none';
}, false);

close_ap_tac.addEventListener('click', function(e) {
    ap.style.display = 'none';
    close_ap_tac.style.display = 'none';
    ap_tac_containers.style.display = 'block';
    window.scrollTo(0, 0);
}, false);


/*document.getElementById('toggle_tac').addEventListener('click', function(e) {
    var tac = document.getElementById("tac");
    if (tac.style.display == 'none') {
        tac.style.display = 'block';
    } else {
        tac.style.display = 'none';
        window.scrollTo(0, 0);
    }
}, false);*/

/*var send_button = document.getElementById('send-survey');
send_button.addEventListener('click', function() {
    send_button.innerHTML = 'Cargando, por favor espera'
}, false);*/

function myOnLoadHandlerHere() {
    alert('myOnLoadHandlerHere');
}

//var myPlayer = videojs('video');
/*console.log('setting vid');
videojs("video").ready(function(){
    console.log("Cargado");
    this.on('ended', function(){
        alert('end');
    });
});*/





/*$(document).ready(function(){

    $('#toggle_ap').on('click',function(){
        $('#ap').toggle();
        alert('toggle');
    });*/
    
    /*//Privacy Policy show
    $('#ap_trigger').on('click',function(){
            $('.ap').show();
            window.onbeforeunload = function() {
                    return "Si quieres cerrar el aviso de privacidad,\n por favor usa el botón Regresar"; 
            };
    });*/

    /*//Privacy Policy hide
    $('.ap_back').on('click',function(){
            $('.ap').hide();
            window.onbeforeunload = function() {
            };
    });*/

    /* Commented next block to avoid bottlenecks, uncomment if necessary (not recommended) */
    /*//Facebook access button
    $('#fb_access').on('click',function(){
            if($('#ap_chbox').prop('checked')){
                    window.location.href = $(this).attr("next_url");
            }else{
                    alert("Por favor acepta los términos de uso y aviso de privacidad para continuar");
            }
    });*/
/*});*/
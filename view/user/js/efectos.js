$(document).ready(function() {
    
    // Scroll Boton Infomacion
    var informacion = $('#conoce-mas').offset().top;

    $('#btn-informacion').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: informacion + 100
        }, 500);
    });
});
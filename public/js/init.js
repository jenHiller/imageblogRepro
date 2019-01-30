$(document).ready(function () {
    // Navigation öffnen und schließen
    $('.burger-navigation').on('click', function () {
        $('.navi-overlay').show();
    });

    $('.close, .close-area').on('click', function () {
        $('.navi-overlay').hide();
    });

    //Slider-Zeit anpassen
    $('.carousel').carousel({
        interval: 5000
    });

    // Parallax ausführen
    $('.parallax').parallax();


});
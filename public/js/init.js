$(document).ready(function () {
    // Navigation öffnen und schließen
    $('.burger-navigation').on('click', function () {
        $('.navi-overlay').show();
    });

    $('.close, .close-area').on('click', function () {
        $('.navi-overlay').hide();
    });

    // fixed Navigation
    $(window).scroll(function(){
        var scrollTop = $(window).scrollTop();

        if ( scrollTop > 1 ) {
            $('.main-navigation').addClass("fixed-top");
        }
        else{
            $('.main-navigation').removeClass("fixed-top");
        }
    });

    // Slider-Zeit anpassen
    $('.carousel').carousel({
        interval: 5000
    });

    // Parallax ausführen
    $('.parallax').parallax();


});
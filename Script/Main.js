$(document).ready(function (e) {
    $(window).resize(function (e) {
        $('#main').css({height:($(window).height()-68)});
    });

    $(window).resize();
});
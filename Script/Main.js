$(document).ready(function (e) {
    $(window).resize(function (e) {
        $('#mainContent').css({height:($(window).height()-68)});
    });

    $(window).resize();
});
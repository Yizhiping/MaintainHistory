$(document).ready(function (e) {
    //自動設置主體部分的高度
    $(window).resize(function (e) {
        $('#mainContent').css({height:($(window).height()-68)});
    });

    $(window).resize();

    //點擊顯示下拉清單
    $('.selInput').click(function (e) {
        $(this).next('ul').width = $(this).width;
        $(this).next('ul').show();
    });

    //按ESC鍵隱藏下拉清單
    $(document).keydown(function (e) {
        if(e.keyCode==27)
        {
            $('.selInput').next('ul').hide();
        }
    });

    //點擊下拉菜單賦值到input中,并隱藏下拉清單
    $('.listOption').click(function (e) {
        $(this).parent().prev().val($(this).text());
        $(this).parent().hide(0);
    });

});
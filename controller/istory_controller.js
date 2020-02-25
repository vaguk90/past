$(document).ready(function () {
    //ВЫВОД ДАННЫХ ЗА МЕСЯЦ
    $('#i_auto').change(function () {
        id_auto = $('#i_auto').val();
        win_w = $(window).width();
        $.ajax ({
            url: 'model/istorydb.php',
            type: 'POST',
            data: ({id_auto: id_auto,
                win_w: win_w}),
            success: function (data) {
                if(data) {
                $('.istory').css({'display': 'block'}).removeClass('bounceOutUp').addClass('bounceInLeft');
                if (win_w > 550) {
                    $('.button_istory').css({'display':'none'});
                    $('.table_istory').css({'display':'block'});
                    $('.li_istory ul').css({'display': 'none'});
                    $('.table tr').after(function () {
                        $('#istory').remove();
                    });
                    $('.table thead').after(data);
                } else {
                    $('.table_istory').css({'display': 'none'});
                    $('.li_istory').css({'display': 'block'}).html(data);
                    $('.button_istory').css({'display': 'block'});
                }
                } else {
                    $('.istory').css({'display': 'none'});
                }
            }
        })
    });
    //СВЕЗЫВАЕМ 2 СЕЛЕКТА
    $('#i_auto').change(function () {
        id = $('#i_auto').val();
        $.ajax ({
            url: 'model/istorydb.php',
            type: 'POST',
            data: ({istory_change: id}),
            success: function (e) {
                $('#istory_select').html(e);
            }
        });
    });
//ИЗМЕНЕНИЕ МЕСЯЦА
    $('#istory_select').change(function () {
        id_istory = $('#istory_select').val();
        id_auto = $('#i_auto').val();
        win_w = $(window).width();
        $.ajax({
            url:'model/istorydb.php',
            type: 'POST',
            data: ({
                win_w: win_w,
                id_auto: id_auto,
                id_istory: id_istory}),
            success: function (data) {
                if (win_w > 550) {
                    $('.table_istory').css({'display':'block'});
                    $('.li_istory ul').css({'display': 'none'});
                    $('.table tr').after(function () {
                        $('#istory').remove();
                    });
                    $('.table thead').after(data);
                } else {
                    $('.table_istory').css({'display': 'none'});
                    $('.li_istory').css({'display': 'block'}).html(data);
                }
    }
    });
    });
    //НАСТРОЙКА КНОПОК ПРОЛИСТЫВАНИЯ
    $('.carousel-arrow-up').click(function () {
        height_istory_stick = parseInt($('.li_istory').css("height"));
        if(height_istory_stick < 1000) {
            $('.li_istory').animate({'max-height': '350vh'}, 1000);
            $('.li_istory').css({'overflow': 'hidden'});
        }
        if(height_istory_stick > 1100 && height_istory_stick < 3000) {
            $('.li_istory').animate({'max-height': '700vh'}, 1000);
            $('.li_istory').css({'overflow': 'hidden'});
        }
        if(height_istory_stick > 3500 && height_istory_stick < 4500) {
            $('.li_istory').animate({'max-height': '1050vh'}, 1000);
            $('.li_istory').css({'overflow': 'hidden'});
        }
        if(height_istory_stick > 5500 && height_istory_stick < 6500) {
            $('.li_istory').animate({'max-height': '1400vh'}, 1000);
            $('.li_istory').css({'overflow': 'hidden'});
        }
        if(height_istory_stick > 7000 && height_istory_stick < 9000) {
            $('.li_istory').animate({'max-height': '1750vh'}, 1000);
            $('.li_istory').css({'overflow': 'hidden'});
        }
        if(height_istory_stick > 10000 && height_istory_stick < 12000) {
            $('.li_istory').animate({'max-height': '2100vh'}, 1000);
            $('.li_istory').css({'overflow': 'hidden'});
        }
        if(height_istory_stick > 12500 && height_istory_stick < 14000) {
            $('.li_istory').animate({'max-height': '100%'}, 1000);
            $('.li_istory').css({'overflow': 'hidden'});
        }
});
    $('.carousel-arrow-down').click(function () {
            $('.li_istory').animate({'max-height': '100vh'}, 1500);
            $('.li_istory').css({'overflow': 'hidden'});
    });
});
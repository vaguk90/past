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
                $('.istory').css({'display': 'block'}).removeClass('bounceOutUp').addClass('bounceInLeft');
                if (win_w > 573) {
                    $('.table_istory').css({'display':'block'})
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
                if (win_w > 573) {
                    $('.table_istory').css({'display':'block'})
                    $('.li_istory ul').css({'display': 'none'});
                    $('.table tr').after(function () {
                        $('#istory').remove();
                    });
                    $('.table thead').after(data);

                } else {
                    $('.table_istory').css({'display': 'none'});
                    $('.li_istory').css({'display': 'block'}).html(data);
                    alert(data);
                }


    }
    });
    });

});
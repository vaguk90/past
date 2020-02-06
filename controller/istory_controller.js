$(document).ready(function () {
    //ВЫВОД ДАННЫХ ЗА МЕСЯЦ
    $('#i_auto').change(function () {
        id_auto = $('#i_auto').val();
        $.ajax ({
            url: 'model/istorydb.php',
            type: 'POST',
            data: ({id_auto: id_auto}),
            success: function (data) {
                    $('.istory').css({'display': 'block'}).removeClass('bounceOutUp').addClass('bounceInLeft');
                    $('.table tr').after(function () {
                        $('#istory').remove();
                    });
                    $('.table thead').after(data);
            }

        })
    })
        //ФУНКЦИИ ПРОЛИСТЫВАНИЯ ИСТОРИИ
    $('.past_date').click(function (a) {
        a.preventDefault();

    });
});
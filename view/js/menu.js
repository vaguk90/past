$(document).ready(function () {
    //Повторение анимации
    $.fn.extend({
        animateCss: function (animationName) {
            var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            $(this).addClass('animated ' + animationName).one(animationEnd, function () {
                $(this).removeClass('animated ' + animationName);
            });
        }
    });



//ОКНО РАСЧЕТ РЕЗУЛЬТАТА ГЛОБАЛЬНАЯ ФУНКЦИЯ
    $.oil_raschet = function(milage_day, milage_night, rashod_oil, day_oile, get_oile) {
        $('.result').removeClass('fast');
        milage = milage_night - milage_day;
        del_night_oil = milage * rashod_oil / 100;
        night_oil = (day_oile - del_night_oil) + get_oile;
        $('.probeg').html("<p>Проехал: <span>" + milage + "</span> км</p>");
        $('.minusoil').html("<p>Потратил бензина: <span>" + del_night_oil + "</span> л</p>");
        $('.rezult_get_oil').html("<p>Заправил: <span>" + get_oile + "</span> л</p>");
        $('.ost_night').html("<p>Остаток бензина вечером: <span>" + night_oil + "</span> л</p>");
        $('.general').toggleClass('bounceInLeft bounceOutUp');
        $('.result').toggleClass('bounceOutUp bounceInLeft');
        $('.result').css({'display': 'block'});
    }

//расчет бензина и вывод результата
    $('.btn_oil').click(function () {
        day = $('.milage_day').val();
        night = $('.milage_night').val();
        del_oil = $('.rashod_oil').val();
        day_oil = $('.day_oil').val();
        get_oil = $('.get_oil').val();
        if (day && night && del_oil && day_oil) {
            $.oil_raschet(day,night,del_oil,day_oil,get_oil);
        } else {
            $('.dann #error').html('Заполните поля');
        }
    });
    //ФУНКЦИЯ ВЫВОДА ОКОН
    function animation_window(button, window, close) {
        $(button).click(function () {
            $(window).show("slow");
        });
        $(close).click(function () {
            $(window).hide("slow");
        });
    }
    //ОКНО РЕГИСТРАЦИИ
    animation_window('.registration p', '.register', '.register .closer');
    //ОКНО НАВИГАЦИИ
    animation_window('.menu', '.guest_menu', '.guest_menu .closer');
    //ОКНО СОЗДАНИЯ АВТОМОБИЛЯ
    animation_window('.get_auto', '.create_auto', '.create_auto .closer');
    //ОКНО СОЗДАНИЯ ВОДИТЕЛЯ
    animation_window('.create_user', '.create_use', '.create_use .closer');
    $('.result .closer').click(function () {
        $('.general').toggleClass('bounceOutUp bounceInLeft delay-1s');
        $('.result').toggleClass('bounceInLeft bounceOutUp');
    });
});

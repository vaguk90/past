$(document).ready(function () {
    $('#save_auto').click(function (a) {
        a.preventDefault();
        create_name_auto = $('#create_name_auto').val();
        create_numer = $('#create_numer').val();
        $.ajax ({
            url: 'model/create_autodb.php',
            type: 'POST',
            data: ({
                create_name_auto: create_name_auto,
                create_numer: create_numer
            }),
            success: function (data) {
                if (data) {
                    $('.create_auto #error').html(data);
                } else {
                    $(".create_auto").hide("slow");
                }
            }
        })
    });

    //УДАЛЕНИЕ АВТОМОБИЛЯ
    $('.auto_none').click(function () {
        auto_delite = $('#i_auto').val();
        $.ajax ({
            url: 'model/create_autodb.php',
            type: 'POST',
            data: ({auto_delite: auto_delite})
        });
    });


});

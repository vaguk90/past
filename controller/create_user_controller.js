$(document).ready(function () {
    //СВЕЗЫВАЕМ 2 СЕЛЕКТА
    $('#i_auto').change(function () {
        id = $('#i_auto').val();
        $.ajax ({
            url: 'model/create_userdb.php',
            type: 'POST',
            data: ({id_auto_change: id}),
            success: function (e) {
                $('#user_names').html(e);
            }
        });
    });
    //ДОБАВЛЕНИЕ ВОДИТЕЛЯ В ЭКИПАЖ
    $('#add_user').click(function (a) {
        a.preventDefault();
        id = $('#i_auto').val();
        add_firstname = $('#add_firstname').val();
        add_lastname = $('#add_lastname').val();
        user_company = $('#user_company').val();
        $.ajax ({
            url: 'model/create_userdb.php',
            type: 'POST',
            data: ({
                id_auto: id,
                add_firstname: add_firstname,
                add_lastname: add_lastname,
                user_company: user_company
            }),
            success: function (data) {
                if (data) {
                        $(' .create_use #error').html(data);
                } else {
                    location.reload()
                }
            }
        })
    });
    //УДАЛЕНИЕ ВОДИТЕЛЯ ИЗ ЭКИПАЖА
    $('.user_none').click(function () {
        user_none = 'TRUE';
        user_id = $('#user_names').val();
        id = $('#i_auto').val();
        $.ajax ({
            url: 'model/create_userdb.php',
            type: 'POST',
            data: ({
                user_none: user_none,
                id_auto: id,
                users_id: user_id}),
            success: function (data) {
                if (data) {
                    $(' .user_add #error').html(data);
                } else {
                    location.reload()
                }
            }
    });
});
});
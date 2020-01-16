$(document).ready(function () {
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
});
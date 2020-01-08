$(document).ready(function () {
    $('#add_user').click(function (a) {
        a.preventDefault();
        add_firstname = $('#add_firstname').val();
        add_lastname = $('#add_lastname').val();
        $.ajax ({
            url: 'model/add_user.php',
            type: 'POST',
            data: ({
                add_firstname: add_firstname,
                add_lastname: add_lastname
            })
        })
    });
});
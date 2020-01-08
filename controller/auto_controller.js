$(document).ready(function () {
    $('#save_auto').click(function (a) {
        a.preventDefault();
        create_name = $('#create_auto').val();
        create_number = $('#create_numer').val();
        $.ajax ({
            url: 'model/save_autodb.php',
            type: 'POST',
            data: ({
                create_name: create_name,
                create_number: create_number
            })
        })
    });
});
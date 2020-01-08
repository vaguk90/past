$(document).ready(function () {
    $('#log_in').click(function (a) {
        a.preventDefault();
        email = $('#login_entry').val();
        pass = $('#pass_entry').val();
        $.ajax({
            url: 'model/autorizationdb.php',
            type: 'POST',
            data: ({
                email: email,
                pass: pass
            }),
            success: function (data) {
                if (data) {
                    $('#new_user p').html(data);
                } else{
                    location.reload()
                }
            }
        })
    });
});
$(document).ready(function () {
    $('#register').click(function (e) {
        e.preventDefault();
        email = $('#email').val();
        pass = $('#pass').val();
        pass2 = $('#pass2').val();
        firstname = $('#firstname').val();
        lastname = $('#lastname').val();
        company = $('#company').val();
        $.ajax({
            url: "model/registrationdb.php",
            type: "POST",
            data: ({
                firstname: firstname,
                lastname: lastname,
                email: email,
                company: company,
                pass: pass,
                pass2: pass2
            }),
            success: function (data) {
                if (data) {
                    $('#error').html(data);
                } else {
                    $('#email').val('');
                    $('#new_user p').html('Теперь вы можете авторизоваться');
                    $(".register").hide("slow");
                }
            }
        })


    })
});
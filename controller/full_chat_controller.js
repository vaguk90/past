$(document).ready(function () {
    $('.chat_enter').click(function (e) {
        e.preventDefault();
        full_chat_text = $('.chat_text').val();
        $.ajax({
            url: 'model/full_chat_textdb.php',
            type: 'POST',
            data: ({full_chat_text: full_chat_text}),
            success: function (data) {
                $('.chat_window').html(data);
                $(".chat_window").mCustomScrollbar({
                    theme:"rounded",
                    autoHideScrollbar: true,
                    scrollButtons:{
                        enable:true
                    }
                });
            }
        })
    })

});
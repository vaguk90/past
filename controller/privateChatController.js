$(document).ready(function () {
//show private chat
    $('#i_auto').change(function () {
        showChat = $("#i_auto").val();
        $.ajax({
            url: "model/privateChatdb.php",
            type: 'POST',
            data: ({showChat: showChat}),
            success: function (data) {
                if (data) {
                    $('.privateChat').css({'display': 'block'});
                    $(".privateWindowChat").html(data);
                    $(".privateWindowChat").scrollTop(9999);


                    setInterval(function () {
                        loadChat = $("#i_auto").val();
                        $.ajax({
                            url: "model/privateChatdb.php",
                            type: 'POST',
                            data: ({loadChat: loadChat}),
                            success: function (data) {
                                $(".privateWindowChat").html(data);
                                $(".privateWindowChat").scrollTop(9999);
                            }
                        })
                    }, 4000);
                } else {
                    $('.privateChat').css({'display': 'none'})
                }
            }
        })
    });
//insert text chat
    $('.PrivateChatButton').click(function (e) {
        e.preventDefault();
        insertText = $('.enterTextInPrivateChat').val();
        chat_enter = 'true';
        id_auto = $('#i_auto').val();
        $.ajax({
            url: "model/privateChatdb.php",
            type: "POST",
            data: ({
                insertText: insertText,
                chat_enter: chat_enter,
                id_auto: id_auto
            }),
            success: function (data) {
                $('.enterTextInPrivateChat').val('');
                $(".privateWindowChat").html(data);
                $(".privateWindowChat").scrollTop(9999);
            }
        })
    });


//Click the window chat and add scroll
    $('.privateWindowChat').click(function () {
        $(this).css({'overflow': 'scroll'});
    });
//Click not on the window and add hidden
    $(document).mouseup(function (e) { // событие клика по веб-документу
        var div = $(".privateWindowChat"); // тут указываем ID элемента
        if (!div.is(e.target) // если клик был не по нашему блоку
            && div.has(e.target).length === 0) { // и не по его дочерним элементам
            div.scrollTop(9999);
            div.css({'overflow': 'hidden'});
        }
    });


});
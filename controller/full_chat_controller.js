$(document).ready(function () {
//loqd common chat
    $('.commonWindowChat').load('model/full_chat_textdb.php', function () {
        $(".commonWindowChat").scrollTop(9999);
        setInterval(function () {
            $('.commonWindowChat').load('model/full_chat_textdb.php', function () {
                $(".commonWindowChat").scrollTop(9999);
            });
        }, 4000);
    });

//insert text chat
    $('.commonChatButton').click(function (e) {
        e.preventDefault();
        enteredText = $('.enterTextInCommenChat').val();
        chat_enter = 'true';
        $.ajax({
            url: 'model/full_chat_textdb.php',
            type: 'POST',
            data: ({
                enteredText: enteredText,
                chat_enter: chat_enter
            }),
            success: function (data) {
                $(".commonWindowChat").html(data);
                $('.enterTextInCommenChat').val('');
                $(".commonWindowChat").scrollTop(9999);
            }
        })
    });
//Click the window chat and add scroll
    $('.commonWindowChat').click(function (e) {
        $(this).css({'overflow': 'scroll'});
    });
//Click not on the window and add hidden
    $(document).mouseup(function (e) { // событие клика по веб-документу
        var div = $(".commonWindowChat"); // тут указываем ID элемента
        if (!div.is(e.target) // если клик был не по нашему блоку
            && div.has(e.target).length === 0) { // и не по его дочерним элементам
            div.scrollTop(9999);
            div.css({'overflow': 'hidden'});
        }
    });
});
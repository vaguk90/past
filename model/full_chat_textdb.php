<?php
session_start();
require_once 'connectdb.php';
if (isset($_POST['full_chat_text'])) {
    //ФУНКЦИЯ ОЧИСТКИ ВРЕДОНСНЫХ ДАННЫХ
    function clean($value = '')
    {
        $value = trim($value); //убираем пробелы
        $value = stripslashes($value); //экранирование букв
        $value = strip_tags($value); //удаление html тегов
        $value = htmlspecialchars($value); //преобразуетм теги html
        return $value;
    }
    $chat_text = clean($_POST['full_chat_text']);
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];

    if(isset($firstname) && isset($lastname)) {
        if (isset($chat_text)) {
            $enter_text = $db->prepare("INSERT INTO `full_chat`(`name`,`family`,`text`) VALUES (?,?,?)");
            $enter_text->execute(array($firstname, $lastname, $chat_text));
            $select_dann = $db -> query("SELECT * FROM `full_chat`");
            $conclusion = $select_dann -> fetchAll(PDO::FETCH_ASSOC);
            foreach ($conclusion as $visibol) {
                print_r('<p class = "text-left mb-0">'.$visibol['name'].' ' .$visibol['family'].': ' .$visibol['text']. '</p>');
            }
        } else {
            $error[] = print_r('Введите текст');
        }
    } else {
       $error[] = print_r ('Общаться в чате могут только зарегистрированные пользоатели');
    }
}
?>
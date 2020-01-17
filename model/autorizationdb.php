<?php
require_once 'connectdb.php';
//ФУНКЦИЯ ОЧИСТКИ ВРЕДОНСНЫХ ДАННЫХ
function clean($value = '')
{
    $value = trim($value); //убираем пробелы
    $value = stripslashes($value); //экранирование букв
    $value = strip_tags($value); //удаление html тегов
    $value = htmlspecialchars($value); //преобразуетм теги html
    return $value;
}
//ОБЪЯВЛЯЕМ ПЕРЕМЕННЫЕ
$login = clean($_POST['email']);
$pass = clean($_POST['pass']);
$errors = array();
//ПРОВЕРЯЕМ НА ПРАВИЛЬНОСТЬ ВВОДА ДАННЫХ
if (empty($login) || empty($pass)) {
    $errors[] = 'Необходимо заполнить оба поля';
} else {
    $valid= $db->prepare("SELECT * FROM `user` WHERE email = ?");
    $valid->execute(array($login));
    $result = $valid->fetch(PDO::FETCH_ASSOC);
    if (empty($result)) {
        $errors[] = 'Такого пользователя не существует';
    } else {
        if (password_verify($pass, $result['pass']) && $result) {
            session_start();
            $_SESSION['id'] = $result['id'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['firstname'] = $result['firstname'];
            $_SESSION['lastname'] = $result['lastname'];
            setcookie("login", $result['email'], time() + 60 * 60 * 24 * 10);
        } else {
            $errors[] = 'Не верно введен пороль';
        }
    }
}
if($errors) {
    $err = $errors[0];
    print_r($err);
}




<?php
require_once 'connectdb.php';
//ФУНКЦИЯ ОЧИСТКИ ВРЕДОНСНЫХ ДАННЫХ
function clean ($value = '') {
$value = trim($value); //убираем пробелы
$value = stripslashes($value); //экранирование букв
$value = strip_tags($value); //удаление html тегов
$value = htmlspecialchars($value); //преобразуем теги html
return $value;
}
//ОЧИСТКА ВВЕДЕННЫХ ДАННЫХ
$id_auto = $_POST['id_auto'];
$add_firstname = clean($_POST['add_firstname']);
$add_lastname = clean($_POST['add_lastname']);
$user_company = clean($_POST['user_company']);
$errors = array();
//ПРОВЕРКА НА ПУСТЫЕ ПОЛЯ
if (strlen($add_firstname) < 3 || strlen($add_firstname) > 17) {
    $errors[] = 'Имя должно иметь не менее 3 букв и не более 17';
}
if (strlen($add_lastname) < 3 || strlen($add_lastname) > 17) {
    $errors[] = 'Фамилия должна иметь не менее 3 букв и не более 17';
}
if (empty($user_company)) {
    $errors[] = 'Введите название фирмы';
} else {
    $sel = $db->prepare("SELECT `id` FROM `user` WHERE firstname = ? AND lastname = ? AND company = ?");
    $sel->execute(array($add_firstname, $add_lastname, $user_company));
    $user = $sel->fetchColumn();
    if ($user < 1) {
        $errors[] = 'Такого пользователя не существует';
    } else {
        $sel_use_auto = $db->prepare("SELECT `id_auto` FROM `add_user_auto` WHERE id_user = ?");
        $sel_use_auto->execute(array($user[0]));
        $id_use_auto = $sel_use_auto->fetchColumn();
        if ($id_use_auto) {
            $errors[] = 'Этот водитель уже добавлен к автомобилю';
        }
    }
}

if (empty($errors)) {
    $save = $db->prepare("INSERT INTO `add_user_auto`(`id_auto`,`id_user`) VALUES(?,?)");
    $save->execute(array($id_auto, $user[0]));
} else {
    $err = $errors[0];
    print_r($err);
}
?>
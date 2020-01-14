<?php
require_once 'connectdb.php';
session_start();
//ФУНКЦИЯ ОЧИСТКИ ВРЕДОНСНЫХ ДАННЫХ
function clean ($value = '') {
    $value = trim($value); //убираем пробелы
    $value = stripslashes($value); //экранирование букв
    $value = strip_tags($value); //удаление html тегов
    $value = htmlspecialchars($value); //преобразуем теги html
    return $value;
}
//ОЧИСТКА ВВЕДЕННЫХ ДАННЫХ
$create_name_auto = clean($_POST['create_name_auto']);
$create_numer = clean($_POST['create_numer']);
$errors = array();
//ПРОВЕРКА НА ПУСТЫЕ ПОЛЯ
if (strlen($create_name_auto) < 3 || strlen($create_name_auto) > 25) {
    $errors[] = 'Название автомобиля должно иметь не менее 3 букв и не более 25';
}
if (strlen($create_numer) < 5 || strlen($create_numer) > 10) {
    $errors[] = 'Номер автомобиля должен иметь не менее 5 и не более 10 символов';
}
if (empty($errors)) {
    $save = $db->prepare("INSERT INTO `info_auto`(`name_auto`,`number`,`id_user`) VALUES(?,?,?)");
    $us_name = $_SESSION['id'];
    $save->execute(array($create_name_auto,$create_numer,$us_name));
} else {
    $err = $errors[0];
    print_r($err);
}
?>
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


    $sel_id_auto = $db->prepare("SELECT `id_auto` FROM `info_auto` WHERE id_user = ? ORDER BY id_auto DESC LIMIT 1 ");
    $sel_id_auto->execute(array($us_name));
    $id_auto = $sel_id_auto->fetchAll(PDO::FETCH_ASSOC);
    foreach ($id_auto as $items) {
        $save_ecip = $db->prepare("INSERT INTO `add_user_auto` VALUES(?,?)");
        $save_ecip->execute(array($items['id_auto'],$us_name));
    }





} else {
    $err = $errors[0];
    print_r($err);
}

//УДАЛЕНИЕ АВТОМОБИЛЯ
if($_POST['auto_delite'] ?? ''){
    $id_autos = $_POST['auto_delite'];
        $delete_user = $db->prepare("DELETE FROM `add_user_auto` WHERE id_auto = ? ");
        $delete_user->execute(array($id_autos));
        $delete_auto = $db->prepare("DELETE FROM `info_auto` WHERE id_auto = ? ");
        $delete_auto->execute(array($id_autos));


}

?>
<?php
require_once 'connectdb.php';
//СВЯЗАННЫЙ СЕЛЕКТ
if(empty($_POST['id_auto_change'])) {
    $errors[] = 'Выберите автомобиль';
} else {
    $id_auto = $_POST['id_auto_change'];
    $users = $db->prepare("SELECT * FROM `user` WHERE id IN (SELECT `id_user` FROM `add_user_auto` WHERE id_auto = ?)");
    $users->execute(array($id_auto));
    $user_name = $users->fetchAll(PDO::FETCH_ASSOC);
    foreach($user_name as $users){
        echo"/n<option value = {$users['id']} >{$users['firstname']}  {$users['lastname']}</option>";
    }
}
if ($_POST['add_firstname'] ?? '') {
//ФУНКЦИЯ ОЧИСТКИ ВРЕДОНСНЫХ ДАННЫХ
    function clean($value = '')
    {
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
        $user = $sel->fetch(PDO::FETCH_ASSOC);
        if (empty($user)) {
            $errors[] = 'Такого пользователя не существует';
        } else {
            $sel_use_auto = $db->prepare("SELECT `id_auto` FROM `add_user_auto` WHERE id_user = ? AND id_auto = ?");
            $sel_use_auto->execute(array($user['id'], $id_auto));
            $id_use_auto = $sel_use_auto->fetch(PDO::FETCH_ASSOC);
            if ($id_use_auto) {
                $errors[] = 'Этот водитель уже добавлен к автомобилю';
            }
        }
    }
    if (empty($errors)) {
        $save = $db->prepare("INSERT INTO `add_user_auto`(`id_auto`,`id_user`) VALUES(?,?)");
        $save->execute(array($id_auto, $user['id']));
    } else {
        $err = $errors[0];
        print_r($err);
    }
}



//УДАЛЕНИЕ ВОДИТЕЛЯ
if($_POST['user_none'] ?? ''){
    $id_auto = $_POST['id_auto'];
    $id_user = $_POST['users_id'];

    $select_id = $db ->prepare("SELECT `id_auto` FROM `info_auto` WHERE id_user = ? AND id_auto = ?");
    $select_id ->execute(array($id_user, $id_auto));
    $select_id_auto = $select_id -> fetch(PDO::FETCH_ASSOC);

    if ($select_id_auto['id_auto'] == $id_auto) {
        $errors[] = 'Нельзя удалить хозяина автомобиля';
        $err = $errors[1];
        print_r($err);
    } else {
        $delete = $db->prepare("DELETE FROM `add_user_auto` WHERE id_user = ? AND id_auto = ?");
        $delete->execute(array($id_user, $id_auto));
    }
}
?>
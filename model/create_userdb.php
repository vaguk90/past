<?php
require_once 'connectdb.php';
//related select
if (empty($_POST['id_auto_change'])) {
    $errors[] = 'Выберите автомобиль';
} else {
    $id_auto = $_POST['id_auto_change'];
    $user_name = searchDB(
        '*',
        '`user`',
        'id IN (SELECT `id_user` FROM `add_user_auto` WHERE id_auto = ?)',
        $id_auto)->fetchAll(PDO::FETCH_ASSOC);
    foreach ($user_name as $users) {
        echo "/n<option value = {$users['id']} >{$users['firstname']}  {$users['lastname']}</option>";
    }
}
if (isset($_POST['add_firstname'])) {
//clean data
    $id_auto = $_POST['id_auto'];
    $add_firstname = clean($_POST['add_firstname']);
    $add_lastname = clean($_POST['add_lastname']);
    $user_company = clean($_POST['user_company']);
    $errors = array();
//checking
    if (strlen($add_firstname) < 3 || strlen($add_firstname) > 17) {
        $errors[] = 'Имя должно иметь не менее 3 букв и не более 17';
    }
    if (strlen($add_lastname) < 3 || strlen($add_lastname) > 17) {
        $errors[] = 'Фамилия должна иметь не менее 3 букв и не более 17';
    }
    if (empty($user_company)) {
        $errors[] = 'Введите название фирмы';
    } else {
        $user = searchDB(
            '`id`',
            '`user`',
            'firstname = ? AND lastname = ? AND company = ?',
            $add_firstname,
            $add_lastname,
            $user_company)->fetch(PDO::FETCH_ASSOC);
        if (empty($user)) {
            $errors[] = 'Такого пользователя не существует';
        } else {
            $id_use_auto = searchDB(
                'id_auto',
                'add_user_auto',
                'id_user = ? AND id_auto = ?',
                $user['id'],
                $id_auto)->fetch(PDO::FETCH_ASSOC);
            if ($id_use_auto) {
                $errors[] = 'Этот водитель уже добавлен к автомобилю';
            }
        }
    }
    if (empty($errors)) {
        $save = insertDB('`add_user_auto`','`id_auto`,`id_user`','?,?',$id_auto, $user['id']);
    } else {
        printErrors($errors);
    }
}


//delete driver
if (isset($_POST['user_none'] )) {
    $id_auto = $_POST['id_auto'];
    $id_user = $_POST['users_id'];
    $select_id_auto = searchDB(
        '`id_auto`',
        '`info_auto`',
        'id_user = ? AND id_auto = ?',$id_user, $id_auto)->fetch(PDO::FETCH_ASSOC);
    if ($select_id_auto['id_auto'] == $id_auto) {
        $errors[] = 'Нельзя удалить хозяина автомобиля';
        $err = $errors[1];
        print_r($err);
    } else {
        deleteDB('`add_user_auto`','id_user = ? AND id_auto = ?',$id_user, $id_auto);
    }
}
?>
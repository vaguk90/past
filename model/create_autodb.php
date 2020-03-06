<?php
require_once 'connectdb.php';
session_start();
if (isset($_POST['create_name_auto'])) {
//clean data
    $create_name_auto = clean($_POST['create_name_auto']);
    $create_numer = clean($_POST['create_numer']);
    $errors = array();
//checking
    if (strlen($create_name_auto) < 3 || strlen($create_name_auto) > 25) {
        $errors[] = 'Название автомобиля должно иметь не менее 3 букв и не более 25';
    } elseif (strlen($create_numer) < 5 || strlen($create_numer) > 10) {
        $errors[] = 'Номер автомобиля должен иметь не менее 5 и не более 10 символов';
    }
//insert auto
    if (empty($errors)) {
        $us_name = $_SESSION['id'];
        insertDB('`info_auto`', '`name_auto`,`number`,`id_user`', '?,?,?', $create_name_auto, $create_numer, $us_name);
        $id_auto = searchDB(
            '`id_auto`',
            'info_auto',
            'id_user = ? ORDER BY id_auto DESC LIMIT 1', $us_name)->fetchAll(PDO::FETCH_ASSOC);
        foreach ($id_auto as $items) {
            $save_ecip = $db->prepare("INSERT INTO `add_user_auto` VALUES(?,?)");
            $save_ecip->execute(array($items['id_auto'], $us_name));
        }
    } else {
        printErrors($errors);
    }
}
//delete auto
if (isset($_POST['auto_none'])) {
//checking for the owner
    $id_autos = $_POST['auto_id'];
    $user_id = $_SESSION['id'];
    $select_id_auto = searchDB(
        '`id_auto`',
        '`info_auto`',
        'id_user = ? AND id_auto = ?',
        $user_id,
        $id_autos)->fetch(PDO::FETCH_ASSOC);
//delete
    if ($select_id_auto['id_auto'] == $id_autos) {
        deleteDB('`add_user_auto`', 'id_auto = ?', $id_autos);
        deleteDB('`info_auto`', 'id_auto = ?', $id_autos);
        deleteDB('`auto_oil`', 'id_auto = ?', $id_autos);
    } else {
        $errors[] = 'Только хозяин может удалить автомобиль';
        printErrors($errors);
    }
}

?>
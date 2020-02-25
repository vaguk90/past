<?php
session_start();
require_once 'connectdb.php';
if(isset($_POST['user_milage_night'])) {
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
    $user_milage_day = clean($_POST['user_milage_day']);
    $user_milage_night = clean($_POST['user_milage_night']);
    $user_rashod_oil = clean($_POST['user_rashod_oil']);
    $user_day_oil = clean($_POST['user_day_oil']);
    $user_get_oil = clean($_POST['user_get_oil']);
    $auto = clean($_POST['auto']);
    $errors = array();
    $date = date('r', time());
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];

//ПРОВЕРКА ВВЕДЕННЫХ ДАННЫХ
    if ($auto == 0) {
        $errors[] = 'Выбирите или создайте автомобиль';
    }
    if (empty($user_milage_day)) {
        $errors[] = 'Введите пробег утро';
    } else if (empty(is_numeric($user_milage_day))) {
        $errors[] = 'В поле пробег утро присуствуют буквы';
    }
    if (empty($user_milage_night)) {
        $errors[] = 'Введите пробег вечер';
    } else if (empty(is_numeric($user_milage_night))) {
        $errors[] = 'В поле пробег вечер присуствуют буквы';
    } else if ($user_milage_day > $user_milage_night) {
        $errors[] = 'Значение утреннего пробега выше вечернего';
    }
    if (empty($user_rashod_oil)) {
        $errors[] = 'Введите расход топлива';
    } else if (empty(is_numeric($user_rashod_oil))) {
        $errors[] = 'В поле расход топливаприсуствуют буквы';
    }
    if (empty($user_day_oil)) {
        $errors[] = 'Введите остаток при выезде';
    } else if (empty(is_numeric($user_day_oil))) {
        $errors[] = 'В поле остаток при выезде присуствуют буквы';
    }
    if ($user_get_oil) {
        if (empty(is_numeric($user_get_oil))) {
            $errors[] = 'В поле заправил присуствуют буквы';
        }
    }

    if (empty($errors)) {
        $probeg = $user_milage_night - $user_milage_day;
        $del_oil = $probeg * $user_rashod_oil / 100;
        if (empty($user_get_oil)) {
            $ost_oil = $user_day_oil - $del_oil;
            $dann = $db->prepare("INSERT INTO `auto_oil`(`id_auto`,`firstname`,`lastname`,`probeg_day`,`probeg_night`,`probeg`,ost_day_oil,`del_oil`,`ost_oil`,`rashod_oil`) VALUES(?,?,?,?,?,?,?,?,?,?)");
            $dann->execute(array($auto, $firstname, $lastname, $user_milage_day, $user_milage_night, $probeg, $user_day_oil, $del_oil, $ost_oil,$user_rashod_oil));
        } else {
            $ost_oil = $user_day_oil - $del_oil + $user_get_oil;
            $dann = $db->prepare("INSERT INTO `auto_oil`(`id_auto`,`firstname`,`lastname`,`probeg_day`,`probeg_night`,`probeg`,`get_oil`,ost_day_oil,`del_oil`,`ost_oil`,`rashod_oil`) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
            $dann->execute(array($auto, $firstname, $lastname, $user_milage_day, $user_milage_night, $probeg, $user_get_oil, $user_day_oil, $del_oil, $ost_oil,$user_rashod_oil));
        }
    } else {
        $err = $errors[0];
        print_r($err);
    }
}
	//ЗАПОЛНЕНИЕ ИНПУТОВ
	if(isset($_POST['enter_input']) != 0 ) {
		$enter_input = $_POST['enter_input'];
		$dann_select = $db -> prepare("SELECT `probeg_night`, `ost_oil`,`rashod_oil` FROM `auto_oil` WHERE id_auto = ? ORDER BY data DESC LIMIT 1");
	$dann_select -> execute(array($enter_input));
	$rezult_input = $dann_select -> fetch(PDO::FETCH_ASSOC);
	if($rezult_input) {
		echo json_encode($rezult_input);
	}
	}
?>
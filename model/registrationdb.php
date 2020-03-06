<?php
require_once 'connectdb.php';

//clean
$email = clean($_POST['email']);
$pass = clean($_POST['pass']);
$pass2 = clean($_POST['pass2']);
$firstname = clean($_POST['firstname']);
$lastname = clean($_POST['lastname']);
$company = clean($_POST['company']);
$errors = array();
//checking
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if ($pass == '') {
        $errors[] = 'Введите пороль';
    } else if (strlen($pass) < 6 || strlen($pass) > 18) {
        $errors[] = 'Пороль должен быть от 6 до 18 символов';
    } else if ($pass2 == '') {
        $errors[] = 'Введите повторный пороль';
    } else if ($pass != $pass2) {
        $errors[] = 'Пороли не совпадают';
    } else if ($firstname == '') {
        $errors[] = 'Введите имя';
    } else if (strlen($firstname) < 3 || strlen($firstname) > 17) {
        $errors[] = 'Имя должно иметь не менее 3 букв и не более 17';
    } else if ($lastname == '') {
        $errors[] = 'Введите фамилию';
    }else if (strlen($lastname) < 3 || strlen($lastname) > 17) {
        $errors[] = 'Фамилия должна иметь не менее 3 букв и не более 17';
    } else if ($company == '') {
        $errors[] = 'Введите название фирмы';
    }
    $result = searchDB('`id`','`user`','email = ?',$email)->fetchColumn();
    if ($result > 0) {
        $errors[] = 'Эта почта уже зарегестрирована';
    }
} else {
    $errors[] = 'Введите корректный email';
}
if (empty($errors)) {
    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
    $create_user = insertDB('`user`', '`firstname`,`lastname`,`email`,`company`,`pass`', '?,?,?,?,?',$firstname, $lastname, $email, $company, $pass_hash);
    $create_user = null;
    $db = null;
} else {
   printErrors($errors);

}

?>
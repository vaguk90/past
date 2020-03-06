<?php
require_once 'connectdb.php';
if (isset($_POST['submitClick'])) {
    $login = clean($_POST['email']);
    $pass = clean($_POST['pass']);
    $errors = array();
    if (empty($login) || empty($pass)) {
        $errors[] = 'Необходимо заполнить оба поля';
    } else {
        $result = searchDB(
            '*',
            '`user`',
            'email = ?', $login)->fetch(PDO::FETCH_ASSOC);
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
    printErrors($errors);
}



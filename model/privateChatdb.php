<?php
session_start();
require_once 'connectdb.php';
//show private chat
if (isset($_POST['showChat'])) {
    $id_auto = $_POST['showChat'];
    $conclusion = searchDB(
        'DISTINCT (`id_user`)',
        '`add_user_auto`',
        'id_auto = ?',$id_auto)->fetchAll(PDO::FETCH_ASSOC);
    if (count($conclusion) > 1) {
        $conclusionData = searchDB('*', 'privatechat', 'id_auto = ?', $id_auto)->fetchAll(PDO::FETCH_ASSOC);
        if (count($conclusionData) > 0) {
            foreach ($conclusionData as $EnterTextInWindow) {
                print_r('<p class = "text-left mb-0"><span style="color:aqua;">' . $EnterTextInWindow['name'] . ' ' . $EnterTextInWindow['family'] . ': </span>' . $EnterTextInWindow['text'] . '</p>');
            }
        } else {
            echo 'Напишите первое сообщение';
        }
    }
}
//insert text chat
if (empty($_POST['insertText']) && isset($_POST['chat_enter']) && isset($_SESSION['firstname'])) {
    $error[] = print_r('Введите текст');
}
if (empty($_SESSION['firstname']) && empty($_SESSION['lastname'])) {
    $error[] = print_r('Общаться в чате могут только зарегистрированные пользователи');
}
if (empty($error)) {
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    if (isset($_POST['insertText'])) {
        $id_auto = $_POST['id_auto'];
        $chat_text = clean($_POST['insertText']);
        $saveTextInSql = insertDB('`privatechat`','`name`,`family`,`text`,`id_auto`','?,?,?,?',$firstname, $lastname, $chat_text, $id_auto);
        $conclusionChat = searchDB('*', '`privatechat`', 'id_auto = ?', $id_auto)->fetchAll(PDO::FETCH_ASSOC);
        foreach ($conclusionChat as $EnterTextInWindow) {
            print_r('<p class = "text-left mb-0"><span style="color:aqua;">' . $EnterTextInWindow['name'] . ' ' . $EnterTextInWindow['family'] . ': </span>' . $EnterTextInWindow['text'] . '</p>');
        }
    }
}
//auto-loadChat
if (isset($_POST['loadChat'])) {
    $id_auto = $_POST['loadChat'];
    $conclusionChat = searchDB('*', '`privatechat`', 'id_auto = ?', $id_auto)->fetchAll(PDO::FETCH_ASSOC);
    foreach ($conclusionChat as $EnterTextInWindow) {
        print_r('<p class = "text-left mb-0"><span style="color:aqua;">' . $EnterTextInWindow['name'] . ' ' . $EnterTextInWindow['family'] . ': </span>' . $EnterTextInWindow['text'] . '</p>');
    }
}

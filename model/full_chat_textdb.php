<?php
session_start();
require_once 'connectdb.php';
//select chat
$conclusion = searchDB('*','`full_chat` ORDER BY timeText ASC')->fetchAll(PDO::FETCH_ASSOC);
foreach ($conclusion as $EnterTextInWindow) {
    print_r('<p class = "text-left mb-0"><span style="color:aqua;">' . $EnterTextInWindow['name'] . ' ' . $EnterTextInWindow['family'] . ': </span>' . $EnterTextInWindow['text'] . '</p>');
}
//controll count text
if (count($conclusion) > 50) {
    $selectChatDann = searchDB('`timeTExt`','full_chat LIMIT 20');
    foreach ($selectChatDann AS $deleteText) {
        deleteDB('`full_chat`','timeTExt = ?',$deleteText['timeTExt']);
    }
}
//insert text chat
if (empty($_POST['enteredText']) && isset($_POST['chat_enter']) && isset($_SESSION['firstname'])) {
    $error[] = print_r('Введите текст');
}
if (empty($_SESSION['firstname']) && empty($_SESSION['lastname'])) {
    $error[] = print_r('Общаться в чате могут только зарегистрированные пользователи');
}
if (empty($error)) {
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    if (isset($_POST['enteredText'])) {
        $chat_text = clean($_POST['enteredText']);
//enter text in sql
        $saveTextInSql = insertDB('`full_chat`','`name`,`family`,`text`','?,?,?',$firstname, $lastname, $chat_text);
//concluse new text from sql
        $conclusionChat = searchDB('*','`full_chat` ORDER BY timeText DESC LIMIT 1')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($conclusionChat as $EnterTextInWindow) {
            print_r('<p class = "text-left mb-0"><span style="color:aqua;">' . $EnterTextInWindow['name'] . ' ' . $EnterTextInWindow['family'] . ': </span>' . $EnterTextInWindow['text'] . '</p>');
        }
    }

}
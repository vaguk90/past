<?php
try {
$db = new PDO('mysql:host=localhost;dbname=h145460_auto_speed;charset=utf8;','root','');
$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print 'Не далось подключиться к базе данных' . $e->getMessage();
}
?>
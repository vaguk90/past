<?php
require_once 'connectdb.php';
//ФУНКЦИЯ ОЧИСТКИ ВРЕДОНСНЫХ ДАННЫХ
function clean($value = '')
{
    $value = trim($value); //убираем пробелы
    $value = stripslashes($value); //экранирование букв
    $value = strip_tags($value); //удаление html тегов
    $value = htmlspecialchars($value); //преобразуетм теги html
    return $value;
}

//ОЧИСТКА ВВЕДЕННЫХ ДАННЫХ
$email = clean($_POST['email']);
$pass = clean($_POST['pass']);
$pass2 = clean($_POST['pass2']);
$firstname = clean($_POST['firstname']);
$lastname = clean($_POST['lastname']);
$company = clean($_POST['company']);
$errors = array();
//ПРОВЕРКА НА ПУСТЫЕ ПОЛЯ
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
    } else if ($lastname == '') {
        $errors[] = 'Введите фамилию';
    } else if ($company == '') {
        $errors[] = 'Введите название фирмы';
    }
    $result = $db->prepare("SELECT `id` FROM `user` WHERE email = ?");
    $result->execute(array($email));
    if ($result->fetchColumn() > 0) {
        $errors[] = 'Эта почта уже зарегестрирована';
    }
} else {
    $errors[] = 'Введите корректный email';
}

if (empty($errors)) {
    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
    $create_user = $db->prepare("INSERT INTO `user` (`firstname`,`lastname`,`email`,`company`,`pass`) VALUES (?,?,?,?,?)");
    $create_user->execute(array($firstname, $lastname, $email, $company, $pass_hash));
    $create_user = null;
    $db = null;
} else {
    $err = $errors[0];
    print_r($err);

}


/*
//ПРОВЕРЯЕМ ВСЕ ЛИ ПОЛЯ ЗАПОЛНЕНЫ
if (!empty($email) && !empty($pass) && !empty($firstname) && !empty($lastname) && !empty($company)) {
//ПРОВЕРКА ФОРМАТ ВВЕДЕННОГО ЭМЕЙЛ
if (filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
//СЧИТАЕМ КОЛИЧЕСТВО СИМВОЛОВ В ПОРОЛЕ
if (strlen($pass) < 6 && strlen($pass) > 18) {
//СРАВНИВАЕМ ПОРОЛЬ 1 И ПОРОЛЬ 2
if ($pass == $pass2) {
$pass_hash = password_hash($pass, PASSWORD_DEFAULT);
//ВСТАВЛЯЕМ ДАННЫЕ В БД


//ВЫВОДИМ ОШИБКУ ЕСЛИ ПОРОЛИ НЕ СОВПАДАЮТ
} else {
echo 'Введенные пороли не совпадают';
}
//ВЫВОДИМ ОШИБКУ ЕСЛИ В ПОРОЛЕ БОЛЬШЕ 18 ИЛИ МЕНЬШЕ 6 СИМВОЛОВ
} else {
echo 'В пороле должно быть от 6 до 18 символов';
}
//ВЫВОДИМ ОШИБКУ ЕСЛИ ФОРМАТ ЭМАЙЛ НЕ ПРАВИЛЬНЫЙ
} else {
echo 'не верный формат email';
}
//ЕСЛИ ЗАПОЛНЕНЫ НЕ ВСЕ ПОЛЯ ВЫВОДИМ СООБЩЕНИЕ ОБ ОШИБКЕ
} else {
echo 'Заполните все поля!';
}
---------------------------------------------------------------------------

ТАК РАНЬШЕ БЫЛО
if(isset($_POST['register'])){

$errors = array();

if(trim($_POST['email']) == ''){
	$errors[] = 'Введите email';
}
if(trim($_POST['pass']) == ''){
	$errors[] = 'Введите пороль';
}
if($_POST['pass'] != $_POST['pass2']){
	$errors[] = 'Введите повторно пороль.';
}
if(trim($_POST['firstname']) == ''){
	$errors[] = 'Введите имя';
}
if(trim($_POST['lastname']) == ''){
	$errors[] = 'Введите фамилию';
}







$email = $_POST['email'];


$result = $mysql->query("SELECT `id` FROM `registration` WHERE email = '$email'");
if (mysqli_num_rows($result) > 0) {
    $errors[] = 'Эта почта уже зарегестрирована';
}

if(empty($errors)){

$email = $_POST['email'];
$pass = $_POST['pass'];
$pass2 = $_POST['pass2'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

$mysql->query
("
	INSERT INTO `registration`
	(`email`, `pass`, `firstname`, `lastname`)

	VALUES
	('$email', '$pass', '$firstname', '$lastname')
");

$mysql->close();

}
else {
	echo "<div>".array_shift($errors)."</div>";
}
}
*/
?>
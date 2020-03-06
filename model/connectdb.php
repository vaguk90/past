<?php
$db = dbConnect();
//clean data
function clean($value = '')
{
    $value = trim($value); //убираем пробелы
    $value = stripslashes($value); //экранирование букв
    $value = strip_tags($value); //удаление html тегов
    $value = htmlspecialchars($value); //преобразуем теги html
    return $value;
}
//connect db
function dbConnect()
{
    try {
        $db = new PDO('mysql:host=localhost;dbname=h145460_auto_speed;charset=utf8;', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        return print 'Не далось подключиться к базе данных' . $e->getMessage();
    }
}
//select
function searchDB($select,$from,$where = 'false',$data1 = 'false',$data2 = 'false',$data3 = 'false',$data4 = 'false',$data5 = 'false',$data6 = 'false')
{
    if($data1 === 'false'){
        $searchData = dbConnect()->query("SELECT $select FROM $from");
    } else {
        $searchData = dbConnect()->prepare("SELECT $select FROM $from WHERE $where");
        if(isset($data1) && $data2 === 'false') {
            $searchData->execute(array($data1));
        } elseif(isset($data2) && $data3 === 'false') {
            $searchData->execute(array($data1, $data2));
        } elseif(isset($data3) && $data4 === 'false') {
            $searchData->execute(array($data1,$data2,$data3));
        } elseif(isset($data4) && $data5 === 'false') {
            $searchData->execute(array($data1,$data2,$data3,$data4));
        } elseif(isset($data5) && $data6 === 'false') {
            $searchData->execute(array($data1,$data2,$data3,$data4,$data5));
        } elseif($data6) {
            $searchData->execute(array($data1,$data2,$data3,$data4,$data5,$data6));
        }
    }
    return $searchData;
}
//insert
function insertDB($into = 'false',$from,$values,$data1 = 'false',$data2 = 'false',$data3 = 'false',$data4 = 'false',$data5 = 'false',$data6 = 'false',$data7 = 'false',$data8 = 'false',$data9 = 'false',$data10 = 'false',$data11 = 'false')
{
    $insertData = dbConnect()->prepare("INSERT INTO $into ($from) VALUES ($values)");
    if(isset($data1) && $data2 === 'false') {
        $insertData->execute(array($data1));
    } elseif(isset($data2) && $data3 === 'false') {
        $insertData->execute(array($data1, $data2));
    } elseif(isset($data3) && $data4 === 'false') {
        $insertData->execute(array($data1,$data2,$data3));
    } elseif(isset($data4) && $data5 === 'false') {
        $insertData->execute(array($data1,$data2,$data3,$data4));
    } elseif(isset($data5) && $data6 === 'false') {
        $insertData->execute(array($data1,$data2,$data3,$data4,$data5));
    } elseif(isset($data6) && $data7 === 'false') {
        $insertData->execute(array($data1,$data2,$data3,$data4,$data5,$data6));
    } elseif(isset($data7) && $data8 === 'false') {
        $insertData->execute(array($data1,$data2,$data3,$data4,$data5,$data6,$data7));
    } elseif(isset($data8) && $data9 === 'false') {
        $insertData->execute(array($data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8));
    } elseif(isset($data9) && $data10 === 'false') {
        $insertData->execute(array($data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8,$data9));
    } elseif(isset($data10) && $data11 === 'false') {
        $insertData->execute(array($data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8,$data9,$data10));
    } elseif(isset($data11)) {
        $insertData->execute(array($data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8,$data9,$data10,$data11));
    }
}
//delete
function deleteDB($from,$where,$data1 = 'false',$data2 = 'false')
{
    $deleteData = dbConnect()->prepare("DELETE FROM $from WHERE $where");
    if(isset($data1) && $data2 === 'false') {
        $deleteData->execute(array($data1));
    } elseif(isset($data2)) {
        $deleteData->execute(array($data1,$data2));
    }
}
//print errors
function printErrors($errors)
{
    if ($errors) {
        $err = $errors[0];
        print_r($err);
    }
}
?>
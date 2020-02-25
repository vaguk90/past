<?php
require_once 'connectdb.php';
$win_w = $_POST['win_w'];


//СВЯЗАННЫЙ СЕЛЕКТ
if(@$_POST['istory_change'] ?? '') {
    $id_auto = $_POST['istory_change'];
    $users = $db->prepare("SELECT DISTINCT (DATE_FORMAT(data,'%Y-%m')) AS OrderYear FROM `auto_oil` WHERE id_auto = ? ORDER BY `data` DESC");
    $users->execute(array($id_auto));
    $user_name = $users->fetchAll(PDO::FETCH_ASSOC);
    foreach($user_name as $users){
        $newDate = date("Y-m", strtotime($users['OrderYear']));
        echo"<option value = {$newDate} >{$users['OrderYear']}</option>";
    }
}
//ИЗМЕНЕНИЕ МЕСЯЦА ВЫВОДА ИСТОРИИ
if($_POST['id_istory'] ?? '') {
    $id_auto = $_POST['id_auto'];
    $id_istory = $_POST['id_istory'];
    $change_user_istory = $db->prepare("SELECT * FROM `auto_oil` WHERE id_auto = ? AND data LIKE ?");
    $change_user_istory->execute(array($id_auto, $id_istory.'%'));
if ($win_w > 550) {
    foreach ($change_user_istory as $item) {
        $newDate = date("d.m.Y", strtotime($item['data']));
        print_r('<tr id = "istory"><td class="data_istory">' . $newDate . '</td>');
        print_r('<td class="name_istory ">' . $item['firstname'] . ' ' . $item['lastname'] . '</td><br>');
        print_r('<td class="night_probeg_istory ">' . $item['probeg_night'] . '</td>');
        print_r('<td class="probeg_istory ">' . $item['probeg'] . '</td>');
        print_r('<td class="get_oil_istory ">' . $item['get_oil'] . '</td>');
        print_r('<td class="ostatock_oil_istory ">' . $item['ost_oil'] . '</td></tr>');
    }
} else {
    foreach ($change_user_istory as $item) {
        $newDate = date("d.m.Y", strtotime($item['data']));
        print_r('<ul class="color_style stick">
                        <li><p><strong>' . $newDate . '</strong></p></li>
                        <li><p class = "text-left m-0 d-inline">Водитель: </p>' . $item['firstname'] . ' ' . $item['lastname'] . '</li>
                        <li><p class = "text-left m-0 d-inline">Пробег вечер: </p>' . $item['probeg_night'] . '</li>
                        <li><p class = "text-left m-0 d-inline">Проехал за день: </p>' . $item['probeg'] . '</li>
                        <li><p class = "text-left m-0 d-inline">Заправил: </p>' . $item['get_oil'] . '</li>
                        <li><p class = "text-left m-0 d-inline">Остаток в баке: </p>' . $item['ost_oil'] . '</li>
                      </ul>');
    }
}
} else {
//ВЫВОД ИСТОРИИ
    $id_auto = $_POST['id_auto'];
    $date = date('%' . "Y-m" . '%');
    if ($id_auto) {
        $select_istory = $db->prepare("SELECT * FROM `auto_oil` WHERE id_auto = ? AND data LIKE ? ORDER BY `data` DESC");
        $select_istory->execute(array($id_auto, $date));
        $istory = $select_istory->fetchAll(PDO::FETCH_ASSOC);
        if ($win_w > 550) {
            foreach ($istory as $string) {
                $newDate = date("d.m.Y", strtotime($string['data']));
                print_r('<tr id = "istory"><td class="data_istory">' . $newDate . '</td>');
                print_r('<td class="name_istory ">' . $string['firstname'] . ' ' . $string['lastname'] . '</td><br>');
                print_r('<td class="night_probeg_istory ">' . $string['probeg_night'] . '</td>');
                print_r('<td class="probeg_istory ">' . $string['probeg'] . '</td>');
                print_r('<td class="get_oil_istory ">' . $string['get_oil'] . '</td>');
                print_r('<td class="ostatock_oil_istory ">' . $string['ost_oil'] . '</td></tr>');
            }
        } else {
            foreach ($istory as $string) {
                $newDate = date("d.m.Y", strtotime($string['data']));
                print_r('<ul class="color_style stick ">
                        <li><p><strong>' . $newDate . '</strong></p></li>
                        <li><p class = "text-left m-0 d-inline">Водитель: </p>' . $string['firstname'] . ' ' . $string['lastname'] . '</li>
                        <li><p class = "text-left m-0 d-inline">Пробег вечер: </p>' . $string['probeg_night'] . '</li>
                        <li><p class = "text-left m-0 d-inline">Проехал за день: </p>' . $string['probeg'] . '</li>
                        <li><p class = "text-left m-0 d-inline">Заправил: </p>' . $string['get_oil'] . '</li>
                        <li><p class = "text-left m-0 d-inline">Остаток в баке: </p>' . $string['ost_oil'] . '</li>
                      </ul>');
            }
        }
    }
}
//ВСТАВЛЯЕМ ДАННЫЕ В ИНПУТЫ
$dann_select = $db->prepare("SELECT * FROM `auto_oil` WHERE id_auto = ? ");
?>
<?php
require_once 'connectdb.php';
    $id_auto = $_POST['id_auto'];
    $date = date('%'."Y-m".'%');
    if($id_auto ?? '') {
        $select_istory = $db->prepare("SELECT * FROM `auto_oil` WHERE id_auto = ? AND data LIKE ? ORDER BY `data` DESC");
        $select_istory->execute(array($id_auto, $date));
        $istory = $select_istory->fetchAll(PDO::FETCH_ASSOC);
        foreach ($istory as $string) {
            $newDate = date("d.m.Y", strtotime($string['data']));
            print_r('<tr id = "istory"><td class="data_istory">' . $newDate . '</td>');
            print_r('<td class="name_istory ">' . $string['firstname'] . ' ' . $string['lastname'] . '</td><br>');
            print_r('<td class="night_probeg_istory ">' . $string['probeg_night'] . '</td>');
            print_r('<td class="probeg_istory ">' . $string['probeg'] . '</td>');
            print_r('<td class="get_oil_istory ">' . $string['get_oil'] . '</td>');
            print_r('<td class="ostatock_oil_istory ">' . $string['ost_oil'] . '</td></tr>');
        }
    }

?>
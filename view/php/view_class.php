<?php

class Show_form
{
    //ОКНО МЕНЮ
    public function form_nav()
    {
        echo '<div class = "guest_menu  stick color_style">';
        $closes = new Commom;
        $closes->right_menu('close', 'Меню');
        echo '<div class="row mt- d-flex flex-column align-items-end row" >';
        //ЕСЛИ ПОЛЬЗОВАТЕЛЬ ГОСТЬ
        if (empty($_SESSION['id']) && empty($_SESSION['email']) && empty($_SESSION['lastname'])) {
            echo <<<GUEST_NAV
<form method = "POST"> 
                        <div class="login row d-flex flex-column">
            <div id="new_user" class="mr-4"><p></p></div>
                <input type="text" name ="login_entry" id = "login_entry" placeholder="Введите логин">
                <input type="password" name = "pass_entry"  id = "pass_entry" placeholder="Введите пороль">
            </div>
            <div class="registration row">
                <p><a href="#" class="d-block">Регистрация</a></p>
                <input type="submit" name = "log_in" id = "log_in" value="Войти">
            </div>
</form>
            </div>
            </div>
GUEST_NAV;
            //ЕСЛИ ПОЛЬЗОВАТЕЛЬ АВТОРИЗОВАН
        } else {
            echo <<<USER_NAV
            <div class="row text-right">
      <div class="col">
      <p> $_SESSION[firstname]  $_SESSION[lastname] </p>
       <form method = "POST">
       <input type="submit" name = "log_out" class = "m-0" value="Выйти">
       </form>
       </div>
       </div>
            </div>
            </div>
USER_NAV;

            if ($_POST['log_out'] ?? '') {
                session_unset();
                session_destroy();
                Header( 'Location:'.$_SERVER['PHP_SELF'] );
            }
        }
    }

    //ОКНО РЕГИСТРАЦИИ
    public function register()
    {
        echo <<<REGISTRATION_head
<div class = "register  window stick color_style">
  <div class = "row">
  <div class = "col-12">
REGISTRATION_head;
        $closes = new Commom;
        $closes->right_menu('close', 'Регистрация');
        echo <<<REGISTRATION
  </div>
  </div>
  <div class ="row text-center">
  <div class = "col-sm">
      <form method = "POST">
      <ul>
  <li><input type = "email" name = "email"  id = "email" placeholder = "Введите Email" required></li>
  <li><input type = "password" name = "pass"  id = "pass" placeholder = "Придумайте пороль" required></li>
  <li><input type = "password" name = "pass2"  id = "pass2" placeholder = "Повторите пороль" required></li>
  <li><input type = "text" name = "firstname"  id = "firstname" placeholder = "Введите имя" required></li>
  <li><input type = "text" name = "lastname"  id = "lastname" placeholder = "Введите фамилию" required></li>
  <li><input type = "text" name = "company"  id = "company" placeholder = "Введите вашу организацию" required></li>
  <li><input type = "submit" name = "register" id = "register" value = "Сохранить"></li>
        </ul>
        </form>
        <div id="error"></div>
    </div>
    </div>
  </div>
REGISTRATION;
    }
}

class Commom
{
    //КНОПКА МЕНЮ, ЗАКРЫТЬ, И ЗАГОЛОВОК
    public function right_menu($class, $text)
    {
        if ($class === 'close') {
            echo <<<EXIT_
<div class="closer row mr-1">
    <p>Close</p>
</div>
<h1 class = "text-center">$text</h1>
EXIT_;
        } else {
            echo <<<MENU_
<div class="$class row color_style">
    <p>....<br>....<br>....</p>
</div>
<h1 class = "text-center">$text</h1>
MENU_;
        }
    }
}

class General_stick
{
    //ОКНО ВВОДА ПРОБЕГА
    public function enter_oil($data = '', $info = '')
    {
        global $db;
        $window = new General_stick;
        $window -> create_auto();
        $window -> create_use();
        if ($data === 'guest') { //ЕСЛИ ПОЛЬЗОВАТЕЛЬ ГОСТЬ, ВЫВЕСТИ ИНФОРМАЦИОННОЕ ОКНО
            echo '<div class="row text-center stick mt-4">' . $info . '</div>';
            $window->create_dann('milage_day','milage_night','rashod_oil','day_oil','get_oil','btn_oil');
        } else if ($data === 'user') { //ЕСЛИ ПОЛЬЗОВАТЕЛЬ АВТОРИЗОВАН ВЫВЕСТИ ОКНО ИНФОРМАЦИИ АВТОМОБИЛЯ
            echo '<div class ="user_ok  d-flex justify-content-between mt-5">
         <ul class = "p-0 auto_add">
             <li>
                 <select type = "text" id = "i_auto" name = "i_auto">
                 <option value = 0>Выберете автомобиль</option>';
//ТУТ ВЫБОРКА СЕЛЕКТА

                    $us_name = $_SESSION['id'];

                   $ecip_name = $db -> prepare("SELECT * FROM `info_auto` WHERE id_auto IN (SELECT `id_auto` FROM `add_user_auto` WHERE id_user = ?)");
                   $ecip_name -> execute(array($us_name,));
            foreach ($ecip_name as $auto) {
                echo "/n<option value = {$auto['id_auto']}>{$auto['name_auto']} {$auto['number']} </option>";
            }
                   echo '</select>
             </li>
             <li><input type = "button" class = "get_auto" value = "Добавить автомобиль"></li>
             <li><input type = "submit" class = "auto_none" name =\'auto_none\' onclick="return confirm(\'Вы уверены что хотите удалить автомобиль? \')" value = "Удалить автомобиль"></li>
             <li><div id="error"></div></li>
         </ul >
         <ul class = "user_add p-0 d-flex flex-column align-items-end">
             <li>
                  <select type = "text" id = "user_names" name = "user_id">
                  <option value ="0">Водители</option>
                  </select>
             </li>
             <li><input type = "button" class = "create_user" value = "Добавить водителя"></li>
             <li><input type = "submit" class = "user_none" name ="user_none" onclick="return confirm(\'Вы уверены что хотите удалить водителя?\')" value = "Удалить водителя"></li>
             <li><div id="error"></div></li>
         </ul>
 </div>';


            $window->create_dann('user_milage_day','user_milage_night','user_rashod_oil','user_day_oil','user_get_oil','user_btn_oil');
        }
    }
//ФОРМА РАСЧЕТА БЕНЗИНА
    public function create_dann($day = 'milage_day', $night = 'milage_night', $rashod = 'rashod_oil', $day_oil = 'day_oil', $get_oil = 'get_oil', $btn_oil = 'btn_oil')
    {
        echo <<<DANN_
  <div class="dann row justify-content-center text-center">
       <ul>
            <li><input type="number" placeholder="Пробег утро" class = "$day" id="milage_day"></li>
            <li><input type="number" placeholder="Пробег вечер" class = "$night" id="milage_night"></li>     
            <li><input type="number" placeholder="Расход топлива" class = "$rashod" id="rashod_oil"></li>
            <li><input type="number" placeholder="Остаток при выезде" class = "$day_oil" id="day_oil"></li>
            <li><input type="number" placeholder="Заправил" class = "$get_oil" id="get_oil"></li>
            <li><input type="submit" value="Посчитать" class = "$btn_oil" id="btn_oil"></li>
       </ul>
               <div id="error"></div>
  </div>
       
DANN_;
    }

//ОКНО СOЗДАНИЯ АВТОМОБИЛЯ
    public function create_auto()
    {
        echo <<<_HEADER_
  <div class = "stick color_style window create_auto">
  <div class = "row">
  <div class = "col-12">
_HEADER_;
        $exit = new Commom;
        $exit->right_menu('close', 'Добавить автомобиль');
        echo <<<CREATE_AUTO
  </div>
  </div>
  <div class ="row text-center">
  <div class = "col-sm">
      <form method = "POST">
      <ul>
  <li><input type = "text" name = "create_name_auto"  id = "create_name_auto" placeholder = "Введите марку автомобиля" required></li>
  <li><input type = "text" name = "create_numer"  id = "create_numer" placeholder = "Введите номер автомобиля" required></li>
  <li><input type = "submit" name = "save_auto" id = "save_auto" value = "Сохранить"></li>
      </ul>
      </form>
        <div id="error"></div>
    </div>
    </div>
  </div>
CREATE_AUTO;
    }
    //ОКНО ДОБАВЛЕНИЯ ВОДИТЕЛЯ
    public function create_use()
    {
        echo <<<_HEADER_
  <div class = "stick color_style window create_use">
  <div class = "row">
  <div class = "col-12">
_HEADER_;
        $exit = new Commom;
        $exit->right_menu('close', 'Добавить водителя');
        echo <<<CREATE_USE
  </div>
  </div>
  <div class ="row text-center">
  <div class = "col-sm">
      <form method = "POST">
      <ul>
  <li><input type = "text" name = "add_firstname"  id = "add_firstname" placeholder = "Введите имя водителя" required></li>
  <li><input type = "text" name = "add_lastname"  id = "add_lastname" placeholder = "Введите фамилию водителя" required></li>
  <li><input type = "text" name = "user_company"  id = "user_company" placeholder = "Введите фирму водителя" required></li>
  <li><input type = "submit" name = "add_user" id = "add_user" value = "Сохранить"></li>
      </ul>
      </form>
        <div id="error"></div>
    </div>
    </div>
  </div>
CREATE_USE;
    }
}

class Other_stick
{
//ОКНО РЕЗУЛЬТАТА
    public function rezult()
    {
        echo '<div class="result stick color_style animated bounceOutUp">';
        $menu = new Commom;
        $nav = new Show_form;
        $nav->register();
        $menu->right_menu('close', 'Результат');
        $nav->form_nav();
        echo <<<REZULT_
       <div class="info d-flex flex-column align-items-start mt-4">
            <div class="probeg"></div>
            <div class="minusoil"></div>
            <div class="rezult_get_oil"></div>
            <div class="ost_night"></div>
        </div>
    </div>
REZULT_;
    }
}
class istory {
    public function istory_oil(){
        echo '<h1 class="text-center">История</h1>
                <ul class=" row justify-content-between">
                    <li class="data_istory"><p>Дата</p></li>
                    <li class="name_istory"><p>Водитель</p></li>
                    <li class="night_probeg_istory"><p>Пробег вечер</p></li>
                    <li class="probeg_istory"><p>Проехал за день</p></li>
                    <li class="get_oil_istory"><p>Заправил</p></li>
                    <li class="ostatock_oil_istory"><p>Остаток в баке</p></li>
                </ul>';

    }
}

?>
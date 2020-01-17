<?php

class Show_form
{
    //ОКНО МЕНЮ
    public function form_nav($data)
    {
        echo '<div class = "guest_menu  stick color_style">';
        $closes = new Commom;
        $closes->right_menu('close', 'Меню');
        echo '<div class="row mt- d-flex flex-column align-items-end row" >';
        //ЕСЛИ ПОЛЬЗОВАТЕЛЬ ГОСТЬ
        if ($data === 'guest') {
            echo <<<GUEST_NAV
<form> 
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
        } else if ($data == 'user') {
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

            if (!empty($_POST['log_out'])) {
                session_unset();
                session_destroy();
                Header("Location: http://localhost/past/");
            }
        }
    }

    //ОКНО РЕГИСТРАЦИИ
    public function register()
    {
        echo <<<REGISTRATION_head
<div class = "register window stick color_style">
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
    <p>....<br>....<br>....<br>....</p>
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
        } else if ($data === 'user') { //ЕСЛИ ПОЛЬЗОВАТЕЛЬ АВТОРИЗОВАН ВЫВЕСТИ ОКНО ИНФОРМАЦИИ АВТОМОБИЛЯ
            echo '<div class ="user_guest  d-flex justify-content-between mt-5">
         <ul class = "p-0">
             <li>
                 <p><select type = "text" id = "i_auto" name = "i_auto">
                 <option value = 0>Выберете автомобиль</option>';
//ТУТ ВЫБОРКА СЕЛЕКТА
                    $name = $db->prepare("SELECT * FROM `info_auto` WHERE id_user = ?");
                    $us_name = $_SESSION['id'];
                    $name->execute(array($us_name));
                    $name_auto = $name->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($name_auto as $auto) {
                echo "/n<option value = {$auto['id_auto']}>{$auto['name_auto']} {$auto['number']} </option>";
            }
                   echo '</select></p>
             </li>
             <li><input type = "button" class = "get_auto" value = "Добавить автомобиль"></li>
             <li><input type = "submit" class = "auto_none" name =\'auto_none\' onclick="return confirm(\'Вы уверены что хотите удалить автомобиль? \')" value = "Удалить автомобиль"></li>
         </ul >
         <ul class = "p-0 d-flex flex-column align-items-end">
             <li>
                  <p><select type = "text" id = "user_names" name = "user_id">
                  <option value ="0">Водители</option>
                  </select></p>
             </li>
             <li><input type = "button" class = "create_user" value = "Добавить водителя"></li>
             <li><input type = "submit" class = "user_none" name ="user_none" onclick="return confirm(\'Вы уверены что хотите удалить водителя?\')" value = "Удалить водителя"></li>
         </ul>
 </div>';
        }
        echo <<<DANN_
  <div class="dann row justify-content-center">
       <ul>
            <li><input type="number" placeholder="Пробег утро" id="milage_day"></li>
            <li><input type="number" placeholder="Пробег вечер" id="milage_night"></li>     
            <li><input type="number" placeholder="Расход топлива" id="rashod_oil"></li>
            <li><input type="number" placeholder="Остаток при выезде" id="day_oil"></li>
            <li><input type="number" placeholder="Заправил" id="get_oil"></li>
            <li><input type="submit" value="Посчитать" id="btn_oil"></li>
       </ul>
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
  <li><input type = "text" name = "add_lastname"  id = "add_lastname" placeholder = "Введите email водителя" required></li>
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
        $menu->right_menu('menu', 'Результат');
        $navigation = new Show_form;
        $navigation->form_nav('user');
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


?>
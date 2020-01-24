<?php require_once 'view/php/header.php'; ?>
<body>
<div class="general stick color_style animated bounceInLeft">
    <?php //НАСТРОЙКА ИНТЕРФЕЙСА НЕ ЗАРЕГИСТРИРОВАННОГО ПОЛЬЗОВАТЕЛЯ
    $navigation = new Show_form;
    $buttons = new Commom;
    $general = new General_stick;
    $istory = new istory;
    if (empty($_SESSION['id']) && empty($_SESSION['email']) && empty($_SESSION['lastname'])) {
        $buttons->right_menu('menu animated infinite delay-1s rubberBand', 'Расход топлива');
        $navigation->form_nav();
        $navigation->register();
        $general->enter_oil('guest', '<p>Зарегистрированные пользователи получают возможность вести журнал расхода топлива автомобиля, добавлять к
                автомобилю экипаж, общаться во внутреннем чате, форуме и многое другое!</p>');
       echo '</div>';
    } else { //НАСТРОЙКА ИНТЕРФЕЙСА ЗАРЕГИСТРИРОВАННОГО ПОЛЬЗОВАТЕЛЯ
        $buttons->right_menu('menu animated infinite delay-1s rubberBand', 'Расход топлива');
        $navigation->form_nav();
        $general->enter_oil('user');
        echo '</div>';
       /* echo '<div class="istory stick color_style animated bounceInLeft">';
        $istory->istory_oil();
       echo '</div>'; */
    }
    ?>

<?php
$rezult = new Other_stick;
$rezult->rezult();
?>
</body>
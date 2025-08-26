<?php

class playGame 
{




   
    
}
$playgame = new playGame();

if (isset($_POST['refresh_coloda'])) {
require_once('onloadrefreshcoloda.php');
$refresh = new refreshColoda;
$refresh->refreshColoda();
}

if (isset($_POST['getscore'])) { // вызываем ход игрока, затем ход компьютера, возвращаем json-массив со значениями
require_once('init.php');
require_once('random.php');
require_once('usermove.php');
$init = new iniT();
$coloda_values = $init->getCardValues(); // колода карт и количество карт в тхт фаиле

$random = new random();
$card = $random->getCard();

$user_move = new userMove($card, $coloda_values);
$move = $user_move->userMove();

//$user_move = $playgame->userMove();
//$move_arr = [$user_move];

echo json_encode($move);
}

if (isset($_POST['finish'])) { // при нажатии стоп ход компьютера
require_once('dealer.php');


$comp_move = new compMove;
$dealer_move = $comp_move->userStop(0, 0, ''); // первый ход компа очки 0 сумма карт 0 пустая строка карты
echo json_encode($dealer_move);
}
    
if (isset($_POST['final'])) { // при нажатии кнопки раскрыться подведение итогов
require_once('compare_score.php');

$compare = new compareScore;

$compare->compareScore();
}
?>


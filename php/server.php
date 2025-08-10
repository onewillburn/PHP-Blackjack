<?php

class playGame 
{

public function __construct() {
    $this->cards = ['6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A'];
    $this->valueofcard = ['bubi', 'kresti', 'chervi', 'piki'];
    $this->cardstring = '';
    $this->coloda = [];
    $this->usercard = '';
    $this->point = 0;

}
public function createColoda() {                   //   функция создания колоды карт/ перебираем карты из cards и комбинируем с мастью valueofcard
    foreach($this->cards as $key) {
        foreach($this->valueofcard as $value) {
        $cardstring = $key.$value;
        array_push($this->coloda, $cardstring);
        }
    }
}
private function getCard() {                          // получаем рандомную карту из колоды
    $this->usercard = $this->coloda[rand(0, 35)];
    return $this->usercard;
}
private function getPoint() {                    // функция присваивания очков карте
     
    if($this->usercard[0] == '6') {
        $this->point = 6;
    }
    if($this->usercard[0] == '7') {
        $this->point = 7;
        }
    if($this->usercard[0] == '8') {
        $this->point = 8;
        }
    if($this->usercard[0] == '9') {
        $this->point = 9;
        }
    if($this->usercard[0] == 'T') {
        $this->point = 10;
        }
    if($this->usercard[0] == 'J') {
        $this->point = 2;
        }
    if($this->usercard[0] == 'Q') {
        $this->point = 3;
        }
    if($this->usercard[0] == 'K') {
        $this->point = 4;
        }
    if($this->usercard[0] == 'A') {
        $this->point = 11;
        }
    return $this->point;
}

private function cardIMG() {                              // функция создания пути до изображения карты в папке проекта
    $playercard = $this->getCard();
    $suit = '';
    $suit = substr($playercard, 1);
    $imgdir = 'img/'.$suit.'/'.$playercard.'.jpg';
    return $imgdir;
}

public function userMove() {                                       // ФУНКЦИЯ ХОДА ИГРОКА
                                                                   // берем случайную карту
    $this->getCard();
    $usercard = $this-> cardIMG();                                  // находим путь до ее изображения в папке
    $point = $this->getPoint();
    $user_card_arr = [];                                           //создаем массив значений
    $scorepost = json_decode($_POST['getscore']);                   // получаем предыдущий счет игрока из первой части json массива
    $score = $scorepost[0];
    (int)$score += (int)$point;                                      // добавляем к предыдущему счету текущие очки
    $sumofcard = $scorepost[1]; 
    $sumofcard++;                                                  // добавляем 1 к сумме взятых карт
    $cardstring = '<img src="'.$usercard.'" id="cardimg">';
    $scorestring = 'Очки: '.$score.'<br>';
    $user_card_arr['score'] = $score;
    $user_card_arr['cardstring'] = $cardstring;
    $user_card_arr['scorestring'] = $scorestring;
    $user_card_arr['sumofcard'] = $sumofcard; 
    return $user_card_arr;                                         // возвращаем массив значений очки/путьдоизображения/строка с очками
    }
    
    public function compMove($score, $sumofcard, $card_arr_string = '') {                                  // ФУНКЦИЯ ХОДА КОМПЬЮТЕРА 
        
        $comp_card_name = $this->getCard();                       // получаем случайную карту
        $compcard = $this-> cardIMG();                            // получаем изображение карты                
        $point = $this->getPoint();                               // получаем текущие очки
        $comp_card_arr = [];                                           // создаем пустой массив, куда будем класть значения
        
        
        $cardstring = '<img src="'.$compcard.'" id="rubashka">';
        $scorestring = 'Очки: '.$score.'<br>';
        
        $comp_card_arr['score'] = 0;
        
                
        $comp_card_arr['score'] += (int)$score;

        $comp_card_arr['cardstring'] = $card_arr_string;
        if($comp_card_arr['cardstring'] == '') {
            $comp_card_arr['cardstring'] = $cardstring;
        } else {

            $new_string = $comp_card_arr['cardstring'];
            $comp_card_arr['cardstring'] = $new_string.$cardstring;
        }

        $comp_card_arr['scorestring'] = $scorestring; 
        $comp_card_arr['sumofcard'] = $sumofcard;               // массив по аналогии с предыдущим, но добавлены 2 ячейки. compcard - карта компа
        $comp_card_arr['stop'] = false;                       // данная строка при false - продолжение игры, при true - комп останавилвиается
            
                                                              // ЛОГИКА ИИ 
        if ($score >= 21) {                                   // если очки больше либо равны 21 - стоп               
            $comp_card_arr['stop'] = true;
            return $comp_card_arr;
            
        }
        if ($score >= 17 && $score < 21) {                    // если очки больше, либо равны 17 и меньше 21 стоп с 50% вероятностью
            
         if (rand(0, 1) == 0){
              $comp_card_arr['stop'] = true;
              return $comp_card_arr;
         } else {  
            $comp_card_arr['stop'] = false;
            $sumofcard++;                                        // добавляем 1 к сумме взятых карт
            $comp_card_arr['sumofcard'] = $sumofcard; 
             (int)$score += (int)$point;                         // добавляем очки записываем в массив
             $comp_card_arr['score'] = $score;
             return $comp_card_arr;
         }
         
         
        }
        
        if ($score < 17) {
              
        $sumofcard++;                                                                   // добавляем 1 к сумме взятых карт
        $comp_card_arr['sumofcard'] = $sumofcard;                                      // если очки меньше 17 продолжаем игру
        (int)$score += (int)$point;                                                     // добавляем очки записываем в массив
        $comp_card_arr['score'] = $score;
        $comp_card_arr['stop'] = false;
        
        return $comp_card_arr;
        
        
        }
    }

    public function userStop($score = 0, $sumofcard = 0, $card_arr_string = '') { // Функция совершения ходов комптютера и возвращения их массивов
        $comp_move_check = $this->compMove($score, $sumofcard, $card_arr_string); // делаем ход
        
        if ($comp_move_check['stop'] == true) {
            
            return $comp_move_check;
        } else {
            $score = $comp_move_check['score'];
            $sumofcard = $comp_move_check['sumofcard'];
            $card_arr_string = $comp_move_check['cardstring'];
            return $this->userStop($score, $sumofcard, $card_arr_string);
            
        }
    }
    public function compareScore() {                              // ФУНКЦИЯ ПОДСЧЕТА ОЧКОВ
        $arr = json_decode($_POST['final']);
        
        $user_score = $arr[0];
        $comp_score = $arr[1];
        if ($user_score < 21 && $user_score > $comp_score){
             echo 'Вы победили. Ваш счет: '.$user_score.' . Счет соперника: '.$comp_score;
        }
        else if ($user_score > 21 && $user_score < $comp_score){
            echo 'Вы победили/ Ваш счет: '.$user_score.' . Счет соперника: '.$comp_score;
           }
        else if ($user_score < 21 && $user_score > $comp_score){
            echo 'Вы проиграли. Ваш счет: '.$user_score.' . Счет соперника: '.$comp_score;
           }
        else if ($user_score > 21 && $user_score > $comp_score){
            echo 'Вы проиграли. Ваш счет: '.$user_score.' . Счет соперника: '.$comp_score;
        }
        else if ($user_score == 21 && $comp_score < 21 or $comp_score > 21){ 
            echo 'Вы выиграли. Ваш счет: '.$user_score.' . Счет соперника: '.$comp_score;
        }
        else if ($comp_score == 21 && $user_score < 21 or $user_score > 21){ 
            echo 'Вы проиграли. Ваш счет: '.$user_score.' . Счет соперника: '.$comp_score;
        }
        else if ($comp_score == $user_score ) {
            echo 'Равный счет. Ваш счет: '.$user_score.' . Счет соперника: '.$comp_score;
        }
        
    }

}
$playgame = new playGame();
$playgame->createColoda();

if (isset($_POST['getscore'])) { // вызываем ход игрока, затем ход компьютера, возвращаем json-массив со значениями

$user_move = $playgame->userMove();
$move_arr = [$user_move];
echo json_encode($move_arr);
}

if (isset($_POST['finish'])) { // при нажатии кнопки "стоп" подведением итогов
$comp_move = $playgame->userStop();
echo json_encode($comp_move);
}
    
if (isset($_POST['final'])) {
$playgame->compareScore();
}
?>


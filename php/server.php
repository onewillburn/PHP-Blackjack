<?php

class playGame 
{

public function __construct() {
    $this->cards = ['2', '3', '4', '5' , '6', '7', '8', '9', 'T', 'J', 'Q', 'K', 'A'];
    $this->valueofcard = ['bubi', 'kresti', 'chervi', 'piki'];
    $this->cardstring = '';
    $this->coloda = [];
    $this->usercard = '';
    $this->point = 0;

}
public function createColoda() { //   функция создания колоды карт/ перебираем карты из cards и комбинируем с мастью valueofcard

    
    if(!is_dir('colodas')) {
        mkdir('colodas', 0777);
        if(file_exists('colodas/temp_coloda.txt')) {
        $deck = fopen('colodas/temp_coloda.txt', 'w');
    }}
    
    $value_deck = file_get_contents('colodas/temp_coloda.txt', true);
    if($value_deck == '') {

    foreach($this->cards as $key) {
        foreach($this->valueofcard as $value) {
        $cardstring = $key.$value;
        array_push($this->coloda, $cardstring);
        file_put_contents('colodas/temp_coloda.txt', serialize($this->coloda));
        }
     }
     } else {
            $this->coloda = unserialize(file_get_contents('colodas/temp_coloda.txt'));
        }
    

return count($this->coloda);
}

public function getCard() {       
                    // получаем рандомную карту из колоды
    $this->coloda = unserialize(file_get_contents('colodas/temp_coloda.txt'));
    $this->usercard = $this->coloda[rand(0, (count($this->coloda) - 1))];
    $delete_key = array_search($this->usercard, $this->coloda);
    unset($this->coloda[$delete_key]);
    file_put_contents('colodas/temp_coloda.txt', "");
    file_put_contents('colodas/temp_coloda.txt', serialize($this->coloda));
    return $this->usercard;
}
    
    

private function getPoint() {                    // функция присваивания очков карте
    if($this->usercard[0] == '2') {
        $this->point = 2;
    }
    if($this->usercard[0] == '3') {
        $this->point = 3;
        }
    if($this->usercard[0] == '4') {
        $this->point = 4;
        }
    if($this->usercard[0] == '5') {
        $this->point = 5;
        }
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
        $this->point = 10;
        }
    if($this->usercard[0] == 'Q') {
        $this->point = 10;
        }
    if($this->usercard[0] == 'K') {
        $this->point = 10;
        }
    if($this->usercard[0] == 'A') {
        $this->point = 0;
        }
    return $this->point;
}

private function cardIMG($cardvalue = 0) {                              // функция создания пути до изображения карты в папке проекта
    
    $suit = '';
    $suit = substr($cardvalue, 1);
    $imgdir = 'img/'.$suit.'/'.$cardvalue.'.jpg';
    return $imgdir;
}

public function userMove() {  // ФУНКЦИЯ ХОДА ИГРОКА
    $scorepost = json_decode($_POST['getscore']); 
    $score = $scorepost[0];                 // добавляем к предыдущему счету текущие очки
    $sumofcard = $scorepost[1];
    $coloda_sum = $scorepost[2];                                   
    $coloda_count = $this->createColoda() - 1;
    $cardvalue = $this->getCard();
    $usercard = $this-> cardIMG($cardvalue);                                  // находим путь до ее изображения в папке
    $point = $this->getPoint();
    (int)$score += (int)$point; 
    $sumofcard++; 
    

                
                                                    // берем случайную карту
    
    $user_card_arr = [];                                           //создаем массив значений
                       // получаем предыдущий счет игрока из первой части json массива
                                                     // добавляем 1 к сумме взятых карт
    $cardstring = '<img src="'.$usercard.'" id="cardimg">';
    
    $user_card_arr['score'] = $score;
    $user_card_arr['cardstring'] = $cardstring;
    $user_card_arr['sumofcard'] = $sumofcard;
    $user_card_arr['acessum'] = 0;
    $user_card_arr['cardvalue'] = $cardvalue[0];
    $user_card_arr['coloda_count'] = $coloda_count;
    return $user_card_arr;                                         // возвращаем массив значений очки/путьдоизображения/строка с очками
    }
    
    public function compMove($score = 0, $sumofcard = 0, $card_arr_string = '') {     // ФУНКЦИЯ ХОДА КОМПЬЮТЕРА 
        
        $comp_card_name = $this->getCard();                       // получаем случайную карту
        $compcard = $this-> cardIMG();                            // получаем изображение карты                
        $point = $this->getPoint();                               // получаем текущие очки
        $comp_card_arr = [];                                           // создаем пустой массив, куда будем класть значения
        
        
        $cardstring = '<img src="'.$compcard.'" id="cardimg">'; 
        $comp_card_arr['score'] = 0;
        $comp_card_arr['score'] += (int)$score;
        $comp_card_arr['cardstring'] = $card_arr_string;
        if($comp_card_arr['cardstring'] == '') {
            $comp_card_arr['cardstring'] = $cardstring;
        } else {

            $new_string = $comp_card_arr['cardstring'];
            $comp_card_arr['cardstring'] = $new_string.$cardstring;
        } 
        $comp_card_arr['sumofcard'] = $sumofcard; // массив по аналогии с предыдущим, но добавлены 2 ячейки. compcard - карта компа
        $comp_card_arr['stop'] = false; // данная строка при false - продолжение игры, при true - комп останавилвиается
        
        $full_arr = $this->playNumbers($score, $sumofcard, $point, $comp_card_arr);// запускаем функцию стратегии
        return $full_arr;
        } 
        

        public function playNumbers($score = 0, $sumofcard = o, $point = 0, $comp_card_arr = [])  { // ЛОГИКА РАБОТЫ С ОЧКАМИ (игра на короткую перспективу)
                        
        if ($score >= 21) {                                   // если очки больше либо равны 21 - стоп               
            $comp_card_arr['stop'] = true;
            
            
        }


        if ($score >= 17 && $score < 21) {                    // если очки больше, либо равны 17 и меньше 21 стоп с 50% вероятностью
            
         if (rand(0, 2) == 0){
              $comp_card_arr['stop'] = true;
             
         } else {  
            $comp_card_arr['stop'] = false;
            $sumofcard++;                                        // добавляем 1 к сумме взятых карт
            $comp_card_arr['sumofcard'] = $sumofcard; 
             (int)$score += (int)$point;                         // добавляем очки записываем в массив
             $comp_card_arr['score'] = $score;
             
         }
        } 
         
        
        
        if ($score < 17) {
              
        $sumofcard++;                                                                   // добавляем 1 к сумме взятых карт
        $comp_card_arr['sumofcard'] = $sumofcard;                                      // если очки меньше 17 продолжаем игру
        (int)$score += (int)$point;                                                     // добавляем очки записываем в массив
        $comp_card_arr['score'] = $score;
        $comp_card_arr['stop'] = false;
        

        }
        return $comp_card_arr;
    
    
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
            echo 'Вы победили. Ваш счет: '.$user_score.' . Счет соперника: '.$comp_score;
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


if (isset($_POST['getscore'])) { // вызываем ход игрока, затем ход компьютера, возвращаем json-массив со значениями

$user_move = $playgame->userMove();
$move_arr = [$user_move];

echo json_encode($move_arr);
}

if (isset($_POST['finish'])) { // при нажатии стоп ход компьютера

$comp_move = $playgame->userStop(0, 0, ''); // первый ход компа очки 0 сумма карт 0 пустая строка карты
echo json_encode($comp_move);
}
    
if (isset($_POST['final'])) { // при нажатии кнопки раскрыться подведение итогов
$playgame->compareScore();
}
?>


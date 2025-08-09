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
public function createColoda() {
    foreach($this->cards as $key) {
        foreach($this->valueofcard as $value) {
        $cardstring = $key.$value;
        array_push($this->coloda, $cardstring);
        }
    }
}
private function getCard() {
    $this->usercard = $this->coloda[rand(0, 35)];
    return $this->usercard;
}
private function getPoint() {
    
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

private function cardIMG() {
    $playercard = $this->getCard();
    $suit = '';
    $suit = substr($playercard, 1);
    $imgdir = 'img/'.$suit.'/'.$playercard.'.jpg';
    return $imgdir;
}

public function userMove() {
 
    $this->getCard();
    $usercard = $this-> cardIMG();
    $point = $this->getPoint();
    $user_card_arr = [];
    $scorepost = json_decode($_POST['getscore']);
    $score = $scorepost[0];
    (int)$score += (int)$point;
    $cardstring = '<img src="'.$usercard.'" id="cardimg">';
    $scorestring = 'Очки: '.$score.'<br>';
    $user_card_arr['score'] = $score;
    $user_card_arr['cardstring'] = $cardstring;
    $user_card_arr['scorestring'] = $scorestring;
    return $user_card_arr;
    }
    public function compMove() {
        
        $comp_card_name = $this->getCard();
        $compcard = 'img/rubashka/rubashka.jpg';
        $point = $this->getPoint();
        $card_arr = [];
        $scorepost = json_decode($_POST['getscore']);
        $score = $scorepost[1];
        $cardstring = '<img src="'.$compcard.'" id="rubashka">';
        $scorestring = 'Очки: '.$score.'<br>';

        $comp_card_arr['score'] = $score;
        $comp_card_arr['cardstring'] = $cardstring;
        $comp_card_arr['scorestring'] = $scorestring;
        $comp_card_arr['compcard'] = $compcard;
        $comp_card_arr['stop'] = false;
               
        if ($score >= 21) {
            $comp_card_arr['stop'] = true;
            return $comp_card_arr;
            error_log('Comp stopes score >=21 . Score = '.$score);
        }
        if ($score >= 17 && $score < 21) {
            
         if (rand(0, 1) == 0){
              $comp_card_arr['stop'] = true;
         } else {  $comp_card_arr['stop'] = false;
             (int)$score += (int)$point;
             $comp_card_arr['score'] = $score;
         }
         error_log('Comp 50/50 decision: ').$comp_card_arr['stop'] = true ? error_log('STOP. ') : error_log('CONTINUE. ').' Score = '.$score;
         return $comp_card_arr;
        }
        
        if ($score < 17) {
        (int)$score += (int)$point;
        $comp_card_arr['score'] = $score;
        return $comp_card_arr;
        error_log('Comp continue score  < 17. Score = '.$score);
        }
    }
    public function compareScore() {
        $arr = json_decode($_POST['finish']);
        
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

if (isset($_POST['getscore'])) {

$user_move = $playgame->userMove();
$comp_move = $playgame->compMove();
$move_arr = [$user_move, $comp_move];
echo json_encode($move_arr);
}

if (isset($_POST['finish'])) {
$playgame->compareScore();
    }

?>


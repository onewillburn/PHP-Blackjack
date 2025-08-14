<?php

class iniT
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
    
yield $this->coloda;
yield count($this->coloda);
}

public function getCardValues() {
    $coloda_values = $this->createColoda();
    $result = [];
    foreach ($coloda_values as $value) {
    array_push($result, $value);
    }
    return $result;
}
}

?>
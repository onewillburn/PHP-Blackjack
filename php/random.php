<?php

class random {
public function __construct() {
    $this->card_values = [];
}

    public function getCard() {       // получаем рандомную карту из колоды
        
$this->card_values = unserialize(file_get_contents('colodas/temp_coloda.txt'));
$this->usercard = $this->card_values[rand(0, (count($this->card_values)))];
$delete_key = array_search($this->usercard, $this->card_values);
unset($this->card_values[$delete_key]);
file_put_contents('colodas/temp_coloda.txt', "");
file_put_contents('colodas/temp_coloda.txt', serialize($this->card_values));
$img = $this->cardIMG($this->usercard);
$point = $this->getPoint($this->usercard);
$card = $this->usercard;
$card_arr = [$card, $point, $img];
return  $card_arr;
}



private function getPoint() { 
                                 // функция присваивания очков карте
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
}

?>
<?php

class userMove {

    public function __construct($card, $coloda_values) {
    $this->card_img = $card[2];
    $this->point = $card[1];
    $this->card = $card[0];
    $this->coloda_values = $coloda_values;
    }

    public function userMove() {  // ФУНКЦИЯ ХОДА ИГРОКА
        $scorepost = json_decode($_POST['getscore']);                    // получаем предыдущий счет игрока из первой части json массива
        $score = $scorepost[0];                                         // добавляем к предыдущему счету текущие очки
        $sumofcard = $scorepost[1];
        $coloda_sum = $scorepost[2];                                   
        $coloda_count = $this->coloda_values[1] - 1;
        $cardvalue = $this->card;                                      // берем случайную карту
        $usercard = $this->card_img;                                  // находим путь до ее изображения в папке
        $point = $this->point;
        (int)$score += (int)$point; 
        $sumofcard++;                                                 // добавляем 1 к сумме взятых карт
                                                
        $user_card_arr = [];                                          //создаем массив значений                                  
                           
                                        
        $cardstring = '<img src="'.$usercard.'" id="cardimg">';
        
        $user_card_arr['score'] = $score;
        $user_card_arr['cardstring'] = $cardstring;
        $user_card_arr['sumofcard'] = $sumofcard;
        $user_card_arr['acessum'] = 0;
        $user_card_arr['cardvalue'] = $cardvalue[0];
        $user_card_arr['coloda_count'] = $coloda_count;
        
        return $user_card_arr;                                         // возвращаем массив значений очки/путьдоизображения/строка с очками
        }
}
?>
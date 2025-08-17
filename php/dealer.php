<?php


class compMove {

    public function __construct() {
        require_once('random.php');
        $this->random = new random;
        
        
        
        
    }
     
    public function compMove($score = 0, $sumofcard = 0, $card_arr_string = '') {     // ФУНКЦИЯ ХОДА КОМПЬЮТЕРА 
        $card_arr = $this->random->getCard();
        $this->card = $card_arr[0];
        $this->point = $card_arr[1];
        $this->img = $card_arr[2];
        $comp_card_name = $this->card;                       // получаем случайную карту
        $compcard = $this->img;                            // получаем изображение карты                
        $point = $this->point;                               // получаем текущие очки
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
    

    public function userStop($score = 0, $sumofcard = 0, $card_arr_string = '', $coloda_count = 0) { // Функция совершения ходов комптютера и возвращения их массивов
        
        $comp_move_check = $this->compMove($score, $sumofcard, $card_arr_string, $coloda_count); // делаем ход
        
        if ($comp_move_check['stop'] == true) {
            $coloda_count = count(unserialize(file_get_contents('colodas/temp_coloda.txt')));
            $comp_move_check['coloda_count'] = $coloda_count;
            return $comp_move_check;
        } else {
            $score = $comp_move_check['score'];
            $sumofcard = $comp_move_check['sumofcard'];
            $card_arr_string = $comp_move_check['cardstring'];
            
            return $this->userStop($score, $sumofcard, $card_arr_string);
            
        }
    }
}

?>
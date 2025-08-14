<?php

class compareScore {

    

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

?>
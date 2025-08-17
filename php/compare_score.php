<?php

class compareScore {

    

    public function compareScore() {    
        
        
        file_put_contents('colodas/temp_coloda.txt', ""); // обновляем колоду
        
        // ФУНКЦИЯ ПОДСЧЕТА ОЧКОВ
        $arr = json_decode($_POST['final']);
        
        $user_score = $arr[0];
        $comp_score = $arr[1];
        if ($user_score < 21 && $user_score > $comp_score && $user_score < 21){ // 17 > 10
             echo 'Вы победили. Ваш счет: '.$user_score.' . Счет соперника: '.$comp_score;
        }
        else if ($user_score > 21 && $user_score < $comp_score){ // 22 < 23
            echo 'Вы победили. Ваш счет: '.$user_score.' . Счет соперника: '.$comp_score;
           }
        else if ($user_score < 21 && $user_score < $comp_score && $comp_score < 21){ // 17 < 18
            echo 'Вы проиграли. Ваш счет: '.$user_score.' . Счет соперника: '.$comp_score;
           } 
           else if ($user_score < 21 && $user_score < $comp_score && $comp_score > 21){ // 17 < 18
            echo 'Вы выиграли. Ваш счет: '.$user_score.' . Счет соперника: '.$comp_score;
           }
        else if ($user_score > 21 && $user_score > $comp_score){ // 23 > 22
            echo 'Вы проиграли. Ваш счет: '.$user_score.' . Счет соперника: '.$comp_score;
        }
        else if ($user_score == 21 && $comp_score !== 21 ){ // 21 ! 22
            echo 'Вы выиграли. Ваш счет: '.$user_score.' . Счет соперника: '.$comp_score;
        }
        else if ($comp_score == 21 && $user_score !== 21){ // 21 ! 19
            echo 'Вы проиграли. Ваш счет: '.$user_score.' . Счет соперника: '.$comp_score;
        }
        else if ($comp_score == $user_score ) {
            echo 'Равный счет. Ваш счет: '.$user_score.' . Счет соперника: '.$comp_score;
        } else {
        echo 'Ошибка. Ваш счет: '.$user_score.' . Счет соперника: '.$comp_score;
        }
    }

}

?>
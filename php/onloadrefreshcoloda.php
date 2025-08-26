<?php

class refreshColoda {
    function refreshColoda() {
if($_POST['refresh_coloda']) {
$card_count = unserialize(file_get_contents('colodas/temp_coloda.txt'));
if($card_count !== '') {
    file_put_contents('colodas/temp_coloda.txt', "");
    echo 'up';
}
}
}
}
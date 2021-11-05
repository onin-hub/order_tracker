<?php
$text = "Barcelona, Catalunya, Spain";
$array = explode(",",$text);
$first_word = $array[0];
$last_word  = $array[count($array)-1];

echo $first_word. ', '.$last_word; 

?>
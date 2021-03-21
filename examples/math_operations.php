<?php
   
    $q = floor(($interval->format('%a'))/7);    //Divisione intera per 7 
    //echo $q;
    //echo "</br>";
    $r = $q%5;  //Resto modulo 5
    echo $r;
?>
<?php
    //Differenza tra oggetti DateTime    
    $datetime1 = new DateTime('2016-09-30');
    $datetime2 = new DateTime('2016-10-07');
    $interval = $datetime2->diff($datetime1);
    echo $interval->format('%R%a days');
    echo "</br>";

?>
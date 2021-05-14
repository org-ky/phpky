<?php
class A 
{ 
    function __construct() 
    { 
        $a = func_get_args(); 
        $i = func_num_args(); 
        if (method_exists($this,$f='__construct'.$i)) { 
            call_user_func_array(array($this,$f),$a); 
        } 
    } 
    
    function __construct1($a1) 
    { 
        echo('Chiamato costruttore con un parametro: '.$a1.PHP_EOL); 
    } 
    
    function __construct2($a1,$a2) 
    { 
        echo('Chiamato costruttore con due parametri: '.$a1.','.$a2.PHP_EOL); 
    } 
    
    function __construct3($a1,$a2,$a3) 
    { 
        echo('Chiamato costruttore con tre parametri: '.$a1.','.$a2.','.$a3.PHP_EOL); 
    } 
} 
?>
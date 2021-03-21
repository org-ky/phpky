<?php
//Array semplice
$array = array("foo", "bar", "hello", "world");

echo "Array semplice senza keys<br>";
var_dump($array);

echo "<br><br>";

$array = array(
    "foo" => "foo",
    "bar" => "bar",
    "hello"   => "hello",
    "world"  =>"world"
);

echo "Array con keys <br>";
var_dump($array);

echo "<br><br>";

$array = array(
    "foo",
    "bar",
    6   => "hello",
    "world"
);

echo "Array con keys non per tutti gli elementi<br>";
var_dump($array);

echo "<br><br>";

echo "Oggetto semplice<br>";
class SimpleClass
{
    // dichiarazione di proprietà
    public $foo = 'foo';
    public $bar = 'bar';
    public $a = 10;
    public $b = 100;

    // dichiarazione di metodi
    public function mostraVar() {
        echo $this->foo;
    }
}

$instanceSC = new SimpleClass();
var_dump($instanceSC);

?>
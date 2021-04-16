<?php

class ArcInsertLink extends VE1_Service implements VE1_IService
{

    function __construct($connector, $url, $method)
    {
        parent::__construct($connector, $url, $method);
    }

    public function validate($input)
    {
  		  //TODO verificare i parametri di input qui...
    	  return $this->runValidation();
    }

    public function execute($input)
    {
          //TODO gestire l'eccezione
    	  $serviceResult=$this->dispatch($input);
    	  $out=$serviceResult;

    	  return $out;
    }
}
?>

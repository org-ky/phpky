<?php

class ArcGetAllLinks extends VE3_Service implements VE3_IService
{

    public function validate($input){

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

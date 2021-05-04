<?php

  class MSOnlineGetAccessToken extends VE3_Service implements VE3_IService
  {

    public function validate($input){
    	return $this->runValidation();
    }

    public function execute($input)
    {
    	//TODO gestire l'eccezione
    	$serviceResult=$this->dispatch($input);
    	return $serviceResult;
    }
    
  }
?>

<?php

class DYNCRMAPI_GetContattoByCodiceClienteBeanIn implements VE3_IBeanIn
{

    private $codiceCliente = null;

    function __construct()
    {
    }

    function setCodiceCliente($codiceCliente)
    {
		  $this->codiceCliente = $codiceCliente;
	  }

	  function getCodiceCliente(){
		  return $this->codiceCliente;
	  }

    function getDataToSend(){
		  $data=array($this->codiceCliente);
      return $data;
	  }

}
?>

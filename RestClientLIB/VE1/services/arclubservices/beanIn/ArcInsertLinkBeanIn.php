<?php

class ArcInsertLinkBeanIn implements VE3_IBeanIn
{

	  private $chiave;
    private $valore;
    private $tipo;
    private $stato;

    function __construct()
    {

    }

	  function setChiave($chiave)
    {
		    $this->chiave=$chiave;
	  }

	  function getChiave()
    {
		    return $this->chiave;
	  }

    function setValore($valore)
    {
		    $this->valore=$valore;
	  }

	  function getValore()
    {
		    return $this->valore;
	  }

    function setTipo($tipo)
    {
		    $this->tipo=$tipo;
	  }

	  function getTipo()
    {
	  	  return $this->tipo;
	  }

    function setStato($stato)
    {
		    $this->stato=$stato;
	  }

	  function getStato()
    {
		    return $this->stato;
	  }

    function getDataToSend()
    {
		    $data=new StdClass();

		    $data->chiave=$this->chiave;
        $data->valore=$this->valore;
        $data->tipo=$this->tipo;
        $data->stato=$this->stato;

		    return $data;
	  }

}
?>

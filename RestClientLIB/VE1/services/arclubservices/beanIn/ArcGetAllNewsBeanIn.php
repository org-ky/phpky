<?php

class ArcGetAllNewsBeanIn implements VE1_IBeanIn
{

    private $numeroElementiPagina;
    private $offset;

    function __construct()
    {
        $this->customData = array();
    }

    function setNumeroElementiPagina($numeroElementiPagina)
    {
	$this->numeroElementiPagina=$numeroElementiPagina;
    }

    function getNumeroElementiPagina()
    {
	return $this->numeroElementiPagina;
    }

    function setOffset($offset)
    {
	$this->offset=$offset;
    }

    function getOffset()
    {
	return $this->offset;
    }

    function setCustomData($customData)
    {
	$this->customData=$customData;
    }

    function getCustomData()
    {
	return $this->customData;
    }

    function getDataToSend(){

	$data=new StdClass();

	$data->numeroElementiPagina=$this->numeroElementiPagina;
	$data->offset=$this->offset;

    	foreach ($this->customData as $key => $value){

		switch ($key){
			case 'dataDa':
			case 'dataA':
			case 'titolo':
			case 'categoria':
			case 'tipo':
			case 'pubblicato':
				$data->$key=$value;
				break;
	        }

	}

	return $data;
	
    }

}
?>

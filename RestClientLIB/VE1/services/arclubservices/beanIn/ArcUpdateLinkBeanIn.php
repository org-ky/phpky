<?php

class ArcUpdateLinkBeanIn implements VE1_IBeanIn
{

    private $id;

    function __construct()
    {
        $this->customData = array();
    }

    function setId($id)
    {
        $this->id=$id;
    }

    function getId()
    {
	return $this->id;
    }

    function setCustomData($customData)
    {
	$this->customData = $customData;
    }

    function getCustomData()
    {
        return $this->customData;
    }

    function getDataToSend()
    {
	$data=new StdClass();

	$data->id=$this->id;

        foreach ($this->customData as $key => $value)
        {

           switch ($key){
          	case 'chiave':
          	case 'valore':
                case 'tipo':
                case 'stato':
            		$data->$key=$value;
            		break;
           }

	}

	return $data;
    }

}
?>

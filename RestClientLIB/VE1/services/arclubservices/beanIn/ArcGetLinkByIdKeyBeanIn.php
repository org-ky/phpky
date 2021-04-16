<?php

class ArcGetLinkByIdKeyBeanIn implements VE1_IBeanIn
{

    function __construct()
    {
        $this->customData = array();
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

	foreach ($this->customData as $key => $value)
        {
		switch ($key){
		    case 'id':
		    case 'chiave':
			    $data->$key=$value;
		            break;
		}
	}

	return $data;
    } 

}
?>

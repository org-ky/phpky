<?php

class ArcGetAllNews extends VE1_Service implements VE1_IService
{

    public function validate($input){

	//TODO verificare i parametri di input qui...
    	return $this->runValidation();

    }

    public function execute($input)
    {
     	$serviceResult=$this->dispatch($input);
    	$out=$serviceResult;

        //Data elaboration if necessary
        /*
	$data=$out->Payload;
        $newData=array();
        foreach ($data as $value){
            $obj=new stdClass();
            $obj->id = isset($value->ID) ? $value->ID : '';
            $obj->titolo = isset($value->titolo) ? $value->titolo : '';
            $obj->contenuto = isset($value->contenuto) ? $value->contenuto : '';
            $obj->immagine = isset($value->immagine) ? $value->immagine : '';
            $obj->data = isset($value->data) ? $value->data : '';
            $obj->pubblicato = isset($value->pubblicato) ? $value->pubblicato : '';
            $obj->categoria = isset($value->categoria) ? $value->categoria : '';
            $obj->url_video = isset($value->url_video) ? $value->url_video : '';
            $obj->tipo_video = isset($value->tipo_video) ? $value->tipo_video : '';
            $obj->timestamp = isset($value->timestamp) ? $value->timestamp : '';
            $obj->id_user = isset($value->id_user) ? $value->id_user : '';
            array_push($newData, $obj);
        }

	//Order data before return them
        usort($newData, "ArcGetAllNews::cmp");

        $out->Payload=$newData;
	*/

    	return $out;

    }

    public static function cmp($a, $b) 
    {
        return strcmp($b->timestamp, $a->timestamp);
    }

}
?>

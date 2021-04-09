<?php

class MSOnlineConnector extends VE1_Connector implements VE1_IRestConnector{

	public function __construct($endPoint){

		//TODO i dati dinaminci devono essere presi da variabili di ambiente
		$config = array(
			'port'          => NULL,
			'cookie'        => FALSE,
			'timeout'       => 1000,
			'result_assoc'  => FALSE,
			'cache'         => FALSE,
			'tts'           => 3600,
			//'custom_cer'	=> __DIR__.'\rassegnastamparestlabconsulcesilocal.crt',
			'verbose'		=> TRUE,
		);

		RestClient::__construct($config, $endPoint);

	}

	public function doGet($url, $data){
		$result = parent::get($url, $data);
		return $this->wrapResult($result);
	}

	public function doPost($url, $data){
		$result = parent::postFormData($url, $data);
		return $this->wrapResult($result);
	}

	public function doPut($url, $data){
		$result = parent::put($url, $data);
		return $this->wrapResult($result);
	}

	public function doGetRest($url, $data){
		$result = parent::getRest($url, $data);
		return $this->wrapResult($result);
	}

  	public function doPatch($url, $data){
		$result = parent::patch($url, $data);
		return $this->wrapResult($result);
	}

  	public function doDelete($url, $data){
		$result = parent::delete($url, $data);
		return $this->wrapResult($result);
	}

	private function wrapResult($result){

		// CodEsito = 0: non c'è stato errore, tutto apposto...
		// CodEsito = 1: c'è stato un errore Esito e Messaggio presenti nella risposta
		// COdEsito = 2: c'è stato un errore Message presente nella risposta
		$r = new StdClass();
		$r->CodEsito="";
		$r->DescEsito="";
		$r->TraceGuid="";
		$r->ErrorsDetail=array();
		$r->Payload=array();

		if($result==null){
				// il servizio non ha restituito nulla
		}else{
            if(isset($result->CodEsito)){
                // Refactoring Servizi CRM
                $r=$result;
                if(!is_array($r->Payload)){
                    $r->Payload=array($result->Payload);
                }
            }else if(isset($result->Esito)){
				if(strtolower($result->Esito)=='ko'){
					// c'è stato un errore, sintassi, consistenza, ecc. ecc.
					$r->CodEsito=1;
					$r->DescEsito=$result->Messaggio;
				}else if(strtolower($result->Esito)=='ok'){
					// è andato tutto bene
					$r->CodEsito=0;
					$r->DescEsito=$result->Messaggio;
				}else{
					// Daje Peppe Inserire una loggata...
				}
			}else if(isset($result->Message)){
				$r->CodEsito=2;
				$r->DescEsito=$result->Message;
			}else{
				// se il risultato è un oggetto popolo il bean uno a uno
				// se il risultato è un array dovrò iterare il risultato e clonare il bean di input per ogni occorrenza restituita
				$r->CodEsito=0;
				if(is_array($result)){
					$r->Payload=$result;
				}else{
					$r->Payload=array($result);
				}
			}
		}


		return $r;
	}

}

?>

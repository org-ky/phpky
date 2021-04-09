<?php

class DYNCRMConnector extends VE3_Connector implements VE3_IRestConnector{

	public function __construct($endPoint){

		//TODO i dati dinaminci devono essere presi da varibili di ambiente Azure
		$config = array(
			'port'          => NULL,
			'auth'          => TRUE,
			'auth_type'     => 'bearer',
			'header'        => array('Content-Type'=>'application/json'),
			'header'        => array(
			                  'Content-Type'			=>'application/json',
			                  'codiceUtente'			=>'8293',
//									    'codiceChiamata'		=>$guid,
                        'codiceApplicazione'	=>'AreaRiservataClub5',
									      'localizzazioneTecnica'	=>'IT'
			),
			'cookie'        => FALSE,
			'timeout'       => 1000,
			'result_assoc'  => FALSE,
			'cache'         => FALSE,
			'tts'           => 3600,
			'custom_cer'	=> __DIR__.'\rassegnastamparestlabconsulcesilocal.crt',
			'verbose'		=> TRUE,

		);

        $this->token=null;

		RestClient::__construct($config, $endPoint);

	}

  private function getBearerToken(){
        $options=array();

        if($this->token==null){
            
            //TODO richiamo il metodo per ottenere il token
            $params = array('MSOnlineApiFactory', '', 'JSON', 'msonline_getaccesstoken_dyncrm');
            $tokenInfo = ServiceRenderer::toJSON($params);

            $this->token=$tokenInfo->getMainData()[0]->access_token;

            //$this->token='eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsIng1dCI6InU0T2ZORlBId0VCb3NIanRyYXVPYlY4NExuWSIsImtpZCI6InU0T2ZORlBId0VCb3NIanRyYXVPYlY4NExuWSJ9.eyJhdWQiOiIwMDAwMDAwMi0wMDAwLTAwMDAtYzAwMC0wMDAwMDAwMDAwMDAiLCJpc3MiOiJodHRwczovL3N0cy53aW5kb3dzLm5ldC9hNzk1MTIzNC0xZDdhLTRiZjctOTYyNS02MGZhZWQxNzVkZjIvIiwiaWF0IjoxNTY1MDk3NDAxLCJuYmYiOjE1NjUwOTc0MDEsImV4cCI6MTU2NTEwMTMwMSwiYWlvIjoiNDJGZ1lIZ2lYTlIxN1BPVGNPRVRaUUtYSXJrMkFRQT0iLCJhcHBpZCI6ImMwZWIxNjJlLTBjMTktNDMyOS04OWIwLTUzMTI2YjYyZTZmNiIsImFwcGlkYWNyIjoiMSIsImlkcCI6Imh0dHBzOi8vc3RzLndpbmRvd3MubmV0L2E3OTUxMjM0LTFkN2EtNGJmNy05NjI1LTYwZmFlZDE3NWRmMi8iLCJvaWQiOiIyYjE5MjZhNC03ODYyLTRmZmItOGNlOC1mNjNlMWZmYjFkZGQiLCJzdWIiOiIyYjE5MjZhNC03ODYyLTRmZmItOGNlOC1mNjNlMWZmYjFkZGQiLCJ0ZW5hbnRfcmVnaW9uX3Njb3BlIjoiRVUiLCJ0aWQiOiJhNzk1MTIzNC0xZDdhLTRiZjctOTYyNS02MGZhZWQxNzVkZjIiLCJ1dGkiOiJCNWZuREUtejBVNmdPVDRRR05ac0FBIiwidmVyIjoiMS4wIn0.ZsaWlleKjD9PBGp_l34PSYvKvjLz7OJE3vgonrjl9PmDptEs4pXpI07G64vlCgqXYt7xtPCWblvWKMDCZRkRGNJEbtVS0rRujueyrKjBBddinHvFXdKjhhg7ykiV8VvHLrfykT1ynUCSFCZ3Js14HOw7Rcg7xwfLKEouxk0VlHJziEahpTFPWSH_gmRBNdlrsmzy50R2z_vcErkDl3g4OpwlcRwikZEvKw1ZMmKYACD1EAMcaD8xB4sE789jpp4erq9O0P4Elc1usoassS_i_P8UduoUO6mDl1SDriJo52uUlDcEH-SzRXXyIaXXPU6r6wrT7y4qkod3xST9ftQNQA';
            $options['bearer_token']=$this->token;

        }

        return $options;
  }

	public function doGet($url, $data){
		$result = parent::get($url, $data, $this->getBearerToken());
		return $this->wrapResult($result);
	}

	public function doPost($url, $data){
		$result = parent::post($url, $data, $this->getBearerToken());
		return $this->wrapResult($result);
	}

	public function doPut($url, $data){
		$result = parent::put($url, $data, $this->getBearerToken());
		return $this->wrapResult($result);
	}

  public function doPatch($url, $data){
		$result = parent::patch($url, $data, $this->getBearerToken());
		return $this->wrapResult($result);
	}

	public function doGetRest($url, $data){
		$result = parent::getRest($url, $data, $this->getBearerToken());
		return $this->wrapResult($result);
	}

  public function doDelete($url, $data){
		$result = parent::delete($url, $data, $this->getBearerToken());
		return $this->wrapResult($result);
	}

	private function wrapResult($result){

		// CodEsito = 0: non c'è stato errore, tutto apposto...
		// CodEsito = 1: c'è stato un errore Esito e Messaggio presenti nella risposta
		// COdEsito = 2: c'è stato un errore Message presente nella risposta
    $logger=Logger::getLogger('DYNCRMAPI');
    
    $r = new StdClass();
		$r->CodEsito="";
		$r->DescEsito="";
		$r->TraceGuid="";
		$r->ErrorsDetail=array();
		$r->Payload=array();

		if($result==null){
				// il servizio non ha restituito nulla
		}else{
            if(isset($result->codEsito)){
                // Refactoring Servizi CRM
                $r->CodEsito=$result->codEsito;
                $r->DescEsito=$result->descEsito;
                $r->TraceGuid=$result->traceGuid;
                $r->ErrorsDetail=$result->errorsDetail;
                if(!is_array($result->payload)){
                    $r->Payload=array($result->payload);
                } else {
                    $r->Payload=$result->payload;
                }
            }
		}

		return $r;
    
	}

}

?>

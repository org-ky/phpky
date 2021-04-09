<?php

class CCSConnector extends VE1_Connector implements VE1_IRestConnector{

	public function __construct($endPoint){

		//TODO i dati dinaminci devono essere presi da varibili di ambiente Azure
		$config = array(
			'port'          => NULL,
			'auth'          => TRUE,
			'auth_type'     => 'basic',
			'auth_username' => 'consulcesiREST',
			'auth_password' => 'mgt93j8tpb45weu3',
			'header'        => array(
									'Content-Type'			=>'application/json',
									'codiceUtente'			=>'8293',
									//'codiceChiamata'		=>$guid,
									'codiceApplicazione'	=>'AreaRiservataClub5',
									'localizzazioneTecnica'	=>'IT'
									),
			'cookie'        => FALSE,
			'timeout'       => 1000,
			'result_assoc'  => FALSE,
			'cache'         => FALSE,
			'tts'           => 3600,
			//'custom_cer'	=> __DIR__.'\rassegnastamparestlabconsulcesilocal.crt',
			'verbose'		=> TRUE,

		);

    //Chiama la classe RsìestClient in maniera statica ereditandola attraverso la classe singleton "VE1_Connector"
		RestClient::__construct($config, $endPoint);

	}

	public function doGet($url, $data){
		return parent::get($url, $data);
	}

	public function doPost($url, $data){
		return parent::post($url, $data);
	}

	public function doPut($url, $data){
		return parent::put($url, $data);
	}

	public function doGetRest($url, $data){
		return parent::getRest($url, $data);
	}

  public function doPatch($url, $data){
		$result = parent::patch($url, $data);
	}
  
  public function doDelete($url, $data){
		$result = parent::delete($url, $data);
	}

}

?>

<?php

//TODO extends Interface
class VE1_Service
{

	function __construct($connector, $url, $method)
	{
		$this->validationChain=array();
		$this->connector=$connector;
		$this->url=$url;
		$this->method=$method;
	}

	public function addValidator($validator, $required, $value, $parameterName)
	{
		$obj=new stdClass();
		$obj->validator=$validator;
		$obj->required=$required;
		$obj->value=$value;
		$obj->parameterName=$parameterName;

		array_push($this->validationChain, $obj);

	}

	public function runValidation()
	{
		$logger=Logger::getLogger('SERVICE');

		$result=null;
		$i=0;

		while(!$result && $i<count($this->validationChain)){
			$validator=$this->validationChain[$i]->validator;

			$logger->info('ESEGUO VALIDATORE: '.get_class($this->validationChain[$i]->validator));
			$logger->info('PARAMETRO: '.$this->validationChain[$i]->parameterName.' OBBLIGATORIO: '.$this->validationChain[$i]->required.' VALORE: '.$this->validationChain[$i]->value);

			if($this->validationChain[$i]->required && !$this->validationChain[$i]->value){
				$logger->error('PARAMETRO: '.$this->validationChain[$i]->parameterName.' OBBLIGATORIO');
				$check=$this->validationChain[$i]->parameterName.' is required';
			}else{
				$check = $validator->validate($this->validationChain[$i]->value, $this->validationChain[$i]->parameterName);
			}

			if($check!=null){

				$logger->error('PARAMETRO: '.$this->validationChain[$i]->parameterName.' NON VALIDATO');

				$result=$check;
			}else{
				$logger->debug('PARAMETRO: '.$this->validationChain[$i]->parameterName.' VALIDATO');
				$i++;
			}

		}

		return $result;

	}

	protected function dispatch($data)
	{
		$logger=Logger::getLogger('SERVICE');
		$logger->info('PARAMETERS: '.print_r($data, true));

		$result=new StdClass();
		$this->connector->initialize();

		switch($this->method){
			case RestClient::GET:
				$result = $this->connector->doGet($this->url, $data);
				break;
			case RestClient::POST:
				$result = $this->connector->doPost($this->url, $data);
				break;
			case RestClient::PUT:
				$result = $this->connector->doPut($this->url, $data);
				break;
      			case RestClient::PATCH:
				$result = $this->connector->doPatch($this->url, $data);
				break;
      			case RestClient::DELETE:
				$result = $this->connector->doDelete($this->url, $data);
				break;
			case RestClient::GET_REST:
				$result = $this->connector->doGetRest($this->url, $data);
				break;
		}

		if(!isset($result->Payload)){
            		$result->Payload = new stdClass();
        	}

		return $result;

	}

	protected function cleanDate($date)
	{
		$date = str_replace('T', ' ', $date);
		$newDate = DateTime::createFromFormat('Y-m-d h:i:s:u' , $date);
		return $newDate->format('Y-m-d h:i:s');
	}

}
?>

<?php
    class Service{
    	
	const VE1_version='VE1';
		
	private $name;
	private $mainData;
	private $parameters;
	private $enrichers;
	private $extendedData;
	private $version=1;
	
	//extended property for VE1
	private $codEsito;
	private $descEsito;
    	private $traceGuid;
    	private $errorsDetail;
		
	public function Service($name, $version=self::VE1_version){
		$this->name=$name;
		$this->mainData=array();
		$this->fields=array();
		$this->enrichers=array();
		$this->extendedData=array();
		$this->codEsito='';
		$this->descEsito='';
		$this->traceGuid='';
		$this->errorsDetail=array();
		$this->version=$version;
	}
		
	public function getName(){
		return $this->name;
	}
		
	public function setMainData($mainData){
		$this->mainData=$mainData;
	}
		
	public function getmainData(){
		return $this->mainData;
	}
		
	public function setFields($fields){
		$this->fields=$fields;
	}
		
	public function getFields(){
		return $this->fields;
	}
		
	public function setEnrichers($enrichers){
		$this->enrichers=$enrichers;
	}
		
	public function getEnrichers(){
		return $this->enrichers;
	}
		
	public function addExtendedData($key, $value){
		$this->extendedData[$key]=$value;
	}
		
	public function getExtendedData(){
		return $this->extendedData;
	}
		
	public function setCodEsito($codEsito){
		$this->codEsito=$codEsito;
	}
		
	public function getCodEsito(){
		return $this->codEsito;
	}
		
	public function setDescEsito($descEsito){
		$this->descEsito=$descEsito;
	}
		
	public function getDescEsito(){
		return $this->descEsito;
	}
		
	public function setTraceGuid($traceGuid){
		$this->traceGuid=$traceGuid;
	}
		
	public function getTraceGuid(){
		return $this->traceGuid;
	}
		
	public function setErrorsDetail($errorsDetail){
		$this->errorsDetail=$errorsDetail;
	}
		
	public function getErrorsDetail(){
		return $this->errorsDetail;
	}		
		
	public function getVersion(){
		return $this->version;
	}
		
    }
?>

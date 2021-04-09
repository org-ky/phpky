<?php

class VE1_ServiceNotFoundException extends Exception
{
	
	public function __construct($message, $code=404, $previous=null) {
		
		$message='Service not found: '.$message;
		$code=404;
		
		parent::__construct($message, $code, $previous);
		
	}

	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}

}

?>

<?php

class VE3_ServiceInputValidationException extends Exception
{
	
	public function __construct($message, $code=500, $previous=null) {
		
		$message='Input Validation Error: '.$message;
		$code=500;
		
		parent::__construct($message, $code, $previous);
		
	}

	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}

}

?>

<?php
class VE1_IntegerValidator extends VE1_Validator implements VE1_IValidator {

	function __construct() {

		parent::__construct();
	}

	public function validate($value, $parameterName) {

		$result = null;
		if (!is_int($value)) {
			$result =  $parameterName.' is not a valid integer';
		}
		return $result;
	}
}
?>

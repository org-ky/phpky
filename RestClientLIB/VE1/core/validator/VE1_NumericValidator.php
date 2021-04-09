<?php
class VE1_NumericValidator extends VE1_Validator implements VE1_IValidator {

	const REG_EXP = "/^[0-9]*$/i";

	function __construct() {

		parent::__construct($name);
	}

	public function validate($value, $fieldName) {

		$result = null;
		if (preg_match(self::REG_EXP, $value)) {
			if (isset($value{$this->minChars - 1}) && !isset($value{$this->maxChars})) {
				$result =  $fieldName.' is not a valid Number';
			}
		}
		return $result;
	}
}
?>

<?php
class VE1_CodFiscValidator extends VE1_Validator implements VE1_IValidator {

	const REG_EXP = '/^[A-Z]{6}[\d]{2}[A-Z][\d]{2}[A-Z][\d]{3}[A-Z]$/';

	function __construct() {
		parent::__construct();
	}

	public function validate($value, $parameterName) {
		$value=strtoupper($value);
		
		$result = null;
		if (preg_match(self::REG_EXP, $value)) {
			$check =  self::checkCin($value);
			if(!$check){
				$result=$parameterName.' is not a valide CodiceFiscale';
			}
		}
		return $result;
	}

	function checkCin($codFisc) {

		$codFisc = strtoupper($codFisc);
		$result = false;

		//codifica lettere posizione dispari
		$odd=array( '_0'=>1 , '_9'=>21, '_I'=>19, '_R'=>8 ,
				'_1'=>0 , '_A'=>1 , '_J'=>21, '_S'=>12,
				'_2'=>5 , '_B'=>0 , '_K'=>2 , '_T'=>14,
				'_3'=>7 , '_C'=>5 ,	'_L'=>4 , '_U'=>16,
				'_4'=>9 , '_D'=>7 ,	'_M'=>18, '_V'=>10,
				'_5'=>13, '_E'=>9 ,	'_N'=>20, '_W'=>22,
				'_6'=>15, '_F'=>13, '_O'=>11, '_X'=>25,
				'_7'=>17, '_G'=>15, '_P'=>3 , '_Y'=>24,
				'_8'=>19, '_H'=>17, '_Q'=>6 , '_Z'=>23);

		//codifica lettere posizione pari
		$even=array('_0'=>0 , '_9'=>9 , '_I'=>8 , '_R'=>17,
				'_1'=>1 , '_A'=>0 , '_J'=>9 , '_S'=>18,
				'_2'=>2 , '_B'=>1 , '_K'=>10, '_T'=>19,
				'_3'=>3 , '_C'=>2 ,	'_L'=>11, '_U'=>20,
				'_4'=>4 , '_D'=>3 ,	'_M'=>12, '_V'=>21,
				'_5'=>5 , '_E'=>4 ,	'_N'=>13, '_W'=>22,
				'_6'=>6 , '_F'=>5 , '_O'=>14, '_X'=>23,
				'_7'=>7 , '_G'=>6 , '_P'=>15, '_Y'=>24,
				'_8'=>8 , '_H'=>7 , '_Q'=>16, '_Z'=>25);

		//decodifica resto somma pari e dispari
		$mod=array( '_0'=>'A', '_7' =>'H', '_14'=>'O', '_21'=>'V',
				'_1'=>'B', '_8' =>'I', '_15'=>'P', '_22'=>'W',
				'_2'=>'C', '_9' =>'J', '_16'=>'Q', '_23'=>'X',
				'_3'=>'D', '_10'=>'K', '_17'=>'R', '_24'=>'Y',
				'_4'=>'E', '_11'=>'L', '_18'=>'S', '_25'=>'Z',
				'_5'=>'F', '_12'=>'M', '_19'=>'T',
				'_6'=>'G', '_13'=>'N', '_20'=>'U');

		$tot=0;

		for($i=1; $i<16; $i++) {

			$char='_'.substr($codFisc, $i-1, 1);

			if($i%2==0){
				//pari
				$tot+=$even[$char];
			}else{
				//dispari
				$tot+=$odd[$char];
			}

		}
		$cin=$mod['_'.($tot%26)];

		$result=$cin==substr($codFisc, 15, 1);

		return $result;
	}
}
?>

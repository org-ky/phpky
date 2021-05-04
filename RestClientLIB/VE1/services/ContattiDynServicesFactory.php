<?php
// Load all services class
require_once (APPPATH . 'services/contattidyn/DYNCRMAPI_GetContattoByCodiceCliente.php');
require_once (APPPATH . 'services/contattidyn/beanIn/DYNCRMAPI_GetContattoByCodiceClienteBeanIn.php');
require_once (APPPATH . 'services/contattidyn/beanOut/DYNCRMAPI_GetContattoByCodiceClienteBeanOut.php');

class ContattiDynServicesFactory extends VE1_Singleton
{

	public static function create($serviceName)
	{
		$endPoint = 'https://api.dev.consulcesi.com/newcrm-test/';

		$connector= DYNCRMConnector::getInstance($endPoint);
		$service=null;

		switch($serviceName){

			case 'dyncrmapi_getcontattobycodicecliente':
				$service = new DYNCRMAPI_GetContattoByCodiceCliente($connector, 'contatti', $connector->getMethodGetRest());
				break;

		}

		return $service;
	}
}
?>

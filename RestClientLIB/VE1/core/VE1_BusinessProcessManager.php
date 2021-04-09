<?php

require_once ('VE1_ServiceNotFoundException.php');
require_once ('VE1_ServiceInputValidationException.php');
require_once ('validator/inc.php');

//TODO extends Interface
class VE1_BusinessProcessManager
{
	protected $_CI = null;
	protected $_lang = null;


	private static function executeService($factory, $serviceName, $input){
		$logger=Logger::getLogger('BPM');
		$result=null;
		$logger->info('************BPM EXECUTE SERVICE*************');
		$logger->info('FACTORY: '.get_class($factory));
        $logger->info('SERVICE NAME: '.$serviceName);

		//Istanza dell'implementazione del servizio
		$serviceImpl = $factory::create($serviceName);

        if($serviceImpl==null){
            $logger->info('Service Impl null');
			$msg = get_class($factory).'.'.$serviceName;
            throw new VE1_ServiceNotFoundException($msg);
		}else{
			//Validate Service
			$validationError=$serviceImpl->validate($input);
        	if($validationError==null){
				//Execute Service
				$result=$serviceImpl->execute($input);
			}else{
				throw new VE1_ServiceInputValidationException($validationError);

			}
		}

		//TODO HAndle Exception
        $logger->info('SERVICE RESULT');
        $logger->info(print_r($result, true));

		return $result;
	}


    static function execute($factory, $parameters, $service){
        $logger=Logger::getLogger('BPM');
		switch(gettype($parameters)){
			case 'string':
				$parameters=json_decode($parameters);
				break;
			case 'object':
				break;
			default:
				$service->errorCode='500';
				$service->errorDescription='Wrong Input parameter Format';
				$service->data=null;
				return $service;
				break;
		}


		$serviceName=$parameters->serviceName;
		$input = $parameters->input;

		try{

			$data = self::executeService($factory, $serviceName, $input);
			$logger->info('SERVICE EXECUTED: '.$serviceName);

			$service->errorCode='0';
			$service->errorDescription='';
			$service->data=$data;

		}
        catch (VE1_ServiceNotFoundException $e){
			$service->errorCode=$e->getCode();
			$service->errorDescription=$e->getMessage();
			$service->data=null;
		}
        catch (VE1_ServiceInputValidationException $e){
			$service->errorCode=$e->getCode();
			$service->errorDescription=$e->getMessage();
			$service->data=null;
		}

        if(!is_array($service->data->Payload) && !is_null($service->data->Payload))
            $service->data->Payload = array($service->data->Payload);

        if(!isset($service)){
            echo 'Verificare la configurazione del servizio: '.$params[3];
        }else{
            $logger->info('*************BPM RETURN RESPONSE**************');
            $service->setCodEsito($service->data->CodEsito);
            $service->setDescEsito($service->data->DescEsito);
            $service->setTraceGuid($service->data->TraceGuid);
            $service->setErrorsDetail($service->data->ErrorsDetail);
            $service->setMainData($service->data->Payload);
        }

        return $service;

	}

}
?>

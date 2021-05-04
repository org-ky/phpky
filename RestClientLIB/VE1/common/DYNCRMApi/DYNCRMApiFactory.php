<?php
class DYNCRMApiFactory{

    public static function getService($params){
        //TODO handle the error when service called not exists
        $logger=Logger::getLogger('DYNCRMAPI');

        $service = new Service($params[3], Service::VE1_version);

        $logger->debug('Servizio invocato: '.$params[3]);
      
        switch($params[3]){
          case "dyncrmapi_getcontattobycodicecliente":

                $factory=ContattiDynServicesFactory::getInstance();
                $parameters=new StdClass();
                $parameters->serviceName='dyncrmapi_getcontattobycodicecliente';
                $parameters->input=new DYNCRMAPI_GetContattoByCodiceClienteBeanIn();
                $parameters->input->setCodiceCliente($params[4]);

                $output=new DYNCRMAPI_GetContattoByCodiceClienteBeanOut();
                $service->setFields($output->getFields());
                break;
            
            default:
                echo 'Chiamato servizio: '.$params[3];
                break;
        }
      
        $serviceResult = VE3_BusinessProcessManager::execute($factory, $parameters, $service);

        return $serviceResult;
    }
}
?>

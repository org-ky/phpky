<?php
class CCServicesFactory{

    public static function getService($params){
        //TODO handle the error when service called not exists
        $logger=Logger::getLogger('ccservices');

        $service = new Service($params[3], Service::VE3_version);

        $logger->debug('Servizio invocato: '.$params[3]);
        switch($params[3]){
            case "getallnews":

                $factory=ArcServicesFactory::getInstance();
                $parameters=new StdClass();
                $parameters->serviceName='getallnews';
                $parameters->input=new ArcGetAllNewsBeanIn();
                /*switch(count($params)){
                    case 5:
                        $parameters->input->setDataDa($params[4]);
                        break;
                    case 6:
                        $parameters->input->setDataDa($params[4]);
                        $parameters->input->setDataA($params[5]);
                        break;
                    case 7:
                        $parameters->input->setDataDa($params[4]);
                        $parameters->input->setDataA($params[5]);
                        $parameters->input->setTitolo($params[6]);
                        break;
                }*/
                $parameters->input->setNumeroElementiPagina($params[4]);
                $parameters->input->setOffset($params[5]);
                if(isset($params[6])){
                    $parameters->input->setCustomData($params[6]);
                }

                $output=new ArcGetAllNewsBeanOut();
                $service->setFields($output->getFields());
                break;
            
            case "getalllinks":

                $factory=ArcServicesFactory::getInstance();

                $parameters=new StdClass();
                $parameters->serviceName='getalllinks';
                $parameters->input=new ArcGetAllLinksBeanIn();

                $output=new ArcGetAllLinksBeanOut();
                $service->setFields($output->getFields());
                break;
        }

        $serviceResult = VE3_BusinessProcessManager::execute($factory, $parameters, $service);

        return $serviceResult;
    }
}
?>

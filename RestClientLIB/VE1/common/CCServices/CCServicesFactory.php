<?php
class CCServicesFactory{

    public static function getService($params){
        //TODO handle the error when service called not exists
        $logger=Logger::getLogger('ccservices');

        $service = new Service($params[3], Service::VE3_version);

        $logger->debug('Servizio invocato: '.$params[3]);
        switch($params[3]){
            /*Caso di servizio con due parametri obbligatori in input(NumeroElementiPagina, Offset) e il resto dei parametri facoltativi in input
              inseriti nell'array associativo "CustomData" */
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
            
            /*Caso di servizio con nessun parametro in input*/
            case "getalllinks":

                $factory=ArcServicesFactory::getInstance();

                $parameters=new StdClass();
                $parameters->serviceName='getalllinks';
                $parameters->input=new ArcGetAllLinksBeanIn();

                $output=new ArcGetAllLinksBeanOut();
                $service->setFields($output->getFields());
                break;
                
            /*Caso di servizio con almeno un parametro obbligatorio in input inserito nell'array associativo "CustomData" */
            case "getlinkbyidkey":

                $factory=ArcServicesFactory::getInstance();

                $parameters=new StdClass();
                $parameters->serviceName='getlinkbyidkey';
                $parameters->input=new ArcGetLinkByIdKeyBeanIn();
                $parameters->input->setCustomData($params[4]);

                $output=new ArcGetLinkByIdKeyBeanOut();
                $service->setFields($output->getFields());
                break;
                
            /*Caso di servizio con tutti i parametri obbligatori in input*/
            case "insertlink":

                $factory=ArcServicesFactory::getInstance();

                $parameters=new StdClass();
                $parameters->serviceName='insertlink';
                $parameters->input=new ArcInsertLinkBeanIn();
                $parameters->input->setChiave($params[4]);
                $parameters->input->setValore($params[5]);
                $parameters->input->setTipo($params[6]);
                $parameters->input->setStato($params[7]);

                $output=new ArcInsertLinkBeanOut();
                $service->setFields($output->getFields());
                break;

            /*Caso di servizio con obbligatorio in input il parameto "Id" ed almeno uno dei parametri definiti nell'array associativo "CustomData" */
            case "updatelink":

                $factory=ArcServicesFactory::getInstance();

                $parameters=new StdClass();
                $parameters->serviceName='updatelink';
                $parameters->input=new ArcUpdateLinkBeanIn();
                $parameters->input->setId($params[4]);
                $parameters->input->setCustomData($params[5]);

                $output=new ArcUpdateLinkBeanOut();
                $service->setFields($output->getFields());
                break;
        }

        $serviceResult = VE3_BusinessProcessManager::execute($factory, $parameters, $service);

        return $serviceResult;
    }
}
?>

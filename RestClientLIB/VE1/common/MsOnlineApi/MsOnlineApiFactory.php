<?php
    class MSOnlineApiFactory{

      public static function getService($params){
        //TODO handle the error when service called not exists
        $logger=Logger::getLogger('msonline');

        $service = new Service($params[3], Service::VE3_version);
        $dataResult = null;

        $logger->debug('Servizio invocato: '.$params[3]);
        switch($params[3]){

          //-----------------------FAD BLOCK CHAIN-----------------------
          case "msonline_getaccesstoken":

            $factory=AccessTokenServicesFactory::getInstance();
            $parameters=new StdClass();
            $parameters->serviceName='msonline_getaccesstoken';
            $parameters->input=new MSOnlineGetAccessTokenBeanIn();
            $parameters->input->setGrantType('client_credentials');                     // get from envinronment
            $parameters->input->setClientId('CLIENT_ID_ACCESS_TOKEN');                  // get from envinronment
            $parameters->input->setClientSecret('CLIENT_ID_ACCESS_TOKEN');              // get from envinronment

            $parameters->output=new MSOnlineGetAccessTokenBeanOut();
            $service->setFields($parameters->output->getFields());
            break;

          //-----------------------NewCRM-----------------------
          case "msonline_getaccesstoken_dyncrm":

            $factory=AccessTokenServicesFactory::getInstance();
            $parameters=new StdClass();
            $parameters->serviceName='msonline_getaccesstoken';
            $parameters->input=new MSOnlineGetAccessTokenBeanIn();
            $parameters->input->setGrantType('client_credentials');                                 // get from envinronment
            $parameters->input->setClientId('CLIENT_ID_ACCESS_TOKEN_DYNCRM');                       // get from envinronment
            $parameters->input->setClientSecret('CLIENT_ID_ACCESS_TOKEN_DYNCRM');                   // get from envinronment

            $parameters->output=new MSOnlineGetAccessTokenBeanOut();
            $service->setFields($parameters->output->getFields());
            break;

        }

        $serviceResult = VE3_BusinessProcessManager::execute($factory, $parameters, $service);

        return $serviceResult;
      }
    }
?>

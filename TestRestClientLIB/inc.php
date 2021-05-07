<?php

  //CORE
  require_once ('../RestClientLIB/VE1/core/Service.php');
  require_once ('../RestClientLIB/VE1/core/VE1_IService.php');  
  require_once ('../RestClientLIB/VE1/core/VE1_Service.php');  
  require_once ('../RestClientLIB/VE1/core/VE1_IRestConnector.php');
  require_once ('../RestClientLIB/VE1/core/VE1_BusinessProcessManager.php');
  require_once ('../RestClientLIB/VE1/core/VE1_IBeanIn.php');
  require_once ('../RestClientLIB/VE1/core/VE1_IBeanOut.php');
  require_once ('../RestClientLIB/VE1/core/VE1_Singleton.php');

  //CORE CONNECTORS
  require_once ('../RestClientLIB/VE1/core/connectors/RestClient.php');
  require_once ('../RestClientLIB/VE1/core/connectors/VE1_Connector.php');
  require_once ('../RestClientLIB/VE1/core/connectors/CCSConnector.php');
  require_once ('../RestClientLIB/VE1/core/connectors/DYNCRMApiConnector.php');
  require_once ('../RestClientLIB/VE1/core/connectors/MSOnlineConnector.php');

  //COMMON FACTORY
  require_once ('../RestClientLIB/VE1/common/MSOnlineApi/MSOnlineApiFactory.php');
  require_once ('../RestClientLIB/VE1/common/DYNCRMApi/DYNCRMApiFactory.php');
  require_once ('../RestClientLIB/VE1/common/CCServices/CCServicesFactory.php.php');

  //SERVICES FACTORY
  require_once ('../RestClientLIB/VE1/services/AccessTokenServicesFactory.php');
  require_once ('../RestClientLIB/VE1/services/ContattiDynServicesFactory.php');
  require_once ('../RestClientLIB/VE1/services/ArcServicesFactory,php');

?>

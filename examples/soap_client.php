<pre>
<?php
            ini_set('soap.wsdl_cache_enabled', '0');
			ini_set('soap.wsdl_cache_ttl', '0'); 
			
            echo '=========================== SOAP CLIENT TEST 1 ===========================';
			echo '<br>';
			//$client = new SOAPClient('http://fad.consulcesi.it/ws?wsdl');

            $wsdl = 'https://wrapperitsm.consulcesi.com/WrapperITSM.Service1.svc?wsdl';
            //$wsdl = 'https://wrapperitsm.consulcesi.local/WrapperITSM.Service1.svc?wsdl';
            //$wsdl = 'https://wrapperitsm.lab.consulcesi.local/WrapperITSM.Service1.svc?wsdl';
			echo('<br>');
			$soapClient = new SOAPClient(null, array('uri' => $wsdl, 'trace' => 1, 'location' => $wsdl, 'encoding'=>'UTF-8'));
			if($soapClient == null)
				echo('Soap Client "'.$wsdl.'" NULL!');
			else
				echo('Soap Client "'.$wsdl.'" istanziato!');

			
			echo '=========================== SOAP CLIENT TEST 2 ===========================';
			echo '<br>';
			
			$client = new SoapClient("http://landing.consulcesi.it/php/ws/wsdl/ccsservices.wsdl");
			
			$anag = new stdClass();
			$anag->username = "TST-TNT002";
			$anag->password = "testws";
			$anag->nome     = "Medico Test ws";
			$anag->cognome  = "Medico Test ws";
			$anag->email    = "l.ruggiero@consulcesi.eu";
			$anag->codfisc  = "RGGLCU74L05A509H";
			$anag->kind     = 'LIM';
			$anag->coupon   = 'TNT-001';
			$anag->data_nascita   = '1974-07-05';
			$anag->luogo_nascita   = 'avellino';
	
			$resp = array();
			try {
		
				$resp = $client->createFadAnag($anag); 
				print_r($resp);
				if (is_soap_fault($resp)) 
					echo("SOAP Fault Error");
				else
					print_r($resp);
	
			} catch (SoapFault $exception) {
			var_dump($resp);
			echo('<br>');
			echo 'EXCEPTION CODE='.$exception->getCode();
			echo('<br>');
			echo 'EXCEPTION CODE='.$exception->getMessage();
			echo('<br>');
			echo 'EXCEPTION='.$exception;
			}	

			echo '=========================== SOAP CLIENT TEST 3 ===========================';

			const WSDL_CRM = 'https://wrapperitsm.consulcesi.local/WrapperITSM.Service1.svc?wsdl';
			
			$opts = array(
				'ssl' => array('ciphers'=>'RC4-SHA', 'verify_peer'=>false, 'verify_peer_name'=>false)
			);
			$context = stream_context_create($opts);

			$soapClient = new SOAPClient(WSDL_CRM, array('stream_context' => $context,
					'cache_wsdl' => WSDL_CACHE_NONE,
					'features' => SOAP_SINGLE_ELEMENT_ARRAYS
			));


			$now=new DateTime();
				
			//Genero la security key
			$sk=$now->format('Ymd');
			$sk.='c0N$L1NNk3d8Wi$$3!';
			$sk=md5($sk);
				
			$header = new SoapHeader('http://Consulcesi.com/CRM/',
					'SecurityKey',
					$sk);

			$soapClient->__setSoapHeaders($header);

			if($soapClient == null)
				echo('Soap Client NULL!');
			else
				echo('Soap Client istanziato!');
?>
</pre>
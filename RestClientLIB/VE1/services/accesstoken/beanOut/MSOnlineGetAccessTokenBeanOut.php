<?php
class MSOnlineGetAccessTokenBeanOut implements VE3_IBeanOut
{

	function __construct()
	{

	}

	function getFields(){
		return array (
                'token_type',
                'expires_in',
                'ext_expires_in',
                'expires_on',
                'not_before',
                'resource',
                'access_token');
	}

}
?>

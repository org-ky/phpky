<?php

class MSOnlineGetAccessTokenBeanIn implements VE3_IBeanIn
{

    private $token=null;

    private $grantType;
    private $clientId;
    private $clientSecret;

    function __construct()
    {

    }

    function setGrantType($grantType)
    {
      $this->grantType=$grantType;
    }

    function getGrantType()
    {
      return $this->grantType;
    }

    function setClientId($clientId)
    {
      $this->clientId=$clientId;
    }

    function getClientId()
    {
      return $this->clientId;
    }

    function setClientSecret($clientSecret)
    {
      $this->clientSecret=$clientSecret;
    }

    function getClientSecret()
    {
      return $this->clientSecret;
    }

    function getDataToSend()
    {
      $data=new StdClass();

      $data->grant_type=$this->grantType;
      $data->client_id=$this->clientId;
      $data->client_secret=$this->clientSecret;

      return $data;
	  }

}
?>

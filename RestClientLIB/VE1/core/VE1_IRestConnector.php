<?php

//TODO extends Interface
interface VE1_IRestConnector
{
	public function __construct($endPoint);

	public function doGet($url, $data);

	public function doPost($url, $data);

	public function doPut($url, $data);

  public function doPatch($url, $data);

  public function doDelete($url, $data);

	public function doGetRest($url, $data);

}

?>

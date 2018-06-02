<?php

if ( ! defined( 'ABSPATH' ) ) exit;
class Roket_Shipping_Model
{

	public $kurir;

	function __construct()
	{
		require( __DIR__ .'/../config.php');
		$this->kurir = $roket_shipping_config;			
	}
	
}
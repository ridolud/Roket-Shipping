<?php

if ( ! defined( 'ABSPATH' ) ) exit;
class Roket_Shipping_Model
{

	public $kurir;
	private $_API;

	function __construct()
	{
		require( __DIR__ .'/../config.php');
		$this->kurir = $roket_shipping_config['kurir'];
		$this->_API = new Roket_Shipping_API('f8a5f2a780af321e615fef7399c3d399');
		
	}

	public function get_all_kurir_fields()
	{
		return $this->kurir;
	}
	
}
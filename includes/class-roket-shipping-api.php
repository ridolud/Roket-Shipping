<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Roket_Shipping_API
{
	private $_instance = null;
	private $api_token = '';
	public $url = 'https://pro.rajaongkir.com/api/';
	public $origin_type = 'city';
	public $destination_type = 'city';

	function __construct($api_token)
	{
		$this->api_token = $api_token;
	}

	// public function get_provice_by_name($name)
	// {
	// 	$data = $this->build('province', array(
	// 		'get_params' => array(
	// 			'id' => null,
	// 		),
	// 	));
	// 	return $data;
	// }

	public function get_provice($id = null)
	{
		return $this->build('province', array(
			'get_params' => array(
				'id' => $id,
			),
		));
	}

	public function get_city($id_province, $id = null)
	{
		return $this->build('city', array(
			'get_params' => array(
				'province' => $id_province,
				'id' => $id,
			),
		));
	}

	public function get_subdistrict($id_city)
	{
		return $this->build('subdistrict', array(
			'get_params' => array(
				'city' => $id_city,
			),
		));
	}

	public function get_cost($options)
	{
		# code...
	}

	private function build( $action, $options = array() )
	{
		if( isset($options['get_params']) )

		$header = array( "key:" . $this->api_token );
		$curl = curl_init();
		$params = array(
		  CURLOPT_URL => $this->url. $action . ( isset( $options['get_params'] ) ?  '?' . http_build_query($options['get_params']) : '' ) ,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => ( isset($options['method']) ? $options['method'] : 'GET' ) ,
		  CURLOPT_HTTPHEADER => $header,
		);

		if ( isset($options['method']) && $options['method'] == 'POST' ){
			$params[ CURLOPT_POSTFIELDS ] = isset($options['params']) ? $options['params'] : array();
            array_push($header, "content-type: application/x-www-form-urlencoded");
		}
		curl_setopt_array($curl, $params);
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		if ($err) {
		  return "cURL Error #:" . $err;
		} else {
		  $result = json_decode($response);
		  if( $result->rajaongkir->status->code = '200' ){
		  	return (array) $result->rajaongkir->results;
		  }
		  return $result;
		}	
	}
}
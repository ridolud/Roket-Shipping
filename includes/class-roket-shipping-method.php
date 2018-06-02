<?php

// Check if WooCommerce is active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	function roket_shipping_method_init() {
		if ( ! class_exists( 'Roket_Shipping_Method' ) ) {
			class Roket_Shipping_Method extends WC_Shipping_Method {

				private $roket_shipping_model;

				/**
				 * Constructor for your shipping class
				 *
				 * @access public
				 * @return void
				 */
				public function __construct() {
					$this->id                 = 'roket_shipping'; // Id for your shipping method. Should be uunique.
					$this->method_title       = __( 'Roket Shipping' );  // Title shown in admin
					$this->method_description = __( 'Description of your shipping method' ); // Description shown in admin

					$this->enabled = $this->get_option('enabled', 'yes');
                    $this->title = $this->get_option('title', __( 'Roket Sihpping' ));
      				
      				// Get Config
      				require( __DIR__ .'/../config.php');
      				$this->roket_shipping_config = $roket_shipping_config;
					
					$this->init();
				}

				/**
				 * Init settings
				 *
				 * @access public
				 * @return void
				 */
				function init() {
					// Load the settings API
					$this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings
					$this->init_settings(); // This is part of the settings API. Loads settings you previously init.

					// Save settings in admin if you have any defined
					add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
				}

				/**
				 * Init Field Form Setting 
				 * @access public
				 * @return void
				 */
				function init_form_fields()
				{
					$general_form_fields = array(
				         'enabled' => array(
				              'title' => __( 'Enable', 'roket_shipping' ),
				              'type' => 'checkbox',
				              'description' => __( 'Enable this shipping.', 'roket_shipping' ),
				              'default' => 'yes'
				              ),
				         'title' => array(
				            'title' => __( 'Title', 'roket_shipping' ),
				              'type' => 'text',
				              'description' => __( 'Title to be display on site', 'roket_shipping' ),
				              'default' => __( 'TutsPlus Shipping', 'roket_shipping' )
				              ),
						'api_key' => array(
				            'title' => __( 'API Key', 'roket_shipping' ),
				              'type' => 'text',
				              'description' => __( 'Api key shipping', 'roket_shipping' ),
				              'default' => __( '', 'roket_shipping' )
				              ),
				         );
					$kurir_form_fields = array();
					foreach ($this->roket_shipping_config['kurir'] as $kurir) {
						array_push($kurir_form_fields, $kurir['field_option']);
					}
					$this->form_fields = array_merge( $general_form_fields, $kurir_form_fields );
				}

				/**
				 * calculate_shipping function.
				 *
				 * @access public
				 * @param mixed $package
				 * @return void
				 */
				public function calculate_shipping( $package = array() ) {
					$rate = array(
						'id' => $this->id . '_jne',
						'label' => 'JNE',
						'cost' => 10000,
					);
					$rate2 = array(
						'id' => $this->id . '_tiki',
						'label' => 'TIKI',
						'cost' => 11000,
					);

					// Register the rate
					$this->add_rate( $rate );
					$this->add_rate( $rate2 );
				}
			}
		}
	}

	add_action( 'woocommerce_shipping_init', 'roket_shipping_method_init' );

	function add_roket_shipping_method( $methods ) {
		$methods[''] = 'Roket_Shipping_Method';
		return $methods;

	}

	add_filter( 'woocommerce_shipping_methods', 'add_roket_shipping_method' );
}

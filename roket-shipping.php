<?php
/*
 * Plugin Name: Roket Shipping
 * Version: 1.0
 * Plugin URI: #
 * Description: Shipping Service.
 * Author: Ridolud
 * Author URI: #
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: roket-shipping
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author ridolud
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require('includes/class-roket-shipping.php');
require('includes/class-roket-shipping-method.php');

/**
 * Returns the main instance of Roket_Shipping to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Roket_Shipping
 */
function Roket_Shipping() {
	$instance = Roket_Shipping::instance( __FILE__, '1.0.0' );

	// if ( is_null( $instance->settings ) ) {
	// 	$instance->settings = WordPress_Plugin_Template_Settings::instance( $instance );
	// }

	return $instance;
}
Roket_Shipping();
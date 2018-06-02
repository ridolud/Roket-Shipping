<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Roket_Shipping
{

	private static $_instance = null;
	public $setting = null;
	public $_version;
	public $file;
	public $_api_key;
	public $_token;
	public $dir;
	public $asset_dir;
	public $asset_url;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	function __construct($file = '', $version = '1.0.0')
	{
		$this->_version = $version;
		$this->_token = "Roket Shipping";

		// Load plugin environment variables
		$this->file = $file;
		$this->dir = dirname( $this->file );
		$this->assets_dir = trailingslashit( $this->dir ) . 'assets';
		$this->assets_url = esc_url( trailingslashit( plugins_url( '/assets/', $this->file ) ) );

		// Check Woocommerce
		if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			return add_action( 'admin_notices', array( $this, '_notice_require_woocommerce' ) );
		}

		register_activation_hook( $this->file, array( $this, 'install' ) );

		// Load frontend JS & CSS
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 10 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 10 );

		// Load admin JS & CSS
		// add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 10, 1 );
		// add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_styles' ), 10, 1 );
		
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->_version );
	}

	/**
	 * Load frontend CSS.
	 * @access  public
	 * @since   1.0.0
	 * @return void
	 */
	public function enqueue_styles () {
		wp_register_style( $this->_token . '-style', esc_url( $this->assets_url ) . 'css/rs-style.css', array(), $this->_version );
		wp_enqueue_style( $this->_token . '-style' );
	}

	/**
	 * Load frontend Javascript.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function enqueue_scripts () {
		wp_register_script( $this->_token . '-script', esc_url( $this->assets_url ) . 'js/rs-script.js', array( 'jquery' ), $this->_version );
		wp_enqueue_script( $this->_token . '-script' );
	}

	/**
	 * Installation. Runs on activation.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function install () {
		$this->_log_version_number();
	} 

	/**
	 * Log the plugin version number.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	private function _log_version_number () {
		update_option( $this->_token . '_version', $this->_version );
	}

	/**
	 * Main Roket_Shipping
	 * Ensures only one instance of Roket_Shipping is loaded or can be loaded.
	 * @since 1.0.0
	 * @static
	 * @see Roket_Shipping()
	 * @return Main Roket_Shipping instance
	 */
	public static function instance ( $file = '', $version = '1.0.0' ) {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self( $file, $version );
			}
			return self::$_instance;
	}

	/**
	 * Send notice error.
	 * @return void
	 */
	public function _notice_require_woocommerce()
	{
		$class = 'notice notice-error';
		$title = sprintf( __('%s for WooCommerce needs WooCommerce'), $this->_token );
		$desc = sprintf( __('<a href="http://wordpress.org/extend/plugins/woocommerce/" target="_blank">WooCommerce</a> must be active for %s to work. Please install &amp; activate WooCommerce.'), $this->_token );
    	$message = '<b>'.$title.'</b><br><p>'.$desc.'</p>';
	    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message ); 
	}
}
<?php
	/**
	 * Plugin Name: WC Force Pass
	 * Plugin URI:
	 * Description: Disable scanning of strong passwords WooCommerce
	 * Author: leobaiano
	 * Author URI: https://profiles.wordpress.org/leobaiano/
	 * Version: 1.0.0
	 * License: GPLv2 or later
	 * Text Domain: lb-force-pass
 	 * Domain Path: /languages/
	 */

	if ( ! defined( 'ABSPATH' ) )
		exit; // Exit if accessed directly.

	// require_once 'autoloader.php';

	/**
	 * Baianada
	 *
	 * @author   Leo Baiano <ljunior2005@gmail.com>
	 */
	class WC_Force_Pass {
		/**
		 * Instance of this class.
		 *
		 * @var object
		 */
		protected static $instance = null;

		/**
		 * Slug.
		 *
		 * @var string
		 */
		protected static $text_domain = 'lb-force-pass';

		/**
		 * Initialize the plugin
		 */
		private function __construct() {
			// Load plugin text domain
			add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );

			// Load styles and script
			add_action( 'wp_enqueue_scripts', array( $this, 'load_admin_styles_and_scripts' ) );

			// Remove password Sttrength
			add_action( 'wp_print_scripts', array( $this, 'remove_password_strength' ) );

			// Reduce min strenght
			add_filter( 'woocommerce_min_password_strength', array( $this, 'reduce_woocommerce_min_strength_requirement' ) );
		}

		/**
		 * Return an instance of this class.
		 *
		 * @return object A single instance of this class.
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Load the plugin text domain for translation.
		 *
		 * @return void
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( self::$text_domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Load styles and scripts
		 *
		 */
		public function load_admin_styles_and_scripts(){
			wp_enqueue_script( self::$text_domain . '_js_main', plugins_url( 'main.js', __FILE__ ), array( 'jquery' ), null, true );
		}

		public function remove_password_strength() {
			if ( wp_script_is( 'wc-password-strength-meter', 'enqueued' ) ) {
				wp_dequeue_script( 'wc-password-strength-meter' );
			}
		}

		/** 
		 * Reduce the strength requirement on the woocommerce password.
		 * 
		 * Strength Settings
		 * 3 = Strong (default)
		 * 2 = Medium
		 * 1 = Weak
		 * 0 = Very Weak / Anything
		 */
		function reduce_woocommerce_min_strength_requirement( $strength ) {
		    return 0;
		}

	} // end class Baianada();
	add_action( 'plugins_loaded', array( 'WC_Force_Pass', 'get_instance' ), 0 );

<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://joshua-project-wp-plugin.netlify.app
 * @since      1.0.0
 *
 * @package    JP_WP
 * @subpackage JP_WP/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    JP_WP
 * @subpackage JP_WP/public
 * @author     JP Workshop
 */
class JP_WP_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $jp_wp    The ID of this plugin.
	 */
	private $jp_wp;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $jp_wp       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $jp_wp, $version ) {

		$this->jp_wp = $jp_wp;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in JP_WP_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The JP_WP_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->jp_wp, plugin_dir_url( __FILE__ ) . 'css/jp-wp-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in JP_WP_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The JP_WP_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->jp_wp, plugin_dir_url( __FILE__ ) . 'js/jp-wp-public.js', array( 'jquery' ), $this->version, false );

	}

}

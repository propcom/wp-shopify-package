<?php

namespace WSP\Frontend;

/**
 * Class - Defines public facing scripts
 *
 * @author Joshua Grierson
 * @package WSP\Frontend
*/
class WSPPublic
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $Wordpress_Shopify    The ID of this plugin.
	 */
	private $Wordpress_Shopify;

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
	 * @param      string    $Wordpress_Shoify       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $Wordpress_Shopify, $version )
	{
		$this->Wordpress_Shopify = $Wordpress_Shopify;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->Wordpress_Shopify, plugin_dir_url( __FILE__ ) . 'css/wp_shopify-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->Wordpress_Shopify, plugin_dir_url( __FILE__ ) . 'js/wp_shopify-public.js', array( 'jquery' ), $this->version, false );
	}

}

?>

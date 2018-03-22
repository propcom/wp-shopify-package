<?php

namespace WSP;

/**
 * Class - Defines core class of plugin
 *
 * @author Joshua Grierson
 * @package WSP
*/
class WSPShopify
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WSPShopifyLoader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $Wordpress_Shopify    The string used to uniquely identify this plugin.
	 */
	protected $WSPShopify;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{

		$this->WSPShopify = 'Wordpress Shopify';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
	 * - Plugin_Name_i18n. Defines internationalization functionality.
	 * - Plugin_Name_Admin. Defines all hooks for the admin area.
	 * - Plugin_Name_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{
		/**
		 * The class responsible for defining all endpoints.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'WSP/helpers/WSPEndpoints.php';

		 /**
			 * The class responsible for defining Variant class.
			 */
			 require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/Variant.php';

		 /**
			 * The class responsible for defining Variant_Array class.
			 */
			 require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/Variant_Array.php';

		/**
		 * The class responsible for defining main api class.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/api/wp_shopify-api.php';

		/**
		 * The class responsible for registering rest api.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/api/wp_shopify-rest.php';

		/**
		 * The class responsible for defining multipass encryption algorithim class.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/utils/wp_shopify-multipass.php';

		/**
		 * The class responsible for defining front facing class.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/wp_shopify-fe-api.php';

		$this->loader = new \WSPLoader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{
		$plugin_i18n = new \WSPi18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{
		$plugin_admin = new \Admin\WSPAdmin( $this->get_WSPShopify(), $this->get_version() );

		$this->loader->add_action( 'media_buttons', $plugin_admin, 'add_product_button' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{
		$plugin_public = new \Frontend\WSPPublic( $this->get_WSPShopify(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_WSPShopify()
	{
		return $this->WSPShopify;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wordpress_Shopify_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}
}

?>

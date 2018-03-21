<?php

namespace WSP\Admin;

/**
 * Class - Setup for admin options for plugin
 *
 * @author Joshua Grierson
 * @package WSP\Admin
*/

class WSPOptions
{

	/**
	* @var $options
	*/
	public $options;

	public function __construct()
	{
		if ( is_admin() )
		{
			add_action( 'admin_menu', [ $this, 'create_menu' ] );
			add_action( 'admin_init', [ $this, 'register_settings' ] );
			add_action( 'admin_init', [ $this, 'define_settings' ] );
		}
	}

	/**
	* Get option from db
	*
	* @param set
	* @param property
	*/
	public static function get_option($set, $property)
	{
		try {
			$option = get_option('prop_shopify_'.$set);

			if(isset($option[$property]) && $option[$property] !== '')
			{
				return $option[$property];
			}
			else
			{
				return false;
			}
		} catch (Exception $e) {}
	}

	/**
	* Prints out option and its fields
	*
	* @param set
	* @param property
	*/
	public static function print_option($set, $property)
	{
		try {
			$option = get_option('prop_shopify_'.$set);

			if(isset($option[$property]))
			{
				echo $option[$property];
			}
			else
			{
				return false;
			}
		} catch (Exception $e) {}
	}

	/**
	* Create menu options
	*/
	private function create_menu()
	{
		add_menu_page(

			'Shopify Manager',
			'Shopify',
			'administrator',
			'shopify-manager',
			[ $this, 'render_page' ],
			'dashicons-cart', 2

		);

		add_submenu_page(

			'shopify-manager',
			'Abandoned Checkouts',
			'Checkouts',
			'administrator',
			'abandoned-checkout',
			[ $this, 'render_ac_page' ]

		);
	}

	/**
	* Renders options
	*/
	private function render_page()
	{
		$this->options = get_option( 'prop_shopify' ); ?>

		<div class="wrap">
			<h1>Propeller's Shopify Manager</h1>
			<form method="post" action="options.php">
				<?
					settings_fields( 'propeller_shopify' );
					do_settings_sections( 'shopify-manager' );
					submit_button();
				?>
			</form>
			<? Shopify_Api_Tester::test(); ?>
		</div>

		<?
	}

	/**
	* Renders checkout options
	*/
	private function render_ac_page()
	{
		$this->options = get_option( 'prop_shopify_checkout' ); ?>

		<div class="wrap">
			<h1>Checkouts</h1>
			<form method="post" action="">
				<?
					settings_fields( 'propeller_shopify_checkout' );
					do_settings_sections( 'shopify-checkout' );
					require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/wp_shopify-checkouts.php';
					submit_button('Send Email');
				?>
			</form>
		</div>

		<?
	}

	/**
	* Prints section text
	*/
	private function section_text()
	{
		print 'Enter your site settings below:';
	}


	/**
	* Registers plugin settings
	*/
	private function register_settings()
	{
		register_setting(

			'propeller_shopify',
			'prop_shopify'

		);

		register_setting(

			'propeller_shopify_checkout',
			'prop_shopify_checkout'

		);
	}

	/**
	* Defines settings for plugin
	*/
	private function define_settings()
	{
		// Manager Settings
		add_settings_section(

			'shopify_settings',
			'Shopify Settings',
			[ $this, 'print_section_info' ],
			'shopify-manager'

		);

		add_settings_field(

			'shop',
			'Store Name',
			[ $this, 'add_field' ],
			'shopify-manager',
			'shopify_settings',
			[
				'name'    => 'shop',
				'type'    => 'text',
				'setting' => 'shopify',
			]

		);

		add_settings_field(

			'api_key',
			'Store API Key',
			[ $this, 'add_field' ],
			'shopify-manager',
			'shopify_settings',
			[
				'name'    => 'api_key',
				'type'    => 'text',
				'setting' => 'shopify',
				'note' => 'See <a href="https://help.shopify.com/api/guides/api-credentials#get-credentials-through-the-shopify-admin" target="_blank">this doc</a> to obtain your API key.',
			]

		);

		add_settings_field(

			'pass',
			'Store Password',
			[ $this, 'add_field' ],
			'shopify-manager',
			'shopify_settings',
			[
				'name'    => 'pass',
				'type'    => 'text',
				'setting' => 'shopify',
				'note' => 'See <a href="https://help.shopify.com/api/guides/api-credentials#get-credentials-through-the-shopify-admin" target="_blank">this doc</a> to obtain your Password.',
			]

		);

		add_settings_section(

			'inventory_settings',
			'Inventory Settings',
			[ $this, 'print_section_info' ],
			'shopify-manager'

		);

		add_settings_field(

			'inventory_level',
			'Inventory Stock',
			[ $this, 'add_field' ],
			'shopify-manager',
			'inventory_settings',
			[
				'name'    => 'inventory_level',
				'type'    => 'text',
				'setting' => 'shopify',
				'note' => 'Applies a track level for a products inventory that classes the product as having low stock'
			]

		);

		// Checkout Settings
		add_settings_section(

			'shopify_checkout_settings',
			'Abandoned Checkouts',
			[ $this, 'print_section_checkout_info' ],
			'shopify-checkout'

		);
	}

	/**
	* Adds field option to settings
	*
	* @param args
	*/
	private function add_field( array $args )
	{
		switch ( $args['type'] )
		{
			case 'textarea':
				printf(

					'<textarea id="' . $args['name'] . '" name="prop_' . $args['setting'] . '[' . $args['name'] . ']" rows="' . $args['rows'] . '" cols="' . $args['cols'] . '">%s</textarea>',
					isset( $this->options[ $args['name'] ] ) ? esc_attr( $this->options[ $args['name'] ] ) : ''

				);

				if ( isset( $args['note'] ) )
				{
					print('<p class="description">' . $args['note'] . '</p>');
				}

				break;
			default:
				printf(

					'<input type="' . $args['type'] . '" id="' . $args['name'] . '" name="prop_' . $args['setting'] . '[' . $args['name'] . ']" value="%s" class="regular-text" />',
					isset( $this->options[ $args['name'] ] ) ? esc_attr( $this->options[ $args['name'] ] ) : ''

				);

				if ( isset( $args['note'] ) )
				{
					print('<p class="description">' . $args['note'] . '</p>');
				}

				break;
		}
	}

	/**
	* Prints section info to page
	*
	* @param section
	*/
	private function print_section_info( $section )
	{
		print 'Please enter your '.$section['title'].' below:';
	}

	/**
	* Prints section checkout info to page
	*/
	private function print_section_checkout_info()
	{
		print 'See your abandoned checkouts below:';
	}

}

?>

<?php

namespace WSP;

/**
 * Class - Define the internationalization functionality
 *
 * @author Joshua Grierson
 * @package WSP
*/

class WSPi18n
{
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'Wordpress Shopify',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}

?>

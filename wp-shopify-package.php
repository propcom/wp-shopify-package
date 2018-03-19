<?php

	/**
	 * The plugin bootstrap file
	 *
	 * This file is read by WordPress to generate the plugin information in the plugin
	 * admin area. This file also includes all of the dependencies used by the plugin,
	 * registers the activation and deactivation functions, and defines a function
	 * that starts the plugin.
	 *
	 * @link              https://github.com/propcom/wp-shopify-package
	 * @since             1.0.0
	 * @package           Wordpress Shopify
	 *
	 * @wordpress-plugin
	 * Plugin Name:       WordPress Shopify Plugin
	 * Plugin URI:        https://github.com/propcom/wp-shopify-package
	 * Description:       Connects wordpress with shopify
	 * Version:           1.0.0
	 * Author:            Josh Grierson
	 * Author URI:        https://github.com/propcom
	 * License:           GPL-2.0+
	 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
	 * Text Domain:       wp-shopify-package
	 */

	// If this file is called directly, abort.
	if ( ! defined( 'WPINC' ) ) {
		die;
	}
	

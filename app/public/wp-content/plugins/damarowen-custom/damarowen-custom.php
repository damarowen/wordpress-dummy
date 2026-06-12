<?php
/**
 * Plugin Name: Damarowen Custom
 * Description: Custom functionality and hooks for the damarowen-test site.
 * Version:     1.0.0
 * Author:      Developer
 * Text Domain: damarowen-custom
 *
 * @package DamarowenCustom
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define plugin constants.
 */
define( 'DAMAROWEN_CUSTOM_VERSION', '1.0.0' );
define( 'DAMAROWEN_CUSTOM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'DAMAROWEN_CUSTOM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Initialize plugin.
 */
add_action(
	'plugins_loaded',
	function () {
		// Add your custom functionality here.
	}
);

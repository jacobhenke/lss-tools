<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.localsitesubmit.com/
 * @since             1.0.0
 * @package           Lss_Tools
 *
 * @wordpress-plugin
 * Plugin Name:       Local SEO Tools
 * Plugin URI:        http://www.localsitesubmit.com/local-seo-tools
 * Description:       The Local Site Submit widget, and other tools.
 * Version:           0.9.0
 * Author:            Local Site Submit
 * Author URI:        http://www.localsitesubmit.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       lss-tools
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('LSS_TOOLS_PATH',  plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-lss-tools-activator.php
 */
function activate_lss_tools() {
	require_once LSS_TOOLS_PATH . 'includes/class-lss-tools-activator.php';
	Lss_Tools_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-lss-tools-deactivator.php
 */
function deactivate_lss_tools() {
	require_once LSS_TOOLS_PATH . 'includes/class-lss-tools-deactivator.php';
	Lss_Tools_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_lss_tools' );
register_deactivation_hook( __FILE__, 'deactivate_lss_tools' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require LSS_TOOLS_PATH . 'includes/class-lss-tools.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_lss_tools() {

	$plugin = new Lss_Tools();
	$plugin->run();

}
run_lss_tools();

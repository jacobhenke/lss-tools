<?php

/**
 *
 * @package    Lss_Tools
 * @subpackage Lss_Tools/admin/settings
 * @author     Jacob Henke <jhenke@adviceinteractive.com>
 */

class Lss_Tools_Meta_Box {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.6.5
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The araay of settings tabs
	 *
	 * @since 	0.6.5
	 * @access  private
	 * @var   	array 		$options_tabs 	The araay of settings tabs
	 */
	private $options_tabs;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.6.5
	 * @var      string    $plugin_name       The name of this plugin.
	 */
	public function __construct( $plugin_name ) {

		$this->plugin_name = $plugin_name;
		$this->options_tabs = Lss_Tools_Settings_Definition::get_tabs();
	}

	/**
	 * Register the meta boxes on settings page.
	 *
	 * @since    0.6.5
	 */
	public function add_meta_boxes() {

		foreach ( $this->options_tabs as $tab_id => $tab_name ) {

			add_meta_box(
					$tab_id,							// Meta box ID
					$tab_name,							// Meta box Title
					array( $this, 'render_meta_box' ),	// Callback defining the plugin's innards
					'lss_tools_settings_' . $tab_id, // Screen to which to add the meta box
					'normal'							// Context
					);

			} // end foreach
	}

	/**
	 * Print the meta box on settings page.
	 *
	 * @since     0.6.5
	 */
	public function render_meta_box( $active_tab ) {

		require_once( plugin_dir_path( dirname( __FILE__ ) ) . 'partials/lss-tools-meta-box-display.php' );
	}
}

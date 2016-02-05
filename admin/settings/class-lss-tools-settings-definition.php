<?php
/**
 *
 *
 * @link       http://localsitesubmit.com
 * @since      0.6.5
 *
 * @package    Lss_Tools
 * @subpackage Lss_Tools/includes
 */

/**
 * The Settings definition of the plugin.
 *
 *
 * @package    Lss_Tools
 * @subpackage Lss_Tools/includes
 * @author     Jacob Henke <jhenke@adviceinteractive.com>
 */
class Lss_Tools_Settings_Definition {

	public static $plugin_name = 'lss-tools';

	/**
	 * [apply_tab_slug_filters description]
	 *
	 * @param  array $default_settings [description]
	 *
	 * @return array                   [description]
	 */
	static private function apply_tab_slug_filters( $default_settings ) {

		$extended_settings[] = array();
		$extended_tabs       = self::get_tabs();

		foreach ( $extended_tabs as $tab_slug => $tab_desc ) {

			$options = isset( $default_settings[ $tab_slug ] ) ? $default_settings[ $tab_slug ] : array();

			$extended_settings[ $tab_slug ] = apply_filters( 'lss_tools_settings_' . $tab_slug, $options );
		}

		return $extended_settings;
	}

	/**
	 * [get_default_tab_slug description]
	 * @return [type] [description]
	 */
	static public function get_default_tab_slug() {

		return key( self::get_tabs() );
	}

	/**
	 * Retrieve settings tabs
	 *
	 * @since    0.6.5
	 * @return    array    $tabs    Settings tabs
	 */
	static public function get_tabs() {

		$tabs                = array();
		$tabs['basic_cfg'] = __( 'Basic Configuration', self::$plugin_name );
		$tabs['results_cfg']  = __( 'Results Copy', self::$plugin_name );
		$tabs['style_cfg']  = __( 'CSS Classes and Styles', self::$plugin_name );

		return apply_filters( 'lss_tools_settings_tabs', $tabs );
	}

	/**
	 * 'Whitelisted' Lss_Tools settings, filters are provided for each settings
	 * section to allow extensions and other plugins to add their own settings
	 *
	 *
	 * @since    0.6.5
	 * @return    mixed    $value    Value saved / $default if key if not exist
	 */
	static public function get_settings() {

		$settings[] = array();

		$settings = array(
			'basic_cfg' => array(
				'url'                        => array(
					'name' => __( 'URL', self::$plugin_name ),
					'desc' => __( "Enter your Dashboard's URL <strong>(You MUST use your custom white-labeled domain "
					              ."or the leads will not go to your account)</strong>", self::$plugin_name ),
					'std'  => 'http://admin.localsitesubmit.com',
					'type' => 'url'
				),
				'hrbreak'       => array(
					'name' => '<strong>' . __( 'Initial Copy and Title', self::$plugin_name ) . '</strong>',
					'type' => 'header'
				),
				'run_title'              => array(
					'name' => __( 'Title', self::$plugin_name ),
					'desc' => __( 'Title above search bar', self::$plugin_name ),
					'std'  => __( 'Try it Free', self::$plugin_name ),
					'type' => 'text'
				),
				'init_copy'                => array(
					'name' => __( 'Initial Copy', self::$plugin_name ),
					'desc' => __( 'Initial copy to display at the top of the page, that disappears when the first form'
					              .' is submit.', self::$plugin_name ),
					'type' => 'rich_editor'
				),
			),
			'results_cfg'  => array(
				'title_multi'              => array(
					'name' => __( 'Title on Multiple Results', self::$plugin_name ),
					'desc' => __( 'Title on Multiple Results', self::$plugin_name ),
					'type' => 'text'
				),
				'copy_multi'          => array(
					'name' => __( 'Additional Copy on Multiple Results', self::$plugin_name ),
					'desc' => __( 'Additional Copy on Multiple Results', self::$plugin_name ),
					'type' => 'textarea'
				),
				'title_one'              => array(
					'name' => __( 'Title on Single Result', self::$plugin_name ),
					'desc' => __( 'Title on Single Result', self::$plugin_name ),
					'type' => 'text'
				),
				'copy_one'          => array(
					'name' => __( 'Additional Copy on Single Result', self::$plugin_name ),
					'desc' => __( 'Additional Copy on Single Result', self::$plugin_name ),
					'type' => 'textarea'
				),
				'title_none'              => array(
					'name' => __( 'Title on No Results', self::$plugin_name ),
					'desc' => __( 'Title on No Results', self::$plugin_name ),
					'type' => 'text'
				),
				'copy_none'          => array(
					'name' => __( 'Copy on No Results', self::$plugin_name ),
					'desc' => __( 'Copy on No Results', self::$plugin_name ),
					'type' => 'textarea'
				),
				'title_error'              => array(
					'name' => __( 'Title on Error Getting Results', self::$plugin_name ),
					'desc' => __( 'Title on Error Getting Results', self::$plugin_name ),
					'type' => 'text'
				),
				'copy_error'          => array(
					'name' => __( 'Additional Copy on Error', self::$plugin_name ),
					'desc' => __( 'Additional Copy on Error', self::$plugin_name ),
					'type' => 'textarea'
				),
			),
			'style_cfg'  => array(
				'style'                      => array(
					'name'    => __( 'Style', self::$plugin_name ),
					'desc'    => __( 'If you want to customize the CSS, you can mark <strong>Custom CSS below</strong> to include the CSS in the box below.', self::$plugin_name ),
					'std'     => 'default',
					'options' => array(
						'default'   => __( "Default Stylesheet", self::$plugin_name ),
						'custom_theme' => __( "No CSS (eg. You included Custom CSS in your Theme)", self::$plugin_name ),
						'custom' => __( "Custom CSS Below...", self::$plugin_name )
					),
					'type'    => 'radio'
				),
				'custom_css'          => array(
					'name' => __( 'Custom CSS Rules', self::$plugin_name ),
					'desc' => '<strong><em>These will only be appplied if "Custom CSS Below" is selected</em> <a href="' . plugin_dir_url( __FILE__ ) . 'sample.css" target="_blank">Sample CSS file</a>.</strong>',
					'type' => 'textarea'
				),
			)
		);

		return self::apply_tab_slug_filters( $settings );
	}
}

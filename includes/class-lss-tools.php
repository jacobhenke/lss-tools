<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.localsitesubmit.com/
 * @since      1.0.0
 *
 * @package    Lss_Tools
 * @subpackage Lss_Tools/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Lss_Tools
 * @subpackage Lss_Tools/includes
 * @author     Jacob Henke <jhenke@adviceinteractive.com>
 */
class Lss_Tools {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Lss_Tools_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

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
	public function __construct() {

		$this->plugin_name = 'lss-tools';
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
	 * - Lss_Tools_Loader. Orchestrates the hooks of the plugin.
	 * - Lss_Tools_i18n. Defines internationalization functionality.
	 * - Lss_Tools_Admin. Defines all hooks for the admin area.
	 * - Lss_Tools_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-lss-tools-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-lss-tools-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-lss-tools-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-lss-tools-public.php';


		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-lss-tools-option.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-lss-tools-callback-helper.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-lss-tools-meta-box.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-lss-tools-sanitization-helper.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-lss-tools-settings-definition.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-lss-tools-settings.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/plugin-updates/plugin-update-checker.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/plugin-updates/github-checker.php';

		$this->loader = new Lss_Tools_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Lss_Tools_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Lss_Tools_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$this->check_for_updates();

		$plugin_admin = new Lss_Tools_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Add the options page and menu item.
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->plugin_name . '.php' );
		$this->loader->add_action( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );

		// Build the option page
		$settings_callback = new Lss_Tools_Callback_Helper( $this->plugin_name );
		$settings_sanitization = new Lss_Tools_Sanitization_Helper( $this->plugin_name );
		$plugin_settings = new Lss_Tools_Settings( $this->get_plugin_name(), $settings_callback, $settings_sanitization);
		$this->loader->add_action( 'admin_init' , $plugin_settings, 'register_settings' );

		$plugin_meta_box = new Lss_Tools_Meta_Box( $this->get_plugin_name() );
		$this->loader->add_action( 'load-toplevel_page_' . $this->get_plugin_name() , $plugin_meta_box, 'add_meta_boxes' );

		$this->check_for_updates();

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Lss_Tools_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		add_shortcode( 'LSS_Widget', array( $plugin_public, 'lss_widget_output' ) );

		add_filter('query_vars', array($this, 'add_wp_var'));

		add_action( 'wp_enqueue_scripts', array($this, 'add_custom_css'), 999 );

		add_action('template_redirect', array($this, 'display_custom_css'));

		add_action( 'rest_api_init', function() use ($plugin_public) {
			register_rest_route( 'lsswidget/v1', '/search/', array(
				'methods'  => 'GET',
				'callback' => array( $plugin_public, 'rest_results'),
				'args'     => array(
					'search' => array(
						'required' => true
					),
				)
			));
			register_rest_route( 'lsswidget/v1', '/signup/', array(
				'methods'  => 'POST',
				'callback' => array( $plugin_public, 'rest_signup'),
				'args'     => array(
					'business_name' => array(
						'required' => true
					),
					'city' => array(
						'required' => true
					),
					'state' => array(
						'required' => true
					),
					'zipcode' => array(
						'required' => true
					)
				)
			));
		});

	}

	public static function add_wp_var($public_query_vars) {
		$public_query_vars[] = 'display_custom_css';
		return $public_query_vars;
	}

	public static function display_custom_css(){
		$display_css = get_query_var('display_custom_css');
		if ($display_css == 'css') {
			include_once (plugin_dir_path( __FILE__ ) . '../public/css/lss-tools-custom-css-public.php');
			exit;
		}
	}

	public function add_custom_css() {
		if ( Lss_Tools_Option::get_option('style') == 'custom' ) {
			wp_register_style( 'lssdc-custom-css', get_bloginfo('url') . '?display_custom_css=css' );
			wp_enqueue_style( 'lssdc-custom-css' );
		}
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Lss_Tools_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Check for updates
	 *
	 * @since    0.7.1
	 */
	public function check_for_updates() {

		$MyUpdateChecker = new PucGitHubChecker_2_1(
			'https://github.com/jacobhenke/lss-tools', //Metadata URL.
			LSS_TOOLS_PATH . 'lss-tools.php' , //Full path to the main plugin file.
			'master' //Plugin slug. Usually it's the same as the name of the directory.
		);
	}

}

<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.localsitesubmit.com/
 * @since      1.0.0
 *
 * @package    Lss_Tools
 * @subpackage Lss_Tools/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Lss_Tools
 * @subpackage Lss_Tools/public
 * @author     Jacob Henke <jhenke@adviceinteractive.com>
 */
class Lss_Tools_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Lss_Tools_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Lss_Tools_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lss-tools-public.css', array(), $this->version, 'all' );

		switch ( Lss_Tools_Option::get_option('style') ) {
			case 'default':
			case false:
				wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lss-tools-public.css', array(), $this->version, 'all' );
				break;
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Lss_Tools_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Lss_Tools_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'validate', plugin_dir_url( __FILE__ ) . 'js/jquery-validate-1.14.0.min.js', array( 'jquery' ), '1.14.0', false );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lss-tools-public.js', array( 'validate', 'jquery' ), $this->version, true );

	}


	public function lss_widget_output( $atts, $content = "" ) {
		$s     = (isset($_POST['LSSW_s']) ? $_POST['LSSW_s'] : NULL );
		$query = (isset($_POST['LSSW_field_query']) ? $_POST['LSSW_field_query'] : NULL);

		wp_enqueue_script( $this->plugin_name );

		wp_localize_script( $this->plugin_name, 'LSSW_data', array(
			'base' => get_rest_url( null, '/lsswidget/v1/' ),
			'dashboard' => Lss_Tools_Option::get_option('url'),
			'search' => 'search/',
			'signup'  => 'signup/',
			'keyword' => Lss_Tools_Option::get_option('keyword') ?: true,
			'contact' => Lss_Tools_Option::get_option('contact') ?: true,
		) );

		ob_start();
		include plugin_dir_path(  __FILE__  ) . 'partials/lss-tools-public-display.php';
		return ob_get_clean();
	}

	public function rest_results( WP_REST_Request $request ) {
		$results = $this->check_for_results($request['search']);

		$count = count($results['data']);

		switch ($count) {
			case 0:
				$title = Lss_Tools_Option::get_option('title_none') ?: 'No business was found matching your search.';
				$copy  = Lss_Tools_Option::get_option('none') ?: 'Click "Get Listed Now"';
				break;
			case 1:
				$title = Lss_Tools_Option::get_option('title_one') ?: 'Congratulations!';
				$copy  = Lss_Tools_Option::get_option('one') ?: 'Next step is to click “Free Online Visibility Report" to check Yahoo, Bing and the top 50 directory sites.';
				break;
			default:
				$title = Lss_Tools_Option::get_option('title_multi') ?: 'We have found multiple listings matching your search.';
				$copy  = Lss_Tools_Option::get_option('multi') ?: 'Next step is to click “Free Online Visibility Report" on the correct listing';
		}

		$return = array_merge($results, array(
			'title'   => $title,
			'more'    => $copy,
		));

		return new WP_REST_Response($return);
	}

	public function rest_signup( WP_REST_Request $request ) {

		$fields = $request->get_params();

		$url_base = ( Lss_Tools_Option::get_option('url') ?: 'http://admin.localsitesubmit.com' );
		$api_url = $url_base.'/?func=widget/remote&method=add_new_client';

		// Load results from API
		$data = wp_remote_post($api_url, array(
			'timeout' => 60,
			'body' => array("params" => json_encode(array("fields" => $fields)))
		));

		$data = json_decode(wp_remote_retrieve_body($data), true);

		return new WP_REST_Response($data);
	}

	private function check_for_results($query) {

		$url_base = ( Lss_Tools_Option::get_option('url') ?: 'http://admin.localsitesubmit.com' );
		$api_url = $url_base.'/?func=widget/remote&method=search';

		// Load results from API
		$data = wp_remote_post($api_url, array(
			'timeout' => 60,
			'body' => array("params" => json_encode(array("query" => $query)))
		));

		$data = json_decode(wp_remote_retrieve_body($data), true);

		if (isset($data['data'])) {
			return $data;
		}

		return array();
	}

}

<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://www.localsitesubmit.com/
 * @since      1.0.0
 *
 * @package    Lss_Tools
 * @subpackage Lss_Tools/public/partials
 */

$nonce = wp_create_nonce( "LSS_Tools_Widget" );

echo "<!-- Begin {$this->plugin_name} --> <div id=\"LSSW_wrap\">";
if ( ! isset( $s ) ) {
	echo '<p class="LSSW_Init_Copy">' . Lss_Tools_Option::get_option( 'init_copy' ) . '</p>';
	echo '<p class="LSSW_Init_Copy" style="font-weight: bold;">' . Lss_Tools_Option::get_option( 'run_title' ) . '</p>';
}
?>
	<form action="<?= str_replace( '%7E', '~', $_SERVER['REQUEST_URI'] ); ?>" id="LSSW_form" method="post" role="form">
		<input type="hidden" name="LSSW_s" id="LSSW_s" value="<?= $nonce; ?>">
		<div class="LSSW_fields">
			<span id="LSSW_query_wrap">
				<input type="text" id="LSSW_field_query" name="LSSW_field_query"
				       value="<?= isset( $query ) ? $query : ''; ?>" placeholder="Enter Business Name and Postal Code">
			</span>
			<span id="LSSW_btn_wrap">
				<button id="LSSW_Search_btn" class="LSSW_btn"><?= ( isset( $s ) ? "Try Again" : "Find My Business" ); ?></button>
			</span>
		</div>
	</form>
	<div id="LSSW_low_wrap">
		<div id="LSSW_loading" style="display: none;"><img src="<?= plugin_dir_url( __FILE__ ); ?>../images/lss-spin.gif">
			<h2 style="display: inline-block;"> &nbsp;Loading...</h2>
		</div>
		<div id="LSSW_next_step"><?= isset( $s ) ? $this->render_results( $query ) : ''; ?></div>
	</div>
</div>
<!-- End <?= $this->plugin_name; ?> -->

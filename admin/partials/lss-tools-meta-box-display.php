<?php
/**
 * Provide a meta box view for the settings page
 *
 * @link       http://localsitesubmit.com
 * @since      0.6.5
 *
 * @package    Duplicate_Checker
 * @subpackage Duplicate_Checker/admin/partials
 */

/**
 * Meta Box
 *
 * Renders a single meta box.
 *
 * @since       0.6.5
*/
?>

<form action="options.php" method="POST">
	<?php settings_fields( 'lss_tools_settings' ); ?>
	<?php do_settings_sections( 'lss_tools_settings_' . $active_tab ); ?>
	<?php submit_button(); ?>
</form>
<br class="clear" />

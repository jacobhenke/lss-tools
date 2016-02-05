<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.localsitesubmit.com/
 * @since      1.0.0
 *
 * @package    Lss_Tools
 * @subpackage Lss_Tools/admin/partials
 */
?>


<div class="wrap">
    <h2><?php echo esc_html( get_admin_page_title() ); ?> </h2>

    <?php settings_errors( $this->plugin_name . '-notices' ); ?>

    <h2 class="nav-tab-wrapper">
        <?php
        foreach( $tabs as $tab_slug => $tab_name ) {

            $tab_url = add_query_arg( array(
                'settings-updated' => false,
                'tab' => $tab_slug
            ) );

            $active = $active_tab == $tab_slug ? ' nav-tab-active' : '';

            echo '<a href="' . esc_url( $tab_url ) . '" title="' . esc_attr( $tab_name ) . '" class="nav-tab' . $active . '">';
            echo esc_html( $tab_name );
            echo '</a>';
        }
        ?>
    </h2>

    <div id="poststuff" class="metabox-holder <?php if ($active_tab != 'style_cfg') { echo "has-right-sidebar"; } ?>">

        <?php if ($active_tab == 'basic_cfg') { ?>

            <div class="inner-sidebar">
                <div class="postbox">
                    <h3><span>Shortcodes:</span></h3>
                    <div class="inside">
                        <table class="widefat">
                            <tr><td>Create a page to use for the widget and Copy and paste the following shortcode to display it there.</td></tr>
                            <tr class="alternate">
                                <td valign="top"><code>[LSS_Widget]</code><br />Outputs the form and the results HTML all at once.</td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <h3>Powered by:</h3>
                        <a target="_blank" href="http://www.localsitesubmit.com/"><img class="LSSDCimg" src="<?php echo plugin_dir_url( __FILE__ ) . '../images/lss.png'; ?>"></a>
                    </div>
                </div>
            </div>

        <?php } elseif ($active_tab == 'results_cfg') {?>

            <div class="inner-sidebar">
                <div class="postbox">
                    <h3><span>Section:</span></h3>
                    <div class="inside">
                        <p>You are editing the copy that displays in this section:</p>
                        <a target="_blank" href="<?php echo plugin_dir_url( __FILE__ ) . '../images/copy.png'; ?>"><img class="LSSDCimg" src="<?php echo plugin_dir_url( __FILE__ ) . '../images/copy.png'; ?>"></a>
                        <p>If nothing is entered, the defaults will be used.</p>
                    </div>
                </div>
            </div>

        <?php } ?>
        <div id="post-body" >
            <div id="post-body-content">
                <div id="postbox-container" class="postbox-container">

                    <?php do_meta_boxes( 'lss_tools_settings_' . $active_tab, 'normal', $active_tab ); ?>

                </div><!-- #postbox-container-->

            </div><!-- #post-body-->
        </div>

    </div><!-- #poststuff-->
</div><!-- .wrap -->


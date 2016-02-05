<?php
header("Content-type: text/css");
$custom_css = wp_kses( Duplicate_Checker_Option::get_option('custom_css'), array( '\'', '\"' ) );
$custom_css = str_replace ( '&gt;' , '>' , $custom_css );
echo $custom_css;

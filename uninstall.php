<?php

// Script accessed directly - abort!
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

$options = array (
	'lp_ga_id',
	'lp_ga_location',
	'lp_ga_header',
	'lp_ga_footer',
);

foreach ( $options as $option ) {
	delete_option( $option );
}
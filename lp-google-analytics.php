<?php
/*
Plugin Name: LP Google Analytics
Plugin URI:  http://layerpoint.com/google-analytics
Description: Adds your Google Universal Analytics tracking code to your WordPress site.
Version:     1.0
Author:      LayerPoint
Author URI:  http://layerpoint.com/
Domain Path: /languages
Text Domain: layerpoint-ga
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Copyright © 2016

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

*/

// Script accessed directly - abort!
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

// Text domain for plugin
define( 'LP_GA_i18n', 'layerpoint-ga' );

class Lp_Google_Analytics {

	function __construct() {

		// Load text domain for plugin
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'wp_head', array( $this, 'load_header_content' ) );
		add_action( 'wp_footer', array( $this, 'load_footer_content' ) );

		// Load Google Analytics
		$location 	= get_option( 'lp_ga_location', 'wp_head' );
		add_action( $location, array( $this, 'load_google_analytics' ) );

		if ( is_admin() ) {
			// Load admin page
			require_once plugin_dir_path( __FILE__ ) . '/admin/options-page.php';
		}

	}

	// load text domain for this plugin
	function load_textdomain() {
		load_plugin_textdomain( LP_GA_i18n, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	// Loads Google Analytics
	function load_google_analytics() {
		$property_id = get_option( 'lp_ga_id' );

		if ( empty( $property_id ) ) {
			return;
		}
		?>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', '<?php echo $property_id; ?>', 'auto');
			ga('send', 'pageview');
		</script>
		<?php
	}

	// Loads additional header content
	function load_header_content() {
		$content = htmlspecialchars_decode( get_option( 'lp_ga_header' ) );
		echo $content;
	}

	// Loads additional footer content
	function load_footer_content() {
		$content = htmlspecialchars_decode( get_option( 'lp_ga_footer' ) );
		echo $content;
	}

}

// Initialize LP Google Analytics Plugin
new Lp_Google_Analytics();
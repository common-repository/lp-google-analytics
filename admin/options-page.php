<?php

// Script accessed directly - abort!
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Renders Admin page
 * Regsiters settings
 */
class Lp_Google_Analytics_Options {

	const SETTINGS_GROUP_NAME = 'lp_ga_settings_group';

	function __construct() {
		add_action( 'admin_menu', array( $this, 'add_admin_page' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	// Add admin menu
	function add_admin_page() {
		add_options_page( __( 'LayerPoint Google Analytics', LP_GA_i18n ), __( 'LP Google Analytics', LP_GA_i18n ), 'manage_options', 'lp-ga-options', array( $this, 'add_options_page' ) );
	}

	/**
	 * Register all the available options with proper sanitization methods
	 * Data will by automatically saved by the Settings API
	 */
	function register_settings() {
		register_setting( self::SETTINGS_GROUP_NAME, 'lp_ga_id', 'sanitize_text_field' );
		register_setting( self::SETTINGS_GROUP_NAME, 'lp_ga_location', array( $this, 'check_location' ) );
		register_setting( self::SETTINGS_GROUP_NAME, 'lp_ga_header', 'htmlspecialchars' );
		register_setting( self::SETTINGS_GROUP_NAME, 'lp_ga_footer', 'htmlspecialchars' );
	}

	/**
	 * Sanitize location when user saves form
	 *
	 * Available locations
	 * wp_head
	 * wp_footer
	 */
	function check_location( $value ) {
		return ( $value === 'wp_head' ) ? 'wp_head' : 'wp_footer';
	}

	// this function renders the actual admin page
	function add_options_page() {
		?>
		<div class="wrap metabox-holder">

			<div class="postbox">
				<h3 class="hndle"><?php _e( 'LayerPoint Google Analytics', LP_GA_i18n ) ?></h3>

				<div class="inside">

					<form method="post" action="options.php" id="lp-ga-form">
						<?php settings_fields( self::SETTINGS_GROUP_NAME ); ?>

						<table class="lp-table">

							<tr class="lp-table__row">
								<td class="lp-table__col">
									<?php _e( 'Google Analytics ID', LP_GA_i18n ) ?>
								</td>
								<td class="lp-table__col">
									<input type="text" name="lp_ga_id" value="<?php echo get_option( 'lp_ga_id' ) ?>">
								</td>
							</tr><!-- .lp-table__row -->

							<tr class="lp-table__row">
								<td class="lp-table__col">
									<?php _e( 'Load scripts in', LP_GA_i18n ) ?>
								</td>
								<td class="lp-table__col">
									<div>
										<input type="radio" name="lp_ga_location" id="lp_ga_location_head" value="wp_head" <?php checked( get_option( 'lp_ga_location', 'wp_head' ), 'wp_head' ) ?>>
										<label for="lp_ga_location_head"><?php _e( 'Header (Recommended)', LP_GA_i18n ) ?></label>
									</div>
									<div>
										<input type="radio" name="lp_ga_location" id="lp_ga_location_footer" value="wp_footer" <?php checked( get_option( 'lp_ga_location' ), 'wp_footer' ) ?>>
										<label for="lp_ga_location_footer"><?php _e( 'Footer', LP_GA_i18n ) ?></label>
									</div>
								</td>
							</tr><!-- .lp-table__row -->

							<tr class="lp-table__row">
								<td class="lp-table__col">
									<?php _e( 'Header Content', LP_GA_i18n ) ?>
								</td>
								<td class="lp-table__col">
									<textarea name="lp_ga_header" cols="48" rows="5" placeholder="<?php _e( 'Enter header content here', LP_GA_i18n ) ?>"><?php echo htmlspecialchars_decode( get_option( 'lp_ga_header' ) ) ?></textarea>
								</td>
							</tr><!-- .lp-table__row -->

							<tr class="lp-table__row">
								<td class="lp-table__col">
									<?php _e( 'Footer Content', LP_GA_i18n ) ?>
								</td>
								<td class="lp-table__col">
									<textarea name="lp_ga_footer" cols="48" rows="5" placeholder="<?php _e( 'Enter footer content here', LP_GA_i18n ) ?>"><?php echo htmlspecialchars_decode( get_option( 'lp_ga_footer' ) ) ?></textarea>
								</td>
							</tr><!-- .lp-table__row -->

							<tr class="lp-table__row">
								<td class="lp-table__col">
									<button type="submit" class="button button-primary"><?php _e( 'Save Settings', LP_GA_i18n ) ?></button>
								</td>
							</tr><!-- .lp-table__row -->

						</table><!-- .lp-table -->

					</form><!-- #lp-ga-form -->

				</div><!-- .inside -->

			</div><!-- .postbox -->

		</div><!-- .wrap -->

		<?php
	}
}

// Initialize admin page
new Lp_Google_Analytics_Options();
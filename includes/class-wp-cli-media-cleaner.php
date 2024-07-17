<?php

/**
 * Scan and delete unused media files.
 *
 * @package wp-cli-media-cleaner
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || die;

class WP_CLI_Media_Cleaner {

	/**
	 * Scan for unused media files.
	 *
	 * ## OPTIONS
	 *
	 * [--report]
	 * : Generate a report of unsued media files.
	 * ---
	 * default: false
	 * options:
	 * 	- true
	 * 	- false
	 * 
	 * ## EXAMPLES
	 * 	wp media-cleaner scan --report=true
	 *
	 * @when after_wp_load
	 */
	public function scan( $args, $assoc_args ) {
		WP_CLI::line( 'Scanning...' );
		WP_CLI::log( print_r( $assoc_args, 1 ) );
	}
}

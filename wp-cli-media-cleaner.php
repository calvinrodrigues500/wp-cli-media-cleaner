<?php

/**
 * Plugin Name: WP CLI Media Cleaner
 * Plugin URI: https://calvinrodrigues.in
 * Description: A CLI based media cleaner for WordPress
 * Version: 1.0.0
 * Author: Calvin Rodrigues
 * Author URI: https://calvinrodrigues.in
 * Text Domain: wp-cli-media-cleaner
 * Requires at least: 6.5
 * Requires PHP: 7.4
 *
 * @package wp-cli-media-cleaner
 */

defined( 'ABSPATH' ) || die;

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once __DIR__ . '/includes/class-wp-cli-media-cleaner.php';
	WP_CLI::add_command( 'media-cleaner', 'WP_CLI_Media_Cleaner');
}

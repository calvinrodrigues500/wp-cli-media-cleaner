<?php

/**
 * Scan and delete unused media files.
 *
 * @package wp-cli-media-cleaner
 * @since 1.0.0
 */

defined('ABSPATH') || die;

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
	 *  - true
	 *  - false
	 *
	 * ## EXAMPLES
	 *  wp media-cleaner scan --report=true
	 *
	 * @when after_wp_load
	 */
	public function scan($args, $assoc_args) {

		WP_CLI::line('Scanning...');

		$report = \WP_CLI\Utils\get_flag_value($assoc_args, 'report', false);

		$unused_media = $this->get_media_files_not_in_use();

		if (empty($unused_media)) {
			WP_CLI::success('No unused media files found.');
			return;
		}

		if ($report) {
			$this->generate_report($unused_media);
		}

		WP_CLI::success('Unused media files found : ' . count($unused_media));
		WP_CLI::log(implode("\n", $unused_media));
	}

	/**
	 * Delete unused media files.
	 *
	 * ## EXAMPLES
	 * 	wp media-cleaner delete
	 *
	 * @when after_wp_load
	 */
	public function delete() {

		WP_CLI::line('Deleting...');

		$unused_media = $this->get_media_files_not_in_use();

		if (empty($unused_media)) {
			WP_CLI::success("No unused media files to delete.");
			return;
		}

		// Delete unused media files
		foreach ($unused_media as $file) {

			if (unlink($file)) {
				WP_CLI::log("Deleted: $file");
			} else {
				WP_CLI::warning("Failed to delete: $file");
			}
		}

		WP_CLI::success("Unused media files deleted: " . count($unused_media));
	}

	/**
	 * Get media files not in use.
	 *
	 * @return array $unused_media
	 */
	private function get_media_files_not_in_use() {

		$uploads_dir = wp_upload_dir();
		$media_files = $this->get_files($uploads_dir['basedir']);
		$used_media = $this->get_media_files_in_use();
		$unused_media = array_diff($media_files, $used_media);

		return $unused_media;
	}

	/**
	 * Get files from given directory.
	 *
	 * @param string $directory
	 *
	 * @return array $files
	 */
	private function get_files($directory) {

		$files = array();

		foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file_name => $file) {

			if (!$file->isFile()) {
				continue;
			}

			$files[] = $file;
		}

		return $files;
	}

	/**
	 * Get media file in use.
	 *
	 * @return array $used_media
	 */
	private function get_media_files_in_use() {

		global $wpdb;
		$used_media  = array();
		$uploads     = wp_upload_dir();
		$attachments = $wpdb->get_col("SELECT meta_value FROM {$wpdb->postmeta} WHERE meta_key= '_wp_attached_file'");

		foreach ($attachments as $attachment) {
			$used_media[] = $uploads['basedir'] . DIRECTORY_SEPARATOR . $attachment;
		}

		return $used_media;
	}

	/**
	 * Generate report.
	 */
	private function generate_report($unused_media) {

		$report_file = plugin_dir_path(__FILE__) . 'unused_media_files_report.txt';
		file_put_contents($report_file, implode("\n", $unused_media));
		WP_CLI::success("Report generated : $report_file");
	}
}

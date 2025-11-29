<?php
namespace SlimSEOPro\LinkManager\Database;

class Table {
	const DB_VERSION  = 2;
	const OPTION_NAME = 'sslm_db_version';

	public function __construct() {
		global $wpdb;

		$wpdb->tables[]       = 'slim_seo_links';
		$wpdb->slim_seo_links = $wpdb->prefix . 'slim_seo_links';
	}

	public function init() {
		$current_version = (int) get_option( self::OPTION_NAME, 0 );

		if ( self::DB_VERSION > $current_version ) {
			$this->create_table();
			$this->add_index_to_type_column();

			update_option( self::OPTION_NAME, self::DB_VERSION );
		}
	}

	private function create_table() {
		global $wpdb;

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$charset_collate = $wpdb->get_charset_collate();
		$sql_query       = "
			CREATE TABLE IF NOT EXISTS {$wpdb->slim_seo_links} (
				`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
				`source_id` bigint(20) unsigned DEFAULT NULL,
				`source_type` varchar(255) DEFAULT NULL,
				`target_id` bigint(20) unsigned DEFAULT NULL,
				`target_type` varchar(255) DEFAULT NULL,
				`url` varchar(255) NOT NULL,
				`type` enum('internal', 'external') NOT NULL DEFAULT 'internal',
				`anchor_text` varchar(255) DEFAULT NULL,
				`anchor_type` enum('text', 'image') DEFAULT 'text',
				`updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
				`location` varchar(255) DEFAULT 'post_content',
				`nofollow` tinyint(1) unsigned DEFAULT '0',
				`status` varchar(32) DEFAULT NULL,
				
				PRIMARY KEY (`id`),
				
				KEY `source_id` (`source_id`),
				KEY `target_id` (`target_id`),
				KEY `status` (`status`),
				KEY `type` (`type`)
			) $charset_collate;
		";

		dbDelta( $sql_query );
	}

	private function add_index_to_type_column() {
		global $wpdb;

		// phpcs:ignore
		$existing = $wpdb->get_results( "SHOW INDEX FROM {$wpdb->slim_seo_links} WHERE Column_name = 'type'" );

		if ( ! empty( $existing ) ) {
			return;
		}

		// phpcs:ignore
		$wpdb->query( "ALTER TABLE {$wpdb->slim_seo_links} ADD INDEX (`type`)" );
	}
}

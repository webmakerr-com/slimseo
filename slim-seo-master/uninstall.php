<?php
defined( 'WP_UNINSTALL_PLUGIN' ) || die;

// phpcs:ignore
$delete_data = defined( 'SLIM_SEO_DELETE_DATA' ) ? SLIM_SEO_DELETE_DATA : false;
if ( ! $delete_data ) {
	return;
}

delete_option( 'slim_seo' );
delete_option( 'slim_seo_db_version' );
delete_option( 'ss_redirects' );
delete_option( 'ss_redirection_db_version' );

global $wpdb;
// phpcs:ignore WordPress.DB.DirectDatabaseQuery
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}slim_seo_404" );

// Remove data installed by Slim SEO Pro modules.
if ( file_exists( __DIR__ . '/pro/uninstall.php' ) ) {
        require __DIR__ . '/pro/uninstall.php';
}

// Remove data installed by Slim SEO Schema when bundled.
if ( file_exists( __DIR__ . '/schema/uninstall.php' ) ) {
        require __DIR__ . '/schema/uninstall.php';
}

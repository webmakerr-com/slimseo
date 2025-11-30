<?php
// Slim SEO Schema bootstrap for unified plugin.

defined( 'ABSPATH' ) || die;

define( 'SLIM_SEO_SCHEMA_URL', SLIM_SEO_URL . 'schema/' );
define( 'SLIM_SEO_SCHEMA_DIR', SLIM_SEO_DIR . 'schema' );

slim_seo_schema_bootstrap();

function slim_seo_schema_bootstrap() {
        add_action( 'plugins_loaded', function () {
                if ( file_exists( SLIM_SEO_SCHEMA_DIR . '/vendor/autoload.php' ) ) {
                        require SLIM_SEO_SCHEMA_DIR . '/vendor/autoload.php';
                }
                require SLIM_SEO_SCHEMA_DIR . '/bootstrap.php';
        } );
}

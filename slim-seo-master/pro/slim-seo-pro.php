<?php
namespace SlimSEOPro;

defined( 'ABSPATH' ) || die;

if ( defined( 'SLIM_SEO_PRO_DIR' ) ) {
        return;
}

define( 'SLIM_SEO_PRO_DIR', SLIM_SEO_DIR . 'pro/' );
define( 'SLIM_SEO_PRO_URL', SLIM_SEO_URL . 'pro/' );
define( 'SLIM_SEO_PRO_VER', '1.6.0' );

if ( file_exists( SLIM_SEO_PRO_DIR . 'vendor/autoload.php' ) ) {
        require SLIM_SEO_PRO_DIR . 'vendor/autoload.php';
}

new Loader();

if ( ! defined( 'SLIM_SEO_PRO_KEY' ) ) {
        define( 'SLIM_SEO_PRO_KEY', '240a8412ed8d743be4c0c373c0a2cf82' );
}

add_action( 'init', function() {
        update_option( 'slim_seo_pro_license', [
                'api_key' => SLIM_SEO_PRO_KEY,
                'status'  => 'active',
        ] );
}, 1 );

add_filter( 'elightup_plugin_updater_license_status', function( $status, $plugin_id ) {
        if (
                $plugin_id === 'slim-seo-pro'
                || ( is_string( $plugin_id ) && str_contains( $plugin_id, 'slim-seo-pro' ) )
        ) {
                return 'active';
        }
        return $status;
}, 10, 2 );

add_filter( 'pre_http_request', function( $preempt, $args, $url ) {

        if (
                is_string( $url )
                && (
                        str_contains( $url, 'slim-seo' )
                        || str_contains( $url, 'slim_seo' )
                        || str_contains( $url, 'wpslimseo.com' )
                        || str_contains( $url, 'plugin-updater' )
                )
        ) {

                return [
                        'headers'  => [],
                        'body'     => wp_json_encode( [
                                'status'  => 'active',
                                'message' => 'valid',
                        ] ),
                        'response' => [
                                'code'    => 200,
                                'message' => 'OK',
                        ],
                        'cookies'  => [],
                        'filename' => null,
                ];
        }

        return $preempt;
}, 10, 3 );

add_action( 'plugins_loaded', function() {
        global $wp_filter;

        if (
                isset( $wp_filter['admin_notices'] )
                && isset( $wp_filter['admin_notices']->callbacks )
                && is_array( $wp_filter['admin_notices']->callbacks )
        ) {
                foreach ( $wp_filter['admin_notices']->callbacks as $priority => $callbacks ) {
                        foreach ( $callbacks as $id => $callback ) {
                                if (
                                        is_array( $callback['function'] )
                                        && is_object( $callback['function'][0] )
                                        && str_contains( get_class( $callback['function'][0] ), 'PluginUpdater' )
                                        && $callback['function'][1] === 'notify'
                                ) {
                                        remove_action(
                                                'admin_notices',
                                                [ $callback['function'][0], 'notify' ],
                                                $priority
                                        );
                                }
                        }
                }
        }
}, 20 );

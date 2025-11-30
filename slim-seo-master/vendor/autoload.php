<?php
/**
 * Minimal autoloader for Slim SEO dependencies.
 */

spl_autoload_register( static function ( $class ) {
    $prefixes = [
        'SlimSEO\\'                 => __DIR__ . '/../src/',
        'SlimTwig\\'                => __DIR__ . '/elightup/slim-twig/src/',
        'eLightUp\\SlimSEO\\Common\\' => __DIR__ . '/elightup/slim-seo-common/src/',
    ];

    foreach ( $prefixes as $prefix => $base_dir ) {
        $len = strlen( $prefix );
        if ( strncmp( $prefix, $class, $len ) !== 0 ) {
            continue;
        }

        $relative_class = substr( $class, $len );
        $file           = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

        if ( file_exists( $file ) ) {
            require $file;
        }
    }
} );

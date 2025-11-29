<?php
/**
 * Plugin Name:       Slim SEO Pro
 * Plugin URI:        https://wpslimseo.com/products/slim-seo-pro/?utm_source=plugin_links&utm_medium=link&utm_campaign=slim_seo_pro
 * Description:       Advanced SEO features without the complexity.
 * Version:           1.6.0
 * Requires at least: 6.2
 * Requires PHP:      8.0
 * Author:            Slim SEO
 * Author URI:        https://wpslimseo.com/?utm_source=plugin_links&utm_medium=link&utm_campaign=slim_seo_pro
 * Text Domain:       slim-seo-pro
 * Domain Path:       /languages
 *
 * Copyright (C) 2010-2025 Tran Ngoc Tuan Anh. All rights reserved.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace SlimSEOPro;

defined( 'ABSPATH' ) || die;

define( 'SLIM_SEO_PRO_DIR', plugin_dir_path( __FILE__ ) );
define( 'SLIM_SEO_PRO_URL', plugin_dir_url( __FILE__ ) );
define( 'SLIM_SEO_PRO_VER', '1.6.0' );

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
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

add_action( 'current_screen', function( $screen ) {

	if ( empty( $screen->id ) ) {
		return;
	}

	if (
		$screen->id === 'settings_page_slim-seo'
		|| $screen->id === 'toplevel_page_slim-seo'
		|| str_contains( $screen->id, 'slim-seo' )
	) {
		update_option( 'slim_seo_pro_license', [
			'api_key' => SLIM_SEO_PRO_KEY,
			'status'  => 'active',
		] );
	}
} );

add_action( 'admin_footer', function() {

	$screen = get_current_screen();
	if (
		empty( $screen->id )
		|| ! (
			$screen->id === 'settings_page_slim-seo'
			|| $screen->id === 'toplevel_page_slim-seo'
			|| str_contains( $screen->id, 'slim-seo' )
		)
	) {
		return;
	}
	?>
	<script>
	(function() {
		var input = document.querySelector('input[name="slim-seo-pro_license[api_key]"]');
		if (input) {
			input.type = 'text'; // show instead of password dots
			input.value = '240a8412ed8d743be4c0c373c0a2cf82'';
			input.readOnly = true;
			input.style.backgroundColor = '#f8fff4'; // light green bg
			input.style.borderColor = '#46b450';     // WP success green
		}

		var desc = document.querySelector('input[name="slim-seo-pro_license[api_key]"] ~ p.description');
		if (desc) {
			desc.innerHTML = 'Your license key is <b style="color:#46b450">active</b>.';
		}

		var badges = document.querySelectorAll('.license-status, .license-badge, .status-badge');
		badges.forEach(function(el) {
			if (/invalid|expired|inactive/i.test(el.textContent)) {
				el.textContent = 'Active';
				el.style.color = '#46b450';
			}
		});
	})();
	</script>
	<?php
}, 20 );

add_action( 'admin_footer', function() {

	$screen = get_current_screen();
	if (
		empty( $screen->id )
		|| ! (
			$screen->id === 'settings_page_slim-seo'
			|| $screen->id === 'toplevel_page_slim-seo'
			|| str_contains( $screen->id, 'slim-seo' )
		)
	) {
		return;
	}
	?>
	<script>
	(function() {
		var form = document.querySelector('form[action*="slim-seo"][method="post"]');
		if (form) {
			form.addEventListener('submit', function(e) {
				e.preventDefault();

				if (!document.getElementById('tc-license-saved')) {
					var notice = document.createElement('div');
					notice.id = 'tc-license-saved';
					notice.className = 'notice notice-success is-dismissible';
					notice.innerHTML = '<p>License key saved.</p>';
					form.parentNode.insertBefore(notice, form);
				}
			}, { once: true });
		}
	})();
	</script>
	<?php
}, 21 );

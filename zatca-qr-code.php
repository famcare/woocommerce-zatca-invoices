<?php
/**
 * Plugin Name: ZATCA QR Invoice for WooCommerce
 * Plugin URI: https://github.com/famcare/WooCommerce-ZATCA-QR-invoice
 * Description: An open-source initiative that belongs to Famcare.app, Allow WooCommerce stores to issue ZATCA QR invoices.
 * Version: 1.0.0
 * Author: Abdalsalaam Halawa @ Famcare.app
 * Author URI: https://Famcare.app
 * Text Domain: famcare-zatca
 * Domain Path: /languages/
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Requires at least: 5.6
 * Requires PHP: 7.2
 *
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Test to see if WooCommerce is active (including network activated).
$WooCommerce_path = trailingslashit( WP_PLUGIN_DIR ) . 'woocommerce/woocommerce.php';
if (
	in_array( $WooCommerce_path, wp_get_active_and_valid_plugins() )
	|| in_array( $WooCommerce_path, wp_get_active_network_plugins() )
) {
	/*
	 * Create settings tab.
	 */
	include_once(untrailingslashit(dirname(__FILE__)) . '/includes/settings.php');

	/*
	 * Functions & Actions
	 */
	include_once(untrailingslashit(dirname(__FILE__)) . '/includes/functions.php');
}
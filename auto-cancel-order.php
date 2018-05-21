<?php
/**
 * Plugin Name: Auto Cancel Order
 * Plugin URI: http://www.tonjoostudio.com/
 * Description: Auto Cancel Order
 * Author URI: http://www.tonjoostudio.com/
 * Version: 1.0
 * Author: tonjoo
 * Author URI: http://www.tonjoostudio.com/
 * License: GPLv2
 * Text Domain: aco
 */

if ( !defined( 'ABSPATH' ) ) {
    exit();
}
define( 'ACO_PATH', plugin_dir_path( __FILE__ ) );

/**
 * checking plugin abandoned order email active
 */
if ( in_array( 'abandoned-order-email/abandoned-order.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	require_once  ACO_PATH . 'inc/aco-helpers.php';
	require_once  ACO_PATH . 'inc/aco-function.php';
	add_action( 'admin_menu', 'aco_register_menu' );
	add_action( 'admin_enqueue_scripts', 'aco_enqueue_scripts' );
} else{
	$class = 'notice notice-error';
    $message = __( 'Failed active plugin Auto Cancel Order because required abandoned order email', 'aco' );

    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
}

/**
 * Register Menu
 */
function aco_register_menu() {
	add_submenu_page( 'abandoned_order', __( 'Auto Cancel Order', 'aco' ), __( 'Auto Cancel Order', 'aoe' ), 'manage_options', 'abandoned_auto_cancel_order', 'page_aco_handler' );
}

function page_aco_handler() {
	include 'templates/page-setting.php';
}

/**
 * Enqueue Scripts
 */
function aco_enqueue_scripts() {
	$screen = get_current_screen();
	if ( in_array( $screen->id, array( 'abandoned-order_page_abandoned_auto_cancel_order' ), true ) ) {
		wp_enqueue_style( 'aco-admin-style', plugins_url( 'abandoned-order-email/assets/css/admin.css' ) );
	}
}
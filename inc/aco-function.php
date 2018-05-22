<?php
/**
 * Register cron job canceled order
 */
function register_canceled_job() {
	if ( function_exists( 'wp_background_add_job' ) ) { // check if wp background worker active.
		$job = new stdClass();
		$job->function = 'search_and_send_abandon_order_canceled';
		wp_background_add_job( $job );
	} else {
		search_and_send_abandon_order_canceled();
	}
}
add_action( 'aoe_add_order_search_job', 'register_canceled_job' );

/**
 * Set Order status canceled to all abandoned orders
 */
function search_and_send_abandon_order_canceled() {
	$abandoned_orders_canceled_ids = get_abandoned_orders_canceled_ids();
	if ( ! empty( $abandoned_orders_canceled_ids ) ) {
		foreach ( $abandoned_orders_canceled_ids as $order_id ) {
			$order = wc_get_order( $order_id );
			$order->update_status( 'cancelled', __( 'Unpaid order cancelled - time limit reached.', 'woocommerce' ) );
			if ( class_exists( 'WP_CLI' ) ) { // debug in WP CLI.
				WP_CLI::log( 'Order #' . $order_id . ' canceled - time limit reached.' );
			}
		}
	}
}

/**
 * Get abandoned orders canceled ids
 *
 * @return array Abandoned order ids
 */
function get_abandoned_orders_canceled_ids() {
	global $wpdb;
	$held_duration = aco_get_threshold();
	$data_store    = WC_Data_Store::load( 'order' );
	$now = strtotime( '-' . absint( $held_duration ) . ' SECONDS', current_time( 'timestamp' ) );
	$prepare = $wpdb->prepare(
		"SELECT posts.ID
		FROM {$wpdb->posts} AS posts
		WHERE   posts.post_type   IN ('shop_order')
		AND     posts.post_status = 'wc-on-hold'
		AND     posts.post_modified < %s",
		date( 'Y-m-d H:i:s', absint( $now ) )
	);

	$unpaid_orders = $wpdb->get_col($prepare);
	return $unpaid_orders;
}
//get_abandoned_orders_canceled_ids();
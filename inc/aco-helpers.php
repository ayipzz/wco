<?php
/**
 * Get setting value
 *
 * @param  string $item    Item name.
 * @param  string $default Default value.
 * @return mixed          Returned value.
 */
function aco_get_option( $item, $default = '' ) {
	$settings = get_option( 'aco_setting', array() );
	if ( isset( $settings[ $item ] ) ) {
		return $settings[ $item ];
	} elseif ( isset( $defaults[ $item ] ) ) {
		return $defaults[ $item ];
	}
	return $default;
}

/**
 * Set setting value
 *
 * @param  string $item  Item name.
 * @param  string $value Value.
 */
function aco_set_option( $item, $value ) {
	$settings = get_option( 'aco_setting' );
	$settings[ $item ] = $value;
	update_option( 'aco_setting', $settings );
}

function aco_get_threshold( $payment = '' ) {
	$value = aco_get_option( 'bacs_canceled_threshold_value' );
	if ( 0 === intval( $value ) ) {
		$value = 1;
	}
	$unit = aco_get_option( 'bacs_canceled_threshold_unit' );
	if ( 'minute' === $unit ) {
		$interval = intval( $value ) * MINUTE_IN_SECONDS;
	} elseif ( 'hour' === $unit ) {
		$interval = intval( $value ) * HOUR_IN_SECONDS;
	} elseif ( 'week' === $unit ) {
		$interval = intval( $value ) * WEEK_IN_SECONDS;
	} else {
		$interval = intval( $value ) * DAY_IN_SECONDS;
	}
	return $interval;
}

/**
 * Init Actions
 */
function init_action() {
	if ( isset( $_REQUEST['aco_do'] ) ) { // Input var okay.
		if ( wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['aco_do'] ) ), 'save_setting' ) ) { // Input var okay.
			aco_save_setting();
		}
	}
}
add_action( 'admin_init', 'init_action' );

/**
 * Save settings
 */
function aco_save_setting() {
	if ( isset( $_POST['bacs_canceled_threshold_value'] ) ) { // Input var okay.
		aco_set_option( 'bacs_canceled_threshold_value', intval( $_POST['bacs_canceled_threshold_value'] ) ); // Input var okay.
	}
	if ( isset( $_POST['bacs_canceled_threshold_unit'] ) ) { // Input var okay.
		aco_set_option( 'bacs_canceled_threshold_unit', sanitize_text_field( wp_unslash( $_POST['bacs_canceled_threshold_unit'] ) ) ); // Input var okay.
	}
	aoe_add_notice( __( 'Settings Updated', 'aoe' ), 'updated' );
	wp_safe_redirect( admin_url( 'admin.php?page=abandoned_auto_cancel_order&notice' ) );
}
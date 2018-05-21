<div class="wrap">
	<h1><?php esc_html_e( 'Auto Cancel Order Setting', 'aco' ); ?></h1><br />
	<div id="aoe-setting">
		<form action="" method="post">
			<div class="form-section">
				<h4 class="form-section-title"><?php esc_html_e( 'General Setting', 'aoe' ); ?></h4>
				<div class="input-row">
					<label for="input-interval"><?php esc_html_e( 'Canceled Order Threshold', 'aco' ); ?> :</label>
					<div class="input-field">
						<input type="number" value="<?php echo esc_html( aco_get_option( 'bacs_canceled_threshold_value' ) ); ?>" name="bacs_canceled_threshold_value" id="input_interval" min="1" style="width: 70px;display: inline-block;vertical-align: top;">
						<select name="bacs_canceled_threshold_unit" style="display: inline-block;vertical-align: top;">
							<option <?php echo 'minute' === aco_get_option( 'bacs_canceled_threshold_unit' ) ? 'selected' : ''; ?> value="minute"><?php esc_html_e( 'Minute(s)', 'aoe' ); ?></option>
							<option <?php echo 'hour' === aco_get_option( 'bacs_canceled_threshold_unit' ) ? 'selected' : ''; ?> value="hour"><?php esc_html_e( 'Hour(s)', 'aoe' ); ?></option>
							<option <?php echo 'day' === aco_get_option( 'bacs_canceled_threshold_unit' ) ? 'selected' : ''; ?> value="day"><?php esc_html_e( 'Day(s)', 'aoe' ); ?></option>
							<option <?php echo 'week' === aco_get_option( 'bacs_canceled_threshold_unit' ) ? 'selected' : ''; ?> value="week"><?php esc_html_e( 'Week(s)', 'aoe' ); ?></option>
						</select>
					</div>
					<div class="helper">
						<?php esc_html_e( 'Threshold time after the abandoned order date which categorized as an abandoned order. Only for orders with BACS payment method.', 'aco' ); ?>
					</div>
				</div>
				
			</div>
			
			<?php wp_nonce_field( 'save_setting', 'aco_do' ); ?>
			<input type="submit" value="<?php esc_attr_e( 'Save Setting', 'aco' ); ?>" class="button button-primary">
		</form>
	</div>
</div>

<?php
/*
 * Add New Section To WooCommerce Settings Tab
 */

// Create new Section
add_filter( 'woocommerce_get_sections_general', 'famcare_zatca_add_section' );
function famcare_zatca_add_section( $sections ) {
	$sections['famcare-zatca'] = __( 'ZATCA', 'famcare-zatca' );
	return $sections;
}

// Create settings tab
add_filter( 'woocommerce_get_settings_general', 'famcare_zatca_settings', 10, 2 );
function famcare_zatca_settings( $settings, $current_section ) {
	/**
	 * Check the current section is what we want
	 **/
	if ( $current_section == 'famcare-zatca' ) {
		$seller_settings = array();

		// Add Title to the Settings
		$seller_settings[] = array(
			'name' => __( 'Seller Information', 'famcare-zatca' ),
			'type' => 'title', 'desc' => __( 'The following options are used to configure QR code data.', 'famcare-zatca' ),
			'id' => 'fc_zatca_sellerInfo'
		);

		$seller_settings[] = array(
			'name'     => __( 'Seller Name', 'famcare-zatca' ),
			'id'       => 'fc_zatca_sellerName',
			'type'     => 'text'
		);

		$seller_settings[] = array(
			'name'     => __( 'Tax Number', 'famcare-zatca' ),
			'id'       => 'fc_zatca_taxNumber',
			'type'     => 'number'
		);

		$seller_settings[] = array(
			'type' => 'sectionend',
			'id' => 'fc_zatca_sellerInfo'
		);

		return $seller_settings;
	} else {
		return $settings;
	}
}
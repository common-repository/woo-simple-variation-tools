<?php
/**
 * Plugin Name: WooCommerce Simple Variation Tools
 * Plugin URI: http://wpmike.com
 * Description: Change the admin variations per page and front end ajax variation threshold.
 * Version: 1.0
 * Author: Michael Moore
 * Author URI: http://wpmike.com
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

/**
 * Create the section beneath the products tab
 **/
add_filter( 'woocommerce_get_sections_products', 'wpmike_simple_variation_tools' );
function wpmike_simple_variation_tools( $sections ) {
	
	$sections['woocommerce_simple_variation_tools'] = __( 'Simple Variation Tools', 'woocommerce-simple-variation-tools' );
	return $sections;
	
}

/**
 * Add settings
 */

add_filter( 'woocommerce_get_settings_products', 'woocommerce_simple_variation_tools_settings', 10, 2 );
function woocommerce_simple_variation_tools_settings( $settings, $current_section ) {
	
	/**
	 * Check the current section is what we want
	 **/
	if ( $current_section == 'woocommerce_simple_variation_tools' ) {
		$settings_woocommerce_simple_variation_tools = array();
		
		// Add Title
		$settings_woocommerce_simple_variation_tools[] = array( 'name' => __( 'Simple Variation Tools', 'woocommerce-simple-variation-tools' ), 'type' => 'title', 'id' => 'variations_count' );
		
		// Add Variation Count Option
		$settings_woocommerce_simple_variation_tools[] = array(
			'name'     => __( 'Variations Per Page', 'woocommerce-simple-variation-tools' ),
			'desc_tip' => __( 'This will change the number of variations per page in the variations panel', 'woocommerce-simple-variation-tools' ),
			'id'       => 'variations_count_value',
			'type'     => 'number',
			'css'      => 'width:80px;',
			'desc'     => __( '', 'woocommerce-simple-variation-tools' ),
		);

		$settings_woocommerce_simple_variation_tools[] = array(
			'name'     => __( 'Ajax Variation Threshold', 'woocommerce-simple-variation-tools' ),
			'desc_tip' => __( 'This will change the threshold at which variations will loaded be by ajax on the frontend.', 'woocommerce-simple-variation-tools' ),
			'id'       => 'ajax_variation_threshold_value',
			'type'     => 'number',
			'css'      => 'width:80px;',
			'desc'     => __( '', 'woocommerce-simple-variation-tools' ),
		);
		
		$settings_woocommerce_simple_variation_tools[] = array( 'type' => 'sectionend', 'id' => 'variations_count_section' );
		return $settings_woocommerce_simple_variation_tools;
	
	/**
	 * If not, return the standard settings
	 **/
	} else {
		return $settings;
	}
}

//change variations per page
function wpmike_wc_admin_variations_per_page( $qty ) {
	
	$value = get_option('variations_count_value');

	if ( $value > 0 ){
		return $value;
	} else {
		return 10;
	}
}

add_filter( 'woocommerce_admin_meta_boxes_variations_per_page', 'wpmike_wc_admin_variations_per_page' );

//Set ajax variation threshold
function wpmike_wc_ajax_variation_threshold( $qty, $product ) {
	$value = get_option('ajax_variation_threshold_value');

	if ( $value > 0 ){
		return $value;
	} else {
		return 20;
	}
}

add_filter( 'woocommerce_ajax_variation_threshold', 'wpmike_wc_ajax_variation_threshold', 10, 2 );
}
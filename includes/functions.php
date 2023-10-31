<?php
/**
 * Create QR code after order payment completed
 * @param int $order_id
 * @return void
 */
function famcare_generate_qr_code( int $order_id ) {
	// Do nothing if its already created.
	$_qr_code_image_id = get_post_meta($order_id,'_qr_code_image_id',true);
	if($_qr_code_image_id != '')
		return;

	// Do nothing if image already exist.
	$_qr_code_image_url = wp_get_attachment_url($_qr_code_image_id);
	if($_qr_code_image_url)
		return;

	// Load TLV QR generator
	require(untrailingslashit(dirname(__FILE__)) . '/famcare_TLV.php');

	/*
	 * Get Order info.
	 */
	$order = wc_get_order($order_id);
	$order_total = $order->get_total();
	$order_tax = $order->get_total_tax();
	$order_date = $order->get_date_created()->date('Y-m-d\TH:i:s');

	(new Famcare_TLV_QR)->generateTLVImage($order_id,$order_date,$order_total,$order_tax);
}
add_action( 'woocommerce_order_status_processing', 'famcare_generate_qr_code', 10, 1 );

/**
 * Get QR code image link
 * @param int $order_id
 * @return false|string
 */
function famcare_get_zatca_qr_code( int $order_id ){
	$_qr_code_image_id = get_post_meta($order_id,'_qr_code_image_id',true);
	$_qr_code_image_url = wp_get_attachment_url($_qr_code_image_id);

    if($_qr_code_image_url && $_qr_code_image_url != '')
        return $_qr_code_image_url;
    else
        return false;
}

/**
 * Add QR Code to PDF invoice
 * Print Invoice & Delivery Notes for WooCommerce Plugin
 * https://wordpress.org/plugins/woocommerce-delivery-notes/
 * @param WC_Order $order
 * @return void
 */
function famcare_wcdn_after_branding( WC_Order $order ){
	$_qr_code_image_url = famcare_get_zatca_qr_code($order->get_id());
	if($_qr_code_image_url){
		?>
		<div class="invoice-QR">
			<img src="<?php echo $_qr_code_image_url;?>" alt="QR Code" width="100px">
		</div>
		<?php
	}
}
add_action( 'wcdn_after_branding', 'famcare_wcdn_after_branding', 10, 1 );

/**
 * Add QR Code to WooCommerce Rest API order object
 * @param WP_REST_Response $response
 * @return void
 */
function famcare_rest_prepare_shop_order_object( WP_REST_Response $response ){
	//TLV QR code.
	$_qr_code_image_url = famcare_get_zatca_qr_code($response->data['id']);
	if($_qr_code_image_url){
		$response->data['qr_code'] = $_qr_code_image_url;
		return $response;
	} else
		$response->data['qr_code'] = wc_placeholder_img_src();
		return $response;
}
add_filter( 'woocommerce_rest_prepare_shop_order_object', 'famcare_rest_prepare_shop_order_object', 10, 1 );

/**
 * Add qr code to user dashboard order view
 * @param int $order_id
 * @return void
 */
function famcare_add_qr_to_user_dashboard( int $order_id ){
	$_qr_code_image_url = famcare_get_zatca_qr_code($order_id);
	if($_qr_code_image_url){
		?>
        <div style="text-align: center;">
            <img src="<?php echo $_qr_code_image_url;?>" alt="QR Code" style="max-width: 200px;">
        </div>
        <?php
	}
}
add_action('woocommerce_view_order', 'famcare_add_qr_to_user_dashboard', 1);
<?php
require(untrailingslashit(dirname(__FILE__)) . '/salla_zatca/vendor/autoload.php');

use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;

class Famcare_TLV_QR
{
	public function __construct()
	{
	}

	public function generateTLVImage($OrderID,$OrderDate, $OrderTotalAmount, $OrderTaxAmount){
		$QR_Image = GenerateQrCode::fromArray([
			new Seller(get_option( 'fc_zatca_sellerName' )), // seller name
			new TaxNumber(get_option( 'fc_zatca_taxNumber' )), // seller tax number
			new InvoiceDate($OrderDate), // invoice date as Zulu ISO8601 @see https://en.wikipedia.org/wiki/ISO_8601
			new InvoiceTotalAmount($OrderTotalAmount), // invoice total amount
			new InvoiceTaxAmount($OrderTaxAmount) // invoice tax amount
			// TODO :: Support others tags
		])->render(['imageTransparent'    => false]);

		return self::save_image($QR_Image,$OrderID);
	}

	/**
	 * Save the image on the server.
	 */
	function save_image( $base64_img, $OrderID ) {
		// Upload dir.
		$upload_dir  = wp_upload_dir();
		$upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;

		$img             = str_replace( 'data:image/png;base64,', '', $base64_img );
		$img             = str_replace( ' ', '+', $img );
		$decoded         = base64_decode( $img );
		$filename        = $OrderID . '.png';
		$file_type       = 'image/png';
		$hashed_filename = md5( $filename . microtime() ) . '_' . $filename;

		// Save the image in the uploads directory.
		$upload_file = file_put_contents( $upload_path . $hashed_filename, $decoded );

		$attachment = array(
			'post_mime_type' => $file_type,
			'post_title'     => 'Order #'.$OrderID.' QR code.' ,
			'post_status'    => 'inherit',
			'guid'           => $upload_dir['url'] . '/' . basename( $hashed_filename )
		);
		$attach_id = wp_insert_attachment( $attachment, $upload_dir['path'] . '/' . $hashed_filename, $OrderID);

		// Save QR image id
		update_post_meta($OrderID,'_qr_code_image_id',$attach_id);
		return wp_get_attachment_url($attach_id);
	}
}
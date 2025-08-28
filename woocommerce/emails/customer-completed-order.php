<?php
/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 * 
 * https://gjafakort.kringlan.is/wp-content/uploads/2023/09/Kringlan-completed-order-email-header.jpg
 * 
 */

do_action( 'woocommerce_email_header', $email_heading, $email ); 
?>

<?php /* translators: %s: Customer first name */ ?>
<h2>Hæ, <?php echo $order->get_billing_first_name();?></h2>
<p>Pöntunin þín hjá Kringlunni hefur verið afgreidd.</p>

<?php

/*
* @hooked WC_Emails::order_details() Shows the order details table.
* @hooked WC_Structured_Data::generate_order_data() Generates structured data.
* @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
* @since 2.5.0
*/
// do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );
?>
<!-- Order Details -->



	<!-- <style-inline>
		@font-face {
			font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;
			src: url('https://gjafakort.kringlan.is/wp-content/uploads/2023/09/DINNextLTPro-Condensed.eot');
			src: url('https://gjafakort.kringlan.is/wp-content/uploads/2023/09/DINNextLTPro-Condensed.eot?#iefix') format('embedded-opentype'),
				url('https://gjafakort.kringlan.is/wp-content/uploads/2023/09/DINNextLTPro-Condensed.woff2') format('woff2'),
				url('https://gjafakort.kringlan.is/wp-content/uploads/2023/09/DINNextLTPro-Condensed.woff') format('woff'),
				url('https://gjafakort.kringlan.is/wp-content/uploads/2023/09/DINNextLTPro-Condensed.ttf') format('truetype'),
				url('https://gjafakort.kringlan.is/wp-content/uploads/2023/09/DINNextLTPro-Condensed.svg#DINNextLTPro-Condensed') format('svg');
			font-weight: normal;
			font-style: normal;
			font-display: swap;
		}
	</style-inline> -->

<div style="margin-bottom: 40px;">
	<table class="td" cellspacing="0" cellpadding="6" style="border:0;width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; " border="0">
		<tbody style="border:0;">
			<tr style="border:0;">
				<td style="border:0;">
					<h2>
						<?php if ( $sent_to_admin ) {
							$before = '<a class="link" href="' . esc_url( $order->get_edit_order_url() ) . '">';
							$after  = '</a>';
						} else {
							$before = '';
							$after  = '';
						}
						/* translators: %s: Order ID. */
						echo wp_kses_post( $before . sprintf( __( '[Bókun #%s]', 'woocommerce' ) . $after . ' (<time datetime="%s">%s</time>)', $order->get_order_number(), $order->get_date_created()->format('d. F Y'), wc_format_datetime( $order->get_date_created() ) ) ); ?>
					</h2>
				</td>
				
			</tr>
		</tbody>
	</table>
	<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: 'Fuggles', cursive;border:0;">
		<thead style="background: #f2f3f4;border:0;">
			<tr style="border:0;">
				<th style="border:0; text-align:left"><?php esc_html_e( 'Vara', 'woocommerce' ); ?></th>
				<th style="border:0; text-align:center"><?php esc_html_e( 'Magn', 'woocommerce' ); ?></th>
				<th style="border:0; text-align:right"><?php esc_html_e( 'Verð', 'woocommerce' ); ?></th>
			</tr>
		</thead>
		<tbody style="border:0;background: #ffffff;background-color:#ffffff;">
		<?php 
			// Get and Loop Over Order Items
			foreach ( $order->get_items() as $item_id => $item ) {

				// $product_id = $item->get_product_id();
				// $variation_id = $item->get_variation_id();
				// $product = $item->get_product(); // see link above to get $product info
				$product_name = $item->get_name();
				$quantity = $item->get_quantity();
				$total = $item->get_total();

				$dagsetning=wc_get_order_item_meta($item_id, 'Dagsetning', true);
				$time =wc_get_order_item_meta($item_id, 'Tími', true);
				$nafn =wc_get_order_item_meta($item_id, 'Nafn viðtakanda', true);
				$email=wc_get_order_item_meta($item_id, 'Netfang viðtakanda', true);
				$phone=wc_get_order_item_meta($item_id, 'Símanúmer', true);
				$sName=wc_get_order_item_meta($item_id, 'Nafn sendanda', true);
				$sms  =wc_get_order_item_meta($item_id, 'Message', true);
				$url  =''.site_url().'?gift-card-pdf=true&gcpdf='.base64_encode($item_id).'';

				?>
				<tr style="border:0;">
					<td class="td" style="border:0; text-align:left;background: #ffffff;background-color:#ffffff;">
						<p style="margin: 0;"><b><?php echo $product_name; ?></b></p>
						<p style="margin: 0;"><b>Dagsetning: </b><?php echo $dagsetning; ?></p>
						<p style="margin: 0;"><b>Tími: </b><?php echo $time; ?></p>
						<p style="margin: 0;"><b>Nafn viðtakanda: </b><?php echo $nafn; ?></p>
						<p style="margin: 0;"><b>Netfang viðtakanda: </b><?php echo $email; ?></p>
						<p style="margin: 0;"><b>Símanúmer: </b><?php echo $phone; ?></p>
						<p style="margin: 0;background: #ffffff;background-color:#ffffff;"><b>Nafn sendanda: </b><?php echo $sName; ?></p>
						<p style="margin: 0;background: #ffffff;background-color:#ffffff;"><b>Message: </b><?php echo $sms; ?></p>
						<p style="margin: 0;background: #ffffff;background-color:#ffffff;margin-top:15px;">
							<a href="<?php echo $url; ?>" target="_blank" >
								<img src="https://gjafakort.kringlan.is/wp-content/uploads/2023/09/Button-150.png" alt="Sækja gjafakort">
							</a>
						</p>
					</td>
					<td class="td" style="border:0; text-align:center;background: #ffffff;background-color:#ffffff;"><b><?php echo $quantity; ?></b></td>
					<td class="td" style="border:0; text-align:right;background: #ffffff;background-color:#ffffff;"><b><?php echo $total; ?> kr.</b></td>
				</tr>
				<?php

			}
		?>
			
		</tbody>
		<tfoot style="background: #f2f3f4;background-color:#f2f3f4;">
			<?php
			$item_totals = $order->get_order_item_totals();

			if ( $item_totals ) {
				$i = 0;
				foreach ( $item_totals as $total ) {
					
					if($i != 0 ){
					?>
					<tr style="border:0;background: #f2f3f4;background-color:#f2f3f4;" bg-color="#f2f3f4">
						<th class="td" scope="row" colspan="2" style="border:0; text-align:left;background: #f2f3f4;background-color:#f2f3f4;">
							<?php echo wp_kses_post( $total['label'] ); ?>
						</th>
						<th class="td" style="border:0; text-align:right;background: #f2f3f4;background-color:#f2f3f4;"><?php echo wp_kses_post( $total['value'] ); ?></th>
					</tr>
					<?php

					}
					$i++;
				}
			} ?>
		</tfoot>
	</table>
	<h3><b style=" font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">Kennitala:</b> <?php 
		$kt =  get_post_meta( $order->get_id(), 'billing_kennitala', true ); 
		echo $kt; ?></h3>

</div>
<!-- End Order Details -->
<?php

	/*
	* @hooked WC_Emails::order_meta() Shows order meta data.
	*/

	// do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

	/*
	* @hooked WC_Emails::customer_details() Shows customer details
	* @hooked WC_Emails::email_address() Shows email address
	*/
	// do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

?>
<div style=" font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; margin-bottom: 40px;">
	<h2 style=" font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;"> Heimilisfang greiðanda </h2>
	
	<p style="margin: 0;"><?php echo $order->get_billing_first_name();?></p>
	<p style="margin: 0;"><?php echo $order->get_billing_company(); ?></p>
	<p style="margin: 0;"><?php echo $order->get_billing_country(); ?></p>
	<p style="margin: 0;"><?php echo $order->get_billing_city(); ?></p>
	<p style="margin: 0;"><?php echo $order->get_billing_state(); ?></p>
	<p style="margin: 0;"><?php echo $order->get_billing_postcode(); ?></p>
	<p style="margin: 0;"><?php echo $order->get_billing_phone(); ?></p>
	<p style="margin: 0;"><?php echo $order->get_billing_email(); ?></p>
</div>
<?php 
	/**
	* Show user-defined additional content - this is set in each email's settings.
	*/
	if ( $additional_content ) {
		echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
	}

	/*
	* @hooked WC_Emails::email_footer() Output the email footer
	*/

	 do_action( 'woocommerce_email_footer', $email );
?>
																		





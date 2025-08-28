<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
$product_id = get_the_ID();
$is_gift=get_post_meta($product_id,'_gift_card',true);
if($is_gift=='yes'){
	
?>

	<div class="top-link-area">
		<a href="<?php echo get_permalink(6340)?>" class="<?php echo ($product_id===6340?'active':'');?>">Fjöldakaup</a>
		<a href="<?php echo get_permalink(6362)?>" class="<?php echo ($product_id===6362?'active':'');?>">Fá gjafakort sent með hefðbundnum pósti</a>
</div>
<div id="accordion">
	<h3 class="product-title-gift" id="productHeader-<?php the_ID(); ?>">Gjafakort nr. <span class="countn">1</span> - Tækifæriskort - <span class="img_label">ALMENNT</span></h3>
	<div  id="productGift-<?php the_ID(); ?>" <?php wc_product_class( ' product-single-gift ', $product ); ?>>

		<?php
		/**
		 * Hook: woocommerce_before_single_product_summary.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
		?>

		<div class="summary entry-summary">
			<?php
			/**
			 * Hook: woocommerce_single_product_summary.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			do_action( 'woocommerce_single_product_summary' );
			?>
		</div>

		<?php
		/**
		 * Hook: woocommerce_after_single_product_summary.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
		?>
	</div>
</div>
<?php
	if($product_id!=6340){
?>
<div style="margin-top:50px;width:100%;float:left;"></div>
<div class="formButton form_row" style="margin-top:20px;width:100%;">

	<div class="gift-cart-btn">
		<div class="but-wrap">
			<input type="number" id="qtyGiftCard" style="margin-left: 10px;width: 60px;" value="1" name="qtyGiftCard"/> 
			<button id="submitGiftCardFormBtn" class="submitGiftCardFormBtn" >KAUPA RAFRÆNT</button>
			<a class="btn aUpdateCart" style="display:none" href="<?=site_url()?>/cart/">Update Cart</a>
			<!--<button id="cloneProduct">Add More Card</button>-->
		</div>
	</div>
	<div class="col_6" id="errorText">
		
	</div>

</div>

<?php
						 }
?>


<style>
	.single_add_to_cart_button.button.alt {
		display: none;
	}
	/*multi giftcard*/
	.ui-accordion .ui-accordion-header {
		display: block;
		cursor: pointer;
		position: relative;
		margin: 2px 0 0 0;
		padding: 0.5em 0.5em 0.5em 0.7em;
		font-size: 100%;
	}	
	.woocommerce div.product form.cart .button.single_add_to_cart_button{
		display: none;
	}
	#submitGiftCardFormBtn{
		background:#000;
		border-radius: 0px;
	}
	.ui-state-active{
		background: #000;
	}
	.woocommerce #qtyGiftCard{
		margin-left: 10px;
		width: 40px;
	}
	.pform_area div span.giftcardformError{
		display: block;
		position: relative;
		font-size: 11px;
		color: red;
	}
	.aUpdateCart{
		background: black;
		color: white;
		padding: 5px;
		font-weight: bold;
	}
	.errorSpan{
		display: block;
		color: red;
		background: #EEE;
		padding: 5px;
		margin: 5px;
	}	
	.woocommerce div.product {
		overflow: hidden;
	}
	#accordion div.product-single-gift{
		height:unset!important;
		overflow:unset!important;
		float: left;
	}
	@media only screen and (max-width: 600px) {
		#accordion div.product-single-gift {
			padding: 5px;
			width: 100%;
		}
	}
	.box_content .min_price,.gift-price{
		max-width: 100%;
	}
</style>	

<script language="javascript">

	jQuery(document).on("change","label.send_mail_sms",function(){
		let parent = jQuery(this).parent().parent();
		let value = jQuery(parent).find("input.send_mail_to_recipient:checked").val();
		//console.log(value);
		if(value == 1){ // email required
			jQuery(parent).find("span.phone_required").addClass("hidden");
			jQuery(parent).find("span.email_required").removeClass("hidden");
			jQuery(parent).find('.gift_card_phone_span').html('');
		}else if(value == 2){ // phone required
			jQuery(parent).find("span.phone_required").removeClass("hidden");
			jQuery(parent).find("span.email_required").addClass("hidden");
			jQuery(parent).find('.gift_card_recipient_email_span').html('');
		}else{
			jQuery(parent).find("span.phone_required").removeClass("hidden");
			jQuery(parent).find("span.email_required").removeClass("hidden");
		}
	});
	jQuery(document).ready(function(){

		function validateEmail($email) {
			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
			return emailReg.test( $email );
		}

		function removeLastWord(str) {
			/*
			const lastIndexOfSpace = str.lastIndexOf(' ');
			if (lastIndexOfSpace === -1) {
				return str;
			}
			return str.substring(0, lastIndexOfSpace);
			*/
			var words = str.split(' ');
			words.splice(-2, 2);
			var result = words.join(' ');
			return result;
		}

		jQuery( function() {
			jQuery( "#accordion" ).accordion();
		} );

		jQuery('#cloneProduct').click(function(){

			var $divHeader = jQuery('#accordion h3[id^="productHeader-"]:last');
			var $div = jQuery('div[id^="productGift-"]:last');
			var numH3 = parseInt( $divHeader.prop("id").match(/\d+/g), 10 ) +1;
			var $klonH3 = $divHeader.clone().prop('id', 'productHeader-'+numH3 );
			$div.after( $klonH3.html($divHeader.html()) );

			var num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;
			var $klon = $div.clone().prop('id', 'productGift-'+num );
			$klonH3.after( $klon.html($div.html()) );
			jQuery( "#accordion" ).accordion( "refresh" );

		});

		jQuery('#qtyGiftCard').change(function(){

			var qtyGiftCard = jQuery(this).val();
			var countProductSingleGift = jQuery('.product-single-gift').length;
			
			if (qtyGiftCard < 1) {
				jQuery(this).val(1).change();
				// console.log('not input value is negative');
			}

			if(qtyGiftCard != countProductSingleGift && qtyGiftCard > 0){
				for(var i=0; i<countProductSingleGift-1;i++){
					
					var countProductSingleGiftTemp = jQuery('.product-single-gift').length;
					if(countProductSingleGiftTemp==1){
						break;
					}
					var $divHeader = jQuery('#accordion h3[id^="productHeader-"]:last');
					var $div = jQuery('div[id^="productGift-"]:last');
					$divHeader.remove();
					$div.remove();

				}

				for(var i=0; i<qtyGiftCard-1;i++){

					var $divHeader = jQuery('#accordion h3[id^="productHeader-"]:last');

					var $div = jQuery('div[id^="productGift-"]:last');

					var numH3 = parseInt( $divHeader.prop("id").match(/\d+/g), 10 ) +1;

					var $klonH3 = $divHeader.clone().prop('id', 'productHeader-'+numH3 );

					$div.after( $klonH3.html(`Gjafakort nr. <span class="countn">${i+2}</span> - Tækifæriskor - <span class="img_label">ALMENNT</span>`));

					$klonH3.removeClass('ui-accordion-header-active ui-state-active');

					

					var num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;
					var $klon = $div.clone().prop('id', 'productGift-'+num );
					
					
					var item_html = $klon.html($div.html());
					
                    jQuery(item_html).find("input.send_mail_to_recipient").each(function(){
                        jQuery(this).attr("name","send_mail_to_recipient_"+(i+1)+"");
                    });
                    jQuery(item_html).find("input.send_mail_to_recipient[value=3]").prop("checked",true);
					
					$klonH3.after( item_html );

				}
			}
			
			jQuery( "#accordion" ).accordion( "refresh" );

		});

		jQuery(".submitGiftCardFormBtn").click( function(e) {
			e.preventDefault(); 

			var product_id = [];	
			var gift_card_date = [];
			var gift_card_time_hour  = [];
			var gift_card_time_minute  =  [];
			var gift_card_recipient_name  =  [];
			var gift_card_recipient_email  = [];
			var gift_card_phone  = [];
			var gift_card_custome_message  = [];
			var gift_card_sender_name  =  [];
			var send_mail_to_recipient  = [];

            var gift_card_image  = [];
			var gift_card_amount = [];
			
			var i = 0;
			var formError = 0;
			jQuery(".product-single-gift").each(function() {

				var myID =  jQuery(this).attr('id').match(/\d+/g);

				product_id[i]  =  jQuery(this).find('[name="product_id"]').val();
				gift_card_date[i]  =  jQuery(this).find('[name="gift_card_date"]').val();
				gift_card_time_hour[i]  =  jQuery(this).find('[name="gift_card_time_hour"] option:selected').val();
				gift_card_time_minute[i]  =  jQuery(this).find('[name="gift_card_time_minute"] option:selected').val();
				gift_card_recipient_name[i]  =  jQuery(this).find('[name="gift_card_recipient_name"] ').val();
				gift_card_recipient_email[i]  =  jQuery(this).find('[name="gift_card_recipient_email"]').val();
				gift_card_phone[i]  =  jQuery(this).find('[name="gift_card_phone"]').val();
				gift_card_custome_message[i]  =  jQuery(this).find('[name="gift_card_custome_message"]').val();
				gift_card_sender_name[i]  =  jQuery(this).find('[name="gift_card_sender_name"]').val();
				send_mail_to_recipient[i]  =  jQuery(this).find('input.send_mail_to_recipient:checked').val();
				let amount = jQuery(this).find('[name="gift_card_amount"]').val();
                gift_card_amount[i]  =  amount;
				gift_card_image[i]  =  jQuery(this).find('[name="gift_card_image"]').val();
				
				if(parseInt(amount)>300000){

					jQuery(this).find('[name="custom_price"]').css('border-color','red');
					jQuery(this).find('[name="custom_price"]').focus();	
					jQuery(this).find('.gift-card-amount-error').html('Upphæð gjafakorts má ekki vera hærri en 300.000 kr.');
					formError++;
					jQuery( "#productHeader-"+myID ).trigger( "click" );
				}else{
					jQuery(this).find('[name="custom_price"]').css('border','0px');
					jQuery(this).find('.gift-card-amount-error').html('');
				}

				if(gift_card_recipient_name[i].trim()=='' || gift_card_recipient_name[i]==null){
					jQuery(this).find('[name="gift_card_recipient_name"]').css('border-color','red');
					jQuery(this).find('[name="gift_card_recipient_name"]').focus();	
					jQuery(this).find('.gift_card_recipient_name_span').html('Nafn viðtakanda er ekki rétt.');
					formError++;
					jQuery( "#productHeader-"+myID ).trigger( "click" );
					
				}
				else{
					jQuery(this).find('[name="gift_card_recipient_name"]').css('border','0px');
					jQuery(this).find('.gift_card_recipient_name_span').html('');
				}

				if(send_mail_to_recipient[i]==1 || send_mail_to_recipient[i]==3){

					if(gift_card_recipient_email[i].trim()=='' || gift_card_recipient_email[i]==null || !validateEmail(gift_card_recipient_email[i])){
						jQuery(this).find('[name="gift_card_recipient_email"]').css('border-color','red');
						jQuery(this).find('[name="gift_card_recipient_email"]').focus();	
						jQuery(this).find('.gift_card_recipient_email_span').html('Netfang viðtakanda er ekki rétt.');
						formError++;
						jQuery( "#productHeader-"+myID ).trigger( "click" );
						jQuery( "#productGift-"+myID ).find("span.email_required").removeClass("hidden");
					}
					else{
						jQuery(this).find('[name="gift_card_recipient_email"]').css('border','0px');
						jQuery(this).find('.gift_card_recipient_email_span').html('');
						
					}
				}else{
					jQuery(this).find('.gift_card_recipient_email_span').html('');
					jQuery( "#productGift-"+myID ).find("span.email_required").addClass("hidden");
				}

				if(send_mail_to_recipient[i]==2 || send_mail_to_recipient[i]==3){
					if(gift_card_phone[i].trim()=='' || gift_card_phone[i]==null || !(jQuery.isNumeric(gift_card_phone[i])) || gift_card_phone[i].length!=7){
						jQuery(this).find('[name="gift_card_phone"]').css('border-color','red');
						jQuery(this).find('[name="gift_card_phone"]').focus();	
						jQuery(this).find('.gift_card_phone_span').html('Símanúmer viðtakanda er ekki rétt');
						formError++;
						jQuery( "#productGift-"+myID ).find("span.phone_required").removeClass("hidden");
						jQuery( "#productHeader-"+myID ).trigger( "click" );
					}
					else{
						jQuery(this).find('[name="gift_card_phone"]').css('border','0px');
						jQuery(this).find('.gift_card_phone_span').html('');
					}
				}else{
					jQuery(this).find('.gift_card_phone_span').html('');
					jQuery( "#productGift-"+myID ).find("span.phone_required").addClass("hidden");
				}

				if(gift_card_sender_name[i].trim()=='' || gift_card_sender_name[i]==null){
					jQuery(this).find('[name="gift_card_sender_name"]').css('border-color','red');
					jQuery(this).find('[name="gift_card_sender_name"]').focus();	
					jQuery(this).find('.gift_card_sender_name_span').html('Nafn sendanda er ekki rétt.');
					formError++;
					jQuery( "#productHeader-"+myID ).trigger( "click" );
				}
				else{
					jQuery(this).find('[name="gift_card_sender_name"]').css('border','0px');
					jQuery(this).find('.gift_card_sender_name_span').html('');
				}
		
				i++;

				if(formError>0){
					return false;
				}
			});

			if(formError>0){
				return false;
			}
			else{
				jQuery("#submitGiftCardFormBtn").html('Í vinnslu').prop("disabled",true).css('background-color','gray');
				jQuery.ajax({
					type : "post",
					dataType : "json",
					url : myAjax.ajaxurl,
					data : {
						action: "gift_card_add_to_cart", 
						product_id : product_id,
						gift_card_date : gift_card_date,
						gift_card_time_hour : gift_card_time_hour,
						gift_card_time_minute : gift_card_time_minute,
						gift_card_recipient_name : gift_card_recipient_name,
						gift_card_recipient_email : gift_card_recipient_email,
						gift_card_phone : gift_card_phone,
						gift_card_custome_message : gift_card_custome_message,
						gift_card_sender_name : gift_card_sender_name,
						send_mail_to_recipient : send_mail_to_recipient,
                        gift_card_amount: gift_card_amount,
						gift_card_image: gift_card_image
					},
					success: function(response) {
						//console.log(response);
						if(response.type == "success") {
							jQuery("#submitGiftCardFormBtn").html('Vara bætt við í körfu').prop("disabled",true).css('background-color','gray');
							//jQuery(".aUpdateCart").show();
							window.location.replace(WPURLS.siteurl+"/checkout/");
						}
						else {
							
							jQuery.each( response.errorMessages, function( key, value ) {
								//console.log(value);
								jQuery('#errorText').append('<span class="errorSpan">'+value.product_id+'</span><br/>');
							});
							//alert("Failed to add gift card to cart.");
						}
					}
				})
			}
		})
	});
	
	// bulk card
	function bulk_card_add_more_card(){
		let html=`<div class="single-card-details">
								<input type="text" name="card_price[]" placeholder="Upphæð korta">
								<input type="text" name="card_no[]" placeholder="Fjöldi korta">
								<button type="button" onclick="bulk_card_remove_more_card(this)">
									-
								</button>
							</div>`;
		jQuery(".add-more-cards-area").append(html);
	}
	function bulk_card_remove_more_card(data){
		jQuery(data).parent().remove();
	}
	function bulk_card_add_more_receiver(){
	let html=`<div class="single-card-receiver-details">
								<input type="text" name="receiver_name[]" placeholder="Nafn">
								<input type="text" name="receiver_phone[]" placeholder="Símanúmer">
								<button type="button" onclick="bulk_card_remove_more_receiver(this)">
									-
								</button>
							</div>`;
		jQuery(".add-more-cards-receiver-area").append(html);
	}
	function bulk_card_remove_more_receiver(data){
		jQuery(data).parent().remove();
	}
</script>
<?php
}else{

?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

<?php
/**
 * Hook: woocommerce_before_single_product_summary.
 *
 * @hooked woocommerce_show_product_sale_flash - 10
 * @hooked woocommerce_show_product_images - 20
 */
do_action( 'woocommerce_before_single_product_summary' );
?>

<div class="summary entry-summary">
    <?php
    /**
     * Hook: woocommerce_single_product_summary.
     *
     * @hooked woocommerce_template_single_title - 5
     * @hooked woocommerce_template_single_rating - 10
     * @hooked woocommerce_template_single_price - 10
     * @hooked woocommerce_template_single_excerpt - 20
     * @hooked woocommerce_template_single_add_to_cart - 30
     * @hooked woocommerce_template_single_meta - 40
     * @hooked woocommerce_template_single_sharing - 50
     * @hooked WC_Structured_Data::generate_product_data() - 60
     */
    do_action( 'woocommerce_single_product_summary' );
    ?>
</div>

<?php
/**
 * Hook: woocommerce_after_single_product_summary.
 *
 * @hooked woocommerce_output_product_data_tabs - 10
 * @hooked woocommerce_upsell_display - 15
 * @hooked woocommerce_output_related_products - 20
 */
//do_action( 'woocommerce_after_single_product_summary' );
?>
</div>

<?php

}

do_action( 'woocommerce_after_single_product' );

<?php
/**
 * Kringlan Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Kringlan Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_KRINGLAN_CHILD_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'kringlan-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_KRINGLAN_CHILD_VERSION, 'all' );
	wp_enqueue_style( 'jquery-uri-accordion-css', '//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css', array('kringlan-child-theme-css'), CHILD_THEME_KRINGLAN_CHILD_VERSION, 'all' );
	wp_enqueue_script( 'jquery-ui-core');
	wp_enqueue_script('jquery-ui-accordion');

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

/*
	function remove_cheque_option( $available_gateways ) {
		
		if(!current_user_can('administrator')){
			if ( isset( $available_gateways['stripe'] )){
				unset( $available_gateways['stripe'] );
			}
		}

		return $available_gateways;
	}   
	add_filter( 'woocommerce_available_payment_gateways', 'remove_cheque_option' );
*/

add_action('init',function(){
	if(isset($_GET["res"])){
		if($_GET["res"]==true){
			$url=trim($_GET['url']);
			//print_r($url);
			if(!empty($url))$url=base64_decode($url);
			if($url){
				//echo $url;
				//wp_safe_redirect($url);
				header('Location:'.$url);
				exit();
			}
		}
	}
});

$cferror=[];
// add gjafakort-from Short code
add_shortcode('gjafakort-from','gjafakort_from_fun');
function gjafakort_from_fun($jekono){ 
	$result = shortcode_atts(array( 
	'title' =>'',
	),$jekono);
	extract($result);
	ob_start();

	global $cferror;

	$name='';
	if(isset($_POST["card_name"])) $name=$_POST["card_name"];
	$phone='';
	if(isset($_POST["card_phone"])) $phone=$_POST["card_phone"];
	$email='';
	if(isset($_POST["card_email"])) $email=$_POST["card_email"];
	$card='';
	if(isset($_POST["cardnumber"])) $card=$_POST["cardnumber"];
	$checkbox=false;
	if(isset($_POST["subscrib_to_mail_list"])) $checkbox=true;

	if(!$card){
		if(isset($_GET['card'])){
			$card = $_GET['card'];
		}
	}
?>
<!-- Start html code here  -->
<div class="pform_area">
	<div class="form_group">
		<?php
			if(count($cferror)>0){
		?>
		<ul>
			<?php
				foreach($cferror as $k=>$val){
					switch ($k) {
						case "name":
						  echo "<li>Nafn is required!</li>";
						  break;
						case "phone":
							echo "<li>Símanúmer is required!</li>";
						  break;
						case "email":
							echo "<li>Netfang is required!</li>";
						  break;
						case "email_invalid":
							echo "<li>Netfang invalid!</li>";
						  break;
						case "card":
							echo "<li>Númer gjafakorts is required!</li>";
						  break;
						default:
						  
					  }
				}
			?>
		</ul>
		<?php
			}

			echo'<div style="text-align:center;">';

			if(isset($_GET["res"])){
				if($_GET["res"]==true){
					$url=trim($_GET['url']);
					//print_r($url);
					if(!empty($url))$url=base64_decode($url);
					echo'<h3>Gjafakort uppfært</h3>';
					if($url){
						echo '<p class="add_to_wlt"><a href="'.$url.'" target="_blank">Bæta korti við í farsíma</a></p>';
					}else{
						echo'<p>Pass url missing in GTW system.</p>';
					}
				}else{
					echo'<h3>Ops! something went wrong, Gjafakort has not been updated!</h3>';
				}
			}

			echo'</div>';
		?>
		<style>
			p.add_to_wlt a{
				background-color: #283b78 !important;
				font-family: 'DINNextLTPro-Condensed' !important;
				font-size: 18px;
				padding:15px;
				color:#fff;
				outline:none;
			}

		</style>
		<form id="gift-card-form" action="" method="POST" onsubmit="block_submit_button()">
			<input type="text" name="card_name" id="card_name" value="<?php echo $name;?>" placeholder="Nafn *" required=""><br>
			<input type="text" name="card_phone" id="card_phone" value="<?php echo $phone;?>" placeholder="Símanúmer *" required="" maxlength="7" minlength="7"><br>
			<input type="email" name="card_email" id="card_email" value="<?php echo $email;?>" placeholder="Netfang *" required=""><br>
			<input type="text" name="cardnumber" id="cardnumber" value="<?php echo $card;?>" placeholder="Númer gjafakorts xxxxxxxx *" required="">



			<video id="video" width="300" height="200"  style="display: none;"></video>
			<canvas id="canvas" style="display: none;"></canvas>
			<!-- <div id="output"></div> <span class="dashicons dashicons-camera-alt"></span> -->
			<button id="startButton" style="display: none;"><span class="dashicons dashicons-camera"></span> Start Scanner</button>
			<button id="stopButton" style="display: none;"><span class="dashicons dashicons-forms"></span> Stop Scanner</button>

			<br>

			<label>
				<input type="checkbox" name="subscrib_to_mail_list" <?php echo ($checkbox?'checked':'');?>> Ég hef áhuga á að skrá mig á póstlista Kringlunnar.
			</label>
			<div class="btn-text-wrap">
				<div class="btn-form">
					<input type="hidden" name="card_submit" value="Staðfesta" style="padding-left:28px;">
					<input type="submit" name="n_card_submit" id="card_submit" value="Staðfesta" style="padding-left:28px;">
				</div>
				<div class="btn-right-text">
					<p>Athugaðu að þótt gjafakortið hafi verið sett í veskið í símann þá er QR-og strikamerki enn virkt á útprentaða gjafakortinu.
					Passa skal því upp á að farga því eða geyma á vísum stað.</p>
				</div>
			</div>
			<div id="progress_bar"></div>
		</form>
		
	</div>
</div>
<!-- End html code here  -->
<?php
return ob_get_clean();
}

add_action('wp_footer',function(){
?>
<script>
	function block_submit_button(){
		jQuery('#card_submit').prop('disabled',true);
		jQuery('#progress_bar').html('<p>í vinnslu</p>');
	}
</script>
<?php
});

// submit card update form
add_action('init',function(){
	if(isset($_POST["card_submit"])){
		global $cferror;
		$card_holder_name=sanitize_text_field($_POST["card_name"]);
		if(!$card_holder_name){
			$cferror['name']=true;
		}
		$card_holder_phone=sanitize_text_field($_POST["card_phone"]);
		if(!$card_holder_phone){
			$cferror['phone']=true;
		}

		if(strlen($card_holder_phone)!=7){
			$cferror['phone']=true;
		}

		$card_holder_email=sanitize_text_field($_POST["card_email"]);
		if(!$card_holder_email){
			$cferror['email']=true;
		}else{
			if(!is_email($card_holder_email)){
				$cferror['email_invalid']=true;
			}
		}
		$cardnumber=sanitize_text_field($_POST["cardnumber"]);
		if(!$cardnumber){
			$cferror['card']=true;
		}

		if(count($cferror)>0){

		}else{
			// valid
			$subscribe=false;
			if(isset($_POST["subscrib_to_mail_list"]))$subscribe=true;
			// call gift card transaction list checkup
			$res=gift_card_transactionlist_lookup($card_holder_name,$card_holder_phone,$card_holder_email,$cardnumber,$subscribe);
			

			wp_safe_redirect(site_url().'/nyskraning/?res='.$res['status'].'&url='.base64_encode($res['url']));
			exit();

		}
	}
});


function woox_gtw_generate_missing_pass($card,$token){
	$url='https://admin.gifttowallet.com/api/card/generate-pass';
	$pass_url='';
	if($token){
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => array(
				'card_number'=>$card,
				'force_generate'=>1
			),
			CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer '.$token.''
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);


		if($response){
			$body = json_decode($response,true);
			
			if(isset($body["status"]) && $body["status"]==1){
				return $pass_url=$body['result']['pass_link'];
			}
		}
	}

	return $pass_url;
}

function woox_get_card_details_by_card($card,$token){
	$url='https://admin.gifttowallet.com/api/card/get-details';
	if($token){

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS =>array(
				'card_number'=>$card
			),
			CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer '.$token.''
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		if($response){
			$body = json_decode($response,true);

			if(isset($body["status"])){
				$url=$body['card_details']['pass_link'];
				if(!$url){
					$url=woox_gtw_generate_missing_pass($card,$token);
				}
				return ['status'=>1,'url'=>$url,'expiry_date'=>$body['card_details']['expiry_date'],'body'=>$body];
			}
		}
	}

	return ['status'=>0,'url'=>''];
}


function gift_card_transactionlist_lookup($name,$phone,$email,$card,$subscribe){
	$token=get_option('gift_to_wallet_token');


	$url='https://admin.gifttowallet.com/api/transactionlist?card_number='.$card;
	if($token){
		$result=woox_get_card_details_by_card($card,$token);
		if($result['status']==1){
			$res=gtw_update_card_information($name,$phone,$email,$card,$subscribe);

			if($res['status']==1){
				return ['status'=>1,'url'=>$res['url']];
			}
		}else{
			return ['status'=>0,'url'=>' - '];
		}
		
	}
}

// gtw update card information
function gtw_update_card_information($name,$phone,$email,$card,$subscribe){
	$token=get_option('gift_to_wallet_token');
	$url='https://admin.gifttowallet.com/api/card/update-detail';
	if($token){
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => array(
				'card_number'=>$card,
				'phone'=>$phone,
				'email'=>$email,
				'name'=>$name
			),
			CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer '.$token.''
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		if($response){
			$body = json_decode($response,true);
			if(isset($body["success"]) && $body["success"]==true){
				// update pass details card details
				if($subscribe) mailchimp_subscription($name,$email);
				return ['status'=>1,'url'=>$body['result']['pass_link']];
			}
		}
	}
	return ['status'=>0,'url'=>' - '];
}

function split_name($name) {
    $name = trim($name);
    $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
    $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
    return array($first_name, $last_name);
}

function mailchimp_subscription($name,$email){

	include('vendor/autoload.php');
	// mailchimp
	$mailchimp = new \MailchimpMarketing\ApiClient();

	$mailchimp->setConfig([
		'apiKey' => 'b3bd121bf83c039e2e3b4f20eda53c6f-us2',
		'server' => 'us2'
	]);

	$list_id = "9b1e52ddbe";

	$subscriber_hash = md5(strtolower($email));

	$fname=getFirstName($name);
	$lname=getLastName($name);

	if(!$fname)$fname=$lname;

	$response=$mailchimp->lists->setListMember($list_id,$subscriber_hash, [
			"email_address" => $email,
			"status" => "subscribed",
			"merge_fields" => [
				"FNAME" => $fname,
				"LNAME" => $lname
			]
		]);

	return 'ok';
}

function getFirstName($name) {
	return implode(' ', array_slice(explode(' ', $name), 0, -1));
}

function getLastName($name) {
	return array_slice(explode(' ', $name), -1)[0];
}


// add from Short code
add_shortcode('transaction-list','transaction_list_fun');
function transaction_list_fun($jekono){ 

	$result = shortcode_atts(array( 
		'title' =>'',
	),$jekono);

	extract($result);
	ob_start();
	$cardNo='';
	if(isset($_GET['cardno'])){
		$cardNo=trim($_GET['cardno']);
	}
	?>
	<div class="gift-card-no-wrap" >
		<form action="#" method="POST" onsubmit=" transaction_list_show(); return false; " >
			<div><b>Kortið mitt:</b></div>
			<input type="text" name="gift-card-no" placeholder="Númer Korts" value="<?php echo $cardNo;?>">
			<button type="button" onclick='transaction_list_show()'>Athuga</button>
		</form>
		<br>
		<?php
			$msg='';
			$transactions='';
			if($cardNo){
				$data=return_card_transactions($cardNo);
				$msg='<h3>'.$data[0].'</h3>';
				$transactions=$data[1];
			}
		?>
		<div id="giftCardSms"><?php echo $msg;?></div>
		<div class="transaction-list-data" id="transactionListData">
		<?php echo $transactions;?>
		</div>
	</div>

	<?php
	return ob_get_clean();
}

add_action('wp_footer', 'transaction_list_script');
function transaction_list_script(){
?>



<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>

<script>

	const video = document.getElementById('video');
	const canvas = document.getElementById('canvas');
	// const outputDiv = document.getElementById('output');
	const cardNo = document.getElementById('cardnumber');
	const startButton = document.getElementById('startButton');
	const stopButton = document.getElementById('stopButton');
	const constraints = { video: { facingMode: 'environment' } };
	let isScanning = false;
	let stream = null;

	function startScanner() {
		navigator.mediaDevices.getUserMedia(constraints)
			.then(function (str) {
				video.style.display = "block";
				stream = str;
				video.srcObject = stream;
				video.setAttribute('playsinline', true);
				video.play();
				requestAnimationFrame(tick);
				isScanning = true;
				startButton.style.display = 'none';
				stopButton.style.display = 'inline';
				cardNo.value = '';
				// outputDiv.innerHTML = ''; // Clear previous results
			})
			.catch(function(error) {
				console.error(error);
			});
	}

	function stopScanner() {
		if (stream) {
			const tracks = stream.getTracks();
			tracks.forEach(track => track.stop());
		}
		isScanning = false;
		startButton.style.display = 'inline';
		stopButton.style.display = 'none';
		video.setAttribute('playsinline', false);
		video.style.display = "none";
		// outputDiv.innerHTML = ''; // Clear previous results
	}

	function tick() {
		if (isScanning && video.readyState === video.HAVE_ENOUGH_DATA) {
			canvas.width = video.videoWidth;
			canvas.height = video.videoHeight;
			const ctx = canvas.getContext('2d');
			ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
			const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
			const code = jsQR(imageData.data, imageData.width, imageData.height);
			if (code) {
				// outputDiv.innerHTML = code.data;

				cardNo.value = code.data;
				stopScanner(); // Stop scanning after a successful scan
				// isScanning = false;
				// startButton.disabled = false;
			}
		}
		if (isScanning) {
			requestAnimationFrame(tick);
		}
	}

	if(startButton){
		startButton.addEventListener('click', startScanner);
		stopButton.addEventListener('click', stopScanner);
	}


 // Form submit function onclick='transaction_list_show()'
 function transaction_list_show() {
	
	let giftCardNo = jQuery('input[name=gift-card-no]').val();
	// WP Ajax Call with submit function
	jQuery('#giftCardSms').html(`<b>Í vinnslu...</b> `);
	jQuery.ajax({
		type: 'POST',
		dataType: 'json',
		url: '<?php echo admin_url('admin-ajax.php')?>',
		data: {
			action: 'gift_card_transaction_list_data',
			name: giftCardNo
		},
		success: function(response) {
			if ( ! response || response.error ) return;
			jQuery('#giftCardSms').html(` `);
			if(response.status == 'ok') { 
				jQuery('#giftCardSms').html(`<h3>${response.message}</h3>`);
				jQuery('#transactionListData').html(`${response.data}`);
			} else { 
				jQuery('#giftCardSms').html(`<p class='error'>Some problam</p>`);
			}
	
		}
	});
 }
 
</script>

<?php 
}

function return_card_transactions($cardNo){
	$token = get_option('gift_to_wallet_token');

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://admin.gifttowallet.com/api/transactionlist?card_number='.$cardNo,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$token
            ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);

        $obj = json_decode($response, true);
		// echo $response;

		$status=$obj['status'];
		if(isset($obj['success'])){
			$apiCall = $obj['success']; // true | false

			$list = $obj['result']['transaction_list'];
			// $initalBal = $obj['result']['initial_balance']; | 
			$dateTime = new DateTime($obj["result"]["expiry_date"]);
			$expDate  = $dateTime->format("d F Y g:i a");


			$html  = "";
	
			$html  .= '
				<ul class="transactionCard_info">
					<li><b>Inneign á korti er</b> '.$obj["result"]["current_balance"].' Kr.</li>		<!-- Current Balance: -->
					<li><b>Gildistími:</b> '.$expDate.'</li>
					<li><b>Fjöldi færsla:</b> '.$obj["result"]["total_transactions"].'</li>		<!-- Total Transactions:  -->
				</ul>';
			
			$html .= '
				<table>
					<tr>
						<th>Dagsetning</th> 	<!-- Transaction Date -->
						<th>Aðgerð</th>		<!-- Transaction By -->
						<th>Upphæð</th>		<!-- Transaction Amount -->
					</tr>';
			foreach ($list as $item) {

				$trDateTime = new DateTime($item['transaction_date']);
				$trDate  = $trDateTime->format("d F Y H:i a");
				$icon = ($item['transaction_type'] == 'redeem') ? '-':'+';
				$html .='
					<tr>
						<td>'.$trDate.'</td>
						<td>'.$item['trans_by'].'</td>
						<td>'.$icon.' '.$item['transaction_amount'].' kr.</td>
					</tr>';
			}

			$html .='
				</table>';
			$sms = 'Færslur'; /* Transaction List Shown below! */
		}else{
			$sms=$obj['message'];
			$html=$obj['result'];
		}

		return [$sms,$html];
}

// Form data ajax process & Email Send
function gift_card_transaction_list_data() {

	$cardNo = sanitize_text_field($_POST['name']); // 54226918 | 76895085 | 61122964
	$data=return_card_transactions($cardNo);
	echo json_encode(['status'=>'ok', 'message' => $data[0] , 'data' => $data[1]]);

	exit(); // wp_die();
}
add_action('wp_ajax_gift_card_transaction_list_data', 'gift_card_transaction_list_data');
add_action('wp_ajax_nopriv_gift_card_transaction_list_data', 'gift_card_transaction_list_data');


add_action('woocommerce_after_checkout_validation', 'is_kennitala',10,2);
function is_kennitala($data,$errors) { 

	// print_r($data);
	$value = trim($_POST['billing_kennitala']);

	$removeHipan =	str_replace("-", "", $value);
	$val = intval($removeHipan);
	$kt_length = strlen($removeHipan);

	if($kt_length==10 && $val>0){ 
		// $errors=false;
	}else{
		// wc_add_notice(sprintf('Sláðu inn gilda kennitölu'), 'error');
		$errors->add( 'validation', 'Kennitala ekki gild' );
		// $errors=true; 
	}

	// return $errors;
}



add_action( 'wp_footer', function() {
  ?>

<script>
// document.addEventListener('DOMContentLoaded', () => {
//   const form = document.querySelector('form.cart');
//   const btn = document.getElementById('front_end_bulk_order');	
//   if (!form || !btn) return;



//   // 2) Intercept the submit, send via AJAX, then show a simple alert
//   btn.addEventListener('click', async e => {
//     e.preventDefault();
//     btn.disabled = true;
//     btn.textContent = 'Sendir…';

//     try {
//       const res = await fetch('<?php echo admin_url( 'admin-ajax.php' );?>', {
//         method: 'POST',
//         body: new FormData(form)
//       });
//       if (!res.ok) throw new Error(`HTTP ${res.status}`);

//       // Success: simple user feedback
// //       alert('Pöntun móttekin! Takk fyrir kaup þín.');


//     } catch (err) {
//       console.error('AJAX error:', err);
//       alert('Villa við að senda pöntunina. Reyndu aftur síðar.');
//     } finally {
//       btn.disabled = false;
//       btn.textContent = 'Staðfesta pöntun';
//     }
//   });
// });


document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('form.cart');
  const btn = document.getElementById('front_end_bulk_order');
  if (!form || !btn) return;

  // Error message elements
  const cardErrorElement = document.querySelector('.add-more-cards-error-message small');
  const receiverErrorElement = document.querySelector('.add-more-cards-receiver-error-message small');
  const senderErrorElement = document.querySelector('.sender-name-error-message small');
  const finalErrorElement = document.querySelector('.final-error-message small');

  // Clear all error messages
  function clearErrors() {
    cardErrorElement.textContent = '';
    receiverErrorElement.textContent = '';
    senderErrorElement.textContent = '';
    finalErrorElement.textContent = '';
  }

  btn.addEventListener('click', async (e) => {
    e.preventDefault();
    clearErrors();
    
    if (!validateForm()) return;

    btn.disabled = true;
    btn.textContent = 'Sendir...';

    try {
       const res = await fetch('<?php echo admin_url( 'admin-ajax.php' );?>', {
        method: 'POST',
        body: new FormData(form)
      });
      if (!res.ok) throw new Error(`HTTP ${res.status}`);

      // First check HTTP status
      if (!res.ok) {
        throw new Error(`HTTP error! status: ${res.status}`);
      }

      let data;
      try {
        data = await res.json();
      } catch (jsonError) {
        console.error('JSON parsing error:', jsonError);
        throw new Error('Invalid server response');
      }

      if (!data || typeof data.success === 'undefined') {
        throw new Error('Invalid response format');
      }

      if (data.success) {
        window.location.href = data.data?.redirect || ajax_object.wc_cart_url;
      } else {
        // Show server error message in final error element
        finalErrorElement.textContent = data.data || 'Villa kom upp við pöntun';
      }

    } catch (err) {
      console.error('Error:', err);
      finalErrorElement.textContent = 'Villa við að senda pöntunina. Reyndu aftur síðar.';
    } finally {
      btn.disabled = false;
      btn.textContent = 'Halda áfram';
    }
  });

  // Form validation
  function validateForm() {
    let isValid = true;

    // Validate card amounts
    const cardPrices = document.querySelectorAll('input[name="card_price[]"]');
    const cardQuantities = document.querySelectorAll('input[name="card_no[]"]');
    
    if (cardPrices.length === 0 || cardQuantities.length === 0) {
      cardErrorElement.textContent = 'Vinsamlegast bættu við kortaupphæð og fjölda';
      isValid = false;
    }

    for (let i = 0; i < cardPrices.length; i++) {
      if (!cardPrices[i].value || isNaN(cardPrices[i].value)) {
        cardErrorElement.textContent = 'Ógild upphæð fyrir kort ' + (i + 1);
        cardPrices[i].focus();
        return false;
      }

      if (!cardQuantities[i].value || isNaN(cardQuantities[i].value) || parseInt(cardQuantities[i].value) < 1) {
        cardErrorElement.textContent = 'Ógildur fjöldi fyrir kort ' + (i + 1) + '. Verður að vera að minnsta kosti 1.';
        cardQuantities[i].focus();
        return false;
      }
    }

    // Validate recipients (either form fields or CSV)
    const csvFile = document.querySelector('input[name="receiver_file"]');
    const receiverNames = document.querySelectorAll('input[name="receiver_name[]"]');
    
    if (csvFile.files.length === 0 && receiverNames.length === 0) {
      receiverErrorElement.textContent = 'Vinsamlegast bættu við viðtakendum eða hladdu upp CSV skrá';
      isValid = false;
    }

    // Validate sender name
    const senderName = document.querySelector('input[name="sender_name"]');
    if (!senderName.value.trim()) {
      senderErrorElement.textContent = 'Vinsamlegast sláðu inn nafn sendanda';
      senderName.focus();
      isValid = false;
    }

    return isValid;
  }
});

</script>


 
  <?php
});

function frontend_bulk_order_action() {
	if ( is_session_started() === FALSE ) session_start();
    // Initialize arrays
    $receiver_names   = [];
    $receiver_phones  = [];
	$receiver_message = [];

    // Process CSV file if uploaded
    if (!empty($_FILES['receiver_file']['tmp_name'])) {
        $csv_data = array_map('str_getcsv', file($_FILES['receiver_file']['tmp_name']));
        
        foreach ($csv_data as $row) {
            if (empty($row[0])) continue;
            $name    = sanitize_text_field($row[0]);
            $phone   = isset($row[1]) ? sanitize_text_field($row[1]) : '';
            $message = isset($row[2]) ? sanitize_text_field($row[2]) : '';
            
            $receiver_names[]   = $name;
            $receiver_phones[]  = $phone;
            $receiver_message[] = $message;
        }
    }

    // Process manual entries if no CSV or in addition to CSV
    if (isset($_POST['receiver_name']) && is_array($_POST['receiver_name'])) {
        foreach ($_POST['receiver_name'] as $index => $name) {
            if (!empty($name) && !empty($_POST['receiver_phone'][$index])) {
                $receiver_names[]   = sanitize_text_field($name);
                $receiver_phones[]  = sanitize_text_field($_POST['receiver_phone'][$index]);
            }
        }
    }
	
	// Validate all recipients have phones
    foreach ($receiver_phones as $i => $phone) {
        if (empty($phone)) {
            wp_send_json_error(sprintf('Missing phone number for recipient %d', $i+1));
            wp_die();
        }
    }

    // Validate we have recipients
    if (empty($receiver_names)) {
        wp_send_json_error('No recipients provided (either via form or CSV file)');
        wp_die();
    }

    // Process card data
    $card_numbers = isset($_POST['card_no']) ? array_map('intval', $_POST['card_no']) : [];
    $card_prices = isset($_POST['card_price']) ? array_map('floatval', $_POST['card_price']) : [];

    // Validate counts
    if (count($card_numbers) !== count($card_prices)) {
        wp_send_json_error('Card numbers and prices count mismatch');
        wp_die();
    }

    $total_cards = array_sum($card_numbers);
    if ($total_cards !== count($receiver_names)) {
        wp_send_json_error(sprintf(
            'Recipient count (%d) does not match total cards (%d)',
            count($receiver_names),
            $total_cards
        ));
        wp_die();
    }

	$gift_card_date = (empty($_POST["gift_card_date"])?date('d/m/Y'):date("d/m/Y",strtotime($_POST["gift_card_date"])));
    $gift_card_time = (empty($_POST["gift_card_date"])?date('H:i:s'):date("H:i:s",strtotime($_POST["gift_card_date"])));
	
    // Prepare data
    $product_id      = intval($_POST['product_id']);
    $sender_name     = sanitize_text_field($_POST['sender_name']);
    $gift_card_image = esc_url_raw($_POST['gift_card_image']);
	//$gift_card_date  = isset($_POST['gift_card_date']) ? sanitize_text_field($_POST['gift_card_date']) : date("Y-m-d");
    //$gift_card_time  = isset($_POST['gift_card_time']) ? sanitize_text_field($_POST['gift_card_time']) : '12:00';

    // Add items to cart
    $current_recipient = 0;
    foreach ($card_numbers as $index => $quantity) {
        for ($i = 0; $i < $quantity; $i++) {
            if (!isset($receiver_names[$current_recipient])) break;
			if($i>0)sleep(1);
            $meta = [
                'gift_card_amount' => $card_prices[$index],
                'gift_card_recipient_name' => $receiver_names[$current_recipient],
                'gift_card_phone' => $receiver_phones[$current_recipient],
                'gift_card_sender_name' => $sender_name,
                'gift_card_image' => $gift_card_image,
                'unique_key' => md5(microtime() . rand()),
				'send_mail_to_recipient'=>2,
				'gift_card_date'=> $gift_card_date,
				'gift_card_time'=> $gift_card_time,
				'gift_card_recipient_email'=>'',
				'gift_card_custome_message'=> empty($receiver_message[$current_recipient]) ? sanitize_text_field($_POST['receiver_message']) : $receiver_message[$current_recipient]
            ];
			
            $_SESSION['lb_gift_card_add_to_cart_'.$product_id] = $meta;
            WC()->cart->add_to_cart($product_id, 1, 0, [], $meta);
            $current_recipient++;
        }
    }

     wp_send_json_success([
        'redirect' => wc_get_cart_url(),
        'message' => 'Pöntun móttekin!'
    ]);
    wp_die();
}

add_action( 'wp_ajax_nopriv_frontend_bulk_order_action', 'frontend_bulk_order_action' );
add_action( 'wp_ajax_frontend_bulk_order_action', 'frontend_bulk_order_action' );

function enqueue_datetimepicker_assets() {
    wp_enqueue_style('jquery-datetimepicker', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css');
    wp_enqueue_script('jquery-datetimepicker', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_datetimepicker_assets');

// for product 6362 start.

add_action('woocommerce_single_product_summary', function (){
    if (!is_product() || get_the_ID() != 6362) return;
    global $product;
    ?>
    <div style="margin-top:15px;">
        <b>Get card as:</b>
        <label><input type="radio" name="get_card" value="1" checked> Printed</label>&nbsp;&nbsp;
        <label><input type="radio" name="get_card" value="2"> plastic</label>
    </div>
    <h2 class="section-title">Upphæð og fjöldi korta <span class="require">*</span></h2>
    <div class="add-more-cards-area">
        <div class="single-card-details">
            <input type="text" name="card_price[]" placeholder="Upphæð korta" required>
            <input type="text" name="card_no[]" placeholder="Fjöldi korta" required>
            <button type="button" class="add-more-cards">
                +
            </button>
        </div>
    </div>

    <div class="final-error-message"><small style="color:red;"></small></div>
    <button type="button" id="front_end_bulk_order_new_product" style="margin-top: 15px;">Halda áfram</button>

    <script>
        jQuery(document).ready(function($) {
            // Add more cards
            $(document).on('click', '.add-more-cards', function() {
                let html = `<div class="single-card-details">
                            <input type="text" name="card_price[]" placeholder="Upphæð korta" required>
                            <input type="text" name="card_no[]" placeholder="Fjöldi korta" required>
                            <button type="button" class="remove-card">
                                -
                            </button>
                        </div>`;
                $(".add-more-cards-area").append(html);
            });

            // Remove card
            $(document).on('click', '.remove-card', function() {
                $(this).parent().remove();
            });

            // Handle bulk add to cart
            $(document).on('click', '#front_end_bulk_order_new_product', function(e) {
                e.preventDefault();
                console.log("work");

                // Clear previous errors
                $('.final-error-message small').html('');
                let errors = [];
                let isValid = true;

                // Validate inputs
                $('input[name="card_price[]"]').each(function(index) {
                    if (!$(this).val() || isNaN($(this).val())) {
                        errors.push(`Card ${index+1}: Please enter a valid price`);
                        isValid = false;
                    }
                });

                $('input[name="card_no[]"]').each(function(index) {
                    if (!$(this).val() || isNaN($(this).val()) || parseInt($(this).val()) < 1) {
                        errors.push(`Card ${index+1}: Please enter a valid quantity (minimum 1)`);
                        isValid = false;
                    }
                });

                // Display all errors
                if (errors.length > 0) {
                    $('.final-error-message small').html(errors.join('<br>'));
                    return;
                }

                // Prepare data
                let formData = new FormData();
                formData.append('action', 'frontend_bulk_order_action_new_product');
                formData.append('product_id', <?php echo $product->get_id(); ?>);

                // Add card data
                $('input[name="card_price[]"]').each(function(index) {
                    formData.append('card_price[]', $(this).val());
                });

                $('input[name="card_no[]"]').each(function(index) {
                    formData.append('card_no[]', $(this).val());
                });

                // Add delivery option
                formData.append('get_card', $('input[name="get_card"]:checked').val());

                // AJAX request
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#front_end_bulk_order_new_product').prop('disabled', true).text('Áfram...');
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.href = response.data.redirect || '<?php echo wc_get_cart_url(); ?>';
                        } else {
                            $('.final-error-message small').html(response.data || 'Error adding to cart');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('.final-error-message small').html('An error occurred: ' + error);
                    },
                    complete: function() {
                        $('#front_end_bulk_order_new_product').prop('disabled', false).text('Halda áfram');
                    }
                });
            });
        });
    </script>
    <?php
}, 35);

// Move the existing add to cart button and replace with our custom button
add_action('woocommerce_after_add_to_cart_button', function() {
	if (!is_product() || get_the_ID() != 6362) return;
    echo '<style>
            .single_add_to_cart_button { 
            display: none !important; 
            }
            .cart.quantity{
            display: none !important;
            }
            .quantity{
            display: none !important;
            }
            </style>';
});

// Allow products with zero price to be purchased
add_filter('woocommerce_is_purchasable', 'allow_zero_price_purchasable', 10, 2);
function allow_zero_price_purchasable($purchasable, $product) {
    return true;
}

// Validate price when adding to cart
add_filter('woocommerce_add_to_cart_validation', 'validate_custom_price', 10, 3);
function validate_custom_price($passed, $product_id, $quantity) {
	if (empty($_POST['card_price'])) {
		wc_add_notice(__('Please enter a valid price', 'woocommerce'), 'error');
		return false;
	}
    return $passed;
}

function frontend_bulk_order_action_new_product() {
    // Process card data
    $card_numbers = isset($_POST['card_no']) ? array_map('intval', $_POST['card_no']) : [];
    $card_prices = isset($_POST['card_price']) ? array_map('floatval', $_POST['card_price']) : [];
    $product_id = intval($_POST['product_id']);
    $get_card = isset($_POST['get_card']) ? sanitize_text_field($_POST['get_card']) : '';

    // Validate counts
    if (count($card_numbers) !== count($card_prices)) {
        wp_send_json_error('Card numbers and prices count mismatch');
    }

    // Temporarily allow zero price
    add_filter('woocommerce_is_purchasable', '__return_true');

    // Add items to cart
    foreach ($card_numbers as $index => $quantity) {
        $price = $card_prices[$index];

        // Prepare cart item data
        $cart_item_data = array(
            'custom_price' => $price,
            'get_card' => $get_card,
            'card_number' => $index + 1
        );


        WC()->cart->add_to_cart($product_id, $quantity, 0, array(), $cart_item_data);
    }

    // Remove the temporary filter
    remove_filter('woocommerce_is_purchasable', '__return_true');

    wp_send_json_success([
        'redirect' => wc_get_cart_url(),
        'message' => 'Items added to cart!'
    ]);
}

add_action('woocommerce_before_calculate_totals', 'set_custom_price', 20, 1);
function set_custom_price($cart) {
    if (is_admin() && !defined('DOING_AJAX')) return;
    if (did_action('woocommerce_before_calculate_totals') >= 2) return;

    foreach ($cart->get_cart() as $cart_item) {
        if (isset($cart_item['custom_price'])) {
            $cart_item['data']->set_price($cart_item['custom_price']);
        }
    }
}

// Display custom data in cart
add_filter('woocommerce_get_item_data', 'display_custom_item_data', 10, 2);
function display_custom_item_data($item_data, $cart_item) {
    if (isset($cart_item['get_card'])) {
        $option = $cart_item['get_card'] == '1' ? 'Printed' : 'Plastic';
        $item_data[] = array(
            'key' => 'Card Type',
            'value' => wc_clean($option)
        );
    }
    return $item_data;
}

// Save custom data to order
add_action('woocommerce_checkout_create_order_line_item', 'save_custom_order_item_meta', 10, 4);
function save_custom_order_item_meta($item, $cart_item_key, $values, $order) {
    if (isset($values['get_card'])) {
        $option = $values['get_card'] == '1' ? 'Printed' : 'Plastic';
        $item->add_meta_data('Card Type', $option);
    }
    if (isset($values['custom_price'])) {
        $item->add_meta_data('Card Amount', $values['custom_price']);
    }
}


add_action('wp_ajax_nopriv_frontend_bulk_order_action_new_product', 'frontend_bulk_order_action_new_product');
add_action('wp_ajax_frontend_bulk_order_action_new_product', 'frontend_bulk_order_action_new_product');

// for product 6362 end.
add_action('init',function(){
	if(isset($_GET['download-csv'])){
		$order_id = $_GET['download-csv'];
		global $wpdb;
		$sql="SELECT a.`order_item_id`,
b.meta_key,
b.meta_value
FROM `{$wpdb->prefix}woocommerce_order_items` a, {$wpdb->prefix}woocommerce_order_itemmeta b 
where a.`order_id`={$order_id} and 
a.order_item_type='line_item' and 
a.order_item_id=b.order_item_id and 
b.meta_key IN('giftcard_no','expire_date','pass_link','recipient_name','Símanúmer','_line_subtotal') order by a.`order_item_id`";
		
		$results = $wpdb->get_results($sql);
		
		$data=array();
		foreach($results as $row){
			if(!isset($data[$row->order_item_id])){
				$data[$row->order_item_id] = array(
					'giftcard_no'=>'',
					'expire_date'=>'',
					'pass_link'=>'',
					'recipient_name'=>'',
					'simi'=>'',
					'amount'=>''
				);
			}
			
			switch($row->meta_key){
				case "giftcard_no":
					$data[$row->order_item_id]['giftcard_no']=$row->meta_value;
				break;
				case "expire_date":
					$data[$row->order_item_id]['expire_date']=$row->meta_value;
				break;
					case "pass_link":
					$data[$row->order_item_id]['pass_link']=$row->meta_value;
				break;
				case "recipient_name":
					$data[$row->order_item_id]['recipient_name']=$row->meta_value;
				break;
				case "Símanúmer":
					$data[$row->order_item_id]['simi']=$row->meta_value;
				break;
				case "_line_subtotal":
					$data[$row->order_item_id]['amount']=$row->meta_value;
				break;
			}
		} // end foreach
		
        header('Content-Type: text/csv');
        header('Content-disposition: attachment; filename=bcse-download-'.time().'.csv');

        $fp = fopen('php://output', 'w');

        $headers = array("Card No.","Phone","Name","Initial Balance", "Pass Link");

        fputcsv($fp, $headers);

        // Loop through the cards and update the database
        foreach ($data as $card) {
			$rname='';
			$unserialized_data = maybe_unserialize($card['recipient_name']);
			if (is_array($unserialized_data) && !empty($unserialized_data)) {
    			$rname = $unserialized_data[0];
			}
          $row = array(
			  $card['giftcard_no'],
			  $card['simi'],
			  $rname,
			  $card['amount'].' Kr.',
			  $card['pass_link'],
			  
          );
          fputcsv($fp, $row);

        }

        fclose($fp);
        exit();
	}
});

function wx_my_custom_admin_meta() {
    ?>
	<style>
		.plastic-card-n{display: flex;flex-direction: column;align-items: flex-start;}
		.plastic-card-n input{margin-bottom:3px;}
	</style>
		
	<?php
}
add_action( 'admin_head', 'wx_my_custom_admin_meta' );

add_action( 'woocommerce_after_order_itemmeta', 'display_special_message_for_product_meta', 10, 3 );

function display_special_message_for_product_meta( $item_id, $item, $product ) {
    // Check if the item is a product and has the specific product ID
    if ( $item->is_type( 'line_item' ) ) {
        if ( $product && $product->get_id() == 6362 ) {
            // Display your special message
            echo '<div class="plastic-card-n">';
				$qty = $item->get_quantity();
			for($i=0;$i<$qty;$i++){
				echo'<input type="text" placeholder="Kortanúmer" name="card_number_'.$item_id.'[]">';
			}
			echo'<button type="button" class="button button-primary">Hengja kort við pöntun</button></div>';
        }
    }
}

// Add AJAX handler for gift card orders
add_action('wp_ajax_process_gift_card_order', 'process_gift_card_order');
add_action('wp_ajax_nopriv_process_gift_card_order', 'process_gift_card_order');

function process_gift_card_order(){
    if ( is_session_started() === FALSE ) session_start();
    // Initialize arrays
    $receiver_names   = [];
    $receiver_phones  = [];
    $receiver_emails  = [];

    $csv_uploaded = false;

    // Process CSV file if uploaded
    if (!empty($_FILES['receiver_file']['tmp_name'])) {
        $csv_uploaded = true;
        $file = fopen($_FILES['receiver_file']['tmp_name'], 'r');

        if ($file !== FALSE) {
            // Read and check if first row is a header
            $firstRow = fgetcsv($file);
            $isHeader = false;

            if ($firstRow !== FALSE) {
                $firstValue = strtolower(trim($firstRow[0]));
                $isHeader = ($firstValue === 'nafn' || $firstValue === 'name');
            }

            // If it's not a header, process the first row
            if (!$isHeader && !empty($firstRow[0])) {
                $receiver_names[]   = sanitize_text_field($firstRow[0]);
                $receiver_emails[]  = isset($firstRow[1]) ? sanitize_email($firstRow[1]) : '';
                $receiver_phones[]  = isset($firstRow[2]) ? sanitize_text_field($firstRow[2]) : '';
            }

            // Process the remaining rows
            while (($row = fgetcsv($file)) !== FALSE) {
                if (empty($row[0])) continue;

                $receiver_names[]   = sanitize_text_field($row[0]);
                $receiver_emails[]  = isset($row[1]) ? sanitize_email($row[1]) : '';
                $receiver_phones[]  = isset($row[2]) ? sanitize_text_field($row[2]) : '';
            }

            fclose($file);
        }
    }

    // Process manual entries ONLY if no CSV was uploaded
    if (!$csv_uploaded && isset($_POST['receiver_name']) && is_array($_POST['receiver_name'])) {
        foreach ($_POST['receiver_name'] as $index => $name) {
            if (!empty($name)) {
                $receiver_names[]   = sanitize_text_field($name);
                $receiver_emails[]  = isset($_POST['receiver_email'][$index]) ? sanitize_email($_POST['receiver_email'][$index]) : '';
                $receiver_phones[]  = isset($_POST['receiver_phone'][$index]) ? sanitize_text_field($_POST['receiver_phone'][$index]) : '';
            }
        }
    }

    // Rest of your code remains the same...
    // Debug: Check what we've collected
    error_log('Receiver names: ' . print_r($receiver_names, true));
    error_log('Receiver emails: ' . print_r($receiver_emails, true));
    error_log('Receiver phones: ' . print_r($receiver_phones, true));
    error_log('CSV uploaded: ' . ($csv_uploaded ? 'Yes' : 'No'));
    error_log('Total recipients: ' . count($receiver_names));


    // Validate all recipients have emails
    foreach ($receiver_emails as $i => $email) {
        if (empty($email)) {
            wp_send_json_error(sprintf('Missing email for recipient %d', $i+1));
            wp_die();
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            wp_send_json_error(sprintf('Invalid email format for recipient %d: %s', $i+1, $email));
            wp_die();
        }
    }

    // Validate phone numbers if SMS notification is selected
    $notification_preference = sanitize_text_field($_POST['notification_preference']);
    if ($notification_preference === 'Sendu sms & tölvupóst til viðtakanda') {
        foreach ($receiver_phones as $i => $phone) {
            if (empty($phone)) {
                wp_send_json_error(sprintf('Missing phone number for recipient %d (SMS notification selected)', $i+1));
                wp_die();
            }
        }
    }

    // Validate we have recipients
    if (empty($receiver_names)) {
        wp_send_json_error('No recipients provided (either via form or CSV file)');
        wp_die();
    }

    // Process card data
    $card_numbers = isset($_POST['card_no']) ? array_map('intval', $_POST['card_no']) : [];
    $card_prices = isset($_POST['card_price']) ? array_map('floatval', $_POST['card_price']) : [];

    // Validate counts
    if (count($card_numbers) !== count($card_prices)) {
        wp_send_json_error('Card numbers and prices count mismatch');
        wp_die();
    }

    $total_cards = array_sum($card_numbers);
    if ($total_cards !== count($receiver_names)) {
        wp_send_json_error(sprintf(
            'Recipient count (%d) does not match total cards (%d)',
            count($receiver_names),
            $total_cards
        ));
        wp_die();
    }

    // Handle date/time - fix the time assignment
    $gift_card_date = date('d/m/Y');
    $gift_card_time = date('H:i:s');

    if (!empty($_POST["gift_card_date"])) {
        $gift_card_date = date("d/m/Y", strtotime($_POST["gift_card_date"]));
    }

    if (!empty($_POST["gift_card_time"])) {
        $gift_card_time = date("H:i:s", strtotime($_POST["gift_card_time"]));
    }

    // Prepare data
    $product_id              = 6340;
    $sender_name             = sanitize_text_field($_POST['sender_name']);
    $right_now_or_not        = sanitize_text_field($_POST['right_now_or_not']);
    $notification_preference = sanitize_text_field($_POST['notification_preference']);
    $receiver_message        = sanitize_text_field($_POST['receiver_message']);

    // Clear any existing gift cards in cart
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        if ($cart_item['product_id'] == $product_id) {
            WC()->cart->remove_cart_item($cart_item_key);
        }
    }

    // Add items to cart
    $current_recipient = 0;
    foreach ($card_numbers as $index => $quantity) {
        for ($i = 0; $i < $quantity; $i++) {
            if (!isset($receiver_names[$current_recipient])) break;

            $meta = [
                'gift_card_amount' => $card_prices[$index],
                'gift_card_recipient_name' => $receiver_names[$current_recipient],
                'gift_card_phone' => $receiver_phones[$current_recipient],
                'gift_card_sender_name' => $sender_name,
                'gift_card_image' => '',
                'unique_key' => md5(microtime() . rand()),
                'send_mail_to_recipient' => ($notification_preference === 'Sendu tölvupóst til viðtakanda') ? 1 : 2,
                'gift_card_date' => $gift_card_date,
                'gift_card_time' => $gift_card_time,
                'gift_card_recipient_email' => $receiver_emails[$current_recipient],
                'gift_card_custome_message' => $receiver_message
            ];

            $_SESSION['lb_gift_card_add_to_cart_'.$product_id] = $meta;
            WC()->cart->add_to_cart($product_id, 1, 0, [], $meta);
            $current_recipient++;
        }
    }

    wp_send_json_success([
        'redirect' => wc_get_cart_url(),
        'message' => 'Pöntun móttekin!'
    ]);
    wp_die();
}
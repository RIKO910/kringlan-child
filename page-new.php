<?php
/**
* Template Name: New page
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kringlan.is - gjafakort (Presentation)</title>

    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/assets/css/styles.css?v=<?php echo time();?>">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/assets/css/responsive.css">
</head>
<body>

    <main>
        <!-- Buy a gift card section  -->
        <section class="gjafa_sec_wrap gjafa_sec_buy_giftcard" id="gjafa_sec_id_01">
            <div class="gjafa_sec_container">
                <div class="gjafa_heading_box">
                    <h2 class="gjafa_heading">Kaupa gjafakort</h2>
                    <div class="gjafa_sec_desc">
                        Gjafakort Kringlunnar gildir í öllum verslunum og hjá þjónustuaðilum <br/>í Kringlunni nema Vínbúðinni.
                        <br/><br/>
                        Rafræn gjafakort er einnig hægt að nota til kaupa í netverslun Kringlunnar á kringlan.is
                    </div>
                </div>
                <div class="gjafa_sec_row">
                    <div class="gjafa_sec_column gjafa_left_column">
                        <figure class="img_wrap">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/image_01.png" class="gjafa_img" alt="image_01">
                        </figure>
                        <figure class="img_wrap">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/image_02.png" class="gjafa_img" alt="image_02">
                        </figure>
                        <figure class="img_wrap">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/image_03.png" class="gjafa_img" alt="image_03">
                        </figure>
                    </div>
                    <div class="gjafa_sec_column gjafa_right_column">
                        <div class="gjafa_column_contents">
                            <div class="gjafa_item_wrap">
                                <div class="gjafa_single_item">
                                    <div class="gjafa_add_items_groups">
                                        <div class="gjafa_input_box_items">
                                            <div class="gjafa_input_item_box">
                                                <div class="gjafa_input_item">
                                                    <span class="input_label">Veldu upphæð</span>
                                                    <input type="text" name="gjafa_pice_input[0]" value="" 
													   oninput="wxPriceInputOnInput(this)" 
													   onblur="wxPriceInputOnBlur(this)" 
													   onfocus="wxPriceInputOnFocus(this)" 
													   placeholder="t.d. 10.000 kr." 
													   id="gjafa_pice_input[0]" 
													   class="gjafa_input gjafa_pice_input">
                                                </div>
                                                <div class="gjafa_input_item">
                                                    <span class="input_label">Skráðu fjölda</span>
                                                    <input type="number" name="gjafa_qty_input[0]" value="1" id="gjafa_qty_input[0]" class="gjafa_input gjafa_qty_input">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="gjafa_btn_box">
                                            <button type="button" class="gjafa_btn gjafa_add_item_btn" onclick="gjafaAddMoreItemshandler(this, event)"> + Bæta við öðru korti<br/>(með aðra upphæð)</button>
                                            <div class="mark_amount" style="display:none;">Hámark 100?</div>
                                        </div>
                                    </div>  
                                </div>
                                <div class="gjafa_single_item">
                                    <div class="gjafa_radio_box gjafa_card_types_options">
                                        <h2 class="gjafa_heading">Hvernig viltu fá kortið</h2>
                                        <div class="gjafa_radio_options">

                                            <div class="gjafa_radio_item">
                                                <input type="radio" name="gjafa_card_type" value="Rafrænt gjafakort" id="gjafa_electric_giftcard" class="gjafa_radio_input" checked>
                                                <label for="gjafa_electric_giftcard" class="gjafa_radio_label">
                                                    Rafrænt gjafakort
                                                </label>
                                            </div>

                                            <div class="gjafa_radio_item">
                                                <input type="radio" name="gjafa_card_type" value="Gjafakort í umslagi" id="gjafa_envelope_giftcard" class="gjafa_radio_input">
                                                <label for="gjafa_envelope_giftcard" class="gjafa_radio_label">
                                                    Gjafakort í umslagi
                                                </label>
                                            </div>

                                            <div class="gjafa_radio_item">
                                                <input type="radio" name="gjafa_card_type" value="Gjafakort í spilastokki" id="gjafa_deck_giftcard" class="gjafa_radio_input">
                                                <label for="gjafa_deck_giftcard" class="gjafa_radio_label">
                                                    Gjafakort í spilastokki
                                                </label>
                                            </div>

                                        </div>
                                    </div>

                                    <button type="button" class="gjafa_btn" onclick="gjafaUpdateDataHandler(this, event)" style="margin-top: 20px;">Áfram</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Electronic Gift Card section CSV upload  -->
        <section class="gjafa_sec_wrap gjafa_sec_electronic_giftcard" id="gjafa_sec_id_02" style="display:none;">
            <div class="gjafa_sec_container">
                
                <div class="gjafa_sec_row">
                    <div class="gjafa_sec_column gjafa_left_column">
                        <div class="gjafa_column_heading_box">
                            <figure class="img_wrap">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/image_01.png" class="gjafa_img" alt="image_01">
                            </figure>
                            <div class="gjafa_heading_box">
                                <span class="gjafa_sub_heading">Kaupa gjafakort- fyrirtæki yfir <span class="no_of_cards"></span> kort?</span>
                                <h2 class="gjafa_heading">Rafrænt Gjafakort</h2>
                            </div>
                        </div>
                        <div class="gjafa_pdf_card">
                            <div class="gjafa_pdf_card_header">
                                <figure class="img_wrap">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/pdf-thumb.png" alt="PDF Thumbnail" class="pdf_thumb">
                                </figure>
                            </div>

                            <div class="gjafa_pdf_card_body">
                                <div class="gjafa_pdf_price_box">
                                    <span class="gjafa_pdf_price"></span>
                                </div>
								<div class="gift_card_message_text" style="word-break: break-all;">
									
								</div>
                                <div class="gjafa_pdf_code_type_box">
                                    <figure class="gjafa_pdf_qrcode">
                                        <img src="https://gjafakort.kringlan.is/wp-content/plugins/gift-card-item/assets/images/kringlan.is.png" alt="QRCode Image" class="qrcode_image">
                                    </figure>
                                    <figure class="gjafa_pdf_barcode">
                                        <img src="https://gjafakort.kringlan.is/wp-content/plugins/gift-card-item/assets/images/kringlan-barcode.gif" alt="BARCode Image" class="barcode_image">
                                    </figure>
                                </div>
                            </div>
                            
                            <div class="gjafa_pdf_card_footer">
                                <p class="pdf_desc">Skannaðu kóðann og fáðu gjafakortið þitt í símann eða borgaðu með því að sýna strikamerkið í verslunum Kringlunnar</p>
                            </div>
                        </div>
                    </div>
                    <div class="gjafa_sec_column gjafa_right_column">
                        <div class="gjafa_column_contents">
                            <div class="gjafa_item_wrap">
                                <div class="gjafa_single_item">
                                    <div class="gjafa_heading_box">
                                        <h2 class="gjafa_heading">Upplýsingar um viðtakanda</h2>
                                        <label for="gjafa_file_input" class="gjafa_file_input_label">Hlaða upp</label>
                                        <figure class="gjafa_file_upload_box">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/cloud-upload.svg" alt="upload image" class="upload_image">
                                            <input type="file" name="gjafa_file_input" id="gjafa_file_input" class="gjafa_input gjafa_file_input" onchange="gjafaUploadFileHandler(this, event)">
                                        </figure>

                                        <div class="gjafa_sec_desc">
                                           Viðtakandi fær gjafakortið sent í tölvupósti og/eða með sms skilaboðum. Ef þú vilt frekar prenta það út og færa þeim sem á að fá gjöfina frá þér þá skráir þú sjálfan þig sem viðtakanda og færð gjafakortið sent tilbúið til prentunar.
                                        </div>
                                    </div>
                                </div>

                                <div class="gjafa_single_item">
                                    <div class="gjafa_heading_box">
                                        <h2 class="gjafa_heading">Viltu skrifa kveðju?</h2>
                                        <span class="gjafa_subheading">Skilaboð sem birtast á gjafakorti og í SMS</span>
                                    </div>
                                    <textarea name="" id="" cols="50" rows="5" class="gjafa_textarea_csv" onkeyup="wxUpdateGiftCardMessage(this)"
          oninput="wxUpdateGiftCardMessage(this)"
          onpaste="wxUpdateGiftCardMessage(this)"
          oncut="wxUpdateGiftCardMessage(this)"></textarea>
                                </div>
                                
                                <div class="gjafa_single_item">
                                    <h2 class="gjafa_heading">Viltu skrifa kveðju?</h2>
                                    <div class="gjafa_options_box">
                                        <div class="gjafa_option_items">
                                            <label for="gjafa_radio_input" class="gjafa_single_option gjafa_radio_item">
                                                <input type="radio" name="gjafa_radio_input_getting_csv" value="Núna" id="gjafa_radio_input" class="gjafa_radio_input" checked>
                                                Núna
                                            </label>

                                            <label for="gjafa_radio_input" class="gjafa_single_option gjafa_radio_item">
                                                <input type="radio" name="gjafa_radio_input_getting_csv" value="Veldu tíma" id="gjafa_radio_input" class="gjafa_radio_input gjafa_radio_getting_time_csv">
                                                Veldu tíma
                                            </label>
                                        </div>
                                        <div class="gjafa_option_items getting-date-time-csv" style="display: none">
                                            <div class="gjafa_single_option">
                                                <input type="date" name="gjafa_date_input_csv" id="gjafa_date_input_csv" class="gjafa_input gjafa_date_input_csv" onchange="gjafaDateInputHandler(this, event)">
                                            </div>
                                            <div class="gjafa_single_option">
                                                <input type="time" name="gjafa_time_input_csv" id="gjafa_time_input_csv" class="gjafa_input gjafa_time_input_csv" onchange="gjafaTimeInputHandler(this, event)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gjafa_single_item">
                                    <div class="gjafa_heading_box">
                                        <h2 class="gjafa_heading">Upplýsingar um þig</h2>
                                        <span class="gjafa_subheading">Mikilvægt að setja nafn þitt hér svo að viðtakandi viti frá hverjum gjöfin er.</span>
                                    </div>
                                    <input type="text" name="gjafa_text_input_csv" id="gjafa_text_input_csv" class="gjafa_input gjafa_text_input_csv" placeholder="Nafn">
                                    <div class="gjafa_radio_options">
                                        <div class="gjafa_radio_item">
                                            <input type="radio" name="gjafa_radio_item_email_phone_csv" value="Sendu tölvupóst til viðtakanda" id="gjafa_radio_item" class="gjafa_radio_input" checked>
                                            <label for="gjafa_radio_item" class="gjafa_radio_label">
                                                Sendu tölvupóst til viðtakanda
                                            </label>
                                        </div>
                                        <div class="gjafa_radio_item">
                                            <input type="radio" name="gjafa_radio_item_email_phone_csv" value="Sendu sms & tölvupóst til viðtakanda" id="gjafa_radio_item" class="gjafa_radio_input gjafa_radio_item_email_and_phone">
                                            <label for="gjafa_radio_item" class="gjafa_radio_label">
                                                Sendu sms & tölvupóst til viðtakanda
                                            </label>
                                        </div>
                                    </div>
									<div style="display:flex;">
										<button type="button" class="gjafa_btn" onclick="gjafaBackToStepOne(this, event)" style="margin-top: 20px;margin-right:15px;">Til Baka</button>
                                    	<button type="button" class="gjafa_btn" onclick="gjafaCheckoutOneHandler(this, event)" style="margin-top: 20px;">Áfram</button>										
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Electronic Gift Card section manual input -->
        <section class="gjafa_sec_wrap gjafa_sec_electronic_giftcard" id="gjafa_sec_id_03" style="display:none;">
            <div class="gjafa_sec_container">
                
                <div class="gjafa_sec_row">
                    <div class="gjafa_sec_column gjafa_left_column">
                        <div class="gjafa_column_heading_box">
                            <figure class="img_wrap">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/image_01.png" class="gjafa_img" alt="image_01">
                            </figure>
                            <div class="gjafa_heading_box">
                                <span class="gjafa_sub_heading">Kaupa gjafakort- fyrirtæki yfir <span class="no_of_cards"></span> kort?</span>
                                <h2 class="gjafa_heading">Rafrænt Gjafakort</h2>
                            </div>
                        </div>
                        <div class="gjafa_pdf_card">
                            <div class="gjafa_pdf_card_header">
                                <figure class="img_wrap">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/pdf-thumb.png" alt="PDF Thumbnail" class="pdf_thumb">
                                </figure>
                            </div>

                            <div class="gjafa_pdf_card_body">
                                <div class="gjafa_pdf_price_box">
                                    <span class="gjafa_pdf_price"></span>
                                </div>
                                
								<div class="gift_card_message_text" style="word-break: break-all;">
									
								</div>
                                <div class="gjafa_pdf_code_type_box">
                                    <figure class="gjafa_pdf_qrcode">
                                        <img src="https://gjafakort.kringlan.is/wp-content/plugins/gift-card-item/assets/images/kringlan.is.png" alt="QRCode Image" class="qrcode_image">
                                    </figure>
                                    <figure class="gjafa_pdf_barcode">
                                        <img src="https://gjafakort.kringlan.is/wp-content/plugins/gift-card-item/assets/images/kringlan-barcode.gif" alt="BARCode Image" class="barcode_image">
                                    </figure>
                                </div>
                            </div>
                            
                            <div class="gjafa_pdf_card_footer">
                                <p class="pdf_desc">Skannaðu kóðann og fáðu gjafakortið þitt í símann eða borgaðu með því að sýna strikamerkið í verslunum Kringlunnar</p>
                            </div>
                        </div>
                    </div>
                    <div class="gjafa_sec_column gjafa_right_column">
                        <div class="gjafa_column_contents">
                            <div class="gjafa_item_wrap">
                                <div class="gjafa_single_item">
                                    <div class="gjafa_heading_box">
                                        <h2 class="gjafa_heading">Upplýsingar um viðtakanda <span class="require">*</span></h2>
                                    </div>
                                </div>

                                <div class="gjaf_single_item">
									<div id="receipent_info_area">
										
									</div>
									
                                    <div class="gjafa_sec_desc">
                                        Viðtakandi fær gjafakortið sent í tölvupósti og/eða með sms skilaboðum. Ef þú vilt frekar prenta það út og færa þeim sem á að fá gjöfina frá þér þá skráir þú sjálfan þig sem viðtakanda og færð gjafakortið sent tilbúið til prentunar.
                                    </div>
                                </div>

                                <div class="gjafa_single_item">
                                    <div class="gjafa_heading_box">
                                        <h2 class="gjafa_heading">Viltu skrifa kveðju?</h2>
                                        <span class="gjafa_subheading">Skilaboð sem birtast á gjafakorti og í SMS</span>
                                    </div>
                                    <textarea name="" id="" cols="50" rows="5" class="gjafa_textarea" onkeyup="wxUpdateGiftCardMessage(this)"
          oninput="wxUpdateGiftCardMessage(this)"
          onpaste="wxUpdateGiftCardMessage(this)"
          oncut="wxUpdateGiftCardMessage(this)"></textarea>
                                </div>
                                
                                <div class="gjafa_single_item">
                                    <h2 class="gjafa_heading">Viltu skrifa kveðju?</h2>
                                    <div class="gjafa_options_box">
                                        <div class="gjafa_option_items">
                                            <label for="gjafa_radio_input" class="gjafa_single_option gjafa_radio_item">
                                                <input type="radio" name="gjafa_radio_input_getting" value="Núna" id="gjafa_radio_input" class="gjafa_radio_input" checked>
                                                Núna
                                            </label>

                                            <label for="gjafa_radio_input" class="gjafa_single_option gjafa_radio_item">
                                                <input type="radio" name="gjafa_radio_input_getting" value="Veldu tíma" id="gjafa_radio_input" class="gjafa_radio_input gjafa_radio_getting_time">
                                                Veldu tíma
                                            </label>
                                        </div>
                                        <div class="gjafa_option_items getting-date-time" style="display: none">
                                            <div class="gjafa_single_option">
                                                <input type="date" name="gjafa_date_input" id="gjafa_date_input" class="gjafa_input gjafa_date_input" onchange="gjafaDateInputHandler(this, event)">
                                            </div>
                                            <div class="gjafa_single_option">
                                                <input type="time" name="gjafa_time_input" id="gjafa_time_input" class="gjafa_input gjafa_time_input" onchange="gjafaTimeInputHandler(this, event)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gjafa_single_item">
                                    <div class="gjafa_heading_box">
                                        <h2 class="gjafa_heading">Upplýsingar um þig <span class="require">*</span></h2>
                                        <span class="gjafa_subheading">Mikilvægt að setja nafn þitt hér svo að viðtakandi viti frá hverjum gjöfin er.</span>
                                    </div>
                                    <input type="text" name="gjafa_text_input" id="gjafa_text_input" class="gjafa_input gjafa_text_input" placeholder="Nafn">
                                    <div class="gjafa_radio_options">
                                        <div class="gjafa_radio_item">
                                            <input type="radio" name="gjafa_radio_item_email_phone" value="Sendu tölvupóst til viðtakanda" id="gjafa_radio_item" class="gjafa_radio_input" checked>
                                            <label for="gjafa_radio_item" class="gjafa_radio_label">
                                                Sendu tölvupóst til viðtakanda
                                            </label>
                                        </div>
                                        <div class="gjafa_radio_item">
                                            <input type="radio" name="gjafa_radio_item_email_phone" value="Sendu sms & tölvupóst til viðtakanda" id="gjafa_radio_item" class="gjafa_radio_input gjafa_radio_item_email_and_phone">
                                            <label for="gjafa_radio_item" class="gjafa_radio_label">
                                                Sendu sms & tölvupóst til viðtakanda
                                            </label>
                                        </div>
                                    </div>
									<div style="display:flex;">										
										<button type="button" class="gjafa_btn" onclick="gjafaBackToStepOne(this, event)" style="margin-top: 20px; margin-right:15px;">Til Baka</button>
                                    	<button type="button" class="gjafa_btn" onclick="gjafaCheckoutTwoHandler(this, event)" style="margin-top: 20px;">Áfram</button>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        


        <!-- Gift card in an envelope section  -->
        <section class="gjafa_sec_wrap" id="gjafa_sec_id_04" style="display:none;">
            <div class="gjafa_sec_container">
                <div class="gjafa_heading_box spacing_mb_30">
                    <h2 class="gjafa_heading left_spacing">Gjafakort í umslagi</h2>
                </div>
                <div class="gjafa_sec_row">
                    <div class="gjafa_sec_column gjafa_left_column">
                        <div class="image_box_item">
                            <figure class="img_wrap">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/image_01.png" alt="" class="img_thumb">
                            </figure>
                        </div>
                    </div>
                    <div class="gjafa_sec_column gjafa_right_column">
                        <div class="gjafa_column_contents">
                            <div class="gjafa_item_wrap">
                                <div class="gjafa_single_item">
                                    <div class="gjafa_heading_box">
                                        <h2 class="gjafa_heading">Upplýsingar um greiðanda</h2>
                                    </div>
                                    <div class="gjafa_btn_groups_box">
                                        <div class="gjafa_btn_groups">
                                            <input type="text" value="" placeholder="Heimilisfang" class="gjafa_input" />
                                            <input type="text" value="" placeholder="Kennitala" class="gjafa_input" />
                                            <input type="text" value="" placeholder="Símanúmer" class="gjafa_input" />
                                        </div>
                                        <div class="gjafa_btn_groups">
                                            <input type="text" value="" placeholder="Nafn" class="gjafa_input" />
                                            <input type="text" value="" placeholder="Póstnúmer" class="gjafa_input" />
                                            <input type="text" value="" placeholder="Netfang" class="gjafa_input" />
                                        </div>
                                    </div>
                                </div>
                                <div class="gjafa_single_item">
                                    <div class="gjafa_heading_box">
                                        <h2 class="gjafa_heading">Afhending</h2>
                                    </div>
                                    <div class="gjafa_radio_options">
                                        <div class="gjafa_radio_item">
                                            <input type="radio" name="gjafa_radio_item" value="Senda gjafakort til greiðanda (1.915 kr.)" id="gjafa_radio_item" class="gjafa_radio_input">
                                            <label for="gjafa_radio_item" class="gjafa_radio_label">
                                                Senda gjafakort til greiðanda (1.915 kr.)
                                            </label>
                                        </div>
                                        <div class="gjafa_radio_item">
                                            <input type="radio" name="gjafa_radio_item" value="Sendu gjafakort til viðtakanda (1.915 kr.)" id="gjafa_radio_item" class="gjafa_radio_input">
                                            <label for="gjafa_radio_item" class="gjafa_radio_label">
                                                Sendu gjafakort til viðtakanda (1.915 kr.)
                                            </label>
                                        </div>
                                        <div class="gjafa_radio_item">
                                            <input type="radio" name="gjafa_radio_item" value="Gjafakort sótt á Þjónustuborð af greiðanda" id="gjafa_radio_item" class="gjafa_radio_input">
                                            <label for="gjafa_radio_item" class="gjafa_radio_label">
                                                Gjafakort sótt á Þjónustuborð af greiðanda
                                            </label>
                                        </div>
                                        <div class="gjafa_radio_item">
                                            <input type="radio" name="gjafa_radio_item" value="Gjafakort sótt á Þjónustuborð af viðtakanda" id="gjafa_radio_item" class="gjafa_radio_input" checked>
                                            <label for="gjafa_radio_item" class="gjafa_radio_label">
                                                Gjafakort sótt á Þjónustuborð af viðtakanda
                                            </label>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="gjafa_single_item">
                                    <div class="gjafa_sec_desc">
                                        Gjafakortin má sækja næsta virka dag á Þjónustuborð á 2. hæð (við hlið Nova) Þjónustuborðið er opið á almennum opnunartíma Kringlunnar sem sjá má á forsíðu Kringlan.is Afhendingartími gjafakorta í ábyrgðarpósti er 1-3 virkir dagar
                                    </div>
									<div style="display:flex;">
										<button type="button" class="gjafa_btn" onclick="gjafaBackToStepOne(this, event)" style="margin-top: 20px;margin-right:15px;">Til Baka</button>
                                    	<button type="button" class="gjafa_btn" onclick="gjafaCheckoutOneHandler(this, event)" style="margin-top: 20px;">Áfram</button>										
									</div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gift card in an envelope section  -->
        <section class="gjafa_sec_wrap" id="gjafa_sec_id_05" style="display:none;">
            <div class="gjafa_sec_container">
                <div class="gjafa_heading_box spacing_mb_30">
                    <h2 class="gjafa_heading left_spacing">Gjafakort í umslagi</h2>
                </div>
                <div class="gjafa_sec_row">
                    <div class="gjafa_sec_column gjafa_left_column">
                        <div class="image_box_item">
                            <figure class="img_wrap">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/image_03.png" alt="" class="img_thumb">
                            </figure>
                        </div>
                    </div>
                    <div class="gjafa_sec_column gjafa_right_column">
                        <div class="gjafa_column_contents">
                            <div class="gjafa_item_wrap">
                                <div class="gjafa_single_item">
                                    <div class="gjafa_heading_box">
                                        <h2 class="gjafa_heading">Upplýsingar um greiðanda</h2>
                                    </div>
                                    <div class="gjafa_btn_groups_box">
                                        <div class="gjafa_btn_groups">
                                            <input type="text" value="" placeholder="Heimilisfang" class="gjafa_input" />
                                            <input type="text" value="" placeholder="Kennitala" class="gjafa_input" />
                                            <input type="text" value="" placeholder="Símanúmer" class="gjafa_input" />
                                        </div>
                                        <div class="gjafa_btn_groups">
                                            <input type="text" value="" placeholder="Nafn" class="gjafa_input" />
                                            <input type="text" value="" placeholder="Póstnúmer" class="gjafa_input" />
                                            <input type="text" value="" placeholder="Netfang" class="gjafa_input" />
                                        </div>
                                    </div>
                                </div>
                                <div class="gjafa_single_item">
                                    <div class="gjafa_heading_box">
                                        <h2 class="gjafa_heading">Afhending</h2>
                                    </div>
                                    <div class="gjafa_radio_options">
                                        <div class="gjafa_radio_item">
                                            <input type="radio" name="gjafa_radio_item" value="Senda gjafakort til greiðanda (1.915 kr.)" id="gjafa_radio_item" class="gjafa_radio_input">
                                            <label for="gjafa_radio_item" class="gjafa_radio_label">
                                                Senda gjafakort til greiðanda (1.915 kr.)
                                            </label>
                                        </div>
                                        <div class="gjafa_radio_item">
                                            <input type="radio" name="gjafa_radio_item" value="Sendu gjafakort til viðtakanda (1.915 kr.)" id="gjafa_radio_item" class="gjafa_radio_input">
                                            <label for="gjafa_radio_item" class="gjafa_radio_label">
                                                Sendu gjafakort til viðtakanda (1.915 kr.)
                                            </label>
                                        </div>
                                        <div class="gjafa_radio_item">
                                            <input type="radio" name="gjafa_radio_item" value="Gjafakort sótt á Þjónustuborð af greiðanda" id="gjafa_radio_item" class="gjafa_radio_input">
                                            <label for="gjafa_radio_item" class="gjafa_radio_label">
                                                Gjafakort sótt á Þjónustuborð af greiðanda
                                            </label>
                                        </div>
                                        <div class="gjafa_radio_item">
                                            <input type="radio" name="gjafa_radio_item" value="Gjafakort sótt á Þjónustuborð af viðtakanda" id="gjafa_radio_item" class="gjafa_radio_input" checked>
                                            <label for="gjafa_radio_item" class="gjafa_radio_label">
                                                Gjafakort sótt á Þjónustuborð af viðtakanda
                                            </label>
                                        </div>
                                    </div>
                                </div>                                 
                                <div class="gjafa_single_item">
                                    <div class="gjafa_sec_desc">
                                        Gjafakortin má sækja næsta virka dag á Þjónustuborð á 2. hæð (við hlið Nova) Þjónustuborðið er opið á almennum opnunartíma Kringlunnar sem sjá má á forsíðu Kringlan.is Afhendingartími gjafakorta í ábyrgðarpósti er 1-3 virkir dagar
                                    </div>


									<div style="display:flex;">
										<button type="button" class="gjafa_btn" onclick="gjafaBackToStepOne(this, event)" style="margin-top: 20px;margin-right:15px;">Til Baka</button>
                                    	<button type="button" class="gjafa_btn" onclick="gjafaCheckoutOneHandler(this, event)" style="margin-top: 20px;">Áfram</button>										
									</div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
    
    <script src="<?php echo get_stylesheet_directory_uri();?>/assets/js/script.js?v=<?php echo time();?>"></script>

    <script>
        // Manual Input 2nd form validate and ajax call

        function gjafaCheckoutTwoHandler(button, event) {
            event.preventDefault();
            if (!validateGiftCardForm()) {
                return false;
            }

            const formData = prepareFormData();
            submitGiftCardOrder(formData);
        }

        function validateGiftCardForm() {
            let isValid = true;
            const errorMessages = [];

            // Validate recipient information
            const nameFields = document.querySelectorAll('input[name="gjafa_name_field[]"]');
            const emailFields = document.querySelectorAll('input[name="gjafa_email_field[]"]');
            const phoneFields = document.querySelectorAll('input[name="gjafa_telephone_field[]"]');
            const emailAndPhone = document.querySelector('input.gjafa_radio_item_email_and_phone:checked');


            nameFields.forEach((field, index) => {
                if (!field.value.trim()) {
                    errorMessages.push(`Vinsamlegast fylltu út nafn viðtakanda ${index + 1}`);
                    isValid = false;
                }
            });

            emailFields.forEach((field, index) => {
                const email = field.value.trim();
                if (!email) {
                    errorMessages.push(`Vinsamlegast fylltu út netfang viðtakanda ${index + 1}`);
                    isValid = false;
                } else if (!isValidEmail(email)) {
                    errorMessages.push(`Netfang viðtakanda ${index + 1} er ekki gilt`);
                    isValid = false;
                }
            });

            if (emailAndPhone) {
                phoneFields.forEach((field, index) => {
                    const phone = field.value.trim();
                    const phoneRegex = /^[0-9]{7,15}$/;
                    if (!phone) {
                        errorMessages.push(`Vinsamlegast fylltu út símanúmer viðtakanda ${index + 1}`);
                        isValid = false;
                    } else if (!phoneRegex.test(phone)) {
                        errorMessages.push(`Símanúmer viðtakanda ${index + 1} er ekki gilt`);
                        isValid = false;
                    }
                });
            }

            // Validate sender information
            const senderName = document.getElementById('gjafa_text_input');
            if (!senderName.value.trim()) {
                errorMessages.push('Vinsamlegast fylltu út nafn sendanda');
                isValid = false;
            }

            // Validate delivery time if "Veldu tíma" is selected
            const timeRadio = document.querySelector('input.gjafa_radio_getting_time:checked');
            if (timeRadio) {
                const dateInput = document.getElementById('gjafa_date_input');
                const timeInput = document.getElementById('gjafa_time_input');

                if (!dateInput.value) {
                    errorMessages.push('Vinsamlegast veldu dagsetningu fyrir sendingu');
                    isValid = false;
                }

                if (!timeInput.value) {
                    errorMessages.push('Vinsamlegast veldu tíma fyrir sendingu');
                    isValid = false;
                }
            }

            // Show error messages if any
            if (errorMessages.length > 0) {
                alert(errorMessages.join('\n'));
            }

            return isValid;
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function prepareFormData() {
            const formData = new FormData();

            // Get recipient information
            const names = document.querySelectorAll('input[name="gjafa_name_field[]"]');
            const emails = document.querySelectorAll('input[name="gjafa_email_field[]"]');
            const phones = document.querySelectorAll('input[name="gjafa_telephone_field[]"]');
            const amounts = document.querySelectorAll('input[name="gjafa_amount_field[]"]');

            const recipients = [];
            for (let i = 0; i < names.length; i++) {
                recipients.push({
                    name: names[i].value,
                    email: emails[i].value,
                    phone: phones[i].value,
                    amount: amounts[i].value
                });
            }

            formData.append('recipients', JSON.stringify(recipients));

            // Get message
            const message = document.querySelector('.gjafa_textarea').value;
            formData.append('message', message);

            // Get delivery timing
            const deliveryOption = document.querySelector('input[name="gjafa_radio_input_getting"]:checked').value;
            formData.append('delivery_option', deliveryOption);

            if (deliveryOption === 'Veldu tíma') {
                const date = document.getElementById('gjafa_date_input').value;
                const time = document.getElementById('gjafa_time_input').value;
                formData.append('delivery_date', date);
                formData.append('delivery_time', time);
            }

            // Get sender information
            const senderName = document.getElementById('gjafa_text_input').value;
            formData.append('sender_name', senderName);

            // Get notification preference
            const notificationPreference = document.querySelector('input[name="gjafa_radio_item_email_phone"]:checked').value;
            formData.append('notification_preference', notificationPreference);
            formData.append('action', 'process_gift_card_order');

            return formData;
        }

        function submitGiftCardOrder(formData) {
            // Show loading indicator
            const submitButton = document.querySelector('#gjafa_sec_id_03 .gjafa_btn[onclick="gjafaCheckoutTwoHandler(this, event)"]');
            const originalText = submitButton.textContent;
            submitButton.textContent = 'Vinsamlegast bíðið...';
            submitButton.disabled = true;

            // Make AJAX request
            const ajaxUrl = '<?php echo admin_url("admin-ajax.php"); ?>';
            fetch(ajaxUrl, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Redirect to payment page or show success message
                        alert('Pöntun tókst! Beðið er um greiðslu.');
                        console.log('Order data:', data.data);
                        // window.location.href = data.data.redirect_url; // Uncomment if you have a redirect URL
                    } else {
                        alert('Villa kom upp: ' + data.data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Villa kom upp við vinnslu pöntunar');
                })
                .finally(() => {
                    // Restore button state
                    submitButton.textContent = originalText;
                    submitButton.disabled = false;
                });
        }
    </script>
</body>
</html>
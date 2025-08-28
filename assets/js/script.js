function wxformatAmount(inputValue) {
    let cleanValue = inputValue.replace(/[^\d]/g, '');
    if (cleanValue === '') return '';

    let reversed = cleanValue.split('').reverse().join('');
    let parts = [];

    if (reversed.length > 0) {
        if (reversed.length >= 3) {
            parts.push(reversed.substr(0, 3).split('').reverse().join(''));
            reversed = reversed.substr(3);
        } else {
            parts.push(reversed.split('').reverse().join(''));
            reversed = '';
        }
    }

    if (reversed.length > 0) {
        if (reversed.length >= 2) {
            parts.push(reversed.substr(0, 2).split('').reverse().join(''));
            reversed = reversed.substr(2);
        } else {
            parts.push(reversed.split('').reverse().join(''));
            reversed = '';
        }
    }

    while (reversed.length > 0) {
        if (reversed.length >= 2) {
            parts.push(reversed.substr(0, 2).split('').reverse().join(''));
            reversed = reversed.substr(2);
        } else {
            parts.push(reversed.split('').reverse().join(''));
            reversed = '';
        }
    }

    return parts.reverse().join('.') + ' kr.';
}

function wxPriceInputOnInput(inputElement){
    // Save cursor position
    const cursorPosition = inputElement.selectionStart;
    const originalLength = inputElement.value.length;
    
    // Format the value
    const formatted = wxformatAmount(inputElement.value);
    inputElement.value = formatted.replace(' kr.', '');
    
    // Restore cursor position (adjust for added/removed characters)
    const newLength = inputElement.value.length;
    const lengthDiff = newLength - originalLength;
    inputElement.setSelectionRange(cursorPosition + lengthDiff, cursorPosition + lengthDiff);
}

function wxPriceInputOnFocus(inputElement){
    // Save current value without formatting
    const rawValue = inputElement.value.replace(/[^\d]/g, '');
    inputElement.value = rawValue;
}

function wxPriceInputOnBlur(inputElement){
    const formatted = wxformatAmount(inputElement.value);
    inputElement.value = formatted; // Keep full formatting with "kr."
}

let giftCardCounter = 1; 

function gjafaAddMoreItemshandler(button, event) {
	if(giftCardCounter>=20) return false;
    event.preventDefault();
    
    // Get the parent container where items should be added
    const addItemsGroup = button.closest('.gjafa_add_items_groups');
    const inputBoxItems = addItemsGroup.querySelector('.gjafa_input_box_items');
    
    const newItemBox = document.createElement('div');
    newItemBox.className = 'gjafa_input_item_box';
    newItemBox.innerHTML = `
        <div class="gjafa_input_item">
            <span class="input_label">Veldu upphæð</span>
			<input type="text" name="gjafa_pice_input[${giftCardCounter}]" value="" 
			oninput="wxPriceInputOnInput(this)" 
			onblur="wxPriceInputOnBlur(this)" 
			onfocus="wxPriceInputOnFocus(this)" 
			placeholder="t.d. 10.000 kr." 
			id="gjafa_pice_input[0]" 
			class="gjafa_input gjafa_pice_input">
        </div>
        <div class="gjafa_input_item">
            <span class="input_label">Skráðu fjölda</span>
            <input type="number" name="gjafa_qty_input[${giftCardCounter}]" value="1" class="gjafa_input gjafa_qty_input">
        </div>
        <button type="button" class="gjafa_remove_btn" onclick="removeGiftCardItem(this)">X</button>
    `;

    
    inputBoxItems.appendChild(newItemBox);
    
    giftCardCounter++;
}

function wxParseAmount(formattedString) {
    if (!formattedString || formattedString.trim() === '') return '';
    
    // Remove "kr." and any other non-digit characters except dots
    let cleanString = formattedString.replace(' kr.', '').trim();
    
    // Remove all dots and return the pure number string
    return cleanString.replace(/\./g, '');
}

// Function to remove a gift card item
function removeGiftCardItem(button) {
    const itemBox = button.closest('.gjafa_input_item_box');
    if (itemBox) {
        itemBox.remove();
        giftCardCounter--;
        
        const markAmount = document.querySelector('.mark_amount');
        if (markAmount) {
            markAmount.textContent = `Hámark 100 (${giftCardCounter}/100)`;
        }
    }
}

function gjafaUpdateDataHandler(button, event) {
    event.preventDefault();
    
    // Validate quantity inputs
    const qtyInputs = document.querySelectorAll('.gjafa_qty_input');
    let totalQuantity = 0;
    let hasEmptyQty = false;
    
    qtyInputs.forEach(input => {
        if (!input.value || input.value.trim() === '' || Number(input.value) < 1) {
            hasEmptyQty = true;
        }
        totalQuantity += Number(input.value) || 0;
    });
    
    if (hasEmptyQty) {
        alert("Fjöldi korta þarf að vera meiri en 1");
        return false;
    }
    
    // Validate price inputs
    const priceInputs = document.querySelectorAll('.gjafa_pice_input');
    let hasEmptyPrice = false;
    let priceTotal = 0;
    priceInputs.forEach(input => {
        if (!input.value || input.value.trim() === '') {
            hasEmptyPrice = true;
        }
		
		priceTotal += Number(wxParseAmount(input.value));
    });
    
    if (hasEmptyPrice) {
        alert("Upphæð má ekki vera tóm");
        return false;
    }
    
	const no_of_cards = document.querySelectorAll('.no_of_cards');
	no_of_cards.forEach(span => {
        span.innerHTML = totalQuantity;
    });
	
	const gjafa_pdf_price = document.querySelectorAll('.gjafa_pdf_price');
	gjafa_pdf_price.forEach(span => {
        span.innerHTML = wxformatAmount(priceTotal.toString());
    });
	
	const checkedValue = document.querySelector('input[name="gjafa_card_type"]:checked').value;
	if(checkedValue == 'Rafrænt gjafakort'){
		// Proceed with logic if validation passes
		if (totalQuantity >= 20) {
			document.getElementById('receipent_info_area').innerHTML = '';
			document.getElementById('gjafa_sec_id_02').style.display = 'block';
			document.getElementById('gjafa_sec_id_03').style.display = 'none';
			document.getElementById('gjafa_sec_id_01').style.display = 'none';
			document.getElementById('gjafa_sec_id_04').style.display = 'none'; 
			document.getElementById('gjafa_sec_id_05').style.display = 'none';
		} else {	
			document.getElementById('gjafa_sec_id_03').style.display = 'block';
			document.getElementById('gjafa_sec_id_02').style.display = 'none';
			document.getElementById('gjafa_sec_id_01').style.display = 'none';
			document.getElementById('gjafa_sec_id_04').style.display = 'none'; 
			document.getElementById('gjafa_sec_id_05').style.display = 'none';
		}
	}
	
	if(checkedValue == 'Gjafakort í umslagi'){			
			document.getElementById('gjafa_sec_id_01').style.display = 'none';
			document.getElementById('gjafa_sec_id_02').style.display = 'none';
			document.getElementById('gjafa_sec_id_03').style.display = 'none';
			document.getElementById('gjafa_sec_id_05').style.display = 'none'; 
			document.getElementById('gjafa_sec_id_04').style.display = 'block';
	}
	
	if(checkedValue == 'Gjafakort í spilastokki'){		
			document.getElementById('gjafa_sec_id_01').style.display = 'none';
			document.getElementById('gjafa_sec_id_02').style.display = 'none';
			document.getElementById('gjafa_sec_id_03').style.display = 'none';
			document.getElementById('gjafa_sec_id_04').style.display = 'none'; 
			document.getElementById('gjafa_sec_id_05').style.display = 'block';
		
	}
		
	gjafaReceipientInfo(totalQuantity);
    return true;
}

function wxUpdateGiftCardMessage(textarea) {
    const displayDivs = document.querySelectorAll('.gift_card_message_text');
    
    displayDivs.forEach(div => {
        div.innerHTML = textarea.value.replace(/(<([^>]+)>)/gi, "").replace(/\n/g, '<br/>');
    });
}

function gjafaReceipientInfo(qty) {
    const priceInputs = document.querySelectorAll('.gjafa_pice_input');
    const qtyInputs   = document.querySelectorAll('.gjafa_qty_input');

    let amountDistribution = [];

    priceInputs.forEach((priceInput, index) => {
        const amount = wxParseAmount(priceInput.value);
        const quantity = parseInt(qtyInputs[index].value) || 0;

        // Add this amount for the specified quantity
        for (let i = 0; i < quantity; i++) {
            amountDistribution.push(amount);
        }
    });

    // Now generate the HTML with the correct amounts
    let html = '';
    for (let i = 0; i < qty; i++) {
        const amount = i < amountDistribution.length ? amountDistribution[i] : '';

        html += `<div class="gjafa_input_item_groups">
            <div class="gjafa_input_item">
                <input type="text" name="gjafa_name_field[]" id="gjafa_name_field_${i}" placeholder="Nafn" class="gjafa_input">
            </div>
            <div class="gjafa_input_item">
                <input type="email" name="gjafa_email_field[]" id="gjafa_email_field_${i}" placeholder="Netfang" class="gjafa_input">
            </div>
            <div class="gjafa_input_item">
                <input type="tel" name="gjafa_telephone_field[]" id="gjafa_telephone_field_${i}" placeholder="Símanúmer" class="gjafa_input">
            </div>
            <div class="gjafa_input_item">
                <input type="hidden" name="gjafa_amount_field[]" value="${amount}" class="gjafa_input">
            </div>
        </div>`;
    }

    document.getElementById('receipent_info_area').innerHTML = html;
}

function gjafaBackToStepOne(button, event){
	document.getElementById('gjafa_sec_id_01').style.display = 'block';
	document.getElementById('gjafa_sec_id_02').style.display = 'none';
	document.getElementById('gjafa_sec_id_03').style.display = 'none';
	document.getElementById('gjafa_sec_id_04').style.display = 'none';
	document.getElementById('gjafa_sec_id_05').style.display = 'none';
}

function gjafaCheckoutOneHandler(button, event){
	alert("Further tasks under progress!");
}
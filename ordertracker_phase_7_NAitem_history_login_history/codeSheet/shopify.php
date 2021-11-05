<!--****************************************************************************
                                 APP USED
******************************************************************************** -->
Better Reports = sa pag hugot ng reports ng order (NOT FREE)
Easy FAQ by ndnapps = para sa pa lagay ng FAQs (FREE)
Judge.me Product Reviews = for review management (FREE)
Recipe Kit = for recipe (NOT FREE)
Simple Contact Us Form = using to contact via email for concern (FREE)
tawk.to Live Chat = for live chat (FREE)

<!--****************************************************************************
        additional field in cart.template.liquid in <div class="cart__footer">
******************************************************************************** -->
<p class="cart-attribute__field senior-label">
                <h6 class="senior-subtitle">We'll give you a discount upon delivery.</h6>
              
              	<select id="specialdiscountcustom" name="attributes[Special Discount]">
                  <option value="Regular Customer"{% if cart.attributes["Regular Customer"] == "Regular Customer" %} selected{% endif %}>Regular Customer</option>
                  
                  <option value="Senior Citizen"{% if cart.attributes["Special Discount"] == "Senior Citizen" %} selected{% endif %}>Senior Citizen</option>
                  
                  <option value="PWD"{% if cart.attributes["Special Discount"] == "PWD" %} selected{% endif %}>PWD</option>
                  
                  <option value="Gift Cert"{% if cart.attributes["Special Discount"] == "Gift Cert" %} selected{% endif %}>Gift Cert</option>
                  
                  <option value="QPoints"{% if cart.attributes["Special Discount"] == "QPoints" %} selected{% endif %}>QPoints</option>
                </select>
                
              	<input onkeypress="return isNumberKey(event);" id="are-you-a-senior" type="text" name="attributes[Card/ID Number]" value="{{ cart.attributes["Card/ID Number"] }}" placeholder="Card/Mobile/ID Number">
</p>
<!--****************************************************************************
        property note , insert below code
        <select name="id" id="ProductSelect-{{ section.id }}" class="product-form__variants no-js">
              {% for variant in product.variants %}
                <option value="{{ variant.id }}"
                  {%- if variant == current_variant %} selected="selected" {%- endif -%}
                >
                  {{ variant.title }}  {%- if variant.available == false %} - {{ 'products.product.sold_out' | t }}{% endif %}
                </option>
              {% endfor %}
        </select>

        in product-template.liquid
******************************************************************************** -->
{% if section.settings.show_quantity_selector %}
              <div class="product-form__controls-group">
                <div class="product-form__item">
                    <label for="Quantity-{{ section.id }}">{{ 'products.product.quantity' | t }}</label>
                    <input type="number" id="Quantity-{{ section.id }}"
                      name="quantity" value="1" min="1" pattern="[0-9]*"
                      class="product-form__input product-form__input--quantity" data-quantity-input
                    >
                  
                  	<label for="note">Note:</label>
                	<textarea id="note" name="properties[Note]" placeholder="add a note on this product"></textarea>
                </div>
              </div>
{% endif %}

<!--****************************************************************************
        Terms and condition code , insert below code

        <div class="cart__shipping rte">{{ taxes_shipping_checkout }}. Prices may vary depends on actual weight of the store and may confirm the actual price by our representative</div>
            <div class="cart__buttons-container">

            in cart-tempalte.liquid
******************************************************************************** -->

<p id="chk-term" style="float: none; text-align: right; clear: both; margin: 10px 0;">
                <input style="float:none; vertical-align: middle;" type="checkbox" id="agree" />
                <label style="display:inline; float:none" for="agree">
                  I agree with the <a href="/pages/terms-of-privacy" style="color: #2cae5d;">terms and conditions</a>.
                </label>
</p>




<!--********************************************************************************************
        special intruction code for shopify in cart.template.liquid in <div class="cart__footer">
*********************************************************************************************** -->
<textarea name="note" id="CartSpecialInstructions" class="cart-note__input" placeholder="Add a general note for your order / Land Mark" data-cart-notes>{{ cart.note }}</textarea>

<!--********************************************************************************************
                            JOSE PACHECO CODED IN SHOPIFY
*********************************************************************************************** -->
============================
product-template
============================

<div class="product-form__controls-group">
                <div class="product-form__item">
                  <label for="Quantity-{{ section.id }}">{{ 'products.product.quantity' | t }}</label>
                  <input type="number" id="Quantity-{{ section.id }}"
                    name="quantity" value="1" min="1" pattern="[0-9]*"
                    class="product-form__input product-form__input--quantity" data-quantity-input
                  >
                  <br>
                  
                <label for="note">Note:</label>
                <textarea id="note" name="properties[Note]" placeholder="add a note on this product"></textarea> 
                </div>
              </div>

<!-- <div class="qtydiv">
          <label for="Quantity" class="quantity-selector">Quantity</label>
          <div class="qtybox">
            <span class="btnqty qtyminus icon icon-minus">-</span>
            <input type="text" id="quantity" name="quantity" value="1" min="1" class="quantity-selector quantity-input" readonly="">
            <span class="btnqty qtyplus icon icon-plus">+</span>
          </div>
        </div> -->


============================
cart-template
============================
<div class="grid__item medium-up--one-half cart-note">
              
              <p class="cart-attribute__field senior-label">
                <h6 class="senior-subtitle">We'll give you a discount upon delivery.</h6>
              
              	<select id="specialdiscountcustom" name="attributes[Special Discount]">
                  <option value="Regular Customer"{% if cart.attributes["Regular Customer"] == "Regular Customer" %} selected{% endif %}>Regular Customer</option>
                  <option value="Senior Citizen"{% if cart.attributes["Special Discount"] == "Senior Citizen" %} selected{% endif %}>Senior Citizen</option>
                  <option value="PWD"{% if cart.attributes["Special Discount"] == "PWD" %} selected{% endif %}>PWD</option>
                  <option value="Gift Cert"{% if cart.attributes["Special Discount"] == "Gift Cert" %} selected{% endif %}>Gift Cert</option>
                  <option value="QPoints"{% if cart.attributes["Special Discount"] == "QPoints" %} selected{% endif %}>QPoints</option>
                </select>
                
              	<input onkeypress="return isNumberKey(event);" id="are-you-a-senior" type="text" name="attributes[Card/ID Number]" value="{{ cart.attributes["Card/ID Number"] }}" placeholder="Enter Card/ID Number">
              </p>
              
              
             
              <textarea name="note" id="CartSpecialInstructions" class="cart-note__input" placeholder="Add a general note for your order" data-cart-notes>{{ cart.note }}</textarea>
          		  
          </div>


============================
cart-template
============================
<p id="chk-term" style="float: none; text-align: right; clear: both; margin: 10px 0;">
                <input style="float:none; vertical-align: middle;" type="checkbox" id="agree" />
                <label style="display:inline; float:none" for="agree">
                  I agree with the <a href="/pages/terms-of-service" style="color: #2cae5d;">terms and conditions</a>.
                </label>
              </p>

note: put this code just below: <div class="cart__buttons-container">


============================
theme.scss
============================
button.qsc-btn.qsc-btn--stickycart.qsc-btn--has-shadow.pos-mobile-bottom_left {
	width: 60px !important;
    height: 60px !important;
}

p.cart-attribute__field.senior-label {
    margin: 0;
}

select#specialdiscountcustom {
    margin-bottom: 10px;
}


============================
theme.js
============================
$(document).ready(function() {
  
    $('body').on('click', '[name="checkout"], [name="goto_pp"], [name="goto_gc"]', function() {
      
        if ($('#agree').is(':checked')) {

          $(this).submit();

        } else {

          $("#chk-term a").css({"color": "red"});
          $("#chk-term").css({"color": "red"});

          alert("You must agree with the terms and conditions of sales to check out. Tick the checkbox below.");
          return false;
        }
    });
  
  	console.log('theme.js');
});




$(document).ready(function() {
    
  
  $("div#ndnappseasyfaqs-wrapper p.copyright a").css({"display": "none"});
  
  
});


//min and max
if (cust_subtotal_trimmed < 500) {
        
      	alert("Cart total should be minimum of 500 peso worth of purchased.");
        return false;
        
      }


function isNumberKey(evt)
{
  var charCode = (evt.which) ? evt.which : event.keyCode;
//  console.log(charCode);
    if (charCode != 46 && charCode != 45 && charCode != 32 && charCode > 31
    && (charCode < 48 || charCode > 57))
     return false;

  return true;
}

// prevent download image
$("html").on("contextmenu",function(e){
       return false;
});


$(document).keydown(function (event) {
  if (event.keyCode == 123) { // Prevent F12
    return false;
  } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I        
    return false;
  }   
});



<!--********************************************************************************************
                            Create Cookie Consent Banner
                            use this to create a pop up a box for terms and condition
                            any page mag pop up sya hanggay hindi mo inaaccept
*********************************************************************************************** -->
cookie consent generator

https://www.websitepolicies.com/create/cookie-consent-banner
<?php $isEnabledTranslate = MainHelper::IsModuleEnabledByTag('translations');

$headerName=''; ?>

<ul class="horizontal_tabs clearfix">
	<li >
		<a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES);?>" class="icon_link">
		<i class="games_tab_icon"></i><?php echo $this->__('Notices'); ?></a>
	</li>
	<li>
		<a href="<?php echo  MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES); ?>" class="icon_link">
		<i class="games_tab_icon"></i><?php echo $this->__('My Notices'); ?></a>
	</li>
	<li class="active">
		<a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_CREATE_NOTICES);?>" class="icon_link">
		<i class="games_tab_icon"></i><?php echo $this->__('Create Notice'); ?></a>
	</li>
    <li>
		<a  href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_BUYCREDITS);?>" class="icon_link">
        <i class="games_tab_icon"></i><?php echo $this->__('Credits');?></a>
	</li>
	
	<li>
		<a  href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_TRANSACTIONS);?>" class="icon_link" >
        <i class="games_tab_icon"></i><?php echo $this->__('Transactions');?></a>
	</li>

</ul>

<!-- header -->
<!-- Company list start -->
<div class="list_container filter_options">
	<!-- Company search start 
	<form method="GET" id="inside_search" class="c_column_search clearfix">
	<input type="hidden" id="form_url" value="http://playnation.eu/companies/search">
		<input type="text" id="inside_search_txt" class="c_column_search_input withLabel" title="Search for companies..." value="Search for companies...">
		<input type="submit" value="Search" class="c_column_search_button green">
	</form>

	 Company search end -->
		<div class="list_header">
			<h1><?php echo $headerName;?></h1>
		</div>

<div class="rc_create_notice">

<script>

$(document).ready( function() {
	
	$('.sale_pay').hide();
	$('.pay_type').hide();
	$('.auction_op').hide();
	$('.price_cur').hide();
	$('.mycurrency').hide();
	 $('#showtype').hide();	
	 
  $('#noticetype').bind('change', function (e) { 
     if( $('#noticetype').val() == 'trade') {
		 
    $('.sale_pay').hide();
	$('.auction_op').hide();
	$('.price_cur').hide();
	$('.pay_type').hide();
    $('#showtype').hide();
	$('.mycurrency').hide();
	 }
	if( $('#noticetype').val() == 'buy') {
      $('.pay_type').show();
	  $('#showtype').show();
	    $('.mycurrency').hide();
		  $('.auction_op').hide();
		  $('.sale_pay').hide();
    }
	if( $('#noticetype').val() == 'sell') {
      $('.sale_pay').show();
    }
	
  });
  
   $('#saletype').bind('change', function (e) {
	    
  if( $('#saletype').val() == 'buynow') {
       $('#showtype').show();
	  $('.pay_type').show();
	  $('.auction_op').hide();
    }
	if( $('#saletype').val() == 'auction') {
      $('.auction_op').show();
	  $('.price_cur').hide();
	    $('.mycurrency').hide();
		$('.pay_type').hide();
		  $('#showtype').hide();
    }
   });
   
     $('#paymenttype').bind('change', function (e) {
	    
  if( $('#paymenttype').val() == 'credits') {
      $('.price_cur').show();
	  $('.auction_op').hide();
	   $('.mycurrency').hide();
    }
	if( $('#paymenttype').val() == 'none') {
      $('.price_cur').show();
	  $('.mycurrency').show();
    }
   });
});


</script>


<script type="text/javascript">
	function verify() {
		show_alert = '';
		//alert(document.getElementById('insert_category').value);
		if (document.getElementById('owner').value=='') {
			show_alert = 'You have to be Logged in to create a notice ';
		}
		if (document.getElementById('category').value=='') {
			if (show_alert!='') {
				show_alert+= ' and you must choose a Category!';
			} else {
				show_alert = 'You must choose a Category!';
			}
			
			
			
		} else {
			if (show_alert!='') {
				show_alert += '!';
			}
			
					
			
		}
		var link_redirect = document.getElementById('link_create').value;
		if (show_alert!='') {
			alert(show_alert);
			
		} else {
			document.getElementById("cnForm").submit(); 
		}
	}
	function verify_new_category(object) {
		show_alert = '';
		
		alert(document.getElementById('insert_category').value);
		if (document.getElementById('owner').value=='') {
			show_alert = 'You have to be Login to create a notice ';
		}
		if (document.getElementById('new_category').value=='') {
			if (show_alert!='') {
				show_alert+= ' and ou must type a description for new Category!';
			} else {
				show_alert = 'You must type a description for new Category!';
			}
		} else {
			if (show_alert!='') {
				show_alert += '!';
			}
		}
		var link_redirect = document.getElementById('link_create').value;
		if (show_alert!='') {
			alert(show_alert);
			
		} else {
			//document.getElementById("cnForm").submit(); 
			window.location.href = 'create_notices/notices/savecategory';
		}
	}
	function insertcategory()
	{
		document.getElementById('button_category').value = '1';
		document.getElementById("cnForm").submit();
	}
</script>

<script>

$(document).ready(function(){
	
 $( ".show_dropdown" ).hide();
  $(".add_cat").click(function(){
  $( ".show_hide" ).hide();
    $( ".show_dropdown" ).slideDown( "slow" );
  
});

 $(document).on('click', '.close', function(){
        $(this).parent().slideUp("slow");
		$( ".show_hide" ).hide();
    });


 }); 
  

</script>









<div id="params" ></div>
<div id="demoWrapper">

			<h5 id="status"></h5>
            
           <!--Owner Type--> 
            
			<form id="liveForm" action="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_CREATE_NOTICES.'/notices/create'); ?>" method="post" class="bbq ">
				
                <div id="fieldWrapper">
                
				<!-- <span class="step2" id="first">-->
					<!-- 	<span class="form_widget_upgrade"></span>-->
                    
                     <!--User Type starts --> 
                     
						
                        <p class="form_widget_upgrade"><?php echo $this->__('1. Select user type & notice type');?></p>
                        <br/>
                            <br/>
                        
                         
                         
                        <label class="respond_label" name="user">User Type</label>
                        
                        
						    <select  class="response_sel"  style="width:150px;height:25px;" valign="top" id="owntype" name="owntype" >
							<option value="Select Ownertype" >&nbsp;</option>
						  
                        <option value="player" <?php echo $ownertype == 'player' ? 'selected="selected"' : ''; ?>>
                        <?php echo $this->__('Player'); ?>
                        </option> 
                           
                           
						    <option value="group" <?php echo $ownertype == 'group' ? 'selected="selected"' : ''; ?>><?php echo $this->__('Group'); ?></option>
						</select> 
					
						
						 
                        <!--Notice type --> 
                         
                         <label class="respond_label" >Notice Type</label>
                         
						<select class="response_sel" valign="top" style="width:150px;height:25px;" id="noticetype" name="noticetype" size>
							<option  selected="selected" value="0">Select type
							</option>									
								<option  value="sell"> <?php echo $this->__('Sell'); ?></option>
								<option value="buy"><?php echo $this->__('Buy'); ?></option>
								<option value="trade"><?php echo $this->__('Trade'); ?></option>
						</select> 
					
					<input name="owner" class="step" value="<?php echo $ownerid; ?>" id="owner" type="hidden" readonly>
                        
                        <input name="createdtime" class="step" value="<?php echo date("dmyHi"); ?>" id="createdtime" type="hidden" readonly>
                       
						
				    <br/>
					<br />
					
	<br />
                    
					
                  
                    
                    
						<p class="form_widget_upgrade"><?php echo $this->__('2. Select a Category');?>  
                        </p>
						<br/>
                        
                        <!--category  --> 
                        
						<?php $categoryID = Buyselltrade::getCategoryByID($category); ?>
						  
                         
                        <label class="respond_label" >Category</label>
                        
						<select  class="response_sel" id="category" valign="top" style="width:150px;height:25px;" id="category" name="category">
							<option value="0">&nbsp;
							</option>
									<?php if(isset($categoryList) and !empty($categoryList)) {
										foreach ($categoryList as $item) { ?>
                                     
				<option <?php echo $item->CategoryName == 'Books' ? 'selected="selected"' : '' ; ?> 
                value="<?php echo $item->ID_CATEGORY; ?>">
				<?php echo $item->CategoryName; ?></option>
                
                
											
									<?php } ?>
								<?php } ?>	
                                
						</select> 
                        
                      
                       
                        
    <ul class="add_cat">
    <li class="add1"><a href="#" class="btn_add">Add New</a></li>
    <li class="show_dropdown">
    

                        
						<a href="#" class="close">x</a>
                        <br />
						<label id="add" >Add a Category <span class="blue2">(English)</span></label>
                        &nbsp;<input name="new_category" class="step" 
                        value="<?php // echo
						//onClick="test();" ?>" id="new_category" type="text"/p>
                        &nbsp;<input class="rounded_gray" id="insert_category" 
                        value="<?php echo $this->__('Insert'); ?>" type="button" onClick="insertcategory();" />
                        </p>
						<input name="button_category" value="" id="button_category" type="hidden">
						
						
                      
       
        </li>
</ul>
    
    
    
    
    <br />
    

                        
						
						<?php $langs = Lang::getLanguages(); $currentLang = Lang::getCurrentLangID(); $selectedLang = Lang::getLangById($currentLang);?>
						<?php if($isEnabledTranslate == 1): ?>
                        
                        
                        
                        
		<p class="form_widget_upgrade"><?php echo $this->__('3. Select a language and Country');?></p>
        <br /><br />
                        <label class="respond_label" >Language</label>
						<select class="response_sel" id="language" valign="top" style="width:150px;height:25px;" id="language" name="language">
							<option value="0">&nbsp;
							</option>
									<?php foreach($langs as $lang):?>
                  <option value="<?php echo $lang->ID_LANGUAGE; ?>" <?php echo $lang->ID_LANGUAGE == $currentLang ? 'selected="selected"' : ''; ?>><?php echo $lang->NativeName; ?>
									</option>
								<?php endforeach;?>
						</select> 
						
						<?php endif; ?>
                        <?php $country != '' ? $countries = Buyselltrade::getCountryByID($country) : ''; ?>
                        
                        <label class="respond_label" >Country</label>
						<select  valign="top" id="country" style="width:150px;height:25px;" name="country" class="response_sel">
							<option value="0">&nbsp;
							</option>
							<?php if(isset($countryList) and !empty($countryList)) {
									foreach ($countryList as $item) { ?>
									<option value="<?php echo $item->ID_COUNTRY; ?>"><?php echo $item->Country; ?>
                                    <?php echo $item->Country == 'DENMARK' ? 'selected="selected"' : '' ; ?> 
									</option>
								<?php } ?>
							<?php } ?>			
						</select> 
					
					<br />
                    <br />
                <!--sale_pay starts --> 
                             
					<div class="sale_pay">
							
								       
                     
						
                        <p class="form_widget_upgrade"><?php echo $this->__('4. Select sale type');?></p>
                        <br/>
                        <br />
                         
                        <label class="respond_label">Type of Sale</label>
                        
                        
						<select  class="response_sel"  id="saletype" style="width:140px;height:25px;" valign="top" name="saletype" >
						
                        
                        <option value="Select Saletype" selected="selected">Select type</option>
						  
                        <option value="buynow"> <?php echo $this->__('Buy Now'); ?> </option> 
                       
                       <option value="auction" <?php //echo $saletype == 'Auction' ? 'selected="selected"' : ''; ?>>
					   <?php echo $this->__('Auction'); ?></option>
                       
						</select> 
					 <br/>
                        <br />
                          <br />
						</div>
                        
                         <p class="form_widget_upgrade" id="showtype"><?php echo $this->__('4. Select payment type');?></p>
                        
                        <div class="pay_type">
						 <br /><br />
                         <!-- Payment Type starts-->
                       	 
                        <label id="paytype" class="respond_label" >Payment type</label>
                           <select  class="response_sel" style="width:100px;height:25px;" valign="top" id="paymenttype" name="paymenttype" >
							<option value="Select paymenttype" >Select type</option>
						  
                        <option value="credits" <?php //echo $saletype == 'Buy Now' ? 'selected="selected"' : ''; ?>>
                        <?php echo $this->__('Credits'); ?>
                        </option> 
                           
                           
						    <option value="none" <?php //echo $saletype == 'Auction' ? 'selected="selected"' : ''; ?>><?php echo $this->__('None'); ?></option>
						</select> 
                         <br />
               <br />  <br />
    </div>         
                         
                       
                     
					
	
                    
					    <!-- Auction starts --> 
                        
                     <div class="auction_op">
                     
                         <br />     
               <br />
    
						
                        <p class="form_widget_upgrade"><?php echo $this->__('5. Auction Options');?></p>
                        <br/><br/>
                        
                        <label class="respond_label" >Starting bid</label>
                         <input id="startprice" name="startprice" class="input_info" type="text" />
                         
                         
                          <label class="respond_label" >Auction starts</label>
                          <input name="price" class="input_info" type="text" style="width:30px;" />
                          <br /><br />
                         <label class="respond_label" >Minimum Price</label>
                         <input id="minprice" name="minprice" class="input_info" type="text" />
                         
                          <label  class="respond_label" >Auction ends&nbsp;&nbsp;</label>
                         <input name="auctionends" class="input_info" type="text" style="width:30px;" />
                         <br /><br />
                         <label class="respond_label" >Buy now Price</label>
                         <input name="currentprice" id="currentprice" class="input_info" type="text"  />
                          <br /><br />
                         </div>
                       <!--currency  -->
                       
    
                        
                        <!--  Price and currency starts --> 
                     <div class="price_cur">
						
                        <p class="form_widget_upgrade"><?php echo $this->__('5. Select Price');?></p>
                        <br/>
                        
                         <label class="respond_label" >Price&nbsp;</label>
                         <input name="currentprice" id="cur_price" class="input_info" type="text" />
                       
                     </div>
                     
                     <div class="mycurrency">  
                              <label id="curry" class="respond_label" >Currency</label>&nbsp;
							
                             <select  class="response_sel"  id="currency" style="width:130px;height:25px;" valign="top"  name="currency" >
		
						  
           <option value="EUR" selected="selected">Euro - EUR</option>
          <option value="USD" >United States Dollars - USD</option>
          <option value="GBP">United Kingdom Pounds - GBP</option>
          <option value="CAD">Canada Dollars - CAD</option>
          <option value="AUD">Australia Dollars - AUD</option>
          <option value="JPY">Japan Yen - JPY</option>
          <option value="INR">India Rupees - INR</option>
          <option value="NZD">New Zealand Dollars - NZD</option>
          <option value="CHF">Switzerland Francs - CHF</option>
          <option value="ZAR">South Africa Rand - ZAR</option>
          <option value="DZD">Algeria Dinars - DZD</option>
          <option value="USD">America (United States) Dollars - USD</option>
          <option value="ARS">Argentina Pesos - ARS</option>
          <option value="AUD">Australia Dollars - AUD</option>
          <option value="BHD">Bahrain Dinars - BHD</option>
          <option value="BRL">Brazil Reais - BRL</option>
          <option value="BGN">Bulgaria Leva - BGN</option>
          <option value="CAD">Canada Dollars - CAD</option>
          <option value="CLP">Chile Pesos - CLP</option>
          <option value="CNY">China Yuan Renminbi - CNY</option>
          <option value="CNY">RMB (China Yuan Renminbi) - CNY</option>
          <option value="COP">Colombia Pesos - COP</option>
          <option value="CRC">Costa Rica Colones - CRC</option>
          <option value="HRK">Croatia Kuna - HRK</option>
          <option value="CZK">Czech Republic Koruny - CZK</option>
          <option value="DKK">Denmark Kroner - DKK</option>
          <option value="DOP">Dominican Republic Pesos - DOP</option>
          <option value="EGP">Egypt Pounds - EGP</option>
          <option value="EEK">Estonia Krooni - EEK</option>
          <option value="EUR">Euro - EUR</option>
          <option value="FJD">Fiji Dollars - FJD</option>
          <option value="HKD">Hong Kong Dollars - HKD</option>
          <option value="HUF">Hungary Forint - HUF</option>
          <option value="ISK">Iceland Kronur - ISK</option>
          <option value="INR">India Rupees - INR</option>
          <option value="IDR">Indonesia Rupiahs - IDR</option>
          <option value="ILS">Israel New Shekels - ILS</option>
          <option value="JMD">Jamaica Dollars - JMD</option>
          <option value="JPY">Japan Yen - JPY</option>
          <option value="JOD">Jordan Dinars - JOD</option>
          <option value="KES">Kenya Shillings - KES</option>
          <option value="KRW">Korea (South) Won - KRW</option>
          <option value="KWD">Kuwait Dinars - KWD</option>
          <option value="LBP">Lebanon Pounds - LBP</option>
          <option value="MYR">Malaysia Ringgits - MYR</option>
          <option value="MUR">Mauritius Rupees - MUR</option>
          <option value="MXN">Mexico Pesos - MXN</option>
          <option value="MAD">Morocco Dirhams - MAD</option>
          <option value="NZD">New Zealand Dollars - NZD</option>
          <option value="NOK">Norway Kroner - NOK</option>
          <option value="OMR">Oman Rials - OMR</option>
          <option value="PKR">Pakistan Rupees - PKR</option>
          <option value="PEN">Peru Nuevos Soles - PEN</option>
          <option value="PHP">Philippines Pesos - PHP</option>
          <option value="PLN">Poland Zlotych - PLN</option>
          <option value="QAR">Qatar Riyals - QAR</option>
          <option value="RON">Romania New Lei - RON</option>
          <option value="RUB">Russia Rubles - RUB</option>
          <option value="SAR">Saudi Arabia Riyals - SAR</option>
          <option value="SGD">Singapore Dollars - SGD</option>
          <option value="SKK">Slovakia Koruny - SKK</option>
          <option value="ZAR">South Africa Rand - ZAR</option>
          <option value="KRW">South Korea Won - KRW</option>
          <option value="LKR">Sri Lanka Rupees - LKR</option>
          <option value="SEK">Sweden Kronor - SEK</option>
          <option value="CHF">Switzerland Francs - CHF</option>
          <option value="TWD">Taiwan New Dollars - TWD</option>
          <option value="THB">Thailand Baht - THB</option>
          <option value="TTD">Trinidad and Tobago Dollars - TTD</option>
          <option value="TND">Tunisia Dinars - TND</option>
          <option value="TRY">Turkey Lira - TRY</option>
          <option value="AED">United Arab Emirates Dirhams - AED</option>
          <option value="GBP">United Kingdom Pounds - GBP</option>
          <option value="USD">United States Dollars - USD</option>
          <option value="VEB">Venezuela Bolivares - VEB</option>
          <option value="VND">Vietnam Dong - VND</option>
          <option value="ZMK">Zambia Kwacha - ZMK</option>
        </select>
					
						
					
                
					<br />
					
	<br />                
                             	  
                                
                            <!--mycurency ends here-->	
                        </div>
                        
                            
                               
				
						
					
						<p class="form_widget_upgrade">
										
									4. Enter your Text
					
						</p>
						<br />
						
						<textarea name="headline" id="headline" rows="1" cols="80" value="<?php echo $headline; ?>">Headline</textarea>
						<br /><br />
					
						<textarea name="details" id="details" rows="5" cols="80" value="<?php echo $details; ?>">Description...</textarea>
					
						
				</div>
				<div id="demoNavigation">
				
				<input id="link_create" name="link_create" type="hidden" value="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_CREATE_NOTICES.'/notices/').'create'; ?>">
					<?php //<input class="rounded_5 navigation_button green" id="back" value="Back" type="reset" />  onClick="verify(this);" ?>
					<input class="rounded_gray" id="next" name="next" value="<?php echo $this->__('Create Notice'); ?>" type="submit" onClick="verify();" />
					</div>
			</form>
			
		</div>
		</div>
		</div>

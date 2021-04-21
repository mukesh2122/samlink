<?php $isEnabledTranslate = MainHelper::IsModuleEnabledByTag('translations');
include_once(Doo::conf()->SITE_PATH . 'global/js/buyselltrade.js.php');// catia

$headerName=''; ?>

<ul class="horizontal_tabs clearfix">
	<li>
		<a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES);?>" class="icon_link">
		<i class="games_tab_icon"></i><?php echo $this->__('Notices'); ?></a>
	</li>
	<li class="active" ><!--catia-->
		<a href="<?php echo  MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES); ?>" class="icon_link">
		<i class="games_tab_icon"></i><?php echo $this->__('My Notices'); ?></a>
	</li>
	<li>
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

</script>

<script type="text/javascript">
	function verify() {
		show_alert = '';
		//alert(document.getElementById('insert_category').value);
		if (document.getElementById('owner').value=='') {
			show_alert = 'You have to be Login to create a notice ';
		}
		if (document.getElementById('category').value=='') {
			if (show_alert!='') {
				show_alert+= ' and ou must choose a Category!';
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











<div id="params" ></div>
<div id="demoWrapper">

			<h5 id="status"></h5>
            
           <!--Owner Type--> 
            
            <form id="cnForm" action="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/update_notices/update_change_notice'); ?>" method="post" class="bbq">
			<input id="nid" type="hidden"  style="border:none;" readonly name="nid" value=<?php echo $nid; ?>>
				<input name="button_images" value="" id="button_images" type="hidden"><!--catia -->
                <?php if(isset($noticesList) and !empty($noticesList)):?>
				<?php foreach ($noticesList as $key=>$notice):?>
                <!-- start catia upload images-->
				<input name="album_id" value="<?php echo $notice->FK_ALBUM; ?>" id="album_id" type="hidden">
					
					<?php if (isset($currentAlbum) && !empty($currentAlbum)) : ?>
						<div class="wall_input_actions clearfix">
							<div class="pull_right">
								<a class="wall_input_button" id="wall_post_<?php echo WALL_OWNER_PLAYER.'_'.$wallType; ?>" id_album="<?php echo $notice->FK_ALBUM ; ?>" href="javascript:void(0)" rel="<?php echo WALL_OWNER_PLAYER; ?>"><?php echo $this->__('Post image'); ?></a>
							</div>
						</div>
					<?php endif; ?>
					</div>
					<!-- Wall input end -->

					<!-- Create New Album start -->				
				
					<div id="insertalbum" class="clearfix">
					<?php if ($wallType == WALL_PHOTO) : ?>
						<div class="clearfix">
							<?php if (!isset($currentAlbum) || !$currentAlbum) : ?>
								<h2 class="pull_left"><?php echo $this->__('My Images'); ?></h2>
								<input name="id" value="0" id="id" type="hidden">
							<?php else : ?>
								<h2 class="pull_left"><?php echo $this->__('My Images in ').'"'.$currentAlbum->AlbumName.'"'; ?></h2>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<?php if (!isset($currentAlbum) || !$currentAlbum) : ?>
					<ul class="add_album">
    					<li class="add2"><a href="#" class="btn_add">Create New Album +</a></li>
						<li class="show_dropdown_img">
							<a href="#" class="close_album">x</a>
							<br />
							<div class="clearfix">
								<label for="albumName"><?php echo $this->__('Album Name'); ?></label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span>
									<input id="albumName" class="text_input" type="text" value="<?php echo $album->AlbumName; ?>" name="albumName" tabindex="1">
								</span>
								
								<label for="albumDescription"><?php echo $this->__('Album Descripton'); ?></label>
								<span>
									<input id="albumDescription" class="text_input" type="text" value="<?php echo $album->AlbumDescription; ?>" name="albumDescription" tabindex="2">
								</span>
							</div>
							<br />
							<div class="clearfix">
								<input type="button" onClick="insertalbum();"  class="button button_auto light_blue pull_right" value="<?php echo $this->__('Save'); ?>" />
							</div>
				        </li>
					</ul>
					<?php endif; ?>
					
					<!-- Wall posts start -->
					<div id="wall_container" class="wall_list">
						<?php if(isset($posts)) echo $posts;?>
					</div>
					<?php if ((!isset($posts) or $posts == '') && (!isset($albums) or empty($albums))): ?>
						<div class="noItemsText"><?php echo $this->__('There are no wall posts at this moment'); ?></div>
					<?php endif; ?>
					<!-- Wall posts end -->
					 </div>
				<br />
               <!-- end catia upload images-->
	  
	            <div id="fieldWrapper">
       
                    
                     <!--User Type and noticetype starts --> 
                     
						
                        <p class="form_widget_upgrade"><?php echo $this->__('1. Select user type & notice type');?></p>
                        <br/>
                        
            
                         
                        <label class="respond_label" name="user">User Type</label>
                        
                        
						    <select  class="response_sel"  id="user" style="width:150px;height:25px;" valign="top" id="owntype" name="owntype" >
							<option value="Select Ownertype" >&nbsp;</option>

                        
              <option value="player" <?php echo $notice->OwnerType == 'player' ? 'selected="selected"' : ''; ?>><?php echo $this->__('Player'); ?></option>
			   
               <option value="group" <?php echo $notice->OwnerType == 'group' ? 'selected="selected"' : ''; ?>><?php echo $this->__('Group'); ?></option>
                        
                              </select> 
                      
                         <input name="owner" class="step" value="<?php echo $notice->FK_OWNER; ?>" id="owner" type="hidden" readonly>
			                       
                        <input name="createdtime" class="step" value="<?php echo $today = date("dmyHi"); ?>" id="createdtime" type="hidden" readonly>
						 
                        <!--Notice type starts--> 
                         
                         <label class="respond_label" >Notice Type</label>
                         
						<select class="response_sel" valign="top" style="width:150px;height:25px;" id="noticetype" name="noticetype" size>
						
								<option value="sell" <?php echo $notice->NoticeType == 'sell' ? 'selected="selected"' : ''; ?>><?php echo $this->__('Sell'); ?></option>
								<option value="buy" <?php echo $notice->NoticeType == 'buy' ? 'selected="selected"' : ''; ?>><?php echo $this->__('Buy'); ?></option>
								<option value="trade" <?php echo $notice->NoticeType == 'trade' ? 'selected="selected"' : ''; ?>><?php echo $this->__('Trade'); ?></option>
						</select> 
                       
						
				
					<br />
					
	<br />
                    
					
                  
                    
                    
						<p class="form_widget_upgrade"><?php echo $this->__('2. Select a Category');?>  
                        </p>
						<br/>
                        
                        <!--category  --> 
                        
						
                         
                        <label class="respond_label" >Category</label>
                        
						<select  class="response_sel" id="category" valign="top" style="width:150px;height:25px;" id="category" name="category">
							<option value="0">&nbsp;
							</option>
									<?php if(isset($categoryList) and !empty($categoryList)) {
										foreach ($categoryList as $item) { ?>
											<option value="<?php echo $item->ID_CATEGORY; ?>" <?php echo $notice->FK_CATEGORY == $item->ID_CATEGORY ? 'selected="selected"' : ''; ?>><?php echo $item->CategoryName; ?>
											</option>
									<?php } ?>
								<?php } ?>	
                                
						</select> 
                        
                      
                       <!--add new category-->
                        
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
    

<br />
                          <!--language and country starts-->
                        
						
						<?php $langs = Lang::getLanguages(); $currentLang = Lang::getCurrentLangID(); $selectedLang = Lang::getLangById($currentLang);?>
						<?php if($isEnabledTranslate == 1): ?>
                        
                        
                        
                        
		<p class="form_widget_upgrade"><?php echo $this->__('3. Select a language and Country');?></p>
        <br /><br />
                        <label class="respond_label" >Language</label>
						<select class="response_sel" id="language" valign="top" style="width:150px;height:25px;" id="language" name="language">
	
                            	<option value="0">&nbsp;</option>
							
							<?php if(isset($langList) and !empty($langList)) { ?>
									<?php foreach($langList as $lang):?>
									<option value="<?php echo $lang->ID_LANGUAGE; ?>" <?php echo $lang->ID_LANGUAGE == $notice->FK_LANGUAGE ? 'selected="selected"' : ''; ?>><?php echo $lang->NativeName; ?>
									</option>
								<?php endforeach;?>
								<?php } ?>
						</select> 
						
						<?php endif; ?>
                        
                        
                            <!--country starts --> 
                        
                        
                        <?php // $country != '' ? $countries = Buyselltrade::getCountryByID($country) : ''; ?>
                        
                        <label class="respond_label" >Country</label>
						<select  valign="top" id="country" style="width:150px;height:25px;" name="country" class="response_sel">
								<option value="0">&nbsp;
							</option>
							<?php if(isset($countryList) and !empty($countryList)) {
									foreach ($countryList as $item) { ?>
<option value="<?php echo $item->ID_COUNTRY; ?>" <?php echo $item->ID_COUNTRY == $notice->FK_COUNTRY ? 'selected="selected"' : ''; ?>><?php echo $item->Country; ?>
									</option>
								<?php } ?>
							<?php } ?>	
						</select>
                     		
					<br />
                    <br />
             
             
                <!--saletype and paymentype starts --> 
                             
					<div class="sale_pay">
						
                        <p class="form_widget_upgrade"><?php echo $this->__('4. Select sale type and Payment Type');?></p>
                        <br/>
                        <br />
                         
                        <label class="respond_label">Type of Sale</label>
                        
                        
						<select  class="response_sel"  id="saletype" style="width:140px;height:25px;" valign="top" name="saletype" >
						
                        
                        <option value="Select Saletype" selected="selected">Select type</option>
						  
                        <option value="buynow" <?php echo $notice->SaleType == 'buynow' ? 'selected="selected"' : ''; ?>><?php echo $this->__('Buy Now'); ?></option> 
                       
                 <option value="auction" <?php echo $notice->SaleType == 'auction' ? 'selected="selected"' : ''; ?>><?php echo $this->__('Auction'); ?></option>
                       
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
						  
                        <option value="credits" <?php echo $notice->PaymentType == 'credits' ? 'selected="selected"' : ''; ?>>
                        <?php echo $this->__('Credits'); ?>
                        </option> 
                           
                           
						    <option value="none" <?php echo $notice->PaymentType == 'none' ? 'selected="selected"' : ''; ?><?php echo $this->__('None'); ?></option>
						</select> 
                         
                        
                         
                        
                       
        <br />
               <br />  <br />
    </div>
                    
					    <!-- Auction starts --> 
                        
                     <div class="auction_op">
                     
                     
						
                        <p class="form_widget_upgrade"><?php echo $this->__('5. Auction Options');?></p>
                        <br/><br/>
                        
                        <label class="respond_label" >Starting Price</label>
                         <input id="startprice" name="startprice" class="input_info" value="<?php echo $notice->StartPrice; ?>" type="text" />
                         
                         
                          <label class="respond_label" >Auction starts</label>
                          <input name="autionstarts" class="input_info" type="text"  style="width:30px;" />
                          <br /><br />
                         <label class="respond_label" >Minimum Price</label>
                         <input id="minprice" name="minprice" class="input_info" value="<?php echo $notice->MinPrice; ?>" type="text" />
                         
                          <label  class="respond_label" >Auction ends&nbsp;&nbsp;</label>
                         <input name="auctionends" class="input_info" type="text" style="width:30px;" />
                         <br /><br />
                         <label class="respond_label" >Buy now Price</label>
                         <input name="currentprice" id="currentprice" value="<?php echo $notice->CurrentPrice; ?>" class="input_info" type="text"  />
                        
                        <br />
                      <br/>  
                        </div>
                        
                        <!--  Price starts --> 
                        
                     <div class="price_cur">
						
                        <p class="form_widget_upgrade"><?php echo $this->__('5. Select Price');?></p>
                        <br/>
                        
                         <label class="respond_label" >Price&nbsp;</label>
                         <input name="currentprice" id="cur_price" class="input_info" value="<?php echo $notice->CurrentPrice; ?>" type="text" />
                       
                       
                         </div>
                         
                         
                       <!--currency starts  --> 
                       
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
						
						
						<textarea name="headline" id="headline" rows="1" cols="80" value="<?php echo $notice->Headline; ?>">    
						<?php echo $notice->Headline; ?></textarea><br /><br />
					
						<textarea name="details" id="details" rows="5" cols="80" value="<?php echo $notice->Details; ?>"><?php echo $notice->Details; ?></textarea>
				
						<br /><br />

				</div>
                
                
                <?php endforeach; ?>
				<?php endif; ?>
                
                
				<div id="demoNavigation">
                
                
              
				
					<input id="link_create" name="link_create" type="hidden" value="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_CREATE_NOTICES.'/notices/').'create'; ?>">
					<?php //<input class="rounded_5 navigation_button green" id="back" value="Back" type="reset" />  onClick="verify(this);" ?>
                    
					<input class="rounded_gray" id="next" name="next" value="<?php echo $this->__('Save Notice'); ?>" type="button" onClick="verify(this);" />
                    
					</div>
			</form>
			
		</div>
		</div>
		</div>

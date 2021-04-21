<?php $isEnabledTranslate = MainHelper::IsModuleEnabledByTag('translations');
include_once(Doo::conf()->SITE_PATH . 'global/js/buyselltrade.js.php');// catia

$headerName=''; ?>

<ul class="horizontal_tabs clearfix">
	<li class="active" >
		<a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES);?>" class="icon_link">
		<i class="games_tab_icon"></i><?php echo $this->__('Notices'); ?></a>
	</li>
	<li>
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
<script type="text/javascript">
//
//$(document).ready(function() {
//// Tooltip only Text
//$('.masterTooltip').hover(function(){
//        // Hover over code
//        var title = $(this).attr('title');
//        $(this).data('tipText', title).removeAttr('title');
//        $('<p class="tooltip"></p>')
//        .text(title)
//        .appendTo('body')
//        .fadeIn('slow');
//}, function() {
//        // Hover out code
//        $(this).attr('title', $(this).data('tipText'));
//        $('.tooltip').remove();
//}).mousemove(function(e) {
//        var mousex = e.pageX + 20; //Get X coordinates
//        var mousey = e.pageY + 10; //Get Y coordinates
//        $('.tooltip')
//        .css({ top: mousey, left: mousex })
//});
//});
//</script>

<!-- header -->

<!-- filter menu starts -->

<div class="filter_bar clearfix">

	<div class="filter_bar_label">
    <?php echo $this->__('Filters'); ?>	
    </div>


	<div class="filter_bar_options">
    
    <div class="list_container filter_options" >
    
<!--noticetype starts-->

<li class="global_nav_actions_li">
 <a class="filter_bar_option_selected global_nav_action_trigger" href="#">
<?php  echo $noticetype != '' ? $noticetype : $this->__('Notice Type');?>
<i class="down_arrow_light_icon"></i>
</a>
    <!-- dropdown starts-->
    
<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
			<li <?php echo $noticetype == 'sell' ? 'class="active"' : ''; ?>><a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/noticetype/sell'); ?>">
			<?php echo $this->__('Sell'); ?>
			</a></li>
			<li  <?php echo $noticetype == 'buy' ? 'class="active"' : ''; ?>><a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/noticetype/buy'); ?>">
			<?php echo $this->__('Buy'); ?>
			</a></li>
            <li  <?php echo $noticetype == 'trade' ? 'class="active"' : ''; ?>><a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/noticetype/trade'); ?>">
			<?php echo $this->__('Trade'); ?>
			</a></li>
		</ul>
	</div>
</li>

<?php if  ($noticetype != 'trade') { ?> 

<!-- auction/buynow starts   -->

<li class="global_nav_actions_li">

<a class="filter_bar_option_selected global_nav_action_trigger" href="#">

<?php   echo $saletype != '' ? $saletype : $this->__('Sale type');?><i class="down_arrow_light_icon"></i>
</a>

<!-- dropdown starts   -->

<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
			<li><a href=<?php  echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/saletype/auction'); ?>>
			<?php echo $this->__('Auction'); ?>
			</a></li>
			<li><a href=<?php  echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/saletype/buynow'); ?>>
			<?php echo $this->__('Buy Now'); ?>
			</a></li>
         
		</ul>
	</div>
</li>
<?php }else  {
		
	}
	 ?>

 <!-- categories starts   -->
 
 <li class="global_nav_actions_li"> 
 <a class="filter_bar_option_selected global_nav_action_trigger" href="#">
  <?php $categoryID = Buyselltrade::getCategoryByID($category); ?>
	<?php  echo $category != '' ? $categoryID->CategoryName : $this->__('Categories');?>
<i class="down_arrow_light_icon"></i></a>
    
     <!-- dropdown starts   -->

<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
        
			<?php 
			if(isset($categoryList) and !empty($categoryList)) {
				foreach ($categoryList as $item3) { ?>
					<li <?php echo $category != '' ? ($item3->ID_CATEGORY == $categoryID->ID_CATEGORY ? 'class="active"' : '') : '';?>><a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/category/'.$item3->ID_CATEGORY); ?>">
					<?php echo $item3->CategoryName; ?></a> </li>
                    
					
				<?php } ?>
			 
		
                    
			
			<?php
			} ?>	
			
		</ul>
	</div>
</li>

	
<!-- owner type starts   -->

<li class="global_nav_actions_li">

<a class="filter_bar_option_selected global_nav_action_trigger" href="#">
<?php  echo $ownertype != '' ? $ownertype : $this->__('Owner Type');?><i class="down_arrow_light_icon"></i>
</a>

<!-- dropdown starts   -->

<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
			<li><a href=<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/ownertype/player'); ?>>
			<?php echo $this->__('Player'); ?>
			</a></li>
			<li><a href=<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/ownertype/group'); ?>>
			<?php echo $this->__('Group'); ?>
			</a></li>
		</ul>
	</div>
</li>

 <!-- languages starts   -->
 
<?php $langs = Lang::getLanguages(); $currentLang = Lang::getCurrentLangID(); $selectedLang = Lang::getLangById($currentLang); ?>
<?php $lang != '' ? ($lang!=$currentLang ? $selectedLang = Lang::getLangById($lang) : '') : '' ?>
<?php if($isEnabledTranslate == 1): ?>
<li class="global_nav_actions_li">
	<a class="filter_bar_option_selected global_nav_action_trigger" href="#"><?php  echo $selectedLang->NativeName;?><i class="down_arrow_light_icon"></i></a>
    
    <!-- dropdown starts   -->
    
	<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
			<?php foreach($langs as $language):?>
			<li <?php echo $language->ID_LANGUAGE == $currentLang ? 'class="active"' : '';?>>
				<a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/lang/'.$language->ID_LANGUAGE);?>"><?php echo $language->NativeName;?></a>
			</li>
			<?php endforeach;?>
		</ul>
	</div>
</li>
<?php endif; ?>

<!--country starts   -->

<li class="global_nav_actions_li">
<a class="filter_bar_option_selected global_nav_action_trigger" href="#">

<?php $countryID = Buyselltrade::getCountryByID($country); ?>
<?php  echo $country != '' ? $countryID->Country : $this->__('Countries');?><i class="down_arrow_light_icon"></i></a>

        <!-- dropdown starts   -->
        
<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
			<?php if(isset($countryList) and !empty($countryList)) {
				foreach ($countryList as $item4) { ?>
					<li <?php echo $country != '' ? ($item4->ID_COUNTRY == $countryID->ID_COUNTRY ? 'class="active"' : '') : '';?>><a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/country/'.$item4->ID_COUNTRY); ?>">
					<?php echo $item4->Country; ?>
					</a></li>
				<?php } ?>
			<?php } ?>	
			
		</ul>
	</div>
</li>

</div>

<!-- filter ends here -->

</div>
</div>







<?php if(!isset($searchText)):?>
	<div class="list_header">
			<h1><?php echo $headerName;?></h1>
		</div>
	<?php endif; ?>
    
<!-- Notices list start -->
    <?php $album_old = ''; ?>
	<?php if(isset($noticesList) and !empty($noticesList)):?>
		
		<?php foreach ($noticesList as $key=>$item2):?>
        	
			<div id="notices_list">
            
            <div class="product_photo">
             <ul> 
             
                   <li class="tphoto"></li>
					
                    </ul>
             </div>       
             <div class="product_data">  
              
             <ul class="title">
             
             <li><?php echo $item2->Headline;  ?></li>
             
             </ul>
             
                 
					  
               <?php if (($ownerid!='')&&($saletype=='auction')) { ?>	
               
                 <ul class="prod_info">
                         <li class="cat_icon">Id#<?php echo $item2->ID_NOTICE; ?></li>
						 	 <!-- ********************catia'*********************-->
						  <?php 
							if ($item2->FK_ALBUM!='') {
								$imagealbum = Buyselltrade::getImageByAlbum($item2->FK_OWNER,$item2->OwnerType,$item2->FK_ALBUM); 
								if($imagealbum!='') {
									$friendUrl = '';
									$poster = $friendUrl == '' ? $player : User::getFriend($friendUrl);
									$total_images = Buyselltrade::getTotalImages($item2->FK_OWNER,$item2->OwnerType,$item2->FK_ALBUM);
									?>
									<a rel="photo_tag" class="showImage" href="<?php echo MainHelper::site_url('players/iframeshowphotopopup/'.$imagealbum.'/'.WALL_PHOTO);?>"><?php echo $this->__('Images').'('.$total_images.')'; ?></a> 
								<?php } else {
									echo $this->__('no Images'); 
								}
							} else {
								echo $this->__('no album'); 
							}
							?>
							<!-- ********************end catia'*********************-->
						 <li class="user_icon"><a href="<?php echo MainHelper::site_url('players/wall');?>">
						<?php echo $item2->OwnerName; ?></a>
                        </li>
                        <li class="id_icon"><?php echo $item2->CategoryName;  ?> </li> 
						<li class="co_icon"><?php echo ucwords(mb_strtolower($item2->CountryName)); ?></li> 
						<li class="lan_icon"><?php echo $item2->LanguageName; ?></li>
                       
					  </ul>   
               
                <ul class="description">
                
                      	<li>Current Bid: <span class="blue"> <?php echo $item2->CurrentPrice; ?></span></li>
                        <li>Min Price: <span class="blue"><?php  echo $item2->MinPrice; ?> </span></li> 
                        <li>#Bids: <span class="blue"> 1 <?php // echo $item2->bidCount; ?> </span></li>
                        <li>Time left: <span class="blue">8 hours</span></li>
					  </ul> 
               
				</div>
                
                         
                <div class="respond">
                
                <ul>
                <br />
             		<li >   <a class="btn_respond" href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_RESPOND_NOTICES.'/'.$item2->ID_NOTICE.'/'.$item2->OwnerType.'/'.$item2->NoticeType); ?>" ><?php echo $this->__('Place Bid'); ?></a>
					</li>
					<!--buy now --> 
                    <li class="buy_now" >
 							<a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_PAYMENTS.'/'.$item2->ID_NOTICE.'/'.$item2->OwnerType.'/'.$item2->FK_OWNER.'/'.$ownerid); ?>" >
 <?php  echo $this->__('Pay with credits'); ?></a>
 					</li>
					      
                        </ul>
			  
              </div>
 
                        <div class="view_options">
                        
						  <?php 
						  $nid= $item2->ID_NOTICE;
						 $myResponsesTotal=Buyselltrade::getResponsesTotal($nid); ?>
						 
	 <a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/view_notices_responses/'.$item2->ID_NOTICE.'/'.$item2->OwnerType); ?>" >
					<?php echo $myResponsesTotal;?>
					     </a>
					    
                        </div>
                        
                        <?php
						
						 } else { ?>
                         
                         
                         
						   <ul class="prod_info">
                      	
                        
                         <li class="cat_icon">Id#<?php echo $item2->ID_NOTICE; ?></li>
				 <!-- ********************catia'*********************-->
						  <?php 
						  	
							if ($item2->FK_ALBUM!='') {
								$imagealbum = Buyselltrade::getImageByAlbum($item2->FK_OWNER,$item2->OwnerType,$item2->FK_ALBUM); 
								$imagesalbum = Buyselltrade::getAllImageByAlbum($item2->FK_OWNER,$item2->OwnerType,$item2->FK_ALBUM); 
								
								if(isset($imagesalbum) and !empty($imagesalbum)) {
									$cont = 0;
								$cont2 = '';
								if ($album_old == '') {
									$album_old = $item2->FK_ALBUM;
									$cont2 = '';
								} else {
									if ($album_old != $item2->FK_ALBUM) {
										$cont2 = '1';
										$album_old = $item2->FK_ALBUM;
										$cont2++;
									}
								}
									foreach ($imagesalbum as $key=>$imgalbuns) {
										if ($cont==0) {
											$total_images = Buyselltrade::getTotalImages($item2->FK_OWNER,$item2->OwnerType,$item2->FK_ALBUM);?>
											<a rel="photo_tag_bst<?php echo $cont2; ?>" class="imagebuyselltrade"  href="<?php echo MainHelper::site_url('players/iframeshowphotopopup/'.$imgalbuns->ID_WALLITEM.'/'.WALL_PHOTO);?>"><?php echo $this->__('Images').'('.$total_images.')'; ?></a> 
										<?php } else { ?>
											<span style="display:none;"><a rel="photo_tag_bst<?php echo $cont2; ?>" class="imagebuyselltrade" style="overflow: hidden;	width: 198px; height: 148px; display: block; 	position: relative;" href="<?php echo MainHelper::site_url('players/iframeshowphotopopup/'.$imgalbuns->ID_WALLITEM.'/'.WALL_PHOTO);?>"></a></span>
										<?php }
										$cont++;
									}
								
									//$friendUrl = '';
//									$list = array();
//									$player_owner = new Players();
//									$player_owner->ID_PLAYER = $item2->FK_OWNER;
//									$player_owner->purgeCache();
//        							$player_owner = $player_owner->getOne();
//									$type_album = WALL_PHOTO;
//									$list['infoBox'] = MainHelper::loadInfoBox('Players', $type_album, true);
//									MainHelper::getWallPosts($list, $player_owner, 0, $type_album, $friendUrl, $item2->FK_ALBUM);
									//$total_images = Buyselltrade::getTotalImages($item2->FK_OWNER,$item2->OwnerType,$item2->FK_ALBUM);?>
									<!--<a rel="photo_tag" class="showimage" href="<?php //echo MainHelper::site_url('players/iframeshowphotopopup/'.$imagealbum.'/'.WALL_PHOTO);?>">					<?php //echo $this->__('Images').'('.$total_images.')'; ?></a> -->
									
									
									<?php
									
									
								?>
								
								<?php
									//$poster = $friendUrl == '' ? $player : User::getFriend($friendUrl);
									
									?>
									
								<?php } else {
									echo $this->__('no Images'); 
								}
							} else {
								echo $this->__('no album'); 
							}
							?>
							<!-- ********************end catia'*********************-->
									
                         <li class="user_icon"><a href="<?php echo MainHelper::site_url('players/wall');?>">
						<?php echo $item2->OwnerName; ?></a>
                        </li>
                        <li class="id_icon"><?php echo $item2->CategoryName;  ?> </li> 
						<li class="co_icon"><?php echo ucwords(mb_strtolower($item2->CountryName)); ?></li> 
						
                               
                       
                       
                       
                       
                       
                       
                       
                       
                       
                       
					  </ul> 
						 
					 <ul class="description">
                                
                          
                
                
                 <li class="price_icon"> <span class="blue">         
				  
				   <?php $PaymentType=$item2->PaymentType; ?> 
				  
				 <?php echo $PaymentType == 'credits'? round($item2->CurrentPrice).' credits': $item2->Currency. $item2->CurrentPrice; ?>
                 
                 
                   </span></li> 
                         <li class="details_icon"><a href="#" title="Product Details: <?php  echo $item2->Details; ?>" class="masterTooltip">Details</a></li>
                        <li class="date_icon">Posted on
                  <?php 
				     //$item2->CreatedTime;
?>
                          

					  </li>
                        <li class="lan_icon"><?php echo $item2->LanguageName; ?></li>
					  </ul> 
               
				</div>
               
                         
                <div class="respond">
                
                <ul>
						
                        <br />
             <li >   <a class="btn_respond" href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_RESPOND_NOTICES.'/'.$item2->ID_NOTICE.'/'.$item2->OwnerType.'/'.$item2->NoticeType); ?>" ><?php echo $this->__('Respond'); ?></a></li>
				
                
                
               <?php  
                          $nid=$item2->ID_NOTICE;
                 
						 $myPaymentsTotal=Buyselltrade::PaymentExists($nid); ?>
                
                
                 <?php  if ($noticetype == 'sell' && $PaymentType == 'credits') { ?>
                		
						      <!--buy now --> 
                       <li class="buy_now" >
            
    <form action="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_PAYMENTS.'/'.$item2->FK_OWNER);?>" method="post">       
                 <input id="credits" type="hidden"  style="border:none;" readonly name="credits" value="<?php echo $item2->CurrentPrice; ?>">  
              <input id="ownertype" type="hidden"  style="border:none;" readonly name="ownertype" value="<?php echo $item2->OwnerType; ?>"> 
           <input id="noticetype" type="hidden"  style="border:none;" readonly name="noticetype" value="<?php echo $item2->NoticeType; ?>"> 
           <input id="buyerid" type="hidden"  style="border:none;" readonly name="buyerid" value="<?php echo $ownerid; ?>">
             <input id="saletype" type="hidden"  style="border:none;" readonly name="saletype" value="<?php echo $saletype; ?>"> 
              <input id="headline" type="hidden"  style="border:none;" readonly name="headline" value="<?php echo $item2->Headline; ?>">
           <input id="sellerid" type="hidden"  style="border:none;" readonly name="sellerid" value="<?php echo $item2->FK_OWNER; ?>"> 
           <input id="nid" type="hidden"  style="border:none;" readonly name="nid" value=<?php echo $item2->ID_NOTICE; ?>> 
           <input id="rid" readonly name="rid" type="hidden" value="" /> 
        <input   <?php echo $myPaymentsTotal == 0 ? 'type="submit" class="buy_now2" value="Pay with credits"'   : 'type="button"  class="btn_disabled" value="SOLD"'; ?> >
             </form>
                        </li>
					      																							
                          <?php  } else {?> 
                          
                          <?php  } ?> 
                        </ul> 
			  
              </div> 
 
                        <div class="view_options">
                       <?php 
						  $nid= $item2->ID_NOTICE;
						 $myResponsesTotal=Buyselltrade::getResponsesTotal($nid); ?>
						 
	 <a id="show" href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/view_notices_responses/'.$item2->ID_NOTICE.'/'.$item2->OwnerType.'/'.$item2->NoticeType.'/'.$item2->SaleType); ?>" >
					<?php echo $myResponsesTotal;?>
					     </a>
                        </div>

						 
						 <?php } ?>
</div>




<br />
       <?php endforeach; ?>      
       
         <!--  end of notices list --> 
    <?php endif; ?>     
		
        
        
        
        
        
        
        
        
        
        
		<?php if(isset($pager)):?>
			<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)) ?>
		   

	<?php else: ?>
    
		<p class="noItemsText"><?php echo $this->__('There are no notices here. Yet!'); ?></p>
	
	 <?php endif; ?>

<!-- noticelist end -->
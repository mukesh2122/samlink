<?php $isEnabledTranslate = MainHelper::IsModuleEnabledByTag('translations');

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

<div id="devconsole">


<script type="text/javascript">
	function change_status_notice(object) {
		var status_id = object.value;
		var link_name = document.getElementById('link_status_notice').value;
		
		window.location.href = link_name+status_id;
		
	}
	function change_status_response(object) {
		var status_id = object.value;
		var link_name = document.getElementById('link_status_response').value;
		
		window.location.href = link_name+status_id;
		
	}
	
</script>

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
			<li <?php echo $noticetype == 'sell' ? 'class="active"' : ''; ?>><a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES.'/noticetype/sell'); ?>">
			<?php echo $this->__('Sell'); ?>
			</a></li>
			<li  <?php echo $noticetype == 'buy' ? 'class="active"' : ''; ?>><a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES.'/noticetype/buy'); ?>">
			<?php echo $this->__('Buy'); ?>
			</a></li>
            <li  <?php echo $noticetype == 'trade' ? 'class="active"' : ''; ?>><a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES.'/noticetype/trade'); ?>">
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
			<li><a href=<?php  echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES.'/saletype/auction'); ?>>
			<?php echo $this->__('Auction'); ?>
			</a></li>
			<li><a href=<?php  echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES.'/saletype/buynow'); ?>>
			<?php echo $this->__('Buy Now'); ?>
			</a></li>
         
		</ul>
	</div>
</li>
<?php }else  {
		
	}
	 ?>


<!--category starts-->


<li class="global_nav_actions_li">
<a class="filter_bar_option_selected global_nav_action_trigger" href="#">
<?php $categoryID = Buyselltrade::getCategoryByID($category); ?>
<?php  echo $category != '' ? $categoryID->CategoryName : $this->__('Categories');?><i class="down_arrow_light_icon"></i></a>

<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
        
        <!--category drop-down starts-->
			<?php
			//list the categories
			
			 if(isset($categoryList) and !empty($categoryList)) {
				foreach ($categoryList as $item) { ?>
					<li <?php echo $category != '' ? ($item->ID_CATEGORY == $categoryID->ID_CATEGORY ? 'class="active"' : '') : '';?>><a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/category/'.$item->ID_CATEGORY); ?>">
					<?php echo $item->CategoryName; ?>
					</a></li>
				<?php } ?>
			<?php } ?>	
			
		</ul>
	</div>
    
    <!--category ends -->
    
</li>




<!--owner type starts-->

<li class="global_nav_actions_li">
<a class="filter_bar_option_selected global_nav_action_trigger" href="#">
<?php  echo $ownertype != '' ? $ownertype : $this->__('Owner Type');?>
<i class="down_arrow_light_icon"></i>
</a>
    <!-- dropdown starts-->
    
<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
			<li <?php echo $ownertype == 'player' ? 'class="active"' : ''; ?>><a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES.'/ownertype/player'); ?>">
			<?php echo $this->__('Player'); ?>
			</a></li>
			<li  <?php echo $ownertype == 'group' ? 'class="active"' : ''; ?>><a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES.'/ownertype/group'); ?>">
			<?php echo $this->__('Group'); ?>
			</a></li>
		</ul>
	</div>
</li>

<!-- notices/responses starts   -->


<li class="global_nav_actions_li">
<a class="filter_bar_option_selected global_nav_action_trigger" href="#">
<?php  echo $type != '' ? $type : $this->__('List Type');?><i class="down_arrow_light_icon"></i></a>

<!-- dropdown starts   -->

<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
			<li <?php echo $type == 'notices' ? 'class="active"' : ''; ?>><a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES.'/type/notices'); ?>">
			<?php echo $this->__('Notices'); ?>
			</a></li>
			<li  <?php echo $type == 'responses' ? 'class="active"' : ''; ?>><a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES.'/type/responses'); ?>">
			<?php echo $this->__('Responses'); ?>
			</a></li>
		</ul>
	</div>
</li>


<!-- country starts   -->


<?php $countryID = Buyselltrade::getCountryByID($country); ?>
<li class="global_nav_actions_li">
<a class="filter_bar_option_selected global_nav_action_trigger" href="#">
<?php  echo $country != '' ? $countryID->Country : $this->__('Countries');?><i class="down_arrow_light_icon"></i></a>

<!-- dropdown starts   -->

<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
			<?php if(isset($countryList) and !empty($countryList)) {
				foreach ($countryList as $item) { ?>
					<li <?php echo $country != '' ? ($item->ID_COUNTRY == $countryID->ID_COUNTRY ? 'class="active"' : '') : '';?>><a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/country/'.$item->ID_COUNTRY); ?>">
					<?php echo $item->Country; ?>
					</a></li>
				<?php } ?>
			<?php } ?>	
			
		</ul>
	</div>
</li>

</div>

</div>
</div>

</div>
<br /><br/> 


<!-- notices list starts   -->


<?php if(isset($noticesList) and !empty($noticesList)):?>
		<?php foreach ($noticesList as $key=>$item):?>
        
        
			<div id="notices_list">
            
            <div class="product_photo">
             <ul> 
             
                   <li class="tphoto"></li>
					
                    </ul>
              </div>    
				     
             <div class="product_data">  
              
             <ul class="title">
             
             <li class="blue4"><?php echo $item->Headline;  ?></li>
             
             </ul>
             
              <?php if (($ownerid!='')&&($saletype=='auction')) { ?>	
                 
              <ul class="prod_info">
                      	
                        
                         <li class="cat_icon">Id#<?php echo $item->ID_NOTICE; ?></li>
                         <li class="user_icon"><a href="<?php echo MainHelper::site_url('players/wall');?>">
						<?php echo $item->OwnerName; ?></a>
                        </li>
                        <li class="id_icon"><?php echo $item->CategoryName;  ?> </li> 
						<li class="co_icon"><?php echo ucwords(mb_strtolower($item->CountryName)); ?></li> 
						
                       
					  </ul> 
                       
					  
                <ul class="description">
                
               
                
                      	<li>Current Bid: <span class="blue"><?php echo $item->CurrentPrice; ?></span></li>
                        <li>Min Price: <span class="blue"><?php echo $item->MinPrice; ?> </span></li> 
                        <li>Time left: <span class="blue">8 hours</span></li>
                           <li class="lan_icon"><?php echo $item->LanguageName; ?></li>
					  </ul> 
               
				</div>
                
                         
                <div class="respond">
                
                <ul>
                
                      	<li class="first">
                        
                        <form style="display:inline;"> 
<input id="link_status_notice" name="link_status_notice" type="hidden" value="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES.'/notices/owner/'.$item->FK_OWNER.'/notice/'.$item->ID_NOTICE).'/status/'; ?>"> <label class="stat">&nbsp;</label>
                        <select style="width:76px;" id="status_notice" name="status_notice" onchange="change_status_notice(this);">
                         <option <?php echo $item->NoticesStatus == 'open' ? 'selected="selected"' : ''; ?>>Open</option>
                        <option <?php echo $item->NoticesStatus == 'closed' ? 'selected="selected"' : ''; ?>>closed</option>
						                        </select></form>
    
                 </li>
                <li class="details_icon">Details</li> 
                <li class="edit_options">
                <a  href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/update_notices/'.$item->ID_NOTICE.'/'.$item->OwnerType); ?>" >Edit</a>
                        </li>
                        
                      
                        
                        
                        </ul>
			  
              </div>
              <br />
               
               <div class="view_options2">
               
               
              <?php 
						  $nid= $item->ID_NOTICE;
						 $myResponsesTotal=Buyselltrade::getResponsesTotal($nid); ?>
						 
	 <span class="blue"><a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/view_notices_responses/'.$item->ID_NOTICE.'/'.$item->OwnerType.'/'.$item->NoticeType.'/'.$item->SaleType); ?>" >
					<?php echo $myResponsesTotal;?>
					     </a></span>bid <?php // echo $item->bidCount; ?> 
                         </div>
            
            
             <?php } else { ?>
             
             
             
             
             <ul class="prod_info">
                      	
                        
                         <li class="cat_icon">Id#<?php echo $item->ID_NOTICE; ?></li>
                         <li class="user_icon"><a href="<?php echo MainHelper::site_url('players/wall');?>">
						<?php echo $item->OwnerName; ?></a>
                        </li>
                        <li class="id_icon"><?php echo $item->CategoryName;  ?> </li> 
						<li class="co_icon"><?php echo ucwords(mb_strtolower($item->CountryName)); ?></li> 
						
                       
					  </ul> 
                       
					  
                <ul class="description">
                
               
                
                         <li class="price_icon"><?php echo $item->Currency; ?><?php echo $item->CurrentPrice; ?></li> 
                         <li class="details_icon">Pay with <?php echo $item->PaymentType; ?></li>
                        <li class="date_icon">Posted on</li>
                        
                        <li class="lan_icon"><?php echo $item->LanguageName; ?></li>
					  </ul> 
               
				</div>
                
                         
                <div class="respond">
                
                <ul>
                
                      	<li class="first">
                        
                        <form style="display:inline;"> 
<input id="link_status_notice" name="link_status_notice" type="hidden" value="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES.'/notices/owner/'.$item->FK_OWNER.'/notice/'.$item->ID_NOTICE).'/status/'; ?>"> <label class="stat">&nbsp;</label>
                        <select style="width:76px;" id="status_notice" name="status_notice" onchange="change_status_notice(this);">
                         <option <?php echo $item->NoticesStatus == 'open' ? 'selected="selected"' : ''; ?>>Open</option>
                        <option <?php echo $item->NoticesStatus == 'closed' ? 'selected="selected"' : ''; ?>>closed</option>
						                        </select></form>
    
                 </li>
                  <li class="details_icon">Details</li> 
                <li class="edit_options">
                <a  href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/update_notices/'.$item->ID_NOTICE.'/'.$item->OwnerType); ?>" >Edit</a>
                        </li>
                        </ul>
			  
              </div>
              <br />
               
               <div class="view_options2">	 
                <?php 
						  $nid= $item->ID_NOTICE;
						 $myResponsesTotal=Buyselltrade::getResponsesTotal($nid); ?>
						 
	 <a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/view_notices_responses/'.$item->ID_NOTICE.'/'.$item->OwnerType.'/'.$item->NoticeType.'/'.$item->SaleType); ?>" >
					<?php echo $myResponsesTotal;?>
					     </a>
                         
                 </div>
             
             
             
              
						 <?php } ?>         
                 
</div>
            
               
                                      
							<br /><br />
						<?php  endforeach; ?>

		
		<?php if(isset($pager)):?>
			<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)) ?>
			
		<?php endif; ?>

	<?php else: ?>
		<p class="noItemsText"><?php echo $this->__('There are no notices here. Yet!'); ?></p>
		
		
	<?php endif; ?>


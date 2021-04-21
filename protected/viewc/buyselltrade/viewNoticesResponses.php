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


<br>

<script>

jQuery(document).ready(function ($) {
   
    var divs=$('.show_messages').hide(); 

    var ps=$('#total_replies').click(function () {
        ps.not(this).removeClass('close_arrow')
        $(this).toggleClass('open_arrow')
		
        divs.not($(this).next()).slideUp()
        $(this).next().slideToggle()
        return false; 

    });
	});

</script>


<div id="params" ></div>
<div id="demoWrapper">


<form id="rcForm" action="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_RESPOND_NOTICES.'/save_response'); ?>" method="post" class="bbq">
<div class="list_header">
			<h1><?php echo $this->__('View Responses');?></h1>
		</div>



<input id="nid" type="hidden"  style="border:none;" readonly name="nid" value=<?php echo $nid; ?>>    <br />

<?php  $commiter_name=''; ?>
<?php  if(isset($committer) and !empty($committer)): ?>
<?php  $commiter_name=$committer->NickName; ?>
<?php  endif; ?>	


<br />
<br />
			


	<?php if(isset($noticeList) and !empty($noticeList)):?>
		<?php foreach ($noticeList as $key=>$item):?>
        
        
		<div id="notices_list">
            
            <div class="product_photo">
             <ul> 
             
                   <li class="tphoto"></li>
					
                    </ul>
             </div>       
             <div class="product_data">  
              
             <ul class="title">
             
             <li><?php echo $item->Headline;  ?></li>
             
             </ul>
			
        
             <?php if (($ownerid!='')&&($saletype=='auction')) { ?>	
        
                     <ul class="prod_info">
                      	
                        
                         <li class="cat_icon">Id#<?php echo $item->ID_NOTICE; ?></li>
                         <li class="user_icon"><a href="<?php echo MainHelper::site_url('players/wall');?>">
						<?php echo $item->OwnerName; ?></a>
                        </li>
                        <li class="id_icon"><?php echo $item->CategoryName;  ?> </li> 
						<li class="co_icon"><?php echo ucwords(mb_strtolower($item->CountryName)); ?></li> 
						<li class="lan_icon"><?php echo $item->LanguageName; ?></li>
                       
					  </ul>   
               
                <ul class="description">
                
               
                
                      	<li>Current Bid: <span class="blue"> DKK <?php echo $item->CurrentPrice; ?></span></li>
                        <li>Min Price: <span class="blue">DKK <?php echo $item->MinPrice; ?> </span></li> 
                        <li>#Bids: <span class="blue"> 1 <?php // echo $item->bidCount; ?> </span></li>
                        <li>Time left: <span class="blue">8 hours</span></li>
					  </ul> 
               
				</div>
                
                         
                <div class="respond">
                
                <ul>
						
                        <br />
             <li >   <a class="btn_respond" href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_RESPOND_NOTICES.'/'.$item->ID_NOTICE.'/'.$item->OwnerType); ?>" ><?php echo $this->__('Place Bid'); ?></a></li>
							
						
						      <!--buy now --> 
                       <li class="buy_now" >

 <a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_RESPOND_NOTICES.'/'.$item->ID_NOTICE.'/'.$item->OwnerType.'/'.$item->CurrentPrice); ?>" >
 <?php  echo $this->__('Pay with credits'); ?></a></li>
					      
                        </ul>
			  
              </div>
 
                        <div class="view_options">
                        
						  <?php 
						  $nid= $item->ID_NOTICE;
						 $myResponsesTotal=Buyselltrade::getResponsesTotal($nid); ?>
						 
	 <a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/view_notices_responses/'.$item->ID_NOTICE.'/'.$item->OwnerType); ?>" >
					<?php echo $myResponsesTotal;?>
					     </a>
					    
                        </div>
                        
                        <?php
						
						 }else {
							 
						 ?>
                         
                         
                         
						   <ul class="prod_info">
                      	
                        
                         <li class="cat_icon">Id#<?php echo $item->ID_NOTICE; ?></li>
                         <li class="user_icon"><a href="<?php echo MainHelper::site_url('players/wall');?>">
						<?php echo $item->OwnerName; ?></a>
                        </li>
                        <li class="id_icon"><?php echo $item->CategoryName;  ?> </li> 
						<li class="co_icon"><?php echo ucwords(mb_strtolower($item->CountryName)); ?></li> 
						
                       
					  </ul> 
						 
						        <ul class="description">
                
                 <li class="price_icon"> DKK <?php echo $item->CurrentPrice; ?></li> 
                         <li class="details_icon"><a href="#">Details</a></li>
                        <li class="date_icon">Posted on<?php // echo $item->TimeCreated; ?></li>
                        <li class="lan_icon"><?php echo $item->LanguageName; ?></li>
					  </ul> 
               
				</div>
                
                         
                <div class="respond">
                
                <ul>
						
                        <br />
             <li >   <a class="btn_respond" href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_RESPOND_NOTICES.'/'.$item->ID_NOTICE.'/'.$item->OwnerType); ?>" ><?php echo $this->__('Respond'); ?></a></li>
				
                
                
                 <?php  if ($noticetype == 'sell') { ?>
                		
						      <!--buy now --> 
                       <li class="buy_now" >
 <a  class="buy_now2" href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_PAYMENTS.'/'.$item->ID_NOTICE.'/'.$item->OwnerType.'/'.$item->SaleType.'/'.$item->FK_OWNER.'/'.$ownerid.'/'.$item->CurrentPrice); ?>"> <?php echo $this->__('Pay with credits'); ?> </a>
                        </li>
					      																							
                          <?php  } else {?> 
                          
                          <?php   }?> 
                        </ul>
			  
              </div> 
           <div class="view_options">
                       <?php 
						  $nid= $item->ID_NOTICE;
						 $myResponsesTotal=Buyselltrade::getResponsesTotal($nid); ?>
						 
	 <a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/view_notices_responses/'.$item->ID_NOTICE.'/'.$item->OwnerType.'/'.$item->NoticeType.'/'.$item->SaleType); ?>" >
					<?php echo $myResponsesTotal;?>
					     </a>
                        </div>
						 					 
						 
						 <?php } ?>
        
        
        						
</div>
         
       
         <!--  end of notices list --> 
        
		
		<?php endforeach; ?>
	<?php endif; ?>	











<br />
				
                        
                        
                        
                      <p id="total_replies" class="close_arrow"> 
                     <a class="msg" href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/view_notices_responses/'.$item->ID_NOTICE.'/'.$item->OwnerType); ?>" >(<?php echo $myResponsesTotal;?>) responses </a>
                      </p>
                      
                      
              <div class="show_responses">           
              
              
              
              
               <?php $responseslist = Buyselltrade::getResponsesByNotices($item->ID_NOTICE,$item->OwnerType); ?>
					<?php if(isset($responseslist) and !empty($responseslist)):?>
						<?php foreach ($responseslist as $key=>$item2):?>
                        
               
              
               
               
                        
							<div class="rc_response_item2">
                            
                            <!-- name, date and time-->
                            
                            <p class="top_txt"><a href=""><?php echo $item->OwnerName; ?></a> said on 22-11-13
							<?php // echo $item->Date; ?> at 20:30</p>
                            
								<div class="rc_response_comment">
                            
                            
                                            
                                <?php echo $item2->ResponseDetailsLog; ?>
										</div>
                                        
										<div class="reply_profile_photo">
                                        
                                        <img src="../../../global/css/img/avatar_mini.png" width="73" height="60" />
                                        <br />
                                        <a href="" class="owner_id"><?php echo $item->OwnerName; ?></a>
                                        </div>
                                        
                                      
                                        
                                        <div class="rc_response_status">
                                        
										<input id="link_status" name="link_status" type="hidden" value="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES.'/rid/'.$item2->ID_RESPONSE.'/owner/'.$item2->FK_OWNER.'/notice/'.$item->ID_NOTICE).'/status/'; ?>"><label class="stat">&nbsp;</label>
											<?php if ($item2->ResponseStatus=='waiting') { ?>
												<select id="status" name="status" style="width:90px;" onchange="change_status(this);">
													<option value="waiting"><?php echo $this->__('waiting');?></option> 
													<option value="rejected"><?php echo $this->__('reject');?></option> 
													<option value="accepted"><?php echo $this->__('accept');?></option> 
												</select>
											<?php } else {?>
												<p><?php echo $item2->ResponseStatus; ?></p>
											<?php } ?>
                            </form>
                                          
                                             
                                              <!-- reply comment link -->
                                            
   <a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_RESPOND_NOTICES.'/'.$item2->ID_RESPONSE.'/'.$item2->OwnerType); ?>"  class="reply_rs">reply</a>
                                            

                                           
                                    
                                                   
                                            <?php if ($item2->PaymentType =='credits') { 
                                         
						   
						  // $cx = new CurrencyExchange($item->Currency,'EUR');
						   //$credits=round($cx->toCredit($item2->Price));
						   
						   ?>
                            
           <a class="price_icon" href="#"> DKK <span class="blue"><?php  echo $item2->Price; ?></span>credits 
          </a> 
                                                          
          <form action="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_PAYMENTS.'/'.$item->FK_OWNER);?>" method="post">  
          
           <input id="rid" type="hidden"  style="border:none;" readonly name="rid" value=<?php echo $item2->ID_RESPONSE; ?>>  
           <input id="credits" type="hidden"  style="border:none;" readonly name="credits" value=<?php echo $item2->Price; ?>>  
              <input id="ownertype" type="hidden"  style="border:none;" readonly name="ownertype" value=<?php echo $item2->OwnerType; ?>> 
           <input id="noticetype" type="hidden"  style="border:none;" readonly name="noticetype" value=<?php echo $item->NoticeType; ?>> 
           <input id="buyerid" type="hidden"  style="border:none;" readonly name="buyerid" value=<?php echo $ownerid; ?>>
             <input id="saletype" type="hidden"  style="border:none;" readonly name="saletype" value=<?php echo $saletype; ?>> 
              <input id="headline" type="hidden"  style="border:none;" readonly name="headline" value=<?php echo $item->Headline; ?>>
           <input id="sellerid" type="hidden"  style="border:none;" readonly name="sellerid" value=<?php echo $item2->FK_OWNER; ?>> 
           <input id="nid" type="hidden"  style="border:none;" readonly name="nid" value=<?php echo $item2->FK_NOTICE; ?>> 
             <input type="submit"  class="buy_now3" value="<?php echo $this->__('Pay with credits'); ?>">
                                                 
                                                 	<?php }else {} ?> 
										</div>
                                        
									
                                    </div>
										
							</div>
							<br /><br /><br />
						<?php endforeach; ?>
						
					<?php endif; ?>	
				
					<br />
</div>



</form>

</div>




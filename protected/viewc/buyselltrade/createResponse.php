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

<div id="params" ></div>
<div id="demoWrapper">


<form id="rcForm" action="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_RESPOND_NOTICES.'/save_response'); ?>" method="post" class="bbq">

<input id="nid" type="hidden"  style="border:none;" readonly name="nid" value=<?php echo $nid; ?>>
<?php  $commiter_name=''; ?>
<?php if(isset($committer) and !empty($committer)): ?>
		<?php $commiter_name=$committer->NickName; ?>
<?php endif; ?>	
<br />

<span><input id="ownerid" type="text" name="ownerid"  class="subtle_grey" style="border:none; width:50px;" readonly value=<?php echo $ownerid; ?>>&nbsp;<input id="committer" type="text"   class="subtle_grey" style="border:none;" readonly name="committer" value=<?php echo $commiter_name; ?>></span>
<br>
<br />

			
<div id="noticecontainer">
<!-- Notices list start -->
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
             
              
						   <ul class="prod_info">
                      	
                        
                         <li class="cat_icon">Id#<?php echo $item->ID_NOTICE; ?></li>
                         <li class="user_icon"><a href="<?php echo MainHelper::site_url('players/wall');?>">
						<?php echo $item->OwnerName; ?></a>
                        </li>
                        <li class="id_icon"><?php echo $item->CategoryName;  ?> </li> 
						<li class="co_icon"><?php echo ucwords(mb_strtolower($item->CountryName)); ?></li> 
						
                       
					  </ul> 
						 
						        <ul class="description">
                        
                           
                
                 <li class="price_icon"><?php  echo $item->Currency; ?> <span class="blue"><?php  echo $item->CurrentPrice; ?></span></li> 
                         <li class="details_icon"> <li class="details_icon"><a href="#" title="Product Details: <?php  echo $item->Details; ?>" class="masterTooltip">Details</a></li>
                        <li class="date_icon">Posted on<?php // echo $item->TimeCreated; ?></li>
                        <li class="lan_icon"><?php echo $item->LanguageName; ?></li>
					  </ul> 
               
				</div>
                
                         
                <div class="respond">
                
                <ul>
						
                        <br />
            
                
                
                 <?php  if ($noticetype == 'sell') { ?>
                		
						      <!--buy now --> 
                       <li class="buy_now" >

 <a  class="buy_now2" href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_RESPOND_NOTICES.'/'.$item->ID_NOTICE.'/'.$item->OwnerType.'/'.$item->CurrentPrice); ?>" >
 <?php  echo $this->__('Pay with credits'); ?></a></li>
					      
                           
                        <?php
						
						 } else { 
						 
						 }?>
                         
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
                       
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 
						
</div>
        
        
        
        
        
        
        
        
        
		<br />
		<?php endforeach; ?>
	<?php endif; ?>	
</div>	
</div>




<div id="createresponse" class="rounded_5"><br />

  <?php  if ($noticetype == 'buy') { ?>
  
 <label class="respond_label"  >Price</label><input class="input_info"  style="width:60px;" value="<?php echo $item->CurrentPrice; ?>" type="text" name="price"/> 
 
   <label class="respond_label" id="resprice" >Select Payment Type</label> <select  class="response_sel" style="width:200px;height:25px;" valign="top" id="paymenttype" name="paymenttype" >
							
						 
                        <option value="credits" >
                        <?php echo $this->__('Pay with Credits'); ?>
                        </option> 
						    <option value="none"><?php echo $this->__('none'); ?></option>
						</select> 
                        
             <?php            }else { 
			 
			 }?>
                      

<textarea id="ResponseDetailsLog" name="ResponseDetailsLog" > Enter response...</textarea><br />
<input name="ownertype" class="step" value="<?php echo $item->OwnerType; ?>" id="ownertype" type="hidden" readonly>
<input name="createdtime" class="step" value="<?php echo $today = date("d-m-y, H:i"); ?>" id="createdtime" type="hidden" readonly>
<input class="btn_respond2" style="float:right" id="next" value="<?php echo $this->__('Add Response'); ?>" type="submit" />
</div>
</form>

</div>




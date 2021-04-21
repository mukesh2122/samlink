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
<script>
$(document).ready(function()
{
  $("tr:even").css("background-color", "#F7F7F7");
});
</script>



	
<div class="rc_create_notice">


<div id="demoWrapper">

		
          <br />
          <br />   
     
     
     
     
      <?php if(isset($buyercredit) and !empty($buyercredit)){ 
      
        foreach ($buyercredit as $key=>$item){
	
	    $BuyerCredits=$item->CreditAmount; 
         $Buyername=$item->NickName;
		}
	 }
	                                  
		
	
		if($BuyerCredits >= $credits) {
	    
	      $TotalBuyerCredits=$BuyerCredits - $credits;  
	 ?> 

	
	
	
		
                <div id="fieldWrapper">
        
                     <table id="pay_credit">
						<tr>
                        <th align="left"><?php  echo $noticetype == 'sell' ?  $this->__('Notice Id') : $this->__('Response Id');?></th>
                        <th align="left" class="item">Item</th>
                        <th align="left">Price </th>
                        </tr>
                       
                        <tr><td class="item3"> <a  href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES.'/'.$nid.'/'.$ownertype); ?>" >#<?php  echo $noticetype == 'sell' ?  $nid : $rid;?></a></td>
                        <td class="item"> <?php echo $headline; ?>    
                        </td>
                        <td align="left">
						
					<?php echo $credits; ?> credits
                    
						</td>
                        </tr>
                       </table>
                       <br/>
                       
                       
                       
                       	
                       <BR />
                       
                          <table id="credit_overview">
                        <tr><td class="item2" align="left">Available Credits</td>
                        <td align="center">
	
	<?php     
                     echo $BuyerCredits;?>
                     
                     
                        </td>  
                        
                         </tr><tr>
                        <td class="item5" align="right" > <span class="blue"> 
                        <a  href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES.'/'.$nid.'/'.$ownertype); ?>" >
                        <?php  echo $noticetype == 'sell' ? 'Notice Id'.$nid : 'Response Id #'.$rid; ?></a>   Purchase  </span></td>
                        <td align="center" class="item5"> - 
                        
                        <?php  echo $credits;?>
                        
                        </td>
                        </tr>
                        <tr><td class="item2" align="left">Remaining Credits</td><td align="center"><?php echo $TotalBuyerCredits; ?></td></tr>
                           
           
                       </table>
                          <br/> <br/>
  	<?php          	 
      
   if(isset($sellercredit) and !empty($sellercredit)){ 
        
        
                 foreach ($sellercredit as $key=>$item){
	
	         $SellerCredits=$item->CreditAmount;
			 $TotalSellerCredits=$SellerCredits + $credits;
				
				 }
			 }	 
		                      
        
       ?>

<form id="cnForm" action="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_PAYMENTS.'/notices/save'); ?>" method="post" class="bbq">

<input id="nid" readonly name="nid" type="hidden" value=" <?php echo $nid ?>" />
<input id="rid" readonly name="rid" type="hidden" value=" <?php  echo $rid ?>" />
<input id="sellercredits" readonly name="sellercredits" type="hidden" value="<?php echo $TotalSellerCredits ?>" />
<input id="buyercredits" readonly name="buyercredits" type="hidden" value=" <?php echo $TotalBuyerCredits ?> " />
<input id="sellerid" readonly name="sellerid" type="hidden" value="<?php echo $sellerid ?>" />
<input id="buyerid" readonly name="buyerid" type="hidden" value=" <?php echo $buyerid ?> " />
<input id="credits" readonly name="credits" type="hidden" value=" <?php echo $credits ?>" />
<input id="saletype"  type="hidden"  style="border:none;" readonly name="saletype" value=<?php echo $saletype; ?>>
<input id="trans_time" readonly name="trans_time" type="hidden" value=" <?php  echo date("dmyHi"); ?>" />
<input id="noticetype" type="hidden"  style="border:none;" readonly name="noticetype" value=<?php echo $noticetype; ?>> 

<input class="button button_large light_green"  id="next2" name="save_transaction" value="Confirm purchase&nbsp;&nbsp;&nbsp;&nbsp;&gt;" type="submit"  />	
</form>		 
 
 <form  action="<?php  echo MainHelper::site_url(BUYSELLTRADE_NOTICES); ?>" method="post" class="bbq">   
<input class="btn_cancel" value="cancel" name="Cancel" type="submit"  />
    
    
  <?php   
    
}else{
                          
		 
		 
?>		 
                          
  
                     <table id="pay_credit">
						<tr>
                        <th align="left">PlayerId</th>
                        <th align="left" class="item">&nbsp;</th>
                        <th align="left">Available Credits </th>
                        </tr>
                       
                        <tr><td>&nbsp<?php echo $Buyername; ?> </td>
                        <td class="item">&nbsp;    
                        </td>
                        <td align="center">
						&nbsp;
					<?php echo $BuyerCredits; ?> credits
                    
						</td>
                        </tr>
                       </table>

<br />



 <p class="saldo" >
 <span class="subtotal"><a  href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES.'/'.$nid.'/'.$ownertype); ?>" >
 
 <?php  echo $noticetype == 'sell' ?  $this->__('Notice Id #'.$nid) : $this->__('Response Id #'.$rid);?> </a></span>

 <?php echo $credits; ?> credits</p>
 <br />
<br />
<br />
<p class="form_widget_upgrade3"> You don't have enough credits to make this purchase.</p>



  <form id="cnForm" action="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_BUYCREDITS);?>" method="post" class="bbq">
<input class="button button_large light_green"  id="next2" name="next" value="Buy Credits&nbsp;&nbsp;&gt;" type="submit"  />
	
    
	</form>		
				
  
  
    <?php   
    
}
                          
		 
		 
?>	
       

  				
				</div>

		</div>
		</div>
	

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


<div class="list_container filter_options">

		<div class="list_header">
			<h1><?php echo $headerName;?></h1>
		</div>

<div class="rc_create_notice">

<div id="demoWrapper">

<script>
$(document).ready(function() {
 
 $('.btn_print').click(function() {
  window.print();
  return false;
 });
});
</script>







	<?php if(isset($transactList) and !empty($transactList)){ 
        
        
                 foreach ($transactList as $key=>$item){
	
	 $sid=$item->ID_SELLER;   
	 $bid=$item->ID_BUYER;
	$ownertype='player';
    $sellerName = Buyselltrade::getownerinfo($sid,$ownertype); 
    $buyerName = Buyselltrade::getownerinfo($bid,$ownertype); 
 
 



		
	?>	
    
    <br />
    

   <h3 class="h3details">Thank you for your purchase.</h3>
  

  <br />	

<p class="form_widget_upgrade3"> Your payment has been successfully transferred. An email with the details of this transaction will be sent to your account shortly.</p>
<br />
<br />



  
  <h3 class="h3details">Transaction Nr <?php echo $tid; ?></h3>
  
  <br />
  <br />	

 <table id="pay_credit">
						<tr>
                        <th align="left"> <?php  echo $this->__('Notice Id #') ?> </th>
                        <th align="left" > <a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES.'/'.$item->FK_NOTICE.'/'.$ownertype); ?>" >
						<?php  echo  $item->FK_NOTICE ?> </a></th>
                        </tr>
                        
                       <tr>
                        <td align="left" >Seller</td><td align="left">
                        <a href="<?php echo MainHelper::site_url('players/wall');?>"><?php echo $sellerName->NickName;?></a> </td></tr>
                        <tr><td align="left">Buyer</td><td align="left">
                        <a href="<?php echo MainHelper::site_url('players/wall');?>"><?php echo $buyerName->NickName; ?></a> </td></tr>
                      
                       <tr><th align="left" class="item2"><b>Amount </b> </th><th align="left"><b><?php echo $item->Credits; ?> credits</b></th></tr>
               
                       </table>
                       
                       <br />
                       <br />
                                                                                                   
			<form id="cnForm" action="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES);?>" method="get" class="bbq">
<input class="button button_large light_green"  id="next2" value="continue shopping&nbsp;&nbsp;&gt;" type="submit"  />
	
	</form>		
     <a class="btn_print" href="#">print this page</a> 
       
</div>			
            
            
  </div>  
 	<?php 
  	 }
	}
		 ?>        
            
            

		</div>

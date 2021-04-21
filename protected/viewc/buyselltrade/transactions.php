<?php $isEnabledTranslate = MainHelper::IsModuleEnabledByTag('translations');
?>

<ul class="horizontal_tabs clearfix">
	<li >
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
	
	<li class="active">
		<a  href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_TRANSACTIONS);?>" class="icon_link" >
        <i class="games_tab_icon"></i><?php echo $this->__('Transactions');?></a>
	</li>

</ul>

<br />


   <h3 class="h3details">Transactions History</h3>
   <br />
   <br/>
   
   
<?php if(!empty($transactionsList)):?>
	<!-- Shop history start -->
	<table class="transaction_items">
		<tr>
			<th>
				<span class="flag shop_flag"><?php echo $this->__('Transaction Nr'); ?></span>
			</th>
			<th>
				<?php echo $this->__('Seller'); ?>
			</th>
			<th>
				<?php echo $this->__('Buyer'); ?>
			</th>
            	<th>
				<?php echo $this->__('Credits'); ?>
			</th>
			<th>
				<?php echo $this->__('NoticeId'); ?>
			</th>
            <th>
				<?php echo $this->__('Date'); ?>
			</th>
		</tr>
		<?php foreach($transactionsList as $key=>$item):?>
        
        <?php
                	 
	$ownertype='player';
    $sellerName = Buyselltrade::getownerinfo($item->ID_SELLER,$ownertype); 
    $buyerName = Buyselltrade::getownerinfo($item->ID_BUYER,$ownertype); 

        ?>
        
        
			<?php $class = $key % 2 == 0 ? '' : 'even_rows_bg2';?>
			<tr class="shop_item">
				<td class="clearfix <?php echo $class ?>">
                
					<?php echo $item->ID_TRANSACTION;?>
				</td>
                <td class="shop_item_meta tar <?php echo $class ?>">
				<?php echo $sellerName->NickName;  ?>
				</td><td class="shop_item_meta tar <?php echo $class ?>">
					<?php echo	$buyerName->NickName;?>
				</td>
				<td class="shop_item_meta <?php echo $class ?>">
					<?php echo $item->Credits;?>
				</td>
                <td class="shop_item_meta tar <?php echo $class ?>">
                <a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES.'/'.$item->FK_NOTICE.'/'.$ownertype); ?>" >
					<?php echo	$item->FK_NOTICE;?>
                    </a>
				</td><td class="shop_item_meta tar <?php echo $class ?>">
					<?php echo	$item->TransactionTime;?>
				</td>
				
			</tr>
		<?php endforeach;?>
	</table>
	<!-- Shop history end -->
    
	<?php if(isset($pager)):?>
		<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)) ?>
	<?php endif; ?>
<?php else: ?>
	<div class="noItemsText"><?php echo $this->__('You have not made any transactions.'); ?></div>
<?php endif; ?>


<BR />
<BR />
<!-- Cash out start -->
<div class="cash_out grey_box rounded_5">
	<div class="box_header">
		<h3><?php echo $this->__('Cash Out') ?></h3>
	</div>

	<form method="post">
		<label for="iban"><?php echo $this->__('IBAN');?></label>
		<input type="text" id="iban" class="text_input" name="iban" value="" />
		
		<label for="swift"><?php echo $this->__('SWIFT');?></label>
		<input type="text" id="swift" class="text_input" name="swift" value="" />
				
		<label for="amount"><?php echo $this->__('Amount');?></label>
		<input type="text" id="amount" class="text_input" name="amount" value="" />
	</form>
</div>
<!-- Cash out end -->

<!-- Cash out pay start -->
<div class="shop_footer clearfix">
	<a class="button button_large light_green"><?php echo $this->__('Cash Out Now'); ?></a>
	<p class="shop_info">
		<?php echo $this->__('This will complete your Cash Out and the amount will be transferred to your bank account.'); ?>
	</p>
</div>
<div class="shop_ext_inf">
	<?php echo $this->__('Notice! It is only possible to cash out Credits. The minimum Cash Out Amount is [_1] Credits. The Cash Out Fee is [_2] Credits and will be deducted from your Account. Read our [_3] to learn more about PlayNations Cash Out Policy.', array(100, 20, '<a href="#">'.$this->__('Terms of Service').'</a>')); ?>
</div>
<!-- Cash out pay end -->

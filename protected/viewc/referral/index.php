<?php include('common/top.php'); ?>
<?php
	$clicksCount= 0;
	$signupCount = 0;
	$paymentCount = 0;
	$paymentTotal = 0;
	$player = User::getUser();
?>

<form class="filter_referrals" method="get" action="<?php echo MainHelper::site_url('referral');?>" id="filterReferral">
	<span class="filter_type"><?php echo $this->__('Select Period');?>:</span>
	<input type="text" id="affiliateFrom" class="text_input w100px datepicker-new" value="<?php echo date(DATE_SHORT, $timeFrom);?>" />
	&nbsp;-&nbsp;
	<input type="text" id="affiliateTo" class="text_input w100px datepicker-new" value="<?php echo date(DATE_SHORT, $timeTo);?>" />
	<input class="button button_medium light_grey" type="submit" value="<?php echo $this->__('Filter');?>" />
</form>

<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt15">
	<thead>
		<tr>
			<th class="size_40"><?php echo $this->__('Referral Codes');?></th>
			<th class="size_20 centered"><?php echo $this->__('Clicks');?></th>
			<th class="size_20 centered"><?php echo $this->__('Sign-ups');?></th>
			<th class="size_20 centered"><?php echo $this->__('Upgrades');?></th>
			<th class="size_20 centered"><?php echo $this->__('Commission');?></th>
		</tr>
	</thead>
	<tbody>
		<?php if(isset($assignedCodes) and !empty($assignedCodes)):?>
			<?php foreach($assignedCodes as $code):?>
				<tr>
					<td>
						<a href="<?php echo MainHelper::site_url('referral/edit/'. $code->VoucherCode);?>"><?php echo $code->DisplayName;?></a>
						<div><a href="<?php echo MainHelper::site_url('referral/codes/'. $code->VoucherCode);?>"><?php echo $this->__('Codes and Banners');?></a></div>
					</td>
					<td class="centered"><?php echo $code->ClickCount ? $code->ClickCount : 0; $clicksCount += $code->ClickCount; ?></td>
					<td class="centered"><?php echo $code->SignupCount ? $code->SignupCount : 0; $signupCount+= $code->SignupCount;?></td>
					<td class="centered"><?php echo $code->PaymentCount ? $code->PaymentCount : 0; $paymentCount+= $code->PaymentCount;?></td>
					<td class="centered"><?php echo MainHelper::creditsOutput($code->PaymentTotal); $paymentTotal+= $code->PaymentTotal;?></td>
				</tr>
			<?php endforeach;?>
		<?php endif;?>
		<tr>
			<td>
				<?php echo $this->__('Totals');?>
			</td>
			<td class="centered"><?php echo $clicksCount;?></td>
			<td class="centered"><?php echo $signupCount;?></td>
			<td class="centered"><?php echo $paymentCount;?></td>
			<td class="centered"><?php echo MainHelper::creditsOutput($paymentTotal);?></td>
		</tr>
	</tbody>
</table>
<?php if($player->canCreateReferrers == 1):?>
	<a href="<?php echo MainHelper::site_url('referral/create-referral-code');?>" class="button button_large light_blue mt15"><?php echo $this->__('Create Referral Code');?></a>
<?php endif;?>

<?php if(isset($subReferals) and !empty($subReferals) and $player->canCreateReferrers == 1):?>
<?php
	$clicksCount= 0;
	$signupCount = 0;
	$paymentCount = 0;
	$paymentTotal = 0;
?>
<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt15">
	<thead>
		<tr>
			<th class="size_40"><?php echo $this->__('Subreferral Codes');?></th>
			<th class="size_20 centered"><?php echo $this->__('Clicks');?></th>
			<th class="size_20 centered"><?php echo $this->__('Sign-ups');?></th>
			<th class="size_20 centered"><?php echo $this->__('Upgrades');?></th>
			<th class="size_20 centered"><?php echo $this->__('Commission');?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($subReferals as $code):?>
			<tr>
				<td>
					<a href="<?php echo MainHelper::site_url('referral/edit-subreferral/'. $code->VoucherCode);?>"><?php echo $code->DisplayName;?></a>
				</td>
				<td class="centered"><?php echo $code->ClickCount ? $code->ClickCount : 0; $clicksCount += $code->ClickCount; ?></td>
				<td class="centered"><?php echo $code->SignupCount ? $code->SignupCount : 0; $signupCount+= $code->SignupCount;?></td>
				<td class="centered"><?php echo $code->PaymentCount ? $code->PaymentCount :0; $paymentCount+= $code->PaymentCount;?></td>
				<td class="centered"><?php echo MainHelper::creditsOutput($code->PaymentTotal); $paymentTotal+= $code->PaymentTotal;?></td>
			</tr>
		<?php endforeach;?>
	</tbody>
	<tfoot>
		<tr>
			<td>
				<?php echo $this->__('Totals');?>
			</td>
			<td class="centered"><?php echo $clicksCount;?></td>
			<td class="centered"><?php echo $signupCount;?></td>
			<td class="centered"><?php echo $paymentCount;?></td>
			<td class="centered"><?php echo MainHelper::creditsOutput($paymentTotal);?></td>
		</tr>
	</tfoot>
</table>

<?php endif;?>

<?php if($player->canCreateReferrers == 1):?>
	<a href="<?php echo MainHelper::site_url('referral/create-subreferral-code');?>" class="button button_large light_blue mt15"><?php echo $this->__('Create Subreferral Code');?></a>
<?php endif;?>


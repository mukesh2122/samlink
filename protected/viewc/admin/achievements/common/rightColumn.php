<?php
	$playerSuspend = $user->getSuspendedHistory();
	$isSuspended = $user->isSuspended();
	?>

<h3><?php echo $this->__('Suspending'); ?></h3>
<ul class="vertical_tabs">
	<li>
		<a href="<?php echo MainHelper::site_url('admin/users/neweditsuspend/'.$user->ID_PLAYER); ?>"><?php echo $this->__('Add suspending');?></a>
	</li>
</ul>

<?php
	$timeToday = strtotime(date("Y-m-d"));
?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered ">
		<thead>
			<tr>
				<th colspan=2">
					<?php echo $this->__('Current status'); ?>
					<a class="pull_right" href="<?php echo MainHelper::site_url('admin/users/cancelsuspend/'.$user->ID_PLAYER); ?>"><?php echo $this->__('Cancel'); ?></a>
				</th>
			</tr>
		</thead>
		<tbody>
				<tr>
					<td>
	<?php
		$sus = $user->getSuspendStatus();

		if ($sus!=null)
		{
			$Reason = $sus['Reason'];
			$Level = $sus['Level'];
			$Unlimited = $sus['Unlimited'];
			$StartDate = $sus['StartDate'];
			$EndDate = $sus['EndDate'];
			$timeStart = strtotime($StartDate);
			$timeEnd = strtotime($EndDate);
			$Days = $sus['Days'];
			?>
				<p>
					<?php if (1==2): ?>
						<a href="<?php echo MainHelper::site_url('admin/users/neweditsuspend/'.$user->ID_PLAYER); ?>"><?php echo $this->__('Edit'); ?></a><br/>
					<?php endif;?>

					<?php if ($Level==4): ?>
						<b><?php echo date(DATE_SHORT,$timeStart); ?></b>
					<?php else:?>
						<b><?php echo date(DATE_SHORT,$timeStart)."</b> " . $this->__('to') . " <b>".date(DATE_SHORT,$timeEnd); ?></b><br/> 
						<b><?php echo $Days . " " . $this->__('day(s)'); ?></b>
					<?php endif;?>
				</p>
				<p>
					<?php echo $this->__('Reason') . ": <b>{$Reason}</b>"; ?>
				</p>
				<p>
					<?php echo $this->__('Level') . ": <b>{$Level} - " . Mainhelper::GetSuspendLevelText($Level) . "</b>"; ?>
				</p>
			<?php
		}
		else
		{
			echo $this->__('Active user');
		}
	?>
					</td>
				</tr>
		</tbody>
	</table>



<?php if (count($playerSuspend)>0): ?>
	<br/>
	<table cellspacing="0" cellpadding="0" class="table table_bordered ">
		<thead>
			<tr>
				<th colspan=2">
					<?php echo $this->__('History'); ?>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$c = 0;
			foreach ($playerSuspend as $sus)
			{
				$Reason = $sus['Reason'];
				$Level = $sus['Level'];
				$Unlimited = $sus['Unlimited'];
				$StartDate = $sus['StartDate'];
				$EndDate = $sus['EndDate'];
				$timeStart = strtotime($StartDate);
				$timeEnd = strtotime($EndDate);
				$Days = $sus['Days'];
				?>
				<tr>
					<td>
						<p>
							<?php if ($Level==4): ?>
								<b><?php echo date(DATE_SHORT,$timeStart); ?></b>
							<?php else:?>
								<b><?php echo date(DATE_SHORT,$timeStart)."</b> " . $this->__('to') . " <b>".date(DATE_SHORT,$timeEnd); ?></b><br/> 
								<b><?php echo $Days . " " . $this->__('day(s)'); ?></b>
							<?php endif;?>
						</p>
						<p>
							<?php echo $this->__('Reason') . ": <b>{$sus['Reason']}</b>"; ?>
						</p>
						<p>
							<?php echo $this->__('Level') . ": <b>{$sus['Level']} - " . Mainhelper::GetSuspendLevelText($sus['Level']) . "</b>"; ?>
						</p>
					</td>
				</tr>
				<?php
				$c++;
			}
			?>
		</tbody>
	</table>
<?php endif; ?>

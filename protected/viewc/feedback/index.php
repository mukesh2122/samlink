<?php echo '<p><h1>'.$this->__('My Tickets').' ('.count($feedbackreports).')</h1>&nbsp;</p>'; ?>

<div class="clearfix" style="float:left; clear:both; width:100%;">
	<p>
       <img src="<?php echo MainHelper::site_url('global/img/icon-feedback-ima.64x32.png'); ?>" alt="Create Feedback" title="Create Feedback"/>
	   <i><?php echo $this->__('We encourage all users to share with us your suggestions and ideas for our site.')?></i>
	</p>
</div>

<div id="spinner" class="ajax_spinner clearfix" style="display:none;">
	<img id="img-spinner" src="<?php echo MainHelper::site_url('global/img/ajax-loader.gif'); ?>" alt="Loading ..." />
</div>

<?php echo '<p>&nbsp;</p><p>&nbsp;</p>' ?>

<?php if (isset($feedbackreports) and !empty($feedbackreports)) { ?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered">
					<a href="<?php echo MainHelper::site_url('players/feedback'.(isset($typeFilter) ? "/".$typeFilter : '').'/sort/Created/'.(isset($sortType) && $sortType == 'Created' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo $this->__('Created').($sortType == 'Created' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
				<th class="size_10 centered">
					<a href="<?php echo MainHelper::site_url('players/feedback'.(isset($typeFilter) ? "/".$typeFilter : '').'/sort/Type/'.(isset($sortType) && $sortType == 'Type' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo 'Type'.($sortType == 'Type' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
				<th class="size_10 centered">
					<a href="<?php echo MainHelper::site_url('players/feedback'.(isset($typeFilter) ? "/".$typeFilter : '').'/sort/Status/'.(isset($sortType) && $sortType == 'Status' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo 'Stat'.($sortType == 'Status' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
				<th class="size_40 centered">
					<a href="<?php echo MainHelper::site_url('players/feedback'.(isset($typeFilter) ? "/".$typeFilter : '').'/sort/ErrorName/'.(isset($sortType) && $sortType == 'ErrorName' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo 'Subject'.($sortType == 'ErrorName' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
				<th class="size_10 centered">
					<a href="<?php echo MainHelper::site_url('players/feedback'.(isset($typeFilter) ? "/".$typeFilter : '').'/sort/LastUpdatedTime/'.(isset($sortType) && $sortType == 'LastUpdatedTime' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo 'Updated'.($sortType == 'LastUpdatedTime' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
				<th class="size_10 centered"><?php echo $this->__('Action'); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($feedbackreports as $fbreport):?>
				<tr>
					<td class="centered"><?php echo MainHelper::calculateTime($fbreport->CreatedTime, 'd/m-y G:i');?></td>
					<td class="centered"><?php echo $types[$fbreport->ReportType];?></td>
					<td class="centered"><?php echo $errorstatuses[$fbreport->ErrorStatus];?></td>
					<td class="centered"><?php echo $fbreport->ErrorName;?></td>
					<td class="centered"><?php echo MainHelper::calculateTime($fbreport->LastUpdatedTime, 'd/m-y G:i');?></td>
					<td class="centered"><a href="<?php echo MainHelper::site_url('players/feedback/edit/'.$fbreport->ID_ERROR);?>"><?php echo $this->__('Edit');?></a></td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
<?php } else { echo '<p>'.$this->__('You have no existing tickets.').'</p>'; } ?>

<?php
	if (isset($pager))
	{
		echo $this->renderBlock('common/pagination', array('pager'=>$pager));
	}
?>

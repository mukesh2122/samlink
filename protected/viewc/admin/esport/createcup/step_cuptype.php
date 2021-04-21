<div class="mt10">
	<h3 style="color:white;"><?php echo $this->__('Cup Type'); ?></h3>
	<div class="ct_page_area">
		<form id="SingleElimForm" class="team_size_form" action="<?php echo MainHelper::site_url('esport/admin/createcup/1');?>" method="post">
			<input name="CreateStep" type="hidden" value="0"/>
			<input name="CupType" type="hidden" value="SingleElimination"/>
			
			<div>	
				<button type="submit" class="button_medium red rounded_5 ct_btn ct_cupfix mt20" style="width:150px"><?php echo $this->__('Single Elimination'); ?></button>
				<div class="mt15">
					<p style="color:white;"><?php echo $this->__('Teams are first arranged into groups where each team plays against each other team. <br />
					The winning teams from each group are then placed into elimination eliminaton brackets'); ?></p>
				</div>
			</div>
		</form>

		<form id="DoubleElimForm" class="team_size_form" action="<?php echo MainHelper::site_url('esport/admin/createcup/1');?>" method="post">
			<input name="CreateStep" type="hidden" value="0"/>
			<input name="CupType" type="hidden" value="DoubleElimination"/>
			<div>	
				<div class="mt15">
					<button type="submit" class="button_medium red rounded_5 ct_btn ct_cupfix mt20" style="width:150px"><?php echo $this->__('Double Elimination'); ?></button>
				</div>
				<div class="mt15">
					<p style="color:white;">
					<?php echo $this->__('Teams are placed into brackets, and eliminate eachother until only one remains
					Single and double elimination both supported (can be changed mid-tournament)'); ?>
					</p>
				</div>
			</div>
		</form>
	</div>	
</div>
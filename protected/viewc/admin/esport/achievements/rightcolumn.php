<div class="esports_right_column">
	<!-- Header start -->
	<div id="news_header">
		<img src="<?php echo MainHelper::site_url('global/img/icon.png');?>" alt=""/>
		<span>E-Sport Admin - Achievements</span>
	</div>
	<!-- Header end -->

	
<form name="ladderform"  method="post" action="<?php echo MainHelper::site_url('esport/admin/editachievement'); ?>">
	<input type="hidden" name="action" value="submitall" />
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered"><?php echo $this->__('Team / Player');?></th>
				<th class="size_10 centered"><?php echo $this->__('Achievements');?></th>
			</tr>
		</thead>

		<tbody>

	<?php
		$p = User::getUser();
		$esport = new Esport();
		$playmodes = $esport->GetPlayModes();
		$teams = $esport->GetTeams();
		
		foreach ($teams as $team):
			$ID_TEAM = $team['ID_TEAM'];
			$achievements = $esport->GetAchievements($ID_TEAM);
		?>
			<tr>
				<td class="size_10 centered">
					<?php
						echo $team['DisplayName'];
					?>
				</td>
				<td class="size_40">
					<?php
						foreach ($achievements as $ac)
						{
							echo '<img height="50px" src="'.MainHelper::site_url("global/pub_img/esport/achievements/".$ac['Image']).'" />'."{$ac['Title']}";
							$oc = "if (!confirm('Are you sure?')) return false;";
							echo '<a onclick="'.$oc.'" href="'.MainHelper::site_url("esport/admin/deleteachievement/".$ac['ID_ACHIEVEMENT']).'" >'.$this->__('Delete').'</a><br/>';
						}
					?>
					<a href="<?php echo MainHelper::site_url("esport/admin/editachievement/".$ID_TEAM); ?>"><?php echo $this->__('Add achievement'); ?></a>

				</td>
			</tr>
	<?php
		endforeach; ?>
		</tbody>
	</table>
	
</form>
	
	
	
</div>

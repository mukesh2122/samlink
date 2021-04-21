<div class="esports_right_column">
	<!-- Header start -->
	<div id="news_header">
		<img src="<?php echo MainHelper::site_url('global/img/icon.png');?>" alt=""/>
		<span><?php echo $this->__('E-Sport Admin'); ?></span>
	</div>
	<!-- Header end -->

	<div class="tournament_buttons mt10 mb10 pull_left">
		<a class="button red pull_left w110" href="createleague"><?php echo $this->__('Create League'); ?></a><br/>
		<a class="button red pull_left mt10 w110" href="createcup"><?php echo $this->__('Create Cup'); ?></a>
	</div>
	<!--<div class="mt10">
		<a class="button button_medium light_blue" href="admin/editcontent">Edit default league text</a>
	</div>-->
	

	
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_25 centered"><?php echo $this->__('Type');?></th>
				<th class="size_25 centered"><?php echo $this->__('League');?></th>
				<th class="size_25 centered"><?php echo $this->__('Game');?></th>
				<th class="size_10 centered"><?php echo $this->__('Playmode');?></th>
				<th class="size_5 centered"><?php echo $this->__('Action');?></th>
			</tr>
		</thead>

		<tbody>

	<?php
		$p = User::getUser();
		$esport = new Esport();
		$playmodes = $esport->GetPlayModes();
		$tournaments = $esport->GetAllTournaments('','',false);
		//$tournaments = array_merge($tournaments,$esport->GetAllTournaments('','Cup'));

		foreach ($tournaments as $tournament): 
			$TournamentType = $tournament['TournamentType'];
			$LeagueName = substr($tournament['LeagueName'],0,20);
			$StartTime = $tournament['StartTime'];			
			$game = Games::getGameByID($tournament['ID_GAME']);
			$playmode = array_search($tournament['PlayMode'], $playmodes);
			$leaguefile = ($TournamentType=="Cup") ? 'createcup/1' : 'createleague';
		?>
			<tr>
				<td class="size_25 centered"><?php echo $TournamentType; ?></td>
				<td class="size_25 centered"><?php echo $LeagueName; ?></td>
				<td class="size_25 centered"><?php echo $game->GameName; ?></td>
				<td class="size_25 centered"><?php echo $playmode; ?></td>
				<td class="size_5 centered">
                                    <a class="edit_icon" title="edit" href="<?php echo MainHelper::site_url('esport/admin/'.$leaguefile.'/'.$tournament['ID_LEAGUE']);?>" />
                                    <a class="delete_icon" title="delete" href="<?php echo MainHelper::site_url('esport/admin/deletetournament/'.$tournament['ID_LEAGUE']);?>" />
                                </td>
			</tr>
	<?php endforeach; ?>
		</tbody>
	</table>
	
	
	
	
</div>

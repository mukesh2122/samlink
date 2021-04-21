<!--@using ESport.Frontend.Model;
@model ESportVM

@{
LeagueVM league = (LeagueVM)Model.SelectedTournament;
IList<ESport.Model.Match> openMatches = league.InstantMatches;
}-->

<div class="esport_action_box mt25">
<span class="esport_action_header"><?php echo $this->__('Play Quick Match'); ?></span>
<div class="esport_action_types">
	<!-- 

	Knappen skal have forskellige classes, alt efter hvilken slags quick match man har valgt:
	Hvis du har valgt "Play for Free" skal den have classen "light_blue".
	Hvis du har valgt "Play for Coins" skal den have classen "purple".
	Hvis du har valgt "Play for Credits" skal den have classen "mint".

	Hvis brugeren ikke er logget ind eller der skal gives andre fejlmeddelelser, spytter du
	naturligvis bare ren tekst ud inde i denne div.

		-->
	<?php
		if(Auth::isUserLogged() === TRUE)
		{
			?>
				<form id="QuickMatchSignup" action="Ajax/QuickMatchSignup" class="ajax">
					<input name="Stake" value="0" type="hidden"/>
					<input type="hidden" name="LeagueID" value="@league.ID"/>
					<?php
						foreach ($leagues as $league)
						{
							$ID_LEAGUE = $league['ID_LEAGUE'];
							$playmode = array_search($league['PlayMode'], $playmodes);
							$betEnabled = ($playmode=='Free2Play') ? 'hidden' : 'text';
							
						?>
							<input style="width:50px;" type="<?php echo $betEnabled; ?>" id="league<?php echo $ID_LEAGUE; ?>" value="0" />
							<a onclick="var v=league<?php echo $ID_LEAGUE; ?>.value;
								v = parseInt(v);if (v<0){v=0;alert('<?php echo $this->__('Indsatsen skal være positiv'); ?>');return false;};
								window.location='<?php echo MainHelper::site_url('esport/quickmatchsignup/'.$league['ID_LEAGUE'].'/'.$league['PlayMode'].'/'); ?>'+v;" 
								class="" 
								href="#">
								Sign up for quick match (<?php echo $playmode; ?>)
								</a>
							</br>
						<?php
						}
						?>
				</form>
			<?php
/*								if (league.CanUserCreateQuickMatch)
			{
				ESport.Model.Match match = Model.CurrentParticipant.GetOpenMatchForLeague(league);
				if (match != null)
				{
					<a class="button button_medium red btn" href="#CancelQuickMatch/@(match.MatchID)">Sign out from quick match</a>
				}
				else 
				{
					//if (league.League.PlayMode == ESport.BaseLib.PlayMode.Free2Play)
					//{
						<form id="QuickMatchSignup" action="Ajax/QuickMatchSignup" class="ajax">
							<input name="Stake" value="0" type="hidden"/>
							<input type="hidden" name="LeagueID" value="@league.ID"/>
							<a class="button button_medium light_blue" onclick="$('#QuickMatchSignup').submit();" href="javascript:void(0)">Sign up for quick match</a>
						</form>
					//}
					else
					{
						<form id="GetQuickMatchSignup" action="Ajax/GetQuickMatchSignup" class="popup">
							<input type="hidden" name="LeagueID" value="@league.ID"/>
							<a class="button button_medium light_blue" onclick="$('#GetQuickMatchSignup').submit();" href="javascript:void(0)">Sign up for quick match</a>
						</form>
					}
				}
			}
			else
			{
				@("You have to sign up for the league to be able to play Quick Match in the league")
			}*/
		}
		else
		{
			echo $this->__("You have to sign in to play a quick match");
		}
	?>
	 
</div>
</div>

<table class="table table_striped table_bordered gradient_thead mt25">
	<thead>
		<tr>
			<th>
				Rating
			</th>
			<th>
				Name
			</th>
			<th>
				Stake
			</th>
			<th>
				Challenge
			</th>
		</tr>
	</thead>

	<tbody>
		<?php
			foreach ($openMatches as $match)
			{
				?>
				<tr>
					<td>
						<?php echo $match['ChallengerRatingBefore']; ?>
					</td>
					<td>
						<?php echo $match['DisplayName']; ?>
						<!--<a href="@ESHelpers.Url("Participant", m.ChallengerID)"></a>-->
					</td>
					<td>
						<?php echo $match['BetSize']; ?>
					</td>
					<td>
						<?php
							if ($p->ID_TEAM != $match['ChallengerID'])
							{
								?>
								<a href="<?php echo MainHelper::site_url('esport/instantchallenge/'.$match['ID_MATCH']); ?>"  class="btn">Challenge</a>
								<?php
							}
							/*
							@if ((league.CanUserEdit) && (Model.CurrentParticipant.ParticipantID != m.ChallengerID))
							{
								<a href="#InstantChallenge/@(<?php echo $match['ID_MATCH']; ?>)"  class="btn">Challenge</a>
							}
							*/
						?>
					</td>
				</tr>
				<?php
			}
		?>
	</tbody>
</table>
<?php //echo "ID_GAME: $ID_GAME";//$this->renderBlock('esport/admin/createleague/main',$list); ?>
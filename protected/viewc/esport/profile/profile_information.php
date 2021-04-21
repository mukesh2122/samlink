<?php
	$player = $profile['player'];
	$teams = $profile['teams'];
	$games = $profile['games'];
        $singleteam = $profile['singleteam'];
	$maxplayedgame = $profile['maxplayedgame'];
?>
<div class="profile_information">
	<table>
		<tr>
			<td><?php echo $this->__('Playername').':'; ?></td>
			<td><?php echo $player->NickName; ?></td>
		</tr>
		<tr>
			<td><?php echo $this->__('Age').':'; ?></td>
			<td><?php echo PlayerHelper::calculateAge($player->DateOfBirth); ?></td>
		</tr>
		<tr>
			<td><?php echo $this->__('Most played').':'; ?></td>
			<td><?php if (isset($maxplayedgame['GameName'])){echo $maxplayedgame['GameName'];} ?></td>
		</tr>
                <?php if(!empty($singleteam) && $player->ID_TEAM == $singleteam->ID_TEAM): ?>
		<tr>
			<td><?php echo $this->__('Account').':'; ?></td>
			<td><?php echo $singleteam->Credits;?> Credits <br/>
                            <?php echo $singleteam->Coins; ?> Coins
                        </td>
		</tr>
                <?php endif; ?>
		<tr>
			<td><?php echo $this->__('Team').':'; ?></td>
			<td><?php foreach ($teams as $team)
				echo $team->DisplayName . "<br/>"; 
                        ?>
			</td>
		</tr>
	</table>
</div>
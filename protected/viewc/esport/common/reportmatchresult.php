<?php
    $esport = new Esport();
    $p1 = $esport->getPlayerByTeam($challenger->ID_TEAM);
    $p2 = $esport->getPlayerByTeam($opponent->ID_TEAM);
?>
<form name="reportscoreform" class="esport_overlay" method="post" action="<?php echo MainHelper::site_url('esport/reportmatchresult'); ?>">
	<input type="hidden" name="action" value="reportmatchresult" />
	<input type="hidden" name="ID_MATCH" value="<?php echo $ID_MATCH; ?>" />
	<input type="hidden" name="whoreports" value="<?php echo $whoreports; ?>" />
        <div class="esport_profile_boxheaders pr20 mb20" style="margin-top:-10px;margin-left:-10px;"><p><?php echo $this->__('Report matchresult'); ?></p></div>
	<table style="text-align:center;width:100%;">
		<tr>
			<td>
				<?php echo $challenger->DisplayName; ?>
				<?php if ($ChallengerID==$ID_TEAM) echo $you; ?>
			</td>
			<td style="height:30px; font-size:20px;">
				VS
			</td>
			<td>
				<?php echo $opponent->DisplayName; ?>
				<?php if ($OpponentID==$ID_TEAM) echo $you; ?>
			<td>
		</tr>
		<tr>
			<td style="height:100px;">
                                <?php echo MainHelper::showImage($p1, THUMB_LIST_80x80, false, array('no_img' => 'noimage/no_player_80x80.png')); ?>
			</td>
			<td >
			</td>
			<td>
				<?php echo MainHelper::showImage($p2, THUMB_LIST_80x80, false, array('no_img' => 'noimage/no_player_80x80.png')); ?>
			<td>
		</tr>
		<tr>
			<td>
				<input type="text" class="text_input w70" name="challengerscore" value="0" />
			</td>
			<td>
				-
			</td>
			<td>
				<input type="text" class="text_input w70" name="opponentscore" value="0" />
			<td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
			</td>
			<td>
				<input class="button button_auto light_blue pull_right mt10" name="submit" type="submit" value="<?php echo $this->__('Submit'); ?>" />
			<td>
		</tr>
	</table>
</form>
<script>
    if($('.fancybox-skin').length){
        $('.fancybox-skin').css('background','rgb(52,53,54)');
    }
</script>
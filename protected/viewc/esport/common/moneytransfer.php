<?php
    $esport = new Esport();
    $team = $esport->getTeambyID($profile['player']->ID_TEAM);
?>
<!-- Credit transfer begins -->
<div id="game_chooser" class="h85 mih0">
	<h2 class="mb0"><?php echo $this->__('eSport account'); ?></h2>
	<a id="playquickmatch" class="mb5" href="<?php echo MainHelper::site_url('esport/moneytransfer/'.$profile['player']->ID_TEAM); ?>"><?php echo $this->__('Transfer credits'); ?></a>
        <p><span><?php echo $team->Credits; ?></span> Credits / <span><?php echo $team->Coins; ?></span> Coins</p>
</div>
<!-- Credit transfer ends -->
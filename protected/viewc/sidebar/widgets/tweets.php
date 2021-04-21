<?php
	$twitterID = $player->TwitterID;
?>
<div class="widget tweets" data-state="<?php echo ($isOpen == 1) ? 'open' : 'closed'; ?>" data-id="<?php echo $widgetId; ?>">
	<div class="top">
		<h3><?php echo $widgetName; ?></h3>
		<span class="slide-icon" title="<?php echo ($isOpen == 1) ? 'Collapse' : 'Expand'; ?> this widget.">&#9660;</span>
		<span class="close-icon" title="Hide this widget.">X</span>
	</div>
	<div class="widget-body">
		<?php
			if ($twitterID == 0) { ?>
				<a class="twitter-timeline" href="https://twitter.com/PlayNationdoteu" height="380" data-widget-id="433985614287892480">Tweets by @PlayNationdoteu</a>
				<?php 
			} else { ?>
				<a class="twitter-timeline" data-user-id="<?php echo $twitterID; ?>" href="https://twitter.com/" height="380" data-widget-id="433985614287892480">Tweets by <?php echo $this->__($player->NickName); ?></a>
				<?php 
			}
		?>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</div>
</div>
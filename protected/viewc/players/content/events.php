<div class="clearfix">
    <span class="fs22 fft fcb fl mr10"><?php echo $this->__('Events');?></span>
</div>
<div class="dot_top mt10">
	<?php
	if(isset($events) and !empty($events)){
		foreach($events as $e){
		?>
			<div class="dot_bot pt10 pb10 clearfix h68">
				<div class="fl grid_1 h68">
					<a href="<?php echo MainHelper::site_url('event/'.$e->ID_EVENT); ?>" class="games">
							<?php echo MainHelper::showImage($e); ?>
					</a>
				</div>
				<div class="fl grid_3 h68 fcb">
					<ul>
						<li><strong><?php echo $this->__('Name'); ?></strong>: <?php echo DooTextHelper::limitChar($e->EventHeadline, 20); ?></li>
						<li><strong><?php echo $this->__('Date'); ?></strong>: <?php echo date("d/m - Y g:i A", $e->EventTime); ?></li>
						<li><strong><?php echo $this->__('Location'); ?></strong>: <?php echo DooTextHelper::limitChar($e->EventLocation, 20); ?></li>
						<li><strong><?php echo $this->__('Participants'); ?></strong>: <?php echo $e->ActiveCount; ?></li>
					</ul>
				</div>
				<div class="fr grid_2 pr h68">
					<?php if(Auth::isUserLogged() and ($e->InviteLevel == 'open' or  $e->isInvited()) and !$e->isParticipating()){ ?>
					<a class="b0 r0 pa roundedButton yellow mb5 joinEvent event_id_<?php echo $e->ID_EVENT;?>" rel="<?php echo $e->ID_EVENT; ?>" href="<?php echo MainHelper::site_url('event/' . $e->ID_EVENT.'/join'); ?>" class="nav_info">
						<span class="lrc"></span>
						<span class="mrc">Participate</span>
						<span class="rrc"></span>
					</a>
					<?php } ?>
				</div>
			</div>
		<?php
		}
	}
	?>

<?php if(isset($pager)){echo $this->renderBlock('common/pagination', array('pager'=>$pager));} ?>
</div>
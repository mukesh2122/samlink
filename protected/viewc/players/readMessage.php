<?php include('common/top.php');?>
<div class="clearfix messagesPagerInfo mt5">
	<div class="fl fclg3 pl5 mt2">
		<a class="db fl" href="<?php echo MainHelper::site_url('players/messages'); ?>">
			<span class="iconr_back fl mt4"></span>
			<span class="fl ml2"><?php echo $this->__('Back to inbox'); ?></span>
		</a>
<!--	<span class="fcbl4 fl db ml2"> | </span>
		<a class="db fl ml2" href="javascript:void(0)"><?php echo $this->__('Forward'); ?></a>
		<span class="fcbl4 fl db ml2"> | </span>-->
	</div>
	
	<div class="fr">
		<div class="fl blueCorner"></div>
		<div class="fr blueBoxCorn"><?php echo $this->__('Messages'); ?>: <?php echo $total; ?></div>
	</div>
</div>

<div class="mt10">
	<div class="messageBoxTop"></div>
	<div class="messageBoxMid">
		<div class="messageInputTop"></div>
		<div class="messageInputMid">
			<textarea rows="1" class="ta pl5 pr5 pt2 wallInput messageInput" cols="1" title="<?php echo $this->__('Reply...');?>"><?php echo $this->__('Reply...');?></textarea>
		</div>
		<div class="messageInputBottom"></div>
		
		<div class="mt5 clearfix">
			<div class="fl mt3 w300">
				<span class="iconr_videolg fl mr5"></span>
				<a href="javascript:void(0)" class="fl fclg3 fs12 postVideoSwitch"><?php echo $this->__('Attach video'); ?></a>
			</div>
			<div class="fr">
				<a id="sendMessage" class="button button_medium grey" href="javascript:void(0)" rel="<?php echo $friendUrl; ?>"><?php echo $this->__('Reply'); ?></a>
			</div>
		</div>
	</div>
	<div class="clearfix messageBoxBottom"></div>
</div>
<?php if(isset($messages) and !empty($messages)):?>
	<div>
		<?php foreach($messages as $m): ?>
			<?php if($m->isShared == 1){
				echo $this->renderBlock('players/common/messageShared_'.$m->ShareOwnerType, array('m' => $m));
			}
			else{
				echo $this->renderBlock('players/common/message', array('m' => $m));
			} ?>
		
		<?php endforeach; ?>
	</div>
	<?php if(isset($pager) and $pager != '' and isset($pagerObj) and $pagerObj->totalPage > 1): ?>
		<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)) ?>
	<?php endif; ?>
<?php endif; ?>



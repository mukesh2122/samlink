<div class="message_container">
    <!-- header -->
    <div class="clearfix">
		<div class="fl postBody">
			<div id="createForm" class="replyForm pt5">
				<form method="POST" id="selectThreadType" class="forumForm"  action="<?php echo MainHelper::site_url('forum/'.$type.'/'.$url.'/'.$board).'/create-form'; ?>">
					<h2 class="fcb"><?php echo $this->__('Create new'); ?></h2>
					<br>										
					<p class="clearfix">
						<div>
							<div class="textMid">
								<input type="radio" name="threadtype" value="thread"><?php echo $this->__(' thread'); ?><br>
								<input type="radio" name="threadtype" value="poll"><?php echo $this->__(' poll'); ?> <br>
							</div>
							
						</div>
					</p>
					<input type="submit" name="select_new" value="<?php echo $this->__('Select'); ?>">
				</form>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>

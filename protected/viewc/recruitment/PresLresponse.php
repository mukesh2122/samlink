<?php

echo '

<ul class="horizontal_tabs clearfix">
	<li >
		<a href="'. MainHelper::site_url(RECRUITMENT_NOTICES).'" class="icon_link">
		<i class="games_tab_icon"></i>Notices</a>
	</li>
	<li  class="active">
		<a href="'. MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_MY_NOTICES).'" class="icon_link">
		<i class="games_tab_icon"></i>My Notices</a>
	</li>
	<li >
		<a href="'. MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES).'" class="icon_link">
		<i class="games_tab_icon"></i>Create Notice</a>
	</li>
</ul>

<div id="devconsole">';
?>
<script type="text/javascript">
	function change_status(object) {
		var status_id = object.value;
		var link_name = document.getElementById('link_status').value;
		
		window.location.href = link_name+status_id;
		
	}
	
</script>
<form id="rcForm" action="<?php echo  MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_MY_NOTICES); ?>" method="get" class="bbq">
<label for="owner">Your identity:&nbsp;</label>
<input id="ownerid" type="text"  style="border:none;" readonly name="ownerid" value="<?php echo $ownerid; ?>">

<br />

<li class="global_nav_actions_li">
<a class="global_nav_action global_nav_action_trigger" href="#">
<?php  echo $ownertype != '' ? $ownertype : 'Owner Type';?><i class="down_arrow_light_icon"></i></a>
<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
			<li <?php echo $ownertype == 'player' ? 'class="active"' : ''; ?>><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_MY_NOTICES.'/ownertype/player'); ?>>
			<?php echo 'Player'; ?>
			</a></li>
			<li  <?php echo $ownertype == 'group' ? 'class="active"' : ''; ?>><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_MY_NOTICES.'/ownertype/group'); ?>>
			<?php echo 'Group'; ?>
			</a></li>
		</ul>
	</div>
</li>
<li class="global_nav_actions_li">
<a class="global_nav_action global_nav_action_trigger" href="#">
<?php  echo $type != '' ? $type : 'List Type';?><i class="down_arrow_light_icon"></i></a>
<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
			<li <?php echo $type == 'notices' ? 'class="active"' : ''; ?>><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_MY_NOTICES.'/type/notices'); ?>>
			<?php echo 'Notices'; ?>
			</a></li>
			<li  <?php echo $type == 'responses' ? 'class="active"' : ''; ?>><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_MY_NOTICES.'/type/responses'); ?>>
			<?php echo 'Responses'; ?>
			</a></li>
		</ul>
	</div>
</li>
<br /> <br />

<p id="committer"></p>
</div>
<div>
<?php if(isset($noticesList) and !empty($noticesList)):?>
		<?php foreach ($noticesList as $key=>$item):?>
			<div class="rc_notices_item">
				<div class="rc_notices_rightBox">
					<div class="rc_notices_rightBox_col1">
					<ul>
						<li class="subtle_grey" title="Game"><?php echo $item->GameName; ?></li> 
						<li class="subtle_grey" title="Server"><?php echo $item->ServerName; ?></li> 
						<li class="subtle_grey" title="Ingame Name"><?php echo $item->InGameHandle; ?></li>
					</ul> 
					</div> 
					<div class="rc_notices_rightBox_col3">
					<ul>
						<li class="subtle_grey" title="Role"><?php echo $item->RoleName; ?></li> 
						<li class="subtle_grey" title="Gameplay"><?php echo $item->GameplayModeName; ?></li> 
						<li class="subtle_grey" title="Gameplay"><?php echo $item->GameplayLVLName; ?></li>+ 
					</ul> 
					</div> 
					<div class="rc_notices_rightBox_col2">
					<ul>
						<li class="subtle_grey" title="Faction"><?php echo $item->FactionName; ?></li>
						<li class="subtle_grey" title="Language"><?php echo $item->LanguageName; ?></li>
						<li class="subtle_grey" title="Region"><?php echo $item->RegionName; ?></li> 
					</ul> 
					</div> 
					<div class="rc_notices_rightBox_details">
						<span title="Details" ><?php echo $item->Details; ?></span>
					</div>
				</div>
				<div class="rc_notices_leftBox">
					<div class="rc_notices_leftBox_name">
						<p title="Name"><?php echo $item->OwnerName; ?></p> 
					</div>			
					<div class="rc_notices_leftBox_avatarP" style="background: no-repeat url('../global/css/img/AvatarP.png');">
					</div>
					<div class="rc_notices_leftBox_response rounded_5_btm">
						<span id="ownertype"><?php echo $item->OwnerType; ?></span>
						<span id="resownertype"><?php echo $item->FK_OWNER; ?></span>
					</div>
				</div> 
			</div>
			<br /><br />
				<?php $responseslist = Recruitment::getResponsesByNotices($item->ID_NOTICE,$item->OwnerType); ?>
					<?php if(isset($responseslist) and !empty($responseslist)):?>
					
						<?php foreach ($responseslist as $key=>$item2):?>
							<div class="rc_response_item" style="width:600px; height:160px; border: 1px solid gray; background:#f5f5f5; -webkit-border-bottom-left-radius: 5px; -moz-border-radius-bottomleft: 5px; border-bottom-left-radius: 5px;">
								<div class="rc_response_rightBox" style="width:128px; height:160px; float:right;">
									<div class="rc_response_rightBox_name p">
										<p title="Name"><?php echo $item2->OwnerName; ?></p> </div>
										<div class="rc_response_rightBox_avatarP" style="width:128px; height:127px; background: no-repeat url('../global/css/img/AvatarP.png');">
										</div>
										<div class="rc_response_rightBox_response rounded_5_top" >
											<span id="resownertype"><?php echo $item2->OwnerType; ?></span>
											<span id="resownertype"><?php echo $item2->FK_OWNER; ?></span>
										</div>
									</div>
									<div class="rc_response_leftBox">
										<div class="rc_response_leftBox_details">
											<p><?php echo $item2->ResponseDetailsLog; ?></p>
										</div>
										<div class="rc_response_status">
										<input id="link_status" name="link_status" type="hidden" value="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_MY_NOTICES.'/rid/'.$item2->ID_RESPONSE.'/owner/'.$item2->FK_OWNER.'/notice/'.$item->ID_NOTICE).'/status/'; ?>">
											<?php if ($item2->ResponseStatus=='waiting') { ?>
												<select id="status" name="status" onchange="change_status(this);">
													<option value="waiting">Waiting</option> 
													<option value="rejected">Reject</option> 
													<option value="accepted">Accept</option> 
												</select>
											<?php } else {?>
												<p><?php echo $item2->ResponseStatus; ?></p>
											<?php } ?>
										</div>
									</div>
								</div>				
							</div>
							<br />
						<?php endforeach; ?>
						
					<?php endif; ?>	
				
					<br /><br />
			
		<?php endforeach; ?>

		
		<?php if(isset($pager)):?>
			<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)) ?>
			
		<?php endif; ?>

	<?php else: ?>
		<p class="noItemsText"><?php echo $this->__('There are no notices here. Yet!'); ?></p>
		</div>
		
	<?php endif; ?>

</form>

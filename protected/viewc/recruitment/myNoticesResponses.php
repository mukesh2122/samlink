<ul class="horizontal_tabs clearfix">
	<li >
		<a href="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES); ?>" class="icon_link">
		<i class="games_tab_icon"></i><?php echo $this->__('Notices');?></a>
	</li>
	<li class="active">
		<a href="<?php echo MainHelper::site_url('recruitment2/'.RECRUITMENT_MY_NOTICES); ?>" class="icon_link">
		<i class="games_tab_icon"></i><?php echo $this->__('My Notices');?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('recruitment2/'.RECRUITMENT_CREATE_NOTICES); ?>" class="icon_link">
		<i class="games_tab_icon"></i><?php echo $this->__('Create Notices');?></a>
	</li>
</ul>

<div id="devconsole">


<script type="text/javascript">
	function change_status(object) {
		var status_id = object.value;
		var link_name = document.getElementById('link_status').value;
		
		window.location.href = link_name+status_id;
		
	}
	
</script>
<form id="rcForm" action="<?php echo  MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_MY_NOTICES); ?>" method="get" class="bbq">
<label for="owner"><?php echo $this->__('Your identity:');?>&nbsp;</label>
<input id="ownerid" type="text"  style="border:none;" readonly name="ownerid" value="<?php echo $ownerid; ?>">

<br />

<li class="global_nav_actions_li">
<a class="global_nav_action global_nav_action_trigger" href="#">
<?php  echo $ownertype != '' ? $ownertype : $this->__('Owner Type');?><i class="down_arrow_light_icon"></i></a>
<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
			<li <?php echo $ownertype == 'player' ? 'class="active"' : ''; ?>><a href="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_MY_NOTICES.'/ownertype/player'); ?>">
			<?php echo $this->__('Player'); ?>
			</a></li>
			<li  <?php echo $ownertype == 'group' ? 'class="active"' : ''; ?>><a href="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_MY_NOTICES.'/ownertype/group'); ?>">
			<?php echo $this->__('Group'); ?>
			</a></li>
		</ul>
	</div>
</li>
<li class="global_nav_actions_li">
<a class="global_nav_action global_nav_action_trigger" href="#">
<?php  echo $type != '' ? $type : $this->__('List Type');?><i class="down_arrow_light_icon"></i></a>
<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
			<li <?php echo $type == 'notices' ? 'class="active"' : ''; ?>><a href="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_MY_NOTICES.'/type/notices'); ?>">
			<?php echo $this->__('Notices'); ?>
			</a></li>
			<li  <?php echo $type == 'responses' ? 'class="active"' : ''; ?>><a href="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_MY_NOTICES.'/type/responses'); ?>">
			<?php echo $this->__('Responses'); ?>
			</a></li>
		</ul>
	</div>
</li>
<br /> <br />

<p id="committer"></p>
</div>


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
						<li class="subtle_grey" title="Gameplay"><?php echo $item->GameplayLVLName; ?></li> 
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
					<div  class="rc_notices_leftBox_avatarP" align="center" style="width:127px; height:104px;">
					<div class="profile_foto">
						<?php if ($item->OwnerType=='player') { ?>
						<a href="<?php echo MainHelper::site_url('players/wall');?>" class="personal_profile_link">
							<?php echo MainHelper::showImage($item->FK_OWNER, THUMB_LIST_100x100, false, array('width', 'no_img' => 'noimage/no_player_100x100.png'));?>
						</a>
						<?php } else { ?>
							<?php $group = Groups::getGroupByID($item->FK_OWNER); ?>
							<a href="<?php echo $group->GROUP_URL;?>" class="personal_profile_link">
								<?php echo MainHelper::showImage($item->FK_OWNER, THUMB_LIST_100x100, false, array('width', 'no_img' => 'noimage/no_group_100x100.png'));?>
							</a>
					

						<?php } ?>
					</div>
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
							<div class="rc_response_item" style="width:600px; height:138px; border: 1px solid gray; background:#f5f5f5; -webkit-border-bottom-left-radius: 5px; -moz-border-radius-bottomleft: 5px; border-bottom-left-radius: 5px;">
								<div class="rc_response_rightBox" style="width:128px; height:160px; float:right;">
									<div class="rc_response_rightBox_name p">
										<p title="Name"><?php echo $item2->OwnerName; ?></p> </div>
										<div class="rc_response_rightBox_avatarP" align="center" style="width:127px; height:104px;">
										<div class="profile_foto">
											<?php if ($item->OwnerType=='player') { ?>
											<a href="<?php echo MainHelper::site_url('players/wall');?>" class="personal_profile_link">
												<?php echo MainHelper::showImage($item2->FK_OWNER, THUMB_LIST_100x100, false, array('width', 'no_img' => 'noimage/no_player_100x100.png'));?>
											</a>
											<?php } else { ?>
												<?php $group = Groups::getGroupByID($item->FK_OWNER); ?>
												<a href="<?php echo $group->GROUP_URL;?>" class="personal_profile_link">
													<?php echo MainHelper::showImage($item2->FK_OWNER, THUMB_LIST_100x100, false, array('width', 'no_img' => 'noimage/no_group_100x100.png'));?>
												</a>
											
					
											<?php } ?>
										</div>
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
													<option value="waiting"><?php echo $this->__('Waiting');?></option> 
													<option value="rejected"><?php echo $this->__('Reject');?></option> 
													<option value="accepted"><?php echo $this->__('Accept');?></option> 
												</select>
											<?php } else {?>
												<p><?php echo $item2->ResponseStatus; ?></p>
											<?php } ?>
										</div>
									</div>
										
							</div>
							<br /><br />
						<?php endforeach; ?>
						
					<?php endif; ?>	
				
					<br />
			
		<?php endforeach; ?>

		
		<?php if(isset($pager)):?>
			<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)) ?>
			
		<?php endif; ?>

	<?php else: ?>
		<p class="noItemsText"><?php echo $this->__('There are no notices here. Yet!'); ?></p>
		
		
	<?php endif; ?>

</form>

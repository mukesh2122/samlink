<?php

//include("previewstart.html");

echo '
<ul class="horizontal_tabs clearfix">
	<li class="active" >
		<a href="'. MainHelper::site_url(RECRUITMENT_NOTICES).'" class="icon_link">
		<i class="games_tab_icon"></i>Notices</a>
	</li>
	<li >
		<a href="'. MainHelper::site_url('recruitment2/'.RECRUITMENT_MY_NOTICES).'" class="icon_link">
		<i class="games_tab_icon"></i>My Notices</a>
	</li>
	<li >
		<a href="'. MainHelper::site_url('recruitment2/'.RECRUITMENT_CREATE_NOTICES).'" class="icon_link">
		<i class="games_tab_icon"></i>Create Notice</a>
	</li>
</ul>

<br>';
?>
<div id="params" ></div>
<div id="demoWrapper">


<form id="rcForm" action="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_RESPOND_NOTICES.'/save_response'); ?>" method="post" class="bbq">

<span>Notice ID: <input id="nid" type="text"  style="border:none;" readonly name="nid" value=<?php echo $nid; ?>><br />
<?php $commiter_name=''; ?>
<?php if(isset($committer) and !empty($committer)): ?>
		<?php $commiter_name=$committer->NickName; ?>
<?php endif; ?>	
<br />

<span><input id="ownerid" type="text" name="ownerid"  class="subtle_grey" style="border:none; width:50px;" readonly value=<?php echo $ownerid; ?>>&nbsp;<input id="committer" type="text"   class="subtle_grey" style="border:none;" readonly name="committer" value=<?php echo $commiter_name; ?>></span>
<br>
<br />

			
<div id="noticecontainer">

	<?php if(isset($noticeList) and !empty($noticeList)):?>
		<?php foreach ($noticeList as $key=>$item):?>
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
			<div class="rc_notices_leftBox_name p">
				<p title="Name"><?php echo $item->OwnerName; ?></p> 
			</div>		
			<div class="rc_notices_leftBox_avatarP" style="width:127px; height:127px; background: no-repeat url('../global/css/img/AvatarP.jpg');"></div>
			<div class="rc_notices_leftBox_response rounded_5_btm">
				<span id="ownertype"><?php echo $item->OwnerType; ?></span>
				<input id="ownertype" type="hidden"  name="ownertype" value=<?php echo $item->OwnerType; ?>>
			</div>
		</div> 
		<br />
		<?php endforeach; ?>
	<?php endif; ?>	
</div>	
</div>


<div id="createresponse" class="rounded_5">



<span>Enter response:</span><input class="rounded_5 navigation_button green" style="float:right" id="next" value="Add" type="submit" /><br /><hr>
<textarea id="ResponseDetailsLog" name="ResponseDetailsLog" rows="8" cols="111"></textarea><br />
</div>
</form>

</div>




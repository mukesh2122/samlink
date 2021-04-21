<?php
$groupURL = $item->GROUP_URL;
$description = $this->__($item->GroupDesc);
$descLimit = 170;
if(isset($item->AllianceDesc)) { $description = $this->__($item->AllianceDesc); };
$hasApplied = $item->hasApplied();
$showAdminFunc = FALSE;
$funcList = array();
if(isset($owner) && $owner === TRUE) {
	$showAdminFunc = TRUE;
	$funcList[] = '<a href="javascript:void(0);" class="leave_group" rel="'.$item->ID_GROUP.'">'.$this->__('Leave Group').'</a>';
};
if($item->isCreator() === TRUE) {
	$showAdminFunc = TRUE;
	$funcList[] = '<a href="javascript:void(0);" class="delete_group" rel="'.$item->ID_GROUP.'">'.$this->__('Delete Group').'</a>';
};
if($hasApplied === TRUE) {
	$showAdminFunc = TRUE;
	$funcList[] = '<a href="javascript:void(0);" class="remove_group_application" rel="'.$item->ID_GROUP.'">'.$this->__('Remove application').'</a>';
};
if(isset($affiliates) && isset($isAdmin) && $isAdmin === TRUE) {
	$showAdminFunc = TRUE;
	$funcList[] = '<a rel="iframe" href="'.$groupURL.'/admin/editalliance/'.$item->ID_GROUP.'">'.$this->__('Edit affilliated group').'</a>';
	$funcList[] = '<a class="remove_affiliate" rel="'.$item->ID_GROUP.'" href="javascript:void(0);">'.$this->__('Remove affilliated group').'</a>';
};
if(Auth::isUserLogged()) {
	$userPlayer = User::getUser();
	$suspendLevel = $userPlayer->getSuspendLevel();
	$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
    if(!$noProfileFunctionality) {
        if($userPlayer->isDeveloper() || $userPlayer->isSuperUser || $userPlayer->isTranslator() || $item->isCreator()) {
            $showAdminFunc = TRUE;
            $funcList[] = '<a href="javascript:void(0);" class="action_translate" data-selec="group" rel="' . $item->ID_GROUP . '">' . $this->__('Translate') . '</a>';
        };
    };
};
$groups = new Groups();
$memberCount = $groups->getTotalMembers($item);
?>

<!-- Group item start -->
<div class="list_item clearfix itemPost">
	<a href="<?php echo $groupURL; ?>" class="list_item_img"><?php echo MainHelper::showImage($item, THUMB_LIST_80x80, false, array('no_img' => 'noimage/no_group_80x80.png')); ?></a>
	<div class="list_item_meta">
		<h2><a class="list_item_header" href="<?php echo $groupURL; ?>"><?php echo $item->GroupName; ?> <?php echo $item->GameName ? '<small>('.$item->GameName.')</small>' : ''; ?></a></h2>
		<p class="list_item_description short_desc_<?php echo $item->ID_GROUP; ?>">
			<?php
			if($description) { echo strip_tags(DooTextHelper::limitChar($description, $descLimit)); }
            else { echo $this->__('There is no description for this group at the moment.'); };
			?>
		</p>
		<p class="list_item_description long_form dn long_desc_<?php echo $item->ID_GROUP; ?>">
			<?php echo ContentHelper::handleContentOutput($description); ?>
		</p>
		<ul class="list_item_footer">
			<?php if(strlen($description) > $descLimit): ?>
			<li><a class="icon_link revealmore" data-open="<?php echo $this->__('Read more'); ?>" data-close="<?php echo $this->__('Hide description'); ?>" data-id="<?php echo $item->ID_GROUP; ?>" href="javascript:void(0);"><i class="readmore_icon"></i><?php echo $this->__('Read more'); ?></a></li>
			<?php endif; ?>
			<li><a class="icon_link" href="<?php echo $groupURL . '/members'; ?>"><i class="members_icon"></i><?php echo $memberCount; ?> <?php echo ($memberCount != 1) ? $this->__('Members') : $this->__('Member'); ?></a></li>
		</ul>
		<?php if($showAdminFunc === TRUE): ?>
			<div class="list_item_dropdown item_dropdown">
				<a href="javascript:void(0)" class="list_item_dropdown_trigger item_dropdown_trigger"><?php echo $this->__('Options');?></a>
				<ul class="list_item_dropdown_options item_dropdown_options">
					<li><?php echo implode("</li><li>", $funcList);?></li>
				</ul>
			</div>
		<?php endif;?>
	</div>
</div>
<!-- Group item end -->
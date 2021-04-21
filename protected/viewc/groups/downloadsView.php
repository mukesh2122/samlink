<?php
$isAdmin = FALSE;
$groupUrl = $group->GROUP_URL;
$p = User::getUser();
include('common/top.php');
?>

<div class="list_header">
    <h1><?php echo $this->__('Downloads'); ?></h1>
    <?php if($p and $p->canAccess('Edit group information')):
    $isAdmin = true; ?>
        <a class="list_header_button" rel="iframe" 
           href="<?php echo $groupUrl; ?>/admin/adddownload"><?php echo $this->__('Add Download').' +'; ?></a>
    <?php endif; ?>
</div>

<?php if(!empty($tabsD) or $isAdmin === TRUE): ?>
    <ul class="horizontal_tabs small mt15 clearfix">
    <?php $num = 0;
    foreach($tabsD as $tab): ?>
        <li class="pr <?php $activeTab = isset($activeTab) ? $activeTab : "";echo ($tab->ID_FILETYPE == $activeTab) ? 'active' : ''; ?>">
            <a <?php echo ($isAdmin === TRUE) ? 'class="pr30"' : ''; ?> href="<?php echo $groupUrl.'/downloads/'.$tab->ID_FILETYPE; ?>"><?php echo $tab->FiletypeName; ?></a>
            <?php if($isAdmin === TRUE): ?>
                <a href="javascript:void(0);" rel="<?php echo $tab->ID_FILETYPE; ?>" class="cal pa icon_close_game_tab" style="margin-right: -9px; margin-top: 3px;"></a>
            <?php endif; ?>
        </li>
        <?php ++$num;
    endforeach;
    if($isAdmin === TRUE): ?>
        <li>
            <a class="add" rel="iframe" href="<?php echo $groupUrl.'/admin/adddownloadtab'; ?>"><?php echo $this->__('Add tab').' +'; ?></a>
        </li>
        <?php if(!empty($tabsD)): ?>
            <li>
                <a class="edit" rel="iframe" href="<?php echo $groupUrl.'/admin/editdownloadtab'; ?>"><?php echo $this->__('Edit tab').' +'; ?></a>
            </li>
        <?php endif;
    endif; ?>
    </ul>
<?php endif;
if(!empty($downloads)): ?>
	<div class="gradient_header clearfix">
		<span class="header_name header_name_green"><?php echo $this->__('All Downloads'); ?></span>
		<?php if($pagerObj->totalItem > 0): ?>
			<span class="header_total header_total1"><?php echo $this->__('Total').$this->__(': [_1]', 
                array($pagerObj->totalItem)); ?></span>
		<?php endif; ?>
	</div>
    <?php foreach($downloads as $download) { echo $this->renderBlock('groups/downloadItem',
        array('download' => $download, 'isAdmin' => $isAdmin)); }
else: ?>
	<p class="noItemsText"><?php echo $this->__('There are no downloads at this moment'); ?></p>
<?php endif; ?>
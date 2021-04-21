<?php
$isAdmin = FALSE;
$gameUrl = $game->GAME_URL;
$p = User::getUser();
include('common/top.php');
?>

<div class="list_header mb15">
	<h1><?php echo $this->__('Media'); ?></h1>
	<?php if($p and $p->canAccess('Edit game information')): ?>
		<a class="list_header_button" rel="iframe" href="<?php echo $gameUrl; ?>/admin/addmedia"><?php echo $this->__('Add Media').' +'; ?></a>
	<?php endif; ?>
</div>

<?php if(!empty($tabs)): ?>
	<ul class="horizontal_tabs small clearfix">
    <?php foreach ($tabs as $url=>$tab): ?>
        <li <?php echo ($url == $activeTabMedia) ? 'class="active"' : ''; ?>>
        	<a href="<?php echo $gameUrl.'/media/'.$url; ?>"><?php echo$this->__($tab); ?></a>
        </li>
    <?php endforeach;
        /*
		<li <?php echo (isset($activeTabMedia) and $activeTabMedia == GAME_DOWNLOADS) ? 'class="active"' : ''; ?>>
			<a class="icon_link" href="<?php echo $gameUrl.'/downloads';?>"><?php echo $this->__('Downloads');?></a>
        </li>*/ ?>
    </ul>
<?php endif; ?>

<div class="list_header">
    <h1><?php echo $this->__('Downloads'); ?></h1>
    <?php $p = User::getUser(); if($p and $p->canAccess('Edit game information')):
    $isAdmin = true; ?>
        <a class="list_header_button" rel="iframe" href="<?php echo $game->GAME_URL; ?>/admin/adddownload"><?php echo $this->__('Add Download').' +'; ?></a>
    <?php endif; ?>
</div>

<?php if(!empty($tabsD) or $isAdmin === TRUE): ?>
    <ul class="horizontal_tabs small mt15 clearfix">
    <?php $num = 0;
    foreach($tabsD as $tab): ?>
        <li class="pr <?php $activeTab = isset($activeTab) ? $activeTab : "";echo ($tab->ID_FILETYPE == $activeTab) ? 'active' : ''; ?>">
            <a <?php echo ($isAdmin === TRUE) ? 'class="pr30"' : ''; ?> href="<?php echo $game->GAME_URL.'/downloads/'.$tab->ID_FILETYPE; ?>"><?php echo $tab->FiletypeName; ?></a>
            <?php if($isAdmin === TRUE): ?>
                <a href="javascript:void(0);" rel="<?php echo $tab->ID_FILETYPE; ?>" class="cal pa icon_close_game_tab" style="margin-right: -9px; margin-top: 3px;"></a>
            <?php endif; ?>
        </li>
        <?php ++$num;
    endforeach;
    if($isAdmin === TRUE): ?>
        <li>
            <a class="add" rel="iframe" href="<?php echo $game->GAME_URL.'/admin/adddownloadtab'; ?>"><?php echo $this->__('Add tab').' +'; ?></a>
        </li>
        <?php if(!empty($tabsD)): ?>
            <li>
                <a class="edit" rel="iframe" href="<?php echo $game->GAME_URL.'/admin/editdownloadtab'; ?>"><?php echo $this->__('Edit tab').' +'; ?></a>
            </li>
        <?php endif;
    endif; ?>
    </ul>
<?php endif;
if(!empty($downloads)): ?>
	<div class="gradient_header clearfix">
		<span class="header_name header_name_green"><?php echo $this->__('All Downloads'); ?></span>
		<?php if($pagerObj->totalItem > 0): ?>
			<span class="header_total header_total1"><?php echo $this->__('Total').$this->__(': [_1]', array($pagerObj->totalItem)); ?></span>
		<?php endif; ?>
	</div>
    <?php foreach($downloads as $download) { echo $this->renderBlock('games/downloadItem', array('download' => $download, 'isAdmin' => $isAdmin)); };
else: ?>
	<p class="noItemsText"><?php echo $this->__('There are no downloads at this moment'); ?></p>
<?php endif; ?>
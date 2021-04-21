<?php
echo $this->renderBlock('common/header_ads', array());
$isMyself = 0;
$pp = User::getUser();
if(isset($poster))	{
    if($poster->ID_PLAYER === $pp->ID_PLAYER) { $isMyself = 1; }
    else { $pp = $poster; };
};
echo $this->renderBlock('common/suspendinfo', array('isMyself'=>$isMyself, 'poster'=>$pp));
if(isset($infoBox)) { echo $infoBox; };

if(isset($selectedCategory)):
	$categories = MainHelper::GetPlayerCategories('player');
	if(!empty($categories)): ?>
		<ul class="horizontal_tabs clearfix">
			<li class="<?php echo ($selectedCategory === 0)?'active' : ''; ?>">
				<a href="<?php echo MainHelper::site_url('players'); ?>" class="icon_link"><i class="games_tab_icon"></i><?php echo $this->__('All'); ?></a>
			</li>
			<?php foreach($categories as $category): ?>
				<li class="<?php echo ($selectedCategory == $category['ID_CATEGORY'])?'active' : ''; ?>">
					<a href="<?php echo MainHelper::site_url('players/category/' . $category['ID_CATEGORY']); ?>" class="icon_link"><i class="games_tab_icon"></i><?php echo $category['CategoryName']; ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif;
endif; ?>
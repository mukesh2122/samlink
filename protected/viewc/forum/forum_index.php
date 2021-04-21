<?php
$user = User::getUser();
include('common/tabs.php');
?>

<!-- Forum list start -->
<div class="list_container">
	<?php echo $this->renderBlock('forum/common/search', array(
        'url' => ($type == 'company') ? MainHelper::site_url('forum/company/search') : MainHelper::site_url('forum/game/search'), 
        'searchText' => isset($searchText) ? $searchText : '',
        'searchTotal' => isset($searchTotal) ? $searchTotal : '',
        'label' => $label = $this->__('Search for forums...'),
        'type' => $type = $this->__('forums')
    ));
    if(!isset($searchText)){
        echo $this->renderBlock('forum/common/title_bar', array(
            'title' => $this->__('All Forums')
        ));
    }; ?>

	<input type="hidden" id="type" value="<?php echo $type; ?>">
	<?php if(!empty($model)): ?>
		<div class="item_list">
            <?php foreach($model as $m):
                if($m instanceof SnGames) { $noimg = 'noimage/no_game_60x60.png'; }
                elseif($m instanceof SnCompanies) { $noimg = 'noimage/no_company_60x60.png'; }
                elseif($m instanceof SnGroups) { $noimg = 'noimage/no_group_60x60.png'; }
                else { $noimg = ''; }; ?>

                <div class="list_item small clearfix itemPost">
                    <a href="<?php echo $m->FORUM_URL; ?>" class="list_item_img">
                        <?php echo MainHelper::showImage($m, THUMB_LIST_60x60, false, array('no_img' => $noimg)); ?>
                    </a>
                    <div class="list_item_meta">
                        <h2><a class="list_item_header" href="<?php echo $m->FORUM_URL; ?>"><?php echo $m->{$fields->name}; ?></a></h2>
                        <ul class="list_item_footer">
                            <li>
                                <a class="icon_link" href="<?php echo $m->FORUM_URL; ?>">
                                    <i class="thread_icon"></i>
                                    <?php echo $m->TopicCount, ' ', (($m->TopicCount != 1) ? $this->__('Threads') : $this->__('Thread')); ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if(isset($pager)) { echo $this->renderBlock('common/pagination', array('pager'=>$pager)); };
	else: ?>
		<p class="noItemsText"><?php echo $this->__('There are no forums at this moment'); ?></p>
	<?php endif; ?>
</div>
<!-- Forum list end -->
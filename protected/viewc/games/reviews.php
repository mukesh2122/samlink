<?php $gameUrl = $game->GAME_URL; 
    error_reporting(E_ALL ^ E_NOTICE);
?>
<?php include('common/top.php'); ?>

<?php if(!isset($searchText)): $player = User::getUser();

	$suspendLevel = ($player) ? $player->getSuspendLevel() : 0;
	$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
	$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
    ?>

<div id="headerCoverInfo">
    <div id="coverImg">&nbsp;</div>
    <div id="headerInfo"><h1><?php echo $this->__('Reviews');?></h1></div>
</div>

    <div class="list_header">
        <?php if($player): ?>
            <div class="list_header_button_group">
                <?php if(!$noSiteFunctionality): ?>
                    <a class="list_header_button" href="<?php echo $gameUrl; ?>/add-review"><?php echo $this->__('Write a review'); ?></a>
                    <a class="list_header_button" href="<?php echo $gameUrl; ?>/unpublished-reviews"><?php echo $this->__('Unpublished reviews'); ?></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<div id="reviewFilter">
    
    <span id="reviewFilterText">Filter:</span>
    
    <span id="reviewDropdown">
        <select>
            <option value="1">Most usefull</option>
            <option value="2">Chronological</option>
            <option value="3">Loved the game</option>
            <option value="4">Hated the game</option>
        </select>
    </span>
    
    <a href="#"><span id="reviewWrite">Write review</span></a>
</div>

<div id="readOurReview">
    <div id="readOurReviewImg"><img src="../../global/img/reviewReadOurReviewIMG.png"></div>
    <div id="readOurReviewText">Read Our Review</div>
</div>

<?php echo $this->renderBlock('common/pagination', array('pager' => $pager)) ?>

<?php
	echo $this->renderBlock('games/common/search', array(
		'url' => $gameUrl.'/news/search',
		'searchText' => isset($searchText) ? $searchText : '',
		'searchTotal' => isset($searchTotal) ? $searchTotal : '',
		'label' => $label = $this->__('Search for games...'),
		'type' => $type = $this->__('news')
	));
	?>
<br/>

<?php /*if(isset($_GET['read']) && $_GET['read'] == "more") {
?>
<div class="reviewArticleBig">
    <div class="reviewFoundUseful">142 out of 201 found this review useful</div>
    
    <div class="reviewContent">
        <div class="reviewUserImg">
            <img src="../../global/img/noimage/no_player_100x100.png">
            Pinguin Master
        </div>
        
        <div class="reviewTop">
            <div class="reviewTitle">Play a poem</div>
            <div class="reviewUserRating">Pinguin Master's rating: 9/10</div>
            <div class="reviewIntroText">Lorem ipsum dolor sit amet, consectetur adipisicing elit, 
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</div>
            <div class="reviewText1">Ut enim ad minim veniam, 
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
        </div>
            
        <div class="reviewCenterBig">
            <div class="reviewText2">Sed ut perspiciatis unde omnis iste natus error 
                sit voluptatem accusantium doloremque laudantium, 
                totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi 
                architecto beatae vitae dicta sunt explicabo. 
                Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, 
                sed quia consequuntur magni dolores eos 
                qui ratione voluptatem sequi nesciunt</div>
            
            <div class="reviewText3">Sed ut perspiciatis unde omnis iste natus error 
                sit voluptatem accusantium doloremque laudantium, 
                totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi 
                architecto beatae vitae dicta sunt explicabo. 
                Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, 
                sed quia consequuntur magni dolores eos 
                qui ratione voluptatem sequi nesciunt.
                Sed ut perspiciatis unde omnis iste natus error 
                sit voluptatem accusantium doloremque laudantium, 
                totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi 
                architecto beatae vitae dicta sunt explicabo.
                <br/>
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br/>
                <a href="?read=all">Read less</a>
            </div>
            
            <div class="reviewComments">0 comments</div>
            <div class="reviewFindUsefull">How do you find this review?
                <a href="?find=useful&id=1"><span class="reviewUseful">Useful</span></a>
                <a href="?find=notuseful&id=1"><span class="reviewNotUseful">Not useful</span></a>
            </div>
        </div>
        
        <div class="reviewBottomBig">&nbsp;</div>
    </div>
</div>
<?php 
    } 
    else
    { ?>

<div class="reviewArticleSmall">
    <div class="reviewFoundUseful">142 out of 201 found this review useful</div>
    
    <div class="reviewContent">
        <div class="reviewUserImg">
            <img src="../../global/img/noimage/no_player_100x100.png">
            Pinguin Master
        </div>
        
        <div class="reviewTop">
            <div class="reviewTitle">Play a poem</div>
            <div class="reviewUserRating">Pinguin Master's rating: 9/10</div>
            <div class="reviewIntroText">Lorem ipsum dolor sit amet, consectetur adipisicing elit, 
                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</div>
            <div class="reviewText1">Ut enim ad minim veniam, 
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
        </div>
            
        <div class="reviewCenterSmall">
            <div class="reviewText2">Sed ut perspiciatis unde omnis iste natus error 
                sit voluptatem accusantium doloremque laudantium, 
                totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi 
                architecto beatae vitae dicta sunt explicabo. 
                Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, 
                sed quia consequuntur magni dolores eos 
                qui ratione voluptatem sequi nesciunt. <br/>
                <a href="?read=more&id=1">Read more</a></div>
            
            <div class="reviewComments">0 comments</div>
            <div class="reviewFindUsefull">How do you find this review?
                <a href="?find=useful&id=1"><span class="reviewUseful">Useful</span></a>
                <a href="?find=notuseful&id=1"><span class="reviewNotUseful">Not useful</span></a>
            </div>
        </div>
        
        <div class="reviewBottomSmall">&nbsp;</div>
    </div>
</div>

<?php 
    } */
    
    if(isset($reviews) and !empty($reviews)):?>
	<div class="item_list">
		<?php foreach ($reviews as $key => $item): ?>
			<?php echo $this->renderBlock('news/reviewItemLine', array('item' => $item, 'objUrl' => $gameUrl.'/review/', 'game' => $game)); ?>
		<?php endforeach; ?>
	</div>
	<?php echo $this->renderBlock('common/pagination', array('pager' => $pager));
else: ?>
	<p class="noItemsText"><?php echo $this->__('There are no news at this moment'); ?></p>
<?php endif; ?>
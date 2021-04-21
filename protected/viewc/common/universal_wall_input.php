<!--<div id="headerCoverInfo">-->
    <!--<div id="coverImg">&nbsp;</div>-->
    <div id="headerInfo"><h1>Wall</h1></div>
<!--</div>-->
        
<?php
	$userPlayer = User::getUser();
	$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
	$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
	$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);

	$id = 0;
	$showWall = false;
	$noItemsText = '';
	if($obj instanceof SnGroups) {
		$id = $obj->ID_GROUP;
		if($obj->isMember()) {
			$showWall = true;
		}
		$noItemsText = $this->__('There are no wall posts at this moment');
	} elseif($obj instanceof EvEvents) {
		$id = $obj->ID_EVENT;
		if($obj->isParticipating() or $obj->isAdmin()) {
			$showWall = true;
		}
		$noItemsText = $this->__('There are no wall posts at this moment');
	} elseif($obj instanceof SnGames) {
		$id = $obj->ID_GAME;
			$showWall = true;
		$noItemsText = $this->__('There are no wall posts at this moment');

	} elseif($obj instanceof Players) {
		$player = User::getUser();
		$isFriend = $player->isFriend($obj->ID_PLAYER );
		if($player->ID_PLAYER == $obj->ID_PLAYER || $isFriend || isset($global) && $global == true) {
			$showWall = true;
		}

		if($player->ID_PLAYER == $obj->ID_PLAYER){
			switch($wallType){
				case WALL_OWNER_PLAYER.'_'.WALL_MAIN:
					$noItemsText = $this->__('There are no wall posts at this moment');
					break;
				case WALL_OWNER_PLAYER.'_'.WALL_HOME:
					$noItemsText = $this->__('You have no wall posts at this moment');
					break;
				case WALL_OWNER_PLAYER.'_'.WALL_PHOTO:
					$noItemsText = $this->__('You have no photos at this moment');
					break;
				case WALL_OWNER_PLAYER.'_'.WALL_VIDEO:
					$noItemsText = $this->__('You have no videos at this moment');
					break;
				case WALL_OWNER_PLAYER.'_'.WALL_LINK:
					$noItemsText = $this->__('You have no links at this moment');
					break;
			}
		}
		elseif($isFriend){
			switch($wallType){
				case WALL_OWNER_FRIEND.'_'.WALL_HOME:
					$noItemsText = $this->__('[_1] has no wall posts at this moment', array(PlayerHelper::showName($obj)));
					break;
				case WALL_OWNER_FRIEND.'_'.WALL_PHOTO:
					$noItemsText = $this->__('[_1] has no photos at this moment', array(PlayerHelper::showName($obj)));
					break;
				case WALL_OWNER_FRIEND.'_'.WALL_VIDEO:
					$noItemsText = $this->__('[_1] has no videos at this moment', array(PlayerHelper::showName($obj)));
					break;
				case WALL_OWNER_FRIEND.'_'.WALL_LINK:
					$noItemsText = $this->__('[_1] has no links at this moment', array(PlayerHelper::showName($obj)));
					break;
			}
		}

		$id = $obj->ID_PLAYER;
	}
?>

<?php if(Auth::isUserLogged() and $showWall === true && !$noProfileFunctionality):?>

	<!-- Wall input start -->
	<div class="wall_input">
		<textarea rows='1' id="wall" class="autoSize titleAttr wallInput" title="<?php echo $post_text;?>"><?php echo $post_text;?></textarea>

		<div class="wall_input_actions clearfix">
			<div class="pull_right">
				<?php if(isset($admin) and $admin === TRUE):?>
					<a class="wall_input_button" id="wall_post_<?php echo $wallType; ?>_admin" href="javascript:void(0)" rel="<?php echo $wallType; ?>_admin"><?php echo $this->__('Post as ').  ucfirst($wallType); ?></a>
				<?php endif;?>
				<a class="wall_input_button" id="wall_post_<?php echo $wallType; ?>" id_album="<?php echo (isset($id_album)) ? $id_album :0; ?>" href="javascript:void(0)" rel="<?php echo $wallType; ?>"><?php echo isset($button) ? $button : $this->__('Post'); ?></a>
			</div>
		</div>
	</div>
	<!-- Wall input end -->

<?php endif;?>

<!-- Wall posts start -->
<div id="wall_container" class="wall_list">
	<?php if(isset($posts)) echo $posts;?>
</div>
<?php if(!isset($posts) or $posts == ''): ?>
	<div class="noItemsText"><?php echo $noItemsText; ?></div>

	<?php /* <div class="noItemsText"><?php echo $this->__('There are no wall posts at this moment'); ?></div> */ ?>
<?php endif; ?>
<!-- Wall posts end -->

<?php
	$showMore = false;
	$pType = str_replace(array(WALL_OWNER_PLAYER.'_', WALL_OWNER_FRIEND.'_'), '', $wallType);
	if(isset($wallType) and ($pType == WALL_PHOTO or $pType == WALL_VIDEO) and isset($postCount)){
		if($pType == WALL_PHOTO and $postCount >= Doo::conf()->photonum) {
			$showMore = true;
		} else if($pType == WALL_VIDEO and $postCount >= Doo::conf()->videonum) {
			$showMore = true;
		}
	} else if(isset($postCount) and $postCount >= Doo::conf()->postnum) {
		$showMore = true;
	}
?>

<!-- Show more button start -->
<?php if($showMore): ?>
	<input type="hidden" value="<?php echo $wallType;?>" id="wallType" />
	<input type="hidden" value="<?php echo $id;?>" id="wallID" />
	<a class="show_more_button show_more_posts" href="javascript:void(0)" rel="<?php echo isset($postCount) ? $postCount : 0; ?>"><?php echo $this->__('Show more posts');?></a>
<?php endif; ?>
<!-- Show more button end -->






<?php /*
<?php
	$id = 0;
	$showWall = false;
	$noItemsText = '';
	if($obj instanceof SnGroups) {
		$id = $obj->ID_GROUP;
		if($obj->isMember()) {
			$showWall = true;
		}
		$noItemsText = $this->__('There are no wall posts at this moment');
	} elseif($obj instanceof EvEvents) {
		$id = $obj->ID_EVENT;
		if($obj->isParticipating()) {
			$showWall = true;
		}
		$noItemsText = $this->__('There are no wall posts at this moment');

	} elseif($obj instanceof Players) {
		$player = User::getUser();
		$isFriend = $player->isFriend($obj->ID_PLAYER );
		if($player->ID_PLAYER == $obj->ID_PLAYER || $isFriend) {
			$showWall = true;
		}

		if($player->ID_PLAYER == $obj->ID_PLAYER){
			switch($wallType){
				case WALL_MAIN:
					$noItemsText = $this->__('There are no wall posts at this moment');
					break;
				case WALL_HOME:
					$noItemsText = $this->__('You have no wall posts at this moment');
					break;
				case WALL_PHOTO:
					$noItemsText = $this->__('You have no photos at this moment');
					break;
				case WALL_VIDEO:
					$noItemsText = $this->__('You have no videos at this moment');
					break;
				case WALL_LINK:
					$noItemsText = $this->__('You have no links at this moment');
					break;
			}
		}
		elseif($isFriend){
			switch($wallType){
				case WALL_HOME:
					$noItemsText = $this->__('[_1] has no wall posts at this moment', array(PlayerHelper::showName($obj)));
					break;
				case WALL_PHOTO:
					$noItemsText = $this->__('[_1] has no photos at this moment', array(PlayerHelper::showName($obj)));
					break;
				case WALL_VIDEO:
					$noItemsText = $this->__('[_1] has no videos at this moment', array(PlayerHelper::showName($obj)));
					break;
				case WALL_LINK:
					$noItemsText = $this->__('[_1] has no links at this moment', array(PlayerHelper::showName($obj)));
					break;
			}
		}

		$id = $obj->ID_PLAYER;
	}
?>

<?php if(Auth::isUserLogged() and $showWall === true):?>
	<div class="mt10">
		<div class="wallpostBoxTop"></div>
		<div class="wallpostBoxMid">
			<div class="wallpostInputTop"></div>
			<div class="wallpostInputMid">
				<textarea id="wall" rows="1" class="ta pl5 pr5 pt2 wallInput" cols="1" title="<?php echo $post_text;?>"><?php echo $post_text;?></textarea>
			</div>
			<div class="wallpostInputBottom"></div>

			<div class=" mt5 clearfix">
				<div class="fl mt3">
					<span class="iconr_videol fl mr5"></span>
					<a href="javascript:void(0)" class="fl fcbl3 fs12 postVideoSwitch"><?php echo $this->__('Post video'); ?></a>
				</div>

				<div class="fr">
					<a id="wall_post_<?php echo $wallType; ?>" class="roundedButton blue fr" href="javascript:void(0)" rel="<?php echo $wallType; ?>">
						<span class="lrc"></span>
						<span class="mrc db tac pl10 pr10"><?php echo isset($button) ? $button : $this->__('Post'); ?></span>
						<span class="rrc"></span>
					</a>
					<?php if(isset($admin) and $admin === TRUE):?>
						<a id="wall_post_<?php echo $wallType; ?>_admin" class="roundedButton blue fr mr10" href="javascript:void(0)" rel="<?php echo $wallType; ?>_admin">
							<span class="lrc"></span>
							<span class="mrc db tac pl10 pr10"><?php echo $this->__('Post as ').  ucfirst($wallType); ?></span>
							<span class="rrc"></span>
						</a>
					<?php endif;?>
				</div>
			</div>
		</div>
		<div class="clearfix wallpostBoxBottom"></div>
	</div>
<?php endif;?>
<div id="wall_container" class="clearfix <?php echo (isset($posts) and $posts == '') ? 'dn' : '';?>">
	<?php if(isset($posts)) echo $posts;?>
</div>
<?php if(!isset($posts) or $posts == ''): ?>
	<div class="noItemsText"><?php echo $noItemsText; ?></div>
<?php endif; ?>

<?php
	$showMore = false;
	$pType = str_replace(array(WALL_OWNER_PLAYER.'_', WALL_OWNER_FRIEND.'_'), '', $wallType);
	if(isset($wallType) and ($pType == WALL_PHOTO or $pType == WALL_VIDEO) and isset($postCount)){
		if($pType == WALL_PHOTO and $postCount >= Doo::conf()->photonum) {
			$showMore = true;
		} else if($pType == WALL_VIDEO and $postCount >= Doo::conf()->videonum) {
			$showMore = true;
		}
	} else if(isset($postCount) and $postCount >= Doo::conf()->postnum) {
		$showMore = true;
	}

?>
<?php if($showMore): ?>
	<input type="hidden" value="<?php echo $wallType;?>" id="wallType" />
	<input type="hidden" value="<?php echo $id;?>" id="wallID" />
	<a class="buttonRRound buttonShowMore show_more_posts mt10"
		href="javascript:void(0)" rel="<?php echo isset($postCount) ? $postCount : 0; ?>">
		<span class="lrc"></span>
		<span class="mrc">
			<span class="db  clearfix showMoreCenter">
				<span class="iconr_showmore fl  mr5">&nbsp;</span>
				<span class=""><?php echo $this->__('Show more posts');?></span>
			</span>
		</span>
		<span class="rrc"></span>
	</a>
<?php endif; ?>
*/ ?>
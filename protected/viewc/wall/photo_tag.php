<?php
$nick = PlayerHelper::showName($poster);
$img  = MainHelper::showImage($poster, THUMB_LIST_60x60, FALSE, array('no_img' => 'noimage/no_player_60x60.png'));
$message = unserialize($item->Message);
$content = unserialize($message['content']);
$filename = $content['content'];

$wallTags = new Walltags();
$tagTypes = $wallTags->getTagTypes();
$tagType = 'player';   //Friend-tagging only

$player = User::getUser();
$taggedList = $wallTags->getTaggedByOthersList($item, $tagType, $player);
$friendsList = $wallTags->getFriendsList($item, $tagType, $player);
$photoTag = TRUE;
?>
<div id="popupcontainer" class="clearfix">
	<div class="pull_left mr10">
		<div id="ug_image_container"><?php echo MainHelper::showImage($item, THUMB_LIST_800x600, FALSE, array('both')); ?></div>
	</div>
	<div class="pull_right ug_wall_item_comment_container_narrow">
		<div class="pull_left mr10">
			<a class="img" title="<?php echo $nick; ?>" href="<?php echo MainHelper::site_url('player/' . $poster->URL); ?>"><?php echo $img; ?></a>
		</div>
		<div>
			<span class="mt0"><a href="<?php echo MainHelper::site_url('player/' . $poster->URL); ?>"><?php echo $nick; ?></a></span>
			<p><?php echo isset($message['description']) ? $message['description'] : ''; ?></p>
		</div>
		<div class="clearfix"></div>

		<!-- Tagged by others start -->
		<div id="tagList">
            <?php if(count($taggedList) > 0) { echo $this->__('Tagged by others'), ':<br>'; };
            $count = 0;
            foreach($taggedList as $tag) : ?>
                <a rel="<?php echo $tag['ID_TAGGED']; ?>" href="javascript:void(0);" title="<?php echo $this->__('Tagged by'), ' ', User::getById($tag['ID_TAGGEDBY'])->DisplayName; ?>">
                    <?php echo $tag['DisplayName']; ?>
                </a>
                <?php if($count < count($taggedList)-2) {
                    echo ', ';
                } elseif($count == count($taggedList)-2) {
                    echo ' ', $this->__('and'), ' ';
                };
                $count++;
            endforeach; ?>
		</div>
		<!-- Tagged by others end -->

		<?php if(!empty($friendsList)): ?>
			<div id="friendList">
				<div><?php echo $this->__('Friends'), ':'; ?></div>
                <ul>
                    <?php foreach($friendsList as $friend): ?>
                        <li class="individual" rel="<?php echo $friend['ID_FRIEND']; ?>">
                            <label>
                                <input type="checkbox">
                                <span><?php echo $friend['FriendName']; ?></span>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="standard_form_footer clearfix">
                    <button id="ug_canceltag" class="button button_auto light_blue pull_left">
                        <?php echo $this->__('Cancel'); ?>
                    </button>
                    <button id="ug_savetag" class="button button_auto light_blue pull_right">
                        <?php echo $this->__('Save'); ?>
                    </button>
                </div>
			</div>
		<?php endif; ?>
	</div>
</div>
<?php include(Doo::conf()->SITE_PATH . 'global/js/imageTag.js.php'); ?>
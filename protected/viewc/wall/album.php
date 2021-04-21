<?php
	include ('common/typeTop.php');

	$maxPhotosPerItem = 10;
	//---- Get own album content ----
	$wallItems = new SnWallitems;
	$wallItems->ItemType = 'photo';
	$wallItems->ID_ALBUM = $item->ID_ALBUM;
	$opt = array(
		'desc'  => 'lastActivityTime'
	,	'limit' => $maxPhotosPerItem
	);
	$albumContent = Doo::db()->find($wallItems, $opt);

	//---- Get album content on which user is tagged ----
	$walltags = new SnWalltags;
	$walltags->ID_ALBUM = $item->ID_ALBUM;
	$walltags->Untagged = 0;
	$opt = array(
		'select'  => 'ID_WALLITEM, ID_TAGGED'
	,	'asArray' => true
	);
	$tagItems = Doo::db()->find($walltags, $opt);
	if (!empty($tagItems)){
		//---- Get wallitem on which user is tagged but don't own ----
		$itemArray = array();
		$taggedArray = array();
		foreach($tagItems as $tagItem){
			$itemArray[] = $tagItem['ID_WALLITEM'];
			$taggedArray[] = $tagItem['ID_TAGGED'];
		}
		$inItem = implode(',', $itemArray);
		$inTagged = implode(',', $taggedArray);
		$wallitems = new SnWallitems;
		$opt = array(
			'where' => 'ID_WALLITEM IN ('.$inItem.') AND '
			.          'ID_OWNER NOT IN ('.$inTagged.') '
		,	'desc'  => 'LastActivityTime'
		,	'limit' => $maxPhotosPerItem
		);
		$tagContent = Doo::db()->find($wallitems, $opt);
		//---- Merge, re-sort and limit dataset ----
		$albumContent = array_merge($albumContent, $tagContent);
		uasort($albumContent, function ($a, $b){
			return $b->LastActivityTime - $a->LastActivityTime;
		});
		$albumContent = array_slice($albumContent, 0, $maxPhotosPerItem);
	}

	$contentCount = count($albumContent);
	if ($contentCount <= 2)
		$thumbSize = THUMB_LIST_198x148;
	elseif ($contentCount == 3)
		$thumbSize = THUMB_LIST_140x110;
	elseif ($contentCount == 4)
		$thumbSize = THUMB_LIST_100x75;
	else
		$thumbSize = THUMB_LIST_80x80;

	$player = User::getuser();
	if ($player->ID_PLAYER == $item->ID_OWNER) {
		$hrefAlbums = MainHelper::site_url('players/wall/'.WALL_PHOTO.'/');
	}
	else {
		$hrefAlbums = MainHelper::site_url('player/'.$poster->URL.'/wall/'.WALL_PHOTO.'/');
	}
?>
<!-- Wall album item start -->
<div class="wall_item clearfix itemPost post_wall_<?php echo $item->ID_WALLITEM; ?>">
	<a class="wall_item_img" title="<?php echo $nick; ?>" href="<?php echo $url; ?>"><?php echo $img; ?></a>
	<div class="wall_item_meta">
		<div class="wall_item_text">
			<a href="<?php echo $url; ?>"><?php echo $nick; ?></a>
			<a class="pull_right" href="<?php echo $hrefAlbums.$item->ID_ALBUM; ?>"><?php echo $this->__('Go to album'); ?></a>
		</div>
		<?php foreach ($albumContent as $content) : ?>
			<?php /*
			<a class="thumbnail" rel="fancy_img" title="" href="<?php echo MainHelper::showImage($content, IMG_800x600, true, array('both')); ?>"><?php echo MainHelper::showImage($content, $thumbSize, false, array('both')); ?></a>
			*/ ?>
			<a rel="photo_tag" class="thumbnail" href="<?php echo MainHelper::site_url('players/iframeshowphotopopup/'.$content->ID_WALLITEM.'/'.WALL_PHOTO);?>"><?php echo MainHelper::showImage($content, $thumbSize, false, array('both'));?></a>
		<?php endforeach; ?>
		<?php include('common/comment_block.php'); ?>

		<?php if($item->isOwner() or $item->isWallOwner()): ?>
			<div class="wall_item_dropdown item_dropdown">
				<a href="javascript:void(0)" class="wall_item_dropdown_trigger item_dropdown_trigger"><?php echo $this->__('Options');?></a>
				<ul class="wall_item_dropdown_options item_dropdown_options">
					<li>
						<a class="delete_post" rel="<?php echo $item->ID_WALLITEM; ?>" href="javascript:void(0)"><?php echo $this->__('Delete');?></a>
					</li>
				</ul>
			</div>
		<?php endif;?>
	</div>
</div>
<!-- Wall album item end -->

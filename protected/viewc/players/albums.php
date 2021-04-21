<?php
include('tabs_wall.php');

function getStats($album) {
    $stats['likes'] = 0;
    $stats['comments'] = 0;
    if(isset($album->SnWallitems) && !empty($album->SnWallitems)) {
        foreach($album->SnWallitems as $item) {
            $stats['likes'] += $item->LikeCount;
            $stats['comments'] += $item->Replies;
        }
    }
    return $stats;
};

// Create New Album start
if($wallType == WALL_PHOTO): ?>
	<div class="clearfix">
		<?php if(!isset($currentAlbum) || !$currentAlbum): ?>
			<h1 class="pull_left"><?php echo $this->__('My Images'); ?></h1>
			<?php if(!isset($friendUrl) || empty($friendUrl)): ?>
				<a class="wall_input_button pull_right" href="<?php echo MainHelper::site_url('players/edit_album/'.WALL_PHOTO.'/0'); ?>">
					<?php echo $this->__('Create New Album'), ' +'; ?>
				</a>
			<?php endif;
		else: ?>
			<h1 class="pull_left"><?php echo $this->__('My Images in'), ' "', $currentAlbum->AlbumName, '"'; ?></h1>
		<?php endif; ?>
	</div>
<?php endif;
// Create New Album end

$hrefAlbums = (!isset($friendUrl) || empty($friendUrl)) ? MainHelper::site_url('players/wall/'.WALL_PHOTO.'/') : MainHelper::site_url('player/'.$poster->URL.'/wall/'.WALL_PHOTO.'/');

if((!isset($currentAlbum) || !$currentAlbum) && (isset($albums) && !empty($albums))): ?>
	<div class="item_list">
		<?php foreach($albums as $album): ?>
			<div class="list_item big clearfix itemPost">
				<?php if(isset($album->SnWallitems) && !empty($album->SnWallitems)):
					// Use first non-album as thumb
                    foreach($album->SnWallitems as $item) {
                        if($item->ItemType != 'album') {
                            $thumb = $item;
                            break 1;
                        }
                    };
					if(isset($thumb) && !empty($thumb)): ?>
						<a class="list_item_img" href="<?php echo $hrefAlbums, $album->ID_ALBUM; ?>">
                            <?php echo MainHelper::showImage($thumb, THUMB_LIST_100x100, FALSE, array('no_img' => 'noimage/no_player_100x100.png')); ?>
                        </a>
					<?php endif;
				endif; ?>
				<div class="list_item_meta">
					<h2>
						<a class="list_item_header" href="<?php echo $hrefAlbums, $album->ID_ALBUM; ?>">
							<?php echo $album->AlbumName; ?>
						</a>
					</h2>
					<p><?php echo $album->AlbumDescription; ?></p>
					<?php $stats = getStats($album); ?>
					<ul class="list_item_footer">
						<li>
							<a class="icon_link" href=""><i class="stat_image_icon"></i><?php echo $album->ImageCount; ?> Images</a>
						</li>
						<li>
							<a class="icon_link" href=""><i class="comment_icon"></i><?php echo $stats['comments']; ?> Comments</a>
						</li>
					</ul>
					<span class="list_item_date"><?php echo date('d/m/Y H:i', $album->LastUpdatedTime); ?></span>
					<?php if(!isset($friendUrl) || empty($friendUrl)): ?>
						<div class="list_item_dropdown item_dropdown">
							<a href="javascript:void(0);" class="list_item_dropdown_trigger item_dropdown_trigger">Options</a>
							<ul class="list_item_dropdown_options item_dropdown_options">
								<li>
                                    <a href="<?php echo MainHelper::site_url('players/edit_album/photo/'.$album->ID_ALBUM); ?>">
                                        <?php echo $this->__('Edit'); ?>
                                    </a>
                                </li>
								<li>
                                    <a href="<?php echo MainHelper::site_url('players/remove_album/photo/'.$album->ID_ALBUM); ?>" onClick="return confirm('Are you sure you wish to delete album and all content?');">
                                        <?php echo $this->__('Remove'); ?>
                                    </a>
                                </li>
							</ul>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif;

// Wall input start
if(!isset($friendUrl) || empty($friendUrl)): ?>
	<div class="wall_input_actions clearfix">
		<div class="pull_right">
			<a class="wall_input_button" id="wall_post_<?php echo WALL_OWNER_PLAYER, '_', $wallType; ?>" id_album="<?php echo $currentAlbum ? $currentAlbum->ID_ALBUM : 0; ?>" href="javascript:void(0);" rel="<?php echo WALL_OWNER_PLAYER, '_', $wallType; ?>">
                <?php echo $this->__('Post image'); ?>
            </a>
		</div>
	</div>
<?php endif; ?>
<!-- Wall input end -->

<!-- Wall posts start -->
<div id="wall_container" class="wall_list">
    <?php if(isset($posts)) { echo $posts; }; ?>
</div>
<?php if((!isset($posts) || $posts == '') && (!isset($albums) || empty($albums))): ?>
	<div class="noItemsText"><?php echo $this->__('There are no wall posts at this moment'); ?></div>
<?php endif; ?>
<!-- Wall posts end -->
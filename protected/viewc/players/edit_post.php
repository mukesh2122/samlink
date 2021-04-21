<?php if (isset($post) && !empty($post)) : ?>
	<?php
		include('tabs_wall.php');
		$albumOption[0] = '- '.$this->__('No Album').' -';
		if (isset($albums) && !empty($albums)) {
			foreach ($albums as $album) {
				$albumOption[$album->ID_ALBUM] = $album->AlbumName;
			}
		}
		natcasesort($albumOption);
		
		$player = User::getUser();
		$playerTagged = false;
		$walltags = new Walltags;
		$tagNames = array();
		$message = unserialize($post->Message);
		$content = unserialize($message['content']);
		$filename = $content['content'];
		$tagNames = $walltags->getAllTagNamesString($post->ID_WALLITEM);
	?>
	<form id="editForm" class="standard_form" enctype="multipart/form-data" method="post"
	 action="<?php echo MainHelper::site_url('players/edit_post/'.$wallType.'/'.$post->ID_WALLITEM); ?>">
		<div class="standard_form_elements clearfix">
			<div class="clearfix">
				<div class="standard_form_header clearfix">
					<div class="clearfix">
						<div class="pull_left" style="margin-right:10px;width:100px;">
							<?php echo MainHelper::showImage($post, THUMB_LIST_100x100, false, array('no_img' => 'noimage/no_player_100x100.png')) ?>
						</div>
						<h1 class="pull_left"><?php echo $this->__($title); ?></h1>
						<span class="pull_right standard_form_header_info">
							<?php echo $this->__('Last Activity:').date(' d/m/Y H:i', $post->LastActivityTime); ?>
						</span>
					</div>
				</div>
			</div>
			<div class="clearfix">
				<div class="standard_form_info_header">
				<h2><?php echo $this->__('Album information'); ?></h2>
				<p><?php echo $this->__('Change your post information.'); ?></p>
				</div>
			</div>
			<div class="clearfix">
				<label for="description"><?php echo $this->__('Description'); ?></label>
				<span>
					<input id="description" class="text_input" name="description" type="text" maxlength="50" value="<?php echo $description; ?>"
					 <?php echo $player->ID_PLAYER != $post->ID_OWNER ? 'disabled' : '' ?> tabindex="1">
				</span>
			</div>
			<div class="clearfix">
				<label for="album"><?php echo $this->__('Album'); ?></label>
				<span>
					<input name="oldalbum" type="hidden" value="<?php echo $post->ID_ALBUM; ?>" />
					<select name="newalbum" class="dropkick_lightWide" tabindex="2">
						<?php foreach ($albumOption as $key => $option) : ?>
							<option value="<?php echo $key; ?>" <?php echo $key == $post->ID_ALBUM ? 'selected="selected"' : ''; ?>>
								<?php echo $option; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</span>
			</div>

			<div class="clearfix">
				<label for="tagging"><?php echo $this->__('Tags'); ?></label>
				<span>
					<?php $width = 25; ?>
					<textarea id="tags" class="text_input pull_right" disabled readonly style="background-color:transparent;resize:none;padding:6px 6px 0 6px;"
					 cols="<?php echo $width; ?>" rows="<?php echo '7'; /*ceil(strlen($tagged)/$width);*/ ?>"><?php echo $tagNames; ?>
					</textarea>
				</span>
				<a rel="photo_tag" class="wall_input_button pull_right" style="margin:5px;" tabindex="3"
				 href="<?php echo MainHelper::site_url('players/iframeshowphototag/'.$post->ID_WALLITEM.'/'.WALL_PHOTO);?>">
					<?php echo $this->__('Edit Tags'); ?>
				</a>
				<?php if ($walltags->isTagged($post, $player)) : ?>
					<div id="untagMe">
						<a rel="<?php echo $player->ID_PLAYER; ?>" class="wall_input_button pull_right" style="margin:5px;" tabindex="4"
						 href="javascript:void(0);">
							<?php echo $this->__('Untag Me!'); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
			<div class="standard_form_footer clearfix">
				<a class="button button_auto light_blue pull_left" style="padding:10px;" tabindex="5"
				 href="<?php echo MainHelper::site_url('players/wall/'.WALL_PHOTO.'/'.$post->ID_ALBUM); ?>">
					<?php echo $this->__('Cancel'); ?>
				</a>
				<input type="submit" class="button button_auto light_blue pull_right" tabindex="6" value="<?php echo $this->__('Save'); ?>" />
			</div>
		</div>
	</form>
<?php endif; ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#untagMe a').click(function(){
			if (confirm('<?php echo $this->__('Are you sure?'); ?>'+"\n"+'The untag is permanent for this photo')){
				var data = {};
				data.untag = {};
				data.untag.player = <?php echo $player->ID_PLAYER; ?>;
				data.untag.wallitem = <?php echo $post->ID_WALLITEM; ?>;
				$.post(site_url+'players/ajaxphotountag', data, function(result) {
					$('#tags').text(result.tagnames);         // update tagged individuals
					$('#untagMe a').css('display', 'none');   // hide button
				});
			}
		});
	});
</script>
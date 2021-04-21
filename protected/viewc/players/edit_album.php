<?php include('tabs_wall.php'); ?>
<?php if (isset($album) && !empty($album)) : ?>
	<form id="editForm" class="standard_form" enctype="multipart/form-data" action="<?php echo MainHelper::site_url('players/edit_album/'.$wallType.'/'.$album->ID_ALBUM); ?>" method="post">
		<div class="standard_form_elements clearfix">
			<div class="clearfix">
				<div class="standard_form_header clearfix">
					<div class="clearfix">
						<h1 class="pull_left"><?php echo $this->__($title); ?></h1>
						<span class="pull_right standard_form_header_info">
							<?php echo $album->ID_ALBUM > 0 ? $this->__('Last Updated:').date(' d/m/Y H:i', $album->LastUpdatedTime) : ''; ?>
						</span>
					</div>
				</div>
			</div>
			<div class="clearfix">
				<div class="standard_form_info_header">
				<h2><?php echo $this->__('Album information'); ?></h2>
				<p><?php echo $album->ID_ALBUM > 0 ? $this->__('Change your album information.') : $this->__('List your album information.'); ?></p>
				</div>
			</div>
			<div class="clearfix">
				<label for="albumName"><?php echo $this->__('Album Name'); ?></label>
				<span>
					<input id="albumName" class="text_input" type="text" value="<?php echo $album->AlbumName; ?>" name="albumName" tabindex="1">
				</span>
			</div>
			<div class="clearfix">
				<label for="albumDescription"><?php echo $this->__('Album Descripton'); ?></label>
				<span>
					<input id="albumDescription" class="text_input" type="text" value="<?php echo $album->AlbumDescription; ?>" name="albumDescription" tabindex="2">
				</span>
			</div>
			<div class="standard_form_footer clearfix">
				<a class="button button_auto light_blue pull_left" style="padding:10px;" href="<?php echo MainHelper::site_url('players/wall/'.WALL_PHOTO); ?>">
					<?php echo $this->__('Cancel'); ?>
				</a>
				<input type="submit" class="button button_auto light_blue pull_right" value="<?php echo $this->__('Save'); ?>" />
			</div>
		</div>
	</form>
<?php endif; ?>

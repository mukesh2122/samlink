<?php
    $facebook = Layout::getActiveLayout('general_social_facebook');
    $twitter = Layout::getActiveLayout('general_social_twitter');
    $linkedin = Layout::getActiveLayout('general_social_linkedin');
    $bg_image = Layout::getActiveLayout('general_bg_img');
    $name = Layout::getActiveLayout('general_site_name');
    $bg_active = Layout::getActiveLayout('general_bg_active');
    $startgradient = Layout::getActiveLayout('general_bg_startgradient');
    $stopgradient = Layout::getActiveLayout('general_bg_stopgradient');
    $bg_color = Layout::getActiveLayout('general_bg_color');
?>
<style>
	.fileInput {
		position: relative;
		overflow: hidden;
		margin: 10px;
	}
	.fileInput input[type=file] {
		position: absolute;
		top: 0;
		right: 0;
		margin: 0;
		padding: 0;
		font-size: 20px;
		cursor: pointer;
		opacity: 0;
		filter: alpha(opacity=0);
	}
</style>

<div class="standard_form_header clearfix">
	<h1 class="pull_left"><?php echo $this->__('Stylesheet'); ?></h1>
</div>

<?php echo $this->renderBlock('common/pagination', array('pager' => $pager)); ?>

<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
	<thead>
		<tr>
			<th class="size_30 centered">
				<a href="<?php echo MainHelper::site_url('admin/setup/layout/css/sort/description/'.(isset($sortType) && $sortType == 'description' && $sortDir == 'asc' ? 'desc' : 'asc')); ?>"><?php echo $this->__('Description'); ?>
				<?php echo ($sortType == 'description' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : ''); ?></a>
			</th>
			<th class="size_40 centered">
				<a href="<?php echo MainHelper::site_url('admin/setup/layout/css/sort/filename/'.(isset($sortType) && $sortType == 'filename' && $sortDir == 'asc' ? 'desc' : 'asc')); ?>"><?php echo $this->__('Filename'); ?>
				<?php echo ($sortType == 'filename' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : ''); ?></a>
			</th>
			<th class="size_20 centered">
				<a href="<?php echo MainHelper::site_url('admin/setup/layout/css/sort/filetype/'.(isset($sortType) && $sortType == 'filetype' && $sortDir == 'asc' ? 'desc' : 'asc')); ?>"><?php echo $this->__('Filetype'); ?>
				<?php echo ($sortType == 'filetype' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : ''); ?></a>
			</th>
			<th class="size_10 centered"><?php echo $this->__('Action'); ?></th>
		</tr>
	</thead>

	<tbody>
		<?php if (!empty($cssFiles)) {
			foreach ($cssFiles as $item) { ?>
				<tr>
					<td class="centered vam">
						<a href="<?php echo Mainhelper::site_url('admin/setup/layout/css/downloadCustomCss/'.$item->ID_FILENAME); ?>"
						title="<?php echo $this->__('Download'); ?>">
							<?php echo $item->FilenameDesc; ?>
						</a><br>
					</td>
					<td class="centered vam"><?php echo $item->Path; ?></td>
					<td class="centered vam"><?php echo $item->Filetype; ?></td>
					<td class="centered vam">
						<a href="<?php echo Mainhelper::site_url('admin/setup/layout/css/edit/'.$item->ID_FILENAME); ?>">
							<?php echo $this->__('Edit'); ?>
						</a><br>
						<a href="<?php echo Mainhelper::site_url('admin/setup/layout/css/deleteCss/'.$item->ID_FILENAME); ?>"
						 onclick="return confirm('<?php echo $this->__('Are you sure you want to delete this CSS?'); ?>')">
							<?php echo $this->__('Delete'); ?>
						</a><br>
					</td>
				</tr>
			<?php }
		}
		else {
			echo '<tr><td colspan="4" class="centered">'.$this->__('No CSS files are currently available').'</td></tr>';
		} ?>
		<tr>
			<td colspan="4">
				<a class="button button_auto light_blue pull_left" href="<?php echo Mainhelper::site_url('admin/setup/layout/css/downloadCssCompanies'); ?>">
					<?php echo $this->__('Default Company CSS'); ?>
				</a>
				<a class="button button_auto light_blue pull_left button_span_left" href="<?php echo Mainhelper::site_url('admin/setup/layout/css/downloadCssGames'); ?>">
					<?php echo $this->__('Default Game CSS'); ?>
				</a>
				<a class="button button_auto light_blue pull_left button_span_left" href="<?php echo MainHelper::site_url('admin/setup/layout/css/imagemanager'); ?>" target="_blank">
					<?php echo $this->__('Image Manager'); ?>
				</a>
				<a class="button button_auto light_blue pull_right" href="<?php echo Mainhelper::site_url('admin/setup/layout/css/edit/0'); ?>">
					<?php echo $this->__('Add CSS'); ?>
				</a>
			</td>
		</tr>
	</tbody>
</table>

<?php echo $this->renderBlock('common/pagination', array('pager' => $pager)); ?>

<script type="text/javascript">
	window.onload = function() {
		document.getElementById("uploadCssSelectButton").onchange = function() {
			document.getElementById("uploadCssShowFile").value = this.value;
		};
		document.getElementById("uploadImgSelectButton").onchange = function() {
			document.getElementById("uploadImgShowFile").value = this.value;
		};
	};
</script>

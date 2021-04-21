<?php include('common/top.php'); ?>

<?php if(isset($platforms) and !empty($platforms)): ?>

	<div class="content_hidden <?php echo !User::isBlockVisible(NEWS_PLATFORM) ? '' : 'dn'; ?>">
		<table class="table table_bordered table_striped table_options" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th class="size_70"><?php echo $this->__('All Platforms');?></th>
					<th class="size_10 centered"><?php echo $this->__('Posts');?></th>
					<th class="size_20 centered"><?php echo $this->__('Popularity');?></th>
				</tr>
			</thead>
		</table>
		<div class="show_content">
			<a href="#" rel="<?php echo NEWS_PLATFORM; ?>"><?php echo $this->__('Show Platform List');?></a>
		</div>
	</div>

	<div class="content_shown <?php echo User::isBlockVisible(NEWS_PLATFORM) ? '' : 'dn'; ?>">
		<table class="table table_bordered table_striped gradient_thead table_options" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th class="size_70"><?php echo $this->__('All Platforms');?></th>
					<th class="size_10 centered"><?php echo $this->__('Posts');?></th>
					<th class="size_20 centered"><?php echo $this->__('Popularity');?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($platforms as $key => $platform):?>
				<tr <?php echo (isset($activePlatform) and $activePlatform->ID_PLATFORM == $platform->ID_PLATFORM) ? 'class="active"' : '';?>>
					<td>
						<a href="<?php echo $platform->NEWS_URL;?>"><?php echo $platform->PlatformName;?></a>
					</td>
					<td class="centered">
						<?php echo $platform->NewsCount;?>
					</td>
					<td class="centered">
						<?php echo str_repeat("<i class='green_star_icon'></i>&nbsp;", $platform->RatingCur);?><?php echo str_repeat("<i class='grey_star_icon'></i>&nbsp;", (5 - $platform->RatingCur));?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<div class="hide_content">
			<a href="#" rel="<?php echo NEWS_PLATFORM;?>"><?php echo $this->__('Hide Platform List'); ?></a>
		</div>
	</div>
<?php endif; ?>

<?php if(isset($recentBlog)):?>
    <?php echo $this->renderBlock('blog/blogList', array('blogList' => $recentBlog, 'pager' => $pager, 'pagerObj' => $pagerObj, 'rating'=>(isset($activePlatform)) ? $activePlatform->RatingCur : null, 'headerName' => (isset($activePlatform)) ? $activePlatform->PlatformName : $this->__('Recent News')));?>
<?php endif; ?>

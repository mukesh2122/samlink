<?php $shareInfo = MainHelper::shareInfo($otype, $oid, $olang); ?>
<?php $descLimit = 270; ?>
<?php $linkLimit = 70; ?>

<?php if(!empty($shareInfo)): ?>

	<div class="wall_item_article_container clearfix">
		<a class="wall_item_article_img" href="<?php echo $shareInfo->url; ?>"><?php echo $shareInfo->img; ?></a>

		<div class="wall_item_article_meta">
			<a class="wall_item_article_header" href="<?php echo $shareInfo->url; ?>"><?php echo $shareInfo->title; ?></a>
			<span class="wall_item_article_link"><a href="<?php echo $shareInfo->url; ?>"><?php echo DooTextHelper::limitChar($shareInfo->url, $linkLimit); ?></a></span>
			<div class="wall_item_article_description">
				<?php echo strip_tags(DooTextHelper::limitChar($shareInfo->description, $descLimit)); ?>
			</div>
		</div>
	</div>
<?php endif; ?>
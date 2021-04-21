<?php if(isset($event) and $event): ?>
	<!-- Event start -->
	<div class="right_column_event right_column_item">

		<h3 class="right_column_header"><?php echo $this->__('Upcoming Event');?></h3>

		<h2><a href="<?php echo $event->EVENT_URL; ?>"><?php echo $event->EventHeadline; ?></a></h2>

		<span class="right_column_date"><?php echo date(DATE_FULL, $event->EventTime); ?></span>

		<a href="<?php echo $event->EVENT_URL; ?>">
			<?php echo MainHelper::showImage($event, THUMB_LIST_200x140, false, array('no_img' => 'noimage/no_news_200x140.png')); ?>
		</a>

		<p><?php echo DooTextHelper::limitChar($event->EventDescription, 120); ?></p>

		<div class="right_column_meta">
			<a class="right_column_read_more_na" href="<?php echo $event->EVENT_URL; ?>"><?php echo $this->__('Read more »'); ?></a>
		</div>
	</div>
	<!-- Event end -->
<?php endif; ?>
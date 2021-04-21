<div class="esport_slider_wrapper">
	<div id="news_slider" class="nivoSlider esports_slider">
		<?php
			$slider = new NewsSlider;
                        $headlines = $slider->getActiveSlides();
			echo $slider->getSliderImages();
		?>
	</div>
</div>

<div class="accordion" id="accordion">
    <?php foreach($headlines as $headline): ?>
    <?php $header = strlen($headline->Headline) >= 25 ? substr($headline->Headline,0,22).'...' : $headline->Headline ; ?>
    <div class="link-header"><a href="<?php echo $headline->getEsportURL(); ?>"><span><?php echo $header; ?><p><?php echo $headline->Teaser; ?></p></span></a></div>
      <?php endforeach; ?>
</div>

<script type="text/javascript">
	$(window).load(function() {
		$('#news_slider').nivoSlider({
			effect: 'slideInLeft',
			pauseTime: 4000,
                        controlNav: false
		});
	});
</script>

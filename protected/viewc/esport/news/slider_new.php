<div class="slider-wrapper">
	<div id="news_slider" class="nivoSlider">
		<?php
			$slider = new NewsSlider;
			echo $slider->getSliderImages();
		?>
	</div>
</div>
<script type="text/javascript">
	$(window).load(function() {
		$('#news_slider').nivoSlider({
			effect: 'slideInLeft',
            animSpeed: 500,
			pauseTime: 4000,
            startSlide: 0,
            directionNav: false,
            controlNav: true,
            controlNavThumbs: false,
            pauseOnHover: true,
            manualAdvance: false,
            prevText: '',
            nextText: '',
            randomStart: false,
		});
	});
</script>
<?php
    $news = new Blog;
    $list = $news->getMostPopularBlog();
    $output = '';
    $number=count($list);
    if($number>=1):
?>
<div id="most_read_column">
	<h3>Most popular this week</h3>
	<?php		
		if (isset($list) && !empty($list)) {
			foreach ($list as $mostPopular) {
				$newsUrl = $mostPopular->NwItems->URL;
				$headline = $mostPopular->NwItemLocale->Headline;                   
				$output .= '<div class="most_read">'
				.	'<a href="'.$newsUrl.'">'.$headline.'</a>'
				.	'</div>';
			}
		}
		echo $output;
	?>
</div>
<?php
endif;
?>

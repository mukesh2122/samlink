<?php
$videoInfo = null;
if($messArr->type == WALL_VIDEO) {
	$content = (object) unserialize($messArr->content);
	if($content->type == VIDEO_YOUTUBE){
		$videoInfo = file_get_contents('http://gdata.youtube.com/feeds/api/videos/' . $content->id . '?v=2&alt=json');
		$videoInfo = json_decode($videoInfo);
	}
}
?>

<?php if (isset($videoInfo)): ?>
	<div class="clear"></div>
	<div class="clearfix mt3">
		<div class="F_showVideo_<?php echo $content->id; ?>">
			<div class="fl w120 mr4">
				<a class="db videoThumb pr showEmbededVideo" rel="<?php echo $content->id; ?>" href="javascript:void(0)" title="<?php echo htmlspecialchars($content->title); ?>">
					<img src="http://img.youtube.com/vi/<?php echo $content->id; ?>/0.jpg" onload="imageLoad(event);" />
					<span class="videoButton pa b0 l0 zi2 mb5 ml5"></span>
				</a>
			</div>
			<div class="fl w400">
				<span class="db fclg2">
					<strong>
						<a class="thickbox fclg2 showEmbededVideo" rel="<?php echo $content->id; ?>" href="javascript:void(0)" title="<?php echo htmlspecialchars($content->title); ?>">
							<?php echo $videoInfo->entry->{'title'}->{'$t'}; ?>
						</a>
					</strong>
				</span>
				<span class="db"><a href="http://youtube.com">www.youtube.com</a></span>
				<span class="fclg"><?php echo DooTextHelper::limitChar($videoInfo->entry->{'media$group'}->{'media$description'}->{'$t'}, VIDEO_DESCRIPTION_LENGTH); ?></span>
			</div>
		</div>
	</div>
<?php endif; ?>
<div class="mt10 mb15 clearfix">
    <div class="mt0 fcb post_body clearfix">
        <?php $content = (object)unserialize($media->MediaDesc);
        if($content->type == VIDEO_YOUTUBE): ?>
            <iframe width="600" height="360" src="http://www.youtube.com/embed/<?php echo $content->id; ?>" frameborder="0" allowfullscreen></iframe>
        <?php endif; ?>
    </div>
</div>
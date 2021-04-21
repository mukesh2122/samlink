<div id="most_read_column">
	<h3><?php echo $this->__('Most read this week'); ?></h3>
	<?php if(!empty($mostReadList)) {
        foreach($mostReadList as $mostRead) {
            echo '<div class="most_read"><a href="', $mostRead->NwItems->URL, '">', $mostRead->NwItemLocale->Headline, '</a></div>';
        };
    }; ?>
</div>

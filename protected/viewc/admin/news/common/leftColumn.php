<?php
$counters = News::getNewsAdminCounters();
?>
<h3><?php echo $this->__('News'); ?></h3>
<ul class="vertical_tabs">
    <li>
        <a href="<?php echo MainHelper::site_url('admin/news'); ?>"><?php echo $this->__('All News') . ' (' . $counters->News . ')'; ?></a>
    </li>
    <li>
        <a href="<?php echo MainHelper::site_url('admin/news/unpublished'); ?>"><?php echo $this->__('Unpublished News') . ' (' . $counters->UnpubNews . ')'; ?></a>
    </li>
    <li>
        <a href="<?php echo MainHelper::site_url('admin/news/local'); ?>"><?php echo $this->__('Local News') . ' (' . $counters->LocalNewsUnseen . '/' . $counters->LocalNewsAll . ')'; ?></a>
    </li>
    <li>
        <a href="<?php echo MainHelper::site_url('admin/news/unpublished-reviews'); ?>"><?php echo $this->__('Unpublished Reviews') . ' (' . $counters->UnpubReviews . ')'; ?></a>
    </li>
    <li>
        <a href="<?php echo MainHelper::site_url('admin/news/frontpage'); ?>"><?php echo $this->__('Frontpage'); ?></a>
    </li>
    <li>
        <a href="<?php echo MainHelper::site_url('admin/news/crawlersubscriptions'); ?>"><?php echo $this->__('Crawler Subscriptions'); ?></a>
    </li>
    <li>
        <a href="<?php echo MainHelper::site_url('admin/news/crawlersites'); ?>"><?php echo $this->__('Crawler Sites'); ?></a>
    </li>
    <li>
        <a href="<?php echo MainHelper::site_url('admin/news/crawlerglobals'); ?>"><?php echo $this->__('Crawler Globals'); ?></a>
    </li>
    <li>
        <a href="<?php echo MainHelper::site_url('admin/news/crawlerlogs'); ?>"><?php echo $this->__('Crawler Logs'); ?></a>
    </li>
    <li>
        <a href="<?php echo MainHelper::site_url('admin/news/edit-prefixes'); ?>"><?php echo $this->__('Edit Prefixes'); ?></a>
    </li>
    <li>
        <a href="<?php echo MainHelper::site_url('admin/news/add-news'); ?>"><?php echo $this->__('Add News'); ?></a>
    </li>
    <li>
		<a href="<?php echo MainHelper::site_url('admin/news/player-news/all/page/1');?>"><?php echo $this->__('Player News'); ?></a> 			
	</li>
    <li>
        <a href="<?php echo MainHelper::site_url('admin/news/filemanager'); ?>" target="_blank"><?php echo $this->__('Filemanager'); ?></a>
    </li>
</ul>

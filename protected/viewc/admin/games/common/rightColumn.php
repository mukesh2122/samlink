<h3><?php echo $this->__('Media'); ?></h3>
<ul class="vertical_tabs">
	<li>
		<a href="<?php echo MainHelper::site_url('admin/games/edit/'.$game->ID_GAME.'/media');?>"><?php echo $this->__('All Media');?></a>
	</li>
        <?php foreach($gameMedia as $key => $media): ?>
            <li>
                <?php if($media->MediaType!=MEDIA_VIDEO):?>
                    <a href="<?php echo MainHelper::site_url('admin/games/edit/'.$game->ID_GAME.'/media/edit/'.$media->ID_MEDIA);?>">
                <?php endif; ?>
                <?php if($media->MediaType==MEDIA_VIDEO): ?>
                    <span class="vertical_tabs">
                <?php endif; ?>
                    <?php
                        if(!empty($media->MediaName)) echo $media->MediaName;
                        else echo $this->__('Video Item ' . $key);
                    ?>
                <?php if($media->MediaType!=MEDIA_VIDEO): ?></a><?php endif; ?>
                <?php if($media->MediaType==MEDIA_VIDEO): ?></span><?php endif; ?>
            </li>
        <?php endforeach; ?>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/games/edit/'.$game->ID_GAME.'/media/new');?>"><?php echo $this->__('New Media');?></a>
	</li>
</ul>
<h3><?php echo $this->__('Downloads'); ?></h3>
<ul class="vertical_tabs">
	<li>
		<a href="<?php echo MainHelper::site_url('admin/games/edit/'.$game->ID_GAME.'/downloads');?>"><?php echo $this->__('All Downloads');?></a>
	</li>
        <?php foreach($gameDownloads as $key => $download): ?>
            <li>
                <a href="<?php echo MainHelper::site_url('admin/games/edit/'.$game->ID_GAME.'/downloads/edit/'.$download->ID_DOWNLOAD);?>">
                    <?php
                        if(!empty($download->DownloadName)) echo $download->DownloadName;
                        else echo $this->__('Download Item ' . $key);
                    ?>
                </a>
            </li>
        <?php endforeach; ?>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/games/edit/'.$game->ID_GAME.'/downloads/new');?>"><?php echo $this->__('New Download');?></a>
	</li>
</ul>
<h3><?php echo $this->__('Download Tabs'); ?></h3>
<ul class="vertical_tabs">
	<li>
		<a href="<?php echo MainHelper::site_url('admin/games/edit/'.$game->ID_GAME.'/downloadtabs');?>"><?php echo $this->__('All Download Tabs');?></a>
	</li>
        <?php foreach($gameDownloadTabs as $tab): ?>
            <li>
                <a href="<?php echo MainHelper::site_url('admin/games/edit/'.$game->ID_GAME.'/downloadtabs/edit/'.$tab->ID_FILETYPE);?>">
                    <?php
                        echo $tab->FiletypeName;
                    ?>
                </a>
            </li>
        <?php endforeach; ?>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/games/edit/'.$game->ID_GAME.'/downloadtabs/new');?>"><?php echo $this->__('New Download Tab');?></a>
	</li>
</ul>
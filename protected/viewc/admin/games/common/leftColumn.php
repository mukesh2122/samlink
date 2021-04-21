<h3><?php echo $this->__('Games'); ?></h3>
<ul class="vertical_tabs">
	<li>
		<a href="<?php echo MainHelper::site_url('admin/games');?>"><?php echo $this->__('All Games');?></a>
	</li>
        <?php foreach($gameTypes as $type): ?>
            <li>
                <a href="<?php echo MainHelper::site_url('admin/games/'.$type->ID_GAMETYPE);?>">
                    <?php
                        if(!empty($type->TypeNameTranslated)) echo $type->TypeNameTranslated;
                        else echo $type->GameTypeName;
                    ?>
                </a>
            </li>
        <?php endforeach; ?>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/games/new');?>"><?php echo $this->__('New Game');?></a>
	</li>
</ul>
<h3><?php echo $this->__('Game Types'); ?></h3>
<ul class="vertical_tabs">
	<li>
		<a href="<?php echo MainHelper::site_url('admin/games/types');?>"><?php echo $this->__('All Game Types');?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/games/types/new');?>"><?php echo $this->__('New Game Type');?></a>
	</li>
</ul>
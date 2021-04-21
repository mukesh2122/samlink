<?php if(isset($data)):
    $content = $data; 
    $inc = 0;
?>
    <div id='news_group_sub'>
    <?php print_r($data); ?>
    <?php if(!empty($content[0]->menuarticlegroup2)): ?>
	
		<?php foreach($content[0]->menuarticlegroup2 as $k2=>$v3): ?>
            <div id='filterlist2'>
            <a href='<?php MainHelper::site_url('gamesgroup'.$v3->ID_GAME); ?>'> <?php echo $v3->GameName; ?></a> <div id='posts'>(0)posts</div>.
            </div>
        <?php endforeach; ?>
    <?php endif ?>
    </div>
<?php endif ?>
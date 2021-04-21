<?php
    if(isset($urlBlog)) $url = $urlBlog;
    else $url = '';
    if(isset($item->Path) and !empty($item->Path)):?>
        <div class="list_item_path">
            
		<?php
		$num = 0;
		$totalNum = count($item->Path);
                $author = ($item->ID_AUTHOR) ? User::getById($item->ID_AUTHOR) : 0;
		?>
		<?php foreach ($item->Path as $path):?>
			<a href="<?php echo MainHelper::site_url('player/'.$author->URL . $url);?>"><?php echo $author->NickName;?></a>
			<?php echo ($num < $totalNum - 1) ? '<span></span>' : ''; ;?>
		<?php $num++; endforeach;?>
	</div>
<?php endif; ?>
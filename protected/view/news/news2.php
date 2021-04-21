
<div id='news_group_main'>
<img src='http://playnation.eu/beta/app/global/img/newsbarwithtext.jpg' />
			    	<?php if(isset($data)):
        				$content = $data; 
        				$inc = 0;
    				    ?>
 <?php if(!empty($content[0]->companygroupmain)):?>

<?php foreach($content[0]->companygroupmain as $k2=>$v3): ?>
    	<div id='filterlist'>
    	<?php foreach ($v3 as $key=>$v4): ?>
    	 <?php echo $v4; ?> <div id='posts'>(0)posts</div>
 		<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
<?php endif ?>
</div>
<div class='clear'></div>
<h1>Latest News</h1>
<?php if(!empty($content[0]->articles)):?>
	<?php foreach($content[0]->articles as $v1): ?>
    	<div id='news_list'>
    	<?php foreach ($v1 as $key=>$v2): ?>
    		<?php if ($key == 'company') : ?>
    		<div id='detailsbar'>
    		<?php endif ?>
      	 <div id='<?php echo $key; ?>'><?php echo $v2; ?></div>
    		<?php if ($key == 'game') : ?>
    		</div><div class='clear'></div>
    		<?php endif ?>
  		<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
	<?php endif ?>
<?php endif ?>

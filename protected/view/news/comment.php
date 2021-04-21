			    	<?php if(isset($data)):
        				$content = $data; 
        				$inc = 0;
    				    ?>
 <?php if(!empty($content[0]->comment2)):?>
	<?php foreach($content[0]->comment2 as $v1): ?>
    	<div id='comment_list'>
    	<?php foreach ($v1 as $key=>$v2): ?>

    			<?php if ($key == 'hour') : ?>
    			<div id='calendar'>
    			<?php endif ?>
    	 <div id='<?php echo $key; ?>'><?php echo $v2; ?></div>
    		<?php if ($key == 'month') : ?>
    		</div>
    		<?php endif ?>

		<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
	<?php endif ?>
<?php endif ?>
	

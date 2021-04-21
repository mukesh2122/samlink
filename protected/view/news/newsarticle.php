<div id='news_group_main'></div>
<?php foreach($data['menuarticlegroup'] as $k1=>$v1): ?>
   <a href='<?php echo $v1->ID_COMPANY; ?>' ><?php echo $v1->CompanyName; ?> </a>
<?php endforeach; ?>
</div>
<div id='news_list'>
<?php foreach($data['articles'] as $v1): ?>
    <?php foreach ($v1 as $key=>$v2): ?>
     <div id='<?php echo $key; ?>'><?php echo $v2; ?></div>
	<?php endforeach; ?>

<?php endforeach; ?>
</div>
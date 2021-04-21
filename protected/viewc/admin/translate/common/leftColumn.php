<h3><?php echo 'Languages'; ?></h3>
<ul class="vertical_tabs">
	<?php
		if ($translate->superadmin)
		{
	?>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/translate/languages');?>"
		<?php echo (isset($translate->A2) && $translate->A2 == "languages") ? ' class="selected"' : '';?>>Edit languages</a>
	</li>
	<?php
		}
	?>

	<?php if (isset($languages)): ?>
		<?php foreach ($languages as $keyStat => $valueStat): ?>
			<li>
				<?php if ($translate->IsLanguageAllowed($keyStat) || $translate->superadmin){ ?>
				<a href="<?php echo MainHelper::site_url('admin/'.$mainpage.'/'.$keyStat);?>"<?php echo (isset($translate->A2) && $translate->A2 == $keyStat) ? ' class="selected"' : '';?>><?php echo $valueStat;?></a>
				<?php } ?>
			</li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>



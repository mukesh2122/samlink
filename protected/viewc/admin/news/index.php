<?php if(isset($newsList) && !empty($newsList)): ?>
	<form name="allnews_form" method="post" action="">
		<input type="hidden" name="action" id="action" value="">
		<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
			<thead>
                <tr>
                    <th class="size_50 centered">
                        <a href="<?php echo MainHelper::site_url('admin/news/sort/news/'.(isset($sortType) && $sortType == 'news' && $sortDir == 'asc' ? 'desc' : 'asc')); ?>"><?php echo $this->__('All News'); ?>
                        <?php echo ($sortType == 'news' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : ''); ?></a>
                    </th>
                    <th class="size_20 centered">
                        <a href="<?php echo MainHelper::site_url('admin/news/sort/author/'.(isset($sortType) && $sortType == 'author' && $sortDir == 'asc' ? 'desc' : 'asc')); ?>"><?php echo $this->__('Author'); ?>
                        <?php echo ($sortType == 'author' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : ''); ?></a>
                    </th>
                    <th class="size_10 centered">
                        <a href="<?php echo MainHelper::site_url('admin/news/sort/languages/'.(isset($sortType) && $sortType == 'languages' && $sortDir == 'asc' ? 'desc' : 'asc')); ?>"><?php echo $this->__('Languages'); ?>
                        <?php echo ($sortType == 'languages' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : ''); ?></a>
                    </th>
                    <th class="size_10 centered"><?php echo $this->__('Delete'); ?></th>
                </tr>
			</thead>
			<tbody>
				<?php foreach($newsList as $key=>$item): ?>
				<tr>
					<td>
						<?php $owner = $item->getOwner();?>
						<div class="fs11"><?php echo date(DATE_SHORT, $item->PostingTime); ?> | <?php echo ucfirst($item->OwnerType); ?>: <a href="<?php echo $owner->url; ?>"><?php echo $owner->name; ?></a></div>
						<div class="mt5"><a href="<?php echo $item->URL; ?>"><?php echo $item->Headline; ?></a></div>
					</td>
                    <td>
                        <p><?php echo $item->Author; ?></p>
                    </td>
					<td class="centered">
						<?php if(isset($item->NwItemLocale) && !empty($item->NwItemLocale)): ?>
						<?php $editUrl = $item->EDIT_URL; ?>
							<?php $num = 0; foreach($item->NwItemLocale as $locale): ?>
								<a href="<?php echo $editUrl.'/'.$locale->ID_LANGUAGE; ?>" class="mr5"><img src="<?php echo MainHelper::site_url('global/img/flags/'.Doo::conf()->lang[$locale->ID_LANGUAGE].'.gif'); ?>" alt=""></a>
							<?php endforeach; ?>
						<?php endif; ?>
					</td>
					<td class="centered">
						<input name="ID_<?php echo $item->ID_NEWS; ?>" class="dst" type="checkbox"> 
					</td>
				</tr>
				<?php endforeach; ?>
				<tr>
					<td colspan="4">
						<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo 'Save Settings'; ?>" 
						onclick="if(confirm('<?php echo $this->__('Are you sure?'); ?>')){action.value='delete';document.allnews_form.submit();}">
					</td>
				</tr>
			</tbody>
		</table>
	<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)); ?>
	</form>
<?php endif; ?>
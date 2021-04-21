<?php if(isset($newsList) and !empty($newsList)):?>
    <form name="localnews_form" method="post" action="">
        <input type="hidden" name="filter" id="filter" value=""/>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered">
                                    <?php echo 'ID';?>
				</th>
				<th class="size_60 centered">
                                    <?php echo $this->__('Local News');?>
				</th>
				<th colspan="3" class="size_30 centered"><?php echo $this->__('Action');?></th>
			</tr>
		</thead>
		<tbody>

			<?php foreach($newsList as $item):?>
				<tr>
					<td class="centered"><?php echo $item->ID_NEWS;?></td>
					<td>
						<?php $owner = $item->getOwner();?>
						<div class="fs11"><?php echo date(DATE_SHORT, $item->PostingTime);?> | <?php echo ucfirst($item->OwnerType);?>: <a href="<?php echo $owner->url;?>"><?php echo $owner->name;?></a></div>
						<div class="mt5"><a href="<?php echo $item->URL;?>"><?php echo $item->Headline;?></a></div>
					</td>
                                        <td class="size_10 centered">
                                            <a href="<?php echo MainHelper::site_url('admin/news/local/publish/'.$item->ID_NEWS.'/'.$filter);?>"><?php echo $this->__('Publish');?></a>
                                        </td>
                                        <?php if($item->isInternal==1): ?>
                                            <td class="size_20 centered">
                                                <a href="<?php echo MainHelper::site_url('admin/news/local/status/seen/'.$item->ID_NEWS.'/'.$filter);?>"><?php echo $this->__('Mark as seen');?></a>
                                            </td>
                                        <?php elseif($item->isInternal==2): ?>
                                            <td class="size_20 centered">
                                                <a href="<?php echo MainHelper::site_url('admin/news/local/status/unseen/'.$item->ID_NEWS.'/'.$filter);?>"><?php echo $this->__('Mark as unseen');?></a>
                                            </td>
                                        <?php endif; ?>
				</tr>
			<?php endforeach;?>
                            <tr>
                                    <td colspan="5">
                                            <input class="button button_auto light_blue pull_right button_span_left" type="submit" value="<?php echo $this->__('Filter by unseen'); ?>" 
                                            onclick="if (confirm('<?php echo $this->__('Are you sure?'); ?>')){filter.value='unseen';document.localnews_form.submit();}"/>

                                            <input class="button button_auto light_blue pull_right" type="submit" value="<?php echo $this->__('No filter'); ?>" 
                                            onclick="if (confirm('<?php echo $this->__('Are you sure?'); ?>')){filter.value='off';document.localnews_form.submit();}"/>
                                    </td>
                            </tr>
		</tbody>
	</table>
    </form>
	<?php
	if(isset($pager)){
		echo $this->renderBlock('common/pagination', array('pager'=>$pager));
	}
        ?>
<?php endif; ?>

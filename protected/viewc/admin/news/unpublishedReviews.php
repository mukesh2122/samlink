<?php if(isset($newsList) and !empty($newsList)): ?>
    <form method="post" action="">
        <input type="hidden" name="filter" id="filter" value="">
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered">
                    <?php echo 'ID'; ?>
				</th>
				<th class="size_40 centered">
                    <?php echo $this->__('Unpublished Reviews'); ?>
				</th>
                <th class="size_30 centered">
                    <?php echo $this->__('Reason for unpublishing'); ?>
				</th>
				<th colspan="3" class="size_20 centered"><?php echo $this->__('Action'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($newsList as $item): ?>
				<tr>
					<td class="centered"><?php echo $item->ID_NEWS; ?></td>
					<td>
						<?php $owner = $item->getOwner(); ?>
						<div class="fs11"><?php echo date(DATE_SHORT, $item->PostingTime); ?> | <?php echo ucfirst($item->OwnerType); ?>: <a href="<?php echo $owner->url; ?>"><?php echo $owner->name; ?></a></div>
						<div class="mt5"><a href="<?php echo $item->URL; ?>"><?php echo $item->Headline; ?></a></div>
					</td>
                    <td>
                        <?php foreach($item->NwItemLocale as $lang) {
                            if($lang->EditorNote!="") {
                                echo $lang->EditorNote;
                                break;
                            };
                        }; ?>
                    </td>
                    <td class="size_10 centered">
                        <a href="<?php echo MainHelper::site_url('admin/news/unpublished-reviews/publish/'.$item->ID_NEWS); ?>"><?php echo $this->__('Republish'); ?></a>
                    </td>
                    <td class="size_10 centered">
                        <a href="<?php echo MainHelper::site_url('admin/news/unpublished-reviews/delete/'.$item->ID_NEWS); ?>"><?php echo $this->__('Delete'); ?></a>
                    </td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
    </form>
	<?php if(isset($pager)) { echo $this->renderBlock('common/pagination', array('pager'=>$pager)); };
endif; ?>

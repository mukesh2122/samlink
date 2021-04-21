<?php echo $this->renderBlock('games/common/search', array(
	'url' => MainHelper::site_url('admin/games/search'),
	'searchText' => isset($searchText) ? $searchText : '',
	'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
	'label' => $label = $this->__('Search for games...'),
	'type' => $type = $this->__('games')
));?>
<?php
$sortType = isset($sortType) ? $sortType : '';
?>
<?php if(isset($games) and !empty($games)):?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered">
					<a href="<?php echo MainHelper::site_url('admin/games/sort/11/'.(isset($sortType) && $sortType == '11' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo 'ID'.($sortType == '11' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
				<th class="size_50 centered">
					<a href="<?php echo MainHelper::site_url('admin/games/sort/12/'.(isset($sortType) && $sortType == '12' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo $this->__('Game Name').($sortType == '12' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
				<th class="size_30 centered">
					<a href="<?php echo MainHelper::site_url('admin/games/sort/13/'.(isset($sortType) && $sortType == '13' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo 'Type'.($sortType == '13' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
				<th class="size_10 centered"><?php echo $this->__('Action');?></th>
			</tr>
		</thead>
		<tbody>

			<?php foreach($games as $game):?>
				<tr>
					<td class="centered"><?php echo $game->ID_GAME;?></td>
					<td><?php echo $game->GameName;?></td>
					<td><?php echo $game->GameType;?></td>
					<td class="centered">
						<a href="<?php echo MainHelper::site_url('admin/games/edit/'.$game->ID_GAME);?>"><?php echo $this->__('Edit');?></a>
					</td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<?php
	if(isset($pager)){
		echo $this->renderBlock('common/pagination', array('pager'=>$pager));
	}
endif;
?>
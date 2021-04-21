<?php include(realpath(dirname(__FILE__) . '/../common/top.php'));?>
<?php $url = MainHelper::site_url('players/my-subscriptions');?>
<?php
	$userPlayer = User::getUser();
	$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
	$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
	$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
?>
<?php if(!empty($generalList)):?>
	<?php
	$totalSubs = 0;
	foreach ($generalList as $item) {
		$totalSubs += $item->total;
	}
	?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead table_options mb15">
		<thead>
			<tr>
				<th><?php echo $this->__('Subscriptions');?></th>
				<th class="centered"><?php echo $this->__('Number Of Subscriptions');?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="size_60">
					<a class="<?php echo $itemType == '' ? 'active' : '';?>" href="<?php echo $url;?>"><?php echo $this->__('All Subscriptions');?></a>
				</td>
				<td class="centered">
					<?php echo $totalSubs;?>
				</td>
			</tr>
			<?php foreach ($generalList as $key=>$item):?>
				<?php
					$name = '';
					if($item->ItemType == 'playersubscribe') {
						$name = $this->__('Players');
					} else if($item->ItemType == 'playerfriend') {
						$name = $this->__('Friends');
					} else if($item->ItemType == 'company') {
						$name = $this->__('Companies');
					} else if($item->ItemType == 'group') {
						$name = $this->__('Groups');
					} else if($item->ItemType == 'game') {
						$name = $this->__('Games');
					} else if($item->ItemType == 'news') {
						$name = $this->__('News');
					} else if($item->ItemType == 'event') {
						$name = $this->__('Events');
					} else if($item->ItemType == 'forum') {
						$name = $this->__('Forums as Member');
					} else if($item->ItemType == 'forumall') {
						$name = $this->__('Forums');
					} else if($item->ItemType == 'forumboard') {
						$name = $this->__('Forum Boards');
					} else if($item->ItemType == 'forumtopic') {
						$name = $this->__('Forum Topics');
					} else if($item->ItemType == 'platform') {
						$name = $this->__('Platforms');
					}
				?>
				<tr <?php echo $itemType == $item->ItemType ? 'class="active"' : '';?>>
					<td>
						<a href="<?php echo $url.'/'.$item->ItemType;?>"><?php echo $name;?></a>
					</td>
					<td class="centered">
						<?php echo $this->__($item->total);?>
					</td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<div class="mt5 clear"></div>
<?php endif;?>

<?php echo $this->renderBlock('players/common/search', array(
	'url' => MainHelper::site_url('players/my-subscriptions/search'),
	'searchText' => isset($searchText) ? $searchText : '',
	'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
	'default' => $this->__('Search for subscriptions')
));?>
<?php
$num = 0;
if(!empty($list)):?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt15">
		<thead>
			<tr>
				<th class="size_60"><?php echo $this->__('Recent Subscriptions');?></th>
				<th class="size_20 centered"><?php echo $this->__('Type');?></th>
				<th class="size_20 centered"><?php echo $this->__('Date');?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($list as $key=>$item):?>
				<?php
					$dataObj = '';
					$name = '';
					$url = '';
					if($item->ItemType == 'playersubscribe') {
						$dataObj = '{"id":"'.$item->ID_ITEM.'", "type":"'.SUBSCRIPTION_PLAYER.'"}';
						$name = $this->__('Player');

						$url = MainHelper::site_url('player/'.User::getById($item->ID_ITEM)->URL);
					} else if($item->ItemType == 'playerfriend') {
						$dataObj = '{"id":"'.$item->ID_ITEM.'", "type":"'.SUBSCRIPTION_PLAYER.'"}';
						$name = $this->__('Friend');

						$url = MainHelper::site_url('player/'.User::getById($item->ID_ITEM)->URL);
					} else if($item->ItemType == 'company') {
						$name = $this->__('Company');
						$dataObj = '{"id":"'.$item->ID_ITEM.'", "type":"'.SUBSCRIPTION_COMPANY.'"}';

						$obj = new SnCompanies();
						$obj->ID_COMPANY = $item->ID_ITEM;
						$url = Url::getUrl($obj, 'COMPANY_URL');
					} else if($item->ItemType == 'group') {
						$name = $this->__('Group');
						$dataObj = '{"id":"'.$item->ID_ITEM.'", "type":"'.SUBSCRIPTION_GROUP.'"}';

						$obj = new SnGroups();
						$obj->ID_GROUP = $item->ID_ITEM;
						$url = Url::getUrl($obj, 'GROUP_URL');
					} else if($item->ItemType == 'game') {
						$name = $this->__('Game');
						$dataObj = '{"id":"'.$item->ID_ITEM.'", "type":"'.SUBSCRIPTION_GAME.'"}';

						$obj = new SnGames();
						$obj->ID_GAME = $item->ID_ITEM;
						$url = Url::getUrl($obj, 'GAME_URL');
					} else if($item->ItemType == 'news') {
						$name = $this->__('News');
						$dataObj = '{"id":"'.$item->ID_ITEM.'", "type":"'.SUBSCRIPTION_NEWS.'"}';

						$obj = new NwItems();
						$obj->ID_NEWS = $item->ID_ITEM;
						$url = Url::getUrl($obj, 'URL');
					} else if($item->ItemType == 'event') {
						$name = $this->__('Event');
						$dataObj = '{"id":"'.$item->ID_ITEM.'", "type":"'.SUBSCRIPTION_EVENT.'"}';

						$url = MainHelper::site_url('event/'.$item->ID_ITEM);
					} else if($item->ItemType == 'forum') {
						$name = $this->__('Forum');
						$dataObj = '{"id":"'.$item->ID_ITEM.'", "type":"'.SUBSCRIPTION_FORUM.'", "otype": "'.$item->OwnerType.'", "oid": "'.$item->ID_ITEM.'"}';

						if($item->OwnerType == SUBSCRIPTION_GROUP) {
							$obj = new SnGroups();
							$obj->ID_GROUP = $item->ID_ITEM;
						} else if($item->OwnerType  == SUBSCRIPTION_GAME) {
							$obj = new SnGames();
							$obj->ID_GAME = $item->ID_ITEM;
						} else if($item->OwnerType  == SUBSCRIPTION_COMPANY) {
							$obj = new SnCompanies();
							$obj->ID_COMPANY = $item->ID_ITEM;
						}
						$url = Url::getUrl($obj, 'FORUM_URL');

					} else if($item->ItemType == 'forumall') {
						$name = $this->__('Forum');
						$dataObj = '{"id":"'.$item->ID_ITEM.'", "type":"'.SUBSCRIPTION_FORUM.'", "otype": "'.$item->OwnerType.'", "oid": "'.$item->ID_ITEM.'"}';

						if($obj == SUBSCRIPTION_GROUP) {
							$obj = new SnGroups();
							$obj->ID_GROUP = $item->ID_ITEM;
						} else if($obj == SUBSCRIPTION_GAME) {
							$obj = new SnGames();
							$obj->ID_GAME = $item->ID_ITEM;
						} else if($obj == SUBSCRIPTION_COMPANY) {
							$obj = new SnCompanies();
							$obj->ID_COMPANY = $item->ID_ITEM;
						}
						$url = Url::getUrl($obj, 'FORUM_URL');

					} else if($item->ItemType == 'forumboard') {
						$name = $this->__('Forum Board');
						$dataObj = '{"id":"'.$item->ID_ITEM.'", "type":"'.SUBSCRIPTION_BOARD.'", "otype": "'.$item->OwnerType.'", "oid": "'.$item->ID_OWNER.'"}';

						if($obj == SUBSCRIPTION_GROUP) {
							$obj = new SnGroups();
							$obj->ID_GROUP = $item->ID_ITEM;
						} else if($obj == SUBSCRIPTION_GAME) {
							$obj = new SnGames();
							$obj->ID_GAME = $item->ID_ITEM;
						} else if($obj == SUBSCRIPTION_COMPANY) {
							$obj = new SnCompanies();
							$obj->ID_COMPANY = $item->ID_ITEM;
						}
						$url = Url::getUrl($obj, 'FORUM_URL').'/'.$item->ID_ITEM;

					} else if($item->ItemType == 'forumtopic') {
						$name = $this->__('Forum Topic');
						$boardID = Forum::getBoardIdFromTopicId($item->ID_OWNER, $item->OwnerType, $item->ID_ITEM);
						$dataObj = '{"id":"'.$item->ID_ITEM.'", "type":"'.SUBSCRIPTION_TOPIC.'", "otype": "'.$item->OwnerType.'", "oid": "'.$item->ID_OWNER.'", "oid1": "'.$boardID.'"}';

						if($obj == SUBSCRIPTION_GROUP) {
							$obj = new SnGroups();
							$obj->ID_GROUP = $item->ID_ITEM;
						} else if($obj == SUBSCRIPTION_GAME) {
							$obj = new SnGames();
							$obj->ID_GAME = $item->ID_ITEM;
						} else if($obj == SUBSCRIPTION_COMPANY) {
							$obj = new SnCompanies();
							$obj->ID_COMPANY = $item->ID_ITEM;
						}
						$url = Url::getUrl($obj, 'FORUM_URL').'/'.$boardID.'/'.$item->ID_ITEM;
					} else if($item->ItemType == 'platform') {
						$name = $this->__('Platform');
						$dataObj = '{"id":"'.$item->ID_ITEM.'", "type":"'.SUBSCRIPTION_PLATFORM.'"}';

						$obj = new SnPlatforms();
						$obj->ID_PLATFORM = $item->ID_ITEM;
						$url = Url::getUrl($obj, 'NEWS_URL');
					}
				?>

				<tr>
					<td class="subscription_item">
						<a class="subscription_item_name" href="<?php echo $url;?>"><?php echo $item->ItemName;?></a>
						<?php if (!$noProfileFunctionality): ?>
							<a class="subscription_item_unsub unsubscribe_subscription unsubscribe" data-opt='<?php echo $dataObj;?>' href="javascript:void(0)"><i class="unsubscribe_icon"></i><?php echo $this->__('Unsubscribe');?></a>
						<?php endif; ?>
					</td>
					<td class="centered">
						<?php echo $name;?>
					</td>
					<td class="centered">
						<?php echo date(DATE_SHORT, $item->SubscriptionTime);?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php if (isset($pager) and $pager != ''): ?>
		<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)) ?>
	<?php endif; ?>

<?php else: ?>
	<div class="noItemsText"><?php echo $this->__('You have no subscriptions at this moment'); ?></div>
<?php endif;?>
<ul class="horizontal_tabs clearfix">
<?php
	$userPlayer = User::getUser();
	$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
	$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
	$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);

	//FriendCategories tabs
	$selectedfriendcatid = (isset($selectedfriendcatid) && !empty($selectedfriendcatid)) ? $selectedfriendcatid : 0;

	$isSelectedNative = 0;
	$query="
		SELECT 'All' as CategoryName,{$viewer->ID_PLAYER} as ID_PLAYER,1 as Native, 0 as ID_CAT
		UNION
		(SELECT CategoryName,sn_playerfriendcat.ID_PLAYER,Native,sn_playerfriendcat.ID_CAT FROM sn_playerfriendcat 
		WHERE sn_playerfriendcat.ID_PLAYER={$viewer->ID_PLAYER} AND Native in (0,1))
		ORDER BY Native DESC,ID_CAT ASC
		";

	$friendCats = Doo::db()->query($query)->fetchall();

	$selectdCatName = '';
	foreach ($friendCats as $friendCat): 
		$sc = '';
		$ID_CAT = $friendCat['ID_CAT'];
		if ($ID_CAT == $selectedfriendcatid)
		{
			$selectdCatName = $friendCat['CategoryName'];
			$sc = 'active';
			if ($friendCat['Native']==1 || $selectedfriendcatid==0)
				$isSelectedNative = 1;
		}

		
/*		$query="SELECT 
			(SELECT COUNT(DISTINCT ID_FRIEND) FROM sn_playerfriendcat_rel WHERE ID_PLAYER={$viewer->ID_PLAYER} AND ID_CAT={$ID_CAT}) as nThis ,
			(SELECT COUNT(DISTINCT ID_FRIEND) FROM sn_playerfriendcat_rel WHERE ID_PLAYER={$viewer->ID_PLAYER}) as nAll";*/

		$query="SELECT 
			(
				SELECT 
					COUNT(DISTINCT sn_playerfriendcat_rel.ID_FRIEND)
				FROM 
					sn_players,
					sn_players as sf,
					sn_playerfriendcat_rel 
				WHERE 
					sn_players.ID_PLAYER={$viewer->ID_PLAYER}
				AND sn_playerfriendcat_rel.ID_CAT={$ID_CAT}
				AND sn_playerfriendcat_rel.ID_PLAYER=sn_players.ID_PLAYER
				AND sn_playerfriendcat_rel.ID_FRIEND=sf.ID_PLAYER
				AND
				(
					SELECT COUNT(*)
					FROM 
						sn_playerfriendcat as spfc2,
						sn_playerfriendcat_rel as spfcrel2 
					WHERE spfc2.ID_PLAYER=sn_players.ID_PLAYER
					AND spfc2.ID_CAT=spfcrel2.ID_CAT
					AND spfc2.ID_PLAYER=sn_players.ID_PLAYER
					AND spfc2.Native=2
					AND spfcrel2.ID_PLAYER=sn_players.ID_PLAYER
					AND spfcrel2.ID_FRIEND=sf.ID_PLAYER
					) =0
				AND
				(
					SELECT COUNT(*)
					FROM 
						sn_playerfriendcat as spfc2,
						sn_playerfriendcat_rel as spfcrel2 
					WHERE spfc2.ID_PLAYER=sf.ID_PLAYER
					AND spfc2.ID_CAT=spfcrel2.ID_CAT
					AND spfc2.ID_PLAYER=sf.ID_PLAYER
					AND spfc2.Native=2
					AND spfcrel2.ID_PLAYER=sf.ID_PLAYER
					AND spfcrel2.ID_FRIEND=sn_players.ID_PLAYER
					) =0
			) as nThis,
			(SELECT COUNT(DISTINCT ID_FRIEND) FROM sn_playerfriendcat_rel WHERE ID_PLAYER={$viewer->ID_PLAYER}) as nAll";


		$o = (object)Doo::db()->fetchRow($query);
		$nFriendsInCat = ($ID_CAT==0) ? $o->nAll : $o->nThis;
		if ($nFriendsInCat>0 OR $friendCat['Native']==0 OR $ID_CAT==0):	?>
			<li class="<?php echo $sc;?>">
				<a class="icon_link" href="<?php echo MainHelper::site_url($baseUrl.'cat/'.$ID_CAT);?>"><?php echo $friendCat['CategoryName'] /*. " ({$nFriendsInCat})"*/;?></a>
			</li><?php
		endif;
	endforeach;
?>
<?php if ($editCat && !$noProfileFunctionality): ?>
		<li class="">
			<a class="icon_link" href="<?php echo MainHelper::site_url($baseUrl.'cat/add');?>">+</a>
		</li>
		<?php if ($isSelectedNative==0): ?>
			<li class="">
				<a class="icon_link" onclick="return confirm('<?php echo $this->__('Are you sure?'); ?>');" href="<?php echo MainHelper::site_url($baseUrl.'cat/delete_'.$selectedfriendcatid);?>">-</a>
			</li>
		<?php endif; ?>
<?php endif; ?>

	</ul>
<?php if ($editCat && !$noProfileFunctionality): ?>
	<?php if ($isSelectedNative==0): ?>
		<a href="" onclick="d=renameframe.style.display;renameframe.style.display=(d=='block')?'none':'block';return false;"><?php echo $this->__('Rename category');echo ' "'.$selectdCatName.'"'; ?></a>
		<div id="renameframe" style="display:none;">
			<form action="" method="post">
				<input name="renamefriendcategory" type="text" value="<?php echo $selectdCatName; ?>" class="text_input" />
				<input type="submit" value="OK" class="button button_auto light_blue pull_right"/>
			</form>
		</div>
	<?php endif; ?>
<?php endif; ?>

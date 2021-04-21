<?php
Doo::loadCore('db/DooSmartModel');

class SnPrivacy extends DooSmartModel{

	public $ID_PRIVSET;
	public $Title;
	public $Tag;

	public $_table = 'sn_privacy';
	public $_primarykey = '';
	public $_fields = array('ID_PRIVSET',
							'Title',
							'Tag',
						 );


						 
	public function DeleteUserPrivacy($ID_PLAYER) {
		$query = "DELETE IGNORE FROM sn_playerprivacy_rel WHERE ID_PLAYER=$ID_PLAYER";
		$rs = Doo::db()->query($query);
        return $rs;
	}

	public function CreateUserPrivacy($ID_PLAYER)
	{
		//Delete this users privacy
		//And create his privacy
		$query = "DELETE FROM sn_playerprivacy_rel WHERE ID_PLAYER=$ID_PLAYER;
			INSERT INTO sn_playerprivacy_rel 
			(ID_PLAYER,ID_PRIVSET,ID_TARGET,TargetType)
			SELECT $ID_PLAYER,ID_PRIVSET,0,'friends' FROM sn_privacy
			UNION
			SELECT $ID_PLAYER,ID_PRIVSET,0,'others' FROM sn_privacy
			UNION
			SELECT $ID_PLAYER,ID_PRIVSET,ID_CATEGORY,'category' FROM sn_privacy,sy_categories";
		$rs = Doo::db()->query($query);
        return $rs;
	}

	public function GetPrivacyTypesForPlayer($player,$poster)
	{
		$isFriend = $player->isFriend($poster->ID_PLAYER );
		$ID_CATEGORY =	MainHelper::GetPlayersCategory($player->ID_PLAYER);

		$a = array();
		$ap = $this->GetAllPrivacies();
		foreach ($ap as $p)
		{
			$a[$p['Tag']]['friends'] = 0;
			$a[$p['Tag']]['others'] = 0;
			$a[$p['Tag']]['allow'] = 0;
			$a[$p['Tag']]['category'] = array();
		}

		$query = "SELECT Tag,TargetType,ID_TARGET
			FROM sn_playerprivacy_rel,sn_privacy
			WHERE sn_playerprivacy_rel.ID_PRIVSET=sn_privacy.ID_PRIVSET
			AND ID_PLAYER={$poster->ID_PLAYER}";
		$rs = Doo::db()->query($query)->fetchall();

		foreach ($rs as $r)
		{
			$tt = $r['TargetType'];
			if ($tt=='friends')
				$a[$r['Tag']]['friends'] = 1;
			if ($tt=='others')
				$a[$r['Tag']]['others'] = 1;
			if ($tt=='category')
				$a[$r['Tag']]['category'][] = $r['ID_TARGET'];
		}

		foreach($a as $k=>$v)
		{
			$allow = 1;
			if (!$isFriend && $a[$k]['friends']==1 && $a[$k]['others']==0) $allow = 0;
			if ( $isFriend && $a[$k]['friends']==0 && $a[$k]['others']==1) $allow = 0;
			if ( $a[$k]['friends']==0 && $a[$k]['others']==0) $allow = 0;
			
			//Is player in allowed category?
			$cats = $a[$k]['category'];
			foreach ($cats as $cat)
			{
				if ($cat==$ID_CATEGORY)
					$allow = 1;
			}
			
			$a[$k]['allow'] = $allow;
		}

/*
echo "User: {$player->ID_PLAYER} usercat:{$ID_CATEGORY} <br/>  viewProfile: {$poster->ID_PLAYER}  Is friend= {$isFriend}<br/>";
echo '<table>';
foreach ($a as $k=>$v)
{
	echo "<tr>";
	echo "<td>allow={$v['allow']}</td><td>$k:</td><td>friends={$v['friends']}</td><td>others={$v['others']}</td>";
	echo "<td>cats: ";
	$cats = $v['category'];
	foreach ($cats as $cat)
	{
		echo "$cat, ";
	}
	echo "</td>";
	echo "</tr>";
}
echo "</table>";
*/
		
		return $a;
	}

	public function GetAllPrivacies()
	{
		return Doo::db()->query("SELECT * FROM {$this->_table}");
	}
	
	public function GetUserTargets($ID_PLAYER,$ID_PRIVSET)
	{
		$query = "SELECT * FROM sn_playerprivacy_rel 
			WHERE ID_PRIVSET=$ID_PRIVSET 
			AND ID_PLAYER=$ID_PLAYER";
		$rs = Doo::db()->fetchall($query);
		return $rs;
	}

	public function GetAllCategories()
	{
 		return Doo::db()->query("SELECT * FROM sy_categories");
	}
	
	public function UpdatePrivacySettingsByPost($ID_PLAYER)
	{
		$query = "DELETE FROM sn_playerprivacy_rel WHERE ID_PLAYER={$ID_PLAYER}";
		Doo::db()->query($query);//		echo "$query<br/>";
		$privacyrows = $this->GetAllPrivacies();
		foreach ($privacyrows as $prow)
		{
			$ID_PRIVSET = $prow['ID_PRIVSET'];
			$pk = 'PRIVACY_FRIENDS_'.$ID_PRIVSET;
			if (isset($_POST[$pk]))
			{
				//echo "{$ID_PRIVSET}: {$_POST[$pk]} - ";
				$query = "INSERT INTO sn_playerprivacy_rel 
					(ID_PLAYER,ID_PRIVSET,ID_TARGET,TargetType) VALUES
					({$ID_PLAYER},{$ID_PRIVSET},0,'friends')";
				Doo::db()->query($query);//		echo "$query<br/>";
			}
			$pk = 'PRIVACY_OTHERS_'.$ID_PRIVSET;
			if (isset($_POST[$pk]))
			{
				//echo "{$ID_PRIVSET}: {$_POST[$pk]} - ";
				$query = "INSERT INTO sn_playerprivacy_rel 
					(ID_PLAYER,ID_PRIVSET,ID_TARGET,TargetType) VALUES
					({$ID_PLAYER},{$ID_PRIVSET},0,'others')";
				Doo::db()->query($query);//		echo "$query<br/>";
			}
			
			$pk = 'PRIVACYCATEGORY_'.$ID_PRIVSET;
			if (isset($_POST[$pk]))
			{
				$ca = $_POST[$pk];
				foreach($ca as $c)
				{
					//echo "{$ID_PRIVSET}: cat= $c - ";
					$query = "INSERT INTO sn_playerprivacy_rel 
						(ID_PLAYER,ID_PRIVSET,ID_TARGET,TargetType) VALUES
						({$ID_PLAYER},{$ID_PRIVSET},$c,'category')";
					Doo::db()->query($query);//		echo "$query<br/>";
				}
			}
			//echo "<br/>";
		}
	}
	
}
?>
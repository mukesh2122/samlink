<?php

$player = $viewer = User::getUser();
$tab = isset($tab) ? $tab : 5;
$listTitle = $this->__('Top Players');
if($tab === 6) {
	$listTitle = $this->__('Players who play the same games as you');
} else if($tab === 7) {
	$listTitle = $this->__('Players who are members of the same groups as you');
} else if($tab === 8) {
    $listTitle = $this->__('Players who live in your area');
};
?>

<?php if(Auth::isUserLogged()): ?>
	<input type="hidden" id="selectedTab" value="">
	<ul class="horizontal_tabs clearfix">
		<li class="">
			<a class="icon_link" href="<?php echo MainHelper::site_url('players'); ?>"><i class="players_tab_icon"></i><?php echo $this->__('Find Players'); ?></a>
		</li>
		<li class="active">
			<a class="icon_link" href=""><i class="photo_tab_icon"></i><?php echo $this->__('Top Players'); ?></a>
		</li>
        </ul>
<?php endif; ?>

<?php include('common/top_player_category.php'); ?>
        
<!-- Player suggestions start -->
<div class="list_container <?php echo (!isset($searchText)) ? 'filter_options' : ''; ?>">
	<?php
/*	<!--====================================================================================-->
		THE PLAYER SEARCH IS IN HERE
	<!--====================================================================================-->	*/
	echo !$this->renderBlock('players/common/search', array(
		'url' => MainHelper::site_url('players/search'),
		'searchText' => isset($searchText) ? $searchText : '',
		'searchTotal' => isset($searchTotal) ? $searchTotal : 0
	));

	if(!isset($searchText)) {
		echo $this->renderBlock('players/common/title_bar', array(
			'title' => $listTitle,
			'selectedCategory' => $selectedCategory
		));
	};

/*	<!--====================================================================================-->
		THE FILTER BAR IS IN HERE
	<!--====================================================================================-->	*/
	if(!isset($searchText)) {
		echo $this->renderBlock('players/common/filter_bar_2', array(
			'tab' => $tab,
			'order' => isset($order) ? $order : '',
			'selectedCategory' => $selectedCategory
		));
	};

/*	<!--====================================================================================-->
		THE PLAYER LIST IS IN HERE
	<!--====================================================================================-->	*/
	if(isset($playerList)) {
		echo '<div id="wall_container" class="item_list">';
        $oldItem = "";
        $oldRank = "";
        $playerCount = count($playerList) - 1;
           
        $user = new User(); 
        
        $query = Doo::db()->query("SELECT COUNT(1) AS total
            FROM sn_playercategory_rel
            WHERE id_category = ". $selectedCategory);
        $res = $query->fetch();
        
        if ($selectedCategory == 0){
            $total = $user->getTotalPlayers($player);
        }
        else{
            $total =  $res['total']; ;
        }
        
        if(($order === "ASC") && ($tab === 1)) {
            
                    $numRank = 0;
            foreach($playerList as $item) {
                if(!is_object($oldItem)) { $rank = $total; }
                else {
                    if($oldItem->VisitCount < $item->VisitCount) {
                        $rank = $oldRank + $numRank - 1;
                        $numRank = 0;
                    } elseif($oldItem->VisitCount === $item->VisitCount) {
                        $rank = $oldRank;
                        $numRank++;
                    };
                };
                echo $this->renderBlock('common/topPlayer', array('player' => (object) $item, 'owner' => $player, 'viewer' => $viewer, 'rank' => $rank));
                
                $oldRank = $rank;
                $oldItem = $item;
            };
            
        } elseif(($order === "DESC") && ($tab === 1) || ($tab === 3) || ($tab === 4)){
            $numRank = 0;
            foreach($playerList as $item) {
                if(!is_object($oldItem)) { $rank = 1; }
                else {
                    if($oldItem->VisitCount > $item->VisitCount) {
                        $rank = $oldRank + $numRank + 1;
                        $numRank = 0;
                    } elseif($oldItem->VisitCount === $item->VisitCount) {
                        $rank = $oldRank;
                        $numRank++;
                    };
                };
                echo $this->renderBlock('common/topPlayer', array('player' => (object) $item, 'owner' => $player, 'viewer' => $viewer, 'rank' => $rank));
                $oldRank = $rank;
                $oldItem = $item;
            };
        }
            elseif(($order === "ASC") && ($tab === 2)) {
                    $numRank = 0;
            foreach($playerList as $item) {
                if(!is_object($oldItem)) { $rank = $total; }
                else {
                    if($oldItem->SocialRating < $item->SocialRating) {
                        $rank = $oldRank + $numRank - 1;
                        $numRank = 0;
                    } elseif($oldItem->SocialRating === $item->SocialRating) {
                        $rank = $oldRank;
                        $numRank++;
                    };
                };
                echo $this->renderBlock('common/topPlayer', array('player' => (object) $item, 'owner' => $player, 'viewer' => $viewer, 'rank' => $rank));
                $oldRank = $rank;
                $oldItem = $item;
            };     
    
        } elseif(($order === "DESC") && ($tab === 2)) {
            $numRank = 0;
            foreach($playerList as $item) {
                if(!is_object($oldItem)) { $rank = 1; }
                else {
                    if($oldItem->SocialRating > $item->SocialRating) {
                        $rank = $oldRank + $numRank + 1;
                        $numRank = 0;
                    } elseif($oldItem->SocialRating === $item->SocialRating) {
                        $rank = $oldRank;
                        $numRank++;
                    };
                };
                echo $this->renderBlock('common/topPlayer', array('player' => (object) $item, 'owner' => $player, 'viewer' => $viewer, 'rank' => $rank));
                $oldRank = $rank;
                $oldItem = $item;
            };
        };
        echo '</div>';

/*		<!--====================================================================================-->
			THE "SHOW MORE" BUTTON IS IN HERE
		<!--====================================================================================--> */
		echo $this->renderBlock('players/common/show_more', array(
			'tab' => $tab,
			'order' => isset($order) ? $order : '',
			'total' => isset($total) ? $total : 0,
		));

		if (isset($pager) && isset($pagerObj) && $pagerObj->totalPage > 1) {
			echo $this->renderBlock('common/pagination', array('pager' => $pager));
		};
	}; ?>
</div>
<!-- Player suggestions end -->
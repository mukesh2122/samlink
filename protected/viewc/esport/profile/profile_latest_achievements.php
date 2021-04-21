<div class="profile_latest_achievements">
	<p><?php //echo $this->__('Latest achievements').':'; ?></p>
		<?php
                        $achievements = new Achievement();
                        $player = User::getUser();
                        $latestAchievements = $achievements->getLatestAchievementsByID($player->ID_PLAYER,4);
			$titles = array('','','','');
		?>
	<ul>
            <?php foreach($latestAchievements as $latest): ?>
            <?php $achievement = $achievements->getLevelByID($latest->FK_LEVEL); 
                  $branch = $achievements->getBranchByLevelID($latest->FK_LEVEL);
                  $noimage = AchievementHelper::GetBranchNoImageName($branch->BranchName); $test=$achievement;$no=$noimage;
            ?>
		<li>
			<?php echo MainHelper::showImage($achievement, THUMB_LIST_95x95, false, array('no_img' => 'noimage/'.$noimage.'_95x95.jpg')); ?>
                    <p class="achievements_desc"><?php echo $achievement->LevelDesc;?></p>
		</li>
            <?php endforeach; ?>
	</ul>
	
</div>

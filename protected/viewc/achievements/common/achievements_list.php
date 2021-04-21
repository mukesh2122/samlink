<?php
$achievements = new Achievement();
$achievementList = $achievements->getAchievementsByBranch($branch);
$myAchievements = $achievements->getPlayerAchievementsByID($player->ID_PLAYER);
$break = 1;
$noimage = AchievementHelper::GetBranchNoImageName($branch->BranchName);
?>
<div class="achievement_wrap">
    <div class="achievement_heading">
        <h2><?php echo $branch->BranchName; ?></h2>
        <img src="<?php echo Doo::Conf()->APP_URL.'global/img/arrow_closed.png'; ?>">
    </div>
    <div class="achievement_body" id="<?php echo $branch->BranchName; ?>">
        <table>
            <?php foreach($achievementList as $achievement):
                $match = FALSE;
                foreach($myAchievements as $myAchievement) { //Checks to see if achievement is unlocked
                    if($myAchievement->FK_ACHIEVEMENT == $achievement->ID_ACHIEVEMENT) {
                        $match = TRUE;
                        $achievement->AchievementName = $myAchievement->Achievement;
                        $achievement->AchievementDesc = $myAchievement->AchievementDesc;
                        $achievement->ID_ACHIEVEMENT = $myAchievement->FK_LEVEL;
                        $achievement->ImageURL = $myAchievement->ImageURL;
                        break;
                    };
                };
                $img = MainHelper::showImage($achievement, THUMB_LIST_110x110, FALSE, array('no_img' => 'noimage/'.$noimage.'_110x110.jpg'));
                if($match): ?>
                    <td class="achieved">
                        <a href="<?php echo Doo::conf()->APP_URL, 'players/my-achievements/', $achievement->ID_ACHIEVEMENT; ?>" title="<?php echo $achievement->AchievementDesc; ?>"><?php echo $img; ?></a>
                        <p><?php echo $achievement->AchievementName; ?></p>
                    </td>
                <?php else: ?>
                    <td class="not_achieved">
                        <a title="<?php echo $achievement->AchievementDesc; ?>"><?php echo $img; ?></a>
                        <p><?php echo $achievement->AchievementName; ?></p>
                    </td> 
                <?php endif;
                if($break % 4 == 0) { echo '</tr>'; };
                $break++;
            endforeach; ?>
        </table>
    </div>
</div>
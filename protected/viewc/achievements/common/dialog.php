<?php   
$achievement = new Achievement();
$branch = $achievement->getBranchByLevelID($achievementInfo->ID_LEVEL);
$noimage = AchievementHelper::GetBranchNoImageName($branch->BranchName);
$img = MainHelper::showImage($achievementInfo, THUMB_LIST_320x320, false, array('no_img' => 'noimage/'.$noimage.'_320x320.jpg'));
?>
<div id="dialog">
    <div id="dialog_title">    
        <h1><?php echo $achievementInfo->LevelName; ?></h1>
        <h2><?php echo $achievementInfo->Points; ?></h2>
    </div>
    <div id="dialog_picture">
        <?php echo $img; ?>
    </div>    
    <h3><?php echo $achievementInfo->LevelDesc; ?></h3>
</div>
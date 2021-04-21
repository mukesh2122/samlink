<?php
$achievements = new Achievement();
$achievement = $achievements->getLevelByID($latest->FK_LEVEL);
$branch = $achievements->getBranchByLevelID($latest->FK_LEVEL);
$noimage = AchievementHelper::GetBranchNoImageName($branch->BranchName);
$img = MainHelper::showImage($achievement, THUMB_LIST_95x95, false, array('no_img' => 'noimage/'.$noimage.'_95x95.jpg'));
?>   
<li>
    <a href="javascript:void(0);" title="<?php echo date(DATE_FULL,$latest->AchievementTime); ?>"><?php echo $img; ?></a>
    <h1><?php echo $achievement->LevelName; ?></h1>
    <h2><?php echo $achievement->Points; ?></h2>
</li>
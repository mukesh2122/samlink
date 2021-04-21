<?php
$player = User::getUser();
$myplace = Achievement::getPlayerRankByID($player->ID_PLAYER);
if(!empty($myplace)): ?>
    <table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
        <thead>
            <tr>
                <th class="size_10 centered"><?php echo $this->__('Place'); ?></th>
                <th class="size_50 centered"><?php echo $this->__('Name'); ?></th>
                <th class="size_20 centered"><?php echo $this->__('Points'); ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="centered"><?php echo $myplace->Place; ?></td>
                <td class="centered"><?php echo $myplace->PlayerName; ?></td>
                <td class="centered"><?php echo $myplace->Points; ?></td>
            </tr>
        </tbody>
    </table>
<?php else: ?>
    <div class="noItemsText"><?php echo $this->__('You have currently no ranking. Unlock achievements to get points'); ?></div>
<?php endif; ?>
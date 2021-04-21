<?php
isset($friendsList) ? '' : $friendsList = FALSE;
?>

<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
	<thead>
		<tr>
			<th class="size_10 centered"><?php echo $this->__('Place'); ?></th>
			<th class="size_50 centered"><?php echo $this->__('Name'); ?></th>
            <th class="size_20 centered"><?php echo $this->__('Points'); ?></th>
		</tr>
	</thead>
	<tbody>
        <?php
        $player = User::getUser();
        if(!empty($rankings)):
            foreach($rankings as $ranking): ?>
                <tr>
                    <?php if($ranking->FK_PLAYER == $player->ID_PLAYER): ?>
                        <td class="centered"><h3><?php echo $ranking->Place; ?></h3></td>
                        <td class="centered"><h3><?php echo $ranking->PlayerName; ?></h3></td>
                        <td class="centered"><h3><?php echo $ranking->Points; ?></h3></td>
                    <?php else: ?>
                        <td class="centered"><?php echo $ranking->Place;?></td>
                        <td class="centered"><?php echo $ranking->PlayerName; ?></td>
                        <td class="centered"><?php echo $ranking->Points; ?></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach;
        endif; ?>
	</tbody>
</table>
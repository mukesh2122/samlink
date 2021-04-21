<?php if(isset($bloggers) and !empty($bloggers)):?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered"><?php echo 'ID';?></th>
				<th class="size_100 centered"><?php echo 'Name';?></th>

				<th class="size_20 centered"><?php echo $this->__('Action');?></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($bloggers as $blogger):?>
				<tr>
					<td class="centered"><?php echo $blogger->ID_PLAYER;?></td>
					<td class="centered"><?php echo $blogger->NickName;?></td>

				</tr>
			<?php endforeach;?>
		</tbody>

	</table>
	<?php

endif;
?>

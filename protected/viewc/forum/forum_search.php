<?php include('common/top.php');?>
<!-- end search forum -->
<!-- forums -->
<div class="dot_top mt10">
	<table id="forumTable">
		<tr>
			<th class="sprite_2 lborder">

			</th>
			<th class="catName">
				<?php echo $this->__('Thread title'); ?>
			</th>
			<th class="catInfo">
				<div><?php echo $this->__('Statistics'); ?>:</div>
			</th>
			<th class="catInfo">
				<div><?php echo $this->__('Last Post'); ?>:</div>
			</th>
			<th class="sprite_2 rborder">
&nbsp;
			</th>
		</tr>
	<?php
		foreach($topics as $t){
		?>
			<tr>
				<td colspan="2" class="boardTitle p10">
					<a href="<?php echo MainHelper::site_url('forum/'.$type.'/'.$ownerId.'/'.$t->ID_BOARD.'/'.$t->ID_TOPIC); ?>" class="games">
							<?php echo $t->Subject; ?>
					</a>
				</td>
				<td class="boardInfo fclg fs11 p10">
					<?php echo $this->__('Views'); ?>: <?php echo $t->ViewCount; ?><br />
					<?php echo $this->__('Replies'); ?>: <?php echo $t->ReplyCount; ?>
				</td>
				<td colspan="2" class="boardInfo fclg fs11 p10">
					<?php echo $this->__('By'); ?>: <?php echo strlen($t->lastMessage->PosterName) > 19 
							? substr($t->lastMessage->PosterName, 0, 17).'...' 
							: $t->lastMessage->PosterName; ?><br />
					<?php echo date("d/m - Y g:i A", $t->lastMessage->PostingTime); ?>
				</td>
			</tr>

		<?php
		}
	?>
	</table>
</div>
<!-- end forums -->
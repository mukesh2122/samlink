<?php $games = MainHelper::getPopularGames(); ?>

<div class="ftu_form yellow_box rounded_5 ftu_step_3">
	<div class="box_header clearfix">
		<h3><?php echo $this->__('Add your favorite games (Optional)'); ?></h3>
		<div class="ftu_form_steps">
			<a href="javascript:void(0)" class="ftu_form_step F_loadFTUStep" rel="0">1</a>
			<a href="javascript:void(0)" class="ftu_form_step F_loadFTUStep" rel="1">2</a>
			<a href="javascript:void(0)" class="current_step" rel="2">3</a>
			<a href="javascript:void(0)" class="ftu_form_step F_loadFTUStep" rel="3">4</a>
		</div>
	</div>

	<p>
		<?php echo $this->__('You can add games to your “My Games”-page to gain easy access to news, events and downloads for your favourite game.'); ?><br />
		<?php echo $this->__('Just type minimum 3 characters in the box below, hit “Search”, mark the games you want on your list and hit the “Add Games”-button.'); ?><br />
		<?php echo $this->__('For example, if you are looking for World of Goo, just type “goo” and hit “Search”.'); ?>
	</p>
	<div class="wide_search_box">
		<input type="text" class="wide_search_box_input withLabel F_searchGamesInput" title="<?php echo $this->__('Search for games...'); ?>" value="<?php echo $this->__('Search for games...'); ?>" />
		<a href="javascript:void(0)" class="wide_search_box_button mint F_searchGames"><?php echo $this->__('Search'); ?></a>
	</div>

	<?php if (!empty($games)): ?>
		<div class="small_list_container">
			<table class="small_list_table F_searchGamesList">
				<tbody>
					<?php foreach ($games as $g): ?>
						<?php echo $this->renderBlock('common/gameSmall', array('game' => $g, 'id' => 'F_addGame')); ?>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr class="small_list F_zeroGamesFound dn">
						<td>
							<div class="no-margin clearfix tac">
								<?php echo $this->__('No games found'); ?>
							</div>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	<?php endif; ?>
	<div class="add_button clearfix">
		<a href="javascript:void(0)" class="button button_medium mint F_addToGames"><?php echo $this->__('Add Games'); ?></a>
	</div>

	<div class="box_header_plus clearfix">
		<h3><?php echo $this->__('Apply for groups (Optional)'); ?></h3>
	</div>

	<p>
		<?php echo $this->__('If you are looking for a specific group, you can request to join the group, directly from the boxes below.'); ?><br />
		<?php echo $this->__('You can also skip these steps and search more specificly in the groups section later on, or you can create your own group and team up with your friends.'); ?>
	</p>
	<?php $groups = MainHelper::getLargestGroups(); ?>
	<div class="wide_search_box">
		<input type="text" class="wide_search_box_input withLabel F_searchGroupsInput" title="<?php echo $this->__('Search for groups...'); ?>" value="<?php echo $this->__('Search for groups...'); ?>" />
		<a href="javascript:void(0)" class="wide_search_box_button mint F_searchGroups"><?php echo $this->__('Search'); ?></a>
	</div>

	<?php if (!empty($groups)): ?>
		<div class="small_list_container">
			<table class="small_list_table F_searchGroupsList">
				<tbody>
					<?php foreach ($groups as $g): ?>
						<?php echo $this->renderBlock('common/groupSmall', array('group' => $g, 'id' => 'F_addGroup')); ?>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr class="small_list F_zeroGroupsFound dn">
						<td>
							<div class="no-margin clearfix tac">
								<?php echo $this->__('No groups found'); ?>
							</div>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	<?php endif; ?>

</div>

<div class="ftu_form_footer clearfix">
	<a href="javascript:void(0)" class="button button_medium light_blue F_loadFTUStep fl" rel="1"><?php echo $this->__('Previous'); ?></a>
	<a href="javascript:void(0)" class="button button_medium light_blue F_loadFTUStep fr" rel="3"><?php echo $this->__('Next'); ?></a>
</div>

<script type="text/javascript">loadCheckboxes();</script>
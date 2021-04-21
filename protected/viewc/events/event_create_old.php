<?php include('common/top.php'); ?>
<div id="createForm">
	<form method="POST">
		<div class="clearfix mt10">
			<div class="roundedInputField fl">
				<div class="rifL sprite_3 fl"></div>
				<div class="rifM fl">
					<?php echo $form->renderDisplayGroup('title'); ?>
				</div>
				<div class="rifR sprite_3 fl"></div>
			</div>
			
			<div class="roundedInputField fr">
				<div class="rifL sprite_3 fl"></div>
				<div class="rifM fl">
					<div class="fl createSelect jqtransform">
						<div class="noborder">
							<?php echo $form->renderDisplayGroup('type'); ?>
						</div>
					</div>
				</div>
				<div class="rifR sprite_3 fl"></div>
			</div>
		</div>

		
		<div class="clearfix mt10">
			<div class="h25">
				<div class="roundedInputField fl">
					<div class="rifL sprite_3 fl"></div>
					<div class="rifM fl">
						<?php echo $form->renderDisplayGroup('date'); ?>
					</div>
					<div class="rifR sprite_3 fl"></div>
				</div>

				<div class="eventRecurTypeChoose">
					<?php echo $this->__('Recurrence limited by'); ?>:
					<div class="multipleRadiosEvent">
						<?php echo $form->renderDisplayGroup('recurType'); ?>
					</div>
				</div>
				
				<div class="roundedInputField fr">
					<div class="rifL sprite_3 fl"></div>
					<div class="rifM fl w130">
						<?php echo $form->renderDisplayGroup('recurDate'); ?>
					</div>
					<div class="rifM fl w100px">
						<div class="jqtransform dateRecur">
							<div class="noborder">
								<?php echo $form->renderDisplayGroup('recurFreq'); ?>
							</div>
						</div>
					</div>
					<div class="rifR sprite_3 fl"></div>
				</div>
			</div>

			<div id="datePickContainer" class="mt10 pr" style="display:none;">
				<div class="startingDatePicker pickerCont grid_3 mt10 ml0 fl">
					<div id="pickFrom"></div>
					<label for="pickTimeFrom" class="fl mr5 mt10"><?php echo $this->__('Starting time'); ?>:</label>
					<div class="roundedInputField mt5">
						<div class="rifL sprite_3 fl"></div>
						<div class="rifM fl">
							<input type="text" class="input_text input_dynamic w30" id="pickTimeFrom" title="Event time" value="00:00" />
						</div>
						<div class="rifR sprite_3 fl"></div>
					</div>
					<input type="hidden" id="pickFromInp" value="00-00-0000" />
					<div class="clearfix"></div>
				</div>
			
				<div class="endingDatePicker pickerCont grid_3 mt10 ml40 fl">
					<div id="pickTo"></div>
					<label for="pickTimeTo" class="fl mr5 mt10"><?php echo $this->__('Ending time'); ?>:</label>
					<div class="roundedInputField fl mt5">
						<div class="rifL sprite_3 fl"></div>
						<div class="rifM fl">
							<input type="text" class="input_text input_dynamic w30" id="pickTimeTo" title="Event time" value="00:00" />
						</div>
						<div class="rifR sprite_3 fl"></div>
					</div>
					<input type="hidden" id="pickToInp" value="00-00-0000" />
					<div class="clearfix"></div>
				</div>
				<a href="#" id="closeDatePickers" class="pa t0 r0">Close</a>
				<div class="clearfix"></div>
			</div>
			
		</div>
		
		<div class="styledTextAreaFull clearfix mt10">
			<div class="topBorderTextArea"></div>
			<div class="middleTextArea">
				<?php echo $form->renderDisplayGroup('description'); ?>
			</div>
			<div class="bottomBorderTextArea"></div>
		</div>

		<div class="clearfix mt10">
			<div class="roundedInputField">
				<div class="rifL sprite_3 fl"></div>
				<div class="rifM fl">
					<?php echo $form->renderDisplayGroup('location'); ?>
				</div>
				<div class="rifR sprite_3 fl"></div>
			</div>
		</div>

		<?php
		$user = User::getUser();
		if($user){
			if (!isset($group)) {
				$friends = $user->getFriends();
			} else {
				$friends['list'] = $group->getMembers();
				$friends = (object) $friends;
			}
		}
		?>

		<div class="clearfix dot_bot mt8 pb5 pr">
			<div class="grid_3 mt20 fl">
				<a class="fs10 mr20" id="select_all" href="javascript:void(0)"><?php echo $this->__('Select All'); ?></a>
				<a class="fs10 mr20 dn" id="deselect_all" href="javascript:void(0)"><?php echo $this->__('Deselect All'); ?></a>
			</div>

			<div class="mt10 fr">
				<div class="roundedInputField">
					<div class="rifL sprite_3 fl"></div>
					<div class="rifM fl">
						<input type="text" id="search" class="friendSearchBox input_text input_dynamic" title="Search friends >" value="Search friends >" />
					</div>
					<div class="rifR sprite_3 fl"></div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<?php if (!empty($friends)): ?>
			<div id="friendsListContainer">
				<?php foreach ($friends->list as $f): ?>
					<?php
					$item = (object) $f;
					$nick = PlayerHelper::showName($item);
					$img = MainHelper::showImage($item, THUMB_LIST_60x60);
					?> 
					<?php if ($user->ID_PLAYER != $item->ID_PLAYER): ?>
						<div class="post_message post_message_<?php //echo $item->ID_PM; ?> mt10 clearfix dot_bot">
							<div class="message_inside mb10 pt10 clearfix">
								<div class="grid_1 alpha omega mt20">
									<input id="c1" value="<?php echo $item->ID_PLAYER; ?>" name="invitation[]" class="cp" type="checkbox"/>
								</div>
								<div class="friendContainer post_message alpha omega">    
									<div class="post_head friend_head  clearfix">
										<div class="grid_1 alpha"><a class="img" title="<?php echo $nick; ?>" href="<?php echo MainHelper::site_url('player/' . $item->URL); ?>"><?php echo $img ?></a></div>
										<div class="grid_3 alpha pr10 mt20">
											<span class="db mt0"><a class="searchPlayerName" href="<?php echo MainHelper::site_url('player/' . $item->URL); ?>"><?php echo $nick; ?></a></span>
										</div>

										<div class="grid_2 omega pr fclg">
											<strong><?php echo $this->__('User Info'); ?></strong>:<br />
											<?php echo $this->__('Age'); ?>: <?php echo PlayerHelper::calculateAge($item->DateOfBirth); ?><br />
											<?php echo $this->__('Country'); ?>: <?php echo PlayerHelper::getCountry($item->Country); ?><br />

										</div>
									</div>

								</div>


							</div>
						</div>
					<?php endif; ?>	
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<script type="text/javascript">loadCheckboxes();</script>

		<div class="clearfix mt10">
			<div class="roundedInputField fl">
				<div class="rifL sprite_3 fl"></div>
				<div class="rifM fl">
					<div class="fl createSelect jqtransform">
						<div class="noborder">
							<?php echo $form->renderDisplayGroup('privacy'); ?>
						</div>
					</div>
				</div>
				<div class="rifR sprite_3 fl"></div>
			</div>
			<div class="roundedInputField fr">
				<div class="rifL sprite_3 fl"></div>
				<div class="rifM fl">
					<div class="fl createSelect jqtransform">
						<div class="noborder">
							<?php echo $form->renderDisplayGroup('invite'); ?>
						</div>
					</div>
				</div>
				<div class="rifR sprite_3 fl"></div>
			</div>
			
		</div>

		<div class="createButton yellow fr mt20">
			<div class="sprite_3 fml fl"></div>
			<?php echo $form->renderDisplayGroup('submit'); ?>
			<div class="sprite_3 fmr fl"></div>
		</div>
	</form>

</div>
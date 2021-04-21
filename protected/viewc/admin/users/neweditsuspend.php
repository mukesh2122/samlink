<?php 
	//if ($suspendStatus==null)
	if (1==1)
	{
		$LevelOptions = array();
		$LevelOptions[] = array(
			'value'     => 2,
			'selected'  => 1,
			'text'      => /*"Level {$l} - ".*/Mainhelper::GetSuspendLevelText(2)
		);
		$LevelOptions[] = array(
			'value'     => 3,
			'selected'  => 0,
			'text'      => /*"Level {$l} - ".*/Mainhelper::GetSuspendLevelText(3)
		);
		$LevelOptions[] = array(
			'value'     => 5,
			'selected'  => 0,
			'text'      => /*"Level {$l} - ".*/Mainhelper::GetSuspendLevelText(5)
		);

		$reasons = array
		(
			'Spamming',
			'Offending',
			'Other'
		);
		$ReasonOptions = array();
		for ($l=0;$l<count($reasons);$l++)
		{
			$ReasonOptions[] = array(
				'value'     => $reasons[$l],
				'selected'  => (0 == $l),
				'text'      => $reasons[$l]
			);
		}

		
		$StartDate = date('Y-m-d');
		
		$EditorData = array(
			'ID'            => $user->ID_PLAYER,
			'Post'          => MainHelper::site_url('admin/users/neweditsuspend/'.$user->ID_PLAYER),
			'MainOBJ'       => $user,
			'Title'         => 'User',
			'ID_PRE'        => 'user',
			'NativeFields' 	=> array(),
			'Elements'      => array(
				array( // all the hidden values
					'type'      => 'hidden',
					'values'    => array (
						array('action', 'newsuspend'),
						array('StartDate', $StartDate)
					)
				),
				array(
					'type'      => 'titleex',
					'text'      => $this->__('New suspending'),
					'info'      => $user->NickName
				),
/*				array(
					'type'      => 'date',
					'id'        => 'StartDate',
					'prefix'    => 'StartDate_',
					'title'     => $this->__('Start date'),
					'value'     => $suspendStatus['StartDate']
				),*/
				array(
					'title'     => $this->__('Days'),
					'id'        => 'Days',
					'value'     => 1,
				),

				array(
					'type'      => 'select',
					'id'        => 'Level',
					'title'     => $this->__('Level'),
					'options'   => $LevelOptions
				),
				array(
					'type'      => 'select',
					'id'        => 'Reason',
					'title'     => $this->__('Reason'),
					'options'   => $ReasonOptions
				),
				array(
					'type'      => 'checkbox',
					'title'     => $this->__('Public'),
					'label'     => $this->__('Yes'),
					'id'        => 'Public',
					'checked'   => 	1
				)
			)
		);

		ContentHelper::ParseEditorData($EditorData);
	}
	else
	{
		$LevelOptions = array();
		for ($l=2;$l<=3;$l++)
		{
			$LevelOptions[] = array(
				'value'     => $l,
				'selected'  => ($suspendStatus['Level'] == $l),
				'text'      => /*"Level {$l} - ".*/Mainhelper::GetSuspendLevelText($l)
			);
		}
		
		$EditorData = array(
			'ID'            => $user->ID_PLAYER,
			'Post'          => MainHelper::site_url('admin/users/neweditsuspend/'.$user->ID_PLAYER),
			'MainOBJ'       => $user,
			'Title'         => 'User',
			'ID_PRE'        => 'user',
			'NativeFields' 	=> array(),
			'Elements'      => array(
				array( // all the hidden values
					'type'      => 'hidden',
					'values'    => array (
						array('action', 'editsuspend'),
						array('ID_SUSPEND', $suspendStatus['ID_SUSPEND']),
						array('StartDate', $suspendStatus['StartDate'])
					)
				),
				array(
					'type'      => 'titleex',
					'text'      => $this->__('Edit suspending'),
					'info'      => $user->NickName
				),
/*				array(
					'type'      => 'date',
					'id'        => 'StartDate',
					'prefix'    => 'StartDate_',
					'title'     => $this->__('Start date'),
					'value'     => $suspendStatus['StartDate']
				),*/
				array(
					'title'     => $this->__('Days'),
					'id'        => 'Days',
					'value'     => $suspendStatus['Days'],
				),

				array(
					'type'      => 'select',
					'id'        => 'Level',
					'title'     => $this->__('Level'),
					'options'   => $LevelOptions
				),
				array(
					'title'     => $this->__('Reason'),
					'id'        => 'Reason',
					'value'     => $suspendStatus['Reason'],
				),
				array(
					'type'      => 'checkbox',
					'title'     => $this->__('Public'),
					'label'     => $this->__('Yes'),
					'id'        => 'Public',
					'checked'   => $suspendStatus['Public'] == 1
				)
			)
		);

		ContentHelper::ParseEditorData($EditorData);
	}
?>
<br/>
<table cellspacing="0" cellpadding="0" class="table table_bordered ">
	<tr>
		<td>
			<a class="button button_auto light_blue pull_right" href="<?php echo MainHelper::site_url('admin/users/edit/'.$user->ID_PLAYER); ?>"><?php echo $this->__('Cancel'); ?></a>
		</td>
	</tr>
</table>
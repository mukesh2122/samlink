<?php
include('tabs_wall.php');
switch($wallType){
	case WALL_PHOTO:
		$postText = $this->__('Post images here...');
		$button = $this->__('Post image');

		$p = User::getUser();
		if($p->ImageLimit <= $p->WallPhotoCount) {
			$wallType = WALL_PHOTO_DISABLE;
		}

		break;
	case WALL_VIDEO:
		$postText = $this->__('Paste your video link here...');
		$button = $this->__('Post video');
		break;
	case WALL_LINK:
		$postText = $this->__('Paste your link here...');
		$button = $this->__('Post link');
		break;
	case WALL_MAIN:
	case WALL_HOME:
		$postText = $this->__('Write on Wall...');
		$button = $this->__('Post');
		break;
	case WALL_INFOPAGE:
		$postText = $this->__('Info page...');
		$button = $this->__('Info page');
		break;
	case WALL_BLOG:
		$postText = $this->__('Post blog...');
		$button = $this->__('Post blog');
		break;

	default:
		$postText = $this->__('Write on Wall...');
		break;
}

if ($wallType==WALL_INFOPAGE)
{
	$user = (!isset($friendUrl) or $friendUrl == "") ? User::getUser() : $poster;


	$extrafields = MainHelper::GetExtraFieldsByOwnertype('player',$user->ID_PLAYER);
	$CategoryName = MainHelper::GetPlayersCategoryName($user->ID_PLAYER);
	$NativeFields = MainHelper::GetModuleFieldsByTag('reguser'); 

	function InfoLine($t,$v,$fieldName,$NativeFields)
	{
		$isEnabled = true;
		if (isset($NativeFields))
			foreach ($NativeFields as $nativeField)
				if ($nativeField['FieldName']==$fieldName)
					if ($nativeField['isEnabled']==0)
						$isEnabled = false;
		if ($isEnabled)
		{
		?>
			<tr>
				<td>
					<label><?php echo $t; ?></label>
				</td>
				<td class="size_60">
					<?php echo ($v!='')?$v:'-'; ?>
				</td>
			</tr>
			<?php
		}

	}

	
	$pInfo = MainHelper::GetPersonalInformation($user->ID_PLAYER)
	
?>
<div class="standard_form_header clearfix">
	<h1 class="pull_left"><?php echo $this->__('Info page'); ?></h1>
</div>

<div class="standard_form_elements clearfix">
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
			<?php if (in_array('vcb_firstName',$pInfo)) infoLine($this->__('First name'), $user->FirstName,'FirstName',$NativeFields); ?>
			<?php if (in_array('vcb_lastName',$pInfo)) infoLine($this->__('Last name'), $user->LastName,'LastName',$NativeFields); ?>
			<?php if (in_array('vcb_nickname',$pInfo)) infoLine($this->__('Nickname'), $user->NickName,'NickName',$NativeFields); ?>
			<?php infoLine($this->__('Display name'), $user->DisplayName,'DisplayName',$NativeFields); ?>
			<?php if (in_array('vcb_dob',$pInfo)) infoLine($this->__('Age'), PlayerHelper::calculateAge($user->DateOfBirth),'DateOfBirth',$NativeFields); 
						//infoLine($this->__('Date of birth'), date(DATE_SHORT, strtotime($user->DateOfBirth)),'DateOfBirth',$NativeFields); 
			?>
			<?php if (in_array('vcb_city',$pInfo)) infoLine($this->__('City'), $user->City,'City',$NativeFields); ?>
			<?php if (in_array('vcb_country',$pInfo)) infoLine($this->__('County'), $user->Country,'Country',$NativeFields); ?>



	<?php
			//Extrafields
			foreach ($extrafields as $ef)
			{
				$FieldType = $ef['FieldType'];
				$v = '';
				switch($FieldType)
				{
					default:
					case 'text':
						$v = $ef['ValueText'];
						break;
					case 'integer':
						$v = $ef['ValueInt'];
						break;
					case 'boolean':
						$v = ($ef['ValueBoolean']==1) ? $this->__('Yes') : $this->__('No');
						break;
					case 'date':
						$v = $ef['ValueDate'];
						$v = date(DATE_SHORT, strtotime($v));
						break;
					case 'timestamp':
						$v = $ef['ValueTimestamp'];
						$v = date(DATE_SHORT, strtotime($v));
						break;
				}
				if ($v=='') $v = '-';
				if (in_array('vcb_extrafield_'.$ef['ID_FIELD'],$pInfo)) infoLine($ef['FieldName'], $v,'',null);
			}

			//Category
			if (in_array('vcb_playercategory',$pInfo)) infoLine($this->__('Category'), isset($CategoryName)?$CategoryName:'-','',null);
	?>
	</table>
</div>
<?php


	
}
else
{
	//Wall modes..
	$idAlbum = 0;
	if (isset($currentAlbum) && !empty($currentAlbum)) {
		$idAlbum = $currentAlbum->ID_ALBUM;
	}
	if(!isset($friendUrl) or $friendUrl == "") {
		echo $this->renderBlock('common/universal_wall_input', array(
			'post_text' => $postText,
			'wallType'  => WALL_OWNER_PLAYER.'_'.$wallType,
			'button'    => $button,
			'posts'     => $posts,
			'obj'       => $poster,
			'postCount' => $postCount,
			'id_album'  => $idAlbum
		));
	} else {
		echo $this->renderBlock('common/universal_wall_input', array(
			'post_text' => $this->__('Write on Friend Wall...'),
			'wallType'  =>  WALL_OWNER_FRIEND.'_'.$wallType,
			'button'    => $button,
			'posts'     => $posts,
			'obj'       => $poster,
			'postCount' => $postCount,
			'id_album'  => $idAlbum
		));
	}
}


?>
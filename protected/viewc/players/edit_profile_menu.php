<?php
	$p = User::getUser();
	$profile['selected'] = '';
	$profile['player'] = $p;
	$profile['hideMenu'] = true;
	echo $this->renderBlock('players/personalProfile', $profile);

	$section = isset($section) ? $section : 'personalinfo';

?>

<div class="left_nav">
	<ul>
		<li <?php echo $section == 'personalinfo' ? 'class="active"' : '';?>><a class="nav_wall" href="<?php echo MainHelper::site_url('players/edit/personalinfo'); ?>"><?php echo $this->__('Personal information');?></a></li>
		<li <?php echo $section == 'timezonelanguage' ? 'class="active"' : '';?>><a class="nav_wall" href="<?php echo MainHelper::site_url('players/edit/timezonelanguage'); ?>"><?php echo $this->__('Timezone & Language');?></a></li>
		<li <?php echo $section == 'userphoto' ? 'class="active"' : '';?>><a class="nav_wall" href="<?php echo MainHelper::site_url('players/edit/userphoto'); ?>"><?php echo $this->__('User Photo');?></a></li>
		<li <?php echo $section == 'privatesettings' ? 'class="active"' : '';?>><a class="nav_wall" href="<?php echo MainHelper::site_url('players/edit/privatesettings'); ?>"><?php echo $this->__('Privacy settings');?></a></li>
		<li <?php echo $section == 'membersettings' ? 'class="active"' : '';?>><a class="nav_wall" href="<?php echo MainHelper::site_url('players/edit/membersettings'); ?>"><?php echo $this->__('Membership Settings');?></a></li>
		<li <?php echo $section == 'widgets' ? 'class="active"' : '';?>><a class="nav_wall" href="<?php echo MainHelper::site_url('players/edit/widgets'); ?>"><?php echo $this->__('Widgets');?></a></li>
		<li <?php echo $section == 'emailpassword' ? 'class="active"' : '';?>><a class="nav_wall" href="<?php echo MainHelper::site_url('players/edit/emailpassword'); ?>"><?php echo $this->__('E-Mail & Password');?></a></li>
	</ul>
</div>

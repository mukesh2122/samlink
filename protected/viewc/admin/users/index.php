<?php
	echo $this->renderBlock('players/common/search', array(
		'url' => MainHelper::site_url('admin/users/search'),
		'searchText' => isset($searchText) ? $searchText : '',
		'searchTotal' => isset($searchTotal) ? $searchTotal : 0
	));
    $activateTxt = $this->__('Activate');
?>
<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
	<thead>
		<tr>
			<th class="size_10 centered">
				<a href="<?php echo MainHelper::site_url('admin/users/sort/id/'.(isset($sortType) && $sortType == 'id' && $sortDir == 'asc' ? 'desc' : 'asc')); ?>"><?php echo $this->__('ID'); ?>
				<?php echo ($sortType == 'id' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : ''); ?></a>
			</th>
			<th class="size_20 centered">
				<a href="<?php echo MainHelper::site_url('admin/users/sort/nick/'.(isset($sortType) && $sortType == 'nick' && $sortDir == 'asc' ? 'desc' : 'asc')); ?>"><?php echo $this->__('Nickname'); ?>
				<?php echo ($sortType == 'nick' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : ''); ?></a>
			</th>
			<th class="size_20 centered">
				<a href="<?php echo MainHelper::site_url('admin/users/sort/real/'.(isset($sortType) && $sortType == 'real' && $sortDir == 'asc' ? 'desc' : 'asc')); ?>"><?php echo $this->__('Real name'); ?>
				<?php echo ($sortType == 'real' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : ''); ?></a>
			</th>
			<th class="size_20 centered">
				<a href="<?php echo MainHelper::site_url('admin/users/sort/email/'.(isset($sortType) && $sortType == 'email' && $sortDir == 'asc' ? 'desc' : 'asc')); ?>"><?php echo $this->__('E-Mail'); ?>
				<?php echo ($sortType == 'email' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : ''); ?></a>
			</th>
			<th class="size_20 centered"><?php echo $this->__('Action'); ?></th>
		</tr>
	</thead>
	<tbody>
        <?php
        $player = User::getUser();
        if(isset($users) && !empty($users)):
            foreach($users as $user):
                if($player->canAccess('Edit user information') === TRUE || strpos(',0,3,4,', ','.$user->ID_USERGROUP.',') !== FALSE):
                    $userID = $user->ID_PLAYER; ?>
                    <tr>
                        <td class="centered"><?php echo $user->ID_PLAYER; ?></td>
                        <td class="centered"><?php echo $user->NickName; ?></td>
                        <td class="centered"><?php echo $user->FirstName, ' ', $user->LastName; ?></td>
                        <td class="centered"><?php echo $user->EMail; ?></td>
                        <td class="centered">
                            <a href="<?php echo MainHelper::site_url('admin/users/edit/'.$userID); ?>">
                                <?php echo $this->__('Edit'); ?>
                            </a>
                            <br>
                            <?php if($user->VerificationCode != ''): ?>
                                <ul class="activate-ul">
                                    <li class="activate-li">
                                        <a href="javascript:void(0);" class="btn_activate"><?php echo $activateTxt; ?></a>
                                    </li>
                                    <li class="show_dropdown-act dnn">
                                        <a href="javascript:void(0);" class="close">x</a>
                                        <br>
                                        <button class="rounded_gray-act" ref="<?php echo $userID; ?>">
                                            <?php echo $activateTxt; ?>
                                        </button>
                                    </li>
                                </ul>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif;
            endforeach;
        endif;
        if($player->canAccess('*') === TRUE): ?>
            <tr>
                <td colspan="5">
                    <a href="<?php echo MainHelper::site_url('admin/users/newuser'); ?>" class="button button_auto light_blue pull_right">
                        <?php echo $this->__('Add user'); ?>
                    </a>
                </td>
            </tr>
        <?php endif; ?>
	</tbody>
</table>
<?php echo (isset($pager)) ? $this->renderBlock('common/pagination', array('pager'=>$pager)): ''; ?>
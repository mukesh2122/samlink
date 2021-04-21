<?php
$functions = MainHelper::GetModuleFunctionsByTag('events');
$userPlayer = User::getUser();
$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;
$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
$showAdminFunc = false;
if(Auth::isUserLogged() === TRUE) {
    if(!$noProfileFunctionality) {
        $showAdminFunc = true;
        if($userPlayer->isDeveloper() || $userPlayer->isSuperUser || $userPlayer->isTranslator()) { $funcList[] = '<a href="javascript:void(0);" class="action_translate" data-selec="event" rel="' . $event->ID_EVENT . '">' . $this->__('Translate') . '</a>'; };
    };
};
include('common/event_tabs.php');
?>

<div class="clearfix mt15 dot_bot pb10 fcb">
    <?php echo ContentHelper::handleContentOutput($this->__($event->EventDescription));
    if($showAdminFunc === true): ?>
        <div class="mt10">
            <?php if($showAdminFunc):
                if($userPlayer->isDeveloper() || $userPlayer->isSuperUser || $userPlayer->isTranslator()) : ?>
                    <a href="javascript:void(0);" class="fs11 action_translate di mr25" data-selec="event" rel="<?php echo $event->ID_EVENT; ?>"><?php echo $this->__('Translate'); ?></a>
                <?php endif;
            endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php if ($functions['eventWall'] == 1 && $isApproved == 1):
	echo $this->renderBlock('common/universal_wall_input', array(
		'post_text' => $this->__('Write on Event Wall...'),
		'wallType' => EVENT,
		'posts' => $posts,
		'obj' => $event,
		'postCount' => $postCount,
		'admin' => $isAdmin,
        'participating' => $isParticipating,
        'subscribed' => $isSubscribed
	));
endif; ?>
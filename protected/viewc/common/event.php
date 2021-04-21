<?php
$eventUrl = $event->EVENT_URL;
$description = $event->EventDescription;
$descLimit = 170;
$showAdminFunc = FALSE;
$funcList = array();
if(Auth::isUserLogged() === TRUE) {
    $userPlayer = User::getUser();
	if($event->isAdmin()) {
		$showAdminFunc = TRUE;
		$funcList[] = '<a href="javascript:void(0);" class="action_remove_event" rel="'.$event->ID_EVENT.'">'.$this->__('Remove event').'</a>';
	};
	if($event->isParticipating()) {
		$showAdminFunc = TRUE;
		$funcList[] = '<a href="javascript:void(0);" class="action_unparticipate_event" rel="'.$event->ID_EVENT.'">'.$this->__('Unparticipate').'</a>';
	};
    if($userPlayer->isDeveloper() || $userPlayer->isSuperUser || $userPlayer->isTranslator()) {
		$showAdminFunc = TRUE;
        $funcList[] = '<a href="javascript:void(0);" class="action_translate" data-selec="event" rel="' . $event->ID_EVENT . '">' . $this->__('Translate') . '</a>';
    };
};
?>

<div class="comEventTitle">
    <div class="eventDate"><?php echo date("d/m - Y g:i A", $event->EventTime); ?></div>
    <div class="eventName">
        <a href="<?php echo $eventUrl; ?>"><?php echo $this->__($event->EventHeadline); ?></a>
    </div>
</div>
<div class="eventLeft">
    <div class="eventImg"><a href="<?php echo $eventUrl; ?>">
        <?php echo MainHelper::showImage($event, THUMB_LIST_100x100, false, array('no_img' => 'noimage/no_events_80x80.png')); ?></a>
    </div>
    <a href="#"><div class="eventParticipate">Participate</div></a>
    <a href="#"><div class="eventAddToCalendar">Add to my calendar</div></a>
</div>
<div class="eventDescription">
    <div>
    <?php
    echo $event->EventLocation;
    ?>
    </div>
    <div>
    <?php
    if($description) { echo strip_tags(DooTextHelper::limitChar($this->__($description), $descLimit)); }
    else { echo $this->__('There is no description for this event at the moment.'); };
    ?>
    </div>
</div>
<div class="clearBoth"></div>

		<p class="list_item_description long_form dn long_desc_<?php echo $event->ID_EVENT; ?>"><?php echo ContentHelper::handleContentOutput($this->__($description)); ?></p>
		    <ul class="list_item_footer">
        <?php if(strlen($description) > $descLimit): ?>
        <li><a class="icon_link revealmore" 
               data-open="<?php echo $this->__('Read more'); ?>" 
               data-close="<?php echo $this->__('Hide description'); ?>" 
               data-id="<?php echo $event->ID_EVENT; ?>" href="javascript:void(0);">
                <i class="readmore_icon"></i><?php echo $this->__('Read more'); ?></a></li>
        <?php endif; ?>
        <li><a class="icon_link" href="<?php echo $eventUrl . '/participants'; ?>">
                <i class="members_icon"></i><?php echo $event->ActiveCount; ?> 
                <?php echo ($event->ActiveCount != 1) ? $this->__('Participants') : $this->__('Participant'); ?></a></li>
    </ul>
    <?php if($showAdminFunc === TRUE): ?>
        <div class="list_item_dropdown item_dropdown">
            <a href="javascript:void(0);" class="list_item_dropdown_trigger item_dropdown_trigger">
                <?php echo $this->__('Options'); ?></a>
            <ul class="list_item_dropdown_options item_dropdown_options">
                <li><?php echo implode("</li><li>", $funcList);?></li>
            </ul>
        </div>
    <?php endif;?>

<?php
include('common/event_tabs.php');
$user = User::getUser();
$headline = isset($filled['eventHeadline']) ? $filled['eventHeadline'] : $event->EventHeadline;
if($user) {
	if(!isset($group)) { $friends = $user->getFriends(); }
    else {
		$friends['list'] = $group->getMembers();
		$friends = (object) $friends;
	};
};
?>
<form method="POST" id="F_eventEditForm" class="eventForm">
    <div class="eventCreate clearfix">
        <div class="eventCreateRoundedTop"></div>
        <div class="eventCreateRoundedMiddle">
            <div class="profileEditTitle clearfix">
                <h3><?php echo $this->__('Create event'); ?></h3>
            </div>
            <?php if(isset($error) and strlen($error) > 0): ?>
                <div class="fcr p5"><?php echo $error; ?></div>
            <?php endif; ?>
            <div class="mt5">
                <label for="eventHeadline" class="cp"><?php echo $this->__('Event Title'); ?></label>
                <div class="profileEditInput clearfix mt2 w380">
                    <div class="lrc"></div>
                    <div class="mrc w360 pr0">
                        <input type="text" id="eventHeadline" class="bareInput mt2 w290" name="eventHeadline" value="<?php echo $this->__($headline); ?>">
                    </div>
                    <div class="rrc"></div>
                </div>
                <div id="eventHeadline-error" class="error">
                    <label for="eventHeadline" class="error" generated="true"></label>
                </div>
            </div>
            <div class="mt5">
                <label for="eventType"><?php echo $this->__('Event Type'); ?>:</label>
                <div class="profileEditInput clearfix mt3 w195">
                    <div class="lrc"></div>
                    <div class="mrc w185 pr0 pr jqtrans">
                        <?php $typeIsSelected = false;
                        if((isset($filled['eventType']) and $filled['eventType'] == 0)) { $typeIsSelected = true; };
                        ?>
                        <select id="eventType" class="w185 jqTransSelect" name="eventType">
                            <option value="" <?php echo $typeIsSelected ? 'selected' : ''; ?>>
                                - <?php echo $this->__('Choose Type'); ?> -
                            </option>
                            <?php $typeIsSelected = false;
                            if((isset($filled['eventType']) and $filled['eventType'] == 0)) { $typeIsSelected = true; }
                            else { if($event->EventType == EVENT_TYPE_LIVE) { $typeIsSelected = true; }; };
                            ?>
                            <option value="<?php echo EVENT_TYPE_LIVE; ?>" <?php echo $typeIsSelected ? 'selected' : ''; ?>>
                                <?php echo $this->__(ucfirst(EVENT_TYPE_LIVE)); ?>
                            </option>
                            <?php $typeIsSelected = false;
                            if((isset($filled['eventType']) and $filled['eventType'] == 0)) { $typeIsSelected = true; }
                            else { if($event->EventType == EVENT_TYPE_ESPORT) { $typeIsSelected = true; }; };
                            ?>
                            <option value="<?php echo EVENT_TYPE_ESPORT; ?>" <?php echo $typeIsSelected ? 'selected' : ''; ?>>
                                <?php echo $this->__(ucfirst(EVENT_TYPE_ESPORT)); ?>
                            </option>
                        </select>
                    </div>
                    <div class="rrc"></div>
                </div>
                <div id="eventType-error" class="error">
                    <label for="eventType" class="error" generated="true"></label>
                </div>
            </div>
            <div class="mt5 clearfix">
                <?php
                    $selectedTZ = $event->LocalTimeOffset;
                    if(isset($filled['timezone']) and $filled['timezone'] != 0) { $selectedTZ = $filled['timezone']; };
                ?>
                <label for="timezone" class="db"><?php echo $this->__('Timezone'); ?></label>
                <select id="timezone" class="dropkick_lightWide" name="timezone" tabindex="1">
                    <?php $zones = MainHelper::getTimeZoneList();
                    foreach($zones as $zone): ?>
                        <option value="<?php echo $zone->Offset; ?>" <?php echo $selectedTZ == $zone->Offset ? 'selected' : ''; ?>>
                            <?php echo $zone->TimeZoneText.' '.$zone->HelpText; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="orgTimezone" value="<?php echo $selectedTZ; ?>">
            </div>
            <div class="clearfix add_langs">
                <?php
                    $selectedDST = 0;//$event->DSTOffset;
                    if(isset($filled['dst']) and $filled['dst'] == 1) { $selectedDST = 3600; }
                    else if(isset($filled['daylight'])) { $selectedDST = 0; };
                ?>
                <input type="hidden" name="daylight" value="1">
                <input class="dst" type="checkbox" id="dst" name="dst" value="1" <?php echo $selectedDST == 3600 ? 'checked="checked"' : ''; ?>> 
                <label for="dst"><?php echo $this->__('Daylight saving time'); ?></label>
                <input type="hidden" name="orgDST" value="<?php echo $selectedDST; ?>">
            </div>
            <div class="mt5 clearfix">
                <label for="eventDate"><?php echo $this->__('Date & Time'); ?>:</label>
                <div>
                    <div class="profileEditInput mt3 fl w120 mr5">
                        <div class="lrc"></div>
                        <div class="mrc w110 pr0 pl0">
                            <?php
                            $date = '';
                            $time = 0;
                            if(isset($filled['eventDate']) and !empty($filled['eventDate'])) { $date = $filled['eventDate']; }
                            else { $date = date('d/m/Y', $event->EventTime); };
                            if(isset($filled['eventTime']) and !empty($filled['eventTime'])) { $time = $filled['eventDate']; }
                            else { $time = intval(date('G', $event->EventTime)) * 60 + intval(date('i', $event->EventTime)); };
                            ?>
                            <input type="text" id="eventDate" class="bareInput mt2 w110 datepicker-new" name="eventDate" value="<?php echo $date; ?>">
                        </div>
                        <div class="rrc"></div>
                    </div>
                    <div class="profileEditInput mt3 fl w70">
                        <div class="lrc"></div>
                        <div class="mrc w60 pr0 jqtrans pr">
                            <select id="eventTime" class="w60 jqTransSelect" name="eventTime">
                                <option value="0" <?php echo ($time == 0) ? 'selected' : ''; ?>>- <?php echo $this->__('Time'); ?> -</option>
                                <?php
                                $tm = MainHelper::getTime();
                                foreach($tm as $t => $v): ?>
                                    <option value="<?php echo $t; ?>" <?php echo ($time == $t) ? 'selected' : ''; ?>><?php echo $v; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="rrc"></div>
                    </div>
                    <div class="fl w200	 ml5 mt5 fs11">
                        <?php if(!isset($filled['eventRecurringType']) or $filled['eventRecurringType'] == 0 or $event->RecurringEvent == 0): ?>
                            <a href="javascript:void(0);" class="addRecurring fl" ><?php echo $this->__('Make recurring'); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div id="eventDate-error" class="error clearfix">
                    <label for="eventDate" class="error" generated="true"></label>
                </div>
            </div>
            <div class="mt5 clearfix endTime">
                <label for="eventEndDate"><?php echo $this->__('End Date'); ?>:</label>
                <div>
                    <div class="profileEditInput mt3 fl w120 mr5">
                        <div class="lrc"></div>
                        <div class="mrc w110 pr0 pl0">
                            <?php
                            $date = '';
                            $time = 0;
                            if(isset($filled['eventEndDate']) and !empty($filled['eventEndDate'])) { $date = $filled['eventEndDate']; }
                            else { $date = date('d/m/Y', $event->EventTime + $event->EventDuration); };
                            if(isset($filled['eventEndTime']) and !empty($filled['eventEndTime'])) { $time = $filled['eventEndDate']; }
                            else { $time = intval(date('G', $event->EventTime + $event->EventDuration)) * 60 + intval(date('i', $event->EventTime + $event->EventDuration)); };
                            ?>
                            <input type="text" id="evenEndDate" class="bareInput mt2 w110 datepicker-new" name="eventEndDate" value="<?php echo $date; ?>">
                        </div>
                        <div class="rrc"></div>
                    </div>
                    <div class="profileEditInput mt3 fl w70">
                        <div class="lrc"></div>
                        <div class="mrc w60 pr0 jqtrans pr">
                            <select id="eventEndTime" class="w60 jqTransSelect" name="eventEndTime">
                                <option value="0" <?php echo ($time == 0) ? 'selected' : ''; ?>>- <?php echo $this->__('Time'); ?> -</option>
                                <?php
                                $tm = MainHelper::getTime();
                                foreach($tm as $t => $v): ?>
                                    <option value="<?php echo $t; ?>" <?php echo $time == $t ? 'selected' : ''; ?>><?php echo $v; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="rrc"></div>
                    </div>
                </div>
            </div>
            <div class="mt5 <?php echo (!isset($filled['eventRecurringType']) or $filled['eventRecurringType'] == 0) ? 'dn' : ''; ?> recurring">
                <label for="eventRecurringType"><?php echo $this->__('Recurrence'); ?>:</label>
                <div class="profileEditInput clearfix mt3 w195">
                    <div class="lrc"></div>
                    <div class="mrc w185 pr0 jqtrans pr">
                        <select id="eventRecurringType" class="w185 jqTransSelect" name="eventRecurringType">
                            <?php $typeIsSelected = false;
                            if(isset($filled['eventRecurringType']) and $filled['eventRecurringType'] == 0) { $typeIsSelected = true; };
                            ?>
                            <option value="0" class="defaultSelection" rel="0" <?php echo $typeIsSelected ? 'selected' : ''; ?>>
                                - <?php echo $this->__('Recurring Schedule'); ?> -
                            </option>
                            <?php $typeIsSelected = false;
                            if(isset($filled['eventRecurringType']) and $filled['eventRecurringType'] == EVENT_RECURRING_WEEKLY) { $typeIsSelected = true; }
                            else { if($event->RecurrenceInterval == EVENT_RECURRING_WEEKLY) { $typeIsSelected = true; }; };
                            ?>
                            <option value="<?php echo EVENT_RECURRING_WEEKLY; ?>" rel="<?php echo EVENT_RECURRING_WEEKLY_MAX; ?>" <?php echo $typeIsSelected ? 'selected' : ''; ?>>
                                <?php echo $this->__(ucfirst(EVENT_RECURRING_WEEKLY)); ?>
                            </option>
                            <?php $typeIsSelected = false;
                            if(isset($filled['eventRecurringType']) and $filled['eventRecurringType'] == EVENT_RECURRING_MONTHLY) { $typeIsSelected = true; }
                            else { if($event->RecurrenceInterval == EVENT_RECURRING_MONTHLY) { $typeIsSelected = true; }; };
                            ?>
                            <option value="<?php echo EVENT_RECURRING_MONTHLY; ?>" rel="<?php echo EVENT_RECURRING_MONTHLY_MAX; ?>" <?php echo $typeIsSelected ? 'selected' : ''; ?>>
                                <?php echo $this->__(ucfirst(EVENT_RECURRING_MONTHLY)); ?>
                            </option>
                            <?php $typeIsSelected = false;
                            if(isset($filled['eventRecurringType']) and $filled['eventRecurringType'] == EVENT_RECURRING_YEARLY) { $typeIsSelected = true; }
                            else { if($event->RecurrenceInterval == EVENT_RECURRING_YEARLY) { $typeIsSelected = true; }; };
                            ?>
                            <option value="<?php echo EVENT_RECURRING_YEARLY; ?>" rel="<?php echo EVENT_RECURRING_YEARLY_MAX; ?>" <?php echo $typeIsSelected ? 'selected' : ''; ?>>
                                <?php echo $this->__(ucfirst(EVENT_RECURRING_YEARLY)); ?>
                            </option>
                        </select>
                    </div>
                    <div class="rrc"></div>
                </div>
                <div class="profileEditInput clearfix mt3 w195">
                    <div class="lrc"></div>
                    <div class="mrc w185 pr0 jqtrans pr">
                        <select id="eventRecurringTimes" class="w185 jqTransSelect" name="eventRecurringTimes">
                            <option value="0">- <?php echo $this->__('Number of events'); ?> -</option>
                        </select>
                    </div>
                    <div class="rrc"></div>
                </div>
            </div>
            <div class="mt5">
                <label for="eventLocation"><?php echo $this->__('Location'); ?>:</label>
                <div class="profileEditInput clearfix mt3 w380">
                    <div class="lrc"></div>
                    <div class="mrc w360 pr0">
                        <?php
                        $location = '';
                        if(isset($filled['eventLocation']) and !empty($filled['eventLocation'])) { $location = $filled['eventLocation']; }
                        else { $location = $event->EventLocation; };
                        ?>
                        <input type="text" id="eventLocation" class="bareInput mt2 w290" name="eventLocation" value="<?php echo $this->__($location); ?>">
                    </div>
                    <div class="rrc"></div>
                </div>
            </div>
            <div class="mt5">
                <label for="eventInfo"><?php echo $this->__('Event Info'); ?>:</label>
                <div class="w380">
                    <div class="inputRoundedTopW380"></div>
                    <div class="inputRoundedMiddleW380">
                        <?php
                        $description = '';
                        if(isset($filled['eventInfo']) and !empty($filled['eventInfo'])) { $description = $filled['eventInfo']; }
                        else { $description = $event->EventDescription; };
                        ?>
                        <textarea id="eventInfo" name="eventInfo" class="ta fs11" style="width: 370px;"><?php echo $this->__($description); ?></textarea>
                    </div>
                    <div class="inputRoundedBottomW380"></div>
                </div>
            </div>
            <?php
            $EditorData = array(
                'ID_PRE'	=> 'event',
                'ID'		=> $event->ID_EVENT,
                'Title'		=> 'Event',
                'MainOBJ'	=> $event
            );
            $SnImages = Doo::db()->getOne('SnImages', array(
                'limit' => 1,
                'where' => 'ID_OWNER = ? AND OwnerType = "'.$EditorData['ID_PRE'].'"',
                'param' => array($EditorData['ID'])
            ));
            if(!is_object($SnImages)): ?>
                <div class="standard_form_info_header">
                    <h2><?php echo SnController::__($EditorData['Title'].' photo'); ?></h2>
                    <p><?php echo SnController::__('Change '.strtolower($EditorData['Title']).' photo. Use PNG, GIF or JPG.'); ?></p>
                </div>
                <div class="profile_foto_edit clearfix">
                    <label><?php echo SnController::__($EditorData['Title'].' photo'); ?></label>
                    <div class="standard_form_photo clearfix">
                        <div class="standard_form_photo_wrapper">
                            <?php echo MainHelper::showImage($EditorData['MainOBJ'], THUMB_LIST_100x100, false, array('width', 'no_img' => 'noimage/no_game_100x100.png')); ?>
                        </div>
                        <div class="standard_form_photo_action">
                            <a id="change_<?php echo $EditorData['ID_PRE'];?>_picture" rel="<?php echo $EditorData['ID']; ?>" class="button button_medium light_grey" href="javascript:void(0);"><?php echo SnController::__('Upload Photo'); ?></a>
                            <p><?php echo SnController::__('Use PNG, GIF or JPG.'); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="clearfix">
                <label><?php echo $EditorData['Title'].' square photo'; ?></label>
                <div class="standard_form_photo clearfix">
                    <div id="picture_crop_square" class="standard_form_photo_wrapper">
                        <?php echo MainHelper::showImage($EditorData['MainOBJ'], THUMB_LIST_100x100, false, array('width', 'no_img' => 'noimage/no_game_100x100.png')); ?>
                    </div>
                    <div class="standard_form_photo_action">
                        <a id="change_picture_crop_square" rel="<?php echo $EditorData['ID'];?>" ownertype="<?php echo $EditorData['ID_PRE']; ?>" orientation="square" class="change_picture_crop button button_medium light_grey" href="javascript:void(0);"><?php SnController::__('Upload Photo'); ?></a>
                        <p><?php echo SnController::__('Use PNG, GIF or JPG.'); ?></p>
                    </div>
                </div>
            </div>
            <div class="clearfix">
                <label><?php echo SnController::__($EditorData['Title'].' portrait photo'); ?></label>
                <div class="standard_form_photo clearfix">
                    <div id="picture_crop_portrait" class="standard_form_photo_wrapper">
                        <?php echo MainHelper::showImage($EditorData['MainOBJ'], THUMB_LIST_100x150, false, array('width', 'no_img' => 'noimage/no_game_100x100.png')); ?>
                    </div>
                    <div class="standard_form_photo_action">
                        <a id="change_picture_crop_portrait" rel="<?php echo $EditorData['ID'];?>" ownertype="<?php echo $EditorData['ID_PRE']; ?>" orientation="portrait" class="change_picture_crop button button_medium light_grey" href="javascript:void(0)"><?php SnController::__('Upload Photo'); ?></a>
                        <p><?php echo SnController::__('Use PNG, GIF or JPG.'); ?></p>
                    </div>
                </div>
            </div>
            <div class="clearfix">
                <label><?php echo SnController::__($EditorData['Title'].' landscape photo'); ?></label>
                <div class="standard_form_photo clearfix">
                    <div id="picture_crop_landscape" class="standard_form_photo_wrapper">
                        <?php echo MainHelper::showImage($EditorData['MainOBJ'], THUMB_LIST_100x75, false, array('width', 'no_img' => 'noimage/no_game_100x100.png')); ?>
                    </div>
                    <div class="standard_form_photo_action">
                        <a id="change_picture_crop_landscape" rel="<?php echo $EditorData['ID']; ?>" ownertype="<?php echo $EditorData['ID_PRE']; ?>" orientation="landscape" class="change_picture_crop button button_medium light_grey" href="javascript:void(0);"><?php echo SnController::__('Upload Photo'); ?></a>
                        <p><?php echo SnController::__('Use PNG, GIF or JPG.'); ?></p>
                    </div>
                </div>
            </div>
            <div class="mt5">
                <div class="">
                    <input type="checkbox" class="cp" id="isPublic" name="isPublic" value="1" <?php echo $event->isPublic == 1 ? 'checked' : ''; ?>> <label for="isPublic"><?php echo $this->__('Make the event public'); ?></label>
                </div>
            </div>
            <div class="mt5">
                <div class="">
                    <input type="checkbox" class="cp" id="isUserInvited" name="isUserInvited" value="1" <?php echo $event->InviteLevel == 'user' ? 'checked' : ''; ?>> <label for="isUserInvited"><?php echo $this->__('Let invited people invite more people'); ?></label>
                </div>
            </div>
        </div>
        <div class="eventCreateRoundedBottom"></div>
    </div>
    <a id="" class="buttonRRound eventsCreateBig fr mt5 formSubmitUniversal" href="javascript:void(0);">
        <span class="lrc"></span>
        <span class="mrc w100px tac">
            <span class="fs11"><strong><?php echo $this->__('Save'); ?></strong></span>
        </span>
        <span class="rrc"></span>
    </a>
    <input type="submit" class="hiddenSubmitButton dn">
</form>
<script type="text/javascript">loadCheckboxes(); </script>
<?php
include('common/top.php');
$user = User::getUser();
if($user) {
	if (!isset($group)) { $friends = $user->getFriends(); }
    else {
		$friends['list'] = $group->getMembers();
		$friends = (object) $friends;
	};
};
?>
<form method="POST" id="F_eventCreateForm" class="eventForm">
    <div class="eventCreate clearfix mt10">
        <div class="eventCreateRoundedTop"></div>
        <div class="eventCreateRoundedMiddle">
            <div class="profileEditTitle clearfix">
                <h3><?php echo $this->__('Create event'); ?></h3>
            </div>
            <?php if(isset($error) and strlen($error) > 0): ?>
                <div class="fcr p5"><?php echo $error; ?></div>
            <?php endif; ?>
            <div class="mt5 clearfix">
                <label for="eventHeadline" class="cp"><?php echo $this->__('Event Title'); ?></label>
                <div class="profileEditInput clearfix mt3 w380">
                    <div class="lrc"></div>
                    <div class="mrc w360 pr0">
                        <input type="text" id="eventHeadline" class="bareInput mt2 w290" name="eventHeadline" value="<?php echo isset($filled['eventHeadline']) ? $filled['eventHeadline'] : ''; ?>">
                    </div>
                    <div class="rrc"></div>
                </div>
                <div id="eventHeadline-error" class="error">
                    <label for="eventHeadline" class="error" generated="true"></label>
                </div>
            </div>

            <div class="mt5 clearfix">
                <label for="eventType"><?php echo $this->__('Event Type'); ?>:</label>
                <div class="profileEditInput clearfix mt3 w195">
                    <div class="lrc"></div>
                    <div class="mrc w185 pr0 pr jqtrans">
                        <select id="eventType" class="w185 jqTransSelect" name="eventType">
                            <option value="" <?php echo (isset($filled['eventType']) and $filled['eventType'] == 0) ? 'selected' : ''; ?>>
                                - <?php echo $this->__('Choose Type'); ?> -
                            </option>
                            <option value="<?php echo EVENT_TYPE_LIVE; ?>" <?php echo (isset($filled['eventType']) and $filled['eventType'] == EVENT_TYPE_LIVE) ? 'selected' : ''; ?>>
                                <?php echo $this->__(ucfirst(EVENT_TYPE_LIVE)); ?>
                            </option>
                            <option value="<?php echo EVENT_TYPE_ESPORT; ?>" <?php echo (isset($filled['eventType']) and $filled['eventType'] == EVENT_TYPE_ESPORT) ? 'selected' : ''; ?>>
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
                    $selectedTZ = $user->TimeOffset;
                    if(isset($filled['timezone']) and $filled['timezone'] != 0) { $selectedTZ = $filled['timezone']; };
                ?>
                <label for="timezone" class="db"><?php echo $this->__('Timezone'); ?></label>
                <select id="timezone" class="dropkick_lightWide" name="timezone" tabindex="1">
                    <?php $zones = MainHelper::getTimeZoneList(); ?>
                    <?php foreach($zones as $zone): ?>
                        <option value="<?php echo $zone->Offset; ?>" <?php echo $selectedTZ == $zone->Offset ? 'selected' : ''; ?>>
                            <?php echo $zone->TimeZoneText.' '.$zone->HelpText; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="clearfix add_langs">
                <?php
                    $selectedDST = $user->DSTOffset;
                    if(isset($filled['dst']) and $filled['dst'] == 1) { $selectedDST = 3600; }
                    else if(isset($filled['daylight'])) { $selectedDST = 0; };
                ?>
                <input type="hidden" name="daylight" value="1">
                <input class="dst" type="checkbox" id="dst" name="dst" value="1" <?php echo $selectedDST == 3600 ? 'checked="checked"' : ''; ?>> 
                <label for="dst"><?php echo $this->__('Daylight saving time'); ?></label>
            </div>
            <div class="mt5 clearfix">
                <label for="eventDate"><?php echo $this->__('Date & Time'); ?>:</label>
                <div class="clearfix">
                    <div class="profileEditInput mt3 fl w120 mr5 ">
                        <div class="lrc"></div>
                        <div class="mrc w110 pr0 pl0">
                            <input type="text" id="eventDate" class="bareInput mt2 w110 datepicker-new" name="eventDate" value="<?php echo isset($filled['eventDate']) ? $filled['eventDate'] : ''; ?>">
                        </div>
                        <div class="rrc"></div>
                    </div>
                    <div class="profileEditInput mt3 fl w70">
                        <div class="lrc"></div>
                        <div class="mrc w60 pr0 jqtrans pr">
                            <select id="eventTime" class="w60 jqTransSelect" name="eventTime">
                                <option value="0" <?php echo (isset($filled['eventTime']) and $filled['eventTime'] == 0) ? 'selected' : ''; ?>>- <?php echo $this->__('Time'); ?> -</option>
                                <?php $time = MainHelper::getTime();
                                foreach($time as $t => $v): ?>
                                    <option value="<?php echo $t; ?>" <?php echo (isset($filled['eventTime']) and $filled['eventTime'] == $t) ? 'selected' : ''; ?>>
                                        <?php echo $v; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="rrc"></div>
                    </div>
                    <div class="fl w200	 ml5 mt5 fs11">
                        <?php if(!isset($filled['eventEndDate']) or strlen($filled['eventEndDate']) == 0): ?>
                            <a href="javascript:void(0);" class="addEndTime fl mr5" ><?php echo $this->__('Add end time'); ?></a> 
                        <?php endif; ?>
                        <?php if(!isset($filled['eventRecurringType']) or $filled['eventRecurringType'] == 0): ?>
                            <a href="javascript:void(0);" class="addRecurring fl" ><?php echo $this->__('Make recurring'); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div id="eventDate-error" class="error clearfix">
                    <label for="eventDate" class="error" generated="true"></label>
                </div>
            </div>
            <div class="mt5 clearfix <?php echo (!isset($filled['eventEndDate']) or strlen($filled['eventEndDate']) == 0) ? 'dn' : ''; ?> endTime">
                <label for="eventEndDate"><?php echo $this->__('End Date'); ?>:</label>
                <div>
                    <div class="profileEditInput mt3 fl w120 mr5">
                        <div class="lrc"></div>
                        <div class="mrc w110 pr0 pl0">
                            <input type="text" id="evenEndDate" class="bareInput mt2 w110 datepicker-new" name="eventEndDate" value="<?php echo isset($filled['eventEndDate']) ? $filled['eventEndDate'] : ''; ?>">
                        </div>
                        <div class="rrc"></div>
                    </div>
                    <div class="profileEditInput mt3 fl w70">
                        <div class="lrc"></div>
                        <div class="mrc w60 pr0 jqtrans pr">
                            <select id="eventEndTime" class="w60 jqTransSelect" name="eventEndTime">
                                <option value="0" <?php echo (isset($filled['eventEndTime']) and $filled['eventEndTime'] == 0) ? 'selected' : ''; ?>>- <?php echo $this->__('Time'); ?> -</option>
                                <?php $time = MainHelper::getTime();
                                foreach($time as $t => $v): ?>
                                    <option value="<?php echo $t; ?>" <?php echo (isset($filled['eventEndTime']) and $filled['eventEndTime'] == $t) ? 'selected' : ''; ?>>
                                        <?php echo $v; ?>
                                    </option>
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
                            <option value="0" class="defaultSelection" rel="0" <?php echo (isset($filled['eventRecurringType']) and $filled['eventRecurringType'] == 0) ? 'selected' : ''; ?>>
                                - <?php echo $this->__('Recurring Schedule'); ?> -
                            </option>
                            <option value="<?php echo EVENT_RECURRING_WEEKLY; ?>" rel="<?php echo EVENT_RECURRING_WEEKLY_MAX; ?>" <?php echo (isset($filled['eventRecurringType']) and $filled['eventRecurringType'] == EVENT_RECURRING_WEEKLY) ? 'selected' : ''; ?>>
                                <?php echo $this->__(ucfirst(EVENT_RECURRING_WEEKLY)); ?>
                            </option>
                            <option value="<?php echo EVENT_RECURRING_MONTHLY; ?>" rel="<?php echo EVENT_RECURRING_MONTHLY_MAX; ?>" <?php echo (isset($filled['eventRecurringType']) and $filled['eventRecurringType'] == EVENT_RECURRING_MONTHLY) ? 'selected' : ''; ?>>
                                <?php echo $this->__(ucfirst(EVENT_RECURRING_MONTHLY)); ?>
                            </option>
                            <option value="<?php echo EVENT_RECURRING_YEARLY; ?>" rel="<?php echo EVENT_RECURRING_YEARLY_MAX; ?>" <?php echo (isset($filled['eventRecurringType']) and $filled['eventRecurringType'] == EVENT_RECURRING_YEARLY) ? 'selected' : ''; ?>>
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
                        <input type="text" id="eventLocation" class="bareInput mt2 w290" name="eventLocation" value="<?php echo isset($filled['eventLocation']) ? $filled['eventLocation'] : ''; ?>">
                    </div>
                    <div class="rrc"></div>
                </div>
            </div>
            <div class="mt5">
                <label for="eventInfo"><?php echo $this->__('Event Info'); ?>:</label>
                <div class="w380">
                    <div class="inputRoundedTopW380"></div>
                    <div class="inputRoundedMiddleW380">
                        <textarea id="eventInfo" name="eventInfo" class="ta fs11"><?php echo isset($filled['eventInfo']) ? $filled['eventInfo'] : ''; ?></textarea>
                    </div>
                    <div class="inputRoundedBottomW380"></div>
                </div>
            </div>
            <div class="mt5">
                <?php echo $this->__("Who's invited?"); ?>
                <div>
                    <a id="" class="buttonRRound eventsSearchRound showInviteFriends mr4"
                        href="javascript:void(0)">
                        <span class="lrc"></span>
                        <span class="mrc">
                            <span class="fl fs11"><strong><?php echo $this->__('Select friends'); ?></strong></span>
                        </span>
                        <span class="rrc"></span>
                    </a>
                </div>
            </div>
            <div class="mt5">
                <div class="">
                    <input type="checkbox" class="cp" id="isPublic" name="isPublic" value="1" checked>
                    <label for="isPublic"><?php echo $this->__('Make the event public'); ?></label>
                </div>
            </div>
            <div class="mt5">
                <div class="">
                    <input type="checkbox" class="cp" id="isUserInvited" name="isUserInvited" value="1">
                    <label for="isUserInvited"><?php echo $this->__('Let invited people invite more people'); ?></label>
                </div>
            </div>
        </div>
        <div class="eventCreateRoundedBottom"></div>
    </div>

    <div class="eventCreate inviteFriends clearfix dnn mt10">
        <div class="eventCreateRoundedTop"></div>
        <div class="eventCreateRoundedMiddle pl5">
            <div class="profileEditTitle clearfix pl2">
                <h3><?php echo $this->__('Invite friend'); ?></h3>
            </div>
            <?php echo $this->renderBlock('events/common/inviteFriends', array('friends' => $friends->list)); //'total' => $total ?>
        </div>
        <div class="eventCreateRoundedBottom"></div>
    </div>

    <a href="javascript:void(0);" class="buttonRRound eventsCreateBig fr mt5 formSubmitEvent" onclick="document.getElementById('F_eventCreateForm').submit();">
        <span class="lrc"></span>
        <span class="mrc w100px tac">
            <span class="fs11"><strong><?php echo $this->__('Create event'); ?></strong></span>
        </span>
        <span class="rrc"></span>
    </a>
</form>

<script type="text/javascript">loadCheckboxes(); loadDropdowns();</script>
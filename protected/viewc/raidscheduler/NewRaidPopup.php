<section id="RSnewRaidPopupWindow" class="RSpopupWindows">
    <button id="RSnewRaidWinClose" class="RSpopupCloseButtons"></button>

    <div id="RSnewRaidLeftHead">
        <label id="RSnewRaidStartDateLabel"><?php echo $this->__('Date'), " :"; ?><input type="date" class="RSinputControls" id="RSnewRaidStartDate"></label>

        <label for="RSnewRaidRecurring" id="RSnewRaidRecurringLabel"><?php echo $this->__('Recurring'), " :"; ?></label>
        <select id="RSnewRaidRecurring">
            <option value=1 selected><?php echo $this->__('Once'); ?></option>
            <option value=2><?php echo $this->__('Daily'); ?></option>
            <option value=3><?php echo $this->__('Weekly'); ?></option>
            <option value=4><?php echo $this->__('Monthly'); ?></option>
        </select>
    </div>

    <div id="RSnewRaidRightHead">
        <label for="RSnewRaidLoadPreset" id="RSnewRaidPresetLabel"><?php echo $this->__('Load preset'), " :"; ?></label>
        <select id="RSnewRaidLoadPreset"></select>

        <label id="RSnewRaidGameLabel" for="RSnewRaidGame"><?php echo $this->__('Game'), " :"; ?></label>
        <select id="RSnewRaidGame" required></select>
    </div>

    <fieldset class="RSpopupBackgroundPic" id="RSnewRaidPopupBox">
        <label><?php echo $this->__('Location'), " :"; ?><input type="text" placeholder="<?php echo $this->__('Write Location here'), "..."; ?>" maxlength=255 class="RSinputControls" id="RSnewRaidLocation" required></label>
        <label for="RSnewRaidServer" id="RSnewRaidServerLabel"><?php echo $this->__('Server'), " :"; ?></label>
        <select id="RSnewRaidServer" required></select>

        <span id="RSnewRaidRoles">
            <?php echo $this->__('Roles'), " :"; ?>
            <label>none1<input type="tel" min=0 max=100 name="RSnewRaidRole1" class="RSinputControls" id="RSnewRaidRole1" data-idnum="0"></label>
            <label>none2<input type="tel" min=0 max=100 name="RSnewRaidRole2" class="RSinputControls" id="RSnewRaidRole2" data-idnum="0"></label>
            <label>none3<input type="tel" min=0 max=100 name="RSnewRaidRole3" class="RSinputControls" id="RSnewRaidRole3" data-idnum="0"></label>
            <label>none4<input type="tel" min=0 max=100 name="RSnewRaidRole4" class="RSinputControls" id="RSnewRaidRole4" data-idnum="0"></label>
            <label>none5<input type="tel" min=0 max=100 name="RSnewRaidRole5" class="RSinputControls" id="RSnewRaidRole5" data-idnum="0"></label>
            <img src="<?php echo MainHelper::site_url('global/css/img/raidscheduler/equal_icon.png'); ?>">
            <input type="text" max=300 pattern="^[1-9]{1}[0-9]{0,2}$" readonly class="RSinputControls" id="RSnewRaidRoleSum">
        </span>

        <div id="RSnewRaidTimesBox">
            <label id="RSnewRaidStartTimeLabel"><?php echo $this->__('Start time'), " :"; ?><input type="time" value="20:00" class="RSinputControls" id="RSnewRaidStartTime" required></label>
            <label for="RSnewRaidFinalize" id="RSnewRaidFinalizeLabel"><?php echo $this->__('Finalize'), " :"; ?></label>
            <select id="RSnewRaidFinalize">
                <option value=1 selected><?php echo $this->__('30 min before'); ?></option>
                <option value=2><?php echo $this->__('One hour before'); ?></option>
                <option value=3><?php echo $this->__('One day before'); ?></option>
            </select>

            <label id="RSnewRaidEndTimeLabel"><?php echo $this->__('End time'), " :"; ?><input type="time" value="23:00" class="RSinputControls" id="RSnewRaidEndTime" required></label>
            <label for="RSnewRaidRemind" id="RSnewRaidRemindLabel"><?php echo $this->__('Reminder'), " :"; ?></label>
            <select id="RSnewRaidRemind">
                <option value=1 selected><?php echo $this->__('30 min before'); ?></option>
                <option value=2><?php echo $this->__('One hour before'); ?></option>
                <option value=3><?php echo $this->__('One day before'); ?></option>
            </select>
        </div>

        <label id="RSnewRaidDescriptionLabel"><?php echo $this->__('Description'), " :"; ?><textarea placeholder="<?php echo $this->__('Enter decription here'), "..."; ?>" maxlength=255 class="RStextAreaControls" id="RSnewRaidDescription" required></textarea></label>

        <span id="RSnewRaidInvitationsLabel"><?php echo $this->__('Invitations'), " :"; ?></span>
        <span id="RSnewRaidInviteButtons">
            <input type="radio" id="RSnewRaidInviteOpenBut" name="RSinvitationButtons" value=1>
                <label for="RSnewRaidInviteOpenBut" class="RSbuttons"><?php echo $this->__('Open'); ?></label>
            <?php if(isset($group)): ?>
                <input type="radio" id="RSnewRaidInviteMemberBut" name="RSinvitationButtons" value=2>
                    <label for="RSnewRaidInviteMemberBut" class="RSbuttons"><?php echo $this->__('Members'); ?></label>
            <?php elseif(!isset($group)): ?>
                <input type="radio" id="RSnewRaidInviteGroupBut" name="RSinvitationButtons" value=3>
                    <label for="RSnewRaidInviteGroupBut" class="RSbuttons"><?php echo $this->__('Groups'); ?></label>
                <input type="radio" id="RSnewRaidInviteFriendBut" name="RSinvitationButtons" value=4>
                    <label for="RSnewRaidInviteFriendBut" class="RSbuttons"><?php echo $this->__('Friends'); ?></label>
                <input type="radio" id="RSnewRaidInviteMixBut" name="RSinvitationButtons" value=5>
                    <label for="RSnewRaidInviteMixBut" class="RSbuttons"><?php echo $this->__('Mixed'); ?></label>
            <?php endif; ?>
        </span>

        <article id="RSnewRaidInvitePopup" class="RSpopupBackgrounds">
            <section id="RSnewRaidInviteListWin" class="RSpopupWindows">
                <button id="RSnewRaidInviteListWinClose" class="RSpopupCloseButtons"></button>
                <h2><?php echo $this->__('Choose Invitees'); ?></h2>
                <div id="RSnewRaidInviteListCont">
                    <ul id="RSnewRaidInviteList"></ul>
                </div>
                <button class="RSbuttons" id="RSnewRaidInviteListWinDoneBut"><?php echo $this->__('Done'); ?></button>
            </section>
        </article>
    </fieldset>

    <button class="RSbuttons" id="RSnewRaidSavePresetBut"><?php echo $this->__('Save as preset'); ?></button>
    <button class="RSbuttons" id="RSnewRaidCreateRaidBut"><?php echo $this->__('Create raid'); ?></button>

</section>
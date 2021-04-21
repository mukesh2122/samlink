<section id="RSinfoRaidPopupWindow" class="RSpopupWindows RSpopupBackgroundPic">
    <button id="RSinfoRaidWinClose" class="RSpopupCloseButtons"></button>
    <header>
        <div id="RSinfoHeaderTitleBox">
            <span id="RSinfoHeadImg"></span>
            <h3 id="RSinfoHeadGame"></h3>
            <h2><?php echo $this->__('Raid at'), " "; ?><span id="RSinfoHeadLocation"></span> (<span id="RSinfoHeadSize"></span><?php echo " ", $this->__('man'); ?>)</h2>
        </div>
        <div id="RSinfoRaidHeaderTimeBox">
            <div id="RSinfoHeadDateBox"><?php echo $this->__('Date'), ": "; ?><input readonly="readonly" required="required" type="date" class="RSinfoHeaderText RSinputControls" id="RSinfoHeadDate"></div>
            <div id="RSinfoHeadStartBox"><?php echo $this->__('Start Time'), ": "; ?><input readonly="readonly" required="required" type="time" class="RSinfoHeaderText RSinputControls" id="RSinfoHeadStart"></div>
            <div id="RSinfoHeadEndBox"><?php echo $this->__('End Time'), ": "; ?><input readonly="readonly" required="required" type="time" class="RSinfoHeaderText RSinputControls" id="RSinfoHeadEnd"></div>
            <div id="RSinfoHeadOwnerBox"><?php echo $this->__('Creator'), ": "; ?><span class="RSinfoHeaderText" id="RSinfoHeadOwner"></span></div>
        </div>
        <textarea id="RSinfoRaidHeaderDescription" maxlength=255 class="RStextAreaControls" readonly="readonly" required="required"></textarea>
    </header>

    <?php if((($menu_selection === 'groups') && $group->isMember()) || (($menu_selection === 'events') || ($menu_selection === 'players'))): ?>
        <button class="RSbuttons" id="RSinfoRaidUpdateButDiscard"><?php echo $this->__('Discard Changes'); ?></button>
        <input type="checkbox" id="RSinfoRaidUpdateBut">
        <label for="RSinfoRaidUpdateBut" class="RSbuttons" id="RSinfoRaidUpdateButChange"><?php echo $this->__('Change Raid'); ?></label>
        <label for="RSinfoRaidUpdateBut" class="RSbuttons" id="RSinfoRaidUpdateButSave"><?php echo $this->__('Save Changes'); ?></label>
    <?php endif; ?>

    <article id="RSinfoRaidTabs">
        <div>
            <input type="radio" id="RSinfoRaidTabSignupBut" name="SomeRandomGroupName" checked="checked">
            <label for="RSinfoRaidTabSignupBut"><?php echo $this->__('Signups'); ?></label>
            <section id="RSinfoRaidTabSignupContent"><?php echo $this->__('No one signed up yet'); ?>...</section>
        </div>
        <div>
            <input type="radio" id="RSinfoRaidTabStatusBut" name="SomeRandomGroupName">
            <label for="RSinfoRaidTabStatusBut"><?php echo $this->__('Status'); ?></label>
            <section id="RSinfoRaidTabStatusContent"></section>
        </div>
        <div>
            <input type="radio" id="RSinfoRaidTabFinalizeBut" name="SomeRandomGroupName">
            <label for="RSinfoRaidTabFinalizeBut"><?php echo $this->__('Final Setup'); ?></label>
            <section id="RSinfoRaidTabFinalizeContent"><?php echo $this->__('Not finalized yet'); ?>...</section>
        </div>
        <div>
            <input type="radio" id="RSinfoRaidTabCommentsBut" name="SomeRandomGroupName">
            <label for="RSinfoRaidTabCommentsBut"><?php echo $this->__('Comments'); ?></label>
            <section id="RSinfoRaidTabCommentsContent">
                <ul id="RSinfoRaidTabCommentsList"></ul>
                <input type="text" maxlength="255" placeholder="<?php echo $this->__('I just want to say'), "....."; ?>" id="RSinfoRaidTabCommentsInput" class="RSinputControls">
                <?php if($menu_selection === 'groups'):
                    if($group->isMember()): ?>
                        <button id="RSinfoRaidTabCommentsSendBut" class="RSbuttons"><?php echo $this->__('Send'); ?></button>
                    <?php endif;
                elseif(($menu_selection === 'events') || ($menu_selection === 'players')): ?>
                    <button id="RSinfoRaidTabCommentsSendBut" class="RSbuttons"><?php echo $this->__('Send'); ?></button>
                <?php endif; ?>
            </section>
        </div>
    </article>

    <?php if($menu_selection === 'groups'):
        if($group->isMember()): ?>
            <button id="RSinfoRaidDeleteBut" class="RSbuttons"><?php echo $this->__('Delete Raid'); ?></button>
            <button id="RSinfoRaidFinalBut" class="RSbuttons"><?php echo $this->__('Finalize'); ?></button>
            <button id="RSinfoRaidSignupBut" class="RSbuttons"><?php echo $this->__('Sign me up!'); ?></button>
        <?php endif;
    elseif(($menu_selection === 'events') || ($menu_selection === 'players')): ?>
        <button id="RSinfoRaidDeleteBut" class="RSbuttons"><?php echo $this->__('Delete Raid'); ?></button>
        <button id="RSinfoRaidFinalBut" class="RSbuttons"><?php echo $this->__('Finalize'); ?></button>
        <button id="RSinfoRaidSignupBut" class="RSbuttons"><?php echo $this->__('Sign me up!'); ?></button>
    <?php endif; ?>
</section>
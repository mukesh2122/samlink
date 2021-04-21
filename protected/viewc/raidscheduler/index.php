<?php
if($menu_selection === 'events') {
    include('protected/viewc/events/common/top.php');
    include("event_tabs.php");
} elseif($menu_selection === 'groups') { include('protected/viewc/groups/common/top.php'); };
include("TopScript.php");
?>

<article id="RaidScheduler">
    <header>
        <h1 id="RStitle"><?php echo $pagetitle, " ", $this->__('raids'); ?>.</h1>
        <div id="RSviewbutweek"><?php echo $this->__('Week'); ?></div>
        <div id="RSviewbut">
            <label id="RSweekmonbutlabel" for="eRSweekmonbut"><?php echo $this->__('Display as'), " :"; ?></label>
            <select name="eRSweekmonbut" id="RSweekmonbut">
                <option value=1><?php echo $this->__('Week'); ?></option>
                <option value=2><?php echo $this->__('Month'); ?></option>
            </select>
        </div>
        <div id="RSviewbutmon"><?php echo $this->__('Month'); ?></div>
    </header>

    <section id="RSmonCal">
        <header class="RSheader">
            <span id="RSprevMonth"></span>
            <span id="RScurMonth" class="RSheaderTxt"></span>
            <span id="RSnextMonth"></span>
            <?php if($menu_selection === 'groups'):
                if($group->isMember()):
                    if($group->isCreator() || $group->isOfficer() || $group->isAdmin()): ?>
                        <button id="RSmonNewRaidBut" class="RSbuttons"><?php echo $this->__('New Raid'); ?></button>
                    <?php endif;
                endif;
            elseif(($menu_selection === 'events') || ($menu_selection === 'players')): ?>
                <button id="RSmonNewRaidBut" class="RSbuttons"><?php echo $this->__('New Raid'); ?></button>
            <?php endif; ?>
        </header>

        <article id="RSmonCalSection">
            <ol id="RSmonDays">
                <li><?php echo $this->__('Mon'); ?></li>
                <li><?php echo $this->__('Tue'); ?></li>
                <li><?php echo $this->__('Wed'); ?></li>
                <li><?php echo $this->__('Thu'); ?></li>
                <li><?php echo $this->__('Fri'); ?></li>
                <li><?php echo $this->__('Sat'); ?></li>
                <li><?php echo $this->__('Sun'); ?></li>
            </ol>
            <ol id="RSmoncalendar"></ol>
        </article>
    </section>

    <section id="RSweekCal">
        <header class="RSheader">
            <span id="RSprevWeek"></span>
            <span id="RSweekNumTxt" class="RSheaderTxt"><?php echo $this->__('Week'), " "; ?><span id="RSweekNum"></span></span>
            <span id="RSnextWeek"></span>
            <?php if(Auth::isUserLogged()):
                if($menu_selection === 'groups'):
                    if($group->isMember()):
                        if($group->isCreator() || $group->isOfficer() || $group->isAdmin()): ?>
                            <button id="RSweekNewRaidBut" class="RSbuttons"><?php echo $this->__('New Raid'); ?></button>
                        <?php endif;
                    endif;
                elseif(($menu_selection === 'events') || ($menu_selection === 'players')): ?>
                    <button id="RSweekNewRaidBut" class="RSbuttons"><?php echo $this->__('New Raid'); ?></button>
                <?php endif;
            endif; ?>
        </header>

        <article id="RSweekCalDays">
            <section id="RSweekCalDay1">
                <span id="RSweekCalDay1ScrollUp"></span>
                <span id="RSweekCalDay1ScrollDown"></span>
                <h3 id="RSweekCalDay1Txt"><?php echo $this->__('Monday'); ?></h3>
            </section>
            <section id="RSweekCalDay2">
                <span id="RSweekCalDay2ScrollUp"></span>
                <span id="RSweekCalDay2ScrollDown"></span>
                <h3 id="RSweekCalDay2Txt"><?php echo $this->__('Tuesday'); ?></h3>
            </section>
            <section id="RSweekCalDay3">
                <span id="RSweekCalDay3ScrollUp"></span>
                <span id="RSweekCalDay3ScrollDown"></span>
                <h3 id="RSweekCalDay3Txt"><?php echo $this->__('Wednesday'); ?></h3>
            </section>
            <section id="RSweekCalDay4">
                <span id="RSweekCalDay4ScrollUp"></span>
                <span id="RSweekCalDay4ScrollDown"></span>
                <h3 id="RSweekCalDay4Txt"><?php echo $this->__('Thursday'); ?></h3>
            </section>
            <section id="RSweekCalDay5">
                <span id="RSweekCalDay5ScrollUp"></span>
                <span id="RSweekCalDay5ScrollDown"></span>
                <h3 id="RSweekCalDay5Txt"><?php echo $this->__('Friday'); ?></h3>
            </section>
            <section id="RSweekCalDay6">
                <span id="RSweekCalDay6ScrollUp"></span>
                <span id="RSweekCalDay6ScrollDown"></span>
                <h3 id="RSweekCalDay6Txt"><?php echo $this->__('Saturday'); ?></h3>
            </section>
            <section id="RSweekCalDay0">
                <span id="RSweekCalDay0ScrollUp"></span>
                <span id="RSweekCalDay0ScrollDown"></span>
                <h3 id="RSweekCalDay0Txt"><?php echo $this->__('Sunday'); ?></h3>
            </section>
        </article>
    </section>

    <article id="RShoverPopup">
        <div id="RShoverPopupWin">
            <div><?php echo $this->__('Game'), ": "; ?><span id="RShoverGame" class="RShoverText"></span></div>
            <div><?php echo $this->__('Server'), ": "; ?><span id="RShoverServer" class="RShoverText"></span></div>
            <div><?php echo $this->__('Location'), ": "; ?><span id="RShoverLocation" class="RShoverText"></span></div>
            <div><?php echo $this->__('Time'), ": "; ?><span id="RShoverStartTime" class="RShoverText"></span><?php echo "  ", $this->__('to'), "  "; ?><span id="RShoverEndTime" class="RShoverText"></span><div id="RShoverRightAlign"><?php echo "       ", $this->__('Size'), ": "; ?><span id="RShoverSize" class="RShoverText"></span></div></div>
            <div id="RShoverDescBox"><?php echo $this->__('Description'), ": "; ?><span id="RShoverDescription"></span></div>
        </div>
    </article>

    <article id="RShoverPlayer">
        <div id="RShoverPlayerWin"></div>
    </article>

    <article id="RSnewRaidPopup" class="RSpopupBackgrounds">
        <?php include_once("NewRaidPopup.php"); ?>
    </article>

    <article id="RSinfoRaidPopup" class="RSpopupBackgrounds">
        <?php include_once("RaidInfoPopup.php"); ?>
    </article>
</article>
<?php include("TopScript.php"); ?>
<article id="RSsignupPage">
    <header>
        <h1 id="RSsignupHeadTitleGame"><?php echo $RaidVals["GameName"]; ?></h1>
        <h2 id="RSsignupHeadTitleLocation"><?php echo $this->__("Raid at"), " ", $RaidVals["Location"], " (", $RaidVals["Size"], " ", $this->__('man'); ?>)</h2>

        <div id="RSsignupHeadImg"><?php echo $RaidVals["GameImg"]; ?></div>
        <div id="RSsignupHeadTimebox">
            <div><?php echo $this->__('Date'), ": "; ?><span id="RSsignupHeadTimeDate"><?php echo $RaidVals["Date"]; ?></span></div>
            <div><?php echo $this->__('Start Time'), ": "; ?><span id="RSsignupHeadTimeStart"><?php echo $RaidVals["StartTime"]; ?></span></div>
            <div><?php echo $this->__('End Time'), ": "; ?><span id="RSsignupHeadTimeEnd"><?php echo $RaidVals["EndTime"]; ?></span></div>
            <div><?php echo $this->__('Creator'), ": "; ?><span id="RSsignupHeadTimeOwner"><?php echo $RaidVals["Owner"]; ?></span></div>
        </div>
        <fieldset id="RSsignupHeadDesc"><?php echo $RaidVals["Desc"]; ?></fieldset>
    </header>

    <section id="RSsignupInputBox">
        <div><label><?php echo $this->__("Sign up with character"), " : "; ?><input id="RSsignupCharacter" class="RSinputControls" type="text" placeholder="<?php echo $this->__("My best assassin"); ?>"></label></div>

        <div><label><?php echo $this->__("Sign up as role"), " : "; ?><select id="RSsignupRole" class="RSselectControls"><?php echo $RaidVals["Roles"]; ?></select></label></div>

        <div id="RSsignupStatusBox">
            <?php echo $this->__("Status"), " : "; ?>
            <label><?php echo $this->__("Attend"); ?><input type="radio" name="RSsignupInviteStatus" <?php echo ($RaidVals["Status"] === "accepted") ? "checked" : ""; ?> value=1></label>
            <label><?php echo $this->__("Maybe"); ?><input type="radio" name="RSsignupInviteStatus" <?php echo ($RaidVals["Status"] === "waiting") ? "checked" : ""; ?> value=2></label>
            <label><?php echo $this->__("Decline"); ?><input type="radio" name="RSsignupInviteStatus" <?php echo ($RaidVals["Status"] === "rejected") ? "checked" : ""; ?> value=3></label>
        </div>

        <textarea id="RSsignupComment" class="RStextAreaControls" placeholder="<?php echo $this->__("Comment to raid"); ?>"></textarea>
    </section>

    <button class="RSbuttons" id="RSsignupDoneBut"><?php echo $this->__("Done"); ?></button>
</article>
<?php
if (is_file("protected/class/Browscap.php")) {
	require_once("protected/class/Browscap.php");
}
use phpbrowscap\Browscap;
$browser = new phpbrowscap\Browscap('protected/class/');
$result = $browser->getBrowser();
$reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser');

$userPlayer = User::getUser();
$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;

$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);


if($firstMsgID  AND $isMember AND $user->ID_PLAYER == $threadStarter or $model->isForumAdmin() OR $model->isForumMod() or $model->isBoardMod($type, $id, $board_id, $user->ID_PLAYER) ){
?>
    <div class="clearfix">
            <span class="fs22 fft fclg2 fl mr10"><h2 class="fcb"><?php echo $this->__('Edit poll'); ?></h2></span>
        </div>

    	<div class="clearfix mt10 ">
    		<div class="postContainer mt10 pb10 pt10">
    	        <div class="fl postBody">
                	<form method="POST" id="editPoll" class="forumForm" action="#">
                        <div>
    	                    <input type="hidden" name="type" value="<?php echo $type; ?>" />
    	                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    	                    <input type="hidden" name="board_id" value="<?php echo $board_id ?>" />
    	                    <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>" />
    	                    <input type="hidden" name="msg_id"  value="<?php echo $firstMsgID; ?>" />
    	                    <input type="hidden" name="poll_id" value="<?php echo $poll_id; ?>" />
    	                </div>
    										
    					<div class="mt5">
                            <label for="topicSubject2" class="cp"><?php echo $this->__('Short question or subject');?></label>
                            <div class="rifL sprite_3 fl"></div>
                           	<div class="rifM fl">
                                    <input type="text" id="topicSubjectpoll" class=" borderframe mb20 w470" name="topicSubjectpoll"  maxlength="34" title="<?php echo $this->__('Type you polls question here...'); ?>" value="<?php echo $subject; ?>" />
                            </div>
                            <div class="rifR sprite_3 fl"></div>
                        </div>
                        <div> <?php echo $this->__('- the question have a max on 34 characters, if longer, type a subject first and then the question below.'); ?> 
                            <br>
                            <?php echo $this->__('- you can one field or both fields.'); ?> 
                        </div>
                        <p class="clearfix">
                            <div>
                                <div class="textMid">
                                    <textarea id="newPostTextPoll" class="elasticTextA inputTextArea mb20 w470" title="<?php echo $this->__('- if your question is long? type it here, or you can type more info/staments for the question '); ?>" name="body"> <?php echo $body; ?> </textarea> 
                                </div>
                            </div>
                        </p>
                        
                      
                        <p class="clearfix">
                            <div>                                
                                <div class="textMid">
                                    <?php echo $this->__('if you still want the same, expire date and time - dont change any thing. you can date or time, or both.'); ?>
                                </div>
                                <div class="textMid mt5">
                                    <?php echo $this->__('Expires: ');?>
                                </div>
                                <div>
                                    <?php echo $this->__('Select a date '); ?>
                                        <?php if ($result->Browser == "Chrome" || $result->Browser == "Opera") { ?>
                                            <input type="date" id="enddate" class="wAuto ml5" name="enddate" value="<?php echo date('Y-m-d', $expiretime); ?>" min="<?php echo date('Y-m-d'); ?>" />
                                        <?php
                                        } else {
                                        ?>
                                            <script>$(function() { $("#datepicker").datepicker({dateFormat: 'dd-mm-yy', minDate: 0, altField: "#enddate", altFormat: "yy-mm-dd"});});</script>
                                            <input type="text" class="wAuto ml5" id="datepicker" name="datepicker" onfocus="if(this.value=='dd-mm-yyyy') this.value = ''" onblur="if(this.value=='') this.value = 'dd-mm-yyyy'" value="<?php echo date('d-m-Y', $expiretime); ?>">
                                            <input type="hidden" id="enddate" name="enddate" value="<?php echo date('Y-m-d', $expiretime); ?>">
                                            <?php echo $this->__('ex. 14-08-2014'); ?>
                                        <?php } ?> 
                                    <br>
                                    <?php echo $this->__('Select a time(hour) '); ?> 

                                    <input type="time" id="hour" class="mt10 ml 5wAuto" name="hour" value="<?php echo date('H:i', $expiretime); ?>" >

                                </div>
                            </div>
                        </p>

                        <p class="clearfix">
                            <div>
                                <div id="PollCon">
                                    <div class="textMid">
                                    <?php echo $this->__('if you spelled something wrong, correct it. - Otherwise you remove one or more answer options and / or add new answer options'); ?>
                                </div>
                                    <?php
                                            $this->__('Answer options:');
                                    foreach ($Poll_choices as $poll) {
                                    ?>
                                            <div class="textMid ">
                                            	<input type="text" name="options[<?php echo $poll->ID_CHOICE; ?>]"  class="mt10 w300" value="<?php echo $poll->Label; ?>"  />
     											<a  href="<?php echo MainHelper::site_url('forum/'.$type.'/'.$url.'/'.$board_id.'/'. $topic_id.'/'.$poll_id.'/deletepollchoice/'.$poll->ID_CHOICE); ?>">
     												 <input type="button" name="delete_choice" class="" id="delete_choice" value="<?php echo $this->__('Delete'); ?>" />
     											</a>                                 
                                            </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="textMid">
                                        <input type="button" name="addinput_edit" class="mt10 w300" id="addinput_edit" value="<?php echo $this->__('Add an option'); ?>" />
                                </div>
                            </div>
                        </p>

    					<span class="lrc"></span>
                        <span class="mrc"> <input type="submit" name="updatePoll_yes"  value="<?php echo $this->__('Update'); ?>" </span>
                                                   
                        <a  href="<?php echo MainHelper::site_url('forum/'.$type.'/'.$url.'/'.$board_id.'/'. $topic_id.'/'.$poll_id); ?>">
                         <span class="mrc"> <input type="button" name="updatePoll_no"  value="<?php echo $this->__('Cancel'); ?>" </span>
                        </a>
                        <span class="rrc"></span>
                    
                    </form>
                    <div class="clearfix"></div>
    			</div>
    		</div>
    	</div>

   
<?php 
} ?>


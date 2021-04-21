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

include('top.php');

if(isset($infoBox)) { echo $infoBox; };
if(isset($crumb)) {
	echo '<div class="clearfix">', $this->renderBlock('common/breadcrumb', array('crumb' => $crumb)), '</div>';
};
?>

<div class="clearfix mt10 ">
	<div class="clearfix pb10 polldescription">
		<?php $player = User::getUser(); ?>
		<div class="postContainer dot_top_dark mt10 pb10 pt10">
			<div class="userHalf fl">
				<div class="w100px pr5 fl pr game_img">
					<a href="<?php echo MainHelper::site_url('player/'.$player->URL); ?>"><?php echo MainHelper::showImage($player, THUMB_LIST_100x100, false, array('no_img' => 'noimage/no_player_100x100.png')); ?></a>
					<div class="company_user_rating game100 pa clearfix b0 l0">
						<?php echo str_repeat("<span class='star_blue'></span>", round($player->SocialRating, 0));?><?php echo str_repeat("<span class='star_grey'></span>", (5 - round($player->SocialRating, 0))); ?><span class="fr fft db fs11 fcblue"><?php echo number_format($player->SocialRating, 1);?></span>
					</div>
				</div>
				<div class="mt5 fs11 fclg">
					<a href="<?php echo MainHelper::site_url('player/'.$player->URL) ?>"><?php echo PlayerHelper::showName($player); ?></a>
				</div>
			</div>
			<div class="fl postBody">
				<div id="createForm" class="replyForm pt5">
					<form method="POST" id="createForumTopicPoll" class="forumForm" action="<?php echo MainHelper::site_url('forum-create/poll/'.$board->OwnerType.'/'.$url.'/'.$board->ID_BOARD); ?>">
						<h2 class="fcb"><?php echo $this->__('Create new poll'); ?></h2>
						<div class="mt5 w98procent">
							<label for="topicSubject2" class="cp"><?php echo $this->__('Short question or subject');?></label>
							
							<div class="roundedInputField  clearfix">
								<div class="rifL sprite_3 fl"></div>
								<div class="rifM fl w98procent">
                                    <input type="text" id="topicSubject2" class="input_text w98procent " name="topicName" maxlength="34" title="<?php echo $this->__('Type you polls question here...'); ?>" value="">
								</div>
							</div>
						</div>
						<div> <?php echo $this->__('- the question have a max on 34 characters, if longer, type a subject first and then the question below.'); ?> </div>
                        <div class="clearfix">
                            <div class="textMid">
                                <textarea id="newPostTextPoll" class="elasticTextA inputTextArea w98procent" title="<?php echo $this->__('- if your question is long? type it here, or you can type more info/staments for the question '); ?>" name="messageText"></textarea>
                            </div>
                        </div>
						<div class="mt20">
							<?php echo $this->__('Poll ends'), ' : '; ?>
							<br>
							<br>
							<?php echo $this->__('Select date and time for when the poll should end.'); ?>         
							<br>
							<div>
							<?php echo $this->__('Select a date '), ':'; ?> 
                            <?php if ($result->Browser == "Chrome" || $result->Browser == "Opera") { ?>
							 	<input type="date" id="enddate" class="wAuto ml5" name="enddate" value="" min="<?php echo date('Y-m-d'); ?>" />
                            <?php
							} else {
							?>
                            	<script>$(function() { $("#datepicker").datepicker({dateFormat: 'dd-mm-yy', minDate: 0, altField: "#enddate", altFormat: "yy-mm-dd"});});</script>
							 	<input type="text" class="wAuto ml5" id="datepicker" name="datepicker" onfocus="if(this.value=='dd-mm-yyyy') this.value = ''" onblur="if(this.value=='') this.value = 'dd-mm-yyyy'" value="dd-mm-yyyy">
							 	<input type="hidden" id="enddate" name="enddate" value="">
								<?php echo $this->__('ex. 14-08-2014'); ?>
                            <?php } ?> 
							</div>
							<br>
							<div>						 
								<?php echo $this->__('Select a time(hour) '); ?> 
								<input type="time" id="hour" class="wAuto mt10 ml5" name="hour">
							</div>
						</div>
                        <div class="clearfix mt20">
                            <div id="pollcontainer">
                                <?php
                                $defaultAnswerTxt = $this->__('type an answer option here');
                                $answer_option_default = 4;
                                echo $this->__('Answer options:');
                                echo '<br>'. $this->__('you should at least type 2 answer options, if you need more then 4, just an exstra by click the button below. You can have up to 15.');

                                for($i = 1; $i <= $answer_option_default; $i++): ?>
                                    <div class="textMid">
                                        <input type="text" name="options[]" class="mt10 w300" title="<?php echo $defaultAnswerTxt; ?>">
                                    </div>
                                <?php endfor; ?>
                            </div>
                            <div class="textMid">
                                <input type="button" name="add_input" class="mt10 w300" id="add_input" value="Add an option"> 
                            </div>
                            <div class="sprite_3 textBotCorn"></div>
                        </div>
						<a href="javascript:void(0);" class="roundedButton grey fr formSubmitUniversal">
							<span class="lrc"></span>
							<span class="mrc"><?php echo $this->__('Create poll'); ?></span>
							<span class="rrc"></span>
						</a>
						<input type="submit" class="dn hiddenSubmitButton">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
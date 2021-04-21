<?php
    error_reporting(E_ALL ^ E_NOTICE);
    $isEnabledTranslate = MainHelper::IsModuleEnabledByTag('translations'); 
	include_once(Doo::conf()->SITE_PATH . 'global/js/recruitment.js.php');// catia
?>
<script>
//$(document).ready(function(){
//	
// $( "#blockcomments" ).hide();
// $( "#linkhidedescription" ).hide();
//  $("#linkshowdescription").click(function(){
//  $( ".show_hide" ).hide();
//    $( "#blockcomments" ).slideDown( "slow" );
//	$("#linkshowdescription" ).hide();
//	$( "#linkhidedescription" ).show();
//  
//});
//
// $(document).on('click', '.closedescr', function(){
//        $(this).parent().slideUp("slow");
//		$( ".show_hide" ).hide();
//		$( "#blockcomments" ).slideUp("slow");
//		$( "#linkhidedescription" ).hide();
//		$("#linkshowdescription" ).show();
//    });
//
//
//
// }); 

</script>

<div id="welcomeBanner">
    <div id="imgBanner"></div>
    <div id="blockcomments" name="blockcomments" >
		<span id="">
		<h2><?php echo $this->__("Welcome to PlayNation's recruitment page!"); ?></h2>
 
		<p><?php echo $this->__("This where you can find people to play your favourite games with.<br/> 
It functions much like a job database. You create a gamer's equivalent of a "."'"."job posting"."'"." for a specific game and tell a little bit about yourself such as what roles, factions, weapons or strategies you prefer.
Other players and groups, guilds and clans can then easily find your posting and contact you.<br/>
Alternatively you can represent your gaming group, guild or clan and create a "."'"."job posting"."'"." for specific player you are missing on your team.
Why not get started and find new friends who enjoy the same games as you?<br/>
View the existing postings, or if you don't find what you are looking for - create your own!"); ?></p>
		</span></div>
    
    <div id="imgDescription">
            <span id="linkshowdescription">
		<a href="#" class="btn_add">                    
                    <?php echo $this->__('Description'); ?>
                    <img src="../../../global/img/RecruitmentWelcome/descriptionClosed.png">
                </a>
            </span>
        
            <span id="linkhidedescription">
		<a href="#" class="closedescr">
                    <?php echo $this->__('Description'); ?>
                    <img src="../../../global/img/RecruitmentWelcome/descriptionOpen.png"></a>
            </span>
	</div>
</div>


<form id="rcForm" action="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_RESPOND_NOTICES.'/save_response'); ?>" method="post" class="bbq">
<script>
$(document).ready(function(){
	
 $( "#blockcommentsposts" ).hide();
 $( "#linkhidecomments" ).hide();
  $("#linkshowcomments").click(function(){
  $( ".show_hide" ).hide();
    $( "#blockcommentsposts" ).slideDown( "slow" );
	$("#linkshowcomments" ).hide();
	$( "#linkhidecomments" ).show();
  
});

 $(document).on('click', '.close', function(){
        $(this).parent().slideUp("slow");
		$( ".show_hide" ).hide();
		$( "#blockcommentsposts" ).slideUp("slow");
		$( "#linkhidecomments" ).hide();
		$("#linkshowcomments" ).show();
    });



 }); 

</script>

<div id="backlink">
<a href="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES);?>" class="icon_link"><?php echo $this->__('Back to Recruitment'); ?></a>
</div>

    <input id="nid" type="hidden"  style="border:none;" readonly name="nid" value=<?php echo $nid; ?>>
	 <input id="ownerid" type="hidden" name="ownerid" value=<?php echo $ownerid; ?>>
	 <input id="ownertype" type="hidden" name="ownertype" value="player">
	<?php if(isset($noticeList) and !empty($noticeList)):?>
		<?php foreach ($noticeList as $key=>$item):?>
		
        <div id="topicBG">
		<?php 
			echo MainHelper::showImage($item, THUMB_LIST_18x18, false, array('no_img' => 'noimage/no_game_18x18.png'))."  ".$item->GameName." - ".ucfirst($item->OwnerType).": ".$item->OwnerName; 
		?>
		</div>
        <div id="recruitmentPost">
            <span id="gameAvatar">
				<?php 
					 echo MainHelper::showImage($item, THUMB_LIST_150x200, false, array('no_img' => 'noimage/no_player_150x200.png')); 
				?>
                <span id="imgAvatar"><a href='#'><?php echo $item->OwnerName; ?></a></span>
            </span>
            <span id='gameFrames'>
                <span class='frameInfo'>
                    <span class='frameIcon'><img src='../../../global/img/RecruitmentWelcome/RecruitmentPost/icons/Language.png'></span>
					
                    <span class='frameText'><?php  echo $item->LanguageName;?></span>
                </span>
                <span class='frameInfo'>
                    <span class='frameIcon'><img src='../../../global/img/RecruitmentWelcome/RecruitmentPost/icons/Modes.png'></span>
					
                    <span class='frameText'><?php  echo $item->GameplayModeName;?></span>
                </span>
                <span class='frameInfo'>
                    <span class='frameIcon'><img src='../../../global/img/RecruitmentWelcome/RecruitmentPost/icons/roles.png'></span>
					
                    <span class='frameText'><?php  echo $item->RoleName;?></span>
                </span>
                <span class='frameInfo'>
                    <span class='frameIcon'><img src='../../../global/img/RecruitmentWelcome/RecruitmentPost/icons/region.png'></span>
					
                    <span class='frameText'><?php  echo $item->RegionName;?></span>
                </span>
               <!-- <span class='frameInfo'>
                    <span class='frameIcon'><img src='../global/img/RecruitmentWelcome/Step5/icons/weapon.png'></span>
                    <span class='frameText'>M4A1</span>
                </span>-->
                <span class='frameInfo'>
                    <span class='frameIcon'><img src='../../../global/img/RecruitmentWelcome/RecruitmentPost/icons/server1.png'></span>
					
                    <span class='frameText'><?php  echo $item->ServerName; ?></span>
                </span>
                <span class='frameInfo'>
                    <span class='frameIcon'><img src='../../../global/img/RecruitmentWelcome/RecruitmentPost/icons/LEVELS.png'></span>
					
                    <span class='frameText'><?php  echo $item->GameplayLVLName; ?></span>
                </span>
                <span class='frameInfo'>
                    <span class='frameIcon'><img src='../../../global/img/RecruitmentWelcome/RecruitmentPost/icons/Faction1.png'></span>
					
                    <span class='frameText'><?php  echo $item->FactionName; ?></span>
                </span>
                <span class='frameInfo'>
                    <span class='frameIcon'></span>
                    <span class='frameText'></span>
                </span>
            </span>
            <span id="gameDescriptionText">
            <h3 id="gameDescriptionTitle">Description</h3>
			
			<span>
                            <span class="frameDescription3"><?php echo $item->Details; ?></span>
			  <div class="frameDescription2" id="details1" name="details1"><?php echo $item->Details; ?></div>
			 
			</span>
			
			<span id="linkshowcomments">
			<a href="#" class="btn_add"><?php echo $this->__('Show comments').'('.$totalresponses.')'; ?></a>
			</span>
			<span id="linkhidecomments">
			<a href="#" class="close"><?php echo $this->__('Hide comments').'('.$totalresponses.')'; ?></a>
			</span>
        </div>
		<div id="commentBox">
		<span id='framecomment'>
                    <?php echo "<input id='ResponseDetailsLog' type='text' 
                            name='ResponseDetailsLog'  
                           placeholder='".$this->__('Comment...')."'>";?>
                    </span>
		</div>
         
		<br />
		
		
		<div id="blockcommentsposts" name="blockcommentsposts" >
			<div id="filterHeader">
			<span class="headercomments">
			<h3><?php echo $this->__('Comments'); ?></h3>
			</span>
			</div>
			<div id="filterBg">
			<?php if(isset($listresponses) and !empty($listresponses)):?>
			
				<?php foreach ($listresponses as $key=>$item2):?>
					<div class="filterResult">
						<div class="leftSideFilter">
							
                                                        <?php 
							echo MainHelper::showImage($item, THUMB_LIST_45x50, false, array('no_img' => 'noimage/no_player_45x50.png'))."  ".$item2->ResponseDetailsLog; 
                                                        ?>
                                                        
                                                        <p><?php echo $item2->OwnerName; ?>
							<!-- &nbsp;<?php //echo $this->__(' : '); ?> -->
							
							<?php //echo $item2->ResponseDetailsLog; ?></p>							</p>
<!--							<div style="clear: both; margin-top: 0px;"></div> -->
							
						</div>
<!--                                            <div style="clear: both; margin-top: 0px;"></div> -->
			
						<!--<div class="rightSideFilter"><p><?php //echo $item->ViewCount; ?> <?php //echo $this->__('views:'); ?><br/>
						Posted on: <?php //echo date(DATE_SHORT, $item->CreatedTime);?> </p>
						</div>-->
			
						
					</div>
				<?php endforeach; ?>
			
				<?php if(isset($pager)):?>
					<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)) ?>
				<?php endif; ?>
				</div>
			<?php else: ?>
				<p class="noItemsText"><?php echo $this->__('There are no notices here. Yet!'); ?></p>
				</div>
			<?php endif; ?>
					
			<!--<span></span><input class="rounded_5 navigation_button green" style="float:right" id="next" value="<?php //echo $this->__('Add'); ?>" type="submit" /><br /><hr>-->
	
		<?php endforeach; ?>
	<?php endif; ?>	
</form>


<!-- remember the following end div tag -->
</div>
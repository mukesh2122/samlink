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
// $(document).on('click', '.close', function(){
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
                    <img src="global/img/RecruitmentWelcome/descriptionClosed.png">
                </a>
            </span>
        
            <span id="linkhidedescription">
		<a href="#" class="close">
                    <?php echo $this->__('Description'); ?>
                    <img src="global/img/RecruitmentWelcome/descriptionOpen.png"></a>
            </span>
	</div>
</div>

<div id="top5">
<div class="top5topic">
    <div class="top5topicline"><?php echo $this->__('Top 5 Hightlighted Player'); ?></div>
    
    <div class="top5bg">
        <div class="top5persons">
            <?php if(isset($top5player) and !empty($top5player)):?>
				<?php foreach ($top5player as $key=>$item2):?>
            <div class="top5users">
						<span class="top5personIcon">
							<?php
								echo MainHelper::showImage($item2, THUMB_LIST_18x18, false, array('no_img' => 'noimage/no_game_18x18.png'));
							?>
						</span>
						<span class="top5personName"><?php echo $item2->OwnerName; ?></span>
            </div>
				<?php endforeach; ?>
			<?php endif; ?>
            </div>
            </div>
            </div>

    <div class="top5topic">
    <div class="top5topicline"><?php echo $this->__('Top 5 Hightlighted Group'); ?></div>
    
        <div class="top5bg">
        <div class="top5persons">
			<?php if(isset($top5group) and !empty($top5group)):?>
				<?php foreach ($top5group as $key=>$item3):?>
            <div class="top5users">
						<span class="top5personIcon">
							<?php
								echo MainHelper::showImage($item3, THUMB_LIST_18x18, false, array('no_img' => 'noimage/no_game_18x18.png'));
							?>
						</span>
						<span class="top5personName"><?php echo $item3->OwnerName; ?></span>
            </div>
				<?php endforeach; ?>
			<?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="lineBetween">&nbsp;</div>

<div id="searchRecruitment">
    <div id="searchDescription"><p><?php echo $this->__('Description'); ?></p></div>
    <div id="searchBg">
        <form>
            <span class="radioButton"><input type="radio" value="player" name="type"><p class="radioValue"><?php echo $this->__('Player'); ?></p></span>
            <span class="radioButton"><input type="radio" value="group" name="type"><p class="radioValue"><?php echo $this->__('Group'); ?></p></span>
            <div id="textField"><input type="text" name="typeGame" placeholder="Type game">
            <input type="text" name="typeKeywords" placeholder="Keywords">
            <input type="submit" name="searchBTN" value=""></div>
        </form>
    </div>
   <!-- <div id="advancedSearch"><a href="#"><?php //echo $this->__('Advanced search'); ?><img src="global/img/RecruitmentWelcome/descriptionClosed.png"></a></div>-->
</div>

<div id="recruitmentFilter">
<div id="filterTop">
    <div id="amountsResults"><span class="amountsresults"><?php echo $noticesLimit; ?> out of <?php echo $noticesTotal; ?> results</span></div>
    <div id="createNotice"><a href="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES).'?step=1';?>"><?php echo $this->__('+ Create notice'); ?></a></div>
</div>
    
    <div id="filterHeader">
        <span id="filterType">
            <span <?php if (($type=='player') || ($type=='')) { echo 'id="filterSelector"'; } ?>><a href="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES).'?type=player';?>"><?php echo $this->__('Players'); ?></a></span>
			<span <?php if ($type=='group') { echo 'id="filterSelector"'; } ?>><a href="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES).'?type=group';?>"><?php echo $this->__('Groups'); ?></a></span>
        </span>
        <span <?php if (($order=='1')) { echo 'id="filterOrderby"'; } else {echo 'id="filterOrderbynselect"';} ?>><a href="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES).'?order=1&type='.$type;?>"><?php echo $this->__('Most views')."</a>"; if(($order=="1")) { echo "<span class='filter_img1'>&nbsp;&nbsp;&nbsp;</span>"; } ?></span>
        <span <?php if (($order=='2')) { echo 'id="filterOrderby"'; } else {echo 'id="filterOrderbynselect"';} ?>><a href="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES).'?order=2&type='.$type;?>"><?php echo $this->__('Last posts')."</a>"; if(($order=="2")) { echo "<span class='filter_img1'>&nbsp;&nbsp;&nbsp;</span>"; } ?></span>
        
    </div>
    <div id="filterBg">
		<?php if(isset($noticesList) and !empty($noticesList)):?>

			<?php foreach ($noticesList as $key=>$item):?>
        <div class="filterResult">
            <div class="leftSideFilter">
						<h1 class="leftsidetitle"><?php echo $item->GameName." seeking ".$item->OwnerType; ?></h1>
                                                <p><?php echo $this->__('Type:'); ?><?php echo $item->GameType; ?></p>
            </div>

					<div class="rightSideFilter"><p><?php echo $item->ViewCount; ?> <?php echo $this->__('views'); ?><br/>
					<?php //echo "Posted on: ".date(DATE_SHORT, $item->CreatedTime);?> </p>
            </div>

					<div class="readmoreDescription">

					<a href="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_RESPOND_NOTICES.'/'.$item->ID_NOTICE.'/'.$item->OwnerType); ?>"><?php echo $this->__('Read full description'); ?></a></div>
            </div>
			<?php endforeach; ?>

			<?php if(isset($pager)):?>
				<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)) ?>
<?php endif; ?>

		<?php else: ?>
			<p class="noItemsText"><?php echo $this->__('There are no notices here. Yet!'); ?></p>
	</div>
	<?php endif; ?>

		
					</div> 
					</div> 

			

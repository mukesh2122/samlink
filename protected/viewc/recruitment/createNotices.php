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
 
	//function verify(object) {
//		show_alert = '';
//		//if (document.getElementById('owner').value=='') {
////			show_alert = 'You have to be Login to create a notice ';
////		}
////		if (document.getElementById('game').value=='') {
////			if (show_alert!='') {
////				show_alert+= ' and ou must choose a Game!';
////			} else {
////				show_alert = 'You must choose a Game!';
////			}
////		} else {
////			if (show_alert!='') {
////				show_alert += '!';
////			}
////		}
//		var link_redirect = document.getElementById('link_create').value;
//		if (show_alert!='') {
//			alert(show_alert);
//			
//		} else {
//			document.getElementById("gamedescriptionform").submit(); 
//		}
//	}
//	function submitgamedescription() {
//		document.getElementById("gamedescriptionform").submit();
//	}
//	function submitgamedescriptionprevious() {
//		var link_action =  document.getElementById("link").value + '?step=' + document.getElementById("step").value + '&type=' + document.getElementById("type").value + '&game=' + document.getElementById("game").value + '&details=next&description=next';
//		document.getElementById("gamedescriptionform").action = link_action;
//		document.getElementById("gamedescriptionform").submit();
//	}
//	function submitfinalizeform() {
//		document.getElementById("finalizeform").submit();
//	}
//	function submitfinalizeformprevious() {
//		var link_action =  document.getElementById("link").value + '?step=' + document.getElementById("step").value + '&type=' + document.getElementById("type").value + '&game=' + document.getElementById("game").value + '&details=next&description=next';
//		document.getElementById("finalizeform").action = link_action;
//		document.getElementById("finalizeform").submit();
//	}
//	function submitdetails() {
//		document.getElementById("gamedetailsform").submit();
//	}
//	function submitdetailsprevious() {
//		//MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'?step=4&type='.$type.'&game='.$game.'&details=next');
//		
//		var link_action =  document.getElementById("link").value + '?step=' + document.getElementById("step").value + '&type=' + document.getElementById("type").value + '&game=' + document.getElementById("game").value;
//		document.getElementById("gamedetailsform").action = link_action;
//		document.getElementById("gamedetailsform").submit();
//	}
//	function submittype(object) {
//		var groupid = object.id;
//		var link_action =  document.getElementById("link").value;
//		document.getElementById("ownerid").value = groupid;
//		document.getElementById("typeuserform").action = link_action;
//		document.getElementById("typeuserform").submit();
//	}
//	function submitgame(object) {
//		//MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'?step=4&type='.$type.'&game='.$game.'&details=next');
//		var gameid = object.id;
//		var link_action =  document.getElementById("link").value + '?step=2&type=' + document.getElementById("type").value + '&game=' + gameid;
//		document.getElementById("search_form").action = link_action;
//		document.getElementById("search_form").submit();
//	}
//	function submitgamenext(object) {
//		//MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'?step=4&type='.$type.'&game='.$game.'&details=next');
//		var gameid = object.id;
//		var link_action =  document.getElementById("link").value + '?step=3&type=' + document.getElementById("type").value + '&game=' + gameid;
//		document.getElementById("search_form").action = link_action;
//		document.getElementById("search_form").submit();
//	}
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
                    <img src="../global/img/RecruitmentWelcome/descriptionClosed.png">
                </a>
            </span>
        
            <span id="linkhidedescription">
		<a href="#" class="close">
                    <?php echo $this->__('Description'); ?>
                    <img src="../global/img/RecruitmentWelcome/descriptionOpen.png"></a>
            </span>
	</div>
</div>

<script type="text/javascript">
	function verify(object) {
		show_alert = '';
		
		var link_redirect = document.getElementById('link_create').value;
		if (show_alert!='') {
			alert(show_alert);
			
		} else {
			document.getElementById("gamedescriptionform").submit(); 
		}
	}
        function submitdetails() {
		document.getElementById("gamedetailsform").submit();
	}
	function submitgamedescription() {
		document.getElementById("gamedescriptionform").submit();
	}
	function submitfinalizeform() {
		document.getElementById("finalizeform").submit();
        }
</script>

<?php if($_GET['step'] == "1")
    {
?>

<div class="steps">
    <span class="step1a"><?php echo $this->__('Choose'); ?></span>
    <span class="step2a"><?php echo $this->__('Game'); ?></span>
    <span class="step3a"><?php echo $this->__('Details'); ?></span>
    <span class="step4a"><?php echo $this->__('Description'); ?></span>
    <span class="step5a"><?php echo $this->__('Finalize'); ?></span>
</div>

<h2><?php echo $this->__('Will you recruit as a:'); ?></h2>

<div id="choosePlayerGroup">
	<form id="typeuserform" action="" method="post"  enctype="multipart/form-data">
	<input type="hidden" id="type" name="type" value="<?php echo isset($_GET['type']) ? $_GET['type'] : ''; ?>">
	<input type="hidden" id="ownerid" name="ownerid">
	<input type="hidden" id="link" name="link" value="<?php echo  MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'?step=2&type=group'); ?>">
    
    <span class="playerGroup">
            
        <div class="playerGroupText">
            <h3><?php echo $this->__('Player'); ?></h3>
            <p><?php echo nl2br($this->__("Choose 'Player' if you are looking for another team member for your guild or clan just a new gaming partner to play with.

            Relevant people can then see that you are looking for a new gaming partner or a new member for your group, 
                guild or clan and quickly get in contact with you.")); ?></p>
            <br/>
            
            <p class='playergroupnext'><a href='?step=2&type=player'><span class='nextBTN1'>&nbsp;</span></a></p> 
        </div>
    </span>
    
    
        <?php 
        echo "<span class='playerGroup'>                        
                        
                <div class='playerGroupText'>
                <h3>".$this->__('Group')."</h3>";
        
                if(isset($_GET['type']) && $_GET['type'] == "group")
                {
                    echo "<p>".$this->__('Choose one of your groups')."</p>
                        <div id='listGroups'>";
                    
                    $listgroups = Recruitment::ListGroupsByPlayer($userid);
                        foreach ($listgroups as $key=>$item):
                                echo "<div class='groupResult'><a onClick='submittype(this);' id=".$item->ID_GROUP." href='#'>
                                    ".$item->GroupName."</a></div>";
                       endforeach; 
                       
                       echo "</div>";
                }
                else 
                {   
                    echo "<p>".nl2br($this->__("Choose 'Group' if you are a single player looking for an established group, guild or clan of players to join.
                    Relevant groups of players can then see that you are looking to join groups like them and easily."))."</p>                    
                    <br/>";
                    
                    $listgroups = Recruitment::ListGroupsByPlayer($userid);
                    if(isset($listgroups) and !empty($listgroups)) {
                        echo "<p class='playergroupnext'><a href='?step=1&type=group'><span class='nextBTN1'>&nbsp;</span></a></p>"; 
                    }
                    else {
                        echo "<br/><p>".nl2br($this->__("You are not member of any groups yet. 
                            Select Player or join a group"))."</p>
                                <p class='playergroupnext'><img src='../global/img/RecruitmentWelcome/Step2/nextNO.png'></p>"; 
                    }
                }		                         
                        
                        echo "</div>
                            </span>";
        		
        
        ?>        
	</form>
</div>
<?php 
    }

    if($_GET['step'] == "2") 
    {
	  
		
    $type = $_GET['type'];
?>
    <div class="steps">
        <span class="step1a"><?php 
            if($type == "player") { echo $this->__('Player'); }
            if($type == "group") { echo $this->__('Group'); }
            ?></span>
        <span class="step2b"><?php echo $this->__('Game'); ?></span>
        <span class="step3a"><?php echo $this->__('Details'); ?></span>
        <span class="step4a"><?php echo $this->__('Description'); ?></span>
        <span class="step5a"><?php echo $this->__('Finalize'); ?></span>
    </div>

    <h2><?php echo $this->__('Choose what you are looking for').":"; ?></h2>
    
    <div id="chooseGame">
        <span class="gameChosen">
		<script>
		function getsearch() {
			var game_search = document.getElementById('gamesearch').value;
			var link_name = document.getElementById('link').value;
			//alert(game_search+'test');
			window.location.href = link_name+game_search;
				
		}
		

</script>

            <?php 
            if(isset($_GET['game'])) 
            {
				if(isset($gameinfo) and !empty($gameinfo)) 
                                { 
                	echo MainHelper::showImage($gameinfo, THUMB_LIST_204x286, false, array('no_img' => 'noimage/no_game_204x286.png')); 
            } 
            }
            else
            {
                echo "<img src='../global/img/RecruitmentWelcome/Step2/gameChosen.png' alt='No game selected'>";
                
            }
        ?>
        </span>
        <span id="gameSearch">
            <span id="gameSearchBar">
                <form id="search_form" action="" method="post"  enctype="multipart/form-data">
				<input type="text" id="gamesearch" name="gamesearch" placeholder="Search" <?php if(isset($_POST['gamesearch'])) { echo "value='$_POST[gamesearch]'"; } ?>>
				<input name="type" value="<?php echo $type; ?>" id="type" type="hidden">
				<input type="hidden" id="ownerid" name="ownerid" value="<?php echo $ownerid == '' ? $_POST['ownerid'] : $ownerid; ?>" >
				<input type="hidden" id="link" name="link" value="<?php echo  MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES); ?>">
				</form>
            </span>
            <span class="gameButtons">
            <?php 
            echo "<a href='?step=1'><span class='previousBTN2'>&nbsp;</span></a>";
            
            if(isset($_GET['game'])) 
                {
                    $game = $_GET['game'];
                    echo "<a onClick='submitgamenext(this);' id='".$game."' href='#'><span class='nextBTN2'>&nbsp;</span></a>"; 
                }
            elseif(isset($_GET['type'])){
                echo "<span class='nextBTN2'><img src='../global/img/RecruitmentWelcome/Step2/nextNO.png'></span>";
            }
            ?>
            </span>
        </span>
        <?php 
        if(isset($_POST['gamesearch']) || isset($_GET['game']) )
        {
			 if(isset($_POST['gamesearch']))
            {
				$games = Recruitment::getSearchGames($_POST['gamesearch']);
			} 
			elseif(isset($_GET['gamesearch']))
            {
                $games = Recruitment::getSearchGames($_GET['gamesearch']);
            }
			if(isset($games) and !empty($games)):
		 		echo "<span id='gameResultColumn'>";
				foreach ($games as $key=>$item):
					 echo "<a href='#' onClick='submitgame(this);' id=".$item->ID_GAME."><span class='theGameResults'";
					 if(isset($_GET['game']) && $_GET['game'] == $item->ID_GAME) { echo "id='selected'"; }
					 echo ">".$item->GameName."</span></a>";
				endforeach; 
				 echo "</span>";
			endif; 
				
        }
        else {
            echo "";
        }
        ?>
    </div>
<?php
    }
    
    if($_GET['step'] == "3")
    {
	
        $type = $_GET['type']; 
        $game = $_GET['game'];
?>
		<script>

		function setOptions(x,y,z) {
			//alert('test');
			document.getElementById(x).value = y;
			document.getElementById('list_'+x).className = 'local_nav_action global_nav_action_trigger';
			document.getElementById('item_'+x).style.display = "none";
			document.getElementById('label_'+x).innerHTML = z;
		}
		
</script>
        <div class="steps">
            <span class="step1a"><?php 
                if($type == "player") { echo $this->__('Player'); }
                if($type == "group") { echo $this->__('Group'); }
                ?></span>
            <span class="step2b"><?php echo $this->__('Game'); ?></span>
            <span class="step3c"><?php echo $this->__('Details'); ?></span>
            <span class="step4a"><?php echo $this->__('Description'); ?></span>
            <span class="step5a"><?php echo $this->__('Finalize'); ?></span>
        </div>
    
        <h2><?php echo $this->__('Choose what you are looking for').":"; ?></h2>
        
        <div id="detailsGame">
            <span class="gameChosen">
                <?php 
				if(isset($gameinfo) and !empty($gameinfo)) { 
                	echo MainHelper::showImage($gameinfo, THUMB_LIST_204x286, false, array('no_img' => 'noimage/no_game_204x286.png')); 
				} else {
					 echo "<img src='../global/img/RecruitmentWelcome/Step2/gameChosen.png' alt='No game selected'>";
				}
                ?>
            </span>
        	<span id="gameDetails">
            	<h3><?php echo $this->__('Game details').":"; ?></h3>
            	<span id="gameDetailsLeft">
                	<?php 
                        echo "<p class='local_nav_actions_p_c'>".$this->__('Region')."</p>
                            <p class='local_nav_actions_p_c'>".$this->__('Language')."</p>
                            <p class='local_nav_actions_p_c'>".$this->__('Server')."</p>
                            <p class='local_nav_actions_p_c'>".$this->__('Faction')."</p>
                            <p class='local_nav_actions_p_c'>".$this->__('Role')."</p>
                            <p class='local_nav_actions_p_c'>".$this->__('Level')."</p>
                            <p class='local_nav_actions_p_c'>".$this->__('Functions')."</p>";
            ?>
            	</span>
            	<span class="gameDetailsRight" id="gameDetailsRight">
                <form method="post" name="gamedetailsform"  id="gamedetailsform" action="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'?step=4&type='.$type.'&game='.$game.'&details=next'); ?>" enctype="multipart/form-data">
				<input name="link" value="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES); ?>" id="link" type="hidden">
				<input name="game" value="<?php echo $game; ?>" id="game" type="hidden">
				<input name="type" value="<?php echo $type; ?>" id="type" type="hidden">
				<input type="hidden" id="ownerid" name="ownerid" value="<?php echo $ownerid; ?>" >
				<div style="display: none;"><textarea id="gamedescription" name="gamedescription"><?php echo $gamedescription; ?></textarea></div>
				<input name="step" value="2" id="step" type="hidden">
				  <?php $regionID = Recruitment::getRegionByID($region); ?>
						<li class="local_nav_actions_li_c">
						<a id="list_region" name="list_region" class="local_nav_action global_nav_action_trigger" href="#">
						<span id="label_region" name="label_region" ><?php  echo  $region != '' ? $regionID->RegionName : $this->__('Select');?></span><i class="down_arrow_light_icon"></i></a>
						<div id="item_region" name="item_region" class="global_nav_action_dropdown">
								<ul class="dropdown_lang_select">
									<?php if(isset($regionList) and !empty($regionList)) {
										foreach ($regionList as $item) { ?>
											<li <?php echo $region != '' ? ($item->ID_REGION == $regionID->ID_REGION ? 'class="active"' : '') : '';?>><a href="#" onclick="setOptions('region','<?php echo $item->ID_REGION; ?>','<?php echo $item->RegionName; ?>');">
											<?php echo $item->RegionName; ?>
											</a></li>
										<?php } ?>
									<?php } ?>	
								</ul>
								<input name="region" value="<?php  echo $region; ?>" id="region" type="hidden">
							</div>
						</li>
						<br />
						<br />
						
					<?php $langs = Lang::getLanguages(); $currentLang = Lang::getCurrentLangID(); $selectedLang = Lang::getLangById($currentLang); $selectedLang2 = Lang::getLangById($language);?>
						<?php if($isEnabledTranslate == 1): ?>
						<li class="local_nav_actions_li_c">
							<a id="list_language" name="list_language" class="local_nav_action global_nav_action_trigger" href="#"><span id="label_language" name="label_language" ><?php  echo $language != '' ? $selectedLang2->NativeName : $selectedLang->NativeName;?></span><i class="down_arrow_light_icon"></i></a>
							<div id="item_language" name="item_language" class="global_nav_action_dropdown">
								<ul class="dropdown_lang_select">
									<?php foreach($langs as $lang):?>
									<li <?php echo $lang->ID_LANGUAGE == $currentLang ? 'class="active"' : '';?>>
										<a href="#" onclick="setOptions('language','<?php echo $lang->ID_LANGUAGE; ?>','<?php echo $lang->NativeName; ?>');"><?php echo $lang->NativeName;?></a>
										
									</li>
									<?php endforeach;?>
								</ul>
								<input name="language" value="<?php echo $language != '' ? $language : $currentLang; ?>" id="language" type="hidden">
							</div>
						</li>
						<?php endif; ?>
						<br />
						<br />
                    <?php $serverID = Recruitment::getServerByID($server); ?>
						<li class="local_nav_actions_li_c">
						<a id="list_server" name="list_server" class="local_nav_action global_nav_action_trigger" href="#">
						<span id="label_server" name="label_server" ><?php  echo $server != '' ? $serverID->ServerName : $this->__('Select'); ?></span><i class="down_arrow_light_icon"></i></a>
						<div id="item_server" name="item_server" class="global_nav_action_dropdown">
								<ul class="dropdown_lang_select">
									<?php if(isset($serverList) and !empty($serverList)) {
										foreach ($serverList as $item) { ?>
										  <li <?php echo $serverID != '' && $item->ID_SERVER == $serverID->ID_SERVER ? 'class="active"' : '';?>><a href="#" onclick="setOptions('server','<?php echo $item->ID_SERVER; ?>','<?php echo $item->ServerName; ?>');"><?php echo $item->ServerName; ?>
											</a></li>
										<?php } ?>
									<?php } ?>	
								</ul>
								<input name="server" value="<?php  echo $server; ?>" id="server" type="hidden">
							</div>
						</li>
						<br />
						<br />
					<?php $factionID = Recruitment::getFactionByID($faction); ?>
						<li class="local_nav_actions_li_c">
						<a id="list_faction" name="list_faction" class="local_nav_action global_nav_action_trigger" href="#">						
						<span id="label_faction" name="label_faction" ><?php  echo $faction != '' ? $factionID->FactionName : $this->__('Select'); ?></span><i class="down_arrow_light_icon"></i></a>
						<div id="item_faction" name="item_faction" class="global_nav_action_dropdown">
								<ul class="dropdown_lang_select">
									<?php if(isset($factionList) and !empty($factionList)) {
										foreach ($factionList as $item) { ?>
											<li <?php echo $factionID != '' && $item->ID_FACTION == $factionID->ID_FACTION ? 'class="active"' : '';?>><a href="#" onclick="setOptions('faction','<?php echo $item->ID_FACTION; ?>','<?php echo $item->FactionName; ?>');"><?php echo $item->FactionName; ?>
											</a></li>
										<?php } ?>
									<?php } ?>	
								</ul>
								<input name="faction" value="<?php  echo $faction; ?>" id="faction" type="hidden" >
							</div>
						</li>
						<br />
						<br />
					<?php $roleID = Recruitment::getRoleByID($role); ?>
						<li class="local_nav_actions_li_c">
						<a id="list_role" name="list_role" class="local_nav_action global_nav_action_trigger" href="#">
						<span id="label_role" name="label_role" ><?php  echo $role != '' ? $roleID->RoleName : $this->__('Select'); ?></span><i class="down_arrow_light_icon"></i></a>
						<div id="item_role" name="item_role" class="global_nav_action_dropdown">
								<ul class="dropdown_lang_select">
									<?php if(isset($roleList) and !empty($roleList)) {
										foreach ($roleList as $item) { ?>
											<li <?php echo $roleID != '' && $item->ID_ROLE == $roleID->ID_ROLE ? 'class="active"' : '';?>><a href="#" onclick="setOptions('role','<?php echo $item->ID_ROLE; ?>','<?php echo $item->RoleName; ?>');"><?php echo $item->RoleName; ?>
											</a></li>
										<?php } ?>
									<?php } ?>	
								</ul>
								<input name="role" value="<?php  echo $role; ?>" id="role" type="hidden">
							</div>
						</li>
						<br />
						<br />
					<?php $levelID = Recruitment::getLevelByID($gplvl); ?>
						<li class="local_nav_actions_li_c">
						<a id="list_gplvl" name="list_gplvl" class="local_nav_action global_nav_action_trigger" href="#">
						<span id="label_gplvl" name="label_gplvl" ><?php  echo $gplvl != '' ? $levelID->GroupTypeName : $this->__('Select'); ?></span><i class="down_arrow_light_icon"></i></a>
						<div id="item_gplvl" name="item_gplvl" class="global_nav_action_dropdown">
								<ul class="dropdown_lang_select">
									<?php if(isset($levelList) and !empty($levelList)) {
										foreach ($levelList as $item) { ?>
											<li <?php echo $level != '' ? ($item->ID_GROUPTYPE == $levelID->ID_GROUPTYPE ? 'class="active"' : '') : '';?>><a href="#" onclick="setOptions('gplvl','<?php echo $item->ID_GROUPTYPE; ?>','<?php echo $item->GroupTypeName; ?>');"><?php echo $item->GroupTypeName; ?>
											</a></li>
										<?php } ?>
									<?php } ?>	
								</ul>
								<input name="gplvl" value="<?php  echo $gplvl; ?>" id="gplvl" type="hidden">
							</div>
						</li>
						<br />
						<br />
					<?php $modeID = Recruitment::getModeByID($gpmode); ?>
						<li class="local_nav_actions_li_c">
						<a id="list_gpmode" name="list_gpmode" class="local_nav_action global_nav_action_trigger" href="#">
						<span id="label_gpmode" name="label_gpmode" ><?php  echo $gpmode != '' ? $modeID->GroupTypeName : $this->__('Select');?></span><i class="down_arrow_light_icon"></i></a>
						<div id="item_gpmode" name="item_gpmode" class="global_nav_action_dropdown">
								<ul class="dropdown_lang_select">
									<?php if(isset($modeList) and !empty($modeList)) {
										foreach ($modeList as $item) { ?>
											<li <?php echo $mode != '' ? ($item->ID_GROUPTYPE == $modeID->ID_GROUPTYPE ? 'class="active"' : '') : '';?>><a href="#" onclick="setOptions('gpmode','<?php echo $item->ID_GROUPTYPE; ?>','<?php echo $item->GroupTypeName; ?>');"><?php echo $item->GroupTypeName; ?>
											</a></li>
										<?php } ?>
									<?php } ?>	
								</ul>
								<input name="gpmode" value="<?php  echo $gpmode; ?>" id="gpmode" type="hidden">
							</div>
						</li>
                </form>
            	</span>
				<span class="gameButtons">
				<?php 
				
					echo "<a onClick='submitdetailsprevious(this);' href='#'><span class='previousBTN3'>&nbsp;</span></a>";
				
					echo "<a onClick='submitdetails(this);' href='#'><span class='nextBTN3'>&nbsp;</span></a>";
					
				?>
				</span>
        	</span>
            
       </div>
<?php
    }
    
    if($_GET['step'] == "4")
    {
	
	
        $type = $_GET['type']; //$_GET['type'];
        $game = $_GET['game'];
?>

        <div class="steps">
            <span class="step1a"><?php 
                if($type == "player") { echo $this->__('Player'); }
                if($type == "group") { echo $this->__('Group'); }
                ?></span>
            <span class="step2b"><?php echo $this->__('Game'); ?></span>
            <span class="step3c"><?php echo $this->__('Details'); ?></span>
            <span class="step4d"><?php echo $this->__('Description'); ?></span>
            <span class="step5a"><?php echo $this->__('Finalize'); ?></span>
        </div>
    
        <h2><?php echo $this->__('Choose what you are looking for').":"; ?></h2>
       
        <div id="gameDescription">
            <div class="gameChosen">
                <?php 
                if(isset($gameinfo) and !empty($gameinfo)) { 
                	echo MainHelper::showImage($gameinfo, THUMB_LIST_204x286, false, array('no_img' => 'noimage/no_game_204x286.png')); 
				} else {
					echo "<img src='' alt='".$game."'>"; 
				}
                ?> 
            </div>
            <div id="gameDescriptionBg">
                <h3><?php echo $this->__('Description'); ?></h3>
                <form  method="post" action="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'?step=5&type='.$type.'&game='.$game.'&details=next&description=next'); ?>"  name="gamedescriptionform" id="gamedescriptionform">
                    <textarea id="gamedescription" name="gamedescription"><?php echo $gamedescription; ?></textarea>
					<input type="hidden" id="game" name="game" value="<?php echo $game; ?>"  />
               		<input type="hidden" id="language" name="language" value="<?php echo $language; ?>"  />
					<input type="hidden" id="gpmode" name="gpmode" value="<?php echo $gpmode; ?>"  />
					<input type="hidden" id="role" name="role" value="<?php echo $role; ?>"  />
					<input type="hidden" id="region" name="region" value="<?php echo $region; ?>"  />
					<input type="hidden" id="weapon" name="weapon" value="<?php echo $weapon; ?>"  />
					<input type="hidden" id="server" name="server" value="<?php echo $server; ?>"  />
					<input type="hidden" id="gplvl" name="gplvl" value="<?php echo $gplvl; ?>"  />
					<input type="hidden" id="faction" name="faction" value="<?php echo $faction; ?>"  />
					<input type="hidden" id="ownerid" name="ownerid" value="<?php echo $ownerid; ?>" >
         			<input name="link" value="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES); ?>" id="link" type="hidden">
					<input name="type" value="<?php echo $type; ?>" id="type" type="hidden">
					<input name="step" value="3" id="step" type="hidden">
                <span class="gameButtons">
            <?php 
            echo "<a onClick='submitgamedescriptionprevious(this);' href='#'><span class='previousBTN4'>&nbsp;</span></a>";
           
			echo "<a onClick='submitgamedescription(this);' href='#'><span class='nextBTN4'>&nbsp;</span></a>";
            
            ?>
			
            </span>
			 </form>
            </div>
        </div>
<?php
    }
    
    if (($_GET['step'] == "5") || ($step == '5'))
    {
			$type = $_GET['type'];
		 	$game = $_GET['game'];
		
?>
		<form  method="post" action="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'/notices/create'); ?>"  name="finalizeform" id="finalizeform">
        <div class="steps">
            <span class="step1a"><?php 
                if($type == "player") { echo $this->__('Player'); }
                if($type == "group") { echo $this->__('Group'); }
				
                ?></span>
            <span class="step2b"><?php echo $this->__('Game'); ?></span>
            <span class="step3c"><?php echo $this->__('Details'); ?></span>
            <span class="step4d"><?php echo $this->__('Description'); ?></span>
            <span class="step5e"><?php echo $this->__('Finalize'); ?></span>
        </div>
    	
        <h2><?php echo $this->__('Overview'); ?></h2>
      
        <div id="topicBG"><?php 
			if(isset($gameinfo) and !empty($gameinfo)) { 
				$gameid = $gameinfo->ID_GAME;
				$gamename = $gameinfo->GameName;
				echo MainHelper::showImage($gameinfo, THUMB_LIST_18x18, false, array('no_img' => 'noimage/no_game_18x18.png'))."  ".ucfirst($type).": ".$owneusername;
			} else {
				$gameid = '';
				$gamename = '';
				echo "<img src='' alt='".$game."'>".ucfirst($type).": ".$owneusername; 
			}//"<img src='' alt='".ucfirst($game)."'> ".
			//echo ucfirst($type).": ".$owneusername; 
		?>
		</div>
        <div id="gameFinalize">
            <span id="gameAvatar">
				<?php if(isset($playerinfo) and !empty($playerinfo)) {
					//$ownerid = $playerinfo->ID_PLAYER;
					 echo MainHelper::showImage($playerinfo, THUMB_LIST_150x200, false, array('no_img' => 'noimage/no_player_150x200.png')); 
				} else { ?>
                	<img src='../global/img/RecruitmentWelcome/Step5/AvatarFrame.png'>
				<?php } ?>
                <span id="imgAvatar"><a href='#'><?php echo $owneusername; ?></a></span>
            </span>
            <span id='gameFrames'>
                <span class='frameInfo'>
                    <span class='frameIcon'><img src='../global/img/RecruitmentWelcome/Step5/icons/Language.png'></span>
					<?php $selectedLang = Lang::getLangById($language);?> 
                    <span class='frameText'><?php  echo $language != '' ? $selectedLang->NativeName : '';?></span>
                </span>
                <span class='frameInfo'>
                    <span class='frameIcon'><img src='../global/img/RecruitmentWelcome/Step5/icons/Modes.png'></span>
					<?php $modeID = Recruitment::getModeByID($gpmode); ?>
                    <span class='frameText'><?php  echo $gpmode != '' ? $modeID->GroupTypeName : '';?></span>
                </span>
                <span class='frameInfo'>
                    <span class='frameIcon'><img src='../global/img/RecruitmentWelcome/Step5/icons/roles.png'></span>
					<?php $roleID = Recruitment::getRoleByID($role); ?>
                    <span class='frameText'><?php  echo $role != '' ? $roleID->RoleName : '';?></span>
                </span>
                <span class='frameInfo'>
                    <span class='frameIcon'><img src='../global/img/RecruitmentWelcome/Step5/icons/region.png'></span>
					<?php $regionID = Recruitment::getRegionByID($region); ?>
                    <span class='frameText'><?php  echo $region != '' ? $regionID->RegionName : '';?></span>
                </span>
               <!-- <span class='frameInfo'>
                    <span class='frameIcon'><img src='../global/img/RecruitmentWelcome/Step5/icons/weapon.png'></span>
                    <span class='frameText'>M4A1</span>
                </span>-->
                <span class='frameInfo'>
                    <span class='frameIcon'><img src='../global/img/RecruitmentWelcome/Step5/icons/server1.png'></span>
					<?php $serverID = Recruitment::getServerByID($server); ?>
                    <span class='frameText'><?php  echo $server != '' ? $serverID->ServerName : ''; ?></span>
                </span>
                <span class='frameInfo'>
                    <span class='frameIcon'><img src='../global/img/RecruitmentWelcome/Step5/icons/LEVELS.png'></span>
					<?php $levelID = Recruitment::getLevelByID($gplvl); ?>
                    <span class='frameText'><?php  echo $gplvl != '' ? $levelID->GroupTypeName : ''; ?></span>
                </span>
                <span class='frameInfo'>
                    <span class='frameIcon'><img src='../global/img/RecruitmentWelcome/Step5/icons/Faction1.png'></span>
					<?php $factionID = Recruitment::getFactionByID($faction); ?>
                    <span class='frameText'><?php  echo $faction != '' ? $factionID->FactionName :''; ?></span>
                </span>
                <span class='frameInfo'>
                    <span class='frameIcon'></span>
                    <span class='frameText'></span>
                </span>
            </span>
            <span id="gameDescriptionText">
            <h3 id="gameDescriptionTitle">Description</h3>
			
                        <span>
                            <span class="frameDescription3"><?php echo $gamedescription; ?></span>
                            <textarea class="frameDescription2" id="details1" name="details1"><?php echo $gamedescription; ?></textarea>
                        </span>
            <?php //} ?>
			</span>
			<div style="display: none;"><textarea id="details" name="details"><?php echo $gamedescription; ?></textarea><textarea id="gamedescription" name="gamedescription"><?php echo $gamedescription; ?></textarea></div>
			<input type="hidden" id="gamename" name="gamename" value="<?php echo $gamename; ?>"  />
			<input type="hidden" id="ownertype" name="ownertype" value="<?php echo $type; ?>"  />
			<input type="hidden" id="owner" name="owner" value="<?php echo $ownerid; ?>"  />
			<input type="hidden" id="ownerid" name="ownerid" value="<?php echo $ownerid; ?>"  />
			<input type="hidden" id="game" name="game" value="<?php echo $gameid; ?>"  />
			
			<input type="hidden" id="language" name="language" value="<?php echo $language; ?>"  />
			<input type="hidden" id="gpmode" name="gpmode" value="<?php echo $gpmode; ?>"  />
			<input type="hidden" id="role" name="role" value="<?php echo $role; ?>"  />
			<input type="hidden" id="region" name="region" value="<?php echo $region; ?>"  />
			<input type="hidden" id="weapon" name="weapon" value="<?php echo $weapon; ?>"  />
			<input type="hidden" id="server" name="server" value="<?php echo $server; ?>"  />
			<input type="hidden" id="gplvl" name="gplvl" value="<?php echo $gplvl; ?>"  />
			<input type="hidden" id="faction" name="faction" value="<?php echo $faction; ?>"  />
			<input name="link" value="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES); ?>" id="link" type="hidden">
			<input name="type" value="<?php echo $type; ?>" id="type" type="hidden">
			<input name="step" value="4" id="step" type="hidden">
            <span id="gameButtonsPost">
            <?php 
          	echo "<a onClick='submitfinalizeformprevious();' href='#'><span class='previousBTN5'>&nbsp;</span></a>";
			echo "<a onClick='submitfinalizeform();' href='#'><span id='postBTN'>&nbsp;</span></a>";
                
            ?>
            </span>
			
	
        </div>
		</form>
<?php
    }
?>
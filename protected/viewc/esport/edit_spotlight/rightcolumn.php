<?php
    $games = $profile['games'];
    $player = $profile['player'];
    $team = $profile['team'];
    $socials = $profile['socials'];
    $gamingrig = $profile['gamingrig'];
?>
<form class="updatespotlight_form" method="post" action="<?php echo MainHelper::site_url('esport/spotlight/update'); ?>">
<input type="hidden" name="teaminfo" class="teaminfo" value="<?php echo $team->ID_TEAM; ?>" />
<div class="esports_right_column">
	<div class="overview red_gradient_bg">
    	<h2><?php echo strtoupper($this->__('General info')); ?></h2>
    </div>
    <div class="grey_bg_margin">
    	<div class="team_info">
            <div class="information_section">
            	<input type="text" name="displayname" id="infobox" value="<?php echo $team->DisplayName; ?>" class="text_input w290 pull_right" />
                <p><?php echo $this->__('Display name'); ?></p>
            </div>
<!--            <div class="information_section">
            	<select id="infobox" class="text_input pull_right">
                    <?php foreach (MainHelper::getCountryList() as $country): ?>
                        <option value="<?php echo $country->A2; ?>" <?php echo $country->A2 == $player->Country ? "selected='selected'" : ""; ?>><?php echo $country->Country; ?></option>
                    <?php endforeach; ?>
                </select>
                <p>Country</p>
            </div>-->
            <div class="information_section">
                        <p><?php echo $this->__('Image'); ?></p>
                        <div class="profile_foto_edit mt5 dib pull_left ml100">
                        <input type="hidden" id="imageName" name="team_img" value="<?php echo $team->Avatar; ?>" />
                        <div class="standard_form_photo mt2">
                                <div class="standard_form_photo_wrapper mr50">
                                        <?php echo MainHelper::showImage($team, THUMB_LIST_100x100, false, array('width', 'no_img' => 'noimage/no_player_100x100.png'));?>
                                </div>
                                <div class="standard_form_photo_action ml0">
                                        <a id="team_img" class="button button_medium btn_red_gradient_bg" href="javascript:void(0);"><?php echo $this->__('Upload Photo'); ?></a>
                                        <p><?php echo $this->__('Use PNG, GIF or JPG.'); ?>
                                </div>
                        </div>
                        </div>
            </div>
            <?php foreach($socials as $social): ?>
            <div class="information_section">
            	<input type="text" name="socials[]" id="infobox" value="<?php echo $social->SocialURL; ?>" class="text_input w290 pull_right" />
                <p><?php echo ucfirst($social->SocialName); ?></p>
            </div>
            <?php endforeach; ?>
<!--            <div class="information_section">
            	<select id="infobox" class="text_input pull_right">
                    <option value="Choose">Choose...</option>
                    <option <?php //echo $player->Gender == 'Male' ? "selected='selected'" : ""; ?> value="male">Male</option>
                    <option <?php //echo $player->Gender == 'Female' ? "selected='selected'" : ""; ?> value="mercedes">Female</option>
                </select>
                <p>Gender</p>
            </div>-->
<!--            <div class="information_section birthday">
            	<input type="text" id="datepicker" value="<?php //echo $player->DateOfBirth; ?>" class="text_input w290 pull_right infobox" />
                <p>Birthday</p>
            </div>-->
		</div>
        <div class="team_description">
            <div class="information_section">
                <p><?php echo $this->__('Description'); ?></p>
            	<textarea type="text" name="intromessage" id="infobox" class="text_input w290 pull_left"><?php echo $team->IntroMessage; ?></textarea>
            </div>
		</div>
    </div>
    <div class="overview red_gradient_bg">
    	<h2><?php echo strtoupper($this->__('Games')); ?></h2>
    </div>
    <div class="grey_bg_margin">
		<div class="add_games">
            <a class="button button_small grey pull_right btn_red_gradient_bg add_game" href="javascript:void(0);"><?php echo $this->__('Add Game'); ?></a>
            <div class="gc_container pr dib">
            <img style="display:none; position: absolute; right: 28px; height: 18px; top: 2px;" src="<?php echo MainHelper::site_url('global/img/ajax-loader-small.gif');?>" />
            <select id="infobox" class="text_input pull_left gamecollection">
                <option value="0"><?php echo $this->__('Select game').'...'; ?></option>
                <?php foreach(Esport::getAllGames() as $game): ?>
                    <option value="<?php echo $game->ID_GAME; ?>"><?php echo $game->GameName; ?></option>
                <?php endforeach; ?>
            </select>
            </div>
        </div>
        <div class="visual_list gamelist">
        <?php foreach ($games as $game): ?>
            <div class="visual_item game pr"> 
                <img class="game_cancel cp" rel="<?php echo $game->ID_GAME; ?>" src="<?php echo MainHelper::site_url('global/img/esport_cross.jpg'); ?>" style="width:16px;height:16px;top:-4px;right:-4px;position:absolute;" />
                <?php echo MainHelper::showImage($game, THUMB_LIST_95x95, false, array('width', 'no_img' => 'noimage/no_game_95x95.png'));?>
                <p><?php echo $game->GameName; ?></p>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
    <div class="overview red_gradient_bg">
    	<h2><?php echo strtoupper($this->__('Gaming rig')); ?></h2>
    </div>
    <div class="grey_bg_margin">
        <div class="team_info w50p">
<!--        	<h3>Computer Specifications</h3>-->
                <?php foreach($gamingrig as $rig): ?>
                    <div class="information_section">
                        <input type="text" name="gamingrig[]" id="infobox" value="<?php echo $rig->SpecDesc; ?>" class="text_input w290 pull_right" />
                        <p><?php echo $rig->SpecName; ?></p>
                    </div>
                <?php endforeach; ?>
<!--            <div class="information_section">
            	<input type="text" id="infobox" value="" class="text_input w290 pull_right" />
                <p>CPU</p>
            </div>
            <div class="information_section">
            	<input type="text" id="infobox" value="" class="text_input w290 pull_right" />
                <p>Memory</p>
            </div>
            <div class="information_section">
            	<input type="text" id="infobox" value="" class="text_input w290 pull_right" />
                <p>Motherboard</p>
            </div>
            <div class="information_section">
            	<input type="text" id="infobox" value="" class="text_input w290 pull_right" />
                <p>Harddrive</p>
            </div>
            <div class="information_section">
            	<input type="text" id="infobox" value="" class="text_input w290 pull_right" />
                <p>Graphics card</p>
            </div>
            <div class="information_section">
            	<input type="text" id="infobox" value="" class="text_input w290 pull_right" />
                <p>Cooler</p>
            </div>
            <div class="information_section">
            	<input type="text" id="infobox" value="" class="text_input w290 pull_right" />
                <p>Power supply</p>
            </div>
            <div class="information_section">
            	<input type="text" id="infobox" value="" class="text_input w290 pull_right" />
                <p>OS</p>
            </div>-->
<!--		</div>
        <div class="team_info w50p">
        	<h3>Gaming Peripherals</h3>
            <div class="information_section">
            	<input type="text" id="infobox" value="" class="text_input w290 pull_right" />
                <p>Mouse</p>
            </div>
            <div class="information_section">
            	<input type="text" id="infobox" value="" class="text_input w290 pull_right" />
                <p>Keyboard</p>
            </div>
            <div class="information_section">
            	<input type="text" id="infobox" value="" class="text_input w290 pull_right" />
                <p>Headset</p>
            </div>
            <div class="information_section">
            	<input type="text" id="infobox" value="" class="text_input w290 pull_right" />
                <p>Monitor</p>
            </div>
		</div>-->
    </div>
<!--    <div class="overview red_gradient_bg">
    	<h2>GALLERY</h2>
    </div>
    <div class="grey_bg_margin">
		<div class="add_images">
            <a class="button button_small grey pull_right btn_red_gradient_bg add_image" href="#">Upload image</a>
            <input type="file" id="infobox" value="" class="text_input pull_left" />
        </div>
        <div class="visual_list">
        	<div class="visual_item">  There should be an X in the corner, to remove the game/image. How should we do this? 
                <img src="global/css/img/teams_cw.png" />
                <p>BF4</p>
            </div>
            <div class="visual_item">
                <img src="global/css/img/teams_cw.png" />
                <p>BF4</p>
            </div>
            <div class="visual_item">
                <img src="global/css/img/teams_cw.png" />
                <p>BF4</p>
            </div>
            <div class="visual_item">
                <img src="global/css/img/teams_cw.png" />
                <p>BF4</p>
            </div>
            <div class="visual_item">
                <img src="global/css/img/teams_cw.png" />
                <p>BF4</p>
            </div>
            <div class="visual_item">
                <img src="global/css/img/teams_cw.png" />
                <p>BF4</p>
            </div>
            <div class="visual_item">
                <img src="global/css/img/teams_cw.png" />
                <p>BF4</p>
            </div>
            <div class="visual_item">
                <img src="global/css/img/teams_cw.png" />
                <p>BF4</p>
            </div>
            <div class="visual_item">
                <img src="global/css/img/teams_cw.png" />
                <p>BF4</p>
            </div>
        </div>
    </div>-->
    <div class="grey_bg_margin save_info">
    	<input type="submit" class="button button_small grey pull_left btn_red_gradient_bg save_button" value="<?php echo $this->__('Save'); ?>"/>
        <input type="button" class="button button_small grey pull_left btn_grey_gradient_bg discard_button" onclick="window.location = site_url+'esport/spotlight'" value="<?php echo $this->__('Cancel'); ?>" />
    </div>
</div>
</form>

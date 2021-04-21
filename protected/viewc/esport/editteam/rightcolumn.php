<?php
    $team = $profile['team'];
    $games = $profile['games'];
    $p = $profile['player'];
    $roster = $profile['roster'];
    $socials = $profile['socials'];
?>
<form class="updatespotlight_form" method="post" action="<?php echo MainHelper::site_url('esport/myteam/update'); ?>">
<input type="hidden" name="teaminfo" class="teaminfo" value="<?php echo $team->ID_TEAM; ?>" />
<div class="esports_right_column">
	<div class="overview red_gradient_bg">
    	<h2>GENERAL INFO</h2>
    </div>
    <div class="grey_bg_margin">
    	<div class="team_info">
            <div class="information_section">
            	<input type="text" name="displayname" id="infobox" value="<?php echo $team->DisplayName; ?>" class="text_input w290 pull_right" />
                <p><?php echo $this->__('Team name'); ?></p>
            </div>
            <div class="information_section">
            	<select id="infobox" name="country" class="text_input pull_right">
                    <?php foreach (MainHelper::getCountryList() as $country): ?>
                        <option value="<?php echo $country->A2; ?>" <?php echo $country->A2 == $team->Country ? "selected='selected'" : ""; ?>><?php echo $country->Country; ?></option>
                    <?php endforeach; ?>
                </select>
                <p>Country</p>
            </div>
            <div class="information_section">
                        <p><?php echo $this->__('Image'); ?></p>
                        <div class="profile_foto_edit mt5 dib pull_left ml100">
                        <input type="hidden" id="imageName" name="team_img" value="<?php echo $team->Avatar; ?>" />
                        <div class="standard_form_photo mt2">
                                <div class="standard_form_photo_wrapper mr50">
                                        <?php echo MainHelper::showImage($team, THUMB_LIST_100x100, false, array('width', 'no_img' => 'noimage/no_player_100x100.png'));?>
                                </div>
                                <div class="standard_form_photo_action ml0">
                                        <a id="team_img" rel="42" class="button button_medium btn_red_gradient_bg" href="javascript:void(0);"><?php echo $this->__('Upload Photo'); ?></a>
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
		</div>
        <div class="team_description">
            <div class="information_section">
                <p><?php echo $this->__('Description'); ?></p>
            	<textarea type="text" name="intromessage" id="infobox" class="text_input w290 pull_left"><?php echo $team->IntroMessage; ?></textarea>
            </div>
		</div>
    </div>
    <div class="overview red_gradient_bg">
    	<h2>GAMES</h2>
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
    	<h2>EDIT / ADD TEAM ROSTER</h2>
    </div>
    <div class="grey_bg_margin">
            <div class="team_info roster">
                <div class="information_section">
                    <select id="rolebox" name="player[]" class="text_input w290 pull_right">
                      <option selected="selected" value="1_<?php echo $p->ID_TEAM; ?>"><?php echo $this->__('Captain'); ?></option>
                    </select>
                    <p class="user"><?php echo $p->DisplayName ?></p>
                    <p><?php echo $this->__('Player'); ?></p>
                </div>
                <?php foreach($roster as $player): ?>
                <div class="information_section">
                    <select id="rolebox" name="player[]" class="text_input w290 pull_right">
                      <option selected="selected" value="3_<?php echo $player->ID_TEAM; ?>"><?php echo $this->__('Member'); ?></option>
                      <option selected="selected" value="4_<?php echo $player->ID_TEAM; ?>"><?php echo $this->__('Remove'); ?></option>
                    </select>
                    <p class="user"><?php echo $player->DisplayName ?></p>
                    <p><?php echo $this->__('Player'); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="team_info">
            <div class="information_section">
                <input type="text" id="infobox" name="add_player" value="" class="searchbox text_input w290 pull_left mr25" />
                <a class="search_player button button_small grey btn_red_gradient_bg pull_left" href="javascript:void(0)"><?php echo $this->__('Search'); ?></a>
            </div>
            <div class="search_result">
            </div>
            </div>
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
    	<input type="submit" class="button button_small grey pull_left btn_red_gradient_bg save_button" value="<?php echo $this->__('Save'); ?>" />
        <input type="button" class="button button_small grey pull_left btn_grey_gradient_bg discard_button" value ="<?php echo $this->__('Cancel') ?>" />
    </div>
</div>
</form>
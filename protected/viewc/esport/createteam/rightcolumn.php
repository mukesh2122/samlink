<?php 
    $p = $profile['player'];
?>
<div class="esports_right_column">
    <div class="overview red_gradient_bg">
    	<h2><?php echo strtoupper($this->__('Team').' '.$this->__('Information')); ?></h2>
    </div>
    <form name="input" action="<?php echo MainHelper::site_url('esport/registerteam'); ?>" method="post">
        <div class="grey_bg_margin">
            <div class="team_info">
                <div class="information_section">
                    <input type="text" id="infobox" name="teamname" value="" class="text_input w290 pull_right" />
                    <p><?php echo $this->__('Team').' '.$this->__('name'); ?></p>
                </div>
                <div class="information_section">
                    <input type="text" id="infobox" name="initials" value="" class="text_input w290 pull_right" />
                    <p><?php echo $this->__('Initials'); ?></p>
                </div>
                <div class="information_section">
                    <select id="infobox" name="country" value="Select role..." class="text_input w300 pull_right">
                    <option value="0"><?php echo $this->__('Select country').'...'; ?></option>
                      <?php foreach(MainHelper::getCountryList() as $country){ ?>
                        <option value="<?php echo $country->A2; ?>"><?php echo $country->Country; ?></option>
                      <?php } ?>
                    </select>
                    <p><?php echo $this->__('Country'); ?></p>
                </div>
                <div class="information_section">
                    <input type="text" id="infobox" name="facebook" value="" class="text_input w290 pull_right" />
                    <p>Facebook</p>
                </div>
                <div class="information_section">
                    <input type="text" id="infobox" name="twitter" value="" class="text_input w290 pull_right" />
                    <p>Twitter</p>
                </div>
                <div class="information_section">
                    <input type="text" id="infobox" name="twitch" value="" class="text_input w290 pull_right" />
                    <p>Twitch</p>
                </div>
                <div class="information_section">
                    <input type="text" id="infobox" name="youtube" value="" class="text_input w290 pull_right" />
                    <p>YouTube</p>
                </div>
                    </div>
            <div class="team_description">
                <div class="information_section">
                    <p><?php echo $this->__('Intro message'); ?></p>
                    <textarea type="text" id="infobox" name="intromessage" value="" class="text_input w290 pull_left"></textarea>
                </div>
                    </div>
        </div>
        <div class="overview red_gradient_bg">
            <h2>TEAM ROSTER</h2>
        </div>
            <div class="grey_bg_margin">
            <div class="team_info roster">
                <div class="information_section">
                    <select id="rolebox" name="player[]" class="text_input w290 pull_right">
                      <option selected="selected" value="captain"><?php echo $this->__('Captain'); ?></option>
                    </select>
                    <input type="hidden" name="owner" value="<?php echo $p->ID_TEAM; ?>" />
                    <p class="user"><?php echo $p->DisplayName ?></p>
                    <p><?php echo $this->__('Player'); ?></p>
                </div>
            </div>
            <div class="team_info">
            <div class="information_section">
                <input type="text" id="infobox" name="add_player" value="" class="searchbox text_input w290 pull_left mr25" />
                <a class="search_player button button_small grey btn_red_gradient_bg pull_left" href="javascript:void(0)"><?php echo $this->__('Search'); ?></a>
            </div>
            <div class="search_result">
            </div>
            </div>
<!--            <div class="team_gallery">
                <div class="information_section">
                    <input type="file" id="gallerybox" value="" class="text_input w290 pull_right" />
                    <p>Team image</p>
                </div>
            </div>-->
        </div>    
        <div class="overview red_gradient_bg">
            <h2><?php echo strtoupper($this->__('Gallery')); ?></h2>
        </div>
            <div class="grey_bg_margin">
            <div class="team_info gallery">
                    </div>
            <div class="team_gallery">
                <div class="information_section">
                    <input type="file" id="gallerybox" value="" class="text_input w290 pull_right" />
                    <p>Team image</p>
                </div>
            </div>
        </div>    
        <div class="grey_bg_margin save_info">
            <input type="submit" value="<?php echo $this->__('Save'); ?>" name="save" class="button button_small grey pull_left btn_red_gradient_bg save_button" href="#">
            <input type="submit" value="<?php echo $this->__('Cancel'); ?>" name="cancel" class="button button_small grey pull_left btn_grey_gradient_bg discard_button" href="#">
        </div>
    </form>
</div>
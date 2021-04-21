<div class="esports_right_column">
	<div class="overview red_gradient_bg">
    	<h2>CREATE CHALLENGE</h2>
    </div>
    <div class="darkgrey_bg_margin">
    	<p>You are about to create a PLAY4FREE Challenge. This will not cost you any credits and depending on your choices below, you will compete in a ranked or unranked challenge against another player.</p>
    </div>
    <div class="darkgrey_bg_margin">
    	<div class="esport_profile_boxheaders mt0 mb1"><p>Choose <span>Game</span></p></div>
        	<div class="visual_list">
                <div class="visual_item">
                    <img src="../global/css/img/gamelist_bf4.png" />
                    <p>BF4</p>
                </div>
                <div class="visual_item">
                    <img src="../global/css/img/games_big_sc2.png" />
                    <p>SC2</p>
                </div>
                <div class="visual_item selected"> <!-- READ ME. CLASS="SELECTED" MEANS BLUE BORDER. MUST BE POSSIBLE TO "SELECT" A GAME. JQUERY?`!?!?!?!??!?!?!?!?!?! -->
                    <img src="../global/css/img/gamecover_dota2.png" />
                    <p>DotA2</p>
                </div>
                <div class="visual_item">
                    <img src="../global/css/img/gamecover_csgo.png" />
                    <p>CS:GO</p>
                </div>
                <div class="visual_item">
                    <img src="../global/css/img/gamecover_lol.png" />
                    <p>LoL</p>
                </div>
                <div class="visual_item">
                    <img src="../global/css/img/gamelist_bf4.png" />
                    <p>BF4</p>
                </div>
                <div class="visual_item">
                    <img src="../global/css/img/gamelist_bf4.png" />
                    <p>BF4</p>
                </div>
                <div class="visual_item">
                    <img src="../global/css/img/gamelist_bf4.png" />
                    <p>BF4</p>
                </div>
                <div class="visual_item">
                    <img src="../global/css/img/gamelist_bf4.png" />
                    <p>BF4</p>
                </div>
            </div>
        </div>
        <div class="darkgrey_bg_margin">
            <div class="esport_profile_boxheaders mt0 mb1"><p>Ranked or <span>Unranked</span></p></div>
            <select id="rolebox" value="" class="text_input w290 pull_left create_challenge_input">
                <option value="Unranked">Unranked</option>
                <option value="Ranked">Ranked</option>
            </select>
        </div> <!-- READ ME. Man skal kun kunne møde "Random Team", når man spiller ranked. Har vedlagt .JPG. Man kan også møde Random Team hvis man spiller unranked. -->
        <div class="darkgrey_bg_margin">
            <div class="esport_profile_boxheaders mt0 mb1"><p>Choose <span>Player</span></p></div>
            <input type="text" id="commentbox role_box" value="Search player..." class="text_input w290 pull_left create_challenge_input">
            <input type="button" class="button button_small grey pull_left mt2 btn_red_gradient_bg create_challenge_input search_button" id="role_box" value="search">
            <div class="visual_list">
                <div class="visual_item selected"> <!-- READ ME. RANDOM TEAM SKAL ALTID VÆRE DER. --> <!-- READ ME. CLASS="SELECTED" MEANS BLUE BORDER. MUST BE POSSIBLE TO "SELECT" A GAME. JQUERY?`!?!?!?!??!?!?!?!?!?! -->
                    <img src="../global/css/img/teams_big_random.png" />
                    <p>Random Player</p>
                </div>
                <div class="visual_item">
                    <img src="../global/css/img/teams_big_cw.png" />
                    <p>Octa</p>
                </div>
                <div class="visual_item">
                    <img src="../global/css/img/gamecover_dota2.png" />
                    <p>Verdens bedste</p>
                </div>
                <div class="visual_item">
                    <img src="../global/css/img/gamecover_csgo.png" />
                    <p>Mesteren</p>
                </div>
                <div class="visual_item">
                    <img src="../global/css/img/gamecover_lol.png" />
                    <p>Steven Seagull</p>
                </div>
                <div class="visual_item">
                    <img src="../global/css/img/teams_big_cw.png" />
                    <p>Zenny</p>
                </div>
                <div class="visual_item">
                    <img src="../global/css/img/teams_big_cw.png" />
                    <p>Nghe</p>
                </div>
                <div class="visual_item">
                    <img src="../global/css/img/teams_big_cw.png" />
                    <p>Carsten</p>
                </div>
            </div>
        </div>
        <div class="darkgrey_bg_margin server_details">
            <div class="esport_profile_boxheaders mt0 mb1"><p>SERVER <span>DetAiLs</span></p></div>
        	<textarea type="text" id="infobox" value="" class="text_input w290 pull_left"></textarea>
            <p>INFO:  It is your responsibility to let the other player know where you are playing. The info will ONLY be sent to the player you are playing against.</p>
        </div>
        <div class="darkgrey_bg_margin date_and_time">
        	<div class="esport_profile_boxheaders mt0 mb1"><p>DATE <span>& TIME</span></p></div>
            <div class="team_info">
                <div class="information_section">
                    <input type="text" id="infobox" value="" class="text_input w290 pull_right" /> <!-- READ ME. Skal være noget jQuery, for at alle tider bliver indtastet ens. Har vedlagt jpg fra grafikereN. -->
                    <p>Date</p>
                </div>
                <div class="information_section">
                    <input type="text" id="infobox" value="" class="text_input w290 pull_right" /> <!-- READ ME. Skal være noget jQuery, for at alle tider bliver indtastet ens. Har vedlagt jpg fra grafikereN. -->
                    <p>Time</p>
                </div>
                <div class="information_section">
                    <select id="rolebox" value="Timezone" class="text_input w290 pull_right"> <!-- READ ME. Skal være noget jQuery, for at alle tider bliver indtastet ens. Har vedlagt jpg fra grafikereN. -->
                      <option value="Timezone">Timezone</option>
                      <option value="-12">-12 GMT ved ik hvad det hedder</option>
                      <option value="-11">-11 hyGz</option>
                      <option value="-10">-10 I dont know man...</option>
                    </select> 
                    <p>Timezone</p>
                </div>
            </div>
        </div>
        <div class="darkgrey_bg_margin save_info">
            <a class="button button_small grey pull_left btn_red_gradient_bg save_button" href="#">Create challenge</a>
            <a class="button button_small grey pull_left btn_grey_gradient_bg discard_button" href="#">Cancel</a>
        </div>
</div>
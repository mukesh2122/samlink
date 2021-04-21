<div class="esports_right_column">
	<div class="overview red_gradient_bg">
    	<h2>CREATE CHALLENGE</h2>
    </div>
     <div class="darkgrey_bg_margin player_challenge">
     	<img src="#profile_picture_here" class="profile_picture" />
        <div class="esport_profile_boxheaders mt0 mb1"><p>RickyBobby<span><img src="#flag_origin_player" /> United States</span></p></div>
    	<p>Here is the deal! I’m the best there is, plain and simple. I mean, I wake up in the morning and I piss excellence, nobody can hang with my stuff. I’m just a big hairy american winning machine. If you aint first your last! Deal with it!</p>
        <div class="grey_info_box large">
        	<img src="#rank_tier_image" />
            <p>ELITE / TIER V</p>
        </div>
        <div class="grey_info_box large player_wins">
            <h1>89</h1>
            <p>WINS</p>
        </div>
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
            <div class="esport_profile_boxheaders mt0 mb1"><p>Play4Free <span>Play4Credits</span></p></div>
            <select id="rolebox" value="" class="text_input w290 pull_left create_challenge_input"><!-- ************ READ ME ************* Hvis der er valgt "Play4Free", skal der ikke vises "Credit Amount" herunder. Men det skal selvfølgelig vises, hvis der er valgt "Play4Credits". -->
                <option value="Play4Free">Play4Free</option>
                <option value="Play4Credits">Play4Credits</option>
            </select>
            <p>INFO: When you challenge another player like this, the match will not be ranked.</p>
        </div>
    <div class="darkgrey_bg_margin">
    	<div class="esport_profile_boxheaders mt0 mb1"><p>Credit <span>amount</span><span class="available_credits">(500 credits available. <a href="#link_to_buy_credits">Add</a> more)</span></p></div>
        <p class="color_white">Fixed credit amount</p>
        <div class="fixed_credit_amount">
        	<div class="amount">
            	<h1>10</h1>
                <p>Credits</p>
            </div>
            <div class="amount selected"> <!-- READ ME. CLASS="SELECTED" GIVER DEN BLÅ BORDER. HVORDAN SKAL VI/JEG LAVE SÅ MAN KAN KLIKKE PÅ EN CREDIT AMOUNT, OG DEN BLIVER SELECTED? STÅR DU FOR DET? CAPS LOCK IS STUCK!!!!!!!!!!!111111111111 -->
            	<h1>15</h1>
                <p>Credits</p>
            </div>
            <div class="amount">
            	<h1>20</h1>
                <p>Credits</p>
            </div>
            <div class="amount">
            	<h1>25</h1>
                <p>Credits</p>
            </div>
            <div class="amount">
            	<h1>50</h1>
                <p>Credits</p>
            </div>
            <div class="amount">
            	<h1>75</h1>
                <p>Credits</p>
            </div>
            <div class="amount">
            	<h1>100</h1>
                <p>Credits</p>
            </div>
            <div class="amount">
            	<h1>200</h1>
                <p>Credits</p>
            </div>
        </div>
        <p class="color_white">Custom credit amount</p>
        <p>Sådan en jQuery slider her. Du kan se vedlagte screenshot. Er det noget du vil lave, eller skal jeg? Du kan eventuelt sætte den ind, og få den til at fungere. Så skal jeg prøve at få den til at se flot ud :D?</p>
        <div class="fixed_credit_amount custom_credit_amount">
            <div class="amount">
            	<h1>VALGTE AMOUNT HER</h1>
                <p>Credits</p>
            </div>
        </div>
    </div>
        <div class="darkgrey_bg_margin server_details">
            <div class="esport_profile_boxheaders mt0 mb1"><p>SERVER <span>DetAiLs</span></p></div>
        	<textarea type="text" id="infobox" value="" class="text_input w290 pull_left"></textarea>
            <p>INFO:  It is your responsibility to let the other team know where you are playing. The info will ONLY be sent to the team you are playing against.</p>
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
<div class="the_one_columns_child index_introduction clearfix">

	<div class="intro_logo">
		<img class="intro_logo_img" alt="<?php echo $this->__('PlayNation'); ?>" src="<?php echo Doo::conf()->APP_URL; ?>global/css/img/intro_logo.png">
	</div>

	<div class="intro_text">
		<h1 class="intro_text_title">PlayNation</h1>

		<p><?php echo $this->__('PlayNation is a [_1]social network[_2] and news site targeted directly at [_1]gaming[_2] and gamers around the globe.', array('<span>','</span>'));?></p>
		<p><?php echo $this->__('[_1]PlayNation[_2] aims to bring you all the relevant news from the global gaming scene. We do not just offer the latest top news. ', array('<span>','</span>'));?>
		<?php echo $this->__('Our goal is to deliver the [_1]latest news[_2] about the gaming industry, [_1]games[_2], gaming [_1]equipment[_2], gaming [_1]events[_2], gaming [_1]groups[_2], players and everything else out there to satisfy your gaming needs.', array('<span>','</span>'));?></p>

		<?php if (MainHelper::IsModuleEnabledByTag('reguser')==1 && MainHelper::IsModuleNotAvailableByTag('reguser')==0): ?>
		<div class="intro_actions clearfix">
			<a class="big_register_button" href="<?php echo MainHelper::site_url('registration'); ?>"><?php echo $this->__('Register Now'); ?></a>
			<a class="big_signin_button" href="<?php echo MainHelper::site_url('signin'); ?>"><?php echo $this->__('Sign In'); ?></a>
		</div>
		<?php endif; ?>

		<div class="intro_video_link">
			<?php echo $this->__('Or, you can watch our promotion video [_1]right here[_2], to learn more about PlayNation.', array('<a target="_blank" href="http://vimeo.com/36973878">', '</a>')); ?>
		</div>
	</div>

</div>

<div class="pn_teasers_wrapper">
	<div class="pn_teasers">
		<div class="pn_teasers_seperator"></div>
		<h2 class="pn_teasers_header"><?php echo $this->__('Here are 9 good reasons to join [_1]PlayNation[_2] today.', array('<span>', '</span>')) ?></h2>

		<div class="teaser_lists clearfix">
			<ul class="teaser_list">
				<li>
					<h3><?php echo $this->__('Read the latest news'); ?></h3>
					<p><?php echo $this->__('Information and news from everything gaming related to every gamer in the world, without spending hours searching the internet.'); ?></p>
				</li>
				<li>
					<h3><?php echo $this->__('Find your favourite games'); ?></h3>
					<p><?php echo $this->__('Use our growing database of games to keep up with upgrades and add-ons, get the latest downloads and join the fanbase.'); ?></p>
				</li>
				<li>
					<h3><?php echo $this->__('Follow your favourite companies'); ?></h3>
					<p><?php echo $this->__('Use our growing database of developers, publishers and distributors to follow the latest news, coming titles and future plans.'); ?></p>
				</li>
			</ul>

			<ul class="teaser_list">
				<li>
					<h3><?php echo $this->__('Interact with other players'); ?></h3>
					<p><?php echo $this->__('Join the PlayNation Network with a personal profile and socialize in an environment that is directly tailored for gaming needs.'); ?></p>
				</li>
				<li>
					<h3><?php echo $this->__('Debate with your fellow gamers'); ?></h3>
					<p><?php echo $this->__('The forum is open to all registered users. Join the debate, share your experience and get help to solve that pesky mission!'); ?></p>
				</li>
				<li>
					<h3><?php echo $this->__('Create and attend events'); ?></h3>
					<p><?php echo $this->__('All the hottest, upcoming events in your area, just one click away. As an user on PlayNation you will also be able to create your own.'); ?></p>
				</li>
			</ul>

			<ul class="teaser_list">
				<li>
					<h3><?php echo $this->__('Create and join groups'); ?></h3>
					<p><?php echo $this->__('Setup a complete group page for your guild, house, fraction or clan, with all the basic features right at your fingertips!'); ?></p>
				</li>
				<li>
					<h3><?php echo $this->__('Play e-sports'); ?></h3>
					<p><?php echo $this->__('PlayNation’s e-sport section allows players to face-off against other players in any skill based game they can imagine.'); ?></p>
				</li>
				<li>
					<h3><?php echo $this->__('Browse our shop'); ?></h3>
					<p><?php echo $this->__('In our shop you can buy additional account features, memberships, games, mumble servers and a lot more. Go check it out!'); ?></p>
				</li>
			</ul>
		</div>
	</div>
</div>

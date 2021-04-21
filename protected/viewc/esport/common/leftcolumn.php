<div class="esports_left_column">
	<!-- Left column start -->
	<aside id="left_column" class="esports_profile_column">
		<?php
			echo $this->renderBlock('players/personalProfile', $profile);
		?>

                <?php if(User::getUser()->isEsportPlayer()): ?>
            
		<?php
                        //echo $this->renderBlock('esport/common/moneytransfer', array('profile'=>$profile));
		?>
		<?php
			if ($choosegameEnabled)
				echo $this->renderBlock('esport/common/game_chooser', array('profile'=>$profile));
		?>
		<?php
			if ($bettingladderEnabled)
				echo $this->renderBlock('esport/common/betting_ladder', array('profile'=>$profile));
		?>
                <?php 
                        if(1==2)
                                echo $this->renderBlock('sidebar/advertisement', array());
                ?>
                <?php endif; ?>
	</aside>
</div>
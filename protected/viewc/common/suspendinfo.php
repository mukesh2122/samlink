<?php 
	if(Auth::isUserLogged())
	{
		$suspendStatus = $poster->getSuspendStatus();
		$level = $suspendStatus['Level'];
		$Public = $suspendStatus['Public'];
		if ($level!=0 && ($Public==1 || $isMyself==1))
		{
			?><div class="info_box info_box_red"><?php 
			$suspendLevelText = MainHelper::GetSuspendLevelText($suspendStatus['Level']);

			$Unlimited = $suspendStatus['Unlimited'];
			$StartDate = $suspendStatus['StartDate'];
			$durDays = MainHelper::GetDurdays($StartDate);

			if ($suspendStatus==null)
			{
				echo $suspendLevelText;
			}
			else
			{
				if ($isMyself==0)
				{
					$suspendLevelText = $this->__('Status for the user') .": " .$suspendLevelText;
				}
				echo "<p><b>$suspendLevelText.</b></p>";
				echo "<p>".$this->__('Suspended').": $durDays ".$this->__('day(s) ago')."</p>";
				if ($Unlimited==0)
				{
					$EndDate = $suspendStatus['EndDate'];
					$remainTime = MainHelper::GetRemainTime($EndDate);
					echo "<p>" . $this->__('[_1] day(s) and [_2] hour(s) remaining',array($remainTime->days,$remainTime->h)) ."</p>";
				}
				echo "<p>".$this->__('Reason').": " . $suspendStatus['Reason'] . "</p>";
			}
			

			if ($level==4 && $isMyself==1)
			{
				echo '<p><a class="" href="'.MainHelper::site_url('players/edit/enableprofile').'">'.
				$this->__('Enable your profile.').'</a></p>';
			}
			?></div><?php
		}
	}
?>

<?php
$user = User::getUser();

if ($user) {
	$load = $user->IntroSteps + 1;

	if (isset($step) and $step >= 0) {
		$load = $step + 1;
	}

	switch ($load) {
		case 1:
			$includePath = "FTU/step1.php";
			break;
		case 2:
			$includePath = "FTU/step2.php";
			break;
		case 3:
			$includePath = "FTU/step3.php";
			break;
		case 4:
			$includePath = "FTU/step4.php";
			break;
		default:
			$includePath = "";
			break;
	}

	if ($includePath != ""):
		?>
		<div class="F_FTUwrapper">
			<div class="info_box">
				<?php echo $this->__('You have to complete these four steps before you can use the features within your account'); ?>
			</div>

			<?php
			include($includePath);
			?>
		</div>
		<?php
	endif;
}
?>
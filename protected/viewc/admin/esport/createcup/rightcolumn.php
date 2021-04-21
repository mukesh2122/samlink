<div class="esports_right_column">
	<?php 
		switch ($step)
		{
			default:
			case 0:
				echo $this->renderBlock('admin/esport/createcup/step_cuptype');
				break;
			case 1:
				echo $this->renderBlock('admin/esport/createcup/step_basicinfo');
				break;
			case 2:
				echo $this->renderBlock('admin/esport/createcup/step_participationrequirements');
				break;
			case 3:
				echo $this->renderBlock('admin/esport/createcup/step_mappool');
				break;
			case 4:
				echo $this->renderBlock('admin/esport/createcup/step_roundformats');
				break;
			case 5:
				echo $this->renderBlock('admin/esport/createcup/step_replays');
				break;
			case 6:
				echo $this->renderBlock('admin/esport/createcup/step_description');
				break;
			case 8:
				echo $this->renderBlock('admin/esport/createcup/step_graphics');
				break;
			case 7:
				echo isset($_SESSION['createcup']['Update']) ? $this->renderBlock('admin/esport/createcup/step_update') : $this->renderBlock('admin/esport/createcup/step_submit');
				break;
		}
	?>
</div>

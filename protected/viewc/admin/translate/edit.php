<form class="standard_form" method="post" action="<?php echo MainHelper::site_url('admin/translate/edit/'.$translateitem['ID_TEXT'].'/'.$translate->A2 . (($translate->transFilter!='') ? ('/'.$translate->transFilter) : '').(isset($translate->sortType) ? ('/sort/'.$translate->sortType.'/'.$translate->sortDir) : '') . (($translate->page!='') ? ('/page/'.$translate->page) : '')); ?>">

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo 'Edit language text'; ?></h1>
	</div>

	<div class="standard_form_elements clearfix">
		<div class="clearfix">
			<?php if (1==1 || $translate->A2=="EN"){ ?>
				<label for="TransKey">
					<?php echo $translateitem['TransKey']; ?>
				</label>
			<?php }else{ ?>
				<?php 
					//Show the english TransText as TransKey
					$englishKey = $translateitem['TransText'.$translate->A2];
				?>
				<label for="TransKey">
					<?php echo $englishKey;?>
				</label>
			<?php } ?>
			<span>
				<textarea rows="4" cols="52" tabindex="1" id="TransText" name="TransText" class="pull_right"><?php echo $translateitem['TransText'.$translate->A2]; ?></textarea>
			</span>
		</div>

		<div class="standard_form_checks clearfix">
			<span><br/>
			</span>
		</div>

		<?php if ($translate->A2=="EN"){ ?>
		<div class="standard_form_checks clearfix">
			<label for="TransKey">
				<?php echo "Allow edit other language"; ?>
			</label>

			<span>
				<div class="standard_form_checks_wrapper no-margin clearfix">
					<input class="dst" <?php if ($translateitem['allowEdit']=="1") echo "checked"; ?> type="checkbox" id="allowEdit" name="allowEdit" />
				</div>
			</span>
		</div>
		<?php } ?>

	</div>


	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo 'Save Settings'; ?>" />
	</div>
		
</form>
<script type="text/javascript">loadCheckboxes();</script>

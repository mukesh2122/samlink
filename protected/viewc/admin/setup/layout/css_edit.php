<style>
	.fileInput {
		position: relative;
		overflow: hidden;
		margin: 10px;
	}
	.fileInput input[type=file] {
		position: absolute;
		top: 0;
		right: 0;
		margin: 0;
		padding: 0;
		font-size: 20px;
		cursor: pointer;
		opacity: 0;
		filter: alpha(opacity=0);
	}
</style>
<div class="standard_form_header clearfix">
	<h1 class="pull_left">
		<?php if (isset($id) && $id > 0) {
			echo $this->__('Edit stylesheet');
		}
		else {
			echo $this->__('Add stylesheet');
		} ?>
	</h1>
</div>
<div class="tac">
	<form class="dib" method="post" action="<?php echo Mainhelper::site_url('admin/setup/layout/css/uploadCss') ?>" enctype="multipart/form-data" name="uploadCss">
		<input name="id" type="hidden" value="<?php echo $id; ?>">
		<label class="pull_left"><?php echo $this->__('CSS file'); ?></label>
		<div class="clearfix"></div>
		<input id="uploadCssShowFile" class="text_input pull_left" placeholder="<?php echo $this->__('No file selected'); ?>" disabled="disabled" value="<?php echo $cssFile->Path; ?>">
		<div class="clearfix"></div>
		<div class="fileInput button button_medium light_blue pull_left" style="margin-left:0px;">
			<span><?php echo $this->__('Select file...') ?></span>
			<input id="uploadCssSelectButton" type="file" name="uploadFileCss">
		</div>
		<label class="mt15 ml5 pull_left error">
			<?php
			if (!empty($error)) {
				switch($error) {
					case 'fileempty':
						echo $this->__('Please select a file to upload');
						break;
					case 'fileduplicate':
						echo $this->__('File is already used by another entry');
						break;
					case 'filetype':
						echo $this->__('Please select a CSS file');
						break;
					case 'fileerror':
						echo $this->__('File appears corrupted');
						break;
				}
			}
			?>
		</label>
		<div class="clearfix"></div>
		<label class="pull_left"><?php echo $this->__('Description').':'; ?></label>
		<div class="clearfix"></div>
		<input class="text_input pull_left" type="text" name="description" placeholder="<?php echo $this->__('Game or company name'); ?>" value="<?php echo $cssFile->FilenameDesc; ?>">
		<div class="clearfix"></div>
		<label class="pull_left mt10"><?php echo $this->__('File type').':'; ?></label>
		<div class="clearfix"></div>
		<?php if (!empty($fileTypes)):?>
			<select class="button button_medium light_blue pull_left" name="type" style="padding-top:.3em;">
				<?php foreach($fileTypes as $fileType): ?>
					<option value="<?php echo $fileType; ?>" <?php echo $fileType == $cssFile->Filetype ? 'selected' : '' ?>><?php echo ucfirst($fileType); ?></option>
				<?php endforeach; ?>
			</select>
			<label class="mt5 ml15 pull_left error">
				<?php
				if (!empty($error)) {
					switch($error) {
						case 'descempty':
							echo $this->__('Please enter a description');
							break;
						case 'descduplicate':
							echo $this->__('Description is already used by another entry');
							break;
						case 'posttype':
							echo $this->__('Please enter a legal file type');
							break;
					}
				}
				?>
			</label>
			<div class="clearfix"></div>
		<?php endif; ?>
		<input class="button button_medium light_blue mt10 pull_right button_span_left" type="submit" name="uploadCss" value="<?php echo $this->__('Save'); ?>">
		<a class="button button_medium light_blue mt10 pull_right" href="<?php echo MainHelper::site_url('admin/setup/layout/css/edit/'.$id); ?>">
			<?php echo $this->__('Reset'); ?>
		</a>
	</form>
</div>
<script type="text/javascript">
	window.onload = function() {
		document.getElementById("uploadCssSelectButton").onchange = function() {
			document.getElementById("uploadCssShowFile").value = this.value;
		};
	};
</script>

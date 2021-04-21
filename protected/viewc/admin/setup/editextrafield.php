<form class="standard_form" name="extrafieldform" method="post" action="#">
	<input type="hidden" name="ID_MODULE" id="ID_MODULE" value="<?php echo $selected_module['ID_MODULE']; ?>" />
	<input type="hidden" name="ID_FIELD" id="ID_FIELD" value="<?php echo $selected_extrafield['ID_FIELD']; ?>" />

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo 'Edit extra frield' ?></h1>
	</div>

	<div class="standard_form_elements clearfix">
		<div class="clearfix">
			<label for="A2"><?php echo 'Field name'; ?></label>
			<span>
				<input tabindex="1" id="FieldName" name="FieldName" type="text" value="<?php echo $selected_extrafield['FieldName']; ?>" class="text_input" />
			</span>
		</div>

		<div class="clearfix">
			<label for="ModuleTitle"><?php echo 'Field type'; ?></label>
			<span>
				<td>
					<?php $s = $selected_extrafield['FieldType']; ?>
					<select id="FieldType" class="dropkick_lightWide" name="FieldType">
						<option value="text" <?php if ($s=="text") echo 'selected="selected"'; ?> >Text</option>
						<option value="integer" <?php if ($s=="integer") echo 'selected="selected"'; ?>>Integer</option>
						<option value="boolean" <?php if ($s=="boolean") echo 'selected="selected"'; ?>>Boolean</option>
						<option value="date" <?php if ($s=="date") echo 'selected="selected"'; ?>>Date</option>
						<option value="timestamp" <?php if ($s=="timestamp") echo 'selected="selected"'; ?>>Timestamp</option>
					</select>
				</td>
			</span>
		</div>

		<div class="clearfix">
			<label for="A2"><?php echo 'Priority'; ?></label>
			<span>
				<input tabindex="3" id="Priority" name="Priority" type="text" value="<?php echo $selected_extrafield['Priority']; ?>" class="text_input" />
			</span>
		</div>
	</div>
	
	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo 'Save Settings'; ?>" />
	</div>
</form>


<script type="text/javascript">loadCheckboxes();</script> 
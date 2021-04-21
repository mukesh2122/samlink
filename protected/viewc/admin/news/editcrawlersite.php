<?php if(isset($sites) and !empty($sites)):?>
	<?php $site = $sites[0]; ?>
	<form method="post" action="<?php echo MainHelper::site_url('admin/news/crawlersites/edit/'.$site->ID_SITE); ?>">
		<input type="hidden" name="ID_SITE" value="<?php echo $site->ID_SITE; ?>" /> 
		<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
			<thead>
				<tr>
					<th class="size_30 centered"><?php echo $this->__('Key');?></th>
					<th class="size_70 centered"><?php echo $this->__('Value');?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($sites as $site) : ?>
				<tr>
					<td><?php echo $this->__('Auto Login'); ?></td>
					<td class="centered">
						<select class="size_30 centered" name="LoginActive">
							<option class="centered" value="1" <?php echo ($site->LoginActive) ? 'selected' : '' ?>>
								<?php echo $this->__('Yes'); ?>
							</option>
							<option class="centered" value="0" <?php echo (!$site->LoginActive) ? 'selected' : '' ?>>
								<?php echo $this->__('No'); ?>
							</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->__('Login URL'); ?></td>
					<td class="centered">
						<textarea rows="1" cols="56" name="LoginURL" onkeyup="resizeTextArea(this);"><?php echo $site->LoginURL; ?></textarea>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->__('Login User Xpath'); ?></td>
					<td class="centered">
						<textarea rows="1" cols="56" name="LoginUserXpath" onkeyup="resizeTextArea(this);"><?php echo $site->LoginUserXpath; ?></textarea>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->__('Login Username'); ?></td>
					<td class="centered">
						<input class="center size_80" type="text" name="LoginUsername" value="<?php echo $site->LoginUsername; ?>" />
					</td>
				</tr>
				<tr>
					<td><?php echo $this->__('Login Password Xpath'); ?></td>
					<td class="centered">
						<textarea rows="1" cols="56" name="LoginPasswordXpath" onkeyup="resizeTextArea(this);"><?php echo $site->LoginPasswordXpath; ?></textarea>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->__('Login Password'); ?></td>
					<td class="centered">
						<input class="center size_80" type="password" name="LoginPassword" value="<?php echo CrawlerLogin::decryptPassword($site->LoginPassword); ?>" />
					</td>
				</tr>
				<tr>
					<td><?php echo $this->__('Login Submit Xpath'); ?></td>
					<td class="centered">
						<textarea rows="1" cols="56" name="LoginSubmitXpath" onkeyup="resizeTextArea(this);"><?php echo $site->LoginSubmitXpath; ?></textarea>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->__('Language'); ?></td>
					<td class="centered">
						<select name="ID_LANGUAGE" class="size_30 centered">
							<?php foreach(Doo::conf()->langName as $key=>$langName) : ?>
								<option class="centered" value="<?php echo $key ?>" <?php echo ($langName == Doo::conf()->langName[$site->ID_LANGUAGE]) ? 'selected' : ''; ?>>
									<?php echo $this->__($langName); ?>
								</option>
							<?php endforeach ?>
						</select>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->__('Site Name'); ?></td>
					<td class="centered">
						<input name="Name" class="size_80 centered" type="text" value="<?php echo $site->Name; ?>" />
					</td>
				</tr>
				<tr>
					<td><?php echo $this->__('Site URL'); ?></td>
					<td class="centered">
						<input name="URL" class="size_80 centered" type="text" value="<?php echo $site->URL; ?>" />
					</td>
				</tr>
				<tr>
					<td><?php echo $this->__('DOM Article'); ?></td>
					<td class="centered">
						<textarea rows="1" cols="56" name="DomArticle" onkeyup="resizeTextArea(this);"><?php echo $site->DomArticle; ?></textarea>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->__('DOM Headline'); ?></td>
					<td class="centered">
						<textarea rows="1" cols="56" name="DomHeadline" onkeyup="resizeTextArea(this);"><?php echo $site->DomHeadline; ?></textarea>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->__('DOM Intro Text'); ?></td>
					<td class="centered">
						<textarea rows="1" cols="56" name="DomIntrotext" onkeyup="resizeTextArea(this);"><?php echo $site->DomIntrotext; ?></textarea>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->__('DOM News Text'); ?></td>
					<td class="centered">
						<textarea rows="1" cols="56" name="DomNewstext" onkeyup="resizeTextArea(this);"><?php echo $site->DomNewstext; ?></textarea>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->__('Internal Site'); ?></td>
					<td class="centered">
						<select class="size_30 centered" name="isInternal">
							<option class="centered" value="1" <?php echo ($site->isInternal) ? 'selected' : '' ?>>
								<?php echo $this->__('Yes'); ?>
							</option>
							<option class="centered" value="0" <?php echo (!$site->isInternal) ? 'selected' : '' ?>>
								<?php echo $this->__('No'); ?>
							</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->__('Active'); ?></td>
					<td class="centered">
						<select class="size_30 centered" name="isActive">
							<option class="centered" value="1" <?php echo ($site->isActive) ? 'selected' : '' ?>>
								<?php echo $this->__('Yes'); ?>
							</option>
							<option class="centered" value="0" <?php echo (!$site->isActive) ? 'selected' : '' ?>>
								<?php echo $this->__('No'); ?>
							</option>
						</select>
					</td>
				</tr>
				<?php endforeach; ?>
				<tr>
					<td colspan="2">
						<input type="submit" class="button button_auto light_blue pull_right" value="<?php echo $this->__('Save'); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</form>
<?php endif; ?>
<style type="text/css">
	textarea{resize:none}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$('textarea').each(function(){
			resizeTextArea(this);
		});
	});

	function resizeTextArea(element){
		var t = element.value;
		element.rows = Math.floor(t.length / element.cols) + t.split('\n').length;
	}
</script>

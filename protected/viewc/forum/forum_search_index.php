<?php include('common/top.php');?>

<!-- forum menu -->
<div id="forum_menu_wrap" class=" mt8 clearfix">
	<div class="sprite_3 fml fl"></div>
	<div id="forum_menu" class="fl">
		<div class="sprite_3 category fl">
			<select id="category" name="category" class="jumpBox">
				<option value ="game" <?php echo $data['type']=='game' ? 'selected' : ''; ?>><?php echo $this->__('Games'); ?></option>
				<option value ="company" <?php echo $data['type']=='company' ? 'selected' : ''; ?>><?php echo $this->__('Companies'); ?></option>
			</select>
		</div>

	<div class="az fl">
		<?php
			$letter = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			for($i = 0; $i < strlen($letter); $i++){
			    $l = $letter[$i];
				$class = "";
				if(isset($data['letter']) and strtoupper($data['letter']) == $l) {
					$class = 'active';
				}
				?>

				<div class="fl letter <?php echo $class; ?>">
					<?php $data['type'] = $data['type'] ? $data['type'] : 'game'; ?>
					<?php if($class == 'active'){ ?>
						<?php echo $l; ?>
					<?php } else { ?>
						<a href="<?php echo MainHelper::site_url('forum/'.$data['type'].'/letter/'.$l); ?>">
							<?php echo $l; ?>
						</a>
					<?php } ?>
				</div>
				<?php
			}
		?>

		</div>
		<div class="num09 fl">
			<?php
				for($n = 0; $n < 10; $n++){
					$class = "";
					if(isset($data['letter']) and strtoupper($data['letter']) === "$n") {
						$class = 'active';
					}
					?>

					<div class="fl letter <?php echo $class; ?>">
						<?php if($class == 'active'){ ?>
							<?php echo $n; ?>
						<?php } else { ?>
							<a href="<?php echo MainHelper::site_url('forum/'.$data['type'].'/letter/'.$n); ?>">
								<?php echo $n; ?>
							</a>
						<?php } ?>
					</div>
					<?php
				}
			?>
		</div>

	</div>
	<div class="sprite_3 fmr fr"></div>
</div>
<!-- end forum menu -->

<!-- forums -->
<div class="dot_top mt10">
	<?php
		foreach($model as $m){
		?>
			<div class="dot_bot pt10 pb10 clearfix">
				<div class="fl forum_title">
						<?php //echo var_dump($fields); exit;?>
					<a href="<?php echo MainHelper::site_url('forum/'.$type.'/'.$m->{$fields->id}); ?>" class="games">
							<?php echo $m->{$fields->name}; ?>
					</a>
				</div>
				<div class="fl forum_info fclg fs11">
					<?php echo $this->__('Posts'); ?>: <?php echo $m->PostCount ? $m->PostCount : 0; ?><br />
					<?php echo $this->__('Threads'); ?>: <?php echo $m->TopicCount ? $m->TopicCount : 0; ?>
				</div>
			</div>
		<?php
		}
	?>

</div>
<!-- end forums -->
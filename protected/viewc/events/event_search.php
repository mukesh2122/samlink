<!-- header -->
<div class="clearfix header events clearfix">
    <a href="<?php echo MainHelper::site_url('events');?>" class="fl"><?php echo $this->__('Events');?></a>
	<?php if(Auth::isUserLogged()):?>
        <div class="fr eventTopMenu">
			<div class="sprite_3 leftCorn fl h16"></div>
			<div class="items fl h16">
				<a href="<?php echo MainHelper::site_url('events/create/'.$type.'/'.$ownerId);?>"><?php echo $this->__('Create new event');?></a>
			</div>
			<div class="sprite_3 rightCorn h16 fl"></div>
        </div>
    <?php endif;?>
</div>
<!-- end header -->
<!-- search forum -->
<div class="clearfix">
	<?php echo $this->renderBlock('events/breadcrumb', array('crumb' => $crumb));?>
	<div class="hmenu mt15 fr">
		<?php
			$searchUrl = 'event-search/'.$type;
			if(isset($ownerId)){
				$searchUrl .= '/'.$ownerId;
			}
			
		?>
    	<form id="searchForm" action="<?php echo MainHelper::site_url($searchUrl); ?>" method="POST">
    		<div id="src_cont" class="sprite_2 forum_search">
				<input id="search" type="text" name="search" title="<?php echo $this->__('Search here...'); ?>" value="<?php echo $this->__('Search here...'); ?>" />
    			<a href="#" id="src_but" title="<?php echo $this->__('Search'); ?>">&nbsp;</a>
    		</div>
    	</form>
	</div>
</div>
<!-- end search forum -->

<!-- forum menu -->
<div id="forum_menu_wrap" class=" mt8 clearfix">
	<div class="sprite_3 fml eventsYellow fl"></div>
	<div id="forum_menu" class="fl eventsYellow">
		<div class="sprite_3 category fl jqtransform">
			<div class="noborder">
				<select id="category" name="category" class="jqselect catSelect jqselectEventCat">
					<option value ="game" <?php echo $data['type']=='game' ? 'selected' : ''; ?>><?php echo $this->__('Games'); ?></option>
					<option value ="company" <?php echo $data['type']=='company' ? 'selected' : ''; ?>><?php echo $this->__('Companies'); ?></option>
					<option value ="group" <?php echo $data['type']=='group' ? 'selected' : ''; ?>><?php echo $this->__('Groups'); ?></option>
				</select>
			</div>
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
						<a href="<?php echo MainHelper::site_url('events/'.$type.'/'.$ownerId.'/letter/'.$l); ?>">
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
							<a href="<?php echo MainHelper::site_url('events/'.$type.'/'.$ownerId.'/letter/'.$n); ?>">
								<?php echo $n; ?>
							</a>
						<?php } ?>
					</div>
					<?php
				}
			?>
		</div>

	</div>
	<div class="sprite_3 fmr eventsYellow fr"></div>
</div>
<!-- end forum menu -->

<!-- forums -->
<div class="dot_top mt10">
	<?php
	if(isset($events) and !empty($events)){
		foreach($events as $e){
		?>
			<div class="dot_bot pt10 pb10 clearfix">
				<div class="fl forum_title">
						<?php //echo var_dump($fields); exit;?>
					<a href="<?php echo MainHelper::site_url('event/'.$e->ID_EVENT); ?>" class="games">
							<?php echo $e->EventHeadline; ?>
					</a>
				</div>
				<div class="fl forum_info fclg fs11">
					<?php echo $this->__('Participants'); ?>: <?php echo $e->ActiveCount; ?>
				</div>
			</div>
		<?php
		}
	}
	?>

</div>
<!-- end forums -->
<!-- Event wrapper start -->
<div id="eventWrapper">

	<!-- Box body start -->
	<div class="boxBody">

		<!-- Box top start -->
		<div class="boxTop"></div>
		<!-- Box top end -->

		<!-- Event week start -->
		<span class="eventWeek"><?php echo $this->__("Week"); ?> <?php echo date("W", mktime(0, 0, 0, $data['month'], $data['day'], $data['year'])); ?></span>
		<!-- Event week end -->

		<!-- Event close start -->
		<a href="#" class="eventClose">&times;</a>
		<!-- Event close end -->

		<?php $e = $data['event']; ?>
		<?php 
		switch ($e->EventType) {
			case 'personal':
				$class = 'type_personal';
				break;
			case 'esport':
				$class = 'type_esport';
				break;
			case 'live':
				$class = 'type_live';
				break;
			case 'birthday':
				$class = 'type_birthday';
				break;
		}
		?>

		<!-- Eventbar start -->
		<div class="eventBar <?php echo $class; ?>">
			<span>Personal</span>

			<a href="#eventEditor" class="toggle eventScheduleToggle"> </a>
			<div id="eventEditor" class="eventSchedule">
				<?php 
				if ($e->EventType == 'personal'):
					include "eventSchedule.php";
				endif;
				?>
			</div>
		</div>
		<!-- Eventbar end -->

		<!-- Event content start -->
		<div class="eventContent clearfix">
			<div class="eventAvatar">
				<?php echo MainHelper::showImage($e, THUMB_LIST_40x40, false, array('no_img' => 'noimage/no_events_40x40.png')); ?>
			</div>

			<div class="eventHeadline">
				<p><?php echo $e->EventText; ?></p>
			</div>
			<div class="clear"></div>
		</div>
		<!-- Event content end -->

		<!-- Event actions start -->
		<div class="cCalendar_actions">
			<a class="icon_link eventDelete" rel="<?php echo $e->ID_EVENT; ?>" href="<?php echo $e->EventTime; ?>"><i class="trash_icon"></i><?php echo $this->__("Delete"); ?></a>

			<?php if ($e->RecurringEvent != false): ?>
				<a class="icon_link eventDeleteFuture" rel="<?php echo $e->ID_EVENT; ?>" href="<?php echo $e->EventTime; ?>"><i class="trash_icon"></i><?php echo $this->__("Delete all"); ?></a>
			<?php endif; ?>
		</div>
		<!-- Event actions end -->

		<!-- Event input start -->
		<?php $date = date('m'); ?>
		<form action="#" class="mt10">
			<input type="hidden" name="year" id="evYear" value="<?php echo $data['year']; ?>" />
			<input type="hidden" name="day" id="evDay" value="<?php echo $data['day']; ?>" />
			<input type="hidden" name="month" id="evMonth" value="<?php echo $data['month']; ?>" />
			<input type="hidden" name="ID_EVENT" id="ID_EVENT" value="<?php echo $e->ID_EVENT; ?>" />		
			<input type="hidden" name="eventTime" id="eventTime" value="<?php echo $e->EventTime; ?>" />		

			<label id="eventSymbolCounter" for="eventText"><?php echo $this->__("Symbols left:"); ?> 144</label>
			<textarea id="eventText" class="eventInput" name="eventText" maxlength="144"><?php echo $e->EventText; ?></textarea>
			<input class="eventEditButton cp" type="submit" name="submitEvent" value="<?php echo $this->__('Save');?>" />
		</form>
		<!-- Event input end -->

	</div>
	<!-- Box body end -->

</div>
<!-- Event wrapper end -->
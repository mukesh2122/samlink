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

		<?php $i = 0; ?>
		<?php foreach ($data['events'] as $e): ?>

			<?php
			switch ($e->EventType):
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
			endswitch;
			?>

			<!-- Eventbar start -->
			<div class="eventBar <?php echo $class; ?>">
				<span>Personal</span>

				<a href="#event<?php echo $i; ?>" class="toggle eventScheduleToggle"> </a>
				<div id="event<?php echo $i; ++$i; ?>" class="eventSchedule">
					<?php 
					if ($e->EventType == 'personal'):
						include "eventSchedule.php";
					endif;
					?>
				</div>
			</div>
			<!-- Eventbar end -->

			<!-- Event content start -->
			<div class="eventContent">
				<div class="eventAvatar">
					<?php echo MainHelper::showImage($e, THUMB_LIST_40x40, false, array('no_img' => 'noimage/no_events_40x40.png')); ?>
				</div>

				<div class="eventHeadline eHead_<?php echo $e->EventType; ?> clearfix">
					<p>
						<?php
						if ($e->EventType != 'personal') {
							echo ContentHelper::articleFeaturedHeadline($e->EventText);
						} else {
							echo $e->EventText;
						}
						?>
					</p>
				</div>
			</div>
			<!-- Event content end -->

			<!-- Event actions start -->
			<div class="cCalendar_actions">
				<?php if ($e->EventType == 'personal'): ?>
					<a class="icon_link eventEdit" rel="<?php echo $e->ID_EVENT; ?>" href="<?php echo $e->EventTime; ?>"><i class="pen_icon"></i><?php echo $this->__("Edit"); ?></a>
				<?php endif; ?>

				<a class="icon_link eventDelete" rel="<?php echo $e->ID_EVENT; ?>" href="<?php echo $e->EventTime; ?>"><i class="trash_icon"></i><?php echo $this->__("Delete"); ?></a>

				<?php if ($e->RecurringEvent != false): ?>
					<a class="icon_link eventDeleteFuture" rel="<?php echo $e->ID_EVENT; ?>" href="<?php echo $e->EventTime; ?>"><i class="trash_icon"></i><?php echo $this->__("Delete all"); ?></a>
				<?php endif; ?>
			</div>
			<!-- Event actions end -->

		<?php endforeach; ?>

		<!-- Event input start -->
		<?php $date = date('m'); ?>
		<form action="#">
			<input type="hidden" name="year" id="evYear" value="<?php echo $data['year']; ?>" />
			<input type="hidden" name="day" id="evDay" value="<?php echo $data['day']; ?>" />
			<input type="hidden" name="month" id="evMonth" value="<?php echo $data['month']; ?>" />

			<div class="eventBar type_personal clearfix">
				<span><?php echo $this->__("Personal"); ?></span>
				<a href="#addEvent" class="toggle eventScheduleToggle"></a>
				<div id="addEvent" class="eventSchedule">
					<?php include "eventSchedule.php"; ?>
				</div>
			</div>

			<label id="eventSymbolCounter" for="eventText"><?php echo $this->__("Symbols left:"); ?> 144</label>
			<textarea rows="2" id="eventText" class="eventInput autoSize" name="eventText"></textarea>
			<input class="eventButton" type="submit" name="submitEvent" value="<?php echo $this->__("Add note"); ?>" />
		</form>
		<!-- Event input end -->

	</div>
	<!-- Box body end -->

</div>
<!-- Eventwrapper end -->

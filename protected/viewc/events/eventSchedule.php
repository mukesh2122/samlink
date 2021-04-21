<!-- Sub box body start -->
<div class="subBoxBody clearfix">

	<!-- Sub box top start -->
	<div class="subBoxTop"></div>
	<!-- Sub box top end -->

	<?php
	$wD = '';
	$mD = '';
	$yD = '';
	if (isset($e)):
		$ID_EVENT = $e->ID_EVENT;
		//@TODO make edit recurrence of personal events possible directly without clicking edit first
		/*
		$recurringEvent 	= $e['RecurringEvent'];
		$recurrenceCount 	= $e['RecurrenceCount'];
		$recurrenceInterval = $e['RecurrenceInterval'];
		$recurrenceEndDate	= $e['RecurrenceEndDate'];
		$recurrenceEndDate 	= date('m/d/Y',$recurrenceEndDate);
		if($recurringEvent){
		if($recurringInterval=='weekly'){		$wD	= 'evScheduleSelect';}
		else if($recurringInterval=='monthly'){	$mD	= 'evScheduleSelect';}
		else if($recurringInterval=='yearly'){	$yD	= 'evScheduleSelect';}
		}else {
		$oD = 'evScheduleSelect';
		}
		*/
		$oD = 'evScheduleSelect';
		$recurringEvent = 0;
		$recurrenceCount = 0;
		$recurrenceInterval = '';
		$recurrenceEndDate = 0;
	else:
		$oD = 'evScheduleSelect';
		$ID_EVENT = '';
		$recurringEvent = 0;
		$recurrenceCount = 0;
		$recurrenceInterval = '';
		$recurrenceEndDate = 0;
	endif;
	?>

	<input class="ID_EVENT" type="hidden" name="ID_EVENT" value="<?php echo $ID_EVENT; ?>" />
	<input class="recurringEvent" type="hidden" name="recurringEvent" value="<?php echo $recurringEvent; ?>" />
	<input class="recurrenceInterval" type="hidden" name="recurrenceInterval" value="<?php echo $recurrenceInterval; ?>" />

	<a class="icon_link setSchedule <?php echo $oD; ?>" href="" rel="off"><i class="wheel_icon"></i><?php echo $this->__("Off"); ?></a>

	<a class="icon_link setSchedule <?php echo $yD; ?>" href="" rel="yearly"><i class="wheel_icon"></i><?php echo $this->__("Set yearly"); ?></a>

	<a class="icon_link setSchedule <?php echo $mD; ?>" href="" rel="monthly"><i class="wheel_icon"></i><?php echo $this->__("Set monthly"); ?></a>

	<a class="icon_link setSchedule <?php echo $wD; ?>" href="" rel="weekly"><i class="wheel_icon"></i><?php echo $this->__("Set weekly"); ?></a>
	
	<label class="setSchedule_label" for="recurrenceCount"><?php echo $this->__("Limit"); ?>:</label>
	<input class="recurrenceCount setSchedule_input" type="text" name="recurrenceCount" value="<?php echo $recurrenceCount; ?>" />

	<label class="setSchedule_label" for="recurrenceEndDate"><?php echo $this->__("End date"); ?>:</label>
	<input class="datepicker recurrenceEndDate setSchedule_input" type="text" name="recurrenceEndDate" value="<?php echo $recurrenceEndDate; ?>" />
</div>
<!-- Sub box body end -->





<?php /*
<!-- Sub box body start -->
<div class="subBoxBody clearfix">

	<!-- Sub box top start -->
	<div class="subBoxTop"></div>
	<!-- Sub box top end -->

	<?php
	$wD = '';
	$mD = '';
	$yD = '';
	if (isset($e)):
		$ID_EVENT = $e->ID_EVENT;
		//@TODO make edit recurrence of personal events possible directly without clicking edit first
		/*
		$recurringEvent 	= $e['RecurringEvent'];
		$recurrenceCount 	= $e['RecurrenceCount'];
		$recurrenceInterval = $e['RecurrenceInterval'];
		$recurrenceEndDate	= $e['RecurrenceEndDate'];
		$recurrenceEndDate 	= date('m/d/Y',$recurrenceEndDate);
		if($recurringEvent){
		if($recurringInterval=='weekly'){		$wD	= 'evScheduleSelect';}
		else if($recurringInterval=='monthly'){	$mD	= 'evScheduleSelect';}
		else if($recurringInterval=='yearly'){	$yD	= 'evScheduleSelect';}
		}else {
		$oD = 'evScheduleSelect';
		}
		
		$oD = 'evScheduleSelect';
		$recurringEvent = 0;
		$recurrenceCount = 0;
		$recurrenceInterval = '';
	$recurrenceEndDate = 0;
	else:
		$oD = 'evScheduleSelect';
		$ID_EVENT = '';
		$recurringEvent = 0;
		$recurrenceCount = 0;
		$recurrenceInterval = '';
		$recurrenceEndDate = 0;
	endif;
	?>

	<input class="ID_EVENT" type="hidden" name="ID_EVENT" value="<?php echo $ID_EVENT; ?>" />
	<input class="recurringEvent" type="hidden" name="recurringEvent" value="<?php echo $recurringEvent; ?>" />
	<input class="recurrenceInterval" type="hidden" name="recurrenceInterval" value="<?php echo $recurrenceInterval; ?>" />
	
	<ul>
		<li>
			<a class="setSchedule <?php echo $oD; ?>" href="" rel="off"><?php echo $this->__("Off"); ?></a>
		</li>
		<li>
			<a class="setSchedule <?php echo $yD; ?>" href="" rel="yearly"><?php echo $this->__("Set yearly"); ?></a>
		</li>
		<li>
			<a class="setSchedule <?php echo $mD; ?>" href="" rel="monthly"><?php echo $this->__("Set monthly"); ?></a>
		</li>
		<li>
			<a class="setSchedule <?php echo $wD; ?>" href="" rel="weekly"><?php echo $this->__("Set weekly"); ?></a>
		</li>
	</ul>

	<label for="recurrenceCount"><?php echo $this->__("Limit"); ?>:</label>
	<input class="recurrenceCount eventInput" type="text" name="recurrenceCount" value="<?php echo $recurrenceCount; ?>" />

	<label for="recurrenceEndDate"><?php echo $this->__("End date"); ?>:</label>
	<input class="datepicker eventInput recurrenceEndDate" type="text" name="recurrenceEndDate" value="<?php echo $recurrenceEndDate; ?>" />

</div>
<!-- Sub box body end -->
*/ ?>
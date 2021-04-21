<?php
	Doo::loadController('SnController');
	$snController = new SnController();

	$ID_PLAYER = $player->ID_PLAYER;
	$calendar   = new Event();
	$monthList = array(0, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
	$timeArr = getdate();
	$data['month'] = $month = sprintf("%02d", $timeArr['mon']);
	$data['day'] = $day = sprintf("%02d", $timeArr['mday']);
	$data['year'] = $year = $timeArr['year'];
	$date =  $month . '/' . $day . '/' . $year;
    $data['events'] = $events = $calendar->getPlayersDayEvents($ID_PLAYER, $year, $month, $day);
	$data['weeks'] = $calendar->getPlayersMonth($ID_PLAYER, $date);
?>

	<!-- Calendar start -->
<div class="widget">
	<div class="F_calendarRight">
		<h3 class="right_column_header"><?php echo $this->__('Calendar'); ?></h3>
		<div id="cMasterWrapper">
			<div id="cWrapper">
				<?php
				$tmpStrTwo = '/' . $day . '/';
				$tmpStr = $tmpStrTwo . $year;
				if ($month == 1) {
					$previousMonth = '12' . $tmpStrTwo . ($year - 1);
					$nextMonth = '02' . $tmpStr;
				} else if ($month == 12) {
					$previousMonth = '11' . $tmpStr;
					$nextMonth = '01' . $tmpStrTwo . ($year + 1);
				} else if ($month == 11) {
					$previousMonth = '10' . $tmpStr;
					$nextMonth = '12' . $tmpStr;
				} else if ($month == 10) {
					$previousMonth = '09' . $tmpStr;
					$nextMonth = '11' . $tmpStr;
				} else if ($month == 9) {
					$previousMonth = '08' . $tmpStr;
					$nextMonth = '10' . $tmpStr;
				} else if ($month < 9) {
					$previousMonth = '0' . ($month - 1) . $tmpStr;
					$nextMonth = '0' . ($month + 1) . $tmpStr;
				}
				$previousYear = $month . $tmpStrTwo . ($year - 1);
				$nextYear = $month . $tmpStrTwo . ($year + 1);
				?>
				<div id="cYear">
					<a href="<?php echo $previousYear; ?>" class="ajaxSetCalendarDate" id="previousYear"></a>
					<label><?php echo $year; ?></label>
					<a href="<?php echo $nextYear; ?>" class="ajaxSetCalendarDate" id="nextYear"></a>
				</div>
				<div id="cMonth">
					<a href="<?php echo $previousMonth; ?>" class="ajaxSetCalendarDate" id="previousMonth"></a>
					<label><?php echo $this->__($monthList[$timeArr['mon']]); ?></label>
					<a href="<?php echo $nextMonth; ?>" class="ajaxSetCalendarDate" id="nextMonth"></a>
				</div>
				<div class="clearfix"></div>
				<div id="cDays">
					<table id="cCalendar">
						<tr>
							<th><label><?php echo $this->__("Mon"); ?></label></th>
							<th><label><?php echo $this->__("Tue"); ?></label></th>
							<th><label><?php echo $this->__("Wed"); ?></label></th>
							<th><label><?php echo $this->__("Thu"); ?></label></th>
							<th><label><?php echo $this->__("Fri"); ?></label></th>
							<th><label class="redTh"><?php echo $this->__("Sat"); ?></label></th>
							<th><label class="redTh"><?php echo $this->__("Sun"); ?></label></th>
						</tr>
                        <?php $weekI = 1;
                        foreach($data['weeks'] as $week): ?>
                            <tr>
                                <?php $dayI = 1;
                                foreach($week as $wday):
                                    $presentDay = '';
                                    $class = 'noEv';
                                    //past
                                    if($wday->when == 'past' && $wday->events == TRUE) {
                                        //past with events
                                        $class = 'evPaE';
                                    } else if($wday->when == 'now') {
                                        if ($wday->events == TRUE) { $class = 'evNoE'; } //now with events
                                        else { $class = 'evNoN'; };
                                        $presentDay = 'evNow';
                                    } else if($wday->when == 'future' && $wday->events == TRUE) {
                                        //future with events
                                        $class = 'evFuE';
                                    };
                                    if($wday->empty): ?>
                                        <td style="width:29px;"></td>
                                    <?php else: ?>
                                        <td class="<?php echo $presentDay; ?> cTd">
                                            <a class="cDay <?php echo $class; ?>" href="<?php echo $dayI; ?>" rel="<?php echo $wday->date; ?>">
                                                <?php echo $wday->day; ?>
                                            </a>
                                            <div class="eventHolder"></div>
                                        </td>
                                    <?php endif;
                                    ++$dayI;
                                endforeach; ?>
                            </tr>
                        <?php ++$weekI;
                        endforeach; ?>
					</table>
				</div>
			</div>
		<?php if(isset($data['msg'])): ?>
		<div id="cMsg">
			<p><?php echo $data['msg']; ?></p>
		</div>
		<?php endif; ?>
		<div id="editEventWrapper"></div>
		</div>
	</div>
</div>
<!-- Calendar end -->
<div class="profile_widget_seperator"></div>

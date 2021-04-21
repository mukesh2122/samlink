<div id="cMasterWrapper">
    <div id="cWrapper">
        <?php
		$month = date('m');
		$day = date('d');
		$year = date('Y');
		
		$data['month'] = $month;
		$data['year'] = $year;
		$data['day'] = $day;
        if ($month == 1) {
            $previousMonth = '12/' . $day . '/' . ($year - 1);
            $nextMonth = '02/' . $day . '/' . $year;
        } else if ($month == 12) {
            $nextMonth = '01/' . $day . '/' . ($year + 1);
            $previousMonth = '11/' . $day . '/' . $year;
        } else if ($month == 11) {
            $previousMonth = '10/' . $day . '/' . $year;
            $nextMonth = '12/' . $day . '/' . $year;
        } else if ($month == 10) {
            $previousMonth = '09/' . $day . '/' . $year;
            $nextMonth = '11/' . $day . '/' . $year;
        } else if ($month == 9) {
            $previousMonth = '08/' . $day . '/' . $year;
            $nextMonth = '10/' . $day . '/' . $year;
        } else if ($month < 9) {
            $previousMonth = '0' . ($month - 1) . '/' . $day . '/' . $year;
            $nextMonth = '0' . ($month + 1) . '/' . $day . '/' . $year;
        }
        //if($month<10){$month = "0$month";}
        $previousYear = $month . '/' . $day . '/' . ($year - 1);
        $nextYear = $month . '/' . $day . '/' . ($year + 1);
        ?>
        <div id="cYear">
            <a href="<?php echo $previousYear; ?>" class="ajaxSetCalendarDate" id="previousYear"></a>
            <label><?php echo date('Y', mktime(1, 1, 1, $data['month'], $data['day'], $data['year'])); ?></label>
            <a href="<?php echo $nextYear; ?>" class="ajaxSetCalendarDate" id="nextYear"></a>
        </div>
        <div id="cMonth">
            <a href="<?php echo $previousMonth; ?>" class="ajaxSetCalendarDate" id="previousMonth"></a>
            <label><?php
        $currentMonth = date('m', mktime(1, 1, 1, $data['month'], $data['day'], $data['year']));
        switch ($currentMonth) {
            case 1: echo $this->__("January");
                break;
            case 2: echo $this->__("February");
                break;
            case 3: echo $this->__("March");
                break;
            case 4: echo $this->__("April");
                break;
            case 5: echo $this->__("May");
                break;
            case 6: echo $this->__("June");
                break;
            case 7: echo $this->__("July");
                break;
            case 8: echo $this->__("August");
                break;
            case 9: echo $this->__("September");
                break;
            case 10: echo $this->__("October");
                break;
            case 11: echo $this->__("November");
                break;
            case 12: echo $this->__("December");
                break;
        }
        ?></label>
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
                <?php
                $weekI = 1;
                foreach ($data['weeks'] as $week) {
                    echo '<tr>';
                    $dayI = 1;
                    foreach ($week as $day) {
                        $presentDay = '';
                        $class = 'noEv';
                        //past
                        if ($day->when == 'past' && $day->events == true) {
                            //past with events
                            $class = 'evPaE';
                        } else if ($day->when == 'now') {
                            if ($day->events == true) {
                                //now with events
                                $class = 'evNoE';
                            } else {
                                $class = 'evNoN';
                            }
                            $presentDay = 'evNow';
                        } else if ($day->when == 'future' && $day->events == true) {
                            //future with events
                            $class = 'evFuE';
                        }
                        if ($day->empty) {
                            echo '<td style="width:29px;"></td>';
                        } else {
                            echo '<td class="' . $presentDay . ' cTd"><a class="cDay ' . $class . '" href="' . $dayI . '" rel="' . $day->date . '">' . $day->day . '</a><div class="eventHolder"></div></td>';
                        }
                        ++$dayI;
                    }
                    echo '</tr>';
                    ++$weekI;
                }
                ?>

            </table>
        </div>
    </div>
</div>
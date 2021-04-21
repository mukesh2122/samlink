<!-- Calendar start -->
<div class="right_column_item">
    <div class="F_calendarRight">
        <h3 class="right_column_header"><?php echo $this->__('Calendar'); ?></h3>
        <div id="cMasterWrapper">
            <div id="cWrapper">
                <?php
                $year = $data['year'];
                $month = $data['month'];
                $previousDay = $nextDay = $day = $data['day'];
                $unixTime = mktime(1, 1, 1, $data['month'], $data['day'], $data['year']);

                if(($month == 1) && ($day > 28)) { $nextDay = 28; }
                else if(($month == 3 || $month == 5 || $month == 8 || $month == 10) && ($day > 30)) { $nextDay = 30; }
                else { $nextDay = $day; };

                if(($month == 3) && ($day > 28)) { $previousDay = 28; }
                else if(($month == 7 || $month == 10 || $month == 12) && ($day > 30)) { $previousDay = 30; }
                else { $previousDay = $day; };

                switch($month) {
                    case 1:
                        $nextMonth = '02/' . $nextDay . '/' . $year;
                        $previousMonth = '12/' . $previousDay . '/' . ($year - 1);
                        break;
                    case 12:
                        $nextMonth = '01/' . $nextDay . '/' . ($year + 1);
                        $previousMonth = '11/' . $previousDay . '/' . $year;
                        break;
                    case 11:
                        $nextMonth = '12/' . $nextDay . '/' . ($year + 1);
                        $previousMonth = '10/' . $previousDay . '/' . $year;
                        break;
                    case 10:
                        $nextMonth = '11/' . $nextDay . '/' . $year;
                        $previousMonth = '09/' . $previousDay . '/' . $year;
                        break;
                    case 9:
                        $nextMonth = '10/' . $nextDay . '/' . $year;
                        $previousMonth = '08/' . $previousDay . '/' . $year;
                        break;
                    case 8:
                    case 7:
                    case 6:
                    case 5:
                    case 4:
                    case 3:
                    case 2:
                        $nextMonth = '0' . ($month + 1) . '/' . $nextDay . '/' . $year;
                        $previousMonth = '0' . ($month - 1) . '/' . $previousDay . '/' . $year;
                        break;
                };
                //if($month<10){$month = "0$month";}
                $previousYear = $month . '/' . $previousDay . '/' . ($year - 1);
                $nextYear = $month . '/' . $nextDay . '/' . ($year + 1);
                ?>
                <div id="cYear">
                    <a href="<?php echo $previousYear; ?>" class="ajaxSetCalendarDate" id="previousYear"></a>
                    <label><?php echo date('Y', $unixTime); ?></label>
                    <a href="<?php echo $nextYear; ?>" class="ajaxSetCalendarDate" id="nextYear"></a>
                </div>
                <div id="cMonth">
                    <a href="<?php echo $previousMonth; ?>" class="ajaxSetCalendarDate" id="previousMonth"></a>
                    <label><?php
                        $currentMonth = date('n', $unixTime);
                        $monthList = array("0",
                            "January",
                            "February",
                            "March",
                            "April",
                            "May",
                            "June",
                            "July",
                            "August",
                            "September",
                            "October",
                            "November",
                            "December");
                        echo $this->__($monthList[$currentMonth]);
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
                        foreach($data['weeks'] as $week) {
                            echo '<tr>';
                            $dayI = 1;
                            foreach($week as $day) {
                                $presentDay = '';
                                $class = 'noEv';
                                //past
                                if($day->when == 'past' && $day->events == TRUE) {
                                    //past with events
                                    $class = 'evPaE';
                                } else if($day->when == 'now') {
                                    $class = ($day->events == TRUE) ? 'evNoE' : 'evNoN';
                                    $presentDay = 'evNow';
                                } else if($day->when == 'future' && $day->events == TRUE) {
                                    //future with events
                                    $class = 'evFuE';
                                };
                                echo ($day->empty) ? '<td style="width:29px;"></td>'
                                    : '<td class="'.$presentDay.' cTd"><a class="cDay '.$class.'" href="'.$dayI.'" rel="'.$day->date.'">'.$day->day.'</a><div class="eventHolder"></div></td>';
                                ++$dayI;
                            };
                            echo '</tr>';
                            ++$weekI;
                        };
                        ?>
                    </table>
                </div>
            </div>
            <?php if(isset($data['msg'])): ?>
                <div id="cMsg"><p><?php echo $data['msg']; ?></p></div>
            <?php endif; ?>
            <div id="editEventWrapper"></div>
        </div>
    </div>
</div>
<!-- Calendar end -->
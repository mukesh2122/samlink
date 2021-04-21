<?php if(!isset($hideTop) or !$hideTop): ?>
	<?php include('common/top.php');?>
<?php endif; ?>
<?php
	$userPlayer = User::getUser();
	$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
	$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
	$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
    $linkMonthAll = MainHelper::site_url('events/'.$type.'/'.$url.'/listtype/all/calendar/month/page/1');
    $linkMonthUpcoming = MainHelper::site_url('events/'.$type.'/'.$url.'/listtype/upcoming/calendar/month/page/1');
    $linkWeekAll = MainHelper::site_url('events/'.$type.'/'.$url.'/listtype/all/calendar/week/page/1');
    $linkWeekUpcoming = MainHelper::site_url('events/'.$type.'/'.$url.'/listtype/upcoming/calendar/week/page/1');
?>

<?php
	echo $this->renderBlock('events/common/search', array(
		'search'	=> isset($search) ? $search : '',
		'searchId'	=> 'search'. ucfirst($type).'EventsForm',
		'total'		=> $total,
		'rel'		=> $url
	));
?>

<?php 
    $thisYear = date("Y");
    $thisMonth = date("F");
    $thisMonthYear = date("F Y");
    $thisWeek = 1;
    //$thisWeek = date("W"); 
    $week1 = ltrim(date($thisWeek),0);
    $lastWeek = $week1-1;
    if($lastWeek == 0)
    {
        $lastWeek = 52;
    }
    $month = date("t");

    $d = date_create();
    $date = date_create($d->format('Y-m-1'))->format('j');
    
    
    //$firstDate = date_create($d->format('Y-m-1'))->format('l');
    $firstWeek = date_create($d->format('Y-m-1'))->format('W');
    
    $week2 = $firstWeek+1; 
     //   $week2 = $date+1;
    $week3 = $firstWeek+2; 
    //    $week3 = $date+2;
    $week4 = $firstWeek+3; 
    //    $week4 = $date+3;
    $week5 = $firstWeek+4; 
    //    $week5 = $date+4;
    $week6 = $firstWeek+5; 
    //    $week6 = $date+5;
    
?>

<?php    
    if(isset($calendar) && $calendar == "week")
    {
?>

<div id="headerCoverInfo">
    <div id="coverImg">&nbsp;</div>
    <div id="headerInfo">
	<h1><?php echo $this->__('All events'); ?></h1>
	<?php if(Auth::isUserLogged() && !$noProfileFunctionality): ?>
		<a class="" href="<?php echo MainHelper::site_url('events/create/'.$type.'/'.$url); ?>"><?php echo $this->__('Create New Event +') ?></a>
<!--		<a class="list_header_button" href="<?php echo MainHelper::site_url('events/create/'.$type.'/'.$url); ?>"><?php echo $this->__('Create New Event +') ?></a> -->
	<?php endif; ?>
</div>
</div>

<div id="comEventsWeekMonth">
    <div class="comEventsSelectedClick">
        <a href="<?php echo $linkWeekUpcoming; ?>" title="View week"><div id="comEventsWeekView1">&nbsp;</div></a>
    </div>
        <a href="<?php echo $linkMonthUpcoming; ?>" title="View month"><div id="comEventsMonthView1">&nbsp;</div></a>
</div>

<div id="comEvents"> 
    <div id="comEventsTop">
        <div id="comEventsTopMonth">
            <p id="prevWeek"><a href="#"><?php echo $lastWeek; ?></a></p>
            <p id="thisWeekMonth"><?php echo "Week ".$week1.", ".$thisMonth." ".$thisYear; ?></p>
            <p id="nextWeek"><a href="#"><?php echo $week1+1; ?></a></p>
        </div>
        <div id="comEventsTopDays">
            <p id="dayWeek">&nbsp;</p>
            <p id="dayMonday">Monday</p>
            <p id="dayTuesday">Tuesday</p>
            <p id="dayWednesday">Wednesday</p>
            <p id="dayThursday">Thursday</p>
            <p id="dayFriday">Friday</p>
            <p id="daySaturday">Saturday</p>
            <p id="daySunday">Sunday</p>
        </div>
    </div>
    
    <div id="comEventsWeek">
        <div class="weekNumberWeek"><?php 
            echo $week1;
        ?></div>
            <div class="comEventsWeekDays">
            <?php
                $weekMonday = date('j', strtotime($thisYear."W".$thisWeek.'1'));
                //echo $weekMonday;
                echo date('j', strtotime('1'))
            ?>
            </div>
            <div class="comEventsWeekDays">
            <?php
                $weekTuesday = date('j', strtotime($thisYear."W".$thisWeek.'2'));
                //echo $weekTuesday;
                echo date('j', strtotime('2'))
            ?>
            </div>
            <div class="comEventsWeekDays">
            <?php
                $weekWednesday = date('j', strtotime($thisYear."W".$thisWeek.'3'));
                //echo $weekWednesday;
                echo date('j', strtotime('3'))
            ?>
            </div>
            <div class="comEventsWeekDays">
            <?php
                $weekThursday = date('j', strtotime($thisYear."W".$thisWeek.'4'));
                //echo $weekThursday;
                echo date('j', strtotime('4'))
            ?>
            </div>
            <div class="comEventsWeekDays">
            <?php
                $weekFriday = date('j', strtotime($thisYear."W".$thisWeek.'5'));
                //echo $weekFriday;
                echo date('j', strtotime('5'))
            ?>
            </div>
            <div class="comEventsWeekDays">
            <?php
                $weekSaturday = date('j', strtotime($thisYear."W".$thisWeek.'6'));
                //echo $weekSaturday;
                echo date('j', strtotime('W'.$thisWeek.'6'));
            ?>
            </div>
            <div class="comEventsWeekDays">
            <?php
                $weekSunday = date('j', strtotime($thisYear."W".$thisWeek.'7'));
                //echo $weekSunday;
                //echo date('j', strtotime('W'.$thisWeek.'7'));
                
                $ugedag = date_create();
                echo date_create($ugedag->format("Y-W-j"))->format('j');
            ?>
            </div>
    </div>
</div>

<div id="comEventsList">
    <div id="comEventsListTop">
        <div id="comEventsListText">List events by:</div>
        <?php
            if(isset($_GET['list']) && $_GET['list'] == "all")
            {
        ?>
            <div class="comEventsListFilter">
                <div class="comEventsListFilterSelector">
                    <div id="comEventsListAll"><a href="<?php echo $linkWeekAll; ?>">All events</a></div>
                </div>
                    <div id="comEventsListUpcoming"><a href="<?php echo $linkWeekUpcoming; ?>">Upcoming</a></div>
            </div>
        </div> <!-- comEventsListText -->
        <?php
            }
            else // isset($_GET['list']) && $_GET['list'] == "all"
            { 
        ?>
            <div class="comEventsListFilter">
                    <div id="comEventsListAll"><a href="<?php echo $linkWeekAll; ?>">All events</a></div>
                <div class="comEventsListFilterSelector">
                    <div id="comEventsListUpcoming"><a href="<?php echo $linkWeekUpcoming; ?>">Upcoming</a></div>
                </div>
            </div>
        </div> <!-- comEventsListText -->
        <?php
            } // else isset($_GET['list']) && $_GET['list'] == "all"
        ?>
    </div> <!-- comEventsListTop -->

<?php
    }
    else // isset($calendar) && $calendar == "week"
    {
?>
<div id="headerCoverInfo">
    <div id="coverImg">&nbsp;</div>
    <div id="headerInfo">
	<h1><?php echo $this->__('All events'); ?></h1>
	<?php if(Auth::isUserLogged() && !$noProfileFunctionality): ?>
		<a class="" href="<?php echo MainHelper::site_url('events/create/'.$type.'/'.$url); ?>"><?php echo $this->__('Create New Event +') ?></a> HACK
<!--		<a class="list_header_button" href="<?php echo MainHelper::site_url('events/create/'.$type.'/'.$url); ?>"><?php echo $this->__('Create New Event +') ?></a> -->
	<?php endif; ?>
</div>
</div>   
    
<div id="comEventsWeekMonth">
        <a href="<?php echo $linkWeekUpcoming; ?>" title="View week"><div id="comEventsWeekView2">&nbsp;</div></a>
    <div class="comEventsSelectedClick">
        <a href="<?php echo $linkMonthUpcoming; ?>" title="View month"><div id="comEventsMonthView2">&nbsp;</div></a>
    </div>
</div>

<div id="comEvents"> 
    <div id="comEventsTop">
        <div id="comEventsTopMonth">
            <p id="prevMonth"><a href="#"><?php echo date('M',strtotime($thisMonthYear.' - 1 month')); ?></a></p>
            <p id="thisMonth"><?php echo $thisMonth." ".$thisYear; ?></p>
            <p id="nextMonth"><a href="#"><?php echo date('M',strtotime($thisMonth.' + 1 month')); ?></a></p>
        </div>
        <div id="comEventsTopDays">
            <p id="dayWeek">&nbsp;</p>
            <p id="dayMonday">Monday</p>
            <p id="dayTuesday">Tuesday</p>
            <p id="dayWednesday">Wednesday</p>
            <p id="dayThursday">Thursday</p>
            <p id="dayFriday">Friday</p>
            <p id="daySaturday">Saturday</p>
            <p id="daySunday">Sunday</p>
        </div>
    </div>
            
    <div id="comEventsMonth">
        <div class="weekNumber"><?php
            $week1 = ltrim(date($firstWeek),0); 
            echo $week1;
        ?></div>
            <div class="comEventsMonthDays">
                
            <?php // MONDAY
                $notMonth = date('m', strtotime($thisYear."W".$firstWeek.'1'));
                if($notMonth != date("m"))
                {
            ?>
                    <p class='notMonth'> 
                        <?php echo date('j', strtotime($thisYear.'W'.$firstWeek.'1')); ?>
                    </p>
            <?php 
                }
                else 
                {
                    echo "<p>".date('j', strtotime($thisYear.'W'.$firstWeek.'1'))."</p>";
                }
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // TUESDAY
                $notMonth = date('m', strtotime($thisYear."W".$firstWeek.'2'));
                if($notMonth != date("m"))
                {
            ?>
                    <p class='notMonth'> 
                        <?php echo date('j', strtotime($thisYear.'W'.$firstWeek.'2')); ?>
                    </p>
            <?php 
                }
                else 
                {
                    echo "<p>".date('j', strtotime($thisYear.'W'.$firstWeek.'2'))."</p>";
                }
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // WEDNESDAY
                $notMonth = date('m', strtotime($thisYear."W".$firstWeek.'3'));
                if($notMonth != date("m"))
                {
            ?>
                    <p class='notMonth'> 
                        <?php echo date('j', strtotime($thisYear.'W'.$firstWeek.'3')); ?>
                    </p>
            <?php 
                }
                else 
                {
                    echo "<p>".date('j', strtotime($thisYear.'W'.$firstWeek.'3'))."</p>";
                }
                 ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // THURSDAY
                $notMonth = date('m', strtotime($thisYear."W".$firstWeek.'4'));
                if($notMonth != date("m"))
                {
            ?>
                    <p class='notMonth'> 
                        <?php echo date('j', strtotime($thisYear.'W'.$firstWeek.'4')); ?>
                    </p>
            <?php 
                }
                else 
                {
                    echo "<p>".date('j', strtotime($thisYear.'W'.$firstWeek.'4'))."</p>";
                }
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // FRIDAY
                $notMonth = date('m', strtotime($thisYear."W".$firstWeek.'5'));
                if($notMonth != date("m"))
                {
            ?>
                    <p class='notMonth'> 
                        <?php echo date('j', strtotime($thisYear.'W'.$firstWeek.'5')); ?>
                    </p>
            <?php 
                }
                else 
                {
                    echo "<p>".date('j', strtotime($thisYear.'W'.$firstWeek.'5'))."</p>";
                }
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // SATURDAY
                $notMonth = date('m', strtotime($thisYear."W".$firstWeek.'6'));
                if($notMonth != date("m"))
                {
            ?>
                    <p class='notMonth'> 
                        <?php echo date('j', strtotime($thisYear.'W'.$firstWeek.'6')); ?>
                    </p>
            <?php 
                }
                else 
                {
                    echo "<p>".date('j', strtotime($thisYear.'W'.$firstWeek.'6'))."</p>";
                }
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // SUNDAY
                $notMonth = date('m', strtotime($thisYear."W".$firstWeek.'7'));
                if($notMonth != date("m"))
                {
            ?>
                    <p class='notMonth'> 
                        <?php echo date('j', strtotime($thisYear.'W'.$firstWeek.'7')); ?>
                    </p>
            <?php 
                }
                else 
                {
                    echo "<p>".date('j', strtotime($thisYear.'W'.$firstWeek.'7'))."</p>";
                }
                ?>
            </div>
            
        <div class="weekNumber"><?php
    
            $firstWeek = date_create($d->format('Y-m-1'))->format('W');
            $week2 = $firstWeek+1; 
     
            echo $week2; ?>
        </div>
            <div class="comEventsMonthDays">
                <?php // MONDAY
                echo date('j', strtotime($thisYear."W".$week2.'1'));
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // TUESDAY
                echo date('j', strtotime($thisYear."W".$week2.'2'));
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // WEDNESDAY
                echo date('j', strtotime($thisYear."W".$week2.'3'));
                 ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // THURSDAY
                echo date('j', strtotime($thisYear."W".$week2.'4'));
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // FRIDAY
                echo date('j', strtotime($thisYear."W".$week2.'5'));
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // SATURDAY
                echo date('j', strtotime($thisYear."W".$week2.'6'));
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // SUNDAY
                echo date('j', strtotime($thisYear."W".$week2.'7'));
                ?>
            </div>
        
        <div class="weekNumber"><?php
            echo $week3; ?>
        </div>
            <div class="comEventsMonthDays">
                <?php // MONDAY
                echo date('j', strtotime($thisYear."W".$week3.'1'));
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // TUESDAY
                echo date('j', strtotime($thisYear."W".$week3.'2'));
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // WEDNESDAY
                echo date('j', strtotime($thisYear."W".$week3.'3'));
                 ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // THURSDAY
                echo date('j', strtotime($thisYear."W".$week3.'4'));
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // FRIDAY
                echo date('j', strtotime($thisYear."W".$week3.'5'));
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // SATURDAY
                echo date('j', strtotime($thisYear."W".$week3.'6'));
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // SUNDAY
                echo date('j', strtotime($thisYear."W".$week3.'7'));
                ?>
            </div>
        
        <div class="weekNumber"><?php 
            echo $week4; ?>            
        </div>
            <div class="comEventsMonthDays">
                <?php // MONDAY
                echo date('j', strtotime($thisYear."W".$week4.'1'));
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // TUESDAY
                echo date('j', strtotime($thisYear."W".$week4.'2'));
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // WEDNESDAY
                echo date('j', strtotime($thisYear."W".$week4.'3'));
                 ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // THURSDAY
                echo date('j', strtotime($thisYear."W".$week4.'4'));
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // FRIDAY
                echo date('j', strtotime($thisYear."W".$week4.'5'));
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // SATURDAY
                echo date('j', strtotime($thisYear."W".$week4.'6'));
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // SUNDAY
                echo date('j', strtotime($thisYear."W".$week4.'7'));
                ?>
            </div>
        
        <div class="weekNumber"><?php
            echo $week5;?>
        </div>
            <div class="comEventsMonthDays">
                <?php // MONDAY
                $notMonth = date('m', strtotime($thisYear."W".$week5.'1'));
                if($notMonth != date("m"))
                {
            ?>
                    <p class='notMonth'> 
                        <?php echo date('j', strtotime($thisYear.'W'.$week5.'1')); ?>
                    </p>
            <?php 
                }
                else 
                {
                    echo "<p>".date('j', strtotime($thisYear.'W'.$week5.'1'))."</p>";
                }
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // TUESDAY
                $notMonth = date('m', strtotime($thisYear."W".$week5.'2'));
                if($notMonth != date("m"))
                {
            ?>
                    <p class='notMonth'> 
                        <?php echo date('j', strtotime($thisYear.'W'.$week5.'2')); ?>
                    </p>
            <?php 
                }
                else 
                {
                    echo "<p>".date('j', strtotime($thisYear.'W'.$week5.'2'))."</p>";
                }
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // WEDNESDAY
                $notMonth = date('m', strtotime($thisYear."W".$week5.'3'));
                if($notMonth != date("m"))
                {
            ?>
                    <p class='notMonth'> 
                        <?php echo date('j', strtotime($thisYear.'W'.$week5.'3')); ?>
                    </p>
            <?php 
                }
                else 
                {
                    echo "<p>".date('j', strtotime($thisYear.'W'.$week5.'3'))."</p>";
                }
                 ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // THURSDAY
                $notMonth = date('m', strtotime($thisYear."W".$week5.'4'));
                if($notMonth != date("m"))
                {
            ?>
                    <p class='notMonth'> 
                        <?php echo date('j', strtotime($thisYear.'W'.$week5.'4')); ?>
                    </p>
            <?php 
                }
                else 
                {
                    echo "<p>".date('j', strtotime($thisYear.'W'.$week5.'4'))."</p>";
                }
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // FRIDAY
                $notMonth = date('m', strtotime($thisYear."W".$week5.'5'));
                if($notMonth != date("m"))
                {
            ?>
                    <p class='notMonth'> 
                        <?php echo date('j', strtotime($thisYear.'W'.$week5.'5')); ?>
                    </p>
            <?php 
                }
                else 
                {
                    echo "<p>".date('j', strtotime($thisYear.'W'.$week5.'5'))."</p>";
                }
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // SATURDAY
                $notMonth = date('m', strtotime($thisYear."W".$week5.'6'));
                if($notMonth != date("m"))
                {
            ?>
                    <p class='notMonth'> 
                        <?php echo date('j', strtotime($thisYear.'W'.$week5.'6')); ?>
                    </p>
            <?php 
                }
                else 
                {
                    echo "<p>".date('j', strtotime($thisYear.'W'.$week5.'6'))."</p>";
                }
                ?>
            </div>
            <div class="comEventsMonthDays">
                <?php // SUNDAY
                $notMonth = date('m', strtotime($thisYear."W".$week5.'7'));
                if($notMonth != date("m"))
                {
            ?>
                    <p class='notMonth'> 
                        <?php echo date('j', strtotime($thisYear.'W'.$week5.'7')); ?>
                    </p>
            <?php 
                }
                else 
                {
                    echo "<p>".date('j', strtotime($thisYear.'W'.$week5.'7'))."</p>";
                }
                ?>
            </div>
        
        <div class="weekNumberLastWeek"><?php
            $lastWeek = $week6;
            if($lastWeek === 53)
            {
                $lastWeek = 1;
            }
            echo $lastWeek;
        ?>
        </div>
            <div class="comEventsMonthDaysLastWeek">
                <?php // MONDAY
                $notMonth = date('m', strtotime($thisYear."W".$week6.'1'));
                if($notMonth != date("m"))
                {
            ?>
                    <p class='notMonth'> 
                        <?php echo date('j', strtotime($thisYear.'W'.$week6.'1')); ?>
                    </p>
            <?php 
                }
                else 
                {
                    echo "<p>".date('j', strtotime($thisYear.'W'.$week6.'1'))."</p>";
                }
                ?>
            </div>
            <div class="comEventsMonthDaysLastWeek">
                <?php // TUESDAY
                $notMonth = date('m', strtotime($thisYear."W".$week6.'2'));
                if($notMonth != date("m"))
                {
            ?>
                    <p class='notMonth'> 
                        <?php echo date('j', strtotime($thisYear.'W'.$week6.'2')); ?>
                    </p>
            <?php 
                }
                else 
                {
                    echo "<p>".date('j', strtotime($thisYear.'W'.$week6.'2'))."</p>";
                }
                ?>
            </div>
            <div class="comEventsMonthDaysLastWeek">
                <?php // WEDNESDAY
                $notMonth = date('m', strtotime($thisYear."W".$week6.'3'));
                if($notMonth != date("m"))
                {
            ?>
                    <p class='notMonth'> 
                        <?php echo date('j', strtotime($thisYear.'W'.$week6.'3')); ?>
                    </p>
            <?php 
                }
                else 
                {
                    echo "<p>".date('j', strtotime($thisYear.'W'.$week6.'3'))."</p>";
                }
                 ?>
            </div>
            <div class="comEventsMonthDaysLastWeek">
                <?php // THURSDAY
                $notMonth = date('m', strtotime($thisYear."W".$week6.'4'));
                if($notMonth != date("m"))
                {
            ?>
                    <p class='notMonth'> 
                        <?php echo date('j', strtotime($thisYear.'W'.$week6.'4')); ?>
                    </p>
            <?php 
                }
                else 
                {
                    echo "<p>".date('j', strtotime($thisYear.'W'.$week6.'4'))."</p>";
                }
                ?>
            </div>
            <div class="comEventsMonthDaysLastWeek">
                <?php // FRIDAY
                $notMonth = date('m', strtotime($thisYear."W".$week6.'5'));
                if($notMonth != date("m"))
                {
            ?>
                    <p class='notMonth'> 
                        <?php echo date('j', strtotime($thisYear.'W'.$week6.'5')); ?>
                    </p>
            <?php 
                }
                else 
                {
                    echo "<p>".date('j', strtotime($thisYear.'W'.$week6.'5'))."</p>";
                }
                ?>
            </div>
            <div class="comEventsMonthDaysLastWeek">
                <?php // SATURDAY
                $notMonth = date('m', strtotime($thisYear."W".$week6.'6'));
                if($notMonth != date("m"))
                {
            ?>
                    <p class='notMonth'> 
                        <?php echo date('j', strtotime($thisYear.'W'.$week6.'6')); ?>
                    </p>
            <?php 
                }
                else 
                {
                    echo "<p>".date('j', strtotime($thisYear.'W'.$week6.'6'))."</p>";
                }
                ?>
            </div>
            <div class="comEventsMonthDaysLastWeek">
                <?php // SUNDAY
                $notMonth = date('m', strtotime($thisYear."W".$week6.'7'));
                if($notMonth != date("m"))
                {
            ?>
                    <p class='notMonth'> 
                        <?php echo date('j', strtotime($thisYear.'W'.$week6.'7')); ?>
                    </p>
            <?php 
                }
                else 
                {
                    echo "<p>".date('j', strtotime($thisYear.'W'.$week6.'7'))."</p>";
                }
                ?>
            </div>
        
    </div>
</div>

<div id="comEventsList">
    <div id="comEventsListTop">
        <div id="comEventsListText">List events by:</div>
        <?php 
            if(isset($_GET['list']) && $_GET['list'] == "all")
            {
        ?>
        <div class="comEventsListFilter">
            <div class="comEventsListFilterSelector">
                <div id="comEventsListAll"><a href="<?php echo $linkMonthAll; ?>">All events</a></div>
            </div>
            <div id="comEventsListUpcoming"><a href="<?php echo $linkMonthUpcoming; ?>">Upcoming</a></div>
        </div>
    </div> <!-- comEventsListTop -->
        <?php
            //}
            }
            else // isset($_GET['list']) && $_GET['list'] == "all"
            {
        ?>
        <div class="comEventsListFilter">
            <div id="comEventsListAll"><a href="<?php echo $linkMonthAll; ?>">All events</a></div>
            <div class="comEventsListFilterSelector">
                <div id="comEventsListUpcoming"><a href="<?php echo $linkMonthUpcoming; ?>">Upcoming</a></div>
            </div>
        </div>
    </div> <!-- comEventsListTop -->    
        <?php
            } // else isset($_GET['list']) && $_GET['list'] == "all"
        ?>
    
<?php 
    } // else isset($calendar) && $calendar == "week" 
?>

<?php if(isset($events) and !empty($events)): ?>
    <?php if(isset($_GET['list']) && $_GET['list'] == "all") {
        $listClass = "comEventsAllEventsList";
    } else {
        $listClass = "comEventsUpcomingEventsList";
    } ?>
    
	<div class="<?php echo $listClass; ?>">
	<?php
	foreach($events as $e) {
		echo $this->renderBlock('common/event', array('event' => $e, 'owner' => false));
	}
	;?>
	</div>

	<?php if(isset($pager) and $pager != '' and isset($pagerObj) and $pagerObj->totalPage > 1): ?>
		<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)) ?>
	<?php endif; ?>

<?php else: ?>

	<p class="noItemsText"><?php echo $this->__('There are no events at this moment'); ?></p>

<?php endif; ?>

</div> <!-- comEventsList -->

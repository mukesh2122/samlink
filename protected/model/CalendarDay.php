<?php
/**
 * NOT ASSOCIATED WITH DB
 *
Subclass of Calendar - Used for managin days and what state they should be
* And in view viewc/events/calendar.php file
**/
class CalendarDay{
	/**
	*	@var string $when Used for defining state ('empty','future','now','past')
	**/
	public $when;
	/**
	*	@var boolean $empty true if no date
	**/
	public $empty;
	/**
	*	@var integer $date UNIX_TIMESTAMP
	**/
	public $date;
	/**
	*	@var integer $day range (01-31)
	**/
	public $day;
	/**
	*	@var boolean $events true if events exist on day
	**/
	public $events;



 	/**
 	*	@param integer $date UNIX_TIMESTAMP - what date to create
 	*	@param integer $now UNIX_TIMESTAMP - which day is the relative now
  	*	@param boolean $events
  	
 	*	@return void
 	**/   
	function __construct($date,$now=false,$events=false){
		if($date==false){
			$this->empty = true;
			$this->when = 'empty';
		}
		else {
			if($date>$now){
				$this->when = 'future';
			}
			else if($date==$now){
				$this->when = 'now';
			}
			else if($date<$now){
				$this->when = 'past';
			}
			else {
				//error
			}
			$this->day 		= date('d',$date);
			$this->empty 	= false;
			$this->date 	= $date;
			$this->events 	= $events;

		}

	}
}
?>

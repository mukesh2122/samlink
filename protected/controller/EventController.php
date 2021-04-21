<?php

/**
  Event Controller Class
 *
 * Used in event calendar
 *
 */
class EventController extends SnController {

	var $event;
	var $data;

	public function beforeRun($resource, $action) {
		parent::beforeRun($resource, $action);

		$this->event = new Event;

		$this->addCrumb($this->__('Events'), MainHelper::site_url('events'));
		$this->data['type'] = !empty($this->params['type']) ? $this->params['type'] : 'game';
		$this->data['user'] = User::getUser();
	}

	public function moduleOff()
	{
		$notAvailable = MainHelper::TrySetModuleNotAvailableByTag('events');
		if ($notAvailable)
		{
			$data['title'] = $this->__('Events');
			$data['body_class'] = 'index_event_index events_page';
			$data['selected_menu'] = 'events';
			$data['left'] = PlayerHelper::playerLeftSide('wall');
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();
			$data['right'] = PlayerHelper::playerRightSide();
			$data['content'] = $notAvailable;
			$this->render3Cols($data);
			exit;
		}
	}
	
	/**
	  function ajaxGetPlayersDay
	 * 	@param integer $time optional UNIX TIMESTAMP of day to get(all seconds off the *day will work)
	 * 	@return void|false on void result get set sent to json
	 * */
	public function ajaxGetPlayersDay($time = false, $debug = false) {
		if (Auth::isUserLogged() === TRUE) {
			if (!$time) {
				if(!MainHelper::validatePostFields(array('time')))
					return false;
				$time = $_POST['time'];
			}
			$yyyy = date('Y', $time);
			$mm = date('m', $time);
			$dd = date('d', $time);

			if ($this->data['user']) {
				$ID_PLAYER = $this->data['user']->ID_PLAYER;
			}

			$calendar = new Event();
			$events = $calendar->getPlayersDayEvents($ID_PLAYER, $yyyy, $mm, $dd);
			$data['events'] = $events;
			$data['month'] = $mm;
			$data['year'] = $yyyy;
			$data['day'] = $dd;
			$this->toJSON(array('content' => $this->renderBlock('events/event', $data)), true);
		} else {
			return false;
		}
	}

	/**
	  function ajaxSetCalendarDate
	 * 	@return void|false on void result get set sent to json
	 * */
	public function ajaxSetCalendarDate($date = false, $msg = false, $debug = false) {
		if (Auth::isUserLogged() === TRUE) {
			$calendar = new Event();

			if ($this->data['user']) {
				$ID_PLAYER = $this->data['user']->ID_PLAYER;
			}
			if ($date == false) {
				if(!MainHelper::validatePostFields(array('date')))
					return false;
				$date = $_POST['date'];
			}
			$day = substr($date, 3, 2);
			$month = substr($date, 0, 2);
			$year = substr($date, 6, 4);

			$events = $calendar->getPlayersDayEvents($ID_PLAYER, $year, $month, $day);
			$data['year'] = $year;
			$data['month'] = $month;
			$data['day'] = $day;
			$data['events'] = $events;
			$data['msg'] = $msg;
			$data['weeks'] = $calendar->getPlayersMonth($ID_PLAYER, $date);

			$this->toJSON(array('content' => $this->renderBlock('events/calendar', $data)), true);
		} else {
			return false;
		}
	}

	/**
	  function ajaxDeleteCalendarNote
	 * 	@return void|false on void result get set sent to json
	 * */
	public function ajaxDeleteCalendarNote() {
		if (Auth::isUserLogged() === TRUE) {
			if(!MainHelper::validatePostFields(array('eventTime', 'ID_EVENT', 'future')))
					return false;
			$calendar = new Event();
			$eventTime = $_POST['eventTime'];
			$ID_EVENT = $_POST['ID_EVENT'];
			$future = $_POST['future'];
			$calendar->deletePlayersEvent($ID_EVENT, $eventTime, $future);
			$time = mktime(0, 0, 0, date('m', $eventTime), date('d', $eventTime), date('Y', $eventTime));
			$date = date('m', $time) . '/' . date('d', $time) . '/' . date('Y', $time);
			$msg = $this->__("Note deleted");

			$this->ajaxSetCalendarDate($date, $msg);
		} else {
			return false;
		}
	}


	/**
	  function ajaxDeleteCalendarNote
	 * 	@return void|false on void result get set sent to json
	 * */
	public function ajaxDeleteEvent() {
		if (!MainHelper::validatePostFields(array('eid')))
			return false;

		$events = new Event();

		$e = $events->getEvent($_POST['eid']);

		if ($e and $e->isAdmin()) {
			$events->removePlayers($e);
			$e->delete();

			$this->toJSON(array('result' => true), true);
		} else {
			return false;
		}
	}

	/**
	  function ajaxAddCalendarNote
	 * 	@return void|false on void result get set sent to json
	 * */
	public function ajaxAddCalendarNote() {
		if (Auth::isUserLogged() === TRUE) {
			$calendar = new Event();

			if ($this->data['user']) {
				$ID_PLAYER = $this->data['user']->ID_PLAYER;
			}

			if(!MainHelper::validatePostFields(
					array('day',
						'month',
						'year',
						'eventText',
						'recurringEvent',
						'recurrenceCount',
						'recurrenceEndDate'))
				)
					return false;

			$user = User::getUser();

			$day = $_POST['day'];
			$month = $_POST['month'];
			$year = $_POST['year'];
			$recurringEvent = $_POST['recurringEvent'];
			$recurrenceInterval = $_POST['recurrenceInterval'];

			if ($recurringEvent) {
				$recurring = $recurrenceInterval;
			} else {
				$recurring = false;
			}

			$date = $month . '/' . $day . '/' . $year;
			//add the note

			$params = array();

			$params['title'] = $_POST['eventText'];
			$params['description'] = $_POST['eventText'];
			$params['location'] = '';
			$params['start'] = mktime(0, 0, 0, $month, $day, $year);
			$params['end'] = mktime(0, 0, 0, $month, ($day + 1), $year) - 1;
			$params['type'] = 'live';
			$params['public'] = 0;
			$params['inviteLevel'] = 'closed';
			$params['invite'] = '';
			$params['recurrance'] = isset($_POST['recurrenceInterval']) ? $_POST['recurrenceInterval'] : 0;
			$params['repeat'] = $_POST['recurrenceCount'];
			$params['repeatDate'] = $_POST['recurrenceEndDate'] != 0 ? strtotime($_POST['recurrenceEndDate']) : 0;
			$params['timezone'] = $user->TimeOffset + $user->DSTOffset;

			$calendar->create_event('', 0, $ID_PLAYER, $params, true);

			//update with the new note
			$time = mktime(0, 0, 0, $month, $day, $year);
			$msg = $this->__("Note added");
			$this->ajaxSetCalendarDate($date, $msg);
		} else {
			return false;
		}
	}

	/**
	  function ajaxEditCalendarNote
	 * 	@return void|false on void result get set sent to json
	 * */
	function ajaxEditCalendarNote($ID_EVENT = false, $eventTime = false) {
		if (Auth::isUserLogged() === TRUE) {
			$calendar = new Event();
			if (!$ID_EVENT) {
				if(!MainHelper::validatePostFields(array('ID_EVENT')))
					return false;
				$ID_EVENT = $_POST['ID_EVENT'];
			}
			if (!$eventTime) {
				if(!MainHelper::validatePostFields(array('eventTime')))
					return false;
				$eventTime = $_POST['eventTime'];
			}
			if ($this->data['user']) {
				$ID_PLAYER = $this->data['user']->ID_PLAYER;
			}
			$e = $calendar->getPlayersDayEvents($ID_PLAYER, '', '', '', $eventTime, $ID_EVENT);
			$data['event'] = $e;
			$data['month'] = date('m', $eventTime);
			$data['day'] = date('d', $eventTime);
			$data['year'] = date('Y', $eventTime);
			$this->toJSON(array('content' => $this->renderBlock('events/eventEdit', $data)), true);
		} else {
			return false;
		}
	}

	/**
	  function ajaxEditNote
	 * 	@return void|false on void result get set sent to json
	 * */
	function ajaxEditNote() {
		if (Auth::isUserLogged() === TRUE) {
			$calendar = new Event();

			if ($this->data['user']) {
				$ID_PLAYER = $this->data['user']->ID_PLAYER;
			}

			if(!MainHelper::validatePostFields(
					array('day',
						'month',
						'year',
						'eventTime',
						'ID_EVENT',
						'eventText',
						'recurringEvent',
						'recurrenceCount',
						'recurrenceEndDate'
					))
			)
					return false;

			$day = $_POST['day'];
			$month = $_POST['month'];
			$year = $_POST['year'];
			$date = $month . '/' . $day . '/' . $year;

			$event = Event::getEvent($_POST['ID_EVENT']);
			if($event){
				$params = array();

				$params['title'] = $_POST['eventText'];
				$params['description'] = $_POST['eventText'];
				$params['start'] = $_POST['eventTime'];
				$params['recurrance'] = isset($_POST['recurrenceInterval']) ? $_POST['recurrenceInterval'] : 0;
				$params['repeat'] = $_POST['recurrenceCount'];
				$params['repeatDate'] = $_POST['recurrenceEndDate'] != 0 ? strtotime($_POST['recurrenceEndDate']) : 0;
				$calendar->edit_event($event, $params, true);
			}
			else
				return false;

			$data['year'] = $year;
			$data['month'] = $month;
			$data['day'] = $day;
			$data['events'] = $calendar->getPlayersDayEvents($ID_PLAYER, $year, $month, $day);
			$data['msg'] = $this->__("Note edited");
			$data['weeks'] = $calendar->getPlayersMonth($ID_PLAYER, $date);

			$this->toJSON(array('content' => $this->renderBlock('events/calendar', $data)), true);
		} else {
			return false;
		}
	}

	public function eventIndex() {
		$this->moduleOff();

		$data['title'] = $this->__('Events');
		$data['body_class'] = 'index_event_index events_page';
		$list['type'] = $this->data['type'];

		$search = isset($this->params['search']) ? $this->params['search'] : '';
		$list['search'] = $search;

		if ($search == '') {
			$eventCount = $this->event->getTotalType($this->data['type']);
			$list['total'] = $eventCount;
			$url = MainHelper::site_url('events/page');
			$pager = $this->appendPagination($list, null, $eventCount, $url, Doo::conf()->eventsLimit);
			$results = $this->event->getIndex($this->data['type'], '', $pager->limit);
		} else {
			$list['search'] = $search;
			$results = $this->event->getIndex($this->data['type'], $search);
			$list['total'] = count($results['results']);
		}

		$list['fields'] = $results['fields'];
		$list['model'] = $results['results'];
		$list['crumb'] = $this->getCrumb();

		$data['selected_menu'] = 'events';
		$data['left'] = PlayerHelper::playerLeftSide('wall');
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['right'] = PlayerHelper::playerRightSide();

		$data['content'] = $this->renderBlock('events/event_index', $list);
		$this->render3Cols($data);
	}

	public function eventsAll() {
		$this->moduleOff();

		$data['title'] = $this->__('All events');
		$data['body_class'] = 'index_event_all events_page';
		$list['type'] = EVENTS_ALL;
		$list['title'] = $this->__('All events');
		$list['searchUrl'] = MainHelper::site_url('events/all/search');
		$list['page'] = 'all';

		$order = isset($this->params['order']) ? $this->params['order'] : '';
		if($order != 'asc' and $order != 'desc') {
			$order = 'dec';
		}

		$this->params['tab'] = isset($this->params['tab']) ? $this->params['tab'] : '';

		if($this->params['tab'] == "") {
			$tabName = 'date';
		} else {
			$tabName = $this->params['tab'];
		}
		if($this->params['tab'] == 'participants') {
			$tab = 2;
		} else {
			$tab = 1;
		}

		$list['tab'] = $tab;
		$list['order'] = $order;

		$search = isset($this->params['search']) ? urldecode($this->params['search']) : null;

		if ($search == '') {
			$url = MainHelper::site_url('events/all/tab/'.$this->params['tab'].'/'.$order.'/page');
		} else {
			$url = MainHelper::site_url('events/all/search/'.  urlencode($search).'/page');
		}
		$eventCount = $this->event->getTotal(true, $search);
		$list['searchText'] = $search;
		$list['searchTotal'] = $eventCount;

		$pager = $this->appendPagination($list, null, $eventCount, $url, Doo::conf()->eventsLimit);
		$results = $this->event->getAll($search, $pager->limit, $tab, $order);

		$list['events'] = $results;

		$data['selected_menu'] = 'events';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['right'] = PlayerHelper::playerRightSide();

		$data['content'] = $this->renderBlock('events/event_all', $list);
		$this->render3Cols($data);
	}

	public function eventsUpcoming() {
		$this->moduleOff();

		$data['title'] = $this->__('Upcoming events');
		$data['body_class'] = 'index_event_all events_page';
		$list['type'] = EVENTS_ALL;
		$list['title'] = $this->__('Upcoming events');
		$list['searchUrl'] = MainHelper::site_url('events/upcoming/search');
		$list['page'] = 'upcoming';

		$order = isset($this->params['order']) ? $this->params['order'] : '';
		if($order != 'asc' and $order != 'desc') {
			$order = 'asc';
		}

		$this->params['tab'] = isset($this->params['tab']) ? $this->params['tab'] : '';

		if($this->params['tab'] == "") {
			$tabName = 'date';
		} else {
			$tabName = $this->params['tab'];
		}
		if($this->params['tab'] == 'participants') {
			$tab = 2;
		} else {
			$tab = 1;
		}

		$list['tab'] = $tab;
		$list['order'] = $order;

		$search = isset($this->params['search']) ? urldecode($this->params['search']) : null;

		if ($search == '') {
			$url = MainHelper::site_url('events/upcoming/tab/'.$this->params['tab'].'/'.$order.'/page');
		} else {
			$url = MainHelper::site_url('events/upcoming/search/'.  urlencode($search).'/page');
		}
		$eventCount = $this->event->getTotalUpcoming(true, $search);
		$list['searchText'] = $search;
		$list['searchTotal'] = $eventCount;

		$pager = $this->appendPagination($list, null, $eventCount, $url, Doo::conf()->eventsLimit);
		$results = $this->event->getUpcoming($search, $pager->limit, $tab, $order);

		$list['events'] = $results;

		$data['selected_menu'] = 'events';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['right'] = PlayerHelper::playerRightSide();

		$data['content'] = $this->renderBlock('events/event_all', $list);
		$this->render3Cols($data);
	}

	public function eventsCurrent() {
		$this->moduleOff();

		$data['title'] = $this->__('Current events');
		$data['body_class'] = 'index_event_all events_page';
		$list['type'] = EVENTS_ALL;
		$list['title'] = $this->__('Current events');
		$list['searchUrl'] = MainHelper::site_url('events/current/search');
		$list['page'] = 'current';

		$order = isset($this->params['order']) ? $this->params['order'] : '';
		if($order != 'asc' and $order != 'desc') {
			$order = 'desc';
		}

		$this->params['tab'] = isset($this->params['tab']) ? $this->params['tab'] : '';

		if($this->params['tab'] == "") {
			$tabName = 'date';
		} else {
			$tabName = $this->params['tab'];
		}
		if($this->params['tab'] == 'participants') {
			$tab = 2;
		} else {
			$tab = 1;
		}

		$list['tab'] = $tab;
		$list['order'] = $order;

		$search = isset($this->params['search']) ? urldecode($this->params['search']) : null;

		if ($search == '') {
			$url = MainHelper::site_url('events/current/tab/'.$this->params['tab'].'/'.$order.'/page');
		} else {
			$url = MainHelper::site_url('events/current/search/'.  urlencode($search).'/page');
		}
		$eventCount = $this->event->getTotalCurrent(true, $search);
		$list['searchText'] = $search;
		$list['searchTotal'] = $eventCount;

		$pager = $this->appendPagination($list, null, $eventCount, $url, Doo::conf()->eventsLimit);
		$results = $this->event->getCurrent($search, $pager->limit, $tab, $order);

		$list['events'] = $results;

		$data['selected_menu'] = 'events';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['right'] = PlayerHelper::playerRightSide();

		$data['content'] = $this->renderBlock('events/event_all', $list);
		$this->render3Cols($data);
	}

	public function events() {
		if(!isset($this->params['id'])) {
			DooUriRouter::redirect(MainHelper::site_url('events'));
			return FALSE;
		}
		switch ($this->data['type']) {
			case WALL_COMPANIES:
				$this->eventsCompanies();
				break;
			case WALL_GAMES:
				$this->eventsGames();
				break;
			case WALL_GROUPS:
				$this->eventsGroups();
				break;
			default:
				DooUriRouter::redirect(MainHelper::site_url('events'));
				return FALSE;
				break;
		}
	}

	private function eventsCompanies() {
		$this->moduleOff();

		$list['allowCreate'] = true;
		$list['page'] = 'event_list';

		$company = $this->getModelByUrl('company', $this->params['id']);
		$name = $company->CompanyName;
		$list['url'] = $this->params['id'];
		$list['model'] = $company;
		$data['body_class'] = 'index_events_list events_page';

		$data['title'] = $name;
		$this->addCrumb($name);

		$list['eventHeader'] = $name . ' ' . $this->__('events');

		$search = isset($this->params['search']) ? $this->params['search'] : '';
		$list['search'] = $search;
		$list['listtype'] = isset($this->params['listtype']) ? $this->params['listtype'] : 'upcoming';
		$list['calendar'] = isset($this->params['calendar']) ? $this->params['calendar'] : 'month';
		$list['pageno'] = isset($this->params['pageno']) ? $this->params['page'] : 1;

		if ($search == '') {
			$eventCount = $this->event->getTotalEvents('company', $company->ID_COMPANY);
			$list['total'] = $eventCount;

			$url = $company->EVENTS_URL . '/listtype/' . $list['listtype'] . '/calendar/' . $list['calendar'] . '/page';
			$pager = $this->appendPagination($list, null, $eventCount, $url, Doo::conf()->eventsLimit);

			$list['events'] = $this->event->getList('company', $company->ID_COMPANY, $search, $list['listtype'], $pager->limit);
		} else {
			$list['events'] = $this->event->getList('company', $company->ID_COMPANY, $search, $list['listtype']);
			$list['total'] = count($list['events']);
		}

		$list['type'] = $this->data['type'];
		$list['ownerId'] = $company->ID_COMPANY;
		$list['crumb'] = $this->getCrumb();

//		$data['selected_menu'] = 'companies';
		$data['left'] = MainHelper::companiesLeftSide($company, 'events');
		$data['right'] = PlayerHelper::playerRightSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$data['content'] = $this->renderBlock('events/' . $list['page'], $list);
		$this->render3Cols($data);
	}

	private function eventsGames() {
		$this->moduleOff();

		$list['allowCreate'] = true;

		$game = $this->getModelByUrl('game', $this->params['id']);

		$name = $game->GameName;
		$list['url'] = $this->params['id'];
		$list['model'] = $game;

		$data['body_class'] = 'index_events_list events_page';

		$data['title'] = $name;

		$search = isset($this->params['search']) ? $this->params['search'] : '';
		$list['search'] = $search;
		$list['listtype'] = isset($this->params['listtype']) ? $this->params['listtype'] : 'upcoming';
		$list['calendar'] = isset($this->params['calendar']) ? $this->params['calendar'] : 'month';
		$list['pageno'] = isset($this->params['pageno']) ? $this->params['page'] : 1;

		if ($search == '') {
			$eventCount = $this->event->getTotalEvents('game', $game->ID_GAME);
			$list['total'] = $eventCount;

			$url = $game->EVENTS_URL . '/listtype/' . $list['listtype'] . '/calendar/' . $list['calendar'] . '/page';
			$pager = $this->appendPagination($list, null, $eventCount, $url, Doo::conf()->eventsLimit);

			$list['events'] = $this->event->getList('game', $game->ID_GAME, $search, $list['listtype'], $pager->limit);
		} else {
			$list['events'] = $this->event->getList('game', $game->ID_GAME, $search, $list['listtype']);
			$list['total'] = count($list['events']);
		}

		$list['type'] = $this->data['type'];
		$list['ownerId'] = $game->ID_GAME;

//		$data['selected_menu'] = 'games';
		$data['left'] = MainHelper::gamesLeftSide($game, 'events');
		$data['right'] = PlayerHelper::playerRightSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$data['content'] = $this->renderBlock('events/event_list', $list);
		$this->render3Cols($data);
	}

	private function eventsGroups() {
		$this->moduleOff();

		$list['page'] = 'event_list';

		$group = $this->getModelByUrl('group', $this->params['id']);
		$name = $group->GameName;
		$list['url'] = $this->params['id'];
		$list['model'] = $group;

		$data['body_class'] = 'index_events_list events_page';

		$data['title'] = $name;

		$list['eventHeader'] = $group->GroupName . ' ' . $this->__('events');

		$isMember = $group->isMember();

		$search = isset($this->params['search']) ? $this->params['search'] : '';
		$list['search'] = $search;
		$list['listtype'] = isset($this->params['listtype']) ? $this->params['listtype'] : 'upcoming';
		$list['calendar'] = isset($this->params['calendar']) ? $this->params['calendar'] : 'month';
		$list['pageno'] = isset($this->params['pageno']) ? $this->params['page'] : 1;

		if ($search == '') {
			//include private events if user is member of the group
			if ($isMember)
				$eventCount = $this->event->getTotalEventsAll('group', $group->ID_GROUP);
			else
				$eventCount = $this->event->getTotalEvents('group', $group->ID_GROUP);

			$list['total'] = $eventCount;
			$url = $group->EVENTS_URL . '/listtype/' . $list['listtype'] . '/calendar/' . $list['calendar'] . '/page';
			$pager = $this->appendPagination($list, null, $eventCount, $url, Doo::conf()->eventsLimit);

			if ($isMember)
				$list['events'] = $this->event->getListAll('group', $group->ID_GROUP, $search, $list['listtype'], $pager->limit);
			else
				$list['events'] = $this->event->getList('group', $group->ID_GROUP, $search, $list['listtype'], $pager->limit);
		}
		else {
			if ($isMember)
				$list['events'] = $this->event->getListAll('group', $group->ID_GROUP, $search, $list['listtype']);
			else
				$list['events'] = $this->event->getList('group', $group->ID_GROUP, $search, $list['listtype']);

			$list['total'] = count($list['events']);
		}

		$list['type'] = $this->data['type'];
		$list['ownerId'] = $group->ID_GROUP;

		if ($group->isAdmin()) {
			$list['allowCreate'] = true;
		} else {
			$list['allowCreate'] = false;
		}

//		$data['selected_menu'] = 'groups';
		$data['left'] = MainHelper::groupsLeftSide($group, 'events');
		$data['right'] = PlayerHelper::playerRightSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$data['content'] = $this->renderBlock('events/' . $list['page'], $list);
		$this->render3Cols($data);
	}

	public function editEvent($error = '', $filled = array()) {
		$this->moduleOff();

		$event = Event::getEvent($this->params['event']);

		if (!$event or !$event->isAdmin())
			DooUriRouter::redirect(Doo::conf()->APP_URL);

		$list['event'] = $event;

		$list['page'] = 'event_edit';

		$data['body_class'] = 'index_events_edit events_page';
		//$name = $model->UNNAME;
		$data['title'] = $this->__('Edit event - '.$event->EventHeadline);
		$list['eventHeader'] = $this->__('Edit event');
		//$this->addCrumb($name, $model->EVENTS_URL);
		//$this->addCrumb($this->__('Create new event'));
		$list['error'] = $error;
		$list['filled'] = $filled;


		//$list['type'] = $this->data['type'];
		//$list['ownerId'] = $model->UNID;
		$list['crumb'] = $this->getCrumb();

		$data['selected_menu'] = 'events';
		$data['left'] = $this->renderBlock('events/common/createEventLeftColumn', array('event' => $event));
		$data['right'] = PlayerHelper::playerRightSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$data['content'] = $this->renderBlock('events/' . $list['page'], $list);
		$this->render3Cols($data);
	}

	private function timeChanged(){
		if(MainHelper::validatePostFields(array('eventDate', 'orgDate', 'dst', 'orgDST', 'timezone', 'orgTimezone', 'endDate', 'orgEndDate'))){
			if($_POST['eventDate'] != $_POST['orgDate'] or $_POST['dst'] != 'orgDST' or $_POST['timezone'] != $_POST['orgTimezone'] or $_POST['endDate'] != $_POST['orgEndDate'])
				return true;
		}

		return false;
	}

	public function editEventAction(){
		$event = Event::getEvent($this->params['event']);

		if ($event and $event->isAdmin()) {
			$params['title'] = ContentHelper::handleContentInput($_POST['eventHeadline']);
			$params['location'] = ContentHelper::handleContentInput($_POST['eventLocation']);
			$params['description'] = ContentHelper::handleContentInput($_POST['eventInfo']);
			$dst = (isset($_POST['dst']) && $_POST['dst'] == 1) ? 3600 : 0;
			$params['timezone'] = ContentHelper::handleContentInput($_POST['timezone']) + $dst;

			$startDate = str_replace('/', '-', $_POST['eventDate']);
			$params['start'] = strtotime($startDate) + $_POST['eventTime'] * 60 - $params['timezone'];
			$params['type'] = $_POST['eventType'];

			if (($params['type'] != EVENT_TYPE_LIVE
					and $params['type'] != EVENT_TYPE_ESPORT)
					or ($params['start'] <= time())
					or (strlen($params['title']) < 3)
			) {

				if ($params['type'] != EVENT_TYPE_LIVE and $params['type'] != EVENT_TYPE_ESPORT) {
					$error = $this->__('Please choose the type of event');
				} elseif ($params['start'] <= time()) {
					$error = $this->__('Event cannot start in the past');
				} elseif (strlen($params['title']) < 3) {
					$error = $this->__('Event title cannot be shorter than 3 symbols');
				}

				$this->editEvent($error, $_POST);
				return;
			}

			if (strlen($_POST['eventEndDate']) > 0) {
				$endDate = str_replace('/', '-', $_POST['eventEndDate']);
				$params['end'] = strtotime($endDate) + $_POST['eventEndTime'] * 60 - $params['timezone'];
			} else {
				$params['end'] = $params['start'] + EVENT_DEFAULT_DURATION;
			}

			if ($params['end'] <= $params['start']) {
				$error = $this->__('End date cannot be before start date');
				$this->editEvent($error, $_POST);
				return;
			}

			$params['recurrance'] = $_POST['eventRecurringType'];
			if ($params['recurrance'] != 0) {
				if ($params['recurrance'] != EVENT_RECURRING_WEEKLY
						or $params['recurrance'] != EVENT_RECURRING_MONTHLY
						or $params['recurrance'] != EVENT_RECURRING_YEARLY
				) {
					$params['recurrance'] = 0;
				}
			}

			if ($params['recurrance'] != 0) {
				$params['repeat'] = $_POST['eventRecurringTimes'];
				if ($params['repeat'] == 0) {
					$params['recurrance'] = 0;
				}
			}

			if (isset($_POST['isPublic']) and $_POST['isPublic'] == 1) {
				$params['public'] = 1;
				$params['inviteLevel'] = 'open';
			} else {
				$params['public'] = 0;
				$params['inviteLevel'] = 'closed';
			}

			if (isset($_POST['isUserInvited']) and $_POST['isUserInvited'] == 1) {
				$params['inviteLevel'] = 'user';
			}

			$this->event->edit_event($event, $params);
		}

		DooUriRouter::redirect($event->EVENT_URL);
	}

	public function createEvent($error = '', $filled = array()) {
		$this->moduleOff();

		$model = $this->getModelByUrl($this->data['type'], $this->params['id']);

		if (!Auth::isUserLogged()) {
			DooUriRouter::redirect(MainHelper::site_url('events/' . $this->data['type'] . '/' . $this->params['id']));
			return;
		}

		if ($this->data['type'] == 'group') {
			$list['group'] = $model;

			if (!$model->isAdmin()) {
				DooUriRouter::redirect($model->EVENTS_URL);
				return;
			}
		}

		$list['page'] = 'event_create';

		$data['body_class'] = 'index_events_create events_page';
		$name = $model->UNNAME;
		$data['title'] = $name;
		$list['eventHeader'] = $this->__('Create new event');
		$this->addCrumb($name, $model->EVENTS_URL);
		$this->addCrumb($this->__('Create new event'));
		$list['error'] = $error;
		$list['filled'] = $filled;

		$list['type'] = $this->data['type'];
		$list['ownerId'] = $model->UNID;
		$list['crumb'] = $this->getCrumb();
		$list['model'] = $model;

		$data['selected_menu'] = 'events';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$data['content'] = $this->renderBlock('events/' . $list['page'], $list);
		$this->render3Cols($data);
	}

	public function createEventAction() {
		$model = $this->getModelByUrl($this->data['type'], $this->params['id']);
		if ($this->data['user'] != false) {
			$params['title'] = ContentHelper::handleContentInput($_POST['eventHeadline']);
			$params['location'] = ContentHelper::handleContentInput($_POST['eventLocation']);
			$params['description'] = ContentHelper::handleContentInput($_POST['eventInfo']);
			$dst = (isset($_POST['dst']) && $_POST['dst'] == 1) ? 3600 : 0;
			$params['timezone'] = ContentHelper::handleContentInput($_POST['timezone']) + $dst;


			$startDate = str_replace('/', '-', $_POST['eventDate']);
			$params['start'] = strtotime($startDate) + $_POST['eventTime'] * 60 - $params['timezone'];
			$params['type'] = $_POST['eventType'];

			if (($params['type'] != EVENT_TYPE_LIVE
					and $params['type'] != EVENT_TYPE_ESPORT)
					or ($params['start'] <= time())
					or (strlen($params['title']) < 3)
			) {

				if ($params['type'] != EVENT_TYPE_LIVE and $params['type'] != EVENT_TYPE_ESPORT) {
					$error = $this->__('Please choose the type of event');
				} elseif ($params['start'] <= time()) {
					$error = $this->__('Event cannot start in the past');
				} elseif (strlen($params['title']) < 3) {
					$error = $this->__('Event title cannot be shorter than 3 symbols');
				}

				$this->createEvent($error, $_POST);
				return;
			}

			if (strlen($_POST['eventEndDate']) > 0) {
				$endDate = str_replace('/', '-', $_POST['eventEndDate']);
				$params['end'] = strtotime($endDate) + $_POST['eventEndTime'] * 60 - $params['timezone'];
			} else {
				$params['end'] = $params['start'] + EVENT_DEFAULT_DURATION;
			}

			if ($params['end'] <= $params['start']) {
				$error = $this->__('End date cannot be before start date');
				$this->createEvent($error, $_POST);
				return;
			}

			$params['recurrance'] = $_POST['eventRecurringType'];
			if ($params['recurrance'] != 0) {
				if ($params['recurrance'] != EVENT_RECURRING_WEEKLY
						or $params['recurrance'] != EVENT_RECURRING_MONTHLY
						or $params['recurrance'] != EVENT_RECURRING_YEARLY
				) {
					$params['recurrance'] = 0;
				}
			}


			if ($params['recurrance'] != 0) {
				$params['repeat'] = $_POST['eventRecurringTimes'];
				if ($params['repeat'] == 0) {
					$params['recurrance'] = 0;
				}
			}

			if (isset($_POST['isPublic']) and $_POST['isPublic'] == 1) {
				$params['public'] = 1;
				$params['inviteLevel'] = 'open';
			} else {
				$params['public'] = 0;
				$params['inviteLevel'] = 'closed';
			}

			if (isset($_POST['isUserInvited']) and $_POST['isUserInvited'] == 1) {
				$params['inviteLevel'] = 'user';
			}


			if (isset($_POST['invitation']) && !empty($_POST['invitation'])) {
				$params['invite'] = implode(',', $_POST['invitation']);
			} else {
				$params['invite'] = '';
			}

			$this->event->create_event($this->data['type'], $model->UNID, $this->data['user']->ID_PLAYER, $params);
		}

		if($model instanceof SnGames)
			DooUriRouter::redirect($model->GAME_URL);
		else
			DooUriRouter::redirect($model->EVENTS_URL);
	}

	public function eventViewInformation() {
		$this->moduleOff();

		if(!isset($this->params['event'])) {
			DooUriRouter::redirect(MainHelper::site_url('events'));
            return FALSE;
		};

		$event = $this->event->getEvent($this->params['event']);

		if(!$event) {
			DooUriRouter::redirect(MainHelper::site_url('events'));
            return FALSE;
		};
		if ($this->data['user']) { $list['user'] = $this->data['user']; };

		$list['type'] = EVENT_INFO;
		$list['topSearch'] = false;
		$list['event'] = $event;
		$list['isAdmin'] = $event->isAdmin();
        $list['isParticipating'] = $event->isParticipating();
        $list['isSubscribed'] = $event->isSubscribed();
		$list['eventHeader'] = $event->EventHeadline;
		$list['selected'] = 'info';

//		$this->addCrumb($event->EventHeadline);
//		$list['crumb'] = $this->getCrumb();
		MainHelper::getWallPosts($list, $event);

		$data['body_class'] = 'index_events_view events_page';
		$data['title'] = $event->EventHeadline;
		$data['selected_menu'] = 'events';
		$data['left'] = $this->renderBlock('events/common/leftColumn', $list);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$data['content'] = $this->renderBlock('events/event_view_information', $list);
		$this->render3Cols($data);
	}

	public function eventViewWall() {
		$this->moduleOff();

		$list['page'] = 'event_wall';
		if ($this->data['user']) {
			$list['user'] = $this->data['user'];
		}
		$data['body_class'] = 'index_event_load events_page';
		$list['type'] = EVENT_WALL;

		$list['event'] = $this->event->getEvent($this->params['event']);
		$list['topSearch'] = false;

		$list['isAdmin'] = $list['event']->isAdmin();
		$list['eventHeader'] = $list['event']->EventHeadline;
		$data['title'] = $list['event']->EventHeadline;
		$list['selected'] = 'wall';

		$this->addCrumb($list['event']->EventHeadline);
		$list['crumb'] = $this->getCrumb();
		MainHelper::getWallPosts($list, $list['event']);

		$data['selected_menu'] = 'events';
		$data['left'] = $this->renderBlock('events/common/' . 'leftColumn', $list);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$data['content'] = $this->renderBlock('events/' . $list['page'], $list);
		$this->render3Cols($data);
	}

	public function eventViewParticipants() {
		$this->moduleOff();

		$list['event'] = $this->event->getEvent($this->params['event']);
		$search = isset($this->params['search']) ? $this->params['search'] : '';
		$list['search'] = $search;
		if($search == ''){
			$participantsCount = $list['event']->ActiveCount;
			$url = $list['event']->EVENT_URL.'/participants/page';
			$pager = $this->appendPagination($list, null, $participantsCount, $url, Doo::conf()->playersLimit);
			$list['players'] = $this->event->getParticipants($this->params['event'], $pager->limit);
			$list['total'] = $participantsCount;
		}
		else{
			$list['players'] = $this->event->getParticipants($this->params['event'], 0, $search);
			$list['total'] = count($list['players']);
		}

		$list['isAdmin'] = $list['event']->isAdmin();
		$list['type'] = EVENT_PARTICIPANTS;


        $data['title'] = $this->__('Participants');
        $data['body_class'] = 'index_players';
		$data['selected_menu'] = 'events';
        $data['left'] = $this->renderBlock('events/common/leftColumn', $list);
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('events/event_participants', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();

        $this->render3Cols($data);
	}

	public function eventViewInvited() {
		$this->moduleOff();

		$list['event'] = $this->event->getEvent($this->params['event']);
		$search = isset($this->params['search']) ? $this->params['search'] : '';
		$list['search'] = $search;
		if($search == ''){
			$invitedCount = $this->event->getTotalInvited($this->params['event']);
			$url = $list['event']->EVENT_URL.'/invited/page';
			$pager = $this->appendPagination($list, null, $invitedCount, $url, Doo::conf()->playersLimit);
			$list['players'] = $this->event->getInvited($this->params['event'], $pager->limit);
			$list['total'] = $invitedCount;
		}
		else{
			$list['players'] = $this->event->getInvited($this->params['event'], 0, $search);
			$list['total'] = count($list['players']);
		}

		$list['isAdmin'] = $list['event']->isAdmin();
		$list['type'] = EVENT_INVITED;


        $data['title'] = $this->__('Invited');
        $data['body_class'] = 'index_players';
		$data['selected_menu'] = 'events';
        $data['left'] = $this->renderBlock('events/common/leftColumn', $list);
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('events/event_invited', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();

        $this->render3Cols($data);
	}

	    /**
     * Crop image
     *
     * @return JSON
     */
    public function ajaxCropPhoto() {
        
        if (!isset($this->params['id']) || !isset($this->params['orientation']) || !isset($this->params['ownertype']))
            return false;

        $c = new Event();
        
        $upload = $c->cropPhoto(
        	intval($this->params['id']),
        	$this->params['orientation'],
        	$this->params['ownertype']
        );

       
        if ($upload['filename'] != '') {
            switch($this->params['orientation'])
            {
                case'portrait':
                $thumb = THUMB_LIST_100x150;
                break;
                case'landscape':
                $thumb = THUMB_LIST_100x75;
                break;
                case'square':
                $thumb = THUMB_LIST_100x100;
                break;
            }

            $file1 = MainHelper::showImage($upload['c'], $thumb, true, array('width', 'no_img' => 'noimage/no_game_100x100.png'));
            
            $jsonArray = array('success' => TRUE, 'img' => $file1);
            if(!isset($_POST)||$_POST == array())
            {
                $jsonArray['img800x600'] = MainHelper::showImage($upload['c'], IMG_800x600, true, array('width', 'no_img' => 'noimage/no_game_800x600.png'));
            }

            echo $this->toJSON($jsonArray);
        } else {
            echo $this->toJSON(array('error' => $upload['error']));
        }
    }


	public function ajaxUploadPhoto() {
		if ($this->data['user']) {
			if (!isset($this->params['id']))
				return false;

			$upload = $this->event->uploadPhoto(intval($this->params['id']), $this->data['user']->ID_PLAYER);

			if ($upload['filename'] != '') {
				$file = MainHelper::showImage($upload['e'], THUMB_LIST_200x300, true, array('no_img' => 'noimage/no_events_200x300.png'));
				echo $this->toJSON(array('success' => TRUE, 'img' => $file));
			} else {
				echo $this->toJSON(array('error' => $upload['error']));
			}
		}
	}

	public function eventSearch() {
		$this->moduleOff();

		if (isset($_POST['search']) && !empty($_POST['search']) && strlen($_POST['search']) > Doo::conf()->eventsSearchMinLength) {
			$data['body_class'] = 'index_event_search events_page';
			if (isset($this->data['type']) and isset($this->params['id'])) {
				$list['page'] = 'event_search';

				$list['events'] = $this->event->search($this->data['type'], $this->params['id'], $_POST['search']);

				$this->addCrumb($this->__($this->event->getItemName($this->data['type'], $this->params['id'])), MainHelper::site_url('events/' . $this->data['type'] . '/' . $this->params['id']));

				$this->addCrumb($_POST['search']);
				$list['ownerId'] = $this->params['id'];
				$list['type'] = $this->data['type'];
			} elseif (isset($this->data['type'])) {
				$results = $this->event->searchIndex($this->data['type'], $_POST['search']);

				$this->addCrumb($_POST['search']);

				$list['page'] = 'event_search_index';
				$list['fields'] = $results['fields'];
				$list['model'] = $results['results'];
			}

			$list['type'] = $this->data['type'];

			$list['crumb'] = $this->getCrumb();

			$data['title'] = $this->__('Search results');

			$data['selected_menu'] = 'events';
			$data['left'] = PlayerHelper::playerLeftSide();
			$data['right'] = PlayerHelper::playerRightSide();
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();

			$data['content'] = $this->renderBlock('events/' . $list['page'], $list);
			$this->render3Cols($data);
		} else {
			$redirect = 'events';

			if (isset($this->data['type']) and !empty($this->data['type'])) {
				$redirect .= '/' . $this->data['type'];
				if (isset($this->params['id']) and !empty($this->params['id'])) {
					$redirect .= '/' . $this->params['id'];
				}
			}
			DooUriRouter::redirect(MainHelper::site_url($redirect));
		}
	}

	public function eventJoin() {
		if ($this->data['user']) {
			$event = $this->event->getEvent($this->params['event']);
			if (Auth::isUserLogged() and $event and ($event->InviteLevel == 'open' or $event->isInvited()) and !$event->isParticipating()) {
				$this->event->join(intval($this->params['event']), $this->data['user']->ID_PLAYER);
			}
		}

		DooUriRouter::redirect(MainHelper::site_url('event/' . $this->params['event']));
	}

	public function ajaxJoinEvent() {
		if ($this->isAjax()) {
			$p = User::getUser();
			if(!MainHelper::validatePostFields(array('eid'))){
				$this->toJSON(array('result' => FALSE), true);
				return;
			}
			$event = $this->event->getEvent(intval($_POST['eid']));
			if ($p and $event and ($event->InviteLevel == 'open' or $event->isInvited()) and !$event->isParticipating()) {
				if ($this->event->join(intval($_POST['eid']), $p->ID_PLAYER) == true) {
					$this->toJSON(array('result' => TRUE), true);
				} else {
					$this->toJSON(array('result' => FALSE), true);
				}
			}
		}
	}

	public function ajaxUnparticipate() {
		if ($this->isAjax() and MainHelper::validatePostFields(array('eid'))) {
			$player = User::getUser();
			if ($player) {
				$result = $this->event->unparticipate($player, $_POST['eid']);
				$this->toJSON(array('result' => $result), true);
			}
		}
	}

	public function getModelByUrl($type, $url) {
		switch ($this->data['type']) {
			case 'game':
				$OwnerType = URL_GAME;
				break;
			case 'company':
				$OwnerType = URL_COMPANY;
				break;
			case 'group':
				$OwnerType = URL_GROUP;
				break;
		}

		$url = Url::getUrlByName($url, $OwnerType);

		if ($url) {
			switch ($this->data['type']) {
				case 'game':
					$model = Games::getGameByID($url->ID_OWNER);
					$name = $model->GameName;
					break;
				case 'company':
					$model = Companies::getCompanyByID($url->ID_OWNER);
					$name = $model->CompanyName;
					break;
				case 'group':
					$model = Groups::getGroupByID($url->ID_OWNER);
					$name = $model->GroupName;
					break;
			}
		} else {
			DooUriRouter::redirect(MainHelper::site_url('events'));
			return false;
		}

		if (isset($model) and $model != false) {
			$model->UNID = $url->ID_OWNER;
			$model->UNNAME = $name;
			return $model;
		} else {
			DooUriRouter::redirect(MainHelper::site_url('events'));
			return false;
		}
	}

	public function ajaxInvitePeople() {
		if ($this->isAjax()) {
			$player = User::getUser();
			if ($player) {
				if(MainHelper::validatePostFields(array('ids', 'event'))){
					$ids = $_POST['ids'];
					$event = $_POST['event'];
					$event = Event::getEvent($event);

					if($event){
						$ids = explode(',', $ids);

						if(!empty($ids)){
							foreach($ids as $id){
								$event->invite($id);
							}
						}
					}

				}
				$result['result'] = true;
				$this->toJSON($result, true);
			}
		}
	}

	public function ajaxInvitePeopleShow() {
		$player = User::getUser();
		$ev = new Event();
		if($player) {
			$list['invite'] = '';
			$event = $ev->getEvent($this->params['event']);
			$friends = array();
			if($event) {
				$friends = $ev->getInvitees($event);
				$list['invite'] = $this->renderBlock('events/ajaxInvitePeople', array('friends' => $friends, 'event' => $event));
			};
			echo $list['invite'];
		};
	}
        
    public function eventViewNews() {
		$this->moduleOff();

		$event = Event::getEvent($this->params['event']);
                $eventURL = MainHelper::site_url('event/'.$event->ID_EVENT);
		$news = new News();
		$p = User::getUser();
		$list = array();

		$list['event'] = $event;
		$list['isAdmin'] = $event->isAdmin();
        if($event->ID_COMPANY>0){
            $ownerType = POSTRERTYPE_COMPANY;
            $list['ownerID'] = $event->ID_COMPANY;
            $list['ownerType'] = COMPANY;
        }
        elseif($event->ID_GAME>0){
            $ownerType = POSTRERTYPE_GAME;
            $list['ownerID'] = $event->ID_GAME;
            $list['ownerType'] = GAME;
        }
        elseif($event->ID_GROUP>0){
            $ownerType = POSTRERTYPE_GROUP;
            $group = Groups::getGroupByID($event->ID_GROUP);
            $list['ownerID'] = $group->ID_GROUP;
            $list['ownerType'] = GROUP;
            $list['languages'] = $group->ID_LANGUAGE;
        }
		$pager = $this->appendPagination($list, $event, $news->getTotalByEvent($event->ID_EVENT), $eventURL . '/news/page');
		$list['newsList'] = $news->getNewsByEvent($event->ID_EVENT, $pager->limit);
                $list['type'] = EVENT_NEWS;

		$data['title'] = $this->__('News') . ' ' . $event->EventHeadline;
		$data['body_class'] = 'event_news';
		$data['selected_menu'] = 'events';
		$data['left'] = $this->renderBlock('events/common/leftColumn', $list);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['content'] = $this->renderBlock('events/newsView', $list);
		$this->render3Cols($data);
	}
        
    public function addEventNews(){
        $event = Event::getEvent($this->params['event']);
        $news = new News();

        if (!$event || $event->isAdmin()===false) {
            DooUriRouter::redirect(MainHelper::site_url('event/'.$event->ID_EVENT));
            return FALSE;
        }
        if (isset($_POST) and !empty($_POST)) {
            $result = $news->saveNews($_POST, 0, 0, 1);
            if ($result instanceof NwItems) {
                $translated = current($result->NwItemLocale);
                $LID = $translated->ID_LANGUAGE;
                DooUriRouter::redirect(MainHelper::site_url('event/'.$_POST['eventID']).'/edit/'.$result->ID_NEWS.'/'.$LID);
                return FALSE;
            } else {
                $list['post'] = $_POST;
            }
        }
        $list['languages'] = Lang::getLanguages();
        if($event->ID_COMPANY>0){
            $list['ownerID'] = $event->ID_COMPANY;
            $list['ownerType'] = COMPANY;
        }
        elseif($event->ID_GAME>0){
            $list['ownerID'] = $event->ID_GAME;
            $list['ownerType'] = GAME;
        }
        elseif($event->ID_GROUP>0){
            $group = Groups::getGroupByID($event->ID_GROUP);
            $list['ownerID'] = $group->ID_GROUP;
            $list['ownerType'] = GROUP;
            $list['languages'] = Lang::getLangById($group->ID_LANGUAGE);
        }
		$list['event'] = $event;
        $list['isAdmin'] = $event->isAdmin();
		$list['CategoryType'] = false;
        $list['function'] = 'add';

		$data['title'] = $this->__('Add News');
		$data['body_class'] = 'add_event_news';
		$data['selected_menu'] = 'events';
		$data['left'] = $this->renderBlock('events/common/leftColumn', $list);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['content'] = $this->renderBlock('events/addEditEventNews', $list);
		$this->render3Cols($data);
    }
        
    public function editEventNews() {
        $event = Event::getEvent($this->params['event']);
        $news = new News();
        $newsItem = $news->getArticleByID($this->params['news_id'], $this->params['lang_id']);

        if (!$event || $event->isAdmin()===false) {
            DooUriRouter::redirect(MainHelper::site_url('event/'.$event->ID_EVENT));
            return FALSE;
        };
        if (isset($_POST) and !empty($_POST)) {
            $result = $news->updateNews($_POST);
            if ($result instanceof NwItems) {
                DooUriRouter::redirect(MainHelper::site_url('event/'.$_POST['eventID']));
                return FALSE;
            } else { $list['post'] = $_POST; };
        }
        $translated = null;
        if(isset($newsItem->NwItemLocale)) { $translated = current($newsItem->NwItemLocale); };
        if (!isset($translated)) {
            DooUriRouter::redirect(MainHelper::site_url('event/'.$event->ID_EVENT.'/news'));
            return FALSE;
        }
        $list['languages'] = Lang::getLanguages();
        if($event->ID_COMPANY>0) {
            $list['ownerID'] = $event->ID_COMPANY;
            $list['ownerType'] = COMPANY;
        } elseif($event->ID_GAME>0) {
            $list['ownerID'] = $event->ID_GAME;
            $list['ownerType'] = GAME;
        } elseif($event->ID_GROUP>0) {
            $group = Groups::getGroupByID($event->ID_GROUP);
            $list['ownerID'] = $group->ID_GROUP;
            $list['ownerType'] = GROUP;
            $list['languages'] = Lang::getLangById($group->ID_LANGUAGE);;
        }
		$list['event'] = $event;
        $list['isAdmin'] = $event->isAdmin();
		$list['CategoryType'] = false;
        $list['function'] = 'edit';
        $list['newsItem'] = $newsItem;
        $list['translated'] = $translated;
        $list['language'] = $this->params['lang_id'];

		$data['title'] = $this->__('Edit News');
		$data['body_class'] = 'edit_event_news';
		$data['selected_menu'] = 'events';
		$data['left'] = $this->renderBlock('events/common/leftColumn', $list);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['content'] = $this->renderBlock('events/addEditEventNews', $list);
		$this->render3Cols($data);
    }
}
?>
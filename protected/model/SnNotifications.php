<?php
Doo::loadCore('db/DooSmartModel');

class SnNotifications extends DooSmartModel{
    public $ID_NOTIFICATION;
    public $ID_PLAYER;
    public $NotificationType;
    public $NotificationTime;
    public $ID_FROM;
    public $FromType;
    public $ID_SECONDARY;
    public $ID_TERTIARY;
    public $ID_QUATERNARY;
    public $LastResetTime;
    public $LastReadTime;
    public $PlayerCount;
    public $isRead;

    public $_table = 'sn_notifications';
    public $_primarykey = 'ID_NOTIFICATION';
    public $_fields = array('ID_NOTIFICATION', 'ID_PLAYER','NotificationType','NotificationTime','ID_FROM', 'FromType', 'ID_SECONDARY','ID_TERTIARY', 'ID_QUATERNARY', 'LastResetTime','LastReadTime', 'PlayerCount', 'isRead');

    /*
    'ReplyMyWall'        Player <Note1> commented on your wall post.
    'PostOnMyWall'        Player <ID_FROM> posted on your wall.
    'ReplyPostMyWall'    Player <Note1> commented the post by <ID_SECONDARY> on your wall.
    'ReplyPostOtherWall'    Player <Note1> commented your post on <ID_SECONDARY>'s wall.
    'ReplyMyReply'        Player <Note1> also commented the post by <ID_SECONDARY>.
    'PublicBySubscribe'    Player <ID_FROM>, whom you subscribe to, has posted a new public post.
    'Like'            Player <Note2> liked your post.
    'Dislike'        Player <Note2> disliked your post.
    'SubscribePlayer'    Player <ID_FROM> is now subscribed to you.
    'FriendRequest'        Player <ID_FROM> has sent you a friend request.
    'FriendReply'        Player <ID_FROM> has accepted your friend request.
    'NewForumPost'        Player <Note3> has posted in topic <ID_TERTIARY>.
    'NewForumTopic'        Player <ID_TERTIARY> has posted a new topic in forum <ID_FROM>.(remember to include FromType when finding forum)
    'CompanyNews'        News from company <ID_FROM>.
    'GameNews'        News from game <ID_FROM>.
    'GroupNews'        News from group <ID_FROM>.
    'NewsReply'        Player <Note4> commented on a news item, you subscribe to
    
    <Note1> the player writing the comment can be found in sn_subnotifications with sn_subnotifications.ID_MAIN = sn_notifications.ID_FROM and with the notification type 'WallReply'
    <Note2> the player liking your post can be found in sn_subnotifications with sn_subnotifications.ID_MAIN = sn_notifications.ID_FROM and with the same notification type and sn_subnotifications.ReplyNumber = sn_notifications.ID_SECONDARY
    <Note3> the player posting the message can be found in sn_subnotifications with sn_subnotifications.ID_MAIN = sn_notifications.ID_FROM, sn_subnotifications.MainType = sn_notifications.FromType, sn_subnotifications.ID_SUB = sn_notifications.ID_SECONDARY and with the same notification type
    <Note4> the player writing the comment can be found in sn_subnotifications with sn_subnotifications.ID_MAIN = sn_notifications.ID_FROM and with the same notification type
    */
    public function getByType() {
        switch ($this->NotificationType) {
            case NOTIFICATION_REPLY_MY_WALL:
                $params = array();
                $ns = new SnNotificationsSub();
                if($this->isRead == 0) {
					$params['Players']['where'] = "{$ns->_table}.ID_MAIN = ? AND {$ns->_table}.NotificationType = 'WallReply' AND {$ns->_table}.ActionTime >= {$this->LastResetTime}";
				} else {
					$params['Players']['where'] = "{$ns->_table}.ID_MAIN = ? AND {$ns->_table}.NotificationType = 'WallReply' AND {$ns->_table}.ActionTime >= {$this->NotificationTime}";
				}
				$params['Players']['param'] = array($this->ID_SECONDARY);
                $params['Players']['joinType'] = 'INNER';
                $params['Players']['match'] = true;
                $return['rel'] = Doo::db()->relateMany('SnNotificationsSub', array('Players'), $params);
				
                $return['post_id'] = $this->ID_SECONDARY;
                return (object)$return; 
                
                break; 
                
            case NOTIFICATION_POST_ON_MY_WALL:
				$return['player'] = User::getById($this->ID_FROM);
                $return['post_id'] = $this->ID_SECONDARY;
                return (object)$return; 
                break;
                
            case NOTIFICATION_REPLY_POST_MY_WALL:
				$params = array();
                $ns = new SnNotificationsSub();
				if($this->isRead == 0) {
					$params['Players']['where'] = "{$ns->_table}.ID_MAIN = ? AND {$ns->_table}.NotificationType = 'WallReply' AND {$ns->_table}.ActionTime >= {$this->LastResetTime}";
				} else {
					$params['Players']['where'] = "{$ns->_table}.ID_MAIN = ? AND {$ns->_table}.NotificationType = 'WallReply' AND {$ns->_table}.ActionTime >= {$this->NotificationTime}";
				}
                $params['Players']['param'] = array($this->ID_SECONDARY);
                $params['Players']['joinType'] = 'INNER';
                $params['Players']['match'] = true;
                $return['rel'] = Doo::db()->relateMany('SnNotificationsSub', array('Players'), $params);
                
				$return['playerPostOwner'] = User::getById($this->ID_TERTIARY);
				$return['post_id'] = $this->ID_SECONDARY;
				return (object)$return; 
                break;
                
            case NOTIFICATION_REPLY_POST_OTHER_WALL:
				$params = array();
                $ns = new SnNotificationsSub();
				if($this->isRead == 0) {
					$params['Players']['where'] = "{$ns->_table}.ID_MAIN = ? AND {$ns->_table}.NotificationType = 'WallReply' AND {$ns->_table}.ActionTime >= {$this->LastResetTime}";
				} else {
					$params['Players']['where'] = "{$ns->_table}.ID_MAIN = ? AND {$ns->_table}.NotificationType = 'WallReply' AND {$ns->_table}.ActionTime >= {$this->NotificationTime}";
				}
                $params['Players']['param'] = array($this->ID_SECONDARY);
                $params['Players']['joinType'] = 'INNER';
                $params['Players']['match'] = true;
                $return['rel'] = Doo::db()->relateMany('SnNotificationsSub', array('Players'), $params);
                
				$return['playerPostOwner'] = User::getById($this->ID_TERTIARY);
				$return['post_id'] = $this->ID_SECONDARY;
				return (object)$return; 
                break;
                
            case NOTIFICATION_REPLY_MY_REPLY:
                $params = array();
                $ns = new SnNotificationsSub();
                if($this->isRead == 0) {
					$params['Players']['where'] = "{$ns->_table}.ID_MAIN = ? AND {$ns->_table}.NotificationType = 'WallReply' AND {$ns->_table}.ActionTime >= {$this->LastResetTime}";
				} else {
					$params['Players']['where'] = "{$ns->_table}.ID_MAIN = ? AND {$ns->_table}.NotificationType = 'WallReply' AND {$ns->_table}.ActionTime >= {$this->NotificationTime}";
				}
                $params['Players']['param'] = array($this->ID_SECONDARY);
                $params['Players']['joinType'] = 'INNER';
                $params['Players']['match'] = true;
                
                $return['rel'] = Doo::db()->relateMany('SnNotificationsSub', array('Players'), $params);
                $return['player'] = User::getById($this->ID_TERTIARY);
                $return['post_id'] = $this->ID_FROM;
                return (object)$return;
                break;
                
            case NOTIFICATION_PUBLIC_BY_SUBSCRIBE:
				$type = new stdClass();
				
				switch ($this->FromType) {
                	case GAME:
						$game = Games::getGameByID($this->ID_FROM);
						$type->Type = $game;
                        $type->TypeName = GAME;
                        $type->Name = $game->GameName;
                        $type->URL = $game->GAME_URL;
                		break;
            		case COMPANY:
						$company = Companies::getCompanyByID($this->ID_FROM);
						$type->Type = $company;
                        $type->TypeName = COMPANY;
                        $type->Name = $company->CompanyName;
                        $type->URL = $company->COMPANY_URL;
                		break;
            		case GROUP:
						$group = Groups::getGroupByID($this->ID_FROM);
						$type->Type = $group;
                        $type->TypeName = GROUP;
                        $type->Name = $group->GroupName;
                        $type->URL = $group->GROUP_URL;
                		break;
					case PLAYER:
						$player = User::getById($this->ID_FROM);
						$type->Type = $player;
                        $type->TypeName = PLAYER;
                        $type->Name = PlayerHelper::showName($player);
                        $type->URL = MainHelper::site_url('player/'.$player->URL);
                		break;
					case EVENT:
						$event = Event::getEvent($this->ID_FROM);
						$type->Type = $event;
                        $type->TypeName = EVENTS;
                        $type->Name = $event->EventHeadline;
                        $type->URL = $event->EVENT_URL;
                		break;
                }
				$return['type'] = $type;
                $return['post_id'] = $this->ID_SECONDARY;
				return (object)$return;
                break;
			
            case NOTIFICATION_LIKE:
                $params = array();
                $ns = new SnNotificationsSub();
                
                $params['Players']['where'] = "{$ns->_table}.ID_MAIN = ? AND {$ns->_table}.NotificationType = 'Like' AND {$ns->_table}.ActionTime > {$this->LastResetTime}";
                $params['Players']['param'] = array($this->ID_SECONDARY);
                $params['Players']['joinType'] = 'INNER';
                $params['Players']['match'] = true;
                
                $return['rel'] = Doo::db()->relateMany('SnNotificationsSub', array('Players'), $params);
                $return['post_id'] = $this->ID_SECONDARY;
				
                return (object)$return;
                
                break;
			
            case NOTIFICATION_DISLIKE:
                $params = array();
                $ns = new SnNotificationsSub();
                 
                $params['Players']['where'] = "{$ns->_table}.ID_MAIN = ? AND {$ns->_table}.NotificationType = 'Dislike' AND {$ns->_table}.ActionTime > {$this->LastResetTime}";
                $params['Players']['param'] = array($this->ID_SECONDARY);
                $params['Players']['joinType'] = 'INNER';
                $params['Players']['match'] = true;
                
                $return['rel'] = Doo::db()->relateMany('SnNotificationsSub', array('Players'), $params);
                $return['post_id'] = $this->ID_SECONDARY;
                return (object)$return;
                break;  
                
            case NOTIFICATION_SUBSCRIBE_PLAYER:
			case NOTIFICATION_FRIEND_REQUEST:
            case NOTIFICATION_FRIEND_REPLY:
                return User::getById($this->ID_FROM);;
                break; 
                
            case NOTIFICATION_NEW_FORUM_POST:
                $ns = new SnNotificationsSub();
                 
				if($this->isRead == 0) {
					$params['Players']['where'] = "{$ns->_table}.ID_MAIN = ? AND {$ns->_table}.MainType = ? AND {$ns->_table}.NotificationType = 'NewForumPost' AND {$ns->_table}.ActionTime >= {$this->LastResetTime}";
				} else {
					$params['Players']['where'] = "{$ns->_table}.ID_MAIN = ? AND {$ns->_table}.MainType = ? AND {$ns->_table}.NotificationType = 'NewForumPost' AND {$ns->_table}.ActionTime >= {$this->NotificationTime}";
				}
				
//                $params['Players']['where'] = "{$ns->_table}.ID_MAIN = ? AND {$ns->_table}.MainType = ? AND {$ns->_table}.NotificationType = 'NewForumPost' AND {$ns->_table}.ActionTime > {$this->LastResetTime}";
                $params['Players']['param'] = array($this->ID_FROM, $this->FromType);
                $params['Players']['joinType'] = 'INNER';
                $params['Players']['match'] = true;
                
                $board = new FmBoards();
				$board->ID_OWNER = $this->ID_FROM;
                $board->OwnerType = $this->FromType;
                $board->ID_BOARD = $this->ID_TERTIARY;
                $board = $board->getOne();
                
                $type = new stdClass();
                switch ($this->FromType) {
                	case GAME:
						$game = Games::getGameByID($this->ID_FROM);
                        $type->Name = $game->GameName;
                        $type->URL = $game->GAME_URL;
                		break;
            		case COMPANY:
						$company = Companies::getCompanyByID($this->ID_FROM);
                        $type->Name = $company->CompanyName;
                        $type->URL = $company->COMPANY_URL;
                		break;
            		case GROUP:
						$group = Groups::getGroupByID($this->ID_FROM);
                        $type->Name = $group->GroupName;
                        $type->URL = $group->GROUP_URL;
                		break;
                }
                
                
                $topic = new FmTopics();
				$topic->ID_OWNER = $this->ID_FROM;
                $topic->OwnerType = $this->FromType;
                $topic->ID_TOPIC = $this->ID_SECONDARY;
                $topic = $topic->getOne();
                
                $return['rel'] = Doo::db()->relateMany('SnNotificationsSub', array('Players'), $params);
                $return['board'] = $board;
                $return['type'] = $type;
                $return['topic'] = $topic;
                return (object)$return;
                break;
                
            case NOTIFICATION_NEW_FORUM_TOPIC:
                $board = new FmBoards();
                $board->ID_OWNER = $this->ID_FROM;
                $board->OwnerType = $this->FromType;
                $board->ID_BOARD = $this->ID_QUATERNARY;
                $board = $board->getOne();
				
                $topic = new FmTopics();
				$topic->ID_OWNER = $this->ID_FROM;
                $topic->OwnerType = $this->FromType;
                $topic->ID_TOPIC = $this->ID_SECONDARY;
                $topic = $topic->getOne();
                
                $type = new stdClass();
                switch ($this->FromType) {
                	case GAME:
						$game = Games::getGameByID($this->ID_FROM);
                        $type->Name = $game->GameName;
                        $type->URL = $game->GAME_URL;
                		break;
            		case COMPANY:
                		$company = Companies::getCompanyByID($this->ID_FROM);
                        $type->Name = $company->CompanyName;
                        $type->URL = $company->COMPANY_URL;
                		break;
            		case GROUP:
                		$group = Groups::getGroupByID($this->ID_FROM);
                        $type->Name = $group->GroupName;
                        $type->URL = $group->GROUP_URL;
                		break;
                }
                
                $return['player'] = User::getById($this->ID_TERTIARY);
                $return['topic'] = $topic;
                $return['board'] = $board;
                $return['type'] = $type;
                return (object)$return;
                break;
                
            case NOTIFICATION_COMPANY_NEWS:
                $newsitem = new NwItems();
                $newsitem->ID_NEWS = $this->ID_SECONDARY;
                $newsitem = $newsitem->getOne();
                
                $return['company'] = Companies::getCompanyByID($this->ID_FROM);;
                $return['newsitem'] = $newsitem;
                return (object)$return;
                break;
                
            case NOTIFICATION_GAME_NEWS:
                $game = Games::getGameByID($this->ID_FROM);
                
                $newsitem = new NwItems();
                $newsitem->ID_NEWS = $this->ID_SECONDARY;
                $newsitem = $newsitem->getOne();
                
                $return['game'] = $game;
                $return['newsitem'] = $newsitem;
                return (object)$return;
                break;
                
            case NOTIFICATION_GROUP_NEWS:
                $return['group'] = Groups::getGroupByID($this->ID_FROM);;
                return (object)$return;
                break;
                
            case NOTIFICATION_NEWS_REPLY:
                $params = array();
                $ns = new SnNotificationsSub();
                $newsitem = new NwItems();
                $newsitem->ID_NEWS = $this->ID_FROM;
                $newsitem = $newsitem->getOne();
                if($this->isRead == 0) {
					$params['Players']['where'] = "{$ns->_table}.ID_MAIN = ? AND {$ns->_table}.NotificationType = 'NewsReply' AND {$ns->_table}.ActionTime >= {$this->LastResetTime}";
				} else {
					$params['Players']['where'] = "{$ns->_table}.ID_MAIN = ? AND {$ns->_table}.NotificationType = 'NewsReply' AND {$ns->_table}.ActionTime >= {$this->NotificationTime}";
				}
                $params['Players']['param'] = array($this->ID_FROM);
                $params['Players']['joinType'] = 'INNER';
                $params['Players']['match'] = true;
                
                $return['rel'] = Doo::db()->relateMany('SnNotificationsSub', array('Players'), $params);
                $return['newsitem'] = $newsitem;
                
                return (object)$return;
                break;
            
            case NOTIFICATION_GROUP_APPLICATION:
            case NOTIFICATION_GROUP_INVITE:
                $return['group'] = Groups::getGroupByID($this->ID_SECONDARY);
                $return['player'] = User::getById($this->ID_FROM);
                return (object)$return;
                break;
            case NOTIFICATION_ACHIEVEMENT:
                $return['achievement'] = Achievement::getLevelByID($this->ID_FROM);
                $return['branch'] = Achievement::getBranchByLevelID($this->ID_FROM);
                return (object)$return;
                break;
            case NOTIFICATION_ESPORT:
                $return['team'] = Esport::getTeamByID($this->ID_SECONDARY);
                $return['player'] = User::getById($this->ID_FROM);
                return (object)$return;
                break;
            case NOTIFICATION_RAID_INVITE:
                $return["type"] = $tmptype = $this->FromType;
                if($tmptype === "group") { $return["group"] = Groups::getGroupByID($this->ID_FROM); }
                else if($tmptype === "player") { $return["player"] = User::getById($this->ID_FROM); };
                $return["raid"] = $this->ID_SECONDARY;
                return (object)$return;
                break;
        }
    }
    
    public function markAsRead() {
        $this->isRead = 1;
        $this->update(array('field' => 'isRead'));
        $this->purgeCache();
    }
    
}
?>
<?php
class ChatSession {
    public static $TheGet;
    public static function Getter() { return self::$TheGet; }

    public function __construct($tmpInput) {
        self::$TheGet = $tmpInput;
        define('FORCE_CHAT_UPDATE', true); //for testing
        define('_SECONDS', 1);
        define('_MINUTES', 60 * _SECONDS);
        define('_HOURS', 60 * _MINUTES);
        define('_DAYS', 24 * _HOURS);
        define('USER_TIMEOUT', 30 * _SECONDS);
        define('OLDEST_MESSAGES', 3 * _DAYS);
        if(Auth::isUserLogged()) { // no need to run all this if nobody is logged on
            $extraInfo = array(); // Add whatever you want to send to the client (gets updated on every pageload)
            if(!isset($_SESSION['chat']) || FORCE_CHAT_UPDATE) {
                $_SESSION['chat'] = array(
                    'url'           => Doo::conf()->APP_URL,
                    'id'            => User::getUser()->ID_PLAYER,
                    'nickName'      => User::getUser()->DisplayName,
                    'userTimeout'   => 30, // timeout in seconds
                    'extraStatic'   => array(), // Add static extra info
                    'extraInfo'     => $extraInfo
                );
            };
            if(count($extraInfo)) { $_SESSION['chat']['extraInfo'] = $extraInfo; };
        };
    }
}

class BottomChat {
    public function __construct() {}
    public function __destruct() {}

    private $conversationId	= null;

    public $Me				= null;
    public $Conversations	= null;
    public $Friends			= null;
    public $State			= null;
    public static $OnlineCount = null;

    public function CreateConversationWith($participants) {
        $this->conversationId = ChatConversation::CreateFromParticipants(explode(',',$participants));
    }

    public function UpdateInfo($Id, $Since = null) {
        $this->Me = ChatUser::GetFromId($Id);
        if(is_null($Since)) { $this->Me = ChatUser::GetFromId($Id); };
        $this->Friends = self::getFriendsOf($Id, $Since);
        $this->Conversations = ChatConversation::GetMyConversations($Id, $Since);
    }

    public function setState($info) { $this->State = $info; }

    public function getAsDataPacket() {
        $result = array();
        $ConversationCount = count($this->Conversations);
        if($ConversationCount > 0) {
            $Temp = array();
            for($i = 0; $i < $ConversationCount; ++$i) {
                $tmpID = $this->Conversations[$i]->Id;
                $tmpConv = new ChatConversation($tmpID);
                $Data = $tmpConv->getAsDataPacket();
                if(Count($Data)) { $Temp[] = $Data; };
            };
            if(count($Temp)) { $result['Conversations'] = $Temp; };
        };
        if(!is_null($this->Me)) { $result['Me'] = $this->Me; };
        if(!is_null($this->State)) { $result['State'] = $this->State; };
        if(!is_null($this->Friends)) { $result['Friends'] = $this->Friends; };
        if(!is_null($this->conversationId)) { $result['conversationId'] = $this->conversationId; };
        if(!is_null(self::$OnlineCount)) { $result['OnlineCount'] = self::$OnlineCount; };
        $userTable = ChatUser::GetUserTable();
        if(count($userTable)) { $result['usertable'] = $userTable; };
        $result['requestTime'] = ChatTime::Now();
        return json_encode($result);
    }

    public static function getFriendsOf($UserId, $Since) {
        $tmpSince = $Since;
        $tmpID = $UserId;
        $friendModel = new SnFriendsRel();
        $Opts = array(
            "limit" => 100,
            "param" => array($tmpID),
            "where" => "{$friendModel->_table}.Mutual = 1 AND {$friendModel->_table}.ID_PLAYER = ?",
            "select" => "ID_FRIEND as id",
            "asArray" => TRUE,
        );
        $Friends = $friendModel->find($Opts);
        $offliners = array();
        $onliners = array();
        for($i = 0, $iEnd = count($Friends); $i < $iEnd; ++$i) {
            $FriendId = $Friends[$i]['id'];
            $User = ChatUser::GetFromId($FriendId);
            if(is_null($tmpSince)) {
                if($User->online == 1) { $onliners[] = $User; }
                else { $offliners[] = $User; };
            } else if($User->lastSeen > $tmpSince) {
                if($User->online == 1) { $onliners[] = $User; }
                else { $offliners[] = $User; };
            };
        };
        self::$OnlineCount = count($onliners);
        $Result = array_merge_recursive($onliners,$offliners);
        return $Result;
    }
}

class ChatUser {
    private static $userCache = null; // lets not look up the same user more than once pr page load ;)

    public $lastSeen;
    public $id;
    public $name;
    public $avatar;
    public $online;

//    private function getThumb($imgname) {
//        if(strlen(trim($imgname)) > 0) {
//            $filename = 'global/pub_img/players/' . $imgname[1] . '/' . $imgname[2] . '/' . $imgname;
//            if(is_readable($filename)) { return $filename; };
//        };
//        return 'global/img/noimage/no_player_40x40.png';
//    }

    public function __construct($id) {
        $tmpID = htmlspecialchars($id);
        if(is_null(self::$userCache)) { self::$userCache = array(); };
        $user = isset(self::$userCache[$tmpID]) ? self::$userCache[$tmpID] : null;
        if(!isset($user)) {
            $userModel = new Players();
            $Opts = array(
                "limit" => 1,
                "param" => array($tmpID),
                "where" => "{$userModel->_table}.ID_PLAYER = ?",
                "select" => "LastActivity as lastSeen, ID_PLAYER as id, DisplayName as name, isOnline as online, Avatar",
            );
            $user = $userModel->find($Opts);
        };
        if($user) {
            $tmp = MainHelper::showImage($user, THUMB_LIST_40x40, TRUE);
            $this->lastSeen = $user->lastSeen;
            $this->id		= $user->id;
            $this->name		= $user->name;
            $this->online   = $user->online;
            $this->avatar   = empty($tmp) ? MainHelper::showImage(null, THUMB_LIST_40x40, TRUE, array('both', 'no_img' => 'noimage/no_player_40x40.png')) : $tmp;
            self::$userCache[$this->id] = $user;
        };
    }

    public function sendMessage($ConversationId, $Message) {
        $tmpMessage = $Message;
        $tmpConvID = $ConversationId;
        $msg = serialize(array(
            'type'	=> 'chat',
            'content' => htmlspecialchars($tmpMessage),
            'description' => ''
        ));
        $MsgModel = new MeMessages();
        $MsgAttrs = array(
            "ID_CONVERSATION"   => htmlspecialchars($tmpConvID),
            "ID_PLAYER"         => htmlspecialchars($this->id),
            "DisplayName"       => htmlspecialchars($this->name),
            "Avatar"            => "",
            "MessageText"       => $msg,
            "MessageTime"       => 0,
            "isShared"          => 0,
            "ID_SHAREOWNER"     => 0,
            "ShareOwnerType"    => "",
        );
        $MsgModel->insertAttributes($MsgAttrs);
    }

    public function AddToConversation($ConversationId) {
        $tmpConvID = $ConversationId;
        $ParticModel = new MeParticipants();
        $ParticAttrs = array(
            "ID_PLAYER"         => htmlspecialchars($this->id),
            "ID_CONVERSATION"   => htmlspecialchars($tmpConvID),
        );
        $ParticModel->insertAttributes($ParticAttrs);
    }

    public function updateTimestamp() {
        $myID = htmlspecialchars($this->id);
        $userModel = new Players();
        $Opts = array(
            "limit" => 1,
            "param" => array($myID),
            "where" => "{$userModel->_table}.ID_PLAYER = ?",
        );
        $time = ChatTime::Now();
        $result = $userModel->updateAttributes(array("LastActivity" => $time), $Opts);
        return $result;
    }

    public function Get() {
        return array(
            'lastSeen'	=> $this->lastSeen,
            'id'		=> $this->id,
            'name'		=> $this->name,
            'avatar'    => $this->avatar,
            'online'    => $this->online
        );
    }

    public function isOnline() { return $this->lastSeen + USER_TIMEOUT > time(); }

    public static function GetFromId($Id) { return new self($Id); }

    public static function GetUserTable() {
        $result = array();
        if(!is_null(self::$userCache)) { foreach(self::$userCache as $user) { $result[$user->id] = $user->name; }; };
        return $result;
    }
}

class ChatParticipant { // must be owned by a Conversation
    private function __construct($user, $lastUpdate) {
        $this->user			= $user;
        $this->lastUpdate	= $lastUpdate;
    }

    private $user_id;

    public $user;
    public $lastUpdate; // when did the user last read in on this conversation

    public function Get() {
        return array(
            'user'			=> ChatUser::GetFromId($this->user_id)->Get(),
            'lastUpdate'	=> $this->lastUpdate
        );
    }

    public static function getParticipants($conversation_id, $Since) {
        $tmpSince = htmlspecialchars($Since);
        $tmpConvID = htmlspecialchars($conversation_id);
        $particModel = new MeParticipants();
        if(is_null($Since)) {
            $Opts =array(
                "limit" => 50,
                "param" => array($tmpConvID),
                "where" => "{$particModel->_table}.ID_CONVERSATION = ?",
                "select" => "ID_PLAYER, LastReadTime",
                "asArray" => TRUE,
            );
            $Participants = $particModel->find($Opts);
        }
        else {
            $query = "SELECT p.ID_PLAYER, p.LastReadTime
                      FROM me_participants as p, sn_players as o
                      WHERE o.LastActivity > {$tmpSince}
                      AND p.ID_CONVERSATION = {$tmpConvID}
                      LIMIT 50";
            $tmpquer = Doo::db()->query($query);
            $Participants = $tmpquer->fetchAll();
        };
        $result = array();
        for($i = 0, $iEnd = count($Participants); $i < $iEnd; ++$i) {
            $user = ChatUser::GetFromId($Participants[$i]['ID_PLAYER']);
            if(is_null($Since) || $user->lastSeen > $Since) { $result[] = new self($user, $Participants[$i]['LastReadTime']); };
        };
        return $result;
    }

    public static function updateReadTime($ConversationId, $UserId) {
        $tmpID = htmlspecialchars($UserId);
        $tmpConvID = htmlspecialchars($ConversationId);
        $particModel = new MeParticipants();
        $Opts = array(
            "limit" => 1,
            "param" => array($tmpID, $tmpConvID),
            "where" => "{$particModel->_table}.ID_PLAYER = ? AND {$particModel->_table}.ID_CONVERSATION = ?",
        );
        $particModel->updateAttributes(array("LastReadTime" => ChatTime::Now()), $Opts);
    }
}

class ChatMessage { // must belong to a conversation
    public $owner_id;
    public $id;
    public $text;
    public $time;
    public static $Input;

    private function __construct(Array $Message) {
        $this->owner_id = $Message['owner_id'];
        $msg 			= (object) unserialize($Message['text']);
        $this->text		= $msg->content;
        $this->time		= $Message['time'];
        $this->id		= $Message['id'];
        self::$Input    = ChatSession::Getter();
    }

    public static function GetMessages($ConversationId, $Since = NULL) {
        $tmpSince = is_null($Since) ? NULL : htmlspecialchars($Since);
        $tmpConvID = htmlspecialchars($ConversationId);
        $tmpLastMsg = (isset(self::$Input['lastMessageId'])) ? htmlspecialchars(self::$Input['lastMessageId']) : NULL;
        $oldest = is_null($tmpSince) ? " AND MessageTime > (UNIX_TIMESTAMP(UTC_TIMESTAMP()) - " . OLDEST_MESSAGES . ")" : " AND MessageTime > {$tmpSince}";
        if(isset($tmpLastMsg)) { $oldest = " AND ID_MESSAGE >" . $tmpLastMsg; };
        $query = "SELECT ID_MESSAGE as id, ID_PLAYER as owner_id, MessageText as text, MessageTime as time
                  FROM me_messages
                  WHERE ID_CONVERSATION = {$tmpConvID}" . $oldest . "
                  ORDER BY time DESC
                  LIMIT 50";
        $tmpQuer = Doo::db()->query($query);
        $Messages = $tmpQuer->fetchAll();
        $result = array();
        for($i = 0, $iEnd = count($Messages); $i < $iEnd; ++$i) {
            $Msg = (object) unserialize($Messages[$i]['text']);
            if($Msg->type == 'chat') { $result[] = new self($Messages[$i]); };
        };
        return array_reverse($result);
    }
}

class ChatConversation {
    public function __construct($ConversationId, $Since = null) {
        $this->Id			= $ConversationId;
        $this->participants = ChatParticipant::getParticipants($ConversationId, $Since);
        $this->messages 	= ChatMessage::GetMessages($ConversationId, $Since);
    }

    private $messages;

    public $Id;
    public $participants;

    public function getAsDataPacket() {
        $MessageCount		= count($this->messages);
        $ParticipantCount	= count($this->participants);
        $result				= null; // default
        if($MessageCount || $ParticipantCount) { // Something has changed
            $result				= array();
            $result['id']		= $this->Id;
            if($MessageCount) { $result['Messages'] = $this->messages; };
            if($ParticipantCount) { $result['Participants'] = $this->participants; };
        };
        return $result;
    }

    public static function CreateFromParticipants($Participants = array()) { // or get
        $allParticipants = $Participants;
        $allParticipants[] = $_SESSION['chat']['id']; // Make sure that the caller is part of the conversation
        $allParticipants = array_unique($allParticipants); // we use array_unique cuz we just added the caller without checking if he's there..
        natsort($allParticipants); // sort to fix key
        $iEnd = count($allParticipants);
        $ConversationId = NULL;
        $convModel = new MeConversations();
        $convModel->Participants = implode(',', $allParticipants);
        $convModel->ParticipantCount = $iEnd;

        $ConversationExists = $convModel->getOne();

        if(!empty($ConversationExists)) { $ConversationId = $ConversationExists->ID_CONVERSATION; }
        else {
            $Attrs = array(
                'Participants' => implode(',', $allParticipants),
                'ParticipantCount' => $iEnd,
                'MessageCount'  => 0,
                'LastMessageTime' => 0,
            );
            $ConversationId = $convModel->insertAttributes($Attrs);
            for($i = 0; $i < $iEnd; ++$i) { ChatUser::GetFromId($allParticipants[$i])->AddToConversation($ConversationId); };
        };
        return $ConversationId;
    }

    public static function GetMyConversations($Id, $Since) {
        $tmpID = $Id;
        $tmpSince = $Since;
        $particModel = new MeParticipants();
        $table = $particModel->_table;
        $Opts = array(
            "asc"   => "LastReadTime",
            "param" => array($tmpID),
            "where" => "{$table}.ID_PLAYER = ?",
            "select" => "ID_CONVERSATION",
            "asArray" => TRUE,
        );
        $ConversationIds = $particModel->find($Opts);
        $result = array();
        for($i = 0, $iEnd = count($ConversationIds); $i < $iEnd; ++$i) { $result[] = new self($ConversationIds[$i]['ID_CONVERSATION'], $tmpSince); };
        return $result;
    }
}

class ChatTime {
    public static function Now() {
        $query = "SELECT UNIX_TIMESTAMP(UTC_TIMESTAMP()) as now";
        $result = Doo::db()->query($query);
        $tmpNow = $result->fetchAll();
        return $tmpNow[0]["now"];
    }
    public static function getDays($days) { return self::getHours($days * 24); }
    public static function getHours($hours) { return self::getMinutes($hours * 60); }
    public static function getMinutes($minutes) { return $minutes * 60; }
    public static function hoursAgo($hours) { return self::Now() - self::getHours(6); }
}
?>
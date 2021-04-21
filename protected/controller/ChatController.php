<?php
class ChatController extends SnController {

    public function beforeRun($resource, $action) {
		parent::beforeRun($resource, $action);
	}

    public function index() {
        if(!isset($_SESSION)) { session_start(); };
        $input = filter_input_array(INPUT_GET);
        if(!isset($input)) { echo('No GET data!'); return FALSE; };
        $chatSession = new ChatSession($input);
        if(!isset($_SESSION['chat'])) { echo('User not logged in!'); return FALSE; };
        $action = $input['action'];
        if(!isset($action)) { echo('No action defined!'); return FALSE; };
        $Since = isset($input['since']) ? $input['since'] : NULL;
        $chat = new BottomChat();
        $tmpcurrentUser = $_SESSION['chat']['id'];
        $currentUser = ChatUser::GetFromId($tmpcurrentUser);
        $currentUser->updateTimestamp();
        switch($action) {
            case 'periodicUpdate':
                break;
            case 'sendMessage':
                ChatParticipant::updateReadTime($input['conversationId'], $tmpcurrentUser);
                if(strlen(trim($input['text']))>0) { $currentUser->sendMessage($input['conversationId'], $input['text']); }; // dont save empty strings plz
                break;
            case 'CreateConversationWith': // TODO:: smid lige en participant update her!
                $chat->CreateConversationWith($input['participants']);
                break;
            case 'setState':
                $_SESSION['lastState'] = $input['state']; // todo: secure this
                if($input['state']['openConversation'] === 'true') { ChatParticipant::updateReadTime($input['state']['conversationId'], $tmpcurrentUser); };
                break;
            case 'firstUpdate':
                if(isset($_SESSION['lastState'])) { $chat->setState($_SESSION['lastState']); };
                break;
        };
        $chat->UpdateInfo($tmpcurrentUser, NULL); // disabling 'since' because LastActivity is also badly updated
        echo $chat->getAsDataPacket();
        return TRUE;
    }
}
?>
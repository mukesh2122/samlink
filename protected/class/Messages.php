<?php

class Messages {

	// Converter begin !!

	/**
	 * Returns all old personal messages (only used in converter)
	 *
	 * @return FmPersonalMessages list
	 */
	public function getAllOldMessages()
	{
		$messages = new FmPersonalMessages();
		$orderBy = "ID_PM";

		$query = "SELECT 
					{$messages->_table}.*
				FROM
					`{$messages->_table}`
				ORDER BY {$orderBy}";

		$rs = Doo::db()->query($query);
		$personalMessages = $rs->fetchAll(PDO::FETCH_CLASS, 'FmPersonalMessages');

		return $personalMessages;
	}

	/**
	 * Returns all old personal message recipients (only used in converter)
	 *
	 * @return FmPersonalMessagesRecipients list
	 */
	public function getOldRecipients($messageID)
	{
		$recipients = new FmPersonalMessagesRecipients();

		$where = "WHERE ID_PM = " . $messageID;
		$query = "SELECT 
					{$recipients->_table}.*
				FROM
					`{$recipients->_table}`" .
				$where;

		$rs = Doo::db()->query($query);
		$list = $rs->fetchAll(PDO::FETCH_CLASS, 'FmPersonalMessagesRecipients');

		return $list;
	}

	// Converter end !!


	/**
	 * Returns Count of conversations
	 *
	 * @return number of conversations for player
	 */
	public function getConversationCount($playerID = 0)
	{
		if ($playerID == 0)
		{
			$player = User::getUser();
			$playerID = $player->ID_PLAYER;
		}
		$part = new MeParticipants();

		$params['select'] = "COUNT(*) as total";
		$params['limit'] = 1;
		$params['where'] = "{$part->_table}.ID_PLAYER = ?";
		$params['param'] = array($playerID);
		$results = Doo::db()->find('MeParticipants', $params);
		return $results->total;
	}

	/**
	 * Returns List of conversations
	 *
	 * @return MeConversations list
	 */
	public function getConversations($limit = 0)
	{
		$player = User::getUser();
		$conv = new MeConversations();
		$part = new MeParticipants();

		$params['select'] = "{$conv->_table}.*, {$part->_table}.LastReadTime, {$part->_table}.NewMessageCount";
//		$params['desc'] = "{$conv->_table}.LastMessageTime";
		$params['filters'][] = array('model' => "MeParticipants",
			'joinType' => "INNER",
			'where' => "{$part->_table}.ID_PLAYER = ?",
			'param' => array($player->ID_PLAYER));
		if($limit) {
			$params['limit'] = $limit;
		}
		
		$conversations = Doo::db()->find("MeConversations", $params);
		return $conversations;
	}

	/**
	 * @param array of player ids
	 *
	 * Finds the corresponding conversation based on the participants
	 * If no conversation is found, a new one is created
	 * In addition records are created in me_participants
	 *
	 * Returns conversation item
	 *
	 * @return MeConversations object
	 */
	public static function getConversation($participantsArray)
	{
//		$participantsArray = explode(',', $participantsList);
		sort($participantsArray);
		$participantsList = implode(',', $participantsArray);

		$item = Doo::db()->getOne('MeConversations', array(
			'limit' => 1,
			'where' => 'Participants = ?',
			'param' => array($participantsList)
		));

		if (!isset($item) || $item == '')
		{
			$item = new MeConversations();
			$item->Participants = $participantsList;
			$item->ParticipantCount = count($participantsArray);
			$item->ID_CONVERSATION = $item->insert();

			$participant = new MeParticipants();
			$participant->ID_CONVERSATION = $item->ID_CONVERSATION;
			foreach ($participantsArray as $p)
			{
				$participant->ID_PLAYER = (int)$p;
				$participant->insert();
			}
		}

		return $item;
	}

	public function getConversationMessageCount($conversationID = 0)
	{
		if($conversationID > 0)
		{
			$messages = new MeMessages();

			$params['select'] = "COUNT(1) as total";
			$params['where'] = "{$messages->_table}.ID_CONVERSATION = ?";
			$params['param'] = array($conversationID);
			$params['limit'] = 1;

			$total = Doo::db()->find("MeMessages", $params);
			return $total->total;
		}
		else
		{
			return 0;
		}
	}

	public function getConversationMessages($conversationID, $limit = 0)
	{
		$player = User::getUser();
		if($conversationID > 0)
		{
			$mess = new MeMessages();
//			$part = new MeParticipants();
			$p = new Players();

			$params['select'] = "{$mess->_table}.*, {$p->_table}.URL";
			$params['desc'] = "{$mess->_table}.MessageTime";
			$params['where'] = "{$mess->_table}.ID_CONVERSATION = ?";
			$params['param'] = array($conversationID);
			$params['filters'][] = array('model' => "Players", 'joinType' => "INNER");
			if($limit)
				$params['limit'] = $limit;
			
			$messages = Doo::db()->find("MeMessages", $params);
			return $messages;
		}
	}

	public function sendMessage($conversationID, $messageText, $share = false)
	{
		$player = User::getUser();
		if (!empty($conversationID) and $player)
		{
			$isShared = 0;
			$shareType = '';
			$shareId = 0;
			if($share === false)
				$messageText = ContentHelper::managePostEnter(ContentHelper::handleContentInput($messageText));
			else
			{
				$messageText = ContentHelper::manageShareEnter($messageText, $share['otype'], $share['oid'], $share['olang']);
				$isShared = 1;
				$shareType = $share['otype'];
				$shareId = $share['oid'];
			}
			$message = new MeMessages();
			$message->ID_CONVERSATION = $conversationID;
			$message->ID_PLAYER = $player->ID_PLAYER;
			$message->MessageText = $messageText->content;
			$message->isShared = $isShared;
			$message->ID_SHAREOWNER = $shareId;
			$message->ShareOwnerType = $shareType;
			$message->ID_MESSAGE = $message->insert();
			$player->purgeCache();

			$part = new MeParticipants();
			$part->ID_CONVERSATION = $conversationID;
			$participants = $part->find();
			foreach ($participants as $participant)
			{
				if ($participant->ID_PLAYER == $player->ID_PLAYER)
				{
					$player->MessageSentCount += 1;
					$player->update();

					$participant->LastReadTime = time();
					$participant->update(array(
						'fields' => 'NewMessageCount',
						'where' => 'ID_CONVERSATION = ? AND ID_PLAYER = ?',
						'param' => array($conversationID, $player->ID_PLAYER)
					));
				}
				else
				{
					$p = new Players();
					$p->ID_PLAYER = $participant->ID_PLAYER;
					$p = $p->getOne();
					$p->MessageCount += 1;
					$p->NewMessageCount += 1;
					$p->update();

					$participant->NewMessageCount += 1;
					$participant->update(array(
						'fields' => 'NewMessageCount',
						'where' => 'ID_CONVERSATION = ? AND ID_PLAYER = ?',
						'param' => array($conversationID, $p->ID_PLAYER)
					));
				}
			}

			return TRUE;
		}
		return false;
	}

	/**
	 * Sends message to recipients
	 *
	 * @return boolean
	 */
	public function sendNewMessage($recipients, $message, $share = false)
	{
		$player = User::getUser();

		if (!empty($recipients))
		{
			$friends = array($player->ID_PLAYER);
			foreach ($recipients as $url)
			{
				$friend = User::getFriend($url);
				if ($friend)
					$friends[] = $friend->ID_PLAYER;
			}
			if (count($friends) > 1)
			{
				$conversation = $this->GetConversation($friends);
				if ($conversation)
					$retVal = $this->sendMessage($conversation->ID_CONVERSATION, $message, $share);
			}
			else
				return FALSE;
		}
		else
			return FALSE;
		return TRUE;
	}

}
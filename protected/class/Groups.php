<?php

class Groups {

    /**
     * Returns all group list
     *
     * @return SnGroups list
     */
    public function getAllGroups($limit) {
		$list = Doo::db()->find('SnGroups', array(
			'limit' => $limit,
			'asc' => 'GroupName'
		));

        return $list;
    }
    public function getAllRecentGroups($limit) {
		$list = Doo::db()->find('SnGroups', array(
			'limit' => $limit,
			'desc' => 'ID_GROUP'
		));

        return $list;
    }

	public function getLargestGroups($limit) {
		$pgr = new SnPlayerGroupRel();
		$p = User::getUser();
		$g = new SnGroups();
		if($p){
			$list = Doo::db()->find('SnGroups', array(
				'limit' => $limit,
				'desc' => 'MemberCount',
				'where' => "{$g->_table}.ID_GROUP NOT IN (SELECT {$pgr->_table}.ID_GROUP FROM {$pgr->_table} WHERE {$pgr->_table}.ID_PLAYER = ?)",
				'param' => array($p->ID_PLAYER)
			));

			return $list;
		}
    }

    /**
     * Returns players groups that he's member of
     * @param Players $player
     * @param string $limit
     * @return SnGroups
     */
    public function getPlayerGroups(Players $player, $limit = 0) {
        $params = array();
        $group = new SnGroups;
        $groupRel = new SnPlayerGroupRel;
        $params['limit'] = $limit;
        $params['select'] = "{$group->_table}.*, {$groupRel->_table}.isSubscribed, {$groupRel->_table}.isAdmin, {$groupRel->_table}.hasApplied";

        $params['filters'][] =  array('model' => "SnPlayerGroupRel",
            'joinType' => 'INNER',
            'where' => "{$groupRel->_table}.isSubscribed = 1 AND {$groupRel->_table}.ID_PLAYER = ?",
            'param' => array($player->ID_PLAYER)
        );

        $groups = Doo::db()->find('SnGroups', $params);
        return $groups;
    }

    /**
     * Returns all group list
     *
     * @return SnGroups list
     */
    public function getSearchPlayerGroups($phrase, $player = null, $limit = null) {
        $group = new SnGroups;
		$groupRel = new SnPlayerGroupRel;
		$list = array();
		if($player == null)
			$player = User::getUser();

		if (strlen($phrase) > 2 and $player) {
			$params = array(
                'asc' => "{$group->_table}.GroupName",
                'where' => "{$group->_table}.GroupName LIKE ?",
                'param' => array('%'. $phrase . '%')
            );

			if($limit !== null){
				$params['limit'] = $limit;
			}

			$params['filters'][] =  array('model' => "SnPlayerGroupRel",
				'joinType' => 'INNER',
				'where' => "{$groupRel->_table}.isSubscribed = 1 AND {$groupRel->_table}.ID_PLAYER = ?",
				'param' => array($player->ID_PLAYER)
			);
            $list = Doo::db()->find('SnGroups', $params);
        }

        return $list;
    }

    /**
     * Returns all group list
     *
     * @return SnGroups list
     */
    public function getSearchGroups($phrase) {
        if (strlen($phrase) > 2) {
            $list = Doo::db()->find('SnGroups', array(
                'limit' => 10,
                'asc' => 'GroupName',
                'where' => 'GroupName LIKE ?',
                'param' => array('%'. $phrase . '%')
            ));
        }

        return $list;
    }

    /**
     * Returns group item
     *
     * @return SnGroups object
     */
    public static function getGroupByID($id) {
        if (Doo::conf()->cache_enabled == TRUE) {
            $currentDBconf = Doo::db()->getDefaultDbConfig();
            $cacheKey = md5(CACHE_GROUP."_{$id}_".$currentDBconf[0]."_".$currentDBconf[1]."_".Cache::getVersion(CACHE_GROUP.$id));

            if (Doo::cache('apc')->get($cacheKey)) {
                return Doo::cache('apc')->get($cacheKey);
            }
        }

        $item = Doo::db()->getOne('SnGroups', array(
            'limit' => 1,
            'where' => 'ID_GROUP = ?',
            'param' => array($id)
        ));

        if (Doo::conf()->cache_enabled == TRUE) {
            Doo::cache('apc')->set($cacheKey, $item, Doo::conf()->GROUP_LIFETIME);
        }

        return $item;
    }

    /**
     * Returns amount of groups
     *
     * @return int
     */
    public function getTotal() {
        $nc = new SnGroups();
		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $nc->_table . '` LIMIT 1');
        return $totalNum->cnt;
    }

    /**
     * Returns amount of player groups
     *
     * @return int
     */
    public function getTotalPlayerGroups(Players $player, $phrase = '') {
        $groupRel = new SnPlayerGroupRel;

        $params =  array(
            'select' => 'COUNT(1) as cnt',
            'where' => "{$groupRel->_table}.isSubscribed = 1 AND {$groupRel->_table}.ID_PLAYER = ?",
            'param' => array($player->ID_PLAYER),
			'limit' => 1
        );

		if(strlen($phrase) > 2) {
			$params['where'] .= ' AND GroupName LIKE ?';
			$params['param'][] = '%'.$phrase.'%';
		}
        $totalNum = Doo::db()->find('SnPlayerGroupRel', $params);
        return $totalNum->cnt;
    }

    /**
     * Returns group members related with SnPlayerGroupRel
     *
     * @return SnPlayer
     */
    public function getMembers(SnGroups $group, $limit = 0) {
        $cgr = new SnPlayerGroupRel();
        $params = array();

        $params = array('model' => "SnPlayerGroupRel",
            'joinType' => 'INNER',
            'match' => TRUE,
            'where' => "{$cgr->_table}.ID_GROUP = ? AND isMember = 1".MainHelper::getSuspendQuery("sn_playergroup_rel.ID_PLAYER"),
            'param' => array($group->ID_GROUP),

        );

        $params['limit'] = $limit;
        $params['asc'] = 'FirstName';
        $members = Doo::db()->relate('Players', 'SnPlayerGroupRel', $params);

        return $members;
    }

    /**
     * Returns number of members
     *
     * @return SnPlayer
     */
    public function getTotalMembers(SnGroups $group) {
      
        $cgr = new SnPlayerGroupRel();
        $params = array();
        $params['limit'] = 1;
        $params['select'] = 'COUNT(1) as total';

        $params['filters'][] = array('model' => "SnPlayerGroupRel",
            'joinType' => 'INNER',
            'where' => "{$cgr->_table}.ID_GROUP = ? AND isMember = 1".MainHelper::getSuspendQuery("sn_playergroup_rel.ID_PLAYER"),
            'param' => array($group->ID_GROUP)
        );
        
     
        $total = Doo::db()->find('Players', $params);
        return $total->total; 

        
    }

    /**
     * Returns group members related with SnPlayerGroupRel
     *
     * @return SnPlayer
     */
    public function getInvitedMembers(SnGroups $group, $limit = 0) {
        $cgr = new SnPlayerGroupRel();
        $params = array();

        $params = array('model' => "SnPlayerGroupRel",
            'joinType' => 'INNER',
            'match' => TRUE,
            'where' => "{$cgr->_table}.ID_GROUP = ? AND isInvited = 1".MainHelper::getSuspendQuery("sn_playergroup_rel.ID_PLAYER"),
            'param' => array($group->ID_GROUP),

        );

        $params['limit'] = $limit;
        $params['asc'] = 'FirstName';

        $members = Doo::db()->relate('Players', 'SnPlayerGroupRel', $params);

        return $members;
    }

    /**
     * Returns number of members
     *
     * @return SnPlayer
     */
    public function getTotalInvitedMembers(SnGroups $group) {
        $cgr = new SnPlayerGroupRel();
        $params = array();
        $params['limit'] = 1;
        $params['select'] = 'COUNT(1) as total';

        $params['filters'][] = array('model' => "SnPlayerGroupRel",
            'joinType' => 'INNER',
            'where' => "{$cgr->_table}.ID_GROUP = ? AND isInvited = 1".MainHelper::getSuspendQuery("sn_playergroup_rel.ID_PLAYER"),
            'param' => array($group->ID_GROUP)
        );

        $total = Doo::db()->find('Players', $params);
        return $total->total;
    }

    /**
     * Returns group members related with SnPlayerGroupRel
     *
     * @return SnPlayer
     */
    public function getApplicantMembers(SnGroups $group, $limit = 0) {
        $cgr = new SnPlayerGroupRel();
        $params = array();

        $params = array('model' => "SnPlayerGroupRel",
            'joinType' => 'INNER',
            'match' => TRUE,
            'where' => "{$cgr->_table}.ID_GROUP = ? AND hasApplied = 1".MainHelper::getSuspendQuery("sn_playergroup_rel.ID_PLAYER"),
            'param' => array($group->ID_GROUP),
        );

        $params['limit'] = $limit;
        $params['asc'] = 'FirstName';

        $members = Doo::db()->relate('Players', 'SnPlayerGroupRel', $params);

        return $members;
    }

    /**
     * Returns number of members
     *
     * @return SnPlayer
     */
    public function getTotalApplicantMembers(SnGroups $group) {
        $cgr = new SnPlayerGroupRel();
        $params = array();
        $params['limit'] = 1;
        $params['select'] = 'COUNT(1) as total';

        $params['filters'][] = array('model' => "SnPlayerGroupRel",
            'joinType' => 'INNER',
            'where' => "{$cgr->_table}.ID_GROUP = ? AND hasApplied = 1".MainHelper::getSuspendQuery("sn_playergroup_rel.ID_PLAYER"),
            'param' => array($group->ID_GROUP)
        );

        $total = Doo::db()->find('Players', $params);
        return $total->total;
    }

    /**
     * Deletes member from group, ONLY admin can do that, do check in controller
     * @param SnGroups $group
     * @param int $memberID
     * @return boolean
     */
    public function deleteMember(SnGroups $group, $memberID) {
        $memberID = intval($memberID);
        if($memberID > 0) {
            $pgr = new SnPlayerGroupRel();
            $pgr->ID_GROUP = $group->ID_GROUP;
            $pgr->ID_PLAYER = $memberID;
            $pgr->delete();
            return true;
        }
        return false;
    }

    /**
     * Invitation done by group admin to multiple players
     * @param SnGroups $group
     * @param array $post
     * @return boolean
     */
    public function inviteMembers(SnGroups $group, $post) {
        if(!empty($post)) {

            $playersURL = explode("|", $post['player_id']);
            $admin = User::getUser();

            if($admin and !empty($playersURL)) {
                foreach($playersURL as $url) {
                    $player = User::getFriend($url);
                    if($player) {
                        $pgr = new SnPlayerGroupRel();
                        $pgr->ID_PLAYER = $player->ID_PLAYER;
                        $pgr->ID_GROUP = $group->ID_GROUP;
                        $result = $pgr->getOne();

                        if($result ) {
                            //if not member then send invitation
                            if($result->isSubscribed == 0 and $result->hasApplied == 0 and $result->isInvited == 0) {
                                $pgr->isInvited = 1;
                                $pgr->ID_INVITEDBY = $admin->ID_PLAYER;
                                $pgr->update(array(
                                                'where' => 'ID_PLAYER = ? AND ID_GROUP = ?',
                                                'param' => array($pgr->ID_PLAYER, $pgr->ID_GROUP)
                                            ));
                            }
                        } else {
                            //if no record exists then insert initation record
                            $pgr->isInvited = 1;
                            $pgr->ID_INVITEDBY = $admin->ID_PLAYER;
                            $pgr->insert();
                        }

                    }
                }
                return true;
            }
        }
        return false;
    }

    /**
     * Accpet of invitation from group
     * @param SnGroups $group
     * @param Players $player - used when admin accepts user application to group
     * @return boolean
     */
    public function acceptInvitation(SnGroups $group, Players $player = null) {
        if($player == null) {
            $player = User::getUser();
        }

        if($player) {
            $pgr = $this->getPlayerGroupRel($group, $player);

            if($pgr) {
                $pgr->isInvited = 0;
                $pgr->hasApplied = 0;
                $pgr->isSubscribed = 1;
                $pgr->isMember = 1;
                $pgr->Comments = '';
                $pgr->update(array(
                                'where' => 'ID_PLAYER = ? AND ID_GROUP = ?',
                                'param' => array($pgr->ID_PLAYER, $pgr->ID_GROUP)
                ));
            }
            return true;
        }
        return false;
    }

    /**
     * Rejects invitation from group by deleting record
     * @param SnGroups $group
     * @param Players $player
     * @return boolean
     */
    public function rejectInvitation(SnGroups $group, Players $player = null) {
        if($player == null) {
            $player = User::getUser();
        }
        if($player) {
            $pgr = $this->getPlayerGroupRel($group, $player);
            $pgr->delete();
            return true;
        }
        return false;
    }

    /**
     * Player send request to join group
     * @param SnGroups $group
     * @param array $post
     * @return boolean
     */
    public function sendRequestToJoin(SnGroups $group, $post) {
        $player = User::getUser();
        if($player and !empty($post)) {
            $pgr = $this->getPlayerGroupRel($group, $player);

            //if is subscribed then just add has applied
            if($pgr) {
                $pgr->hasApplied = 1;
                $pgr->Comments = $post['group_apply_description'];
                $pgr->update(array(
                                'where' => 'ID_PLAYER = ? AND ID_GROUP = ?',
                                'param' => array($pgr->ID_PLAYER, $pgr->ID_GROUP)
                ));
            } else {
                $pgr = new SnPlayerGroupRel();
                $pgr->ID_PLAYER = $player->ID_PLAYER;
                $pgr->ID_GROUP = $group->ID_GROUP;
                $pgr->hasApplied = 1;
                $pgr->Comments = ContentHelper::handleContentInput($post['group_apply_description']);
                $pgr->insert();
            }
            return true;
        }
        return false;
    }

    /**
     * Upload single photo handler - can be added only by admin, do check in controller
     *
     * @return array
     */
    public function uploadPhoto($id) {
        $c = $this->getGroupByID($id);

        if ($c->isAdmin()) {
            $image = new Image();
            $result = $image->uploadImage(FOLDER_GROUPS, $c->ImageURL);
            if ($result['filename'] != '') {
                $c->ImageURL = ContentHelper::handleContentInput($result['filename']);
                $c->update(array('field' => 'ImageURL'));
                $c->purgeCache();
                $result['c'] = $c;
            }

            return $result;
        }
    }

    /**
     * Adds video - can be added only by admin, do check in controller
     * @param int $id
     * @param String $video - serialized
     * @return boolean
     */
    public function addVideo($id, $video) {
        $g = $this->getGroupByID($id);
        if ($g->isAdmin()) {
            $media = new SnMedia();
            $media->ID_OWNER = $g->ID_GROUP;
            $media->OwnerType = WALL_GROUPS;
            $media->MediaType = MEDIA_VIDEO;
            $media->MediaDesc = ContentHelper::handleContentInput($video);
            $media->MediaName = '';
            $media->insert();
            return true;
        }
        return false;
    }

    /**
     * Deletes media by id - deleted can be only by admin, do check in controller
     * @param int $id
     * @return boolean
     */
    public function deleteMedia($id) {
        if(intval($id) > 0) {
            $media = new SnMedia();
            $media->ID_MEDIA = $id;

            $media = $media->getOne();

            if($media->MediaType != MEDIA_VIDEO) {
                $image = new Image();
                $result = $image->deleteImage(FOLDER_GROUPS, $media->MediaDesc);
            }

            $media->delete();
            return true;
        }
        return false;
    }

    /**
     * Upload handler uses uploadify - can be added only by admin, do check in controller
     *
     * @return array
     */
    public function uploadMedias($id, $mediaID = 0, $type = MEDIA_VIDEO) {
        $c = $this->getGroupByID($id);
        $image = new Image();
        $result = $image->uploadImages(FOLDER_GROUPS);
        if ($result['filename'] != '') {
            $media = new SnMedia();
            $media->ID_OWNER = $c->ID_GROUP;
            $media->OwnerType = WALL_GROUPS;
            $media->MediaType = ContentHelper::handleContentInput($type);
            $media->MediaDesc = ContentHelper::handleContentInput($result['filename']);
            $media->MediaName = ContentHelper::handleContentInput($result['original_name']);
            $media->insert();

            $result['media'] = $media;
        }

        return $result;
    }

    /**
     * This is download tabs, can be added by group admin, do check in controller
     * @param type $ID_GROUP
     * @return SnFiletypes
     */
    public function getFiletypes($ID_GROUP) {
        if (intval($ID_GROUP) > 0) {
            $params = array();
            $params['asc'] = 'FiletypeName';
            $params['where'] = "OwnerType = ? AND ID_OWNER = ?";
            $params['param'] = array(WALL_GROUPS, $ID_GROUP);
            $tabs = Doo::db()->find('SnFiletypes', $params);
            return $tabs;
        }
        return array();
    }

    /**
     * Returns list of medias by group and media type
     * @param type $ID_GROUP
     * @param String $type
     * @return SnMedia
     */
    public function getMedias($ID_GROUP, $type) {
        if (intval($ID_GROUP) > 0) {
            $params = array();
            $params['desc'] = 'ID_MEDIA';
            $params['where'] = "OwnerType = ? AND ID_OWNER = ? AND MediaType = ?";
            $params['param'] = array(WALL_GROUPS, $ID_GROUP, $type);
            $medias = Doo::db()->find('SnMedia', $params);
            return $medias;
        }
        return array();
    }

    /**
     * Returns specific media record
     * @param type $ID_MEDIA
     * @return SnMedia
     */
    public function getMedia($ID_MEDIA) {
        if (intval($ID_MEDIA) > 0) {
            $media = new SnMedia();
            $media->ID_MEDIA = $ID_MEDIA;
            $media->purgeCache();
            $media = $media->getOne();
            return $media;
        }
        return array();
    }

    /**
     * Updates media info
     * @param array $post
     * @return boolean
     */
    public function saveMedia($post) {
        if (!empty($post)) {
            $media = new SnMedia();
            $media->ID_MEDIA = $post['media_id'];
            $media->MediaType = (ContentHelper::handleContentInput($post['tab']) === "concept-art") ? "Concept Art" : ContentHelper::handleContentInput($post['tab']);
            $media->MediaName = ContentHelper::handleContentInput($post['media_name']);
            $media->update();
            return true;
        }
        return false;
    }

    /**
     * Updates group info
     * @param SnGroups $group
     * @param type $post
     * @return boolean
     */
    public function updateGroupInfo(SnGroups $group, $post) {
        if (!empty($post)) {

            $group->GroupName = ContentHelper::handleContentInput($post['group_name']);
            $group->ID_GROUPTYPE1 = ContentHelper::handleContentInput($post['group_type1']);
            $group->ID_GROUPTYPE2 = ContentHelper::handleContentInput($post['group_type2']);
            $group->GroupDesc = ContentHelper::handleContentInput($post['group_description']);

            if(isset ($post['group_leader'])) {
                //remove all leaders
                $playerGroupRel = new SnPlayerGroupRel();
                $playerGroupRel->isLeader = 0;
                $playerGroupRel->update(array(
                                                'field' => 'isLeader',
                                                'where' => 'ID_GROUP = ?',
                                                'param' => array($group->ID_GROUP),
                                        ));

                //add selected leader
                $playerGroupRel = new SnPlayerGroupRel();
                $playerGroupRel->isLeader = 1;
                $playerGroupRel->update(array(
                                                'field' => 'isLeader',
                                                'where' => 'ID_PLAYER = ? AND ID_GROUP = ?',
                                                'param' => array(ContentHelper::handleContentInput($post['group_leader']), $group->ID_GROUP),
                                        ));
            }
            Url::createUpdateURL(ContentHelper::handleContentInput($post['group_name']), URL_GROUP, $group->ID_GROUP);
            $group->update();
            $this->updateCache($group);
            return true;
        }
        return false;
    }

    /**
     * Creation of new group
     * @param array $post
     * @return mixed group id or false
     */
    public function saveGroup($post) {
        $player = User::getUser();
        if (!empty($post) and $player) {
            $group = new SnGroups();
            $group->GroupName = ContentHelper::handleContentInput($post['group_name']);
            $group->ID_GROUPTYPE1 = ContentHelper::handleContentInput($post['group_type1']);
            $group->ID_GROUPTYPE2 = ContentHelper::handleContentInput($post['group_type2']);
            $group->GroupDesc = ContentHelper::handleContentInput($post['group_description']);
            $group->ID_CREATOR = $player->ID_PLAYER;
            $group->ID_GAME = ContentHelper::handleContentInput($post['group_game']);
            $groupID = $group->insert();
            $player->purgeCache();
            Url::createUpdateURL(ContentHelper::handleContentInput($post['group_name']), URL_GROUP, $groupID);

            return $groupID;
        }
        return false;
    }

    /**
     * Creates/updates group alliances
     * @param SnGroups $group
     * @param array $post
     * @return boolean
     */
    public function saveAlliance(SnGroups $group, $post) {
        if(isset($post['group_affiliate'])) {
            $alliance = new SnGroupAlliances();
            $alliance->ID_GROUP = $group->ID_GROUP;
            $alliance->ID_ALLIANCE = ContentHelper::handleContentInput($post['group_affiliate']);
            $alliance = $alliance->getOne();

            //both sides
            if($alliance) {
                $this->removeAlliance($group, $post['group_affiliate']);
            }

            $alliance = new SnGroupAlliances();
            $alliance->ID_GROUP = $group->ID_GROUP;
            $alliance->ID_ALLIANCE = ContentHelper::handleContentInput($post['group_affiliate']);
            $alliance->AllianceDesc = ContentHelper::handleContentInput($post['group_affiliate_description']);
            $alliance->insert();

            $alliance = new SnGroupAlliances();
            $alliance->ID_GROUP = ContentHelper::handleContentInput($post['group_affiliate']);
            $alliance->ID_ALLIANCE = $group->ID_GROUP;
            $alliance->AllianceDesc = ContentHelper::handleContentInput($post['group_affiliate_description']);
            $alliance->insert();

            $this->updateCacheAlliance($group->ID_GROUP, ContentHelper::handleContentInput($post['group_affiliate']));

            return true;
        }
        return false;
    }

    /**
     * Removes alliance between groups
     * @param SnGroups $group
     * @param int $allianceID
     * @return boolean
     */
    public function removeAlliance(SnGroups $group, $allianceID) {
        if(intval($allianceID) > 0) {
            $alliance = new SnGroupAlliances();
            $alliance->ID_GROUP = $group->ID_GROUP;
            $alliance->ID_ALLIANCE = $allianceID;
            $alliance->delete();

            $alliance = new SnGroupAlliances();
            $alliance->ID_GROUP = $allianceID;
            $alliance->ID_ALLIANCE = $group->ID_GROUP;
            $alliance->delete();

            $this->updateCacheAlliance($group->ID_GROUP, $allianceID);

            return true;
        }
        return false;
    }

    /**
     * Returns group list of alliances with added AllianceDesc field from SnGroupAlliances
     * @param SnGroups $group
     * @return SnGroups
     */
    public function getAlliances(SnGroups $group) {
        if (Doo::conf()->cache_enabled == TRUE) {
            $currentDBconf = Doo::db()->getDefaultDbConfig();
            $cacheKey = md5(CACHE_GROUP_ALLIANCE."_{$group->ID_GROUP}_".$currentDBconf[0]."_".$currentDBconf[1]);

            if (Doo::cache('apc')->get($cacheKey)) {
                return Doo::cache('apc')->get($cacheKey);
            }
        }

        $ga = new SnGroupAlliances();
        $params = array();
        $params['select'] = "{$group->_table}.*, {$ga->_table}.AllianceDesc";
        $params['filters'][] = array(
                                    'joinType' => 'INNER',
                                    'model' => 'SnGroupAlliances',
                                    'where' => "{$ga->_table}.ID_ALLIANCE = ?",
                                    'param' => array($group->ID_GROUP)
                                    );

        $groups = Doo::db()->find('SnGroups', $params);

        if (Doo::conf()->cache_enabled == TRUE) {
            Doo::cache('apc')->set($cacheKey, $groups, Doo::conf()->GROUP_ALLIANCE_LIFETIME);
        }

        return $groups;
    }

    /**
     * Returns specific group alliance
     * @param SnGroups $group
     * @param int $allianceID
     * @return SnGroups
     */
    public function getAlliance(SnGroups $group, $allianceID) {
        $ga = new SnGroupAlliances();
        $params = array();
        $params['select'] = "{$group->_table}.*, {$ga->_table}.AllianceDesc, {$ga->_table}.ID_ALLIANCE";
        $params['limit'] = 1;
        $params['filters'][] = array(
                                    'joinType' => 'INNER',
                                    'model' => 'SnGroupAlliances',
                                    'where' => "{$ga->_table}.ID_ALLIANCE = ? AND {$ga->_table}.ID_GROUP = ?",
                                    'param' => array($allianceID, $group->ID_GROUP, )
                                    );

        $groups = Doo::db()->find('SnGroups', $params);
        return $groups;
    }

    /**
     * Returns group types
     * @return SnGroupTypes
     */
    public function getTypes() {
        $params = array();
        $params['asc'] = 'ID_GROUPTYPE';
        $types = Doo::db()->find('SnGroupTypes', $params);
        return $types;
    }

    /**
     * Deletes group, can be done only by creator
     * @param SnGroups $group
     * @return boolean
     */
    public function deleteGroup(SnGroups $group) {
        if (!empty($group)) {
            if($group->isCreator() === TRUE) {
                //remove physical cache file
                Cache::delete(CACHE_GROUP.$group->ID_GROUP);
                Url::deleteURL(URL_GROUP, $group->ID_GROUP);

                $group->delete();
                return true;
            }
        }
        return false;
    }

    /**
     * Leaves group that player is member of
     * @param SnGroups $group
     * @return boolean
     */
    public function leaveGroup(SnGroups $group) {
        return $group->leave();
    }

    public function getPlayerGroupRel(SnGroups $group, Players $player = null) {
        if($player == null) {
            $player = User::getUser();
        }

        if($player) {
            $pgr = new SnPlayerGroupRel();
            $pgr->ID_PLAYER = $player->ID_PLAYER;
            $pgr->ID_GROUP = $group->ID_GROUP;
            $result = $pgr->getOne();

            return $result;
        }
    }

    /**
     * Toggles between isOfficer and isMember
     * @param SnGroups $group
     * @param Players $player
     */
    public function toggleMemberRank(SnGroups $group, Players $player) {
        $rel = $this->getPlayerGroupRel($group, $player);

        if($rel->isOfficer == 1) {
            $rel->isOfficer = 0;
        } else {
            $rel->isOfficer = 1;
        }
        $rel->update(array(
            'where' => 'ID_PLAYER = ? AND ID_GROUP = ?',
            'param' => array($rel->ID_PLAYER, $rel->ID_GROUP)
        ));
        return TRUE;
    }

    public function updateCache(SnGroups $group) {
        Cache::increase(CACHE_GROUP.$group->ID_GROUP);
    }

    public function updateCacheAlliance($groupID, $allianceID) {
        //clear cache both ways
        $currentDBconf = Doo::db()->getDefaultDbConfig();
        $cacheKey = md5(CACHE_GROUP_ALLIANCE."_{$groupID}_".$currentDBconf[0]."_".$currentDBconf[1]);
        Doo::cache('apc')->flush($cacheKey);

        $cacheKey = md5(CACHE_GROUP_ALLIANCE."_{$allianceID}_".$currentDBconf[0]."_".$currentDBconf[1]);
        Doo::cache('apc')->flush($cacheKey);
    }

	public function searchGroups($q){
		$g = new SnGroups();
		$pgr = new SnPlayerGroupRel();

		$p = User::getUser();
		if($p){
			$params['where'] = "GroupName LIKE ? AND {$g->_table}.ID_GROUP
			NOT IN (SELECT {$pgr->_table}.ID_GROUP FROM {$pgr->_table} WHERE {$pgr->_table}.ID_PLAYER = ?)";
			$params['param'] = array('%'.ContentHelper::handleContentInput($q).'%', $p->ID_PLAYER);

			return Doo::db()->find('SnGroups', $params);
		}
		return array();
	}

	public function saveDownloadTab(SnGroups $group, $post) {
		if (!empty($post)) {
			$tab = new SnFiletypes();
			$tab->FiletypeName = ContentHelper::handleContentInput($post['tab_name']);
			if(isset($post['tab_desc'])) $tab->FiletypeDesc = ContentHelper::handleContentInput($post['tab_desc']);

			if (isset($post['tab_id']) && !empty($post['tab_id'])) {
				$tab->ID_FILETYPE = $post['tab_id'];
				$tab->update();
			} else {
				$tab->ID_OWNER = $group->ID_GROUP;
				$tab->OwnerType = WALL_GROUPS;
				$tab->insert();
			}

			return true;
		}
		return false;
	}

	/**
	 * Deletes download tab by ID
	 * @param int $tabID
	 * @return boolean
	 */
	public function deleteDownloadTab($tabID) {
		if (intval($tabID) > 0) {
			$tab = new SnFiletypes();
			$tab->ID_FILETYPE = $tabID;
			$tab->delete();
			return true;
		}
		return false;
	}

    public function saveDownload(SnGroups $group, $post) {
        if (!empty($post)) {
			$down = new SnDownloads();
			$down->DownloadName = ContentHelper::handleContentInput($post['download_filename']);
			$down->DownloadDesc = ContentHelper::handleContentInput($post['download_description']);
			$down->FileSize = ContentHelper::handleContentInput($post['download_filesize']);
			$down->URL = ContentHelper::handleContentInput($post['download_fileurl']);
			$down->ID_FILETYPE = $post['tab_id'];

			if (isset($post['download_id']) && !empty($post['download_id'])) {
				$down->ID_DOWNLOAD = $post['download_id'];
				$down->update();
			} else {
				$down->insert();
			}

			return true;
		}
		return false;
	}
    
	public function deleteDownload($downloadID) {
		if (intval($downloadID) > 0) {
			$down = new SnDownloads();
			$down->ID_DOWNLOAD = $downloadID;
			$down->delete();
			return true;
		}
		return false;
	}

}